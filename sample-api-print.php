<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\ReceiptPrint;
use App\FontSize;
use App\Emqx;

class HelloWorldPrint extends ReceiptPrint
{

  protected function build()
  {
    $this->center();

    $this->text("211111111112", FontSize::Large);
    $this->text("あいうえ加増増加ああああううで？", FontSize::Large);
    $this->text("211111111111111112", FontSize::Medium);
    $this->text("あいうえおああいう", FontSize::Medium);
    $this->text("21111111111111111111111112", FontSize::Small);
    $this->text("あいうえおあああいあうえお", FontSize::Small);
    $this->text("あいうえおあああいえ", FontSize::Small);
    $this->text("QRコード", FontSize::Small);
    $this->printQrCode("https:/example.com/");

    $this->close();
  }
}


new HelloWorldPrint('/tmp/print_date');
(new Emqx)->post(base64_encode(file_get_contents('/tmp/print_date')));