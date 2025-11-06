<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->whereNull('read_at')->latest()->get();

        return response()->json($notifications);
    }

    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id === Auth::id()) {
            $notification->update(['read_at' => now()]);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 403);
    }

    public function markAsUnread(Notification $notification)
    {
        if ($notification->user_id === Auth::id()) {
            $notification->update(['read_at' => null]);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 403);
    }

    public function markAllAsRead()
    {
        Auth::user()->notifications()->whereNull('read_at')->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    public function deleteNotification(Notification $notification)
    {
        if ($notification->user_id === Auth::id()) {
            $notification->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 403);
    }

    public function deleteAllNotifications()
    {
        Auth::user()->notifications()->delete();

        return response()->json(['success' => true]);
    }

    public function show()
    {
        $notifications = Auth::user()->notifications()->latest()->get();

        return view('admin.notifications.index', compact('notifications'));
    }

    public function getNotificationDetail(Notification $notification)
    {
        // Authorize that the notification belongs to the user
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        // Mark as read
        $notification->markAsRead();

        return view('admin.notifications._detail', compact('notification'));
    }
}
