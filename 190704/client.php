<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/4
 * Time: 15:24
 */

/**
 * 同步阻塞客户端
 */
$client = new swoole_client(SWOOLE_SOCK_TCP);
if (!$client->connect('127.0.0.1', 9501, -1))
{
    exit("connect failed. Error: {$client->errCode}\n");
}
$client->send("hello world d\n");
echo $client->recv();

//启用SSL隧道加密
if ($client->enableSSL())
{
    //握手完成，此时发送和接收的数据是加密的
    $client->send("hello world\n");
    echo $client->recv();
}

$client->close();