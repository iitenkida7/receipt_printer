<?php

namespace App;

use  Dotenv\Dotenv;
use \PhpMqtt\Client\MqttClient;
use \PhpMqtt\Client\ConnectionSettings;
use Monolog\Logger;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;

class Mqtt
{
  public bool $debug = true;

  private string $topic = 'php/mqtt';
  private string $server;
  private int $port;
  private string $clientId;
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
    $this->clientId = $_ENV['MQTT_CLIENT_ID'];
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
    $logger = $this->debug ? $this->logger() : null;
    $mqtt = new MqttClient($this->server, $this->port, $this->clientId, MqttClient::MQTT_3_1_1, null, $logger);
    $mqtt->connect($this->connectionSettings, $this->clean_session);
    $mqtt->subscribe($this->topic, function ($topic, $message) {
      $this->ReceivedPostProcess($topic, $message);
    }, 0);

    $mqtt->loop(true);
    $mqtt->disconnect();
  }

  public function publish(string $message): void
  {

    $logger = $this->debug ? $this->logger() : null;
    $mqtt = new MqttClient($this->server, $this->port, $this->clientId, MqttClient::MQTT_3_1_1, null, $logger);
    $mqtt->connect($this->connectionSettings, $this->clean_session);
    $mqtt->publish($this->topic, $message, MqttClient::QOS_EXACTLY_ONCE, true);
    $mqtt->loop(true, true);
    $mqtt->disconnect();
  }

  protected function receivedPostProcess(string $topic, string $message): void
  {
    // override this method to process the received message
    printf("Received message on topic [%s]: %s\n", $topic, $message);
  }

  private function logger(): Logger
  {
    date_default_timezone_set("Asia/Tokyo");
    $formatter = new LineFormatter("[%datetime%] %channel% %level_name% %message%\n", "Y-m-d H:i:s");
    $logger = new Logger('log');
    $logHandler = new StreamHandler('php://stdout');
    $logHandler->setFormatter($formatter);
    return $logger->pushHandler($logHandler);
  }
}
