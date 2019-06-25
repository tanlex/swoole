<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/25
 * Time: 11:44
 */

$http = new Swoole\Http\Server("0.0.0.0", 9501);

$http->on('request', function ($req, Swoole\Http\Response $resp) use ($http) {
    $resp->detach();
    $resp2 = Swoole\Http\Response::create($req->fd);
    $resp2->end("hello world");
});

$http->start();