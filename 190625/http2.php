<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/25
 * Time: 11:42
 */

$serv = new Swoole\Http\Server("127.0.0.1", 9501, SWOOLE_PROCESS, SWOOLE_SOCK_TCP | SWOOLE_SSL);
$serv->set([
    'ssl_cert_file' => '/home/tangzhiyuan/ssl/2384729_mini.poxx.top.pem',
    'ssl_key_file' => '/home/tangzhiyuan/ssl/2384729_mini.poxx.top.key',
    'open_http2_protocol' => true,
]);