<?php

namespace App\View\Components;

use Closure;
use App\Models\User;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FiltersPanel extends Component
{
    public ?User $user = null;

    public array $config = [
        'customer' => [
            'resource' => [
                [
                    'header' => 'Trainers',
                    'routes' => [
                        [
                            'path' => 'trainers.index',
                            'params' => ['filter' => 'all'],
                            'inner' => 'All trainers',
                        ],
                        [
                            'path' => 'trainers.index',
                            'params' => ['filter' => 'most_rated'],
                            'inner' => 'Most rated trainer',
                        ],
                        [
                            'path' => 'trainers.index',
                            'params' => ['filter' => 'available'],
                            'inner' => 'Available trainers',
                        ],
                        [
                            'path' => 'trainers.index',
                            'params' => ['filter' => 'trainers'],
                            'inner' => 'Trainers from programs you\'re enrolled',
                        ],
                    ]
                ],
                [
                    'header' => 'Programs',
                    'routes' => [
                        [
                            'path' => 'enrollments.index',
                            'params' => ['filter' => 'trainers'],
                            'inner' => '',
                        ],
                        [
                            'path' => 'programs.index',
                            'params' => [],
                            'inner' => 'All programs'
                        ],
                        [
                            'path' => 'programs.index',
                            'params' => ['filter' => 'available'],
                            'inner' => 'Available enrollments',
                        ],
                    ]
                ]
            ]
        ],
        'admin' => [
            'resource' => [
                [
                    'header' => 'Create',
                    'routes' => [
                        [
                            'path' => 'admin.callControllerMethod',
                            'params' => ['controller' => 'types', 'method' => 'create'],
                            'inner' => 'Tags'
                        ],
                        [
                            'path' => 'admin.callControllerMethod',
                            'params' => ['controller' => 'tags', 'method' => 'create'],
                            'inner' => 'Tags'
                        ],
                        [
                            'path' => 'admin.callControllerMethod',
                            'params' => ['controller' => 'users', 'method' => 'create'],
                            'inner' => 'Users'
                        ],
                        [
                            'path' => 'admin.callControllerMethod',
                            'params' => [['controller' => 'categories', 'method' => 'create']],
                            'inner' => 'Categories'
                        ],
                    ]
                ],
                [
                    'header' => 'View',
                    'routes' => [
                        [
                            'path' => 'admin.callControllerMethod',
                            'params' => ['controller' => 'tags', 'method' => 'index'],
                            'inner' => 'Tags',
                        ],
                        [
                            'path' => 'admin.callControllerMethod',
                            'params' =>  ['controller' => 'types', 'method' => 'index'],
                            'inner' => 'Types',
                        ],
                        [
                            'path' => 'admin.callControllerMethod',
                            'params' => ['controller' => 'users', 'method' => 'index'],
                            'inner' => 'Users',
                        ],
                        [
                            'path' => 'admin.callControllerMethod',
                            'params' => ['controller' => 'categories', 'method' => 'index'],
                            'inner' => 'Categories',
                        ]
                    ]
                ]
            ]
        ],
        'trainer' => [
            'resource'  => [
                [
                    'header' => 'Create',
                    'routes' => [
                        [
                            'path' => 'programs.create',
                            'params' => '',
                            'inner' => 'Create programs',
                        ]
                    ]
                ],
                [
                    'header' => 'View',
                    'routes' => [
                        [
                            'path' => 'trainers.index.programs',
                            'params' => '',
                            'inner' => 'My programs',
                        ]
                    ]
                ]
            ]
        ]
    ];

    public array $userConfig = [];

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->user = Auth::user();


        $types = $this->user->types()->first();
        Log::debug('--------type------');
        Log::debug($types);
        Log::debug('--------type------');
        
        $this->userConfig = $this->config[$this->user->types()->first()['title']] ?? null;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.filters-panel');
    }
}
