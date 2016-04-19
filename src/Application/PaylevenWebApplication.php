<?php


/**
 * Payleven Web Application Entity
 *
 * Used for storing/accessing information describing the current web application
 */

namespace Payleven\Application;

class PaylevenWebApplication {

    /**
     * The API key for the current application
     *
     * @var string
     */
    private $apiKey;

    /**
     * The URL scheme for the current application
     *
     * @var string
     */
    private $returnUrlScheme;

    /**
     * The app return url for the current application
     *
     * @var string
     */
    private $returnDomain;

    /**
     * The app return page for the current application
     *
     * @var string
     */
    private $returnPage;

    /**
     * The display name for the current application
     *
     * @var string
     */
    private $displayName;

    /**
     * The currency for the current application
     *
     * @var string
     */
    private $paymentCurrency;

    /**
     * PaylevenWebAppication constructor.
     * @param string $apiKey
     * @param string $returnUrlScheme
     * @param string $returnDomain
     * @param string $returnPage
     * @param string $displayName
     */
    public function __construct($apiKey, $returnUrlScheme, $returnDomain, $returnPage, $displayName, $paymentCurrency) {

        $this->apiKey = $apiKey;
        $this->returnUrlScheme = $returnUrlScheme;
        $this->returnDomain = $returnDomain;
        $this->returnPage = $returnPage;
        $this->displayName = $displayName;
        $this->paymentCurrency = $paymentCurrency;
    }

    /**
     * Get the application api key
     *
     * @return string
     */
    public function getApiKey() {
        return $this->apiKey;
    }

    /**
     * Get the application URL scheme
     *
     * @return string
     */
    public function getReturnUrlScheme() {
        return $this->returnUrlScheme;
    }

    /**
     * Get the application return domain
     *
     * @return string
     */
    public function getReturnDomain() {
        return $this->returnDomain;
    }

    /**
     * Get the application Return Page
     *
     * @return string
     */
    public function getAppReturnPage() {
        return $this->returnPage;
    }

    /**
     * Get the application display name
     *
     * @return string
     */
    public function getDisplayName() {
        return $this->displayName;
    }

    /**
     * Get the payment currency
     *
     * @return string
     */
    public function getPaymentCurrency() {
        return $this->paymentCurrency;
    }
}