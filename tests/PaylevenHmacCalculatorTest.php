<?php

namespace Payleven\Tests;

use Payleven\Security\PaylevenHmacCalculator;

class PaylevenHmacCalculatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The Payleven hmac calculator object
     *
     * @var
     */
    private $hmacCalculator;

    public function setUp()
    {
        $this->hmacCalculator = new PaylevenHmacCalculator();
    }

    public function testInstanceOfPaylevenHmacCalculator() {
        $this->assertInstanceOf('Payleven\Security\PaylevenHmacCalculator', $this->hmacCalculator);
    }

    public function testCalculateHmacReturnType() {
        $this->assertInternalType('string', $this->hmacCalculator->calculateHmac('testapikey', 'testrequestbody'));
    }

    public function testCalculateHmac() {
        $this->assertEquals('84c09dc74b105f3b44dfce4e94c0895db73753fe7d7cda3836e739445bd901ab', $this->hmacCalculator->calculateHmac('testapikey', 'testrequestbody'));
    }

    public function testValidateHmacReturnType() {
        $this->assertInternalType('boolean', $this->hmacCalculator->validateHmac('testapikey', '84c09dc74b105f3b44dfce4e94c0895db73753fe7d7cda3836e739445bd901ab', 'testrequestbody'));
    }

    public function testValidateHmac() {
        $this->assertEquals(true, $this->hmacCalculator->validateHmac('testapikey', '84c09dc74b105f3b44dfce4e94c0895db73753fe7d7cda3836e739445bd901ab', 'testrequestbody'));
    }

}