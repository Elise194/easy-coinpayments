<?php

namespace Elise194\EasyCoinPayments\Services;

use Elise194\EasyCoinPayments\CoinPayments;
use Elise194\EasyCoinPayments\Models\CoinpaymentsTransaction;

class CoinpaymentsService
{
    /**
     * @param int $amount
     * @param string $currency1
     * @param string $currency2
     * @param string $buyer_email
     * @param array $options
     * @param bool $isNeedLog
     * @return CoinpaymentsTransaction
     * @throws \Exception
     */
    public function createCoinPaymentsTransaction(
        float $amount,
        string $currency1,
        string $currency2,
        string $buyer_email,
        array $options = [],
        bool $isNeedLog = false
    ) {
        /** @var CoinPayments $coinpayments */
        $coinpayments = app('coinpayments');
        $responseData = $coinpayments->payment()->createTransaction(
            $amount,
            $currency1,
            $currency2,
            $buyer_email,
            $options,
            $isNeedLog
        );

        $responseResult = $responseData['result'];
        $transactionData = [
            'address' => $responseResult['address'],
            'amount' => $responseResult['amount'],
            'txn_id' => $responseResult['txn_id'],
            'confirms_needed' => $responseResult['confirms_needed'],
            'timeout' => $responseResult['timeout'],
            'checkout_url' => $responseResult['checkout_url'],
            'status_url' => $responseResult['status_url'],
            'qrcode_url' => $responseResult['qrcode_url'],
        ];

        if (isset($responseResult['dest_tag'])) {
            $transactionData['dest_tag'] = $responseResult['dest_tag'];
        };

        $transaction = new CoinpaymentsTransaction($transactionData);
        $transaction->save();

        return $transaction;
    }

    public function processingCallback(array $post, $hmac)
    {
        /** @var CoinPayments $coinpayments */
        $coinpayments = app('coinpayments');

        if (!hash_equals($hmac, hash_hmac('sha512', http_build_query($post), $coinpayments->request->ipnSecret))) {
            throw new \Exception('IPN is wrong');
        }

        /** @var CoinpaymentsTransaction $transaction */
        $transaction = CoinpaymentsTransaction::where('txn_id', $post['txn_id'])->firstOrFail();
        $transaction->update([
            'api_status' => $post['status'],
            'api_status_text' => $post['status_text'],
            'amount2' => $post['amount2'],
            'status_history' => $post['amount2'],
        ]);

        $transaction->addHistory();
    }
}
