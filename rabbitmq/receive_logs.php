<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/15
 * Time: 15:50
 */

/**
 * 参考：https://laravelacademy.org/post/7420.html
 * 接收消息
 * 1:php receive_logs.php > logs_from_rabbit.log
 * 2:php receive_logs.php
 */

$exchangeName = 'mylogs';

// 建立TCP连接
$connection = new AMQPConnection([
    'host' => 'localhost',
    'port' => '5672',
    'vhost' => '/',
    'login' => 'zhiyuan',
    'password' => 'zhiyuan'
]);
$connection->connect() or die("Cannot connect to the broker!\n");

$channel = new AMQPChannel($connection);

$exchange = new AMQPExchange($channel);
$exchange->setName($exchangeName);
$exchange->setType(AMQP_EX_TYPE_FANOUT);
$exchange->declareExchange();

$queue = new AMQPQueue($channel);
$queue->setFlags(AMQP_EXCLUSIVE);
$queue->declareQueue();
$queue->bind($exchangeName);

var_dump("Waiting for message...");

// 消费队列消息
while(TRUE) {
    $queue->consume('processMessage');
}

// 断开连接
$connection->disconnect();

function processMessage($envelope, $queue) {
    $msg = $envelope->getBody();
    var_dump(date('YmdHis',time())." :Received: " . $msg);
    $queue->ack($envelope->getDeliveryTag()); // 手动发送ACK应答
}