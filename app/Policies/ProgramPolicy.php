<?php

namespace App\Policies;

use App\Models\Program;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Log;

class ProgramPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->types->contains('title', config('tables.types.trainerKey'));
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Program $program): bool
    {
        return false;
    }

    public function createReviewForProgram(User $user, Program $program): bool {
        return $program->enrolled()->where('user_id', $user->id)->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->types->contains('title', config('tables.types.trainerKey'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Program $program): bool
    {
        if ($user->types->contains('title', config('tables.types.trainerKey')) && $program->user_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Program $program): bool
    {
        if ($user->types->contains('title', config('tables.types.trainerKey')) || $user->id === $program->user_id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Program $program): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Program $program): bool
    {
        return false;
    }

    public function deleteProgramEnrollment(User $user, Program $program): bool {
        // Only user can unsubscribe from programs enrolled.
        foreach ($user->enrollments as $programEnrolled) {
            if ($programEnrolled->pivot->program_id === $program->id) {
                return true;
            }
        }
        
        return false;
    }

    public function enrollIntoProgram(User $user, Program $program): bool {
        return $user->types->contains('title', config('tables.types.customerKey'));
    }
}
