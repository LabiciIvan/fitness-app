<?php

namespace App\Policies;

use App\Models\Program;
use App\Models\Reviews;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ReviewsPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
    }

    public function create(User $user, Program $program): bool {
        return false; // TODO replies to review.
    }

    public function delete(User $user, Reviews $review): bool {
        return $user->id === $review->user_id;
    }

}

