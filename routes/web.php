<?php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(FrontendController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/home', 'home');
    Route::get('/about', 'about')->name('about');
    Route::get('/news', 'news')->name('news');
});
Route::view('/booking', 'frontend.booking.index')->name('booking');

Route::prefix('staff')->name('staff.')->group(function () {
    Route::get('/', function () {
        return view('staff.dashboard');
    })->name('dashboard');

    Route::resource('users', UserController::class);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});



