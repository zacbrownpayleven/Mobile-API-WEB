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
     * @var
     */
    private $apiKey;

    /**
     * The URL scheme for the current application
     *
     * @var
     */
    private $returnUrlScheme;

    /**
     * The app return url for the current application
     *
     * @var
     */
    private $returnDomain;

    /**
     * The app return page for the current application
     *
     * @var
     */
    private $returnPage;

    /**
     * The display name for the current application
     *
     * @var
     */
    private $displayName;

    /**
     * PaylevenWebAppication constructor.
     * @param $apiKey
     * @param $returnUrlScheme
     * @param $returnDomain
     * @param $returnPage
     * @param $displayName
     */
    public function __construct($apiKey, $returnUrlScheme, $returnDomain, $returnPage, $displayName) {

        $this->apiKey = $apiKey;
        $this->returnUrlScheme = $returnUrlScheme;
        $this->returnDomain = $returnDomain;
        $this->returnPage = $returnPage;
        $this->displayName = $displayName;
    }

    /**
     * Get the application API key
     *
     * @return mixed
     */
    public function getApiKey() {
        return $this->apiKey;
    }

    /**
     * Get the application URL scheme
     *
     * @return mixed
     */
    public function getReturnUrlScheme() {
        return $this->returnUrlScheme;
    }

    /**
     * Get the application return domain
     *
     * @return mixed
     */
    public function getReturnDomain() {
        return $this->returnDomain;
    }

    /**
     * Get the application Return Page
     *
     * @return mixed
     */
    public function getAppReturnPage() {
        return $this->returnPage;
    }

    /**
     * Get the application display name
     *
     * @return mixed
     */
    public function getDisplayName() {
        return $this->displayName;
    }
}