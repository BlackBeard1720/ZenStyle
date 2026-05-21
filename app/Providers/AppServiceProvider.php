<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Các Gate này nhận User từ Laravel Auth resolver.
        // JwtAuthMiddleware đã set Auth::setUser($user), nên middleware can vẫn hoạt động với JWT.
        Gate::define('manage-staff-users', function (User $user) {
            return $user->hasRole('admin');
        });

        Gate::define('view-appointments', function (User $user) {
            return $user->hasRole('admin')
                || $user->hasRole('receptionist')
                || $user->hasRole('stylist');
        });

        Gate::define('manage-appointments', function (User $user) {
            return $user->hasRole('admin')
                || $user->hasRole('receptionist');
        });

        Gate::define('cancel-appointments', function (User $user) {
            return $user->hasRole('admin')
                || $user->hasRole('receptionist');
        });

        Gate::define('view-services', function (User $user) {
            return $user->hasRole('admin')
                || $user->hasRole('receptionist')
                || $user->hasRole('stylist');
        });

        Gate::define('manage-services', function (User $user) {
            return $user->hasRole('admin');
        });
    }
}
