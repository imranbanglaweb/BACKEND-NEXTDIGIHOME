<?php

/*
|==========================================================================
| VMS - Vehicle Management System Routes
|==========================================================================
*/

use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PageContentController;
use App\Http\Controllers\Admin\HeroSliderController;
use App\Http\Controllers\Admin\TestimonialsController;
use App\Http\Controllers\Admin\TeamMembersController;
use App\Http\Controllers\Admin\ContactInfoController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\SystemController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;

// Vehicle & Transport
use App\Http\Controllers\AIMaintenanceAlertController;
use App\Http\Controllers\AIReportController;
// use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DepartmentApprovalController;
// Requisitions & Approvals
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DepartmentEmployeeController;
use App\Http\Controllers\DepartmentHeadController;
use App\Http\Controllers\DriverController;
// Maintenance
// use App\Http\Controllers\EmailLogController;
// use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\GpsTrackingController;
use App\Http\Controllers\HomeController;
// Reports
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LicneseTypeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MaintenanceApprovalController;
use App\Http\Controllers\MaintenanceCategoryController;
// AI Features
use App\Http\Controllers\MaintenanceRequisitionController;
use App\Http\Controllers\MaintenanceTransportApprovalController;
// Admin & Settings
use App\Http\Controllers\MaintenanceTypeController;
use App\Http\Controllers\MaintenanceVendorController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Payment\ManualPaymentController;
// Subscriptions & Payments
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PushSubscriptionController;
use App\Http\Controllers\Reports\DriverPerformanceReportController;
use App\Http\Controllers\Reports\MaintenanceReportController;
use App\Http\Controllers\Reports\RequisitionReportController;
// Organization Structure
use App\Http\Controllers\Reports\TripFuelReportController;
use App\Http\Controllers\RequisitionApprovalController;
use App\Http\Controllers\RequisitionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
// use App\Http\Controllers\TestEmailController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\TransportApprovalController;
use App\Http\Controllers\TripSheetController;
// Other Controllers
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ============================================================================
// EMAIL LOGS ROUTES - DISABLED (Controller missing)
// ============================================================================
// Route::middleware(['auth'])->group(function () {
//     Route::post('emaillogs/{id}/resend', [EmailLogController::class, 'resend'])->name('emaillogs.resend');
//     Route::resource('emaillogs', EmailLogController::class);
// });

// ============================================================================
// EMAIL TEMPLATES ROUTES - DISABLED (Controllers missing)
// ============================================================================
// Route::middleware(['auth'])->group(function () {
//     Route::resource('email-templates', EmailTemplateController::class);
//     Route::post('email-templates/toggle-status', [EmailTemplateController::class, 'toggleStatus'])->name('email-templates.toggle-status');
//     Route::post('email-templates/{id}/restore', [EmailTemplateController::class, 'restore'])->name('email-templates.restore');
//     Route::get('email-templates/{id}/preview', [EmailTemplateController::class, 'preview'])->name('email-templates.preview');

//     // Test Email Routes
//     Route::get('email/test', [TestEmailController::class, 'index'])->name('admin.email.test');
//     Route::post('email/test/preview', [TestEmailController::class, 'preview'])->name('admin.email.test.preview');
//     Route::post('email/test/send', [TestEmailController::class, 'send'])->name('admin.email.test.send');
// });

// ============================================================================
// 1. AUTHENTICATION ROUTES
// ============================================================================

Auth::routes();

// Demo Login Routes
Route::post('/demo-login', [App\Http\Controllers\Auth\LoginController::class, 'demoLogin'])->name('demo.login');

// ============================================================================
// 2. DASHBOARD & HOME
// ============================================================================

// Route for service worker (must be accessible without auth)
Route::get('/service-worker.js', function () {
    $path = public_path('service-worker.js');

    return response()->file($path, [
        'Content-Type' => 'application/javascript',
    ]);
});

// Web Push Subscription Route (uses existing controller)
Route::middleware('web')->post('/api/push/subscribe', [PushSubscriptionController::class, 'store']);

// Root route must be public (outside auth) so unauthenticated users can access it
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    // Home route - show backend dashboard for authenticated users
    Route::get('/home', [HomeController::class, 'index'])->name('home');



    // Admin dashboard
    Route::get('/admin/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');

    // AJAX endpoints for dashboard
    Route::get('/admin/dashboard/data', [HomeController::class, 'data'])->name('admin.dashboard.data');
    Route::get('/dashboard/recent-documents', [HomeController::class, 'getRecentDocuments'])->name('dashboard.recent-documents');
    Route::get('/dashboard/pending-approvals', [HomeController::class, 'getPendingApprovals'])->name('dashboard.pending-approvals');
});

// ============================================================================

// 3A. GPS TRACKING (Mobile GPS + Live Tracking)
// ============================================================================

Route::middleware(['auth'])->group(function () {
    // GPS Tracking pages
    Route::get('/gps-tracking', [GpsTrackingController::class, 'index'])->name('admin.gps-tracking.index');

    Route::get('/gps-tracking/trip/{tripId}', [GpsTrackingController::class, 'showTrip'])->name('admin.gps-tracking.trip');

    // GPS Device Management routes DISABLED
    // (GpsDeviceController class is missing — uncomment after implementing the controller)

});

// ============================================================================
// 4. DRIVER MANAGEMENT
// ============================================================================

Route::middleware(['prevent-back-history'])->group(function () {
    // DataTable AJAX endpoint
    Route::get('drivers/data', [DriverController::class, 'data'])->name('drivers.data');
    Route::get('drivers/list', [DriverController::class, 'list'])->name('drivers.list');

    // CRUD operations
    Route::resource('drivers', DriverController::class);

    // AJAX helpers
    Route::get('/get-departments-by-unit', [DriverController::class, 'getDepartmentsByUnit'])->name('getDepartmentsByUnit');
    Route::get('/get-employee-info', [DriverController::class, 'getEmployeeInfo'])->name('getEmployeeInfo');
});

// ============================================================================
// 5. VENDOR MANAGEMENT
// ============================================================================

Route::middleware(['auth'])->group(function () {
    Route::resource('vendors', VendorController::class);
});

// ============================================================================
// 6. REQUISITIONS & APPROVALS
// ============================================================================

Route::middleware(['prevent-back-history'])->group(function () {

    // AJAX endpoints
    Route::get('/requisitions-search', [RequisitionController::class, 'index'])->name('requisitions.search');
    Route::post('/requisitions/validate', [RequisitionController::class, 'validateAjax'])->name('requisitions.validate');
    Route::get('/get-employee-details/{id}', [EmployeeController::class, 'getEmployeeDetails'])->name('employee.details');

    // ============================================================================
    // DRIVER PORTAL ROUTES
    // ============================================================================

    Route::middleware(['auth'])->prefix('driver')->name('driver.')->group(function () {
        // Driver Dashboard
        Route::get('/dashboard', [DriverController::class, 'driverDashboard'])->name('dashboard');

        // My Schedule
        Route::get('/schedule', [DriverController::class, 'driverSchedule'])->name('schedule');

        // My Trips
        Route::get('/trips', [DriverController::class, 'driverTrips'])->name('trips');

        // Trip Status Update
        Route::get('/trip-status', [DriverController::class, 'driverTripStatus'])->name('trip.status');
        Route::get('/trip-status/{id}', [DriverController::class, 'driverTripStatus'])->name('trip.status.view');
        Route::post('/trip/{id}/start', [DriverController::class, 'startTrip'])->name('trip.start');
        Route::post('/trip/{id}/finish', [DriverController::class, 'finishTrip'])->name('trip.finish');
        Route::post('/trip/{id}/end', [DriverController::class, 'endTrip'])->name('trip.end');
        Route::patch('/trip/{id}/complete', [DriverController::class, 'endTrip'])->name('trip.complete');

        // Live Tracking
        Route::get('/live-tracking', [DriverController::class, 'driverLiveTracking'])->name('live.tracking');

        // Fuel Log (Driver)
        Route::get('/fuel-log', [DriverController::class, 'driverFuelLog'])->name('fuel.log');
        Route::post('/fuel-log/store', [DriverController::class, 'storeFuelLog'])->name('fuel.store');

        // Fuel History (Admin)
        Route::get('/fuel-history', [DriverController::class, 'fuelHistory'])->name('fuel.history');

        // Fuel Purchase Log (Admin)
        Route::get('/fuel-purchase-log', [DriverController::class, 'fuelPurchaseLog'])->name('fuel.purchase.log');

        // Monthly Fuel Summary (Admin)
        Route::get('/fuel-monthly-summary', [DriverController::class, 'fuelMonthlySummary'])->name('fuel.monthly.summary');

        // Vehicle Fuel Efficiency (Admin)
        Route::get('/fuel-efficiency', [DriverController::class, 'fuelEfficiency'])->name('fuel.efficiency');

        // Availability
        Route::get('/availability', [DriverController::class, 'driverAvailability'])->name('availability');
        Route::post('/availability/update', [DriverController::class, 'updateAvailability'])->name('availability.update');

        // My Vehicle

    });

    Route::resource('requisitions', RequisitionController::class);

    // Status & Workflow
    Route::post('/requisitions/update-status/{id}', [RequisitionController::class, 'updateStatus'])->name('requisitions.updateStatus');
    Route::post('{id}/workflow/update', [RequisitionController::class, 'updateWorkflow'])->name('requisitions.workflow.update');

    // Transport Approval
    Route::post('/requisitions/transport-approve/{id}', [RequisitionApprovalController::class, 'transportApprove'])->name('requisitions.transport.approve');
    Route::post('/requisitions/transport-reject/{id}', [RequisitionApprovalController::class, 'transportReject'])->name('requisitions.transport.reject');

    // Admin Final Approval
    Route::post('/requisitions/admin-approve/{id}', [RequisitionApprovalController::class, 'adminApprove'])->name('requisitions.admin.approve');
    Route::post('/requisitions/admin-reject/{id}', [RequisitionApprovalController::class, 'adminReject'])->name('requisitions.admin.reject');

    // Role-based requisition access
    Route::group(['middleware' => 'role:employee,transport,admin'], function () {});
});

// ============================================================================
// 7. DEPARTMENT APPROVAL WORKFLOW
// ============================================================================

Route::prefix('department')->group(function () {
    // AJAX endpoint
    Route::get('/approvals/ajax', [DepartmentApprovalController::class, 'ajax'])->name('department.approvals.ajax');

    // Department Head Approvals
    Route::get('/approvals', [DepartmentApprovalController::class, 'index'])->defaults('type', 'pending')->name('department.approvals.index');
    Route::get('/approvals/approved', [DepartmentApprovalController::class, 'index'])->defaults('type', 'approved')->name('department.approvals.approved');
    Route::get('/approvals/rejected', [DepartmentApprovalController::class, 'index'])->defaults('type', 'rejected')->name('department.approvals.rejected');
    Route::get('/approvals/my', [DepartmentApprovalController::class, 'myApprovals'])->name('department.approvals.my');
    Route::get('/approvals/{id}', [DepartmentApprovalController::class, 'show'])->name('department.approvals.show');
    Route::post('/approvals/{id}/approve', [DepartmentApprovalController::class, 'approve'])->name('department.approvals.approve');
    Route::post('/approvals/{id}/reject', [DepartmentApprovalController::class, 'reject'])->name('department.approvals.reject');
});

// ============================================================================
// 8. TRANSPORT APPROVAL WORKFLOW & TRIP SHEETS
// ============================================================================

Route::prefix('transport')->group(function () {
    // Transport Approvals
    Route::get('/approvals', [TransportApprovalController::class, 'index'])->name('transport.approvals.index');
    Route::get('/approvals/ajax', [TransportApprovalController::class, 'ajax'])->name('transport.approvals.ajax');
    Route::get('/approvals/{id}', [TransportApprovalController::class, 'show'])->name('transport.approvals.show');
    Route::post('/approvals/{id}/assign', [TransportApprovalController::class, 'assignVehicleDriver'])->name('transport.approvals.assign');
    Route::post('/approvals/{id}/approve', [TransportApprovalController::class, 'approve'])->name('transport.approvals.approve');
    Route::post('/approvals/{id}/reject', [TransportApprovalController::class, 'reject'])->name('transport.approvals.reject');
    Route::get('/approvals/{id}/availability', [TransportApprovalController::class, 'availability'])->name('transport.approvals.availability');

    // Trip Sheets
    Route::get('/trip-sheets', [TripSheetController::class, 'index'])->name('trip-sheets.index');
    Route::get('/trip-sheets/create', [TripSheetController::class, 'create'])->name('trip-sheets.create');
    Route::post('/trip-sheets', [TripSheetController::class, 'store'])->name('trip-sheets.store');
    Route::get('/trip-sheets/active', [TripSheetController::class, 'index'])->name('trip-sheets.active');
    Route::get('/trip-sheets/completed', [TripSheetController::class, 'index'])->name('trip-sheets.completed');
    Route::get('/trip-sheets/data', [TripSheetController::class, 'getData'])->name('trip-sheets.data');
    Route::get('/trip-sheet/{id}', [TripSheetController::class, 'show'])->name('trip-sheets.show');
    Route::post('/trip-sheet/start/{id}', [TripSheetController::class, 'startTrip'])->name('trip-sheets.start');
    Route::post('/trip-sheet/finish/{id}', [TripSheetController::class, 'finishTrip'])->name('trip-sheets.finish');
    Route::get('/trip-sheet/end/{id}', [TripSheetController::class, 'endTripForm'])->name('trip-sheets.end.form');
    Route::post('/trip-sheet/end/{id}', [TripSheetController::class, 'endTripSave'])->name('trip-sheets.end.save');
});

// ============================================================================
// 9. MAINTENANCE MANAGEMENT
// ============================================================================

Route::get('admin/maintenance/history', [MaintenanceRequisitionController::class, 'history'])->name('admin-maintenance.history');
Route::resource('maintenance', MaintenanceRequisitionController::class);

// ============================================================================
// MAINTENANCE APPROVAL WORKFLOW
// ============================================================================
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::prefix('approvals/maintenance')->name('maintenance_approvals.')->group(function () {
        Route::get('/', [MaintenanceApprovalController::class, 'index'])->name('index');
        // Approved requisitions list - must be before {id} route
        Route::get('/approved', [MaintenanceApprovalController::class, 'approved'])->name('approved');
        Route::get('/approved/ajax', [MaintenanceApprovalController::class, 'approved'])->name('approved.ajax');

        Route::get('/ajax', [MaintenanceApprovalController::class, 'ajax'])->name('ajax');
        Route::get('/{id}', [MaintenanceApprovalController::class, 'show'])->name('show');
        Route::post('/{id}/approve', [MaintenanceApprovalController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [MaintenanceTransportApprovalController::class, 'reject'])->name('reject');
    });

    // Transport Approval for Maintenance Requisitions
    Route::prefix('approvals/maintenance-transport')->name('maintenance_transport_approvals.')->group(function () {
        Route::get('/', [MaintenanceTransportApprovalController::class, 'index'])->name('index');
        Route::get('/ajax', [MaintenanceTransportApprovalController::class, 'ajax'])->name('ajax');
        Route::get('/{id}', [MaintenanceTransportApprovalController::class, 'show'])->name('show');
        Route::post('/{id}/approve', [MaintenanceTransportApprovalController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [MaintenanceTransportApprovalController::class, 'reject'])->name('reject');
    });
});

// ============================================================================
// 11. MAINTENANCE TYPES, VENDORS & SCHEDULES
// ============================================================================

Route::prefix('maintenance-types')->middleware('auth')->group(function () {
    Route::get('/', [MaintenanceTypeController::class, 'index'])->name('maintenance-types.index');
    Route::post('/store', [MaintenanceTypeController::class, 'store'])->name('maintenance-types.store');
    Route::get('/edit/{maintenanceType}', [MaintenanceTypeController::class, 'edit'])->name('maintenance-types.edit');
    Route::put('/update/{maintenanceType}', [MaintenanceTypeController::class, 'update'])->name('maintenance-types.update');
    Route::delete('/delete/{maintenanceType}', [MaintenanceTypeController::class, 'destroy'])->name('maintenance-types.destroy');
    Route::get('maintenance-types-data', [MaintenanceTypeController::class, 'data'])->name('maintenance.types.data');
});

Route::prefix('maintenance-vendors')->middleware('auth')->group(function () {
    Route::get('/', [MaintenanceVendorController::class, 'index'])->name('maintenance-vendors.index');
    Route::post('/store', [MaintenanceVendorController::class, 'store'])->name('maintenance.vendors.store');
    Route::get('/edit/{vendor}', [MaintenanceVendorController::class, 'edit'])->name('maintenance.vendors.edit');
    Route::post('/update/{vendor}', [MaintenanceVendorController::class, 'update'])->name('maintenance.vendors.update');
    Route::delete('/delete/{vendor}', [MaintenanceVendorController::class, 'destroy'])->name('maintenance.vendors.destroy');
});

Route::prefix('maintenance-categories')->group(function () {
    Route::get('/', [MaintenanceCategoryController::class, 'index'])->name('maintenance-categories.index');
    Route::post('/', [MaintenanceCategoryController::class, 'store'])->name('maintenance-categories.store');
    Route::get('/{id}/edit', [MaintenanceCategoryController::class, 'edit'])->name('maintenance-categories.edit');
    Route::delete('/{id}', [MaintenanceCategoryController::class, 'destroy'])->name('maintenance-categories.destroy');
});

// ============================================================================
// 12. REPORTS
// ============================================================================

// Reports routes are defined later in the admin group

// Trip & Fuel Consumption Report
Route::middleware(['auth'])->prefix('admin')->name('reports.')->group(function () {
    Route::get('/reports/trips-fuel', [TripFuelReportController::class, 'index'])->name('trips_fuel');
    Route::get('/reports/trips-fuel/ajax', [TripFuelReportController::class, 'ajax'])->name('trips_fuel.ajax');
    Route::get('/reports/trips-fuel/excel', [TripFuelReportController::class, 'excel'])->name('trips_fuel.excel');
    Route::get('/reports/trips-fuel/pdf', [TripFuelReportController::class, 'pdf'])->name('trips_fuel.pdf');
});

// Driver Performance Report
Route::middleware(['auth'])->prefix('admin')->name('reports.')->group(function () {
    Route::get('/reports/driver-performance', [DriverPerformanceReportController::class, 'index'])->name('driver_performance');
    Route::get('/reports/driver-performance/ajax', [DriverPerformanceReportController::class, 'ajax'])->name('driver_performance.ajax');
    Route::get('/reports/driver-performance/excel', [DriverPerformanceReportController::class, 'excel'])->name('driver_performance.excel');
    Route::get('/reports/driver-performance/pdf', [DriverPerformanceReportController::class, 'pdf'])->name('driver_performance.pdf');
});

// Maintenance Reports
Route::middleware(['auth'])->prefix('admin')->name('reports.')->group(function () {
    Route::get('/reports/maintenance', [MaintenanceReportController::class, 'index'])->name('maintenance');
    Route::get('/reports/maintenance/ajax', [MaintenanceReportController::class, 'ajax'])->name('maintenance.ajax');
    Route::get('/reports/maintenance/excel', [MaintenanceReportController::class, 'excel'])->name('maintenance.excel');
    Route::get('/reports/maintenance/pdf', [MaintenanceReportController::class, 'pdf'])->name('maintenance.pdf');
});

// ============================================================================
// 13. SUBSCRIPTIONS & PLANS
// ============================================================================

Route::middleware(['auth'])->prefix('admin')->as('admin.')->group(function () {
    Route::resource('plans', SubscriptionPlanController::class)->except(['show', 'destroy']);
    Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

    Route::resource('products', ProductController::class);
    Route::get('products-data', [ProductController::class, 'getData'])->name('products.getData');
    Route::post('products/{id}/toggle-status', [App\Http\Controllers\Admin\ProductController::class, 'toggleStatus'])->name('products.toggle-status');
    Route::post('products/{id}/toggle-featured', [App\Http\Controllers\Admin\ProductController::class, 'toggleFeatured'])->name('products.toggle-featured');
    Route::get('admin/products/downloads', [ProductController::class, 'downloads'])->name('products.downloads');
    Route::get('admin/products/reviews', [ProductController::class, 'reviews'])->name('products.reviews');

    // Orders management
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/data', [OrderController::class, 'data'])->name('orders.data');
    Route::get('orders/pending', [OrderController::class, 'pending'])->name('orders.pending');
    Route::get('orders/processing', [OrderController::class, 'processing'])->name('orders.processing');
    Route::get('orders/shipped', [OrderController::class, 'shipped'])->name('orders.shipped');
    Route::get('orders/delivered', [OrderController::class, 'delivered'])->name('orders.delivered');
    Route::get('orders/refunds', [OrderController::class, 'refunds'])->name('orders.refunds');
    Route::get('orders/exports', [OrderController::class, 'exports'])->name('orders.exports');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('orders/{order}/approve', [OrderController::class, 'approve'])->name('orders.approve');
    Route::post('orders/{order}/reject', [OrderController::class, 'reject'])->name('orders.reject');

    // Customers management
    Route::resource('customers', CustomerController::class)->except(['show']);
    Route::get('customers/reviews', [CustomerController::class, 'reviews'])->name('customers.reviews');
    Route::get('customer-groups', [CustomerGroupController::class, 'index'])->name('customer-groups.index');



    // Test route for support
    Route::get('test-support', function() {
        return 'Support routes are working! <a href="' . route('admin.support.tickets.index') . '">Go to tickets</a>';
    });

    // Support tickets management
    Route::resource('support/tickets', \App\Http\Controllers\Admin\SupportController::class, ['as' => 'support']);
    Route::get('tickets/open', [\App\Http\Controllers\Admin\SupportController::class, 'open'])->name('support.tickets.open');
    Route::get('tickets/pending', [\App\Http\Controllers\Admin\SupportController::class, 'pending'])->name('support.tickets.pending');
    Route::get('tickets/closed', [\App\Http\Controllers\Admin\SupportController::class, 'closed'])->name('support.tickets.closed');
    Route::post('support/tickets/{ticket}/reply', [\App\Http\Controllers\Admin\SupportController::class, 'addReply'])->name('support.tickets.reply');
    Route::post('support/tickets/{ticket}/status', [\App\Http\Controllers\Admin\SupportController::class, 'updateStatus'])->name('support.tickets.status');
    Route::post('support/tickets/{ticket}/assign', [\App\Http\Controllers\Admin\SupportController::class, 'assign'])->name('support.tickets.assign');

    // Support categories management
    Route::resource('support/categories', \App\Http\Controllers\Admin\SupportCategoryController::class, ['as' => 'support']);
    Route::post('support/categories/{category}/toggle-status', [\App\Http\Controllers\Admin\SupportCategoryController::class, 'toggleStatus'])->name('support.categories.toggle-status');

    // Knowledge base management
    Route::resource('support/knowledge-base', \App\Http\Controllers\Admin\KnowledgeBaseController::class, ['as' => 'support']);
    Route::post('support/knowledge-base/{article}/toggle-published', [\App\Http\Controllers\Admin\KnowledgeBaseController::class, 'togglePublished'])->name('support.knowledge-base.toggle-published');

    // Reports management
    Route::get('reports', [ReportsController::class, 'index'])->name('reports.index');
    Route::get('reports/sales', [ReportsController::class, 'sales'])->name('reports.sales');
    Route::get('reports/products', [ReportsController::class, 'products'])->name('reports.products');
    Route::get('reports/customers', [ReportsController::class, 'customers'])->name('reports.customers');
    Route::get('reports/orders', [ReportsController::class, 'orders'])->name('reports.orders');
    Route::get('reports/revenue', [ReportsController::class, 'revenue'])->name('reports.revenue');
    Route::get('reports/export', [ReportsController::class, 'export'])->name('reports.export');
    Route::post('reports/export/process', [ReportsController::class, 'processExport'])->name('reports.export.process');

    Route::get('admin/system/info', [SystemController::class, 'info'])->name('system.info');
    Route::get('admin/system/logs', [SystemController::class, 'logs'])->name('system.logs');
    Route::get('admin/system/cache', [SystemController::class, 'cache'])->name('system.cache');   
    Route::post('system/cache/clear', [SystemController::class, 'clearCache'])->name('system.cache.clear');
    Route::get('system/backup', [SystemController::class, 'backup'])->name('system.backup');
    Route::post('system/backup/create', [SystemController::class, 'createBackup'])->name('system.backup.create');
    Route::get('system/backup/download/{filename}', [SystemController::class, 'downloadBackup'])->name('system.backup.download');
    Route::delete('system/backup/{filename}', [SystemController::class, 'deleteBackup'])->name('system.backup.delete'); 
    Route::get('system/api', [App\Http\Controllers\Admin\SystemController::class, 'api'])->name('system.api');



    Route::get('roles', function() { return redirect()->route('admin.dashboard')->with('info', 'Roles & permissions coming soon.'); })->name('roles.index');
    Route::get('users/activity', function() { return redirect()->route('admin.dashboard')->with('info', 'User activity coming soon.'); })->name('users.activity');

    Route::get('settings/general', [App\Http\Controllers\Admin\SettingsController::class, 'general'])->name('settings.general');
    Route::post('settings/general/update', [App\Http\Controllers\Admin\SettingsController::class, 'updateGeneral'])->name('settings.general.update');
    Route::get('settings/email', [App\Http\Controllers\Admin\SettingsController::class, 'email'])->name('settings.email');
    Route::post('settings/email/update', [App\Http\Controllers\Admin\SettingsController::class, 'updateEmail'])->name('settings.email.update');
    Route::get('settings/payments', [App\Http\Controllers\Admin\SettingsController::class, 'payments'])->name('settings.payments');
    Route::post('settings/payments/update', [App\Http\Controllers\Admin\SettingsController::class, 'updatePayments'])->name('settings.payments.update');
    Route::get('settings/languages', [App\Http\Controllers\Admin\SettingsController::class, 'languages'])->name('settings.languages');
    Route::post('settings/languages/update', [App\Http\Controllers\Admin\SettingsController::class, 'updateLanguages'])->name('settings.languages.update');
    Route::get('settings/notifications', [App\Http\Controllers\Admin\SettingsController::class, 'notifications'])->name('settings.notifications');
    Route::post('settings/notifications/update', [App\Http\Controllers\Admin\SettingsController::class, 'updateNotifications'])->name('settings.notifications.update');
    Route::get('settings/security', [App\Http\Controllers\Admin\SettingsController::class, 'security'])->name('settings.security');
    Route::post('settings/security/update', [App\Http\Controllers\Admin\SettingsController::class, 'updateSecurity'])->name('settings.security.update');

    // SEO Management for Frontend Site (under marketing for menu compatibility)
    Route::get('marketing/seo', [App\Http\Controllers\Admin\SettingsController::class, 'seo'])->name('marketing.seo');
    Route::post('marketing/seo/update', [App\Http\Controllers\Admin\SettingsController::class, 'updateSeo'])->name('marketing.seo.update');
    Route::resource('purchases', PurchaseController::class);
    Route::resource('categories', CategoryController::class);
    Route::get('categories-data', [CategoryController::class, 'getData'])->name('categories.getData')->withoutMiddleware(['auth']);
    Route::post('categories/{id}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
    Route::resource('payments', \App\Http\Controllers\Admin\AdminPaymentController::class);
    Route::resource('users', \App\Http\Controllers\UserController::class);

    // ============================================================================
    // CONTENT MANAGEMENT (Pages, Hero Sliders, Testimonials, Team Members, Contact Info)
    // ============================================================================
    
    // Pages
    Route::resource('pages', PageContentController::class);
    Route::get('pages/data', [PageContentController::class, 'getData'])->name('pages.data');
    
    // Hero Sliders
    Route::resource('hero-sliders', HeroSliderController::class);
    Route::get('hero-sliders/data', [HeroSliderController::class, 'getData'])->name('hero-sliders.data');
    Route::post('hero-sliders/{id}/toggle-status', [HeroSliderController::class, 'toggleStatus'])->name('hero-sliders.toggle-status');
    
    // Testimonials
    Route::resource('testimonials', TestimonialsController::class);
    Route::get('testimonials/data', [TestimonialsController::class, 'getData'])->name('testimonials.data');
    Route::post('testimonials/{id}/toggle-status', [TestimonialsController::class, 'toggleStatus'])->name('testimonials.toggle-status');
    
    // Team Members
    Route::resource('team-members', TeamMembersController::class);
    Route::get('team-members/data', [TeamMembersController::class, 'getData'])->name('team-members.data');
    Route::post('team-members/{id}/toggle-status', [TeamMembersController::class, 'toggleStatus'])->name('team-members.toggle-status');
    
    // Contact Info
    Route::resource('contact-info', ContactInfoController::class);
    Route::get('contact-info/data', [ContactInfoController::class, 'getData'])->name('contact-info.data');
});

// Pricing page (accessible without auth)
Route::get('/pricing', [SubscriptionPlanController::class, 'price'])->name('pricing')->middleware('web');

// Subscription Routes - select can be accessed without auth, but store requires auth
Route::get('/subscribe/{slug}', [SubscriptionController::class, 'select'])->name('subscription.select');

Route::middleware(['auth'])->group(function () {
    Route::post('/subscribe', [SubscriptionController::class, 'store'])->name('subscription.store');
    Route::get('/subscription-expired', [SubscriptionController::class, 'expired'])->name('subscription.expired');
    Route::get('/my-subscription', [SubscriptionController::class, 'mySubscription'])->name('my.subscription');
});

// Subscription check for features
Route::middleware(['auth', 'subscription.active'])->group(function () {
    Route::resource('trips', TripSheetController::class);
});

// ============================================================================
// 14. PAYMENTS (MANUAL ONLY - STRIPE DISABLED)
// ============================================================================

Route::middleware(['auth'])->group(function () {
    // Stripe (disabled - controller not implemented)
    // Route::post('/stripe/pay', [StripeController::class,'pay'])
    //     ->name('stripe.pay');
    // Route::get('/payment/stripe', [StripeController::class,'pay'])
    //     ->name('payment.stripe');
    // Route::get('/stripe/success', [StripeController::class, 'success'])->name('stripe.success');

    // Manual Payment
    Route::get('/payment/manual/{plan}', [ManualPaymentController::class, 'form'])->name('payment.manual');
    Route::post('/manual-payment/ajax-store', [ManualPaymentController::class, 'ajaxStore'])->name('manual.payment.ajax');
    Route::post('/manual-payment/store', [ManualPaymentController::class, 'store']);

    // Invoices
    Route::get('/invoice/{payment}', [ManualPaymentController::class, 'invoice'])->name('invoice.download');
    Route::get('/admin/payments/{payment}/invoice', [ManualPaymentController::class, 'invoice'])->name('admin.payments.invoice');

    // Stripe (disabled - controller not implemented)
    // Route::get('/stripe/success', [StripeController::class, 'success'])->name('stripe.success');
});

// ============================================================================
// 15. TENANT MANAGEMENT (SaaS) - DISABLED (Controller not found)
// ============================================================================

// Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
//     Route::resource('tenants', \App\Http\Controllers\Admin\TenantController::class);
// });

// ============================================================================
// 15. TENANT MANAGEMENT (SaaS) - DISABLED
// ============================================================================

// Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
//     Route::resource('tenants', \App\Http\Controllers\Admin\TenantController::class);
// });

// ============================================================================
// 16. SUBSCRIPTION PLANS MANAGEMENT
// ============================================================================

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard/plans', [\App\Http\Controllers\Admin\SubscriptionPlanController::class, 'index'])->name('dashboard.plans.index');
    Route::get('dashboard/plans/create', [\App\Http\Controllers\Admin\SubscriptionPlanController::class, 'create'])->name('dashboard.plans.create');
    Route::post('dashboard/plans', [\App\Http\Controllers\Admin\SubscriptionPlanController::class, 'store'])->name('dashboard.plans.store');
    Route::get('dashboard/plans/{plan}/edit', [\App\Http\Controllers\Admin\SubscriptionPlanController::class, 'edit'])->name('dashboard.plans.edit');
    Route::put('dashboard/plans/{plan}', [\App\Http\Controllers\Admin\SubscriptionPlanController::class, 'update'])->name('dashboard.plans.update');
});

// ============================================================================
// 16. SUBSCRIPTION PLANS MANAGEMENT
// ============================================================================

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard/plans', [\App\Http\Controllers\Admin\SubscriptionPlanController::class, 'index'])->name('dashboard.plans.index');
    Route::get('dashboard/plans/create', [\App\Http\Controllers\Admin\SubscriptionPlanController::class, 'create'])->name('dashboard.plans.create');
    Route::post('dashboard/plans', [\App\Http\Controllers\Admin\SubscriptionPlanController::class, 'store'])->name('dashboard.plans.store');
    Route::get('dashboard/plans/{plan}/edit', [\App\Http\Controllers\Admin\SubscriptionPlanController::class, 'edit'])->name('dashboard.plans.edit');
    Route::put('dashboard/plans/{plan}', [\App\Http\Controllers\Admin\SubscriptionPlanController::class, 'update'])->name('dashboard.plans.update');
});

// ============================================================================
// 15. TENANT MANAGEMENT (SaaS) - DISABLED (Controller not found)
// ============================================================================

// Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
//     Route::resource('tenants', \App\Http\Controllers\Admin\TenantController::class);
// });

// ============================================================================
// 18. ADMIN CONTROLS & PAYMENTS
// ============================================================================

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Payment Management
    Route::get('payments/pending', [AdminPaymentController::class, 'pending'])->name('payments.pending');
    Route::get('payments/paid', [AdminPaymentController::class, 'paid'])->name('payments.paid');
    Route::get('admin/payments/paid/data', [AdminPaymentController::class, 'paidData'])->name('payments.paid.data');
    Route::post('/payments/approve/{payment}', [AdminPaymentController::class, 'approve'])->name('payments.approve');
    Route::post('payments/reject/{payment}', [AdminPaymentController::class, 'reject'])->name('payments.reject');
    Route::get('payments/expiring', [AdminPaymentController::class, 'expiring'])->name('payments.expiring');
    Route::get('revenue/plans', [AdminPaymentController::class, 'byPlan'])->name('revenue.plans');

    // API Payment Management (for external subscription system)
    Route::get('api-payments/users', [App\Http\Controllers\Admin\ApiPaymentController::class, 'registeredUsers'])->name('api-payments.users');
    Route::get('api-payments/pending', [App\Http\Controllers\Admin\ApiPaymentController::class, 'pendingPayments'])->name('api-payments.pending');
    Route::get('api-payments/paid', [App\Http\Controllers\Admin\ApiPaymentController::class, 'paidPayments'])->name('api-payments.paid');
    Route::post('api-payments/approve/{payment}', [App\Http\Controllers\Admin\ApiPaymentController::class, 'approvePayment'])->name('api-payments.approve');
    Route::post('api-payments/reject/{payment}', [App\Http\Controllers\Admin\ApiPaymentController::class, 'rejectPayment'])->name('api-payments.reject');

    // API Data Management
    Route::get('api-data', [App\Http\Controllers\Admin\ApiDataController::class, 'index'])->name('api-data.index');
    Route::get('api-data/users', [App\Http\Controllers\Admin\ApiDataController::class, 'getUsers'])->name('admin.api-data.users');
    Route::get('api-data/pending-payments', [App\Http\Controllers\Admin\ApiDataController::class, 'getPendingPayments'])->name('admin.api-data.pending');
});

Route::middleware(['auth', 'role:Admin'])->prefix('admin')->group(function () {
    // SubscriptionApprovalController not implemented
    // Route::get('/subscriptions/pending', [SubscriptionApprovalController::class, 'pending']);
    // Route::post('/subscriptions/approve/{payment}', [SubscriptionApprovalController::class, 'approve']);
});

// ============================================================================
// 16. ORGANIZATION SETUP
// ============================================================================

// Company routes (both direct and admin prefixed)
Route::middleware(['auth'])->group(function () {
    Route::resource('company', CompanyController::class);
    Route::resource('departments', DepartmentController::class);
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Employees
    Route::get('employees/data', [EmployeeController::class, 'data'])->name('employees.data');
    Route::get('employees/profiles', [EmployeeController::class, 'profiles'])->name('employees.profiles');
    Route::get('employees/approvals', [EmployeeController::class, 'approvals'])->name('employees.approvals');
    Route::resource('employees', EmployeeController::class);

    // Department Employees (for Department Head)
    Route::get('admin/employees/department', [DepartmentEmployeeController::class, 'index'])->name('employees.department.index');
    Route::get('employees/department/create', [DepartmentEmployeeController::class, 'create'])->name('employees.department.create');
    Route::post('employees/department', [DepartmentEmployeeController::class, 'store'])->name('employees.department.store');
    Route::get('employees/department/{employee}', [DepartmentEmployeeController::class, 'show'])->name('employees.department.show');
    Route::get('employees/department/{employee}/edit', [DepartmentEmployeeController::class, 'edit'])->name('employees.department.edit');
    Route::put('employees/department/{employee}', [DepartmentEmployeeController::class, 'update'])->name('employees.department.update');
    Route::delete('employees/department/{employee}', [DepartmentEmployeeController::class, 'destroy'])->name('employees.department.destroy');

    // Units
    Route::get('units/data', [UnitController::class, 'data'])->name('units.data');
    Route::get('units/list', [UnitController::class, 'list'])->name('units.list');
    Route::resource('units', UnitController::class);

    // Companies
    Route::get('company/data', [CompanyController::class, 'data'])->name('company.data');
    Route::get('company/stats', [CompanyController::class, 'stats'])->name('company.stats');

    // SaaS-specific company routes
    Route::get('company/{company}/tenant-details', [CompanyController::class, 'tenantDetails'])->name('company.tenant-details');
    Route::post('company/{company}/upgrade-subscription', [CompanyController::class, 'upgradeSubscription'])->name('company.upgrade-subscription');
    Route::post('company/{company}/deactivate', [CompanyController::class, 'deactivate'])->name('company.deactivate');
    Route::post('company/{company}/reactivate', [CompanyController::class, 'reactivate'])->name('company.reactivate');
    Route::get('company/{company}/export-data', [CompanyController::class, 'exportData'])->name('company.export-data');
    Route::get('company/{company}/statistics', [CompanyController::class, 'statistics'])->name('company.statistics');
    Route::post('company/provision', [CompanyController::class, 'provisionCompany'])->name('company.provision');

    // Departments
    Route::get('departments/data', [DepartmentController::class, 'data'])->name('departments.data');
    Route::get('departments/list', [DepartmentController::class, 'list'])->name('departments.list');
    Route::get('departments/{id}/head-info', [DepartmentController::class, 'getHeadInfo'])->name('departments.head-info');
    Route::get('unit-wise-department', [DepartmentController::class, 'unitWiseDepartment'])->name('unit-wise-department');

    // Department Heads Management
    Route::get('department-heads', [DepartmentHeadController::class, 'index'])->name('department-heads.index');
    Route::post('department-heads', [DepartmentHeadController::class, 'store'])->name('department-heads.store');
    Route::post('department-heads/send-notification', [DepartmentHeadController::class, 'sendNotification'])->name('department-heads.send-notification');
    Route::delete('department-heads/remove', [DepartmentHeadController::class, 'remove'])->name('department-heads.remove');
    Route::get('department-heads/employees/{departmentId}', [DepartmentHeadController::class, 'getEmployeesByDepartment'])->name('department-heads.employees');

    // Locations
    Route::get('locations/data', [LocationController::class, 'data'])->name('locations.data');
    Route::get('locations/list', [LocationController::class, 'list'])->name('locations.list');
    Route::resource('locations', LocationController::class);
});

// ============================================================================
// 17. EMPLOYEE & USER MANAGEMENT
// ============================================================================

Route::middleware(['auth'])->group(function () {
    // Employees (note: admin employees routes are in the admin prefix group above)

    // Users
    Route::get('users/getData', [UserController::class, 'getData'])->name('users.getData');
    Route::get('users/search', [UserController::class, 'search'])->name('users.search');

    Route::post('users/validate', [UserController::class, 'validateUser'])->name('users.validate');
    Route::post('users/ajaxSubmit', [UserController::class, 'ajaxSubmit'])->name('users.ajaxSubmit');

    // Get employee details for auto-populate
    Route::get('users/employee-details/{employeeId}', [UserController::class, 'getEmployeeDetails'])->name('users.get-employee-details');

    // User Profile
    Route::get('user-profile', [UserController::class, 'userprofile'])->name('user-profile');
    Route::post('profile-update', [UserController::class, 'updateProfile'])->name('profile-update');
    Route::post('profile-password-update', [UserController::class, 'profilepasswordupdate'])->name('profile-password-update');
});

// ============================================================================
// 16. SUBSCRIPTION PLANS MANAGEMENT
// ============================================================================

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard/plans', [\App\Http\Controllers\Admin\SubscriptionPlanController::class, 'index'])->name('dashboard.plans.index');
    Route::get('dashboard/plans/create', [\App\Http\Controllers\Admin\SubscriptionPlanController::class, 'create'])->name('dashboard.plans.create');
    Route::post('dashboard/plans', [\App\Http\Controllers\Admin\SubscriptionPlanController::class, 'store'])->name('dashboard.plans.store');
    Route::get('dashboard/plans/{plan}/edit', [\App\Http\Controllers\Admin\SubscriptionPlanController::class, 'edit'])->name('dashboard.plans.edit');
    Route::put('dashboard/plans/{plan}', [\App\Http\Controllers\Admin\SubscriptionPlanController::class, 'update'])->name('dashboard.plans.update');
    Route::get('dashboard/plans/{plan}', [\App\Http\Controllers\Admin\SubscriptionPlanController::class, 'show'])->name('dashboard.plans.show');
});

// ============================================================================
// 16A. QUOTA MANAGEMENT
// ============================================================================

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('quota-management', [QuotaManagementController::class, 'index'])->name('quota-management.index');
    Route::get('quota-management/search', [QuotaManagementController::class, 'search'])->name('quota-management.search');
    Route::get('quota-management/{company}', [QuotaManagementController::class, 'show'])->name('quota-management.show');
    Route::put('quota-management/{company}', [QuotaManagementController::class, 'update'])->name('quota-management.update');
    Route::post('quota-management/{company}/assign-plan', [QuotaManagementController::class, 'assignPlan'])->name('quota-management.assign-plan');
    Route::post('quota-management/{company}/clear-cache', [QuotaManagementController::class, 'clearCache'])->name('quota-management.clear-cache');
});

// ============================================================================
// 17. PERMISSIONS & ROLES
// ============================================================================

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Roles
    Route::get('roles/data', [RoleController::class, 'data'])->name('roles.data');
    Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
    Route::resource('roles', RoleController::class);
    Route::post('roles/{id}/duplicate', [RoleController::class, 'duplicate'])
        ->name('roles.duplicate');
    // Permissions
    Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('permissions/store', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('permissions/{id}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::post('permissions/{id}/update', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('permissions/{id}/delete', [PermissionController::class, 'destroy'])->name('permissions.destroy');
    Route::get('permissions/list', [PermissionController::class, 'list'])->name('permissions.list');
    Route::post('permissions/validate', [PermissionController::class, 'validatePermission'])->name('permissions.validate');
});

// ============================================================================
// 19. PUSH NOTIFICATIONS
// ============================================================================

Route::middleware(['auth'])->group(function () {
    Route::post('push-subscribe', [PushSubscriptionController::class, 'store'])->name('push.subscribe');
    Route::post('push-unsubscribe', [PushSubscriptionController::class, 'destroy'])->name('push.unsubscribe');
    Route::post('push-clear-all', [PushSubscriptionController::class, 'clearAll'])->name('push.clearAll');
    Route::get('/admin/push-subscribers', [PushSubscriptionController::class, 'index'])->name('admin.push.subscribers');
    Route::get('/settings/notifications', [SettingController::class, 'notification'])->name('settings.notifications');

    Route::post('/admin/push/test', [PushTestController::class, 'send'])->name('admin.push.test');

    // Test Push Notification
    Route::get('/test-push', function () {
        auth()->user()->notify(new \App\Notifications\RequisitionCreated);

        return 'Push Sent';
    });

    // Admin: Clear ALL push subscriptions (for fixing key mismatches)
    Route::post('/admin/push/clear-all', [PushTestController::class, 'clearAllSubscriptions'])->name('admin.push.clearAll');

});

// Notifications
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications/unread', [NotificationController::class, 'unread'])->name('admin.notifications.unread');
    Route::get('/admin/notifications/unread-count', function () {
        return response()->json(['count' => \App\Models\Notification::where('user_id', auth()->id())->where('is_read', 0)->count()]);
    })->name('notifications.unread');
    Route::get('notifications', [NotificationController::class, 'index'])->name('admin.notifications.all');
});

// ============================================================================
// 21. LANGUAGES & LOCALIZATION
// ============================================================================

Route::middleware(['auth'])->prefix('Super Admin')->group(function () {
    Route::post('/language/switch', [LanguageController::class, 'switch'])->name('admin.language.switch');
    Route::get('/language/current', [LanguageController::class, 'current'])->name('language.current');
    Route::get('/language/list', [LanguageController::class, 'list'])->name('language.list');

    Route::get('/translations', [TranslationController::class, 'index'])->name('admin.translations');
    Route::post('/translations', [TranslationController::class, 'store'])->name('translations.store');
    Route::post('/translations/update', [TranslationController::class, 'update'])->name('translations.update');
    Route::post('/translations/auto-translate', [TranslationController::class, 'autoTranslate'])->name('admin.translations.auto');
    Route::get('translations/ajax', [TranslationController::class, 'ajaxTranslations'])->name('admin.translations.ajax');
    Route::post('translations/create', [TranslationController::class, 'store'])->name('translations.create');
});

// ============================================================================
// 22. MISCELLANEOUS ROUTES
// ============================================================================

Route::middleware(['auth'])->group(function () {

    // License Types
    Route::get('license-types/data', [LicneseTypeController::class, 'data'])->name('license-types.data');
    Route::resource('license-types', LicneseTypeController::class);



    // Settings & Configuration
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings/store', [SettingController::class, 'store'])->name('settings.store');
    Route::get('settings/languages', [SettingController::class, 'loadLanguages'])->name('settings.languages');
    Route::post('admin/language/clear-cache', [SettingController::class, 'clearTranslationCache'])->name('admin.language.clear-cache');
    Route::post('admin/mail/clear-cache', [SettingController::class, 'clearMailConfigCache'])->name('admin.mail.clear-cache');
    Route::post('admin/language/sync', [SettingController::class, 'syncLanguages'])->name('admin.language.sync');
    Route::get('admin/settings/get-logo', [SettingController::class, 'getLogo'])->name('admin.settings.get-logo');

    // Menus
    Route::resource('menus', MenuController::class);
    Route::post('menus/reorder', [MenuController::class, 'reorder'])->name('menus.reorder');

    // Meta Pixel Analytics
    Route::get('metapixel/dashboard', [MetaPixelController::class, 'dashboard'])->name('metapixel.dashboard');
    Route::get('metapixel/pages', [MetaPixelController::class, 'pages'])->name('metapixel.pages');
    Route::get('metapixel/events', [MetaPixelController::class, 'events'])->name('metapixel.events');
    Route::get('metapixel/sources', [MetaPixelController::class, 'sources'])->name('metapixel.sources');
    Route::get('metapixel/conversions', [MetaPixelController::class, 'conversions'])->name('metapixel.conversions');
    Route::get('metapixel/config', [MetaPixelController::class, 'config'])->name('metapixel.config');
    Route::post('metapixel/config', [MetaPixelController::class, 'updateConfig'])->name('metapixel.config.update');
});

// ============================================================================
// STRIPE WEBHOOKS
// ============================================================================

Route::post('/stripe/webhook', [\App\Http\Controllers\Api\StripeWebhookController::class, 'handleWebhook'])
    ->name('stripe.webhook');

// ============================================================================
// 23. AI FEATURES ROUTES (Maintenance Alerts & Reporting)
// ============================================================================

Route::middleware(['auth'])->group(function () {

    // AI Maintenance Alerts
    Route::prefix('ai-maintenance-alerts')->name('ai-maintenance-alerts.')->group(function () {
        Route::get('/', [AIMaintenanceAlertController::class, 'index'])->name('index');
        Route::get('/dashboard', [AIMaintenanceAlertController::class, 'dashboard'])->name('dashboard');
        Route::get('/generate', [AIMaintenanceAlertController::class, 'generateForm'])->name('generateForm');
        Route::post('/generate', [AIMaintenanceAlertController::class, 'generate'])->name('generate');
        Route::get('/{alert}', [AIMaintenanceAlertController::class, 'show'])->name('show');
        Route::get('/{alert}/edit', [AIMaintenanceAlertController::class, 'edit'])->name('edit');
        Route::put('/{alert}', [AIMaintenanceAlertController::class, 'update'])->name('update');
        Route::post('/{alert}/mark-completed', [AIMaintenanceAlertController::class, 'markAsCompleted'])->name('mark-completed');
        Route::delete('/{alert}', [AIMaintenanceAlertController::class, 'destroy'])->name('destroy');
    });

    // AI Reports
    Route::prefix('ai-reports')->name('ai-reports.')->group(function () {
        Route::get('/', [AIReportController::class, 'index'])->name('index');
        Route::get('/dashboard', [AIReportController::class, 'dashboard'])->name('dashboard');
        Route::get('/create', [AIReportController::class, 'create'])->name('create');
        Route::post('/', [AIReportController::class, 'store'])->name('store');
        Route::get('/{report}', [AIReportController::class, 'show'])->name('show');
        Route::get('/{report}/download', [AIReportController::class, 'download'])->name('download');
        Route::delete('/{report}', [AIReportController::class, 'destroy'])->name('destroy');
    });

    // API endpoints for stats
    Route::get('/api/ai-maintenance-alerts/stats', [AIMaintenanceAlertController::class, 'stats'])->name('ai-maintenance-alerts.stats');
    Route::get('/api/ai-reports/stats', [AIReportController::class, 'stats'])->name('ai-reports.stats');

});

// ============================================================================
// Notification Routes
// ============================================================================
Route::post('/notifications/mark-read/{id}', function ($id) {
    $notification = auth()->user()->notifications()->find($id);
    if ($notification) {
        $notification->markAsRead();

        return response()->json(['status' => 'success']);
    }

    return response()->json(['status' => 'error', 'message' => 'Not found'], 404);
})->name('notifications.mark-read');

// ============================================================================
// END OF ROUTES FILE
// ============================================================================
