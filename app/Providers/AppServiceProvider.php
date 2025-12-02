<?php

namespace App\Providers;

use Carbon\Carbon;
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
        // Configurar Carbon para português brasileiro
        Carbon::setLocale('pt_BR');
        setlocale(LC_TIME, 'pt_BR.utf8', 'pt_BR', 'Portuguese_Brazil');
        
        // Register Blade directives for dashboard helper
        Blade::directive('userDashboard', function () {
            return "<?php echo App\Helpers\DashboardHelper::getUserDashboardRoute(); ?>";
        });

        Blade::directive('userAreaLabel', function () {
            return "<?php echo App\Helpers\DashboardHelper::getUserAreaLabel(); ?>";
        });
    }
}
