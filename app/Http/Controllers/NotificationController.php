<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return view('notifications.index', [
            'notifications' => $user->notifications,
            'unread' => $user->unreadNotifications,
        ]);
    }

    public function markAllRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();
        $request->user()->notifications()->delete();
        return back()->with('success', 'All notifications marked as read!');
    }

    public function destroy($id, Request $request)
    {
        $notification = $request->user()->notifications()->findOrFail($id);
        $notification->delete();

        return back()->with('success', 'Notification deleted!');
    }
}
