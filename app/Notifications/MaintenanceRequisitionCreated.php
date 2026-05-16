<?php

namespace App\Notifications;

use App\Models\MaintenanceRequisition;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MaintenanceRequisitionCreated extends Notification
{
    use Queueable;

    public $requisition;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(MaintenanceRequisition $requisition)
    {
        $this->requisition = $requisition;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $requisition = $this->requisition;
        
        return (new MailMessage)
            ->subject('New Maintenance Requisition - ' . $requisition->requisition_no)
            ->greeting('Hello!')
            ->line('A new maintenance requisition has been created and requires your attention.')
            ->line('Requisition Details:')
            ->line('Requisition No: ' . $requisition->requisition_no)
            ->line('Type: ' . ucfirst($requisition->requisition_type))
            ->line('Priority: ' . $requisition->priority)
            ->line('Vehicle: ' . ($requisition->vehicle->vehicle_name ?? 'N/A') . ' - ' . ($requisition->vehicle->vehicle_number ?? ''))
            ->line('Service Title: ' . $requisition->service_title)
            ->line('Maintenance Date: ' . \Carbon\Carbon::parse($requisition->maintenance_date)->format('d M Y'))
            ->line('Estimated Cost: $' . number_format($requisition->total_cost ?? 0, 2))
            ->action('View Details', route('maintenance.show', $requisition->id))
            ->line('Please review and take necessary action.')
            ->line('Thank you!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $requisition = $this->requisition;
        
        return [
            'title' => 'New Maintenance Requisition',
            'message' => 'Requisition ' . $requisition->requisition_no . ' has been created for ' . ($requisition->vehicle->vehicle_name ?? 'N/A'),
            'requisition_id' => $requisition->id,
            'requisition_no' => $requisition->requisition_no,
            'type' => $requisition->requisition_type,
            'priority' => $requisition->priority,
            'url' => route('maintenance.show', $requisition->id),
        ];
    }
}
