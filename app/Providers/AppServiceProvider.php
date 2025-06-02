<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use App\Models\Customer;


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
        Event::listen(Registered::class, function ($event) {
            $user = $event->user;
    
            if ($user->role === 'customer') {
                Customer::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'user_id' => $user->id,
                ]);
            }
        });
        }

    
}
