<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/5
 * Time: 17:38
 */

//创建Server对象，监听 127.0.0.1:9501端口
$serv = new swoole_server("127.0.0.1", 9501);

//监听连接进入事件
$serv->on('connect', function ($serv, $fd) {
    echo "Client: Connect: ".$fd."\n";
    $redis = new Swoole\Coroutine\Redis();
    $redis->connect('127.0.0.1', 6379);
//    $redis->lPush('tanlex',$fd);
    //把连接上的客户端存起来
    $redis->lPush('swoole',$fd);
});

//监听数据接收事件
$serv->on('receive', function ($serv, $fd, $from_id, $data) {
    $serv->send($fd, "Server: ".$data."\n");
});

//监听连接关闭事件
$serv->on('close', function ($serv, $fd) {
    echo "Client: Close: ".$fd."\n";

    $redis = new Swoole\Coroutine\Redis();
    $redis->connect('127.0.0.1', 6379);
    //通知其他客户端该客户端退出
    $len = $redis->lLen('swoole');
    for($i=0;$i<$len;$i++){
        $fds = $redis->lPop('swoole');
        if($fds != $fd){
            $serv->send($fds, "Client: Close: ".$fd."\n");
        }
    }

});

//启动服务器
$serv->start();