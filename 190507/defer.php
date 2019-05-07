<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/7
 * Time: 17:58
 */

$server = new Swoole\Http\Server("127.0.0.1", 9502, SWOOLE_BASE);

$server->set([
    'worker_num' => 1,
]);

$server->on('Request', function ($request, $response) {

    $tcpclient = new Swoole\Coroutine\Client(SWOOLE_SOCK_TCP);
    $tcpclient->connect('127.0.0.1', 9501,0.5);
    $tcpclient->send("hello world\n");

    $redis = new Swoole\Coroutine\Redis();
    $redis->connect('127.0.0.1', 6379);
    $redis->setDefer();
    $redis->get('key');

    $mysql = new Swoole\Coroutine\MySQL();
    $mysql->connect([
        'host' => '127.0.0.1',
        'user' => 'user',
        'password' => 'pass',
        'database' => 'test',
    ]);
    $mysql->setDefer();
    $mysql->query('select sleep(1)');

    $httpclient = new Swoole\Coroutine\Http\Client('0.0.0.0', 9599);
    $httpclient->setHeaders(['Host' => "api.mp.qq.com"]);
    $httpclient->set([ 'timeout' => 1]);
    $httpclient->setDefer();
    $httpclient->get('/');

    $tcp_res  = $tcpclient->recv();
    $redis_res = $redis->recv();
    $mysql_res = $mysql->recv();
    $http_res  = $httpclient->recv();

    $response->end('Test End');
});
$server->start();