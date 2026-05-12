<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\UserController;
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
    // login
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    // logout
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // dashboard
    Route::get('/', function () {
        return view('staff.dashboard');
    })->name('dashboard');

    Route::resource('users', UserController::class);
});

Route::fallback(function (){
    return view('staff.404');
});
