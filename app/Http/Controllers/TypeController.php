<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestStoreType;
use App\Models\Type;

class TypeController extends Controller
{
    public function index() {
        return view('admin.index-resource', [
            'resource' => Type::paginate(5),
            'columns'  => ['title'],
            'controller' => 'types',
        ]);
    }

    public function show(string $id) {
        $type = Type::where('id', $id)->first();

        return view('admin.show-resource', [
            'resource' => $type,
            'columns'  => ['id', 'title'],
            'controller' => 'types',
        ]);
    }

    public function create() {
        return view('admin.create-resource', [
            'columns'     => ['title'],
            'controller'  => 'types',
        ]);
    }

    // public function store(RequestStoreType $request) {

    //     $attributes = $request->validated();

    //     Type::create($attributes);

    //     return redirect();
    // }

    public function store(array $data) {

        $type = Type::create($data);

        return $this->show($type->id);
    }

    public function edit(string $id) {
        return view('admin.edit-resource', [
            'resource'    => Type::where('id', $id)->first(),
            'columns'     => ['title'],
            'controller'  => 'types',
        ]);
    }

    public function patch(array $data, string $id) {
        Type::where('id', $id)->update($data);

        return $this->show($id);
    }

    public function delete(string $id) {
        Type::where('id', $id)->delete();

        return redirect()->route('admin.callControllerMethod', ['controller' => 'types', 'method' => 'index']);
    }
}
