<?php

namespace App\Services;

use App\Models\EmailLog;
use App\Models\EmailTemplate;
use App\Models\MaintenanceRequisition;
use App\Models\Requisition;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * EmailService - Handles dynamic email notifications for requisition workflow
 *
 * This service is used by:
 * - SendRequisitionStatusEmail listener
 * - DepartmentApprovalController
 * - TransportApprovalController
 * - RequisitionObserver
 */
class EmailService
{
    /**
     * @var \Illuminate\Contracts\Mail\Mailer
     */
    protected $mailer;

    /**
     * @var EmailTemplate
     */
    protected $emailTemplate;

    /**
     * @var EmailLog
     */
    protected $emailLog;

    /**
     * Create a new EmailService instance
     */
    public function __construct(
        \Illuminate\Contracts\Mail\Mailer $mailer,
        EmailTemplate $emailTemplate,
        EmailLog $emailLog
    ) {
        $this->mailer = $mailer;
        $this->emailTemplate = $emailTemplate;
        $this->emailLog = $emailLog;
    }

    /**
     * Send email when requisition is created (to Department Head)
     *
     * @param  string|null  $customEmail  Optional custom email recipient
     */
    public function sendRequisitionCreated(Requisition $requisition, ?string $customEmail = null): bool
    {
        // If custom email is provided, use it instead of default recipients
        if (! empty($customEmail)) {
            $recipients = [$customEmail];
        } else {
            $recipients = $this->getRecipients('created', $requisition);
        }

        if (empty($recipients)) {
            Log::warning('EmailService: No recipients found for requisition created notification', [
                'requisition_id' => $requisition->id,
                'custom_email' => $customEmail,
            ]);

            return false;
        }

        $data = $this->prepareTemplateData($requisition);
        $data['status'] = 'Pending';

        return $this->sendTemplatedEmail(
            EmailTemplate::TYPE_CREATED,
            $recipients,
            $data
        );
    }

    /**
     * Send email when Department Head approves (to Transport Head)
     */
    public function sendDepartmentApproved(Requisition $requisition): bool
    {
        $recipients = $this->getRecipients('dept_approved', $requisition);

        if (empty($recipients)) {
            Log::warning('EmailService: No recipients found for department approved notification', [
                'requisition_id' => $requisition->id,
            ]);

            return false;
        }

        $data = $this->prepareTemplateData($requisition);
        $data['status'] = 'Department Approved';

        return $this->sendTemplatedEmail(
            EmailTemplate::TYPE_DEPT_APPROVED,
            $recipients,
            $data
        );
    }

    /**
     * Send email when Transport approves (to Requester, Driver, Transport Head)
     */
    public function sendTransportApproved(Requisition $requisition): bool
    {
        $recipients = $this->getRecipients('transport_approved', $requisition);

        if (empty($recipients)) {
            Log::warning('EmailService: No recipients found for transport approved notification', [
                'requisition_id' => $requisition->id,
            ]);

            return false;
        }

        $data = $this->prepareTemplateData($requisition);
        $data['status'] = 'Transport Approved';

        return $this->sendTemplatedEmail(
            EmailTemplate::TYPE_TRANSPORT_APPROVED,
            $recipients,
            $data
        );
    }

    /**
     * Send email when maintenance requisition is created (to Department Head)
     *
     * @param  string|null  $customEmail  Optional custom email recipient
     */
    public function sendMaintenanceRequisitionCreated(MaintenanceRequisition $requisition, ?string $customEmail = null): bool
    {
        $recipients = [];

        // If custom email is provided, use it
        if (! empty($customEmail)) {
            $recipients = [$customEmail];
        } else {
            // Get Department Head emails
            $recipients = $this->getMaintenanceDepartmentHeadEmails($requisition);
        }

        if (empty($recipients)) {
            Log::warning('EmailService: No recipients found for maintenance requisition created notification', [
                'maintenance_requisition_id' => $requisition->id,
                'custom_email' => $customEmail,
            ]);

            return false;
        }

        $data = $this->prepareMaintenanceTemplateData($requisition);
        $data['status'] = 'Pending';

        return $this->sendTemplatedEmail(
            'maintenance_created',
            $recipients,
            $data
        );
    }

    /**
     * Send email when maintenance is approved by department (to Transport Head)
     */
    public function sendMaintenanceDepartmentApproved(MaintenanceRequisition $requisition): bool
    {
        $recipients = $this->getMaintenanceTransportHeadEmails($requisition);

        if (empty($recipients)) {
            Log::warning('EmailService: No recipients found for maintenance department approved notification', [
                'maintenance_requisition_id' => $requisition->id,
            ]);

            return false;
        }

        $data = $this->prepareMaintenanceTemplateData($requisition);
        $data['status'] = 'Department Approved';

        return $this->sendTemplatedEmail(
            'maintenance_dept_approved',
            $recipients,
            $data
        );
    }

    /**
     * Send email when maintenance is approved by transport (to Department Head and Requester)
     */
    public function sendMaintenanceTransportApproved(MaintenanceRequisition $requisition): bool
    {
        $recipients = array_merge(
            $this->getMaintenanceRequesterEmails($requisition),
            $this->getMaintenanceDepartmentHeadEmails($requisition)
        );

        if (empty($recipients)) {
            Log::warning('EmailService: No recipients found for maintenance transport approved notification', [
                'maintenance_requisition_id' => $requisition->id,
            ]);

            return false;
        }

        $data = $this->prepareMaintenanceTemplateData($requisition);
        $data['status'] = 'Transport Approved';

        return $this->sendTemplatedEmail(
            'maintenance_transport_approved',
            $recipients,
            $data
        );
    }

    /**
     * Send email when maintenance is fully approved (to Requester)
     */
    public function sendMaintenanceApproved(MaintenanceRequisition $requisition): bool
    {
        $recipients = $this->getMaintenanceRequesterEmails($requisition);

        if (empty($recipients)) {
            Log::warning('EmailService: No recipients found for maintenance approved notification', [
                'maintenance_requisition_id' => $requisition->id,
            ]);

            return false;
        }

        $data = $this->prepareMaintenanceTemplateData($requisition);
        $data['status'] = 'Approved';

        return $this->sendTemplatedEmail(
            'maintenance_approved',
            $recipients,
            $data
        );
    }

    /**
     * Get Department Head emails for maintenance requisition
     */
    protected function getMaintenanceDepartmentHeadEmails(MaintenanceRequisition $requisition): array
    {
        $emails = [];

        // Get users with Department Head, Manager, Super Admin, Admin roles
        $users = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['Department Head', 'Manager', 'Super Admin', 'Admin']);
        })->where('email', '!=', '')->whereNotNull('email')->pluck('email')->toArray();

        return array_merge($emails, $users);
    }

    /**
     * Get Transport Head emails for maintenance requisition
     */
    protected function getMaintenanceTransportHeadEmails(MaintenanceRequisition $requisition): array
    {
        $emails = [];

        // Get users with Transport role
        $transportUsers = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['Transport', 'Super Admin', 'Admin']);
        })->where('email', '!=', '')->whereNotNull('email')->pluck('email')->toArray();

        return array_merge($emails, $transportUsers);
    }

    /**
     * Get requester emails for maintenance requisition
     */
    protected function getMaintenanceRequesterEmails(MaintenanceRequisition $requisition): array
    {
        $emails = [];

        $employee = $requisition->employee;
        if ($employee && ! empty($employee->email)) {
            $emails[] = $employee->email;
        }

        return $emails;
    }

    /**
     * Get department head user by department ID
     */
    protected function getDepartmentHeadUser(int $departmentId): ?User
    {
        return User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['Department Head', 'Manager']);
        })->where('department_id', $departmentId)
            ->where('email', '!=', '')
            ->whereNotNull('email')
            ->first();
    }

    /**
     * Prepare template data from maintenance requisition
     */
    protected function prepareMaintenanceTemplateData(MaintenanceRequisition $requisition): array
    {
        $employee = $requisition->employee;
        $vehicle = $requisition->vehicle;
        $vendor = $requisition->vendor;

        // Get admin settings
        $adminSettings = DB::table('settings')->where('id', 1)->first();
        $adminTitle = $adminSettings->admin_title ?? 'Transport Management System';
        $adminLogo = $adminSettings->admin_logo ?? 'default.png';
        $baseUrl = config('app.url', 'http://localhost');
        $adminLogoUrl = ! empty($adminSettings->admin_logo)
            ? $baseUrl.'/public/admin_resource/assets/images/'.$adminSettings->admin_logo
            : $baseUrl.'/public/admin_resource/assets/images/default.png';

        // Get department name from employee
        $departmentName = 'N/A';
        if ($employee && $employee->department_id) {
            $department = DB::table('departments')->where('id', $employee->department_id)->first();
            $departmentName = $department ? ($department->name ?? 'N/A') : 'N/A';
        }

        // Get department head name
        $headName = 'Department Head';
        if ($employee && $employee->department_id) {
            $headUser = $this->getDepartmentHeadUser($employee->department_id);
            $headName = $headUser ? ($headUser->name ?? 'Department Head') : 'Department Head';
        }

        return [
            'requisition_number' => $requisition->requisition_no ?? 'N/A',
            'requester_name' => $employee ? ($employee->name ?? 'N/A') : 'N/A',
            'requester_email' => $employee ? ($employee->email ?? 'N/A') : 'N/A',
            'department_name' => $departmentName,
            'head_name' => $headName,
            'vehicle_name' => $vehicle ? ($vehicle->vehicle_name ?? 'N/A') : 'N/A',
            'vehicle_number' => $vehicle ? ($vehicle->vehicle_number ?? 'N/A') : 'N/A',
            'maintenance_type' => $requisition->maintenanceType ? ($requisition->maintenanceType->name ?? 'N/A') : 'N/A',
            'service_title' => $requisition->service_title ?? 'N/A',
            'maintenance_date' => $requisition->maintenance_date ? $requisition->maintenance_date->format('d M, Y') : 'N/A',
            'scheduled_date' => $requisition->maintenance_date ? $requisition->maintenance_date->format('d M, Y') : 'N/A',
            'description' => $requisition->description ?? $requisition->service_title ?? 'N/A',
            'priority' => $requisition->priority ?? 'N/A',
            'estimated_cost' => number_format($requisition->total_cost ?? 0, 2),
            'status' => $requisition->status ?? 'N/A',
            'approval_url' => route('maintenance.show', $requisition->id),
            'company_name' => config('app.name', 'Transport Management System'),
            'year' => date('Y'),
            'admin_title' => $adminTitle,
            'admin_logo_url' => $adminLogoUrl,
            'admin_description' => $adminSettings->admin_description ?? 'Vehicle Management System',
        ];
    }

    /**
     * Generic method for sending templated emails
     */
    public function sendTemplatedEmail(string $templateType, array $recipients, array $data): bool
    {
        $template = $this->getTemplate($templateType);

        if (! $template) {
            $this->logEmail(
                null,
                implode(', ', $recipients),
                'Template Not Found',
                'Template type: '.$templateType,
                EmailLog::STATUS_FAILED,
                'Email template not found for type: '.$templateType
            );
            Log::error('EmailService: Email template not found', ['type' => $templateType]);

            return false;
        }

        $rendered = $this->renderTemplate($template, $data);
        $subject = $rendered['subject'];
        $body = $rendered['body'];

        $success = true;

        foreach ($recipients as $recipient) {
            try {
                $this->mailer->to($recipient)->send(new \App\Mail\GenericMailable($subject, $body));

                $this->logEmail(
                    $template->id,
                    $recipient,
                    $subject,
                    $body,
                    EmailLog::STATUS_SENT
                );
            } catch (\Exception $e) {
                $success = false;
                $errorMessage = $e->getMessage();

                $this->logEmail(
                    $template->id,
                    $recipient,
                    $subject,
                    $body,
                    EmailLog::STATUS_FAILED,
                    $errorMessage
                );

                Log::error('EmailService: Failed to send email', [
                    'recipient' => $recipient,
                    'template_type' => $templateType,
                    'error' => $errorMessage,
                ]);
            }
        }

        return $success;
    }

    /**
     * Find active template by type
     */
    public function getTemplate(string $type, bool $isActive = true): ?EmailTemplate
    {
        $query = EmailTemplate::where('type', $type);

        if ($isActive) {
            $query->where('is_active', true);
        }

        return $query->first();
    }

    /**
     * Replace template variables with data
     */
    public function renderTemplate(EmailTemplate $template, array $data): array
    {
        return $template->render($data);
    }

    /**
     * Log email to email_logs table
     */
    public function logEmail(
        ?int $templateId,
        string $recipient,
        string $subject,
        string $body,
        string $status,
        ?string $errorMessage = null
    ): EmailLog {
        return EmailLog::create([
            'requisition_id' => null, // Will be set if available in context
            'recipient_email' => $recipient,
            'subject' => $subject,
            'body' => $body,
            'status' => $status,
            'error_message' => $errorMessage,
            'sent_at' => $status === EmailLog::STATUS_SENT ? now() : null,
            'created_by' => auth()->id() ?? 1,
            'updated_by' => auth()->id() ?? 1,
        ]);
    }

    /**
     * Get recipients based on notification type
     */
    public function getRecipients(string $type, Requisition $requisition): array
    {
        $recipients = [];

        switch ($type) {
            case 'created':
                // Send to Department Head
                $recipients = $this->getDepartmentHeadEmails($requisition);
                break;

            case 'dept_approved':
                // Send to Transport Head AND Requester
                $recipients = array_merge(
                    $this->getTransportHeadEmails($requisition),
                    $this->getRequesterEmails($requisition)
                );
                break;

            case 'transport_approved':
                // Send to Requester, Driver, and Transport Head
                $recipients = array_merge(
                    $this->getRequesterEmails($requisition),
                    $this->getDriverEmails($requisition),
                    $this->getTransportHeadEmails($requisition)
                );
                break;

            default:
                Log::warning('EmailService: Unknown recipient type', ['type' => $type]);
        }

        return array_filter(array_unique($recipients));
    }

    /**
     * Get requester emails
     */
    protected function getRequesterEmails(Requisition $requisition): array
    {
        $emails = [];

        $requester = $requisition->requestedBy;
        if ($requester && ! empty($requester->email)) {
            $emails[] = $requester->email;
        }

        return $emails;
    }

    /**
     * Get Department Head emails
     */
    protected function getDepartmentHeadEmails(Requisition $requisition): array
    {
        $emails = [];

        // Get department head from department relationship
        $department = $requisition->department;
        if ($department) {
            // Use the model's accessor which has fallback logic
            $headEmail = $department->head_email;
            if (! empty($headEmail)) {
                $emails[] = $headEmail;
            }
        }

        // Fallback: Also check for users with department_head user_type in the same department
        if (empty($emails)) {
            $departmentId = $requisition->department_id;
            if ($departmentId) {
                $headUsers = \App\Models\User::where('department_id', $departmentId)
                    ->where('user_type', 'department_head')
                    ->where('email', '!=', '')
                    ->pluck('email')
                    ->toArray();

                $emails = array_merge($emails, $headUsers);
            }
        }

        return array_filter(array_unique($emails));
    }

    /**
     * Get Transport Head emails
     */
    protected function getTransportHeadEmails(Requisition $requisition): array
    {
        $emails = [];

        // Get transport admin/head from the requisition
        $transportAdmin = $requisition->transportAdmin;
        if ($transportAdmin && ! empty($transportAdmin->email)) {
            $emails[] = $transportAdmin->email;
        }

        // You might also want to query for users with transport admin role
        // This is an alternative approach
        $transportAdmins = \App\Models\User::whereHas('roles', function ($query) {
            $query->where('name', 'Transport_Head');
        })->where('email', '!=', '')->pluck('email')->toArray();

        return array_merge($emails, $transportAdmins);
    }

    /**
     * Get Driver emails
     */
    protected function getDriverEmails(Requisition $requisition): array
    {
        $emails = [];

        $driver = $requisition->assignedDriver ?? $requisition->driver;

        // First check if driver has direct email
        if ($driver && ! empty($driver->email)) {
            $emails[] = $driver->email;
        }

        // If driver has employee_id, try to get email from employee
        if (empty($emails) && $driver && $driver->employee_id) {
            $employee = \App\Models\Employee::find($driver->employee_id);
            if ($employee && ! empty($employee->email)) {
                $emails[] = $employee->email;
            }
        }

        // Also check for user account linked to driver via employee
        if (empty($emails) && $driver && $driver->employee_id) {
            $user = \App\Models\User::where('employee_id', $driver->employee_id)->first();
            if ($user && ! empty($user->email)) {
                $emails[] = $user->email;
            }
        }

        return $emails;
    }

    /**
     * Prepare template data from requisition
     */
    protected function prepareTemplateData(Requisition $requisition): array
    {
        $requester = $requisition->requestedBy;
        $department = $requisition->department;
        $driver = $requisition->assignedDriver ?? $requisition->driver;
        $vehicle = $requisition->assignedVehicle ?? $requisition->vehicle;

        // Get driver contact info - try employee first, then driver fields
        $driverPhone = '';
        $driverEmail = '';
        if ($driver) {
            if ($driver->employee) {
                $driverPhone = $driver->employee->phone ?? '';
                $driverEmail = $driver->employee->email ?? '';
            }
            if (empty($driverPhone)) {
                $driverPhone = $driver->phone ?? $driver->mobile ?? '';
            }
        }

        // Get department head info for department approval emails
        $headName = 'Department Head';
        $approvedByName = null;
        $approvedByEmail = null;

        // Get department head name from the department's head_employee relationship
        if ($department && $department->headEmployee) {
            $headName = $department->headEmployee->name;
        } elseif ($department && $department->head_email) {
            // Use department name as fallback if head name not available
            $headName = $department->department_name.' Department Head';
        }

        // Get the user who approved (for approval emails)
        if ($requisition->department_approved_by) {
            $approvedBy = User::find($requisition->department_approved_by);
            if ($approvedBy) {
                $approvedByName = $approvedBy->name;
                $approvedByEmail = $approvedBy->email;
            }
        }

        // Get admin settings for email templates (cached for 1 hour)
        $adminSettings = Cache::remember('admin_settings_for_emails', 3600, function () {
            return DB::table('settings')->where('id', 1)->first();
        });
        $adminTitle = $adminSettings->admin_title ?? 'Transport Management System';
        $adminDescription = $adminSettings->admin_description ?? 'Fleet Management Solution';
        $adminLogo = $adminSettings->admin_logo ?? 'default.png';
        // Generate absolute URL for logo - needed for emails
        $baseUrl = config('app.url', 'http://localhost');
        $adminLogoUrl = ! empty($adminSettings->admin_logo)
            ? $baseUrl.'/public/admin_resource/assets/images/'.$adminSettings->admin_logo
            : $baseUrl.'/public/admin_resource/assets/images/default.png';

        return [
            'requisition_number' => $requisition->requisition_number ?? 'N/A',
            'requester_name' => $requester ? ($requester->name ?? $requester->first_name.' '.$requester->last_name) : 'N/A',
            'requester_email' => $requester->email ?? 'N/A',
            'department_name' => $department ? ($department->department_name ?? 'N/A') : 'N/A',
            'pickup_location' => $requisition->from_location ?? 'N/A',
            'dropoff_location' => $requisition->to_location ?? 'N/A',
            'pickup_date' => $requisition->travel_date ? $requisition->travel_date->format('d M, Y') : 'N/A',
            'pickup_time' => $requisition->travel_time ? $requisition->travel_time->format('H:i') : 'N/A',
            'purpose' => $requisition->purpose ?? 'N/A',
            'vehicle_type' => $vehicle ? ($vehicle->vehicle_type ?? $vehicle->name) : ($requisition->vehicle_type ?? 'N/A'),
            'passengers' => (string) ($requisition->number_of_passenger ?? $requisition->total_passenger_count ?? 0),
            'status' => $requisition->status ?? 'N/A',
            'approval_url' => route('requisitions.show', $requisition->id),
            'company_name' => config('app.name', 'Transport Management System'),
            'year' => date('Y'),
            // Department head info
            'head_name' => $headName,
            // Approval info
            'approved_by_name' => $approvedByName,
            'approved_by_email' => $approvedByEmail,
            // Vehicle & Driver info (for transport approved emails)
            'vehicle_assigned' => $vehicle ? ($vehicle->vehicle_name ?? $vehicle->name) : null,
            'driver_assigned' => $driver ? ($driver->driver_name ?? $driver->name) : null,
            'driver_phone' => $driver ? ($driver->phone ?? $driver->contact_number) : null,
            // Admin settings for email templates
            'admin_title' => $adminTitle,
            'admin_description' => $adminDescription,
            'admin_logo_url' => $adminLogoUrl,
        ];
    }

    /**
     * Send product purchase confirmation email
     */
    public function sendProductPurchaseConfirmation($purchase): bool
    {
        $recipients = [$purchase->customer_email];

        if (empty($recipients)) {
            return false;
        }

        $data = $this->prepareProductPurchaseData($purchase);

        return $this->sendTemplatedEmail(
            'product_purchase_confirmation',
            $recipients,
            $data
        );
    }

    /**
     * Send product delivery email with download link
     */
    public function sendProductDelivery($purchase): bool
    {
        $recipients = [$purchase->customer_email];

        if (empty($recipients)) {
            return false;
        }

        $data = $this->prepareProductPurchaseData($purchase);
        $data['download_url'] = route('download', ['token' => $purchase->download_token]);

        return $this->sendTemplatedEmail(
            'product_delivery',
            $recipients,
            $data
        );
    }

    /**
     * Prepare template data for product purchase
     */
    protected function prepareProductPurchaseData($purchase): array
    {
        $product = $purchase->product;
        $adminSettings = DB::table('settings')->where('id', 1)->first();
        $baseUrl = config('app.url', 'http://localhost');
        $adminLogoUrl = ! empty($adminSettings->admin_logo)
            ? $baseUrl.'/public/admin_resource/assets/images/'.$adminSettings->admin_logo
            : $baseUrl.'/public/admin_resource/assets/images/default.png';

        // Generate download URL (route not named, so construct manually)
        $downloadUrl = $baseUrl . '/api/download?token=' . $purchase->download_token;

        return [
            'customer_name' => $purchase->customer_name,
            'customer_email' => $purchase->customer_email,
            'transaction_id' => $purchase->transaction_id,
            'product_name' => $product->name,
            'product_price' => $purchase->price,
            'quantity' => $purchase->quantity,
            'total' => $purchase->total,
            'status' => ucfirst($purchase->status),
            'download_token' => $purchase->download_token,
            'download_url' => $downloadUrl,
            'access_starts_at' => $purchase->access_starts_at ? $purchase->access_starts_at->format('d M Y') : null,
            'access_expires_at' => $purchase->access_expires_at ? $purchase->access_expires_at->format('d M Y') : null,
            'remaining_access_days' => $purchase->remaining_access_days,
            'validity_label' => $product->access_label ?? null,
            'purchase_type' => $product->purchase_type_label ?? null,
            'company_name' => config('app.name', 'Digital Products Store'),
            'year' => date('Y'),
            'admin_title' => $adminSettings->admin_title ?? 'Digital Products Store',
            'admin_description' => $adminSettings->admin_description ?? 'Digital Products Store',
            'admin_logo_url' => $adminLogoUrl,
        ];
    }
}
