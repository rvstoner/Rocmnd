<?php

namespace App\Providers;

use Gate;
use App\Models\Payroll\{Team};

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class TeamsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Team::get()->map(function ($team){
        //     Gate::define($team->ip_address, function ($user) use ($team) {

        //     });
        // });


        Blade::directive('IPallowed', function () {
            return '<?php if (auth()->user()->IPallowed()): ?>';
        });

        Blade::directive('endIPallowed', function () {
            return '<?php endif; ?>';
        });
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
