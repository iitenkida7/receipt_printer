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

    $chars = mb_str_split($string);
    $outs = [];
    while (count($chars) !== 0) {
      $outs[] =  array_shift($chars);
      if ($this->countBytes(implode('', $outs)) === $fontSize->maxLength()) {
        $this->printer->text(implode('', $outs), $fontSize);
        $outs = [];
      }
    }

    if (count($outs) > 0) {
      $this->printer->text(implode('', $outs), $fontSize);
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

  private function countBytes($string)
  {
    $length = mb_strlen($string, 'UTF-8');
    $byteCount = 0;

    for ($i = 0; $i < $length; $i++) {
      $char = mb_substr($string, $i, 1, 'UTF-8');
      // mb_strwidth が2を返す場合、それは全角文字と見なす
      if (mb_strwidth($char, 'UTF-8') === 2) {
        $byteCount += 2;
      } else {
        $byteCount += 1;
      }
    }
    return $byteCount;
  }
}
