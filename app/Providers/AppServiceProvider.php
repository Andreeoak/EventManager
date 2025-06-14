<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;

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
        /*
        Gate::define('update-event', function (User $user, Event $event){
            return $user->id === $event->user_id;
        });

        Gate::define('delete-attendee', function (User $user, Event $event, Attendee $attendee){
            return $user->id === $event->user_id || $user->id === $attendee->user_id;
        });
        */ // <------Trocamos por Policies

        RateLimiter::for ('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
