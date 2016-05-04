<?php

namespace Payleven\Tests;

use Payleven\Payleven;

class PaylevenTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The Payleven object
     *
     * @var
     */
    private $paylevenObject;

    public function setUp()
    {
        $this->paylevenObject = new Payleven([
            'api_key' => 'testapikey',
            'bundle_id' => 'testbundle',
            'return_domain' => 'testreturndomain',
            'return_page' => 'testreturnpage',
            'display_name' => 'testdisplayname',
            'return_scheme' => 'https',
            'payment_currency' => 'EUR'
        ]);
    }

    public function testInstanceOfPayleven() {
        $this->assertInstanceOf('Payleven\Payleven', $this->paylevenObject);
    }

    public function testStartPaymentResultType() {
        $this->assertInternalType('string', $this->paylevenObject->startPayment('4343', 'testorderid', 'testdescription', 'EUR'));
    }

    public function testStartPaymentValue() {
        $this->assertContains('paylevenweb://payleven/payment', $this->paylevenObject->startPayment('4343', 'testorderid', 'testdescription', 'EUR'));
        $this->assertInternaltype('string', $this->paylevenObject->getRequestUrl());
    }

    public function testStartRefundResultType() {
        $this->assertInternalType('string', $this->paylevenObject->startRefund('testorderid'));
    }

    public function testStartRefundValue() {
        $this->assertContains('paylevenweb://payleven/refund', $this->paylevenObject->startRefund('testorderid'));
    }

    public function testStartTransactionDetailsReturnType() {
        $this->assertInternalType('string', $this->paylevenObject->startTransactionDetails('testorderid'));
    }

    public function testStartTransactionDetailsValue() {
        $this->assertContains('paylevenweb://payleven/trxdetails', $this->paylevenObject->startTransactionDetails('testorderid'));
    }

    public function testStartTransactionHistoryReturnType() {
        $this->assertInternalType('string', $this->paylevenObject->startTransactionHistory());
    }

    public function testStartTransactionHistoryValue() {
        $this->assertContains('paylevenweb://payleven/history', $this->paylevenObject->startTransactionHistory());
    }

    public function testValidateResponseNoresponse() {
        $this->assertEquals(false, $this->paylevenObject->validateResponse());
    }

    public function testvalidateResponseValidResponse() {
        $_REQUEST['result'] = true;
        $_REQUEST['hmac'] = '16a868d3cd163bc07986ecb70944b74294be64e2f6b686f994d1c5c9046b88fe';
        $_REQUEST['result'] = 'result';
        $_REQUEST['description'] = 'description';
        $_REQUEST['orderId'] = 'orderId';
        $_REQUEST['errorCode'] = 'errorCode';
        $_REQUEST['amount'] = 'amount';
        $_REQUEST['tipAmount'] = 'tipAmount';
        $_REQUEST['currency'] = 'currency';
        $_REQUEST['is_duplicate_receipt'] = 'is_duplicate_receipt';
        $_REQUEST['payment_method'] = 'payment_method';
        $_REQUEST['expire_month'] = 'expire_month';
        $_REQUEST['expire_year'] = 'expire_year';
        $_REQUEST['effective_month'] = 'effective_month';
        $_REQUEST['effective_year'] = 'effective_year';
        $_REQUEST['aid'] = 'aid';
        $_REQUEST['application_label'] = 'application_label';
        $_REQUEST['application_preferred_name'] = 'application_preferred_name';
        $_REQUEST['pan'] = 'pan';
        $_REQUEST['issuer_identification_number'] = 'issuer_identification_number';
        $_REQUEST['pan_seq'] = 'pan_seq';
        $_REQUEST['card_scheme'] = 'card_scheme';
        $_REQUEST['bank_code'] = 'bank_code';
        $_REQUEST['pos_entry_mode'] = 'pos_entry_mode';
        $_REQUEST['merchant_id'] = 'merchant_id';
        $_REQUEST['merchant_display_name'] = 'merchant_display_name';
        $_REQUEST['auth_code'] = 'auth_code';
        $_REQUEST['terminal_id'] = 'terminal_id';
        $_REQUEST['api_version'] = 'api_version';
        $_REQUEST['timestamp'] = 'timestamp';

        $this->assertEquals(true, $this->paylevenObject->validateResponse());
    }

    public function testInstanceOfWebApplication() {
        $this->assertInstanceOf('Payleven\Application\PaylevenWebApplication', $this->paylevenObject->getWebApplication());
    }

}
