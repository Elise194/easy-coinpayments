<?php

namespace Elise194\EasyCoinPayments\Request;

use GuzzleHttp\Client;

/**
 * Class ApiRequest
 * @package Elise194\EasyCoinPayments\Request
 */
class ApiRequest
{
    const
        METHOD_GET = 'GET',
        METHOD_POST = 'POST';

    public
        $baseUrl = 'https://www.coinpayments.net/api.php',
        $publicApiKey,
        $privateApiKey,
        $ipnSecret;

    private $httpClient;

    /**
     * ApiRequest constructor.
     *
     * @param $publicApiKey
     * @param $privateApiKey
     * @param $ipnSecret
     * @param null $baseUrl
     */
    public function __construct($publicApiKey, $privateApiKey, $ipnSecret, $baseUrl = null)
    {
        $this->publicApiKey = $publicApiKey;
        $this->privateApiKey = $privateApiKey;
        $this->ipnSecret = $ipnSecret;

        if ($baseUrl) {
            $this->baseUrl = $baseUrl;
        }

        $this->httpClient = $this->getHttpClient();
    }

    /**
     * @return Client
     */
    public function getHttpClient()
    {
        if (!is_object($this->httpClient)) {
            $this->httpClient = new Client($this->defaultHttpClientConfig());
        }

        return $this->httpClient;
    }

    /**
     * @param $method
     * @param array $data
     * @param bool $needLog
     * @return string
     * @throws \Exception
     */
    public function request($method, array $data, bool $needLog = false)
    {
        $fullData = array_merge($this->defaultRequestData(), $data);
        $rowData = http_build_query($fullData);
        $headers = $this->generateHeaders($rowData);

        try {
            $response = $this->httpClient->request($method, '', [
                'headers' => $headers,
                'body' => $rowData
            ]);

            return $response->getBody()->getContents();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @return array
     */
    protected function defaultHttpClientConfig(): array
    {
        return [
            'base_uri' => $this->baseUrl
        ];
    }

    /**
     * @return array
     */
    private function defaultRequestData(): array
    {
        return [
            'version' => 1,
            'key' => $this->publicApiKey,
            'format' => 'json'
        ];
    }

    /**
     * @param string $data
     * @return array
     */
    private function generateHeaders(string $data): array
    {
        return [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'HMAC' => hash_hmac('sha512', $data, $this->privateApiKey)
        ];
    }
}
