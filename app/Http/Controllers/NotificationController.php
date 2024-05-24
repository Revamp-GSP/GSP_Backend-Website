<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function getNotifications(Request $request)
    {
        // Ensure authenticated user
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        // Get notifications for authenticated user
        $limit = $request->has('limit') ? intval($request->limit) : 10;
        $notifications = $user->notifications()->orderBy('created_at', 'desc')->paginate($limit);

        // Mark unread notifications as read
        $unreadNotifications = $user->unreadNotifications;
        if ($unreadNotifications->isNotEmpty()) {
            $unreadNotifications->markAsRead();
        }

        // Return JSON response with paginated notifications
        return response()->json($notifications);
    }
    public function getAllNotifications(Request $request)
    {
        // Define the limit for pagination
        $limit = $request->has('limit') ? intval($request->limit) : 10;

        // Initialize the query
        $query = DatabaseNotification::query();

        // Filter by user ID if provided
        if ($request->has('user_id')) {
            $query->where('notifiable_id', $request->user_id);
        }

        // Get notifications, paginated
        $notifications = $query->orderBy('created_at', 'desc')->paginate($limit);

        // Return JSON response with paginated notifications
        return response()->json($notifications);
    }
}
