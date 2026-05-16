<?php

namespace App\Observers;

use App\Jobs\SendRequisitionCreatedEmailJob;
use App\Models\Requisition;
use App\Services\EmailService;

class RequisitionObserver
{
    /**
     * @var EmailService
     */
    protected $emailService;

    /**
     * Create a new observer instance.
     *
     * @return void
     */
    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * Handle the Requisition "created" event.
     *
     * @return void
     */
    public function created(Requisition $requisition)
    {
        try {
            SendRequisitionCreatedEmailJob::dispatch($requisition);
        } catch (\Throwable $e) {
            \Log::warning('RequisitionObserver email job error: '.$e->getMessage());
        }
    }

    /**
     * Handle the Requisition "updated" event.
     *
     * @return void
     */
    public function updated(Requisition $requisition)
    {
        // Check if status has changed
        if ($requisition->isDirty('status')) {
            $oldStatus = $requisition->getOriginal('status');
            $newStatus = $requisition->status;

            // Dispatch event for email notifications via listener
            event(new \App\Events\RequisitionStatusChanged($requisition, $oldStatus, $newStatus));
        }
    }

    /**
     * Handle the Requisition "deleted" event.
     *
     * @return void
     */
    public function deleted(Requisition $requisition)
    {
        //
    }

    /**
     * Handle the Requisition "restored" event.
     *
     * @return void
     */
    public function restored(Requisition $requisition)
    {
        //
    }
}
