<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index() {
        return view('admin.index-resource', [
            'resource'    => Tag::paginate(5),
            'columns'     => ['id', 'tag'],
            'controller'  => 'tags',
        ]);
    }

    public function show(string $id) {
        $tag = Tag::where('id', $id)->first();

        return view('admin.show-resource', [
            'resource'    => $tag,
            'columns'     => ['id', 'tag'],
            'controller'  => 'tags',
        ]);
    }

    public function create() {
        return view('admin.create-resource', [
            'columns'     => ['tag'],
            'controller'  => 'tags',
        ]);
    }

    public function store(array $data) {
        $tag = Tag::create($data);

        return $this->show($tag->id);
    }

    public function edit(string $id) {
        return view('admin.edit-resource', [
            'resource'    => Tag::where('id', $id)->first(),
            'columns'     => ['tag'],
            'controller'  => 'tags',
        ]);
    }

    public function patch(array $data, string $id) {
        Tag::where('id', $id)->update($data);

        return $this->show($id);
    }

    public function delete(string $id) {
        Tag::where('id', $id)->delete();

        return redirect()->route('admin.callControllerMethod', ['controller' => 'tags', 'method' => 'index']);
    }

}
