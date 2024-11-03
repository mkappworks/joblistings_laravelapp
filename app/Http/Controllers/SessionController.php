<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store()
    {
        $attributes = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (!\App\Models\User::where('email', $attributes['email'])->exists()) {
            throw ValidationException::withMessages(['email' => trans('This email does not exist in our records')]);
        }

        if (!Auth::attempt($attributes)) {
            throw ValidationException::withMessages(['password' => trans('Sorry, those credentials do not match')]);
        }

        request()->session()->regenerate();

        return redirect('/jobs');
    }

    public function destroy()
    {
        Auth::logout();

        return redirect('/');
    }
}
