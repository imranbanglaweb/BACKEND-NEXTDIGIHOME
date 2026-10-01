<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->latest()
            ->paginate(20);

        Notification::where('user_id', auth()->id())
            ->update(['is_read' => 1]);

        return view('admin.dashboard.notifications.index', compact('notifications'));
    }

    // Return unread notifications for the current user (for dropdown)
    public function unread()
    {
        $userId = auth()->id();
        $notifications = Notification::where('user_id', $userId)
            ->where('is_read', 0)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function($n) {
                return [
                    'message' => $n->message ?? ($n->data['message'] ?? 'Notification'),
                    'time' => \Carbon\Carbon::parse($n->created_at)->diffForHumans(),
                ];
            });
        return response()->json($notifications);
    }
}
