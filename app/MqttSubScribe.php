<?php

namespace App;

use  Dotenv\Dotenv;
use \PhpMqtt\Client\MqttClient;
use \PhpMqtt\Client\ConnectionSettings;

class MqttSubScribe
{
  private string $topic = 'php/mqtt';
  private string $server;
  private int $port;
  private int $clientId;
  private string $username;
  private string $password;
  private bool $clean_session;
  private ConnectionSettings $connectionSettings;

  public function __construct()
  {
    $dotenv = Dotenv::createImmutable(__DIR__ . "/../");
    $dotenv->load();
    $this->server = $_ENV['MQTT_SERVER'];
    $this->port = $_ENV['MQTT_PORT'];
    $this->username = $_ENV['MQTT_USERNAME'];
    $this->password = $_ENV['MQTT_PASSWORD'];
    $this->clientId = rand(5, 15);
    $this->clean_session = false;

    $this->connectionSettings  = (new ConnectionSettings)
      ->setUsername($this->username)
      ->setPassword($this->password)
      ->setKeepAliveInterval(60)
      ->setConnectTimeout(3)
      ->setUseTls(true)
      ->setTlsSelfSignedAllowed(true);
  }

  public function subscribe(): void
  {
    $mqtt = new MqttClient($this->server, $this->port, $this->clientId, MqttClient::MQTT_3_1_1);
    $mqtt->connect($this->connectionSettings, $this->clean_session);
    $mqtt->subscribe($this->topic, function ($topic, $message) {
      $this->ReceivedPostProcess($topic, $message);
    }, 0);

    $mqtt->loop(true);
    $mqtt->disconnect();
  }

  public function receivedPostProcess(string $topic, string $message): void
  {
    // override this method to process the received message
    printf("Received message on topic [%s]: %s\n", $topic, $message);
  }
}
