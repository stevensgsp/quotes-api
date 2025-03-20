<?php

namespace Stevensgsp\QuotesApi\Providers;

use Illuminate\Support\ServiceProvider;

class QuotesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot()
    {
        // Publish config
        $this->publishes([
            __DIR__ . '/../config/quotes.php' => config_path('quotes.php'),
        ], 'config');

        // Publish UI
        $this->publishes([
            __DIR__.'/../resources/js/dist' => public_path('vendor/quotes-package'),
        ], 'quotes-ui');

        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'quotesapi');
    }

    /**
     * Registrar servicios (se ejecuta antes que boot).
     */
    public function register()
    {
        // Fusionar configuración del paquete con la del usuario
        $this->mergeConfigFrom(__DIR__ . '/../config/quotes.php', 'quotesapi');
    }
}
