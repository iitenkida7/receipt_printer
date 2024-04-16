<?php
require_once __DIR__ . '/vendor/autoload.php';

use \App\MqttSubScribe;

(new MqttSubScribe)->subscribe();
