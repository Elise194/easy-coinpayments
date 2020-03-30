<?php

Route::group([
    'prefix' => 'coinpayments',
], function () {
    Route::get('/callback', 'Elise194\EasyCoinPayments\Controllers\CoinpaymentsController@callback')->name('coinpayments.callback');
});
