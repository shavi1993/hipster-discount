<?php

namespace Hipster\Discount;

use Illuminate\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/discount.php', 'discount');
    }

    
    public function boot()
{
    // Only keep migrations + views
    $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    $this->loadViewsFrom(__DIR__.'/../resources/views', 'discount');
}



    public function provides()
    {
        return [DiscountManager::class];
    }
}
