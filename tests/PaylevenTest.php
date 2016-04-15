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

}
