<?php

use App\Http\Controllers\Staff\ClientController;
use App\Http\Controllers\customer\CustomerBookController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Staff\AppointmentController;
use App\Http\Controllers\Staff\Auth\SessionController;
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

Route::controller(CustomerBookController::class)->group(function () {

    Route::get('/booking', 'create')
        ->name('booking');

    Route::post('/booking', 'store')
        ->name('booking.store');

    Route::post('/booking/verify-otp', [CustomerBookController::class, 'verifyOtp'])
        ->name('booking.verify.otp');

    Route::get('/booking/success/{appointment}', 'success')
        ->name('customer.booking.success');
});
// Admin/Staff
Route::prefix('staff')->name('staff.')->middleware('guest')
    ->controller(SessionController::class)->group(function () {
        Route::get('/login', 'create')->name('login');
        Route::post('/login', 'store')->name('login.store');
    });

Route::prefix('staff')->name('staff.')
    ->middleware('auth')->group(function () {
    Route::delete('/logout', [SessionController::class, 'destroy'])->name('logout');

    Route::get('/', function () {
        return view('staff.dashboard.index');
    })->name('dashboard');

    Route::resource('users', UserController::class)
        ->middleware('can:manage-staff-users');

    Route::resource('appointments', AppointmentController::class);
    Route::patch('appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])
        ->name('appointments.cancel');

    Route::resource('clients', ClientController::class);

    Route::fallback(function (){
        return response()->view('staff.errors.404', [
            'code' => 404,
            'title' => '404 Page Not Found',
            'heading' => 'ERROR',
            'message' => 'We can’t seem to find the page you are looking for!',
        ], 404);
    });
});