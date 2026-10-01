<?php

namespace App\Events;

use App\Models\Requisition;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RequisitionCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $requisition;

    public function __construct(Requisition $requisition)
    {
        $this->requisition = $requisition;
    }

    public function broadcastOn()
    {
        return new Channel('admin-notifications');
    }

    public function broadcastAs()
    {
        return 'requisition.created';
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->requisition->id,
            'number' => $this->requisition->requisition_number,
            'employee' => optional($this->requisition->requestedBy)->name,
        ];
    }
}
