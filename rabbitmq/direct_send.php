<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/12
 * Time: 15:04
 */

$exchangeName = 'demo';
$routeKey = 'hello';
$message = 'Hello World To!';

// 建立TCP连接
$connection = new AMQPConnection([
    'host' => 'localhost',
    'port' => '5672',
    'vhost' => '/',
    'login' => 'zhiyuan',
    'password' => 'zhiyuan'
]);
$connection->connect() or die("Cannot connect to the broker!\n");
//var_dump($connection);exit;

try {
    $channel = new AMQPChannel($connection);
    $exchange = new AMQPExchange($channel);

    $exchange->setName($exchangeName);
    $exchange->setType(AMQP_EX_TYPE_DIRECT);
    $exchange->declareExchange();

    echo 'Send Message: ' . $exchange->publish($message, $routeKey) . "\n";
    echo "Message Is Sent: " . $message . "\n";
} catch (AMQPConnectionException $e) {
    var_dump($e);
}

// 断开连接
$connection->disconnect();