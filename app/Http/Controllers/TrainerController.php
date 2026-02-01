<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\User;
use App\Services\Search;
use App\Services\TrainerFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainerController extends Controller
{
    // public function index() {
    //     $trainers = User::whereHas('types', function ($query) {
    //         $query->where('title', config('tables.types.trainerKey'));
    //     })
    //     ->with('types', 'profile')
    //     ->paginate(4);

    //     return view('trainers.index', [
    //         'user' => Auth::user(),
    //         'trainers' => $trainers
    //     ]);
    // }

    public function index(Request $request, TrainerFilter $service) {
        $filter = $request->get('filter', 'all');

        $trainers = $service->get($filter, Auth::user());

        return view('trainers.index', [
            'user' => Auth::user(),
            'trainers' => $trainers
        ]);
    }


    public function show(User $trainer) {

        $user = Auth::user();

        $user = User::with('enrollments')->where('id', $user->id)->first();

        $enrolledPrograms = $user->enrollments()->pluck('program_id');

        $trainer = User::with(['programs' => function ($query) {
            $query->withCount('enrolled');
        }])->where('id', $trainer->id)->first();

        return view('trainers.show', [
            'user'      => Auth::user(),
            'trainer'   => $trainer,
            'enrolledPrograms'   => $enrolledPrograms,
        ]);
    }


    public function indexPrograms(Request $request) {
        $user = Auth::user();

        if ($request->has('query')) {
            $programs = (new Search)(
                \App\Models\Program::class,
                [
                    'name'      => $request->get('query'),
                    'user_id'   => $user->id,
                ],
                paginate: true
                );
        } else {
            $programs = Program::where('user_id', $user->id)->orderByDesc('created_at')->paginate(5);
        }

        $programs->load(['tags', 'categories']);

        return view('trainers.indexPrograms', [
            'user' => $user,
            'programs' => $programs
        ]);
    }


    public function indexClients() {
        $user = Auth::user();

        /** @var App\Models\User $user*/
        $user->load(['programs.programs']);

        return view('trainers.indexClients', [
            'user' => $user,
        ]);
    }
}
