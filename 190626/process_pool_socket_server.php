<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/26
 * Time: 14:39
 */
$pool = new Swoole\Process\Pool(2, SWOOLE_IPC_SOCKET);

$pool->on("Message", function ($pool, $message) {
    echo "Message: {$message}\n";
    $pool->write("hello ");
    $pool->write("world ");
    $pool->write("\n");
});

$pool->listen('127.0.0.1', 8089);
$pool->start();