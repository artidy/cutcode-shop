<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignInFormRequest;
use Illuminate\Http\RedirectResponse;

class SignInController extends Controller
{
    public function page()
    {
        return view('auth.index');
    }

    public function handle(SignInFormRequest $request): RedirectResponse
    {
        if (!auth()->attempt($request->validated())) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }
}
