<?php

namespace Elise194\EasyCoinPayments;

use Illuminate\Support\ServiceProvider;

/**
 * Class CoinpaymentsServiceProvider
 * @package Elise194\EasyCoinPayments
 */
class CoinpaymentsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Elise194\EasyCoinPayments\Controllers\CoinpaymentsController');
//        $configPath = __DIR__.'Config/coinpayments.php';
//        $this->mergeConfigFrom($configPath, 'coinpayments');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__.'/routes.php';
        $this->loadMigrationsFrom(__DIR__.'/path/to/migrations');

        // Publish a config file
//        $configPath = __DIR__.'/Config/coinpayments.php';
//        $this->publishes([
//            $configPath => config_path('coinpayments.php'),
//        ], 'config');
    }
}
