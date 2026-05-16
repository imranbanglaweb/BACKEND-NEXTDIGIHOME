<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Requisition;

class RequisitionStatusUpdated implements ShouldBroadcast
{
    use SerializesModels;

    public $requisition;

    public function __construct(Requisition $requisition)
    {
        $this->requisition = $requisition;
    }

    public function broadcastOn()
    {
        return new Channel('dashboard');
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->requisition->id,
            'requested_by_name' => $this->requisition->requestedBy->name ?? 'N/A',
            'travel_date' => $this->requisition->travel_date,
            'status' => $this->requisition->status,
            'status_text' => $this->requisition->status_text,
        ];
    }
}
