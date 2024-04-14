<?php

namespace Tests;

use App\ReceiptPrint;
use PHPUnit\Framework\TestCase;

class HelloWorldPrint extends ReceiptPrint
{
  protected function build()
  {
    $this->center();

    $this->text("こんにちは！", 40);
    $this->text("QRコード", 20);
    $this->printQrCode("https:/example.com/");

    $this->close();
  }
}

class PrintTest extends TestCase
{
  public function testPrint()
  {
    new HelloWorldPrint("/tmp/test.out");
    $this->assertEquals("23fabcdb7c3bdc3238b410fb8e157c0c", md5("/tmp/test.out"));
  }
}
