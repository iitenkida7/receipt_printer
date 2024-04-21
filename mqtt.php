<?php
require_once __DIR__ . '/vendor/autoload.php';

use \App\MqttSubscribe;

(new MqttSubscribe)->subscribe();
