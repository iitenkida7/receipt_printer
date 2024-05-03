<?php

namespace App;

use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintBuffers\ImagePrintBuffer;
use Mike42\Escpos\Printer;

class ReceiptPrint
{
  protected Printer $printer;
  protected ImagePrintBuffer $buffer;

  public function __construct(string $device = "/dev/usb/lp0")
  {
    $this->printer = new Printer($this->getConnector($device));
    $this->buffer = new ImagePrintBuffer();
    $this->setFont();

    $this->build();
  }

  protected function build()
  {
    //
  }

  protected function printQrCode(string $qrString): void
  {
    $this->printer->feed(2);
    $this->center();
    $this->printer->qrCode($qrString, Printer::QR_ECLEVEL_L, 10);
    $this->left();
    $this->printer->feed(2);
  }

  protected function text(string $string, FontSize $fontSize): void
  {
    $this->setSize($fontSize);
    $lines = (new Text())->sliceText($string, $fontSize->maxLength());

    foreach ($lines as $line) {
      $this->printer->text($line);
    }
  }

  protected function center(): void
  {
    $this->printer->setJustification(Printer::JUSTIFY_CENTER);
  }

  protected function left(): void
  {
    $this->printer->setJustification(Printer::JUSTIFY_LEFT);
  }

  protected function getConnector(string $device = "php://stdout"): FilePrintConnector
  {
    return  new FilePrintConnector($device);
  }

  protected function setFont(string $fontPath = "/usr/share/fonts/opentype/ipafont-gothic/ipag.ttf"): void
  {
    $this->buffer->setFont($fontPath);
    $this->printer->setPrintBuffer($this->buffer);
  }

  protected function setSize(FontSize $fontSize): void
  {
    $this->buffer->setFontSize($fontSize->value);
    $this->printer->setPrintBuffer($this->buffer);
  }

  protected function close(): void
  {
    $this->printer->feed(3);
    $this->printer->close();
  }
}
