<?php
/**
 * The Payleven Mobile API SDK for PHP v2
 * @author Zac Brown - zac.brown@payleven.de
 *
 * @docs https://github.com/payleven/Mobile-API-WEB
 */

namespace Payleven;

use Payleven\Application\PaylevenWebApplication;
use Payleven\RequestBuilder\PaylevenRequestBuilder;
use Payleven\Exception\PaylevenMissingConfigException;
use Payleven\Security\PaylevenHmacCalculator;

class Payleven {

    /**
     * The token to be used for calculation when a login has been cancelled
     */
    const CANCELLED_LOGIN_TOKEN = 'vKqmpnwrad3N';


    /**
     * The current web application entity
     *
     * @var PaylevenWebApplication
     */
    private $webApplication;

    /**
     * The Payleven request builder object
     *
     * @var PaylevenRequestBuilder
     */
    private $requestBuilder;

    /**
     * The current request url
     *
     * @var string
     */
    private $requestUrl;

    /**
     * @param array $config
     * @throws PaylevenMissingConfigException
     */
    public function __construct(array $config = []) {

        if(empty($config)) {
            throw new PaylevenMissingConfigException('Instantiation requires configurable options.');
        }

        if(empty($config['api_key'])) {
            throw new PaylevenMissingConfigException('The API key is required for all library interaction');
        }

        if(empty($config['return_domain'])) {
            throw new PaylevenMissingConfigException('The return domain is required for all library indertaction');
        }

        if(empty($config['return_page'])) {
            throw new PaylevenMissingConfigException('The return page is required for all library interaction');
        }

        if(empty($config['display_name'])) {
            throw new PaylevenMissingConfigException('The display name is required for all library interaction');
        }

        if(empty($config['payment_currency'])) {
            throw new PaylevenMissingConfigException('The payment currency is required for all library interaction');
        }

        $this->webApplication = new PaylevenWebApplication(
            $config['api_key'],
            $config['return_scheme'],
            $config['return_domain'],
            $config['return_page'],
            $config['display_name'],
            $config['payment_currency']
        );

        $this->requestBuilder = new PaylevenRequestBuilder();

    }

    /**
     * Start a payment with the Payleven app
     *
     * @param $paymentPrice
     * @param $orderId
     * @param $orderDescription
     * @return string
     * @throws PaylevenMissingConfigException
     */
    public function startPayment($paymentPrice, $orderId, $orderDescription) {

        if(empty($paymentPrice) || !is_numeric($paymentPrice)) {
            throw new PaylevenMissingConfigException('The amount to charge is required for this method');
        }

        if(empty($orderId)) {
            throw new PaylevenMissingConfigException('The order ID is required for this method');
        }

        if(empty($orderDescription)) {
            throw new PaylevenMissingConfigException('The order description is required for this method');
        }

        $this->requestBuilder->initiateRequest('payment', [
            'price' => $paymentPrice,
            'description' => $orderDescription,
            'orderId' => $orderId,
            'domain' => $this->webApplication->getReturnDomain(),
            'api_key' => $this->webApplication->getApiKey(),
            'scheme' => $this->webApplication->getReturnUrlScheme(),
            'callback' => $this->webApplication->getAppReturnPage(),
            'appName' => $this->webApplication->getDisplayName(),
            'currency' => $this->webApplication->getPaymentCurrency()
        ]);

        $this->requestUrl = $this->requestBuilder->buildRequestUrl();

        return $this->requestUrl;

    }

    /**
     * Start a refund in the Payleven App
     *
     * @param $orderId
     * @return string
     * @throws PaylevenMissingConfigException
     */
    public function startRefund($orderId) {

        if(empty($orderId)) {
            throw new PaylevenMissingConfigException('The order ID is required to start a refund');
        }

        $this->requestBuilder->initiateRequest('refund', [
            'orderId' => $orderId,
            'domain' => $this->webApplication->getReturnDomain(),
            'api_key' => $this->webApplication->getApiKey(),
            'scheme' => $this->webApplication->getReturnUrlScheme(),
            'callback' => $this->webApplication->getAppReturnPage(),
            'appName' => $this->webApplication->getDisplayName(),
        ]);

        $this->requestUrl = $this->requestUrl = $this->requestBuilder->buildRequestUrl();

        return $this->requestUrl;
    }

    /**
     * Start transaction details in the Payleven app
     *
     * @param $orderId
     * @return string
     * @throws PaylevenMissingConfigException
     */
    public function startTransactionDetails($orderId) {

        if(empty($orderId)) {
            throw new PaylevenMissingConfigException('The order ID is required for this method');
        }

        $this->requestBuilder->initiateRequest('trxdetails', [
            'orderid' => $orderId,
            'domain' => $this->webApplication->getReturnDomain(),
            'api_key' => $this->webApplication->getApiKey(),
            'scheme' => $this->webApplication->getReturnUrlScheme(),
            'callback' => $this->webApplication->getAppReturnPage(),
            'appName' => $this->webApplication->getDisplayName(),
        ]);

        $this->requestUrl = $this->requestBuilder->buildRequestUrl();

        return $this->requestUrl;
    }

    /**
     * Start transaction history in Payleven App
     */
    public function startTransactionHistory() {

        $this->requestBuilder->initiateRequest('history', [
            'domain' => $this->webApplication->getReturnDomain(),
            'api_key' => $this->webApplication->getApiKey(),
            'scheme' => $this->webApplication->getReturnUrlScheme(),
            'callback' => $this->webApplication->getAppReturnPage(),
            'appName' => $this->webApplication->getDisplayName(),
        ]);

        $this->requestUrl = $this->requestBuilder->buildRequestUrl();

        return $this->requestUrl;
    }

    /**
     * Validate the response returned by the API
     * 0 = invalid, 1 = valid
     *
     * @return bool
     */
    public function validateResponse() {

        if(empty($_REQUEST['result'])) {
            return false;
        }

        $responseBody = array(
            'result' 						=> $this->ensureRequestParameterValue('result'),
            'description' 					=> $this->ensureRequestParameterValue('description'),
            'orderId' 						=> $this->ensureRequestParameterValue('orderId'),
            'errorCode' 					=> $this->ensureRequestParameterValue('errorCode'),
            'amount' 						=> $this->ensureRequestParameterValue('amount'),
            'tipAmount' 					=> $this->ensureRequestParameterValue('tipAmount'),
            'currency'						=> $this->ensureRequestParameterValue('currency'),
            'is_duplicate_receipt'			=> $this->ensureRequestParameterValue('is_duplicate_receipt'),
            'payment_method' 				=> $this->ensureRequestParameterValue('payment_method'),
            'expire_month'					=> $this->ensureRequestParameterValue('expire_month'),
            'expire_year'					=> $this->ensureRequestParameterValue('expire_year'),
            'effective_month'				=> $this->ensureRequestParameterValue('effective_month'),
            'effective_year'				=> $this->ensureRequestParameterValue('effective_year'),
            'aid'							=> $this->ensureRequestParameterValue('aid'),
            'application_label'				=> $this->ensureRequestParameterValue('application_label'),
            'application_preferred_name'	=> $this->ensureRequestParameterValue('application_preferred_name'),
            'pan'							=> $this->ensureRequestParameterValue('pan'),
            'issuer_identification_number'	=> $this->ensureRequestParameterValue('issuer_identification_number'),
            'pan_seq'						=> $this->ensureRequestParameterValue('pan_seq'),
            'card_scheme' 					=> $this->ensureRequestParameterValue('card_scheme'),
            'bank_code'						=> $this->ensureRequestParameterValue('bank_code'),
            'pos_entry_mode'				=> $this->ensureRequestParameterValue('pos_entry_mode'),
            'merchant_id'					=> $this->ensureRequestParameterValue('merchant_id'),
            'merchant_display_name'			=> $this->ensureRequestParameterValue('merchant_display_name'),
            'auth_code'						=> $this->ensureRequestParameterValue('auth_code'),
            'terminal_id'					=> $this->ensureRequestParameterValue('terminal_id'),
            'api_version'					=> $this->ensureRequestParameterValue('api_version'),
            'timestamp' 					=> $this->ensureRequestParameterValue('timestamp')
        );

        $hmacCalculator = new PaylevenHmacCalculator();

        $encodedResponseBody = $this->requestBuilder->buildRequestQuery($responseBody);

        if($responseBody['result'] == 'login_cancelled') {
            $applicationApiKey = self::CANCELLED_LOGIN_TOKEN;
        } else {
            $applicationApiKey = $this->webApplication->getApiKey();
        }

        if($hmacCalculator->ValidateHmac($applicationApiKey, $_REQUEST['hmac'], $encodedResponseBody)) {
            return true;
        } else {
            return false;
        }

    }
    /**
     * Redirect to the current request url
     */
    public function redirect() {
        header('Location: '.$this->requestUrl);
    }

    /**
     * Return the current web application
     *
     * @return PaylevenWebApplication
     */
    public function getWebApplication() {
        return $this->webApplication;
    }

    /**
     * Return the url for the current request
     *
     * @return string
     */
    public function getRequestUrl() {
        return $this->requestUrl;
    }

    /**
     * Ensure each parameter is available, or empty
     * Used for calculating the response HMAC
     *
     * @param $requestParameter
     * @return string
     */
    private function ensureRequestParameterValue($requestParameter) {

        return (isset($_REQUEST[$requestParameter]) && !empty($_REQUEST[$requestParameter])) ? $requestParameter : '';
    }


}