<?php


use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
/*
|--------------------------------------------------------------------------
| Khu vực khách hàng (public)
|--------------------------------------------------------------------------
| - Tên route luôn có tiền tố client.* để gom nhóm và dùng trong Blade:
|   route('client.home'), route('client.booking.create'), ...
| - Mặc định: / = trang chủ, /dat-lich = đặt lịch (sau này thay closure bằng controller).
|
| Nếu muốn MỌI URL khách nằm dưới một segment (ví dụ /zenstyle, /zenstyle/dat-lich):
|   Route::prefix('zenstyle')->name('client.')->group(function () {
|       Route::get('/', [ClientHomeController::class, 'index'])->name('home');
|       ...
|   });
|   Route::redirect('/', '/zenstyle'); // hoặc giữ / là landing tuỳ chiến lược SEO
|--------------------------------------------------------------------------
*/


Route::controller(FrontendController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/about', 'about')->name('about');
    Route::get('/news', 'news')->name('news');
//    Route::get('/contact', 'contact')->name('contact');
});

Route::prefix('staff')->name('staff.')->group(function () {
    Route::get('/', function () {
        return view('staff.dashboard');
    })->name('dashboard');
    Route::resource('users', UserController::class);
});
