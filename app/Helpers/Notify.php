<?php
namespace App\Helpers;
use Illuminate\Notifications\Notification;
use App\Models\User;
use App\Notifications\TestPushNotification;

function sendNotification($toUserId, $title, $message = null, $type = 'info', $link = null)
{
    $user = User::find($toUserId);
    if (!$user) return false;

    $user->notify(new TestPushNotification($title, $message, $type, $link));
    return true;
}
