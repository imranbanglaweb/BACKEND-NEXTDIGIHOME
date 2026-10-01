<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class TransportApproved extends Notification implements ShouldQueue
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
        $driverName = $this->requisition->assignedDriver ? $this->requisition->assignedDriver->driver_name : 'N/A';
        $vehicleName = $this->requisition->assignedVehicle ? $this->requisition->assignedVehicle->vehicle_name : 'N/A';
        
        return (new WebPushMessage)
            ->title('Transport Approved: ' . $this->requisition->requisition_number)
            ->body("Your requisition has been approved! Vehicle: {$vehicleName}, Driver: {$driverName}")
            ->icon('https://tms.nextdigihome.com/public/admin_resource/assets/images/icons.png')
            ->data([
                'url' => route('requisitions.show', $this->requisition->id)
            ])
            ->action('View Requisition', route('requisitions.show', $this->requisition->id));
    }

    public function toDatabase($notifiable)
    {
        $approvedById = $this->requisition->transport_admin_id;
        $approvedByName = 'Transport Admin';
        
        if ($approvedById) {
            $approvedBy = \App\Models\User::find($approvedById);
            if ($approvedBy) {
                $approvedByName = $approvedBy->name;
            }
        }
        
        $driverName = $this->requisition->assignedDriver ? $this->requisition->assignedDriver->driver_name : 'N/A';
        $vehicleName = $this->requisition->assignedVehicle ? $this->requisition->assignedVehicle->vehicle_name : 'N/A';
        
        return [
            'title' => "Transport Approved: {$this->requisition->requisition_number}",
            'message' => "Requisition has been approved by {$approvedByName}. Vehicle: {$vehicleName}, Driver: {$driverName}",
            'url' => route('requisitions.show', $this->requisition->id)
        ];
    }
}
