<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Requisition;

class RequisitionStatusChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $requisition;
    public $oldStatus;
    public $newStatus;
    public $remarks;

    public function __construct(Requisition $requisition, $oldStatus, $newStatus, $remarks = null)
    {
        $this->requisition = $requisition;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
        $this->remarks = $remarks;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
