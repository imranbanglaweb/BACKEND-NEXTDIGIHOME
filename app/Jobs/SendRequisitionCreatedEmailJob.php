<?php

namespace App\Jobs;

use App\Models\Requisition;
use App\Services\EmailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendRequisitionCreatedEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $requisitionId;

    protected $customEmail;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Requisition $requisition, ?string $customEmail = null)
    {
        $this->requisitionId = $requisition->id;
        $this->customEmail = $customEmail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(EmailService $emailService)
    {
        // Eager load relationships to avoid N+1 queries in email template
        $requisition = Requisition::with([
            'requestedBy',
            'department',
            'assignedDriver',
            'driver',
            'assignedVehicle',
            'vehicle',
        ])->find($this->requisitionId);

        if (! $requisition) {
            return;
        }

        $emailService->sendRequisitionCreated($requisition, $this->customEmail);
    }
}
