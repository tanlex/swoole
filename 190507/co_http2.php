<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/7
 * Time: 10:43
 */

go(function () {
    $domain = 'tang.poxx.top';
    $cli = new Swoole\Coroutine\Http2\Client($domain, 80, false);
    $cli->set([
        'timeout' => -1,
    ]);
    $cli->connect();
    $req = new swoole_http2_request;
    $req->method = 'GET';
    $req->path = '/web/test/index?id=1';
    $req->headers = [
        'host' => $domain,
        "user-agent" => 'Chrome/49.0.2587.3',
        'accept' => 'text/html,application/xhtml+xml,application/xml',
        'accept-encoding' => 'gzip'
    ];
//    $req->data = '{"type":"up"}';
    $cli->send($req);
    $response = $cli->recv();
    var_dump($response);
});