<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class MaintenanceApproved extends Notification implements ShouldQueue
{
    use Queueable;

    protected $requisition;

    public function __construct($requisition)
    {
        $this->requisition = $requisition;
    }

    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        $vehicleName = $this->requisition->vehicle ? $this->requisition->vehicle->vehicle_name : 'N/A';
        $totalCost = number_format($this->requisition->total_cost ?? 0, 2);
        
        return (new WebPushMessage)
            ->title('Maintenance Approved: ' . $this->requisition->requisition_no)
            ->body("Your maintenance requisition has been approved! Vehicle: {$vehicleName}, Cost: \${$totalCost}")
            ->icon('https://tms.nextdigihome.com/public/admin_resource/assets/images/icons.png')
            ->data([
                'url' => route('maintenance.show', $this->requisition->id)
            ])
            ->action('View Requisition', route('maintenance.show', $this->requisition->id));
    }

    public function toDatabase($notifiable)
    {
        $approvedById = $this->requisition->approved_by;
        $approvedByName = 'Admin';
        
        if ($approvedById) {
            $approvedBy = \App\Models\User::find($approvedById);
            if ($approvedBy) {
                $approvedByName = $approvedBy->name;
            }
        }
        
        $vehicleName = $this->requisition->vehicle ? $this->requisition->vehicle->vehicle_name : 'N/A';
        
        return [
            'title' => "Maintenance Approved: {$this->requisition->requisition_no}",
            'message' => "Requisition for vehicle {$vehicleName} has been approved by {$approvedByName}.",
            'url' => route('maintenance.show', $this->requisition->id)
        ];
    }
}
