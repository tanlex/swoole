<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/25
 * Time: 11:49
 */
Swoole\Timer::tick(3000,function(){
    echo "after 3000ms".PHP_EOL;
    Swoole\Timer::tick(10000,function(){
        echo "after 10000ms".PHP_EOL;
    });
});