<?php

namespace Hipster\Discount;

use Illuminate\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider
{
    public function boot()
{
    // Load routes
    $this->loadRoutesFrom(__DIR__.'/routes/web.php');

    // Load views
    $this->loadViewsFrom(__DIR__.'/../resources/views', 'discount');

    // Publish views (optional)
    $this->publishes([
        __DIR__.'/../resources/views' => resource_path('views/vendor/discount'),
    ], 'views');
}


    public function register()
    {
        // Register bindings if needed
    }
}
