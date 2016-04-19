<?php

namespace Payleven\RequestBuilder;

use Payleven\Security\PaylevenHmacCalculator;

class PaylevenRequestBuilder {

    /**
     * The base request url
     */
    const BASE_REQUEST_URL = 'paylevenweb://payleven/';

    /**
     * The current version of the mobile API
     */
    const MOBILE_API_VERSION = '1.2';

    /**
     * Delimination character for query
     */
    const QUERY_DELIMINATOR = '&';

    /**
     * The action endpoint (payment, refund)
     *
     * @var string
     */
    protected $actionEndpoint;

    /**
     * The hmac calculation for the request
     *
     * @var string
     */
    private $calculatedHmac;

    /**
     * The encoded body for the current request
     *
     * @var string
     */
    private $encodedQueryParameters;

    /**
     * The api key to be used for hmac calculation
     *
     * @var string
     */
    private $apiKey;

    /**
     * Initiate the request builder for request
     *
     * @param string $action
     * @param array $queryParams
     */
    public function initiateRequest($action, array $queryParams = []) {

        $this->actionEndpoint = strtolower($action);
        $this->apiKey = $queryParams['api_key'];
        $this->encodedQueryParameters = $this->buildRequestQuery($queryParams);
    }

    /**
     * Build the request URL
     */
    public function buildRequestUrl() {

        $hmacCalculator = new PaylevenHmacCalculator();
        $calculatedHmac = $hmacCalculator->calculateHmac($this->apiKey, $this->encodedQueryParameters);

        return self::BASE_REQUEST_URL.$this->actionEndpoint.'/'.$calculatedHmac.'?'.$this->encodedQueryParameters;
    }

    /**
     * Build the request query
     *
     * @param array $queryParameters
     * @return string
     */
    public function buildRequestQuery(array $queryParameters) {

        $finalQuery = '';

        foreach($queryParameters as $key => $value) {
            $finalQuery .= $key.'='.$value.self::QUERY_DELIMINATOR;
        }

        return rawurlencode($finalQuery);
    }
}