<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/30
 * Time: 16:49
 */
/**
 * 协程并发
 */
Swoole\Runtime::enableCoroutine();

go(function ()
{
    test1();
    echo "任务1完成";
});

go(function ()
{
    test2();
    echo "任务2完成";
});

function test1(){
    sleep(1);
}

function test2(){
    sleep(2);
}