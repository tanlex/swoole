<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/25
 * Time: 11:50
 */

$str = 'llll';

Swoole\Timer::after(1000,function() use ($str) {
    echo "timeout,$str".PHP_EOL;
});