<?php
require_once __DIR__ . '/vendor/autoload.php';

use \App\Mqtt;

class MqttFlow extends Mqtt
{

  protected function receivedPostProcess(string $topic, string $message): void
  {
    $data = base64_decode($message);
    file_put_contents('/dev/usb/lp0', $data);
  }
}

(new Mqtt)->subscribe();
