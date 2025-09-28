<?php

namespace Hipster\Discount;

use Illuminate\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish the config file to the application's config directory
        $this->publishes([
            __DIR__ . '/config/discount.php' => config_path('discount.php'),
        ], 'config');
       /**
        * enable this accoring to requirements
        */
        // Load routes  
       // $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // Load views (if any)
    //    $this->loadViewsFrom(__DIR__ . '/../resources/views', 'discount');

        // Load migrations (if any)
       // $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Merge the package config with the app config
        $this->mergeConfigFrom(
            __DIR__ . '/config/discount.php',
            'discount'
        );
    }
}
