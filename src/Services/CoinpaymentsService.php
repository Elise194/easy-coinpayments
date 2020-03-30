<?php

namespace Elise194\EasyCoinPayments\Services;

class CoinpaymentsService
{
    public function processingCallback(array $post, $hmac)
    {
        $coinComponent = \Yii::$app->coinPayments;
        if (!hash_equals($hmac, hash_hmac("sha512", http_build_query($data), $coinComponent->ipnSecret))) {
            throw new Exception('IPN is wrong');
        }

        /** @var CoinPaymentsTransaction $transaction */
        $transaction = CoinPaymentsTransaction::find()->where(['txn_id' => $data['txn_id']])->one();
        $transaction->api_status = $data['status'];
        $transaction->api_status_text = $data['status_text'];
        $transaction->amount_paid = $data['amount2'];
        $transaction->addHistory();

        if (!$transaction->save()) {
            \Yii::error(implode($transaction->firstErrors));
        }
    }
}
