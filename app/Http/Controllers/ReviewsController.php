<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Reviews;
use App\Http\Requests\RequestStoreReview;
use Illuminate\Support\Facades\Auth;

class ReviewsController extends Controller
{
    public function store(RequestStoreReview $request, Program $program) {

        $user = Auth::user();

        Reviews::create([
            'content'       => $request->attribute('content'),
            'rating'        => $request->attribute('rating'),
            'program_id'    => $program->id,
            'user_id'       => $user->id,
        ]);

        return redirect()->route('programs.show', ['program' => $program]);
    }

    public function delete(Reviews $review, Program $program) {
        $review->delete();

        return redirect()->route('programs.show', ['program' => $program->id]);
    }
}
