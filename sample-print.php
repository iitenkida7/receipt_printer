<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\ReceiptPrint;
use App\Mqtt;

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


new HelloWorldPrint('/tmp/print_date');
(new Mqtt)->publish(base64_encode(file_get_contents('/tmp/print_date')));
