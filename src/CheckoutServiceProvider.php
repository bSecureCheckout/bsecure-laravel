<?php

namespace bSecure\UniversalCheckout;

use Illuminate\Support\ServiceProvider;

class CheckoutServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     * The register() function is used to bind our package to the classes inside the app container.
     * @return void0
     */
    public function register()
    {
        $this->app->bind("bSecure_facade", function(){
            return new BsecureCheckout();
        });

    }

    /**
     * Bootstrap services.
     *  The boot() function is used to initialize some routes or add an event listener
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom( resource_path('lang/vendor/bSecure'),'bSecure');


        if ($this->app->runningInConsole()) {

            $this->publishes([
              __DIR__.'/config/config.php' => config_path('bSecure.php'),
            ], 'config');

            $this->publishes([
              __DIR__.'/lang/en/messages.php' => resource_path('lang/vendor/bSecure/en/messages.php'),
            ]);
        }
    }
}
