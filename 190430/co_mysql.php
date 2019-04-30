<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/30
 * Time: 16:28
 */
$http = new swoole_http_server("0.0.0.0", 888);

$http->on('request', function ($request, $response) {
    $db = new Swoole\Coroutine\MySQL();
    $db->connect([
        'host' => '127.0.0.1',
        'port' => 3307,
        'user' => 'root',
        'password' => 'root3307',
        'database' => 'tang',
    ]);
    $data = $db->query('select * from employee');
    $response->end(json_encode($data));
});

$http->start();