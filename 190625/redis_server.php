<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/25
 * Time: 14:10
 */

use Swoole\Redis\Server;

$server = new Server('127.0.0.1', 9501);

//同步模式
$server->setHandler('Set', function($fd, $data) use ($server) {
    $server->array($data[0], $data[1]);
    return Server::format(Server::INT, 1);
});

//异步模式
/*
$server->setHandler('Get', function ($fd, $data) use ($server) {
    $db->query($sql, function($db, $result) use ($fd) {
        $server->send($fd, Server::format(Server::LIST, $result));
    });
});
*/
$server->start();