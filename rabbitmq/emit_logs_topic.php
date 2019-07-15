<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/15
 * Time: 17:33
 */

/**
 * 参考：https://laravelacademy.org/post/7434.html
 * 发送消息
 */

$exchangeName = 'topic_logs';
$topic = empty($argv[1]) ? 'anonymous.info' : $argv[1]; // 主题
$message = empty($argv[2]) ? 'Hello World!' : $argv[2];

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

$exchange->publish($message, $topic);
echo "Message is sent: " . $message . "\n";
$connection->disconnect();