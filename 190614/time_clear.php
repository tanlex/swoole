<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/25
 * Time: 11:50
 */
$count = 0;

$timer = Swoole\Timer::tick(1000,function() use ($count) {
    echo $count.PHP_EOL;
});

Swoole\Timer::clear($timer);