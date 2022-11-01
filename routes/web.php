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
    Route::get('/login', 'index')->name('login');
    Route::post('/login', 'signIn')->name('signIn');
    Route::delete('/logout', 'logout')->name('logout');

    Route::get('/sign-up', 'signUp')->name('signUp');
    Route::post('/sign-up', 'register')->name('register');

    Route::get('/forgot-password', 'forgotPassword')->name('forgotPassword');
    Route::get('/reset-password', 'resetPassword')->name('resetPassword');
});

Route::get('/', HomeController::class)->name('home');
