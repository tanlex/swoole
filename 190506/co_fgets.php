<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/6
 * Time: 15:16
 */
use Swoole\Coroutine as co;
$fp = fopen(__DIR__ . "/co_getpcid.php", "r");
go(function () use ($fp)
{
    $r =  co::fgets($fp);
    var_dump($r);
});