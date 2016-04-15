<?php

namespace Payleven\Tests;

use Payleven\Application;
use Payleven\Exception;

class PaylevenWebApplicationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The Payleven web application object
     *
     * @var
     */
    private $webApplication;

    public function setUp()
    {
        $this->webApplication = new Application\PaylevenWebApplication(
            'p11testapikey',
            'https',
            'test.payleven.de',
            'test.php',
            'P11 Test App',
            'EUR'
        );
    }

    public function testInstanceOfPaylevenWebApplication() {
        $this->assertInstanceOf('Payleven\Application\PaylevenWebApplication', $this->webApplication);
    }

    public function testGetApiKeyReturnType() {
        $this->assertInternalType('string', $this->webApplication->getApiKey());
    }

    public function testGetApiKey() {
        $this->assertEquals('p11testapikey', $this->webApplication->getApiKey());
    }

    public function testGetUrlSchemeReturnType() {
        $this->assertInternalType('string', $this->webApplication->getReturnUrlScheme());
    }

    public function testGetUrlScheme() {
        $this->assertEquals('https', $this->webApplication->getReturnUrlScheme());
    }

    public function testGetReturnDomainReturnType() {
        $this->assertInternalType('string', $this->webApplication->getReturnDomain());
    }

    public function testGetReturnDomain() {
        $this->assertEquals('test.payleven.de', $this->webApplication->getReturnDomain());
    }

    public function testGetDisplayNameReturnType() {
        $this->assertInternalType('string', $this->webApplication->getDisplayName());
    }
    public function testGetDisplayName() {
        $this->assertEquals('P11 Test App', $this->webApplication->getDisplayName());
    }

    public function testGetAppReturnPageReturnType() {
        $this->assertInternalType('string', $this->webApplication->getAppReturnPage());
    }

    public function testGetAppReturnPage() {
        $this->assertEquals('test.php', $this->webApplication->getAppReturnPage());
    }

    public function testGetPaymentCurrencyType() {
        $this->assertInternalType('string', $this->webApplication->getPaymentCurrency());
    }

    public function testGetPaymentCurrency() {
        $this->assertEquals('EUR', $this->webApplication->getPaymentCurrency());
    }

}