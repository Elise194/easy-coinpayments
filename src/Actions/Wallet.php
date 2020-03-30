<?php

namespace Elise194\EasyCoinPayments\Actions;

use Elise194\EasyCoinPayments\Request\ApiRequest;

/**
 * Class Wallet
 * Class for wallet methods
 * @package Elise194\EasyCoinPayments\Actions
 */
class Wallet
{
    /**
     * @var ApiRequest
     */
    private $request;

    /**
     * Wallet constructor.
     *
     * @param ApiRequest $request
     */
    public function __construct(ApiRequest $request) {
        $this->request = $request;
    }

    /**
     * Coin Balances
     *
     * @param bool $isNeedAll - If set to true, the response will include all coins, even those with a 0 balance
     * @param bool $isNeedLog
     * @return string
     * @throws \Exception
     */
    public function getCoinBalances(bool $isNeedAll = false, bool $isNeedLog = false)
    {
        $requestData = [
            'cmd' => 'balances'
        ];

        if ($isNeedAll) {
            $requestData['all'] = 1;
        }

        return $this->request->request(
            ApiRequest::METHOD_POST,
            $requestData,
            $isNeedLog
        );
    }

    /**
     * Addresses returned by this API are for personal use deposits and reuse the same personal address(es)
     * in your wallet. Deposits to these addresses don't send IPNs.
     *
     * @param string $currency - The currency the buyer will be sending
     * @param bool $isNeedLog
     * @return string
     * @throws \Exception
     */
    public function getDepositAddress(string $currency, bool $isNeedLog = false)
    {
        $requestData = [
            'cmd' => 'get_deposit_address',
            'currency' => $currency
        ];

        return $this->request->request(
            ApiRequest::METHOD_GET,
            $requestData,
            $isNeedLog
        );
    }

    /**
     * Create Transfer
     * Transfers are performed as internal coin transfers/accounting entries when possible.
     * For coins not supporting that ability a withdrawal is created instead.
     *
     * @param int $amount - The amount of the transfer in the currency below
     * @param string $currency - The cryptocurrency to withdraw. (BTC, LTC, etc.)
     * @param int|null $merchant - The merchant ID to send the funds to (not a username)
     * @param string|null $pbntag - The $PayByName tag to send the funds to
     * @param bool $auto_confirm - If set to true, withdrawal will complete without email confirmation
     * @param string|null $note - This lets you set the note for the withdrawal
     * @param bool $isNeedLog
     * @return string
     * @throws \Exception
     */
    public function createTransfer(
        int $amount,
        string $currency,
        int $merchant = null,
        string $pbntag = null,
        bool $auto_confirm = false,
        string $note = null,
        bool $isNeedLog = false
    ) {
        if (!$merchant && !$pbntag) {
            throw new \Exception('PayByName tag OR merchant must be specified');
        }

        $requestData = [
            'cmd' => 'create_transfer',
            'amount' => $amount,
            'currency' => $currency,
        ];

        if (!is_null($merchant)) {
            $requestData['merchant'] = $merchant;
        } else {
            $requestData['pbntag'] = $pbntag;
        }

        if ($auto_confirm) {
            $requestData['auto_confirm'] = 1;
        }

        return $this->request->request(
            ApiRequest::METHOD_POST,
            $requestData,
            $isNeedLog
        );
    }

    /**
     * Creating withdrawal.
     *
     * @param int $amount - The amount of the withdrawal in the currency below
     * @param string $currency - The cryptocurrency to withdraw. (BTC, LTC, etc.)
     * @param string|null $address - The address to send the funds to, either this OR pbntag must be specified
     * @param string|null $pbntag - The $PayByName tag to send the withdrawal to
     * @param array $options
     *     @option bool $add_tx_fee - If set to true, add the coin TX fee to the withdrawal amount so the sender
     *                                pays the TX fee instead of the receiver
     *     @option string $currency2 - currency to use to to withdraw 'amount' worth of 'currency2' in 'currency' coin
     *     @option string $dest_tag - The extra tag to use for the withdrawal for coins that need it
     *     @option string $ipn_url - URL for your IPN callbacks. If not set it will use value from settings
     *     @option bool $auto_confirm - If set to true, withdrawal will complete without email confirmation
     *     @option string $note - This lets you set the note for the withdrawal
     * @param bool $isNeedLog
     * @return string
     * @throws \Exception
     */
    public function createWithdrawal(
        int $amount,
        string $currency,
        string $address = null,
        string $pbntag = null,
        array $options = [],
        bool $isNeedLog = false
    ) {
        if (!$address && !$pbntag) {
            throw new \Exception('PayByName tag OR address must be specified');
        }

        $requestData = [
            'cmd' => 'create_withdrawal',
            'amount' => $amount,
            'currency' => $currency,
        ];

        foreach ($options as $option => $value) {
            $requestData[$option] = $value;
        }

        return $this->request->request(
            ApiRequest::METHOD_POST,
            $requestData,
            $isNeedLog
        );
    }

    /**
     * Convert Coins.
     *
     * @param int $amount - The amount convert in the 'from' currency below
     * @param string $from - The cryptocurrency in your Coin Wallet to convert from. (BTC, LTC, etc.)
     * @param string $to - The cryptocurrency to convert to. (BTC, LTC, etc.)
     * @param string|null $address - The address to send the funds to. If blank the coins will go to your Wallet.
     * @param string|null $dest_tag - The destination tag to use for the withdrawal (for Ripple.)
     *                                If 'address' is not included this has no effect.
     * @param bool $isNeedLog
     * @return string
     * @throws \Exception
     */
    public function convertCoins(
        int $amount,
        string $from,
        string $to,
        string $address = null,
        string $dest_tag = null,
        bool $isNeedLog = false
    ) {
        $requestData = [
            'cmd' => 'convert',
            'amount' => $amount,
            'from' => $from,
            'to' => $to,
        ];

        if ($address) {
            $requestData['address'] = $address;
        }

        if ($dest_tag) {
            $requestData['dest_tag'] = $dest_tag;
        }

        return $this->request->request(
            ApiRequest::METHOD_POST,
            $requestData,
            $isNeedLog
        );
    }

    /**
     * Get Conversion Limits.
     *
     * @param string $from - The cryptocurrency to convert from. (BTC, LTC, etc.)
     * @param string $to - The cryptocurrency to convert to. (BTC, LTC, etc.)
     * @param bool $isNeedLog
     * @return string
     * @throws \Exception
     */
    public function conversionLimits(string $from, string $to, bool $isNeedLog = false)
    {
        $requestData = [
            'cmd' => 'convert_limits',
            'from' => $from,
            'to' => $to,
        ];

        return $this->request->request(
            ApiRequest::METHOD_POST,
            $requestData,
            $isNeedLog
        );
    }

    /**
     * Get Withdrawal History.
     *
     * @param array $options
     *     @option int $limit - The maximum number of withdrawals to return from 1-100. (default: 25)
     *     @option int $start - What withdrawals # to start from (default: 0, starts with your newest withdrawals.)
     *     @option int $newer - Return withdrawals submitted at the given Unix timestamp or later. (default: 0)
     * @param bool $isNeedLog
     * @return string
     * @throws \Exception
     */
    public function getWithdrawalHistory(array $options = [], bool $isNeedLog = false)
    {
        $requestData = [
            'cmd' => 'get_withdrawal_history',
        ];

        foreach ($options as $option => $value) {
            $requestData[$option] = $value;
        }

        return $this->request->request(
            ApiRequest::METHOD_POST,
            $requestData,
            $isNeedLog
        );
    }

    /**
     * Get Withdrawal Information.
     *
     * @param int $id - The withdrawal ID to query
     * @param bool $isNeedLog
     * @return string
     * @throws \Exception
     */
    public function getWithdrawalInfo(int $id, bool $isNeedLog = false)
    {
        $requestData = [
            'cmd' => 'get_withdrawal_info',
            'id' => $id
        ];

        return $this->request->request(
            ApiRequest::METHOD_POST,
            $requestData,
            $isNeedLog
        );
    }

    /**
     * Get Conversion Information.
     *
     * @param int $id - The conversion ID to query.
     * @param bool $isNeedLog
     * @return string
     * @throws \Exception
     */
    public function getConversionInformation(int $id, bool $isNeedLog = false)
    {
        $requestData = [
            'cmd' => 'get_conversion_info',
            'id' => $id
        ];

        return $this->request->request(
            ApiRequest::METHOD_POST,
            $requestData,
            $isNeedLog
        );
    }
}
