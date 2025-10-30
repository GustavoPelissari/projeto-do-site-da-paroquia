<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
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
        // Register Blade directives for dashboard helper
        Blade::directive('userDashboard', function () {
            return "<?php echo App\Helpers\DashboardHelper::getUserDashboardRoute(); ?>";
        });

        Blade::directive('userAreaLabel', function () {
            return "<?php echo App\Helpers\DashboardHelper::getUserAreaLabel(); ?>";
        });
    }
}
