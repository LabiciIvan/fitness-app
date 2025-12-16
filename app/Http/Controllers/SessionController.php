<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestLoginUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create() {
        return view('auth.login');
    }

    public function store(RequestLoginUser $request) {

        $attributes = $request->validated();

        if (!Auth::attempt($attributes)) {
            throw ValidationException::withMessages([
                'email' => 'Sorry, these credentials don\'t match.'
            ]);
        }

        request()->session()->regenerate();

        return redirect()->route('dashboard.index', ['user' => Auth::user()]);
    }

    public function destroy() {

        Auth::logout();

        return redirect('/');
    }

}
