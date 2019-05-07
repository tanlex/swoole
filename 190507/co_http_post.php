<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/7
 * Time: 10:58
 */

go(function(){
    $cli = new Swoole\Coroutine\Http\Client('tang.poxx.top', 80);
    $cli->post('/web/test/index?id=1&title=足球', array("a" => '1234', 'b' => '456'));
    var_dump($cli->body);
    $cli->close();
});