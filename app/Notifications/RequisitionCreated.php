<?php

namespace App\Notifications;

use App\Models\Requisition;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class RequisitionCreated extends Notification implements ShouldQueue
{
    use Queueable;

    public Requisition $requisition;

    public function __construct(Requisition $requisition)
    {
        $this->requisition = $requisition;
    }

    public function via($notifiable)
    {
        return [];
    }
}
