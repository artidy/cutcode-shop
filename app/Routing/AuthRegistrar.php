<?php

namespace App\Routing;

use App\Contracts\RouteRegistrar;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\Auth\SocialAuthController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

class AuthRegistrar implements RouteRegistrar
{
    public function map(Registrar $registrar): void
    {
        Route::middleware('web')->group(function () {
            Route::controller(SignInController::class)->group(function() {
                Route::get('/login', 'page')
                    ->middleware('guest')->name('login');
                Route::post('/login', 'handle')
                    ->middleware('guest', 'throttle:auth')
                    ->name('login.handle');
                Route::delete('/logout', 'logout')->name('logout');
            });

            Route::controller(SignUpController::class)->group(function() {
                Route::get('/sign-up', 'page')
                    ->middleware('guest', 'throttle:auth')
                    ->name('register');
                Route::post('/sign-up', 'handle')
                    ->middleware('guest')->name('register.handle');
            });

            Route::controller(ForgotPasswordController::class)->group(function() {
                Route::get('/forgot-password', 'page')
                    ->middleware('guest')->name('forgot-password');
                Route::post('/forgot-password', 'handle')
                    ->middleware('guest')->name('forgot-password.handle');
            });

            Route::controller(ResetPasswordController::class)->group(function() {
                Route::get('/reset-password', 'page')
                    ->middleware('guest')->name('reset-password');
                Route::post('/reset-password', 'handle')
                    ->middleware('guest')->name('password.reset');
            });

            Route::controller(SocialAuthController::class)->group(function() {
                Route::get('/auth/socialite/{driver}', 'redirect')->name('socialite.redirect');
                Route::get('/auth/socialite/{driver}/callback', 'callback')->name('socialite.callback');
            });
        });
    }
}
