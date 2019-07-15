<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/15
 * Time: 17:57
 */

/**
 * 参考：https://laravelacademy.org/post/7440.html
 * RPC服务端
 */
$routing_key = 'rpc_queue';

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
$channel->setPrefetchCount(1);

$server_queue = new AMQPQueue($channel);
$server_queue->setName($routing_key);
$server_queue->declareQueue();

$exchange = new AMQPExchange($channel);

$server_queue->consume(function($envelope, $queue) use ($exchange){
    $num = intval($envelope->getBody());
    $response = fib($num);
    $exchange->publish($response, $envelope->getReplyTo(), AMQP_NOPARAM, [
        'correlation_id' => $envelope->getCorrelationId(),
    ]);
    $queue->ack($envelope->getDeliveryTag());
});

// 断开连接
$connection->disconnect();

// 斐波那契函数
function fib($num) {
    if ($num == 0)
        return 1;
    else if ($num == 1)
        return 1;
    else
        return fib($num - 1) + fib($num - 2);
}