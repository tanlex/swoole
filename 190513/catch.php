<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/13
 * Time: 16:56
 */
function test()
{
    throw new \RuntimeException(__FILE__, __LINE__);
}

Swoole\Coroutine::create(function () {
    try
    {
        test();
    }
    catch (\Throwable $e)
    {
        echo $e;
    }
});