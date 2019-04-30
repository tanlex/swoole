<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/30
 * Time: 15:21
 */
$http = new swoole_http_server("0.0.0.0", 888);

$http->on('request', function ($request, $response) {
    if ($request->server['path_info'] == '/favicon.ico' || $request->server['request_uri'] == '/favicon.ico') {
        return $response->end();
    }
//    var_dump($request->get, $request->post);
    list($controller, $action) = explode('/', trim($request->server['request_uri'], '/'));
    $text = "controller:".$controller.",action:".$action;
    $response->header("Content-Type", "text/html; charset=utf-8");
    $response->end("<h1>Hello Swoole. #".$text."</h1>");
});

$http->start();