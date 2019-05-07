<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/7
 * Time: 10:50
 */

go(function(){

    $cli = new Swoole\Coroutine\Http\Client('tang.poxx.top', 80);
    $cli->setHeaders([
        'Host' => "tang.poxx.top",
        "User-Agent" => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ]);
    $cli->set([ 'timeout' => 1]);
    $cli->get('/web/test/index?id=1&title=篮球');
    var_dump($cli->body);
    $cli->close();

});