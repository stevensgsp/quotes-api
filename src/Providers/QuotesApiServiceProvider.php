<?php

namespace Stevensgsp\QuotesApi\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * This service provider is responsible for registering and bootstrapping the
 * package's services, including routes, views, assets, and configuration.
 * It allows the package to integrate seamlessly with a Laravel application.
 *
 * @author Steven Sucre <steven.g.s.p@gmail.com>
 * @version March 20, 2025
 */
class QuotesApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'quotes');

        // Publish Routes
        $this->publishes([
            __DIR__ . '/../routes/web.php' => base_path('routes/quotes-api.php'),
        ], 'quotes-api-routes');

        // Publish UI Views
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/quotes-api'),
        ], 'quotes-api-views');

        //Publish UI assets
        $this->publishes([
            __DIR__ . '/../../dist' => public_path('vendor/quotes-api'),
        ], 'quotes-api-ui');

        // Publish config
        $this->publishes([
            __DIR__ . '/../config/quotes.php' => config_path('quotes.php'),
        ], 'quotes-api-config');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Merge package settings with user settings
        $this->mergeConfigFrom(__DIR__ . '/../config/quotes.php', 'quotes-api');
    }
}
