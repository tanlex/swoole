<?php
/**
 * 处理任务
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/12
 * Time: 17:33
 */

/**
 * 参考：https://laravelacademy.org/post/7417.html
 * 接收消息
 */

$exchangeName = 'task';
$queueName = 'worker';
$routeKey = 'worker';

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
$exchange->setType(AMQP_EX_TYPE_DIRECT);

echo 'Exchange Status: ' . $exchange->declareExchange() . "\n";

$queue = new AMQPQueue($channel);
$queue->setName($queueName);

echo 'Message Total: ' . $queue->declareQueue() . "\n";

echo 'Queue Bind: ' . $queue->bind($exchangeName, $routeKey) . "\n";

var_dump("Waiting for message...");

// 消费队列消息
while(TRUE) {
    $queue->consume('processMessage');
}

// 断开连接
$connection->disconnect();

function processMessage($envelope, $queue) {
    $msg = $envelope->getBody();
    var_dump("Received: " . $msg);
    sleep(substr_count($msg, '.')); // 为每一个点号模拟1秒钟操作
    $queue->ack($envelope->getDeliveryTag()); // 手动发送ACK应答
}

/**
 * 消息持久化
 * 为了保证在 RabbitMQ 退出或者 crash 了数据不丢失，需要将 Queue 和 Message 持久化。
 * Exchange 的持久化：
 * $exchange->setFlags(AMQP_DURABLE);
 * Queue 的持久化：
 * $queue->setFlags(AMQP_DURABLE);
 */