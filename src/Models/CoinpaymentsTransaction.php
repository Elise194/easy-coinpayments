<?php

namespace Elise194\EasyCoinPayments\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CoinpaymentsTransaction.
 * @package Elise194\EasyCoinPayments\Models
 */
class CoinpaymentsTransaction extends Model
{
    //STATUSES
    const
        STATUS_PAY_PAL_REFUND = -2, //PayPal Refund or Reversal
        STATUS_CANCELLED_TIME_OUT = -1, //Cancelled / Timed Out
        STATUS_WAITING = 0, //Waiting for buyer funds
        STATUS_CONFIRMED_COIN_RECEPTION = 1, //We have confirmed coin reception from the buyer
        STATUS_QUEUED_NIGHTLY_PAYOUT = 2, //Queued for nightly payout
        STATUS_PAY_PAL_PENDING = 3, //PayPal Pending (eChecks or other types of holds)
        STATUS_PAYMENT_COMPLETE = 100; //Payment Complete. We have sent your coins to your payment address

    protected $_statusHistoryArrayData;

    /**
     * @var array
     */
    protected $fillable = [
        'txn_id',
        'amount',
        'address',
        'dest_tag',
        'confirms_needed',
        'timeout',
        'checkout_url',
        'status_url',
        'qrcode_url',
        'api_status',
        'api_status_text',
        'amount2',
        'status_history',
    ];

    /**
     * @return mixed
     */
    public function getStatusHistoryAsArray()
    {
        if (is_null($this->_statusHistoryArrayData)) {
            $this->_statusHistoryArrayData = json_decode($this->status_history);
        }

        return (array) $this->_statusHistoryArrayData;
    }

    /**
     * @param array $data
     */
    public function setStatusHistoryAsArray(array $data = [])
    {
        $this->_statusHistoryArrayData = null;
        $this->status_history = json_encode($data);
    }

    /**
     * Update status history.
     */
    public function addHistory()
    {
        $statusHistoryAsArray = $this->getStatusHistoryAsArray();
        $statusHistoryAsArray = array_merge($statusHistoryAsArray, [$this->api_status]);
    }
}
