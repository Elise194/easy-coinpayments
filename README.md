# CoinPayments API wrapper

 CoinPayments API wrapper for Laravel framework
 
**Install**
 
 `composer require Elise194/easy-coinpayments`
 
**Install Service Provider**
 
 `$this->app->register(Elise194\EasyCoinPayments\CoinpaymentsServiceProvider::class);`
 
**.env params**

`COINPAYMENTS_API_PUBLIC_KEY="your public api key"
 COINPAYMENTS_API_PRIVATE_KEY="your private api key"
 COINPAYMENTS_API_IPN_SECRET="your ipn secret"` 
 
 **Migration**
  
Run `php artisan migrate`

**Usage**

If you want to get transaction as an object use CoinpaymentsService:

` 
$service = new Elise194\EasyCoinPayments\Services\CoinpaymentsService();
$transaction = $service->createCoinPaymentsTransaction($amount, $currency1, $currency2, $buyerEmail);
`

This entry from the database will be used to receive IPN callback

To get transaction info as array use simple
` 
         $coinpayments = app('coinpayments');
         $responseData = $coinpayments->payment()->createTransaction(
             $amount,
             $currency1,
             $currency2,
             $buyer_email,
             $options,
             $isNeedLog
         );`
