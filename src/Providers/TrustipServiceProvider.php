<?php

namespace Trustip\Trustip\Providers;

use Illuminate\Support\ServiceProvider;
use Trustip\Trustip\ProxyCheck;

class TrustipServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //get the api_key from the config file
        $apiKey = config('trustip.api_key');

        // bind the ProxyCheck class to the app container
        $this->app->bind(ProxyCheck::class, function () use ($apiKey) {
            return new ProxyCheck($apiKey);
        });

        // register the facade
        $this->app->alias(ProxyCheck::class, 'trustip');

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // load the package config file
        $this->mergeConfigFrom(
            __DIR__ . '/../config/trustip.php', 'trustip'
        );

        // publish the config file
        $this->publishes([
            __DIR__ . '/../config/trustip.php' => config_path('trustip.php'),
        ], 'config');

        // load the helper function
        require_once __DIR__ . '/../Helpers/ProxyCheckHelper.php';
    }
}
