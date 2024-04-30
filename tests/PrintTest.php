<?php

namespace Tests;

use App\ReceiptPrint;
use App\FontSize;
use PHPUnit\Framework\TestCase;

class HelloWorldPrint extends ReceiptPrint
{
  protected function build()
  {
    $this->center();

    $this->text("こんにちは！", FontSize::Large);
    $this->text("QRコード", FontSize::Small);
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
