<?php

namespace Payleven\Security;

/**
 * Payleven HmacCalculator Entity
 *
 * Used for calculating and validating hmac for requests
 */

class PaylevenHmacCalculator {

    /**
     * The hashing algorithm to use when calculating the hmac
     */
    const HMAC_HASH_ALGORITHM = 'SHA256';

    /**
     * Calculate the HMAC for the request
     *
     * @param $applicationApiKey
     * @param $requestBody
     * @return string
     */
    public function calculateHmac($applicationApiKey, $requestBody) {
        return hash_hmac(self::HMAC_HASH_ALGORITHM, $requestBody, $applicationApiKey);
    }

    /**
     * Validate the hmac returned by the API
     *
     * @param $applicationApiKey
     * @param $responseCalculation
     * @param $responseBody
     * @return bool
     */
    public function ValidateHmac($applicationApiKey, $responseCalculation, $responseBody) {

        if($this->calculateHmac($applicationApiKey, $responseBody) == $responseCalculation) {
            return true;
        } else {
            return false;
        }

    }
}