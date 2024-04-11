<?php

namespace App;

class HelloworldPrint extends ReceiptPrint
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
