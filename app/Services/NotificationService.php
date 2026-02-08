<?php

namespace App\Services;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class NotificationService {
    public static function notify(
        int $userId,
        string $type,
        array $data = [],
        ?Model $notifiable = null
    ): void {
        if (!isset(NotificationTemplates::TEMPLATES[$type])) {
            return;
        }

        Notification::create([
            'user_id'         => $userId,
            'type'            => $type,
            'data'            => $data,
            'notifiable_type' => $notifiable->getMorphClass(),
            'notifiable_id'   => $notifiable->getKey(),
        ]);
    }
}
