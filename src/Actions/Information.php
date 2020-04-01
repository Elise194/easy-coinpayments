<?php

namespace Elise194\EasyCoinPayments\Actions;

use Elise194\EasyCoinPayments\Request\ApiRequest;

/**
 * Class Information
 * Basic information commands.
 * @package Elise194\EasyCoinPayments\Actions
 */
class Information
{
    /**
     * @var ApiRequest
     */
    private $request;

    /**
     * Information constructor.
     *
     * @param ApiRequest $request
     */
    public function __construct(ApiRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Get Basic Account Information.
     *
     * @param bool $isNeedLog
     * @return string
     * @throws \Exception
     */
    public function getBasicAccountInfo(bool $isNeedLog = false)
    {
        $requestData = [
            'cmd' => 'get_basic_info',
        ];

        return $this->request->request(
            ApiRequest::METHOD_POST,
            $requestData,
            $isNeedLog
        );
    }

    /**
     * Exchange Rates / Coin List.
     *
     * @param bool $isShort - If set to 1, the response won't include the full coin names and number of confirms needed
     * to save bandwidth
     * @param int|null $accepted - If set to 1, the response will include if you have the coin enabled for acceptance
     * on your Coin Acceptance Settings page. If set to 2, the response will include all fiat coins but only
     * cryptocurrencies enabled for acceptance on your Coin Acceptance Settings page
     * @param bool $isNeedLog
     * @return string
     * @throws \Exception
     */
    public function getExchageRates(bool $isShort = false, int $accepted = null, bool $isNeedLog = false)
    {
        if (!is_null($accepted) && ($accepted !== 1 || $accepted !== 2)) {
            throw new \Exception('"Accepted" must be 1 or 2');
        }

        $requestData = [
            'cmd' => 'rates',
        ];

        if ($isShort) {
            $requestData['short'] = 1;
        }

        return $this->request->request(
            ApiRequest::METHOD_POST,
            $requestData,
            $isNeedLog
        );
    }
}
