<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/8
 * Time: 17:01
 */

$server = new swoole_server('0.0.0.0',9501);

$server->set([
    'worker_num' => 2
]);

$server->on('start',function(swoole_server $server){
    $info = "master start".PHP_EOL;
    file_put_contents(__DIR__.'/swooletcp.log',$info,FILE_APPEND);
});

$server->on('connect',function(swoole_server $server, int $fd, int $reactorId){
    $info = "connect event:fd:".$fd.PHP_EOL;
    file_put_contents(__DIR__.'/swooletcp.log',$info,FILE_APPEND);
});

$server->on('receive',function(swoole_server $server, int $fd, int $reactor_id, string $data){

    $info = "fd:".$fd.PHP_EOL;
    file_put_contents(__DIR__.'/swooletcp.log',$info,FILE_APPEND);
    $info = "data:".$data.PHP_EOL;
    file_put_contents(__DIR__.'/swooletcp.log',$info,FILE_APPEND);

});

$server->on('close',function(swoole_server $server, int $fd, int $reactorId){
    $info = "close event:fd:".$fd.PHP_EOL;
    file_put_contents(__DIR__.'/swooletcp.log',$info,FILE_APPEND);
});

$server->start();