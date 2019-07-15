<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/15
 * Time: 17:37
 */

/**
 * 参考：https://laravelacademy.org/post/7434.html
 * 接收消息
 */

$exchangeName = 'topic_logs';
$topic = $argv[1];

// 建立TCP连接
$connection = new AMQPConnection([
    'host' => 'localhost',
    'port' => '5672',
    'vhost' => '/',
    'login' => 'zhiyuan',
    'password' => 'zhiyuan'
]);
$connection->connect() or die("Cannot connect to broker!\n");

$channel = new AMQPChannel($connection);

$exchange = new AMQPExchange($channel);
$exchange->setName($exchangeName);
$exchange->setType(AMQP_EX_TYPE_TOPIC);
$exchange->declareExchange();

$queue = new AMQPQueue($channel);
$queue->setFlags(AMQP_EXCLUSIVE);
$queue->declareQueue();
$queue->bind($exchangeName, $topic);

echo "Waiting for logs...\n";
while (TRUE) {
    $queue->consume('processLogs');
}

$connection->disconnect();

function processLogs($envelope, $queue) {
    $logs = $envelope->getBody();
    var_dump("Received: " . $logs);
    $queue->ack($envelope->getDeliveryTag()); // 手动发送ACK应答
}