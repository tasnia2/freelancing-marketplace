<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->latest()->paginate(20);
        $unreadCount = Auth::user()->unreadNotificationsCount();
        
        return view('dashboard.notifications', compact('notifications', 'unreadCount'));
    }
    
    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }
        
        $notification->markAsRead();
        
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->back();
    }
    
    public function markAllAsRead()
    {
        Auth::user()->notifications()->unread()->update(['read' => true]);
        
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->back();
    }
    
    public function unreadCount()
    {
        $count = Auth::user()->unreadNotificationsCount();
        
        return response()->json(['count' => $count]);
    }
}