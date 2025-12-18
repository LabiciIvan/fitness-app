<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestPatchProgram;
use App\Http\Requests\RequestStoreProgram;
use App\Models\Categories;
use App\Models\Program;
use App\Models\Tag;
use App\Models\User;
use App\Services\Search;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ProgramController extends Controller
{
    public function search(Request $request) {

        if (!$request->has('query')) {
            return redirect();
        }

        $user = Auth::user();

        $user = User::with('enrollments')->where('id', $user->id)->first();

        $programsEnrolled = $user->enrollments()->pluck('program_id');

        $results = (new Search())(
            \App\Models\Program::class,
            [
                'name' => $request->get('query'),
                'description' => $request->get('query'),
            ]
        );

        return view('programs.results', [
            'user' => Auth::user(),
            'query' => $request->get('query'),
            'programs' => $results,
            'programsEnrolled' => $programsEnrolled,
        ]);
    }

    public function index(Request $request) {

        $user = Auth::user();

        $user = User::with('enrollments')->where('id', $user->id)->first();

        $programsEnrolled = $user->enrollments()->pluck('program_id');

        if ($request->has('query')) {
            $programs = (new Search)(
                \App\Models\Program::class,
                [
                    'name'          => $request->get('query'),
                ],
                paginate: true
            );
        } else {
            $programs = Program::paginate(5);
        }

        return view('programs.index', [
            'user' => Auth::user(),
            'programs' => $programs,
            'programsEnrolled' => $programsEnrolled
        ]);
    }

    public function show(Program $program) {

        $program->load('user', 'reviews');

        return view('programs.show', [
            'program'   => $program,
            'user'      => Auth::user(),
        ]);
    }

    public function create() {
        return view('programs.create', [
            'user' => Auth::user(),
            'tags'  => Tag::all(),
            'categories'  => Categories::all(),
        ]);
    }

    public function store(RequestStoreProgram $request) {
        $attributes = $request->validated();
        $user = Auth::user();

        $logoName = null;

        if (Storage::disk('public')->get($user->profile->logo)) {
            Storage::disk('public')->delete($user->profile->logo);
        }

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');

            $logoName = uniqid($user->id .  '_') . '_LOCAL_STORAGE.' . $file->extension();

            Storage::disk('public')->putFileAs(
                "logos",
                $file,
                $logoName
            );
        }

        $program = Program::create([
            'user_id'       => $user->id,
            'name'          => $attributes['name'],
            'description'   => $attributes['description'],
            'price'         => $attributes['price'],
            'difficulty'    => $attributes['difficulty'],
            'limit'         => $attributes['limit'],
            'logo'          => "logos/" . $logoName
        ]);

        if (isset($attributes['tags'])) {
            $tagIds = Tag::whereIn('id', $attributes['tags'])->pluck('id');

            $program->tags()->attach($tagIds);
        }

        if (isset($attributes['category'])) {
            $categoryIds = Categories::where('title', 'LIKE', "%" . $attributes['category'] . "%")->pluck('id');

            $program->categories()->attach($categoryIds);
        }

        return redirect()->route('trainers.index.programs');
    }

    public function edit(Program $program) {

        return view('programs.edit', [
            'user' => Auth::user(),
            'tags'  => Tag::all(),
            'program' => $program->load(['tags', 'categories']),
        ]);
    }

    public function patch(RequestPatchProgram $request, Program $program) {
        $attributes = $request->validated();

        $program->update($attributes);

        $program->load(['tags']);

        $tags = $request->has('tags') ? json_decode($request->get('tags')) : null;

        $category = $request->has('category') ? Categories::where('title', 'LIKE', "%" . $request->get('category') . "%")->pluck('id') : null;

        if ($tags) {
            $program->tags()->sync($tags);
        }

        if ($category) {
            $program->categories()->sync($category);
        }

        return redirect()->route('programs.edit', $program);
    }

    public function destroy(Program $program) {

        if (Storage::disk('public')->get($program->logo)) {
            Storage::disk('public')->delete($program->logo);
        }

        $program->delete();

        if (Gate::authorize('is-trainer')) {
            return redirect()->route('trainers.index.programs');
        }

        return redirect()->route('programs.index');
    }
}
