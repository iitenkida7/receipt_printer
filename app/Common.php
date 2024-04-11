<?php

namespace App;

use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintBuffers\ImagePrintBuffer;
use Mike42\Escpos\Printer;
//use Mike42\Escpos\EscposImage;

class Common
{
  public function __construct()
  {
    //$connector = new FilePrintConnector("php://stdout");
    $connector = new FilePrintConnector("/dev/usb/lp0");

    $fontSize = 40;
    $qrString = "https:/example.com/";

    $fontPath = "/usr/share/fonts/opentype/ipaexfont-gothic/ipaexg.ttf";
    $buffer = new ImagePrintBuffer();
    $buffer->setFont($fontPath);
    $buffer->setFontSize($fontSize);
    $printer = new Printer($connector);
    $printer->setPrintBuffer($buffer);

    $printer->setJustification(Printer::JUSTIFY_CENTER);

    $printer->text("こんにちは！\n");
    $printer->text("QRコード\n");
    $printer->feed(2);

    $printer->qrCode($qrString, Printer::QR_ECLEVEL_L, 10);
    $printer->setJustification();

    $printer->feed(4);

    $printer->close();
  }
}
