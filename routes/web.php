<?php

use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Staff\Auth\SessionController;
use App\Http\Controllers\Staff\ClientController;
use App\Http\Controllers\Staff\UserController;
use Illuminate\Support\Facades\Route;

// Các Route giao diện của thành viên (feature 2.2)
Route::controller(FrontendController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/home', 'home');
    Route::get('/about', 'about')->name('about');
    Route::get('/news', 'news')->name('news');
    Route::get('/news/{slug}', 'newsShow')->name('news.show');
    Route::get('/chinh-sach-bao-mat', 'privacyPolicy')->name('privacy-policy');
    Route::get('/dieu-khoan-su-dung', 'termsOfService')->name('terms-of-service');
    Route::get('/lien-he', 'contact')->name('contact');
});

Route::view('/booking', 'frontend.booking.index')->name('booking');

// Các Route hệ thống/quản trị của bạn (HEAD)
Route::prefix('staff')->name('staff.')->group(function () {
    // auth
    Route::controller(SessionController::class)->group(function () {
       Route::get('/login', 'create')->name('login');
       Route::post('/login', 'store')->name('login.store');
       Route::delete('/logout', 'destroy')->name('logout');
    });

    // dashboard
    Route::get('/', function () {
        return view('staff.dashboard.index');
    })->name('dashboard');

    Route::resource('users', UserController::class);
});

Route::fallback(function (){
    return view('staff.errors.404');
});

Route::prefix('staff')->name('staff.')->group(function () {
   Route::resource('clients', ClientController::class);
   Route::resource('users', UserController::class);
});
