<?php
namespace Modules\Forum;

use App\Traits\UsesProviderHelpers;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ForumServiceProvider extends ServiceProvider
{
    use UsesProviderHelpers;

    private $namespace = "Modules\Forum\Controllers";

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerEloquentFactoriesFrom(__DIR__."/../database/factories");
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mapApiRoutes();
        $this->loadMigrationsFrom(__DIR__."/../database/migrations");
    }

    /**
     * Add api routes in provider using standard 'api' middleware
     *
     * @return void
     */
    private function mapApiRoutes()
    {
        Route::namespace($this->namespace)
            ->middleware("api")
            ->prefix("api")
            ->group(function () {
                require __DIR__. '/../routes.php';
            });
    }
}
