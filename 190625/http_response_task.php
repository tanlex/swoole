<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/25
 * Time: 11:44
 */

$http = new swoole_http_server("0.0.0.0", 9501);

$http->set(['task_worker_num' => 1, 'worker_num' => 1]);

$http->on('request', function ($req, Swoole\Http\Response $resp) use ($http) {
    $resp->detach();
    $http->task(strval($resp->fd));
});

$http->on('finish', function ()
{
    echo "task finish".PHP_EOL;
});

$http->on('task', function ($serv, $task_id, $worker_id, $data)
{
    var_dump($data);
    $resp = Swoole\Http\Response::create($data);
    $resp->end("in task".PHP_EOL);
    echo "async task".PHP_EOL;
});

$http->start();
