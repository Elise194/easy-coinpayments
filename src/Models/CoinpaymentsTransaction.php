<?php

namespace Elise194\EasyCoinPayments\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CoinpaymentsTransaction
 * @package Elise194\EasyCoinPayments\Models
 */
class CoinpaymentsTransaction extends Model
{
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
    ];
}
