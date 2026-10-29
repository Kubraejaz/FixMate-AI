<?php

namespace App\Providers;

use App\Notifications\Channels\SmsChannel;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;
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
        Notification::extend('sms', fn ($app) => new SmsChannel);

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('api-auth', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        // -----------------------------------------------------------
        // Authorization & Role / Permission Gates
        // -----------------------------------------------------------
        \Illuminate\Support\Facades\Gate::before(function (\App\Models\User $user, string $ability) {
            if ($user->isAdmin()) {
                return true;
            }
            return null;
        });

        \Illuminate\Support\Facades\Gate::define('admin', fn (\App\Models\User $user) => $user->isAdmin());
        \Illuminate\Support\Facades\Gate::define('customer', fn (\App\Models\User $user) => $user->isCustomer());
        \Illuminate\Support\Facades\Gate::define('technician', fn (\App\Models\User $user) => $user->isTechnician());
        \Illuminate\Support\Facades\Gate::define('verified-technician', fn (\App\Models\User $user) => $user->isTechnician() && (bool) ($user->professional?->is_verified ?? false));
        \Illuminate\Support\Facades\Gate::define('pro-technician', fn (\App\Models\User $user) => $user->isTechnician() && (bool) ($user->professional?->isPro() ?? false));
        \Illuminate\Support\Facades\Gate::define('vip-customer', fn (\App\Models\User $user) => $user->isCustomer() && $user->isVip());

        // Dynamic granular permission evaluation
        \Illuminate\Support\Facades\Gate::define('permission', fn (\App\Models\User $user, string $permission) => $user->hasPermission($permission));
    }
}
