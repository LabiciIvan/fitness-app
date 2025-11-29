<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function index() {
        // enrollments - table used for all programs in which customer enrolled.
        // programs    - table of trainer which contains has it's own programs.
        /** @var \App\Models\User $user */
        $user = Auth::user();

        return view('enrollments.index', [
            'user' => $user->load(['enrollments'])
        ]);
    }

    public function store(Program $program) {

        $user = Auth::user();

        $user = User::with('enrollments')->where('id', $user->id)->first();

        $user->enrollments()->attach($program->id);

        return redirect()->route('enrollments.index');
    }


    public function destroy(Program $program) {
        $user = Auth::user();

        $user = User::with('enrollments')->where('id', $user->id)->first();

        $user->enrollments()->detach($program->id);
        
        return redirect()->route('enrollments.index');
    }
}
