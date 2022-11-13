<?php

namespace Domain\Auth\Routing;

use App\Contracts\RouteRegistrar;
use App\Http\Controllers\Auth\SignInController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

class AuthRegistrar implements RouteRegistrar
{
    public function map(Registrar $registrar): void
    {
        Route::middleware('web')->group(function () {
            Route::controller(SignInController::class)->group(function() {
                Route::get('/login', 'index')
                    ->middleware('guest')->name('login');
                Route::post('/login', 'signIn')
                    ->middleware('guest', 'throttle:auth')
                    ->name('signIn');
                Route::delete('/logout', 'logout')->name('logout');

                Route::get('/sign-up', 'signUp')
                    ->middleware('guest', 'throttle:auth')
                    ->name('signUp');
                Route::post('/sign-up', 'register')
                    ->middleware('guest')->name('register');

                Route::get('/forgot-password', 'forgot')
                    ->middleware('guest')->name('forgot');
                Route::post('/forgot-password', 'forgotPassword')
                    ->middleware('guest')->name('forgotPassword');
                Route::get('/reset-password/{token}', 'reset')
                    ->middleware('guest')->name('password.reset');
                Route::post('/reset-password', 'resetPassword')
                    ->middleware('guest')->name('resetPassword');

                Route::get('/auth/socialite/github', 'github')->name('socialite.github');
                Route::get('/auth/socialite/github/callback', 'githubCallback')->name('socialite.github.callback');
            });
        });
    }
}
