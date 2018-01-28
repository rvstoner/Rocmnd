<?php

namespace App\Providers;

use App\User;
use App\Observers\UserObserver;
use App\Models\Payroll\TimePunch;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
      User::observe(UserObserver::class);
      TimePunch::observe(TimePunchObserver::class);
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}