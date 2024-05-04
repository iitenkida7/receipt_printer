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
    $binary = file_get_contents("/tmp/test.out");
    $this->assertEquals("b3052f9ad49fb8653b5ccbb8e6a44ed7", md5($binary));
  }
}
