<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\ReceiptPrint;

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

new HelloWorldPrint("/tmp/test.out");

if (md5("/tmp/test.out") === "23fabcdb7c3bdc3238b410fb8e157c0c") {
  echo "Test passed\n";
  exit(0);
} else {
  echo "Test failed\n";
  exit(1);
}
