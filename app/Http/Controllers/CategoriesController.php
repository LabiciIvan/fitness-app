<?php

namespace App\Http\Controllers;

use App\Models\Categories;

class CategoriesController extends Controller
{
    public function index() {
        return view('admin.index-resource', [
            'resource'   => Categories::paginate(5),
            'columns'    => ['id', 'title', 'description'],
            'controller' => 'categories',
        ]);
    }

    public function show(string $id) {
        $category = Categories::where('id', $id)->first();

        return view('admin.show-resource', [
            'resource'   => $category,
            'columns'    => ['id', 'title', 'description'],
            'controller' => 'categories',
        ]);
    }

    public function create() {
        return view('admin.create-resource', [
            'columns'     => ['title', 'description'],
            'controller'  => 'categories',
        ]);
    }

    public function store(array $data) {
        $category = Categories::create($data);

        return $this->show($category->id);
    }

    public function edit(string $id) {
        return view('admin.edit-resource', [
            'resource'    => Categories::where('id', $id)->first(),
            'columns'     => ['title', 'description'],
            'controller'  => 'categories',
        ]);
    }

    public function patch(array $data, string $id) {
        Categories::where('id', $id)->update($data);

        return $this->show($id);
    }

    public function delete(string $id) {
        Categories::where('id', $id)->delete();

        return redirect()->route('admin.callControllerMethod', ['controller' => 'categories', 'method' => 'index']);
    }
}
