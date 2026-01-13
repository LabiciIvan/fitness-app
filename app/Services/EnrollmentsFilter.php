<?php

namespace App\Services;

use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;


class EnrollmentsFilter {

    public function get(string $filer, User $user) {

        return match ($filer) {
            'available'     => $this->availableEnrollments($user),
             default        => $this->all($user),
        };
    }

    protected function availableEnrollments(User $user) {
        return Program::whereDoesntHave('enrolled', function (Builder $query) use ($user) {
                $query->where('users.id', $user->id);
            })
            ->with('enrolled')
            ->distinct('programs.id')
            ->paginate(10);
    }

    protected function all(User $user) {
        return Program::paginate(5);
    }

}
