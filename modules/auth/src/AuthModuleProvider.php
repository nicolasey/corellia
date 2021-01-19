<?php
namespace Modules\Auth;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AuthModuleProvider extends ServiceProvider 
{
    protected $namespace = "Modules\Auth\Controllers";

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRoutes();
        $this->loadMigrationsFrom(__DIR__."/../database/migrations");
    }

    /**
     * Set config file
     *
     * @param string $path
     * @param string $key
     * @return void
     */
    private function setConfig($path, $key)
    {
        $this->mergeConfigFrom($path, $key);

        $this->publishes([
            $path => config_path($key.".php"),
        ], "config");
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../api.php');
        });
    }

    /**
     * Get the Nova route group configuration array.
     *
     * @return array
     */
    protected function routeConfiguration()
    {
        return [
            'namespace' => $this->namespace,
            'prefix' => 'auth',
            'middleware' => 'api',
        ];
    }
}