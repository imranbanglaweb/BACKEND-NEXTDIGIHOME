<?php

namespace App\Traits;

use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Log;

/**
 * DepartmentHeadHelper Trait
 * 
 * Provides helper methods to work with department heads throughout the application.
 * Use this trait in controllers, services, or any class that needs to interact with department heads.
 */
trait DepartmentHeadHelper
{
    /**
     * Get department head information for a given department
     *
     * @param int $departmentId
     * @return array|null
     */
    public function getDepartmentHeadInfo(int $departmentId): ?array
    {
        $department = Department::find($departmentId);
        
        if (!$department) {
            Log::warning('DepartmentHeadHelper: Department not found', ['department_id' => $departmentId]);
            return null;
        }
        
        // Get head employee if exists
        $headEmployee = $department->headEmployee;
        
        if ($headEmployee) {
            return [
                'type' => 'employee',
                'id' => $headEmployee->id,
                'name' => $headEmployee->name,
                'email' => $headEmployee->email,
                'phone' => $headEmployee->phone ?? null,
            ];
        }
        
        // Fallback to stored head info
        if (!empty($department->head_email)) {
            return [
                'type' => 'manual',
                'id' => null,
                'name' => $department->head_name,
                'email' => $department->head_email,
                'phone' => null,
            ];
        }
        
        // Last resort: Find user with department_head user_type
        $headUser = User::where('department_id', $departmentId)
            ->where('user_type', 'department_head')
            ->first();
            
        if ($headUser) {
            return [
                'type' => 'user',
                'id' => $headUser->id,
                'name' => $headUser->name,
                'email' => $headUser->email,
                'phone' => $headUser->cell_phone ?? null,
            ];
        }
        
        Log::warning('DepartmentHeadHelper: No department head found', ['department_id' => $departmentId]);
        return null;
    }
    
    /**
     * Get department head email(s) for a given department
     *
     * @param int $departmentId
     * @return array
     */
    public function getDepartmentHeadEmails(int $departmentId): array
    {
        $emails = [];
        
        $department = Department::find($departmentId);
        
        if ($department) {
            $headEmail = $department->head_email;
            if (!empty($headEmail)) {
                $emails[] = $headEmail;
            }
        }
        
        // Fallback: Find users with department_head user_type
        $headUsers = User::where('department_id', $departmentId)
            ->where('user_type', 'department_head')
            ->where('email', '!=', '')
            ->pluck('email')
            ->toArray();
            
        $emails = array_merge($emails, $headUsers);
        
        return array_filter(array_unique($emails));
    }
    
    /**
     * Check if a user is the head of their department
     *
     * @param int $userId
     * @return bool
     */
    public function isDepartmentHead(int $userId): bool
    {
        $user = User::find($userId);
        
        if (!$user) {
            return false;
        }
        
        // Check if user has department_head user_type
        if ($user->user_type === 'department_head') {
            return true;
        }
        
        // Check if user is assigned as head_employee in their department
        if ($user->employee && $user->employee->department_id) {
            $department = Department::find($user->employee->department_id);
            if ($department && $department->head_employee_id === $user->employee->id) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Get all departments that a user is head of
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getDepartmentsHeadedByUser(int $userId)
    {
        $user = User::find($userId);
        
        if (!$user) {
            return collect([]);
        }
        
        // Find by employee relationship
        if ($user->employee) {
            return Department::where('head_employee_id', $user->employee->id)->get();
        }
        
        // Find by user department_id and user_type
        return Department::where('head_employee_id', null)
            ->whereHas('headEmployee', function($query) use ($user) {
                $query->where('email', $user->email);
            })
            ->get();
    }
    
    /**
     * Set department head for a department
     *
     * @param int $departmentId
     * @param int|null $headEmployeeId
     * @param string|null $manualEmail
     * @param string|null $manualName
     * @return bool
     */
    public function setDepartmentHead(
        int $departmentId, 
        ?int $headEmployeeId = null, 
        ?string $manualEmail = null, 
        ?string $manualName = null
    ): bool
    {
        $department = Department::find($departmentId);
        
        if (!$department) {
            return false;
        }
        
        $updateData = [
            'head_employee_id' => $headEmployeeId,
            'head_email' => $manualEmail,
            'head_name' => $manualName,
        ];
        
        // If employee is selected, auto-fill email and name from employee record
        if ($headEmployeeId) {
            $employee = \App\Models\Employee::find($headEmployeeId);
            if ($employee) {
                $updateData['head_email'] = $employee->email;
                $updateData['head_name'] = $employee->name;
            }
        }
        
        $department->update($updateData);
        
        Log::info('DepartmentHeadHelper: Department head updated', [
            'department_id' => $departmentId,
            'head_employee_id' => $headEmployeeId,
            'head_email' => $updateData['head_email'],
        ]);
        
        return true;
    }
}
