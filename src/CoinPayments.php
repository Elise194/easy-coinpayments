<?php

namespace Elise194\EasyCoinPayments;

use Elise194\EasyCoinPayments\Actions\Information;
use Elise194\EasyCoinPayments\Actions\Payment;
use Elise194\EasyCoinPayments\Actions\Wallet;
use Elise194\EasyCoinPayments\Request\ApiRequest;

/**
 * Class CoinPayments
 * @package Elise194\EasyCoinPayments
 */
class CoinPayments
{
    public $request;

    public $wallet;
    public $information;
    public $payment;

    /**
     * CoinPayments constructor.
     */
    public function __construct()
    {
        $this->request = new ApiRequest(
            'fc1aa7cd945d0d62583d2f04ccbc473475828754c919645e2cd67a07eca16ed8',
            '3a09E710E3a49d62D29d70f774b888F5e8D402b788d7BEaF33B5f1Cb9dcC8C59',
            config('ipnSecret')
        );
    }

    /**
     * @return Wallet
     */
    public function wallet(): Wallet
    {
        if (!$this->wallet) {
            $this->wallet = new Wallet($this->request);
        }

        return $this->wallet;
    }

    /**
     * @return Information
     */
    public function information(): Information
    {
        if (!$this->information) {
            $this->information = new Information($this->request);
        }

        return $this->information;
    }

    /**
     * @return Payment
     */
    public function payment(): Payment
    {
        if (!$this->payment) {
            $this->payment = new Payment($this->request);
        }

        return $this->payment;
    }
}
