<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/15
 * Time: 17:00
 */

/**
 * 参考：https://laravelacademy.org/post/7426.html
 * 接收消息
 */

$exchangeName = 'direct_logs';
$level = !empty($argv[1]) ? $argv[1] : 'error';

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
$exchange->setType(AMQP_EX_TYPE_DIRECT);
$exchange->declareExchange();

$queue = new AMQPQueue($channel);
$queue->setFlags(AMQP_EXCLUSIVE);
$queue->declareQueue();
$queue->bind($exchangeName, $level);

echo "Waiting for logs...\n";
while (TRUE) {
    $queue->consume('processLogs');
}

$connection->disconnect();

function processLogs($envelope, $queue) {
    $logs = $envelope->getBody();
    var_dump(date('YmdHis',time()).":Received: " . $logs);
    $queue->ack($envelope->getDeliveryTag()); // 手动发送ACK应答
}