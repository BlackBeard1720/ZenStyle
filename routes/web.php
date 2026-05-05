<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend.welcome');
});

Route::fallback(function (){
    return view('staff.404');
});

Route::prefix('staff')->name('staff.')->group(function () {
    //login
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    //logout
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    //dashboard
    Route::get('/', function () {
        return view('staff.dashboard');
    })->name('dashboard');
    Route::resource('users', UserController::class);
});
