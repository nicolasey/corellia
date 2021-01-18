<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Factory as EloquentFactory;

trait UsesProviderHelpers
{
    /**
     * Register factories.
     *
     * @param  string  $path
     * @return void
     */
    protected function registerEloquentFactoriesFrom($path)
    {
        $this->app->make(EloquentFactory::class)->load($path);
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

        $this->mapApiRoutes();
    }
}