<?php

namespace Elise194\EasyCoinPayments;

use Illuminate\Support\ServiceProvider;

/**
 * Class CoinpaymentsServiceProvider.
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
        $this->app->singleton('coinpayments', function () {
            return new CoinPayments();
        });
        $this->app->make('Elise194\EasyCoinPayments\Controllers\CoinpaymentsController');
        $this->mergeConfigFrom(
            __DIR__ . '/Config/coinpayments.php', 'coinpayments'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__.'/routes.php';
        $this->loadMigrationsFrom(__DIR__ . '/Database');
        $this->publishes([__DIR__ . '/Config/coinpayments.php' => base_path('config/' . 'coinpayments.php')]);
    }
}
