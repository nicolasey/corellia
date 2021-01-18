<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Factories\Factory as EloquentFactory;

trait UsesProviderHelpers
{
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