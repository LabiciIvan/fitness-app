<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('is-trainer', function (User $user) {
            return $user->types->contains('title', config('tables.types.trainerKey'));
        });

        Gate::define('is-customer', function (User $user) {
            return $user->types->contains('title', config('tables.types.customerKey'));
        });

        Gate::define('is-admin', function (User $user) {
            return $user->types->contains('title', config('tables.types.adminKey'));
        });

        View::composer('*', function ($view) {
            /** @var User|null $user */
            $user = Auth::user();

            $notificationsCount = $user ? $user->unreadNotifications()->count() : 0;

            $view->with('unreadNotificationsCount', $notificationsCount);
        });
    }
}
