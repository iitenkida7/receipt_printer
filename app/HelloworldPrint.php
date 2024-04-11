<?php

namespace App;

use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintBuffers\ImagePrintBuffer;
use Mike42\Escpos\Printer;

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
