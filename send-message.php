<?php
require_once __DIR__ . '/vendor/autoload.php';

use \App\Mqtt;

(new Mqtt)->publish("これはテスト。");
