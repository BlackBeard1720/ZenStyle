<?php

use App\Http\Controllers\Staff\PaypalController;
use App\Http\Controllers\Staff\AppointmentCheckoutController;
use App\Http\Controllers\Staff\FcmTokenController;
use App\Http\Controllers\Staff\ClientController;
use App\Http\Controllers\customer\CustomerBookController;
use App\Http\Controllers\customer\CustomerBookingOtpController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Staff\AppointmentController;
use App\Http\Controllers\Staff\Auth\SessionController;
use App\Http\Controllers\Staff\CategoryController;
use App\Http\Controllers\Staff\UserController;
use App\Http\Controllers\Staff\NewsController;
use App\Http\Controllers\Staff\ServiceController;
use App\Http\Controllers\Staff\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Js;
use App\Http\Controllers\Staff\InventoryController;
use App\Http\Controllers\Staff\InventoryReportController;


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
        data: {
            url: payload.data?.url || '',
        },
    };

    self.registration.showNotification(title, options);
});

self.addEventListener('notificationclick', function(event) {
    event.notification.close();

    const notificationUrl = event.notification.data?.url || '';

    if (!notificationUrl) {
        return;
    }

    const targetUrl = new URL(notificationUrl, self.location.origin).href;

    event.waitUntil(
        clients.matchAll({
            type: 'window',
            includeUncontrolled: true,
        }).then(function(clientList) {
            for (const client of clientList) {
                if (client.url === targetUrl && 'focus' in client) {
                    return client.focus();
                }
            }

            if (clients.openWindow) {
                return clients.openWindow(targetUrl);
            }
        })
    );
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
    Route::get('/hot-trend', 'hotTrend')->name('hot-trend.index');
    Route::get('/dich-vu', 'services')->name('services');
    Route::get('/dich-vu/{slug}', 'serviceShow')->name('services.show');
    Route::get('/chinh-sach-bao-mat', 'privacyPolicy')->name('privacy-policy');
    Route::get('/dieu-khoan-su-dung', 'termsOfService')->name('terms-of-service');
    Route::get('/faq', 'faq')->name('faq');
    Route::get('/lien-he', 'contact')->name('contact');
});

Route::controller(CustomerBookController::class)->group(function () {


Route::post('/booking/send-email-otp', [CustomerBookingOtpController::class, 'send'])
    ->name('booking.send-email-otp');

    Route::get('/booking', 'create')
        ->name('booking');

    Route::post('/booking', 'store')
        ->name('booking.store');

    Route::post('/booking/cancel-otp', 'cancelOtp')
        ->name('booking.cancel-otp');

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

        // Temporary FCM test route. Remove after confirming staff notifications work.
        Route::get('/test-fcm', function (\Illuminate\Http\Request $request) {
            $fcmService = app(\App\Services\FcmService::class);
            $tokens = $request->user()->fcmTokens()->pluck('token');

            $fcmService->sendToUser(
                $request->user(),
                'Test FCM',
                'ZenStyle test notification was sent successfully.',
                ['type' => 'test']
            );

            return response()->json([
                'message' => 'Sent',
                'token_count' => $tokens->count(),
                'token_ends' => $tokens->map(fn(string $token) => substr($token, -12))->values(),
                'errors' => $fcmService->lastErrors(),
            ]);
        })->name('test-fcm');

        Route::delete('/logout', [SessionController::class, 'destroy'])->name('logout');

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/dashboard/data', [DashboardController::class, 'data'])->name('staff.dashboard.data');

        Route::get('/profile', function (Request $request) {
            $user = $request->user()->loadMissing(['role', 'staff', 'client']);

            return view('staff.profile.show', compact('user'));
        })->name('profile.show');

        Route::resource('users', UserController::class)
            ->middleware('can:manage-staff-users');

        Route::get('client-accounts', function () {
            return response()->view('staff.errors.404', [
                'code' => 404,
                'title' => 'Client Account',
                'heading' => 'COMING SOON',
                'message' => 'Client Account management is not available yet.',
            ], 404);
        })->middleware('can:manage-staff-users')->name('client-accounts.index');

        Route::resource('appointments', AppointmentController::class);

        // route for checkout
        Route::get('appointments/{appointment}/checkout', [AppointmentCheckoutController::class, 'show'])
            ->name('appointments.checkout.show');

        Route::post('appointments/{appointment}/checkout', [AppointmentCheckoutController::class, 'store'])
            ->name('appointments.checkout.store');

        Route::patch('appointments/{appointment}/confirm', [AppointmentController::class, 'confirm'])
            ->name('appointments.confirm');

        Route::patch('appointments/{appointment}/complete', [AppointmentController::class, 'complete'])
            ->name('appointments.complete');

        // route for appointment paypal payment
        Route::post('appointments/{appointment}/paypal/create-order', [AppointmentCheckoutController::class, 'createPayPalOrder'])
            ->name('appointments.paypal.create-order');

        Route::post('appointments/{appointment}/paypal/capture-order', [AppointmentCheckoutController::class, 'capturePayPalOrder'])
            ->name('appointments.paypal.capture-order');

        // cancel appointment (soft delete -> change status)
        Route::patch('appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])
            ->name('appointments.cancel');

        Route::resource('categories', CategoryController::class);
        Route::resource('services', ServiceController::class);

        Route::resource('clients', ClientController::class);

        Route::resource('news', NewsController::class)->except(['show']);

        Route::fallback(function () {
            return response()->view('staff.errors.404', [
                'code' => 404,
                'title' => '404 Page Not Found',
                'heading' => 'ERROR',
                'message' => 'We can’t seem to find the page you are looking for!',
            ], 404);
        });

        //quản lý kho hàng
        Route::get('/inventory', [InventoryController::class, 'index'])
            ->name('inventory.index');

        Route::post('/inventory/supplier', [InventoryController::class, 'storeSupplier'])
            ->name('inventory.supplier.store');

        Route::post('/inventory/product', [InventoryController::class, 'storeProduct'])
            ->name('inventory.product.store');

        Route::put('/inventory/product/{product}', [InventoryController::class, 'updateProduct'])
            ->name('inventory.product.update');

        Route::delete('/inventory/product/{product}', [InventoryController::class, 'destroyProduct'])
            ->name('inventory.product.destroy');

        Route::post('/inventory/purchase-order', [InventoryController::class, 'storePurchaseOrder'])
            ->name('inventory.purchase-order.store');

        Route::post('/inventory/{product}/use', [InventoryController::class, 'useProduct'])
            ->name('inventory.use');

        Route::post('/inventory/{product}/waste', [InventoryController::class, 'wasteProduct'])
            ->name('inventory.waste');
    });
