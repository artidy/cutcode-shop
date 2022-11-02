<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(AuthController::class)->group(function() {
    Route::get('/login', 'index')
        ->middleware('guest')->name('login');
    Route::post('/login', 'signIn')
        ->middleware('guest')->name('signIn');
    Route::delete('/logout', 'logout')->name('logout');

    Route::get('/sign-up', 'signUp')
        ->middleware('guest')->name('signUp');
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
});

Route::get('/', HomeController::class)->name('home');
