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
            'return_scheme' => 'https'
        ]);
    }

    public function testInstanceOfPayleven() {
        $this->assertInstanceOf('Payleven\Payleven', $this->paylevenObject);
    }

    public function testStartPayment() {
        $this->assertContains('paylevenweb://payleven/payment', $this->paylevenObject->startPayment('4343', 'testorderid', 'testdescription', 'EUR'));
    }

    public function testStartRefund() {
        $this->assertContains('paylevenweb://payleven/refund', $this->paylevenObject->startRefund('testorderid'));
    }

    public function testStartTransactionDetails() {
        $this->assertContains('paylevenweb://payleven/trxdetails', $this->paylevenObject->startTransactionDetails('testorderid'));
    }

    public function testStartTransactionHistory() {
        $this->assertContains('paylevenweb://payleven/history', $this->paylevenObject->startTransactionHistory());
    }

}
