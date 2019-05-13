<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/13
 * Time: 10:09
 */

/**
 * setDefer()方法声明延迟收包，然后通过recv()方法收包
 * 以HttpClient为例，设置setDefer(true)后，发起$http->get()请求，将不再等待服务器返回结果，而是在send request之后，立即返回true。在此之后可以继续发起其他HttpClient、MySQL、Redis等请求。最后再使用$http->recv()接收响应内容。
 * 需注意的是, defer特性只支持并发收取响应结果, 正如示例代码所示, 创建连接和数据的发送, 仍是串行的
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