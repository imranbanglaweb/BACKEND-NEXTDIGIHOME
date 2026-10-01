<?php

namespace App\Listeners;

use App\Events\RequisitionStatusChanged;
use App\Services\EmailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendRequisitionStatusEmail implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(RequisitionStatusChanged $event)
    {
        $requisition = $event->requisition;
        $oldStatus = $event->oldStatus;
        $newStatus = $event->newStatus;

        // Determine which email to send based on status change
        switch ($newStatus) {
            case 'Dept_Approved':
            case 'Pending Transport Approval':
                // Department head has approved - notify transport admin
                $this->emailService->sendDepartmentApproved($requisition);
                break;

            case 'Transport_Approved':
            case 'Approved':
                // Transport has approved - notify requester, driver, and transport head
                $this->emailService->sendTransportApproved($requisition);
                break;

            case 'Rejected':
            case 'Rejected by Department':
            case 'Rejected by Transport':
                // Handle rejection notifications if needed
                // Currently handled in controllers via notifications
                break;

            default:
                // Other status changes - no email notification needed
                break;
        }
    }
}
