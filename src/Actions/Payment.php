<?php

namespace Elise194\EasyCoinPayments\Actions;

use Elise194\EasyCoinPayments\Request\ApiRequest;

/**
 * Methods for receiving payments
 *
 * Class Payment
 * @package Elise194\EasyCoinPayments\Actions
 */
class Payment
{
    /**
     * @var ApiRequest
     */
    private $request;

    /**
     * Payment constructor.
     *
     * @param ApiRequest $request
     */
    public function __construct(ApiRequest $request) {
        $this->request = $request;
    }

    /**
     * @param int $amount - The amount of the transaction in the original currency (currency1 below)
     * @param string $currency1 - The original currency of the transaction
     * @param string $currency2 - The currency the buyer will be sending
     * @param string $buyer_email - Set the buyer's email address
     * @param array $options - optional fields
     *        @option string $address - Optionally set the address to send the funds to
     *        @option string $buyer_name - Optionally set the buyer's name for your reference
     *        @option string $item_name - Item name for your reference, will be on the payment information page
     *        @option int $item_number - Item number for your reference
     *        @option string $invoice - Another field for your use, will be on the payment information page
     *        @option string $custom - Another field for your use, will be on the payment information page
     *        @option string $ipn_url - URL for your IPN callbacks. If not set it will use the IPN URL in your
     *                                  Edit Settings page if you have one set
     *        @option string $success_url - Sets a URL to go to if the buyer does complete payment
     *        @option string $cancel_url - Sets a URL to go to if the buyer does not complete payment
     * @param bool $isNeedLog
     * @return string
     * @throws \Exception
     */
    public function createTransaction(
        int $amount,
        string $currency1,
        string $currency2,
        string $buyer_email,
        array $options = [],
        bool $isNeedLog = false
    ) {
        $requestData = [
            'cmd' => 'create_transaction',
            'amount' => $amount,
            'currency1' => $currency1,
            'currency2' => $currency2,
            'buyer_email' => $buyer_email,
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
     * Get Callback Address
     *
     * @param string $currency - The currency the buyer will be sending
     * @param string|null $ipnUrl - URL for your IPN callbacks.
     *                              If not set it will use the IPN URL in your Edit Settings page if you have one set
     * @param string|null $label - Optionally sets the address label
     * @param bool $isNeedLog
     * @return string
     * @throws \Exception
     */
    public function getCallbackAddress(
        string $currency,
        string $ipnUrl = null,
        string $label = null,
        bool $isNeedLog = false
    ) {
        $requestData = [
            'cmd' => 'get_callback_address',
            'currency' => $currency,
        ];

        if ($ipnUrl) {
            $requestData['ipn_url'] = $ipnUrl;
        }

        if ($label) {
            $requestData['label'] = $label;
        }

        return $this->request->request(
            ApiRequest::METHOD_POST,
            $requestData,
            $isNeedLog
        );
    }

    /**
     * Get Transaction Information
     *
     * @param bool $isMultiple - if set to true lets you get information about up to 25 transactions
     * @param string $txId - for single transaction: The transaction ID to query (API key must belong to the seller.)
     *                     - for multiple: up to 25 transaction ID(s) separated with a | (pipe symbol)
     * @param bool $isFull - Set to true to also include the raw checkout and shipping data for the payment if available
     * @param bool $isNeedLog
     * @return string
     * @throws \Exception
     */
    public function getTXInfo(bool $isMultiple, string $txId, bool $isFull = false, bool $isNeedLog = false)
    {
        $operation = $isMultiple ? 'get_tx_info_multi' : 'get_tx_info';
        $requestData = [
            'cmd' => $operation,
            'txid' => $txId,
        ];

        if ($isFull) {
            $requestData['full'] = 1;
        }

        return $this->request->request(
            ApiRequest::METHOD_POST,
            $requestData,
            $isNeedLog
        );
    }

    /**
     * Get Transaction IDs
     *
     * @param array $options - optional fields
     *      @option int $limit - The maximum number of transaction IDs to return from 1-100. (default: 25)
     *      @option int $start - What transaction # to start from (for iteration/pagination)
     *                          (default: 0, starts with your newest transactions)
     *      @option int $newer - Return transactions started at the given Unix timestamp or later. (default: 0)
     *      @option int $all - By default return an array of TX IDs where you are the seller for
     *                         use with get_tx_info_multi or get_tx_info. If all is set to 1 returns an array with
     *                         TX IDs and whether you are the seller or buyer for the transaction.
     * @param bool $isNeedLog
     * @return string
     * @throws \Exception
     */
    public function getTXList(array $options,  bool $isNeedLog = false)
    {
        $requestData = [
            'cmd' => 'get_tx_ids'
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
}
