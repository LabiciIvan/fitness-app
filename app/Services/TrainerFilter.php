<?php

namespace App\Services;

use App\Models\User;

class TrainerFilter
{
    public function get(string $filter, ?User $user)
    {
        return match ($filter) {
            'most_rated' => $this->mostRated(),
            'available'  => $this->available(),
            'trainers'   => $this->trainers($user),
            default      => $this->all(),
        };
    }

    protected function all()
    {
        return User::whereHas('types', function ($query) {
            $query->where('title', config('tables.types.trainerKey'));
        })
        ->with('types', 'profile')
        ->paginate(4);
    }

    protected function mostRated()
    {
        return $this->all(); // To do review Model and calculate rating based on that.
    }

    protected function available()
    {
        return User::whereHas('programs', function ($query) {
            $query->withCount('enrolled')
                ->havingRaw('enrolled_count < `limit`');
            })
            ->paginate(5);
    }

    protected function trainers(User $user)
    {
        return User::whereHas('programs', function ($q) use ($user) {
            $q->whereHas('enrolled', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        })->distinct()->paginate(10);
    }
}
