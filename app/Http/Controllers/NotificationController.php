<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    public function markAsRead(Request $request, string $notificationUuid = null) {
        if (!$notificationUuid) {
            $request->user()->unreadNotifications->markAsRead();
        } else {
            $request->user()->notifications()->where('id', $notificationUuid)->update(['read_at' => now()]);
        }

        return redirect()->back();
    }
}
