<?php

namespace bSecure\UniversalCheckout;

use Illuminate\Support\ServiceProvider;

class SSOServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     * The register() function is used to bind our package to the classes inside the app container.
     * @return void
     */
    public function register()
    {
        $this->app->bind("sso_facade", function(){
            return new BsecureSSO();
        });
    }

    /**
     * Bootstrap services.
     *  The boot() function is used to initialize some routes or add an event listener
     * @return void
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */

        $this->loadTranslationsFrom( __DIR__.('./resources/lang/'),'bSecure');

        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'universal-checkout');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {

            $this->publishes([
              __DIR__.'/config/config.php' => config_path('bSecure.php'),
            ], 'config');


            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/universal-checkout'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/universal-checkout'),
            ], 'assets');*/

            // Publishing the translation files.
            $this->publishes([
              __DIR__.'/resources/lang' => resource_path('lang/vendor/bSecure'),
            ],'lang');

            // Registering package commands.
            // $this->commands([]);
        }

    }
}
