<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/4
 * Time: 15:37
 */

/**
 * 异步非阻塞客户端
 */
$client = new Swoole\Client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);

$client->set([
    'package_max_length' => 1024 * 1024 * 2,
]);

$client->on("connect", function(swoole_client $cli) {
    $cli->send("GET / HTTP/1.1\r\n\r\n");

    var_dump($cli->isConnected());
    var_dump($cli->getsockname());
//    var_dump($cli->getPeerCert());


});
$client->on("receive", function(swoole_client $cli, $data){
    echo "Receive: $data";
//    $cli->send(str_repeat('A', 100)."\n");
//    sleep(1);

    //睡眠模式，不再接收新的数据
    $cli->sleep();
    swoole_timer_after(5000, function() use ($cli) {
        //唤醒，重新接收数据
        $cli->wakeup();
    });

});
$client->on("error", function(swoole_client $cli){
    echo "error\n";
});
$client->on("close", function(swoole_client $cli){
    echo "Connection close\n";
});

$client->on("bufferEmpty", function(swoole_client $cli){
    $cli->close();
});

$client->connect('127.0.0.1', 9501);