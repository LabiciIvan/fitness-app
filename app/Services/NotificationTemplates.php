<?php

namespace App\Services;

class NotificationTemplates {

    public const TEMPLATES = [
        'program.enrolled' => [
            'message' => ':user enrolled in your program ":program".',
            'route'   => 'programs.show',
        ],

        'program.unsubscribed' => [
            'message' => ':user unsubscribed from your program ":program".',
            'route'   => 'programs.show',
        ],

        'program.unsubscribed.self' => [
            'message' => 'You\'ve unsubscribed from program ":program".',
            'route'   => 'programs.show',
        ],

        'program.reminder' => [
            'message' => 'Your enrollment in ":program" starts today.',
            'route'   => 'programs.show',
        ],

        'trainer.followed' => [
            'message' => ':user started following you.',
            'route'   => 'trainers.show',
        ],
    ];
}
