<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class DepartmentApproved extends Notification implements ShouldQueue
{
    use Queueable;

    public $requisition;

    public function __construct($requisition)
    {
        $this->requisition = $requisition;
    }

    public function via($notifiable)
    {
        return [];
    }
}
