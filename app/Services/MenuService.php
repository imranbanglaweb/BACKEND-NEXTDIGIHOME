<?php

namespace App\Services;

use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Models\Permission;

class MenuService
{
    /**
     * Get sidebar menus cached per role
     */
    public static function sidebar()
    {
        $user = Auth::user();

        // If no user is authenticated, return empty collection
        if (! $user) {
            return collect();
        }

        // Check if user is Super Admin
        $isSuperAdmin = $user->hasRole('Super Admin');
        $isAdmin = $user->hasRole('Admin');
        $isManager = $user->hasRole('Department Head') || $user->hasRole('Manager');
        $isTransport = $user->hasRole('Transport');
        $isEmployee = $user->hasRole('Employee');
        $isDriver = $user->hasRole('Driver');

        // Fallback to 'role' column if no Spatie role is assigned
        if (! $isAdmin && ! $isManager && ! $isTransport && ! $isEmployee && ! $isDriver) {
            $userRole = $user->role ?? 'employee';
            $isAdmin = ($userRole === 'admin');
            $isManager = ($userRole === 'manager');
            $isTransport = ($userRole === 'transport');
            $isEmployee = ($userRole === 'employee');
            $isDriver = ($userRole === 'driver');
        }

        // Load all parent menus ordered by menu_order
        $menus = Menu::where('menu_parent', 0)
            ->orderBy('menu_order', 'ASC')
            ->get();

        $filtered = $menus->map(function ($menu) use ($user, $isSuperAdmin, $isAdmin, $isManager, $isTransport, $isDriver, $isEmployee) {

            // Load children
            $children = Menu::where('menu_parent', $menu->id)
                ->orderBy('menu_order')
                ->get()
                ->filter(function ($child) use ($user, $isSuperAdmin, $isAdmin, $isManager, $isTransport, $isDriver, $isEmployee) {
                    // Super Admin and Admin see everything, others need permission
                    // Exclude employee-specific menus to avoid duplicates
                    if ($isSuperAdmin || $isAdmin) {
                        $employeeOnlyMenus = [
                            'driver-list-view',
                            'vehicle-list-view',
                            'employee-view-own',
                            'employee-edit-own',
                            'report-requisition-own',
                            'report-maintenance-own',
                        ];
                        if ($child->menu_permission && in_array($child->menu_permission, $employeeOnlyMenus)) {
                            return false;
                        }

                        return true;
                    }

                    // For Driver role - show only driver-specific menus
                    if ($isDriver) {
                        $driverAllowedMenus = [
                            'driver-access',
                            'driver-schedule-view',
                            'driver-schedule-own',
                            'driver-availability-view',
                            'driver-availability-update',
                            'trip-sheet-view',
                            'trip-sheet-own',
                            'trip-start',
                            'trip-finish',
                            'trip-end',
                            'trip-fuel-log',
                            'trip-fuel-own',
                            'driver-document-view',
                            'driver-vehicle',
                            'notification-view',
                            'profile-view',
                            'profile-edit',
                            'employee-view-own',
                            'employee-edit-own',
                            'menu-dashboard',
                            'my-profile',
                        ];

                        // Exclude vehicle requisition and maintenance requisition for drivers
                        $driverExcludedMenus = [
                            'vehicle-requisition',
                            'maintenance-requisition',
                            'vehicle-requisition-create',
                            'maintenance-requisition-create',
                            'vehicle-requisition-list',
                            'maintenance-requisition-list',
                            'vehicle-requisition-approval',
                            'maintenance-requisition-approval',
                            'requisition-create',
                            'requisition-manage',
                            'vehicle-manage',
                            'vehicle-create',
                            'vehicle-edit',
                            'vehicle-delete',
                            'driver-manage',
                            'driver-create',
                            'driver-edit',
                            'driver-delete',
                            'settings',
                        ];

                        // Check if menu is in excluded list
                        if ($child->menu_permission && in_array($child->menu_permission, $driverExcludedMenus)) {
                            return false;
                        }

                        // Check if menu requires driver permission
                        if ($child->menu_permission && in_array($child->menu_permission, $driverAllowedMenus)) {
                            return self::userHasPermission($user, $child->menu_permission);
                        }

                        // For menus without permission requirement, hide for drivers (they shouldn't see generic menus)
                        return false;
                    }

                    // For Department Head, include department-specific menus
                    if ($isManager) {
                        $deptHeadMenus = [
                            'employee-list-department',
                            'employee-create-department',
                            'employee-edit-department',
                            'employee-delete-department',
                            'vehicle-list-department',
                            'driver-list-department',
                            'requisition-approval-department',
                            'maintenance-approval-department',
                            'report-requisition-department',
                            'report-maintenance-department',
                            'department-approval-view',
                            'department-approval-approve',
                            'department-approval-reject',
                            'maintenance-approval-view',
                            // Department Head specific approval menus only
                            'pending-requisitions',
                            'approved-requisitions',
                            'rejected-requisitions',
                            'my-pending-approvals',
                        ];

                        // Exclude transport and maintenance manager menus for Dept Head
                        $excludeForDeptHeadChild = [
                            'transport-approvals',
                            'maintenance-approvals',
                            'maintenance-transport',
                            'maintenance-pending',
                            'maintenance-approved-list',
                        ];

                        // Check if menu is excluded for department head
                        if ($child->menu_slug && in_array($child->menu_slug, $excludeForDeptHeadChild)) {
                            return false;
                        }

                        // Allow department head specific menus
                        if ($child->menu_permission && in_array($child->menu_permission, $deptHeadMenus)) {
                            // Check if permission exists before checking access
                            return self::userHasPermission($user, $child->menu_permission);
                        }

                        // Exclude admin-only menus for department heads
                        $adminOnlyMenus = [
                            'employee-create',
                            'employee-delete',
                            'vehicle-create',
                            'vehicle-delete',
                            'driver-create',
                            'driver-delete',
                            'settings',
                        ];
                        if ($child->menu_permission && in_array($child->menu_permission, $adminOnlyMenus)) {
                            return false;
                        }
                    }

                    // For Employee role - show only employee-specific menus
                    if ($isEmployee) {
                        $employeeAllowedChildMenus = [
                            'requisition-create',
                            'requisition-view',
                            'requisition-edit',
                            'requisition-pending-view',
                            'requisition-approved-view',
                            'my-requisitions',
                            'driver-list-view',
                            'vehicle-list-view',
                            'maintenance-create',
                            'maintenance-view',
                            'report-requisition-own',
                            'report-maintenance-own',
                            'employee-view-own',
                            'employee-edit-own',
                            'document-manage',
                            'document-create',
                            'document-view',
                            'document-history',
                            'document-export',
                            'my-documents',
                            'notification-view',
                            'support-create',
                            'support-edit',
                            'support-view',
                            'profile-view',
                            'profile-edit',
                            'trip-sheet-view',
                            'gps-tracking-view',
                        ];

                        if ($child->menu_permission && in_array($child->menu_permission, $employeeAllowedChildMenus)) {
                            return self::userHasPermission($user, $child->menu_permission);
                        }

                        // Show menus without specific permission requirements
                        return ! $child->menu_permission;
                    }

                    // For Transport role - show transport-specific menus
                    if ($isTransport) {
                        $transportAllowedChildMenus = [
                            'transport-approval-view',
                            'transport-approval-assign',
                            'transport-approval-approve',
                            'transport-approval-reject',
                            'trip-manage',
                            'trip-sheet-view',
                            'trip-sheet-own',
                            'trip-create',
                            'trip-start',
                            'trip-finish',
                            'trip-end',
                            'trip-export',
                            'driver-manage',
                            'driver-view',
                            'driver-create',
                            'driver-edit',
                            'driver-schedule-manage',
                            'driver-schedule-view',
                            'driver-schedule-assign',
                            'driver-availability-manage',
                            'driver-availability-view',
                            'driver-availability-update',
                            'vehicle-manage',
                            'vehicle-view',
                            'vehicle-create',
                            'vehicle-edit',
                            'maintenance-manage',
                            'maintenance-view',
                            'maintenance-create',
                            'maintenance-edit',
                            'report-trip-fuel',
                            'report-vehicle-utilization',
                            'settings',
                            'settings-manage',
                            'settings-notification',
                            'settings-language',
                            'profile-view',
                            'profile-edit',
                            'notification-view',
                            'my-subscription',
                        ];

                        if ($child->menu_permission && in_array($child->menu_permission, $transportAllowedChildMenus)) {
                            // Allow settings menus for transport without strict permission check
                            if (in_array($child->menu_permission, ['settings', 'settings-manage', 'settings-notification', 'settings-language'])) {
                                return true;
                            }

                            return self::userHasPermission($user, $child->menu_permission);
                        }

                        // Show menus without specific permission requirements
                        return ! $child->menu_permission;
                    }

                    return ! $child->menu_permission || (self::userHasPermission($user, $child->menu_permission));
                })
                ->values();

            // Check parent permission - show if:
            // 1. Super Admin, OR
            // 2. Has visible children, OR
            // 3. No permission required, OR
            // 4. User has permission
            if ($isSuperAdmin || $isAdmin) {
                // Hide My Profile menu for all authenticated users
                $menu->visible = $menu->menu_slug !== 'my-profile';
            } elseif ($isManager) {
                // For Department Head, show relevant parent menus
                $deptHeadParentMenus = [
                    'approvals',
                    'my-approvals',
                    'my-team',
                    'my-vehicles',
                    'my-drivers',
                    'requisitions',
                    'maintenance',
                    'reports',
                ];

                // Hide these generic menus for Department Head
                $excludeForDeptHead = [
                    'settings',
                    'employee-management',
                    'vehicles',
                    'public-pages',
                    'menu-management',
                ];

                // Show parent if it has visible children or is in allowed list
                $hasVisibleChildren = $children->isNotEmpty();
                $isExcluded = $menu->menu_slug && in_array($menu->menu_slug, $excludeForDeptHead);
                $isAllowedParent = $menu->menu_slug && in_array($menu->menu_slug, $deptHeadParentMenus);
                $hasPermission = ! $menu->menu_permission || (Permission::where('name', $menu->menu_permission)->exists() && $user->can($menu->menu_permission));

                // For dept head, hide excluded menus, otherwise show if allowed or has permission
                if ($isExcluded) {
                    $menu->visible = false;
                } elseif ($isAllowedParent) {
                    $menu->visible = true;
                } elseif ($hasPermission) {
                    $menu->visible = true;
                } else {
                    $menu->visible = false;
                }
            } elseif ($isDriver) {
                // For Driver role - only show driver-specific parent menus
                $driverAllowedParentMenus = [
                    'menu.dashboard',
                    'driver-portal',
                ];

                // Exclude vehicle requisition and maintenance requisition parent menus for drivers
                $driverExcludedParentMenus = [
                    'vehicle-requisition',
                    'maintenance-requisition',
                    'requisitions',
                    'vehicles',
                    'maintenance',
                    'settings',
                ];

                $hasVisibleChildren = $children->isNotEmpty();
                $isExcludedParent = $menu->menu_slug && in_array($menu->menu_slug, $driverExcludedParentMenus);
                $isAllowedParent = $menu->menu_slug && in_array($menu->menu_slug, $driverAllowedParentMenus);

                // For drivers: show if allowed parent OR (has visible children AND not excluded)
                $menu->visible = $isAllowedParent || ($hasVisibleChildren && ! $isExcludedParent);
            } elseif ($isTransport) {
                // For Transport role - show transport-specific parent menus
                $transportAllowedParentMenus = [
                    'menu.dashboard',
                    'approvals',
                    'trip-sheets',
                    'vehicles',
                    'driver-management',
                    'reports',
                    'menu.settings',
                ];

                $hasVisibleChildren = $children->isNotEmpty();
                $isAllowedParent = $menu->menu_slug && in_array($menu->menu_slug, $transportAllowedParentMenus);
                $hasPermission = ! $menu->menu_permission || (Permission::where('name', $menu->menu_permission)->exists() && $user->can($menu->menu_permission));

                // Hide My Profile and Maintenance menus for Transport role
                if (in_array($menu->menu_slug, ['my-profile', 'maintenance'])) {
                    $menu->visible = false;
                } else {
                    $menu->visible = $isAllowedParent || ($hasVisibleChildren && $hasPermission);
                }
            } else {
                // For Employee role - show allowed parent menus
                if ($isEmployee) {
                    $employeeAllowedParentMenus = [
                        'menu.dashboard',
                        'vehicle-requisition',
                        'maintenance',
                        'trip-sheets',
                        'vehicle-management',
                        'driver-management',
                        'fuel-management',
                        'reports',
                        'employee-management',
                    ];

                    // Explicitly hide My Profile menu for employees
                    if ($menu->menu_slug === 'my-profile') {
                        $menu->visible = false;
                    } else {
                        $hasPermission = ! $menu->menu_permission || (Permission::where('name', $menu->menu_permission)->exists() && $user->can($menu->menu_permission));
                        $isAllowedParent = $menu->menu_slug && in_array($menu->menu_slug, $employeeAllowedParentMenus);
                        $menu->visible = ($isAllowedParent && $children->isNotEmpty()) || $hasPermission;
                    }
                } elseif ($isTransport) {
                    // For Transport role - show allowed parent menus
                    $transportAllowedParentMenus = [
                        'menu-dashboard',
                        'approvals',
                        'trip-sheets',
                        'vehicles',
                        'driver-management',
                        'maintenance',
                        'reports',
                        'settings',
                    ];

                    $hasPermission = ! $menu->menu_permission || (Permission::where('name', $menu->menu_permission)->exists() && $user->can($menu->menu_permission));
                    $isAllowedParent = $menu->menu_slug && in_array($menu->menu_slug, $transportAllowedParentMenus);

                    $menu->visible = $isAllowedParent || ($children->isNotEmpty() && $hasPermission);
                } else {
                    $hasPermission = ! $menu->menu_permission || (Permission::where('name', $menu->menu_permission)->exists() && $user->can($menu->menu_permission));
                    $menu->visible = $children->isNotEmpty() || $hasPermission;
                }
            }

            $menu->children = $children;

            return $menu;
        })
            ->filter(fn ($menu) => $menu->visible)
            ->values();

        // Add dynamic department-specific menus for Department Head
        if ($isManager) {
            // Menus for department head are now loaded from database via MenuSeeder
            // Dynamic menus removed to avoid conflicts
        }

        // Clear menu cache after getting menus to ensure fresh data
        // Note: Cache is cleared when roles/permissions change, not on every request

        return $filtered;
    }

    /**
     * Clear menu cache (call after role/menu change)
     */
    public static function clear()
    {
        Cache::flush();
    }

    /**
     * Check if user has permission safely
     */
    private static function userHasPermission($user, $permission)
    {
        try {
            // First check if permission exists in database
            if (! Permission::where('name', $permission)->exists()) {
                return false;
            }

            // Then check if user has the permission
            return $user->can($permission);
        } catch (PermissionDoesNotExist $e) {
            return false;
        }
    }
}
