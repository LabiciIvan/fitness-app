<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index() {
        return view('admin.index-resource', [
            'resource' => User::paginate(10),
            'columns'  => ['id', 'name', 'email', 'email_verified_at'],
            'controller' => 'users',
        ]);
    }

    public function show(string $id) {
        $users = User::where('id', $id)->first();

        return view('admin.show-resource', [
            'resource' => $users,
            'columns'  => ['id', 'name', 'email', 'email_verified_at', 'created_at'],
            'controller' => 'users',
        ]);
    }

    public function create() {
        return view('admin.create-resource', [
            'columns'     => ['name', 'email', 'password'],
            'controller'  => 'users',
        ]);
    }

    public function edit(string $id) {
        return view('admin.edit-resource', [
            'resource'    => User::where('id', $id)->first(),
            'columns'     => ['name'],
            'controller'  => 'users',
        ]);
    }

    public function store(array $data) {
        $user = User::create($data);

        return $this->show($user->id);
    }

    public function patch(array $data, string $id) {
        User::where('id', $id)->update($data);

        return $this->show($id);
    }

    public function delete(string $id) {
        User::where('id', $id)->delete();

        return redirect()->route('admin.callControllerMethod', ['controller' => 'users', 'method' => 'index']);
    }
}
