<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TestPushNotification extends Notification
{
    use SerializesModels, Queueable;

    public $message;

    public function __construct($msg)
    {
        $this->message = $msg;
    }

    public function broadcastOn()
    {
        return new Channel('dashboard');
    }

    use Queueable;

    public function via($notifiable)
    {
        return ['webpush'];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('VMS Test Notification')
            ->body('If you see this, push is working')
            ->icon('/icon-192.png')
            ->action('Open App', 'open_app');
    }
}
