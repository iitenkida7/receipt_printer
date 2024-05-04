<?php

namespace App;

use  Dotenv\Dotenv;
use  Illuminate\Http\Client\PendingRequest;
use \PhpMqtt\Client\MqttClient;

class Emqx
{
  private PendingRequest $http;

  private string $endpoint;
  private string $appId;
  private string $appSecret;
  private string $topic;

  public function __construct()
  {
    $this->http =  new PendingRequest();
    $dotenv = Dotenv::createImmutable(__DIR__ . "/../");
    $dotenv->load();

    $this->endpoint = $_ENV['EMQX_API_ENDPOINT'];
    $this->appId = $_ENV['EMQX_API_APP_ID'];
    $this->appSecret = $_ENV['EMQX_API_APP_SECRET'];
    $this->topic = $_ENV['MQTT_TOPIC'];
  }

  public function post(string $message)
  {
    $this->http
      ->acceptJson()
      ->withBasicAuth($this->appId, $this->appSecret)
      ->post($this->endpoint . '/publish', [
        "topic" => $this->topic,
        "qos" => MqttClient::QOS_EXACTLY_ONCE,
        "payload" => $message,
      ]);
  }
}
