<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Helpers\DashboardHelper;

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
