<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function index() {
        $withNotifications = $this->user->load('notifications');

        return view('notifications.index', [
            'notifications' => $withNotifications['notifications'],
            'user' => $this->user
        ]);
    }
}
