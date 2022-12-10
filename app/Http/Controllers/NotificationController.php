<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    public function markAsRead(Request $request, int $notificationId = null) {
        if (!$notificationId) {
            $request->user()->unreadNotifications->markAsRead();
        }

        $request->user()->notifications()->where('id', $notificationId)->update(['read_at' => now()]);

        // TODO
    }
}
