<?php

namespace Stevensgsp\QuotesApi\Providers;

use Illuminate\Support\ServiceProvider;

class QuotesApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot()
    {
        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'quotes-api');

        // Publish Routes
        $this->publishes([
            __DIR__ . '/routes/web.php' => base_path('routes/quotes-api.php'),
        ], 'quotes-api-routes');

        // Publish UI Views
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/quotes-api'),
        ], 'quotes-api-views');

        //Publish UI assets
        $this->publishes([
            __DIR__ . '/../../public/vendor/quotes-api' => public_path('vendor/quotes-api'),
        ], 'quotes-api-ui');

        // Publish config
        $this->publishes([
            __DIR__ . '/../config/quotes.php' => config_path('quotes.php'),
        ], 'quotes-api-config');
    }

    /**
     * Register services.
     */
    public function register()
    {
        // Merge package settings with user settings
        $this->mergeConfigFrom(__DIR__ . '/../config/quotes.php', 'quotes-api');
    }
}
