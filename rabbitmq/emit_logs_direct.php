<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/15
 * Time: 16:57
 */

/**
 * 参考：https://laravelacademy.org/post/7426.html
 * 发送消息
 */

$exchangeName = 'direct_logs';
$level = empty($argv[1]) ? 'info' : $argv[1]; // 错误级别：info、warn、error
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
$exchange->setType(AMQP_EX_TYPE_DIRECT);
$exchange->declareExchange();

$exchange->publish($message, $level);
echo "Message is sent: " . $message . "\n";
$connection->disconnect();