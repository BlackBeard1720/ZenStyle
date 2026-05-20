<?php

use App\Http\Controllers\Staff\FcmTokenController;
use App\Http\Controllers\Staff\ClientController;
use App\Http\Controllers\customer\CustomerBookController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Staff\AppointmentController;
use App\Http\Controllers\Staff\Auth\SessionController;
use App\Http\Controllers\Staff\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Js;

Route::get('/firebase-messaging-sw.js', function () {
    $firebaseConfig = [
        'apiKey' => config('services.firebase.api_key'),
        'authDomain' => config('services.firebase.auth_domain'),
        'projectId' => config('services.firebase.project_id'),
        'storageBucket' => config('services.firebase.storage_bucket'),
        'messagingSenderId' => config('services.firebase.messaging_sender_id'),
        'appId' => config('services.firebase.app_id'),
    ];

    $firebaseConfigJson = Js::from($firebaseConfig);

    $javascript = <<<JS
importScripts('https://www.gstatic.com/firebasejs/10.12.4/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.12.4/firebase-messaging-compat.js');

firebase.initializeApp({$firebaseConfigJson});

const messaging = firebase.messaging();

messaging.onBackgroundMessage(function(payload) {
    const title = payload.notification?.title || 'ZenStyle Notification';
    const options = {
        body: payload.notification?.body || '',
        icon: '/favicon.ico',
    };

    self.registration.showNotification(title, options);
});
JS;

    return response($javascript, 200)
        ->header('Content-Type', 'application/javascript')
        ->header('Service-Worker-Allowed', '/');
});

// Các Route giao diện của thành viên (feature 2.2)
Route::controller(FrontendController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/home', 'home');
    Route::get('/about', 'about')->name('about');
    Route::redirect('/gioi-thieu', '/about', 301)->name('about.vi');
    Route::get('/news', 'news')->name('news');
    Route::get('/news/{slug}', 'newsShow')->name('news.show');
    Route::get('/hot-trend', 'hotTrend')->name('hot-trend.index');
    Route::get('/dich-vu', 'services')->name('services');
    Route::get('/dich-vu/{slug}', 'serviceShow')->name('services.show');
    Route::get('/chinh-sach-bao-mat', 'privacyPolicy')->name('privacy-policy');
    Route::get('/dieu-khoan-su-dung', 'termsOfService')->name('terms-of-service');
    Route::get('/faq', 'faq')->name('faq');
    Route::get('/lien-he', 'contact')->name('contact');
});

Route::controller(CustomerBookController::class)->group(function () {

    Route::get('/booking', 'create')
        ->name('booking');

    Route::post('/booking', 'store')
        ->name('booking.store');

    Route::post('/booking/verify-otp', [CustomerBookController::class, 'verifyOtp'])
        ->name('booking.verify.otp');

    Route::get('/booking/success', 'successPage')
        ->name('booking.success');

    Route::get('/booking/success/{appointment}', 'success')
        ->name('customer.booking.success');
});

// Auth staff: không dùng middleware guest vì guest dựa trên Laravel session auth.
// Staff login hiện tạo JWT và lưu vào cookie access_token.
Route::prefix('staff')->name('staff.')
    ->controller(SessionController::class)->group(function () {
        Route::get('/login', 'create')->name('login');
        Route::post('/login', 'store')->name('login.store');
    });

// Staff area: mọi route bên dưới được bảo vệ bằng JWT middleware tự viết.
Route::prefix('staff')->name('staff.')
    ->middleware('jwt.auth')->group(function () {

    Route::post('/fcm-token', [FcmTokenController::class, 'store'])
            ->name('fcm-token.store');

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
