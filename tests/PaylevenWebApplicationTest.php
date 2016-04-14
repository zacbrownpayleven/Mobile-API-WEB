<?php

namespace Payleven\Tests;

use Payleven\Application;

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
            'P11 Test App'
        );
    }

    public function testGetApiKey() {
        $this->assertEquals('p11testapikey', $this->webApplication->getApiKey());
    }

    public function testGetUrlScheme() {
        $this->assertEquals('https', $this->webApplication->getReturnUrlScheme());
    }

    public function testGetReturnDomain() {
        $this->assertEquals('test.payleven.de', $this->webApplication->getReturnDomain());
    }

    public function testGetDisplayName() {
        $this->assertEquals('P11 Test App', $this->webApplication->getDisplayName());
    }

    public function testGetAppReturnPage() {
        $this->assertEquals('test.php', $this->webApplication->getAppReturnPage());
    }

}