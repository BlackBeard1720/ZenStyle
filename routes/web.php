<?php

use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Staff\AppointmentController;
use App\Http\Controllers\Staff\Auth\SessionController;
use App\Http\Controllers\Staff\ClientController;
use App\Http\Controllers\Staff\UserController;
use Illuminate\Support\Facades\Route;

// Các Route giao diện của thành viên (feature 2.2)
Route::controller(FrontendController::class)->group(function () {
    // mở trang chủ
    Route::get('/', 'home')->name('home');
    // mở trang chủ bằng đường dẫn /home
    Route::get('/home', 'home');
    // mở trang giới thiệu
    Route::get('/about', 'about')->name('about');
    // mở trang danh sách tin tức
    Route::get('/news', 'news')->name('news');
    // mở trang chi tiết tin tức
    Route::get('/news/{slug}', 'newsShow')->name('news.show');
    // mở trang chính sách bảo mật
    Route::get('/chinh-sach-bao-mat', 'privacyPolicy')->name('privacy-policy');
    // mở trang điều khoản sử dụng
    Route::get('/dieu-khoan-su-dung', 'termsOfService')->name('terms-of-service');
    // mở trang liên hệ
    Route::get('/lien-he', 'contact')->name('contact');
});

// mở trang đặt lịch
Route::view('/booking', 'frontend.booking.index')->name('booking');

// Admin/Staff
Route::prefix('staff')->name('staff.')->middleware('guest')
    ->controller(SessionController::class)->group(function () {
        // mở trang đăng nhập nhân viên
        Route::get('/login', 'create')->name('login');
        // xử lý đăng nhập nhân viên
        Route::post('/login', 'store')->name('login.store');
    });

Route::prefix('staff')->name('staff.')
    ->middleware('auth')->group(function () {
    // xử lý đăng xuất nhân viên
    Route::delete('/logout', [SessionController::class, 'destroy'])->name('logout');

    // mở trang dashboard nhân viên
    Route::get('/', function () {
        return view('staff.dashboard.index');
    })->name('dashboard');

    // quản lý tài khoản nhân viên
    Route::resource('users', UserController::class)
        ->middleware('can:manage-staff-users');

    Route::resource('clients', ClientController::class);

    // mở trang checkout
    Route::get('appointments/{appointment}/checkout}', [AppointmentController::class, 'show'])
        ->middleware('can:manage-appointments')
        ->name('appointments.checkout');

    // submit thanh toán
    Route::post('appointments/{appointment}/checkout}', [AppointmentController::class, 'store'])
        ->middleware('can:manage-appointments')
        ->name('appointments.checkout.store');

    // mở trang danh sách lịch hẹn
    Route::get('appointments', [AppointmentController::class, 'index'])
        ->middleware('can:view-appointments')
        ->name('appointments.index');

    // mở trang tạo lịch hẹn
    Route::get('appointments/create', [AppointmentController::class, 'create'])
        ->middleware('can:manage-appointments')
        ->name('appointments.create');

    // lưu lịch hẹn mới
    Route::post('appointments', [AppointmentController::class, 'store'])
        ->middleware('can:manage-appointments')
        ->name('appointments.store');

    // mở trang sửa lịch hẹn
    Route::get('appointments/{appointment}/edit', [AppointmentController::class, 'edit'])
        ->middleware('can:manage-appointments')
        ->name('appointments.edit');

    // cập nhật lịch hẹn bằng PUT
    Route::put('appointments/{appointment}', [AppointmentController::class, 'update'])
        ->middleware('can:manage-appointments')
        ->name('appointments.update');

    // cập nhật lịch hẹn bằng PATCH
    Route::patch('appointments/{appointment}', [AppointmentController::class, 'update'])
        ->middleware('can:manage-appointments');

    // xóa lịch hẹn
    Route::delete('appointments/{appointment}', [AppointmentController::class, 'destroy'])
        ->middleware('can:manage-appointments')
        ->name('appointments.destroy');

    // hủy lịch hẹn
    Route::patch('appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])
        ->middleware('can:cancel-appointments')
        ->name('appointments.cancel');

    // mở trang chi tiết lịch hẹn
    Route::get('appointments/{appointment}', [AppointmentController::class, 'show'])
        ->middleware('can:view-appointments')
        ->name('appointments.show');

    // hiển thị trang lỗi 404 trong khu vực nhân viên
    Route::fallback(function (){
        return response()->view('staff.errors.404', [
            'code' => 404,
            'title' => '404 Page Not Found',
            'heading' => 'ERROR',
            'message' => 'We can’t seem to find the page you are looking for!',
        ], 404);
    });
});
