<?php
namespace Modules\Personnages;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class PersonnageServiceProvider extends ServiceProvider
{
    protected $namespace = "Modules\Personnages\Http\Controllers";

    public function boot()
    {
        $this->setConfig(__DIR__."/../config.php", "personnages");
        $this->mapApiRoutes();
        $this->loadMigrationsFrom(__DIR__."/../database/migrations");
    }

    public function register()
    {
        //
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
                require __DIR__.'/../api.php';
            });
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
}