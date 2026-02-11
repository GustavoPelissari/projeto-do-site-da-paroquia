<?php

namespace App\Providers;

use App\Models\Event;
use App\Models\Group;
use App\Models\News;
use App\Policies\EventPolicy;
use App\Policies\GroupPolicy;
use App\Policies\NewsPolicy;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Event::class => EventPolicy::class,
        News::class => NewsPolicy::class,
        Group::class => GroupPolicy::class,
    ];

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
        // Register policies
        Gate::guessPoliciesForModels();

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
