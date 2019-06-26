<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/26
 * Time: 14:48
 */

$workerNum = 10;
$pool = new Swoole\Process\Pool($workerNum);

$pool->on("WorkerStart", function ($pool, $workerId) {
    $process = $pool->getProcess();
    $process->exec("/bin/sh", ["ls", '-l']);
});

$pool->on("WorkerStop", function ($pool, $workerId) {
    echo "Worker#{$workerId} is stopped\n";
});

$pool->start();