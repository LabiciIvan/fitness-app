<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestStoreUser;
use App\Models\Type;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function create() {
        return view('auth.register');
    }

    public function store(RequestStoreUser $request) {

        $attributes = $request->validated();

        $userAttributes = [
            'name'      => $attributes['name'],
            'email'     => $attributes['email'],
            'password'  => $attributes['password'],
        ];

        $user = User::create($userAttributes);

        $type = Type::where('title', $attributes['type'])->get()->pluck('id');

        $user->types()->attach($type);

        if (!Auth::attempt($userAttributes)) {
            throw ValidationException::withMessages([
                'email' => 'Sorry, these credentials don\'t match.'
            ]);
        }

        request()->session()->regenerate();

        return redirect()->route('dashboard.index');
    }
}
