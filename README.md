# CoinPayments API wrapper

[![Latest Stable Version](https://poser.pugx.org/elise194/easy-coinpayments/version)](https://packagist.org/packages/elise194/easy-coinpayments)
[![License](https://poser.pugx.org/elise194/easy-coinpayments/license)](https://packagist.org/packages/elise194/easy-coinpayments)

 CoinPayments API wrapper for Laravel framework
 
**Install**
 
 `composer require Elise194/easy-coinpayments`
 
**Install Service Provider**
 
 `````
 $this->app->register(Elise194\EasyCoinPayments\CoinpaymentsServiceProvider::class);
`````
 
**.env params**

`````
COINPAYMENTS_API_PUBLIC_KEY="your public api key"
COINPAYMENTS_API_PRIVATE_KEY="your private api key"
COINPAYMENTS_API_IPN_SECRET="your ipn secret"
`````
 
 **Migration**
  
Run `php artisan migrate`

**Usage**

If you want to get transaction as an object use CoinpaymentsService:

`````php
$service = new Elise194\EasyCoinPayments\Services\CoinpaymentsService();
$transaction = $service->createCoinPaymentsTransaction($amount, $currency1, $currency2, $buyerEmail);
`````

This entry from the database will be used to receive IPN callback

To get transaction info as array use simple
`````php
$coinpayments = app('coinpayments');
$responseData = $coinpayments->payment()->createTransaction(
     $amount,
     $currency1,
     $currency2,
     $buyer_email,
     $options,
     $isNeedLog
);
`````

Other functions from API are divided to sections.

Information

The main commands from "information" sections in CoinPayments documentations

````php
$coinpayments = app('coinpayments');
$coinpayments->information()->getBasicAccountInfo();
$coinpayments->information()->getExchageRates($isShort, $accepted);
```` 

Payments.

Getting callback address example:
````php
$coinpayments = app('coinpayments');
$coinpayments->payment()->getCallbackAddress($currency, $ipnUrl, $label);
```` 

The full list of functions is in the /Actions/Payment.php. It matches functions from CoinPayments methods from "Receiving payments" section in documentation.

Wallet

Example:
```php
$coinpayments = app('coinpayments');
$coinpayments->wallet()->getCoinBalances($isNeedAll);
```

The full list of functions is in the /Actions/Wallet.php. It matches functions from CoinPayments methods from "Wallet" section in documentation.
