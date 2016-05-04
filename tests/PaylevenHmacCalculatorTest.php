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

    public function testValidateInvalidHmac() {
        $this->assertEquals(false, $this->hmacCalculator->validateHmac('testapikey', 'invalidhmaccalculation', 'testrequestbody'));
    }

    public function testValidateValidHmac() {
        $this->assertEquals(true, $this->hmacCalculator->validateHmac('testapikey', '16a868d3cd163bc07986ecb70944b74294be64e2f6b686f994d1c5c9046b88fe', 'result%3Dresult%26description%3Ddescription%26orderId%3DorderId%26errorCode%3DerrorCode%26amount%3Damount%26tipAmount%3DtipAmount%26currency%3Dcurrency%26is_duplicate_receipt%3Dis_duplicate_receipt%26payment_method%3Dpayment_method%26expire_month%3Dexpire_month%26expire_year%3Dexpire_year%26effective_month%3Deffective_month%26effective_year%3Deffective_year%26aid%3Daid%26application_label%3Dapplication_label%26application_preferred_name%3Dapplication_preferred_name%26pan%3Dpan%26issuer_identification_number%3Dissuer_identification_number%26pan_seq%3Dpan_seq%26card_scheme%3Dcard_scheme%26bank_code%3Dbank_code%26pos_entry_mode%3Dpos_entry_mode%26merchant_id%3Dmerchant_id%26merchant_display_name%3Dmerchant_display_name%26auth_code%3Dauth_code%26terminal_id%3Dterminal_id%26api_version%3Dapi_version%26timestamp%3Dtimestamp%26'));
    }
}