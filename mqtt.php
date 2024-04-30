<?php
require_once __DIR__ . '/vendor/autoload.php';

use \App\Mqtt;

class MqttFlow extends Mqtt
{

  protected function receivedPostProcess(string $topic, string $message): void
  {
    file_put_contents('/dev/usb/lp0', base64_decode($message));
  }
}

(new MqttFlow)->subscribe();
