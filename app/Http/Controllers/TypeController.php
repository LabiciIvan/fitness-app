<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestStoreType;
use App\Models\Type;

class TypeController extends Controller
{
    public function index() {
        return view('admin.index-resource', [
            'resource' => Type::paginate(5),
            'columns'  => ['title']
        ]);
    }

    public function store(RequestStoreType $request) {

        $attributes = $request->validated();

        Type::create($attributes);

        return redirect();
    }

    public function create() {
        return view('types.create');
    }
}
