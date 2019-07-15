<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/15
 * Time: 15:38
 */

/**
 * 参考：https://laravelacademy.org/post/7420.html
 * 发送消息
 */

$exchangeName = 'mylogs';
$message = 'Hello World!';

// 建立TCP连接
$connection = new AMQPConnection([
    'host' => 'localhost',
    'port' => '5672',
    'vhost' => '/',
    'login' => 'zhiyuan',
    'password' => 'zhiyuan'
]);
$connection->connect() or die("Cannot connect to the broker!\n");

try {
    $channel = new AMQPChannel($connection);

    $exchange = new AMQPExchange($channel);
    $exchange->setName($exchangeName);
    $exchange->setType(AMQP_EX_TYPE_FANOUT); //fanout 就是广播模式，会将 Message 都放到它所知道的所有 Queue 中
    $exchange->declareExchange();

    echo 'Send Message: ' . $exchange->publish($message) . "\n";
    echo "Message Is Sent: " . $message . "\n";
} catch (AMQPConnectionException $e) {
    var_dump($e);
}

// 断开连接
$connection->disconnect();