<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/7
 * Time: 11:18
 */

//协程客户端上传文件
go(function(){
    $cli = new Swoole\Coroutine\Http\Client('tang.poxx.top', 80);
    $cli->setHeaders([
        'Host' => "tang.poxx.top"
    ]);
    $cli->set(['timeout' => -1]);
    $cli->addFile(__FILE__, '1.txt');
    $cli->post('/web/test/index?id=1&title=足球', ['foo' => 'bar']);
    var_dump($cli->body);
    $cli->close();
});
