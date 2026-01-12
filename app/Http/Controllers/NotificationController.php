<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function index() {

        /** @var App\Models\User  $user  */
        $user = Auth::user();

        $notifications = $user->load('notifications');

        return view('notifications.index', [
            'notifications' => $notifications['notifications']
        ]);
    }
}
