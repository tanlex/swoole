<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/25
 * Time: 14:30
 */
$redis = new Redis;
$redis->connect('127.0.0.1', 6379);

function callback_function () {
    swoole_timer_after(10000, function () {
        echo "hello world";
    });
    global $redis;
};

swoole_timer_tick(1000, function () {
    echo "parent timer\n";
});

Swoole\Process::signal(SIGCHLD, function ($sig) {
    while ($ret = Swoole\Process::wait(false)) {
        // create a new child process
        $p = new Swoole\Process('callback_function');
        $p->start();
    }
});

// create a new child process
$p = new Swoole\Process('callback_function');

Swoole\Event::add($p->pipe, function ($pipe) use ($p) {
    echo $p->read();
});

$p->start();