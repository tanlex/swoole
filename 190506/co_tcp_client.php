<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/6
 * Time: 17:05
 */

go(function(){
    $client = new Swoole\Coroutine\Client(SWOOLE_SOCK_TCP);
    if (!$client->connect('127.0.0.1', 9501, 0.5))
    {
        exit("connect failed. Error: {$client->errCode}\n");
    }
    $client->send("hello world\n");
    echo $client->recv();
    $client->close();
});
