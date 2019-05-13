<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/13
 * Time: 17:09
 */

Swoole\Runtime::enableCoroutine();

go(function () {
    $redis = new redis;
    $retval = $redis->connect("127.0.0.1", 6379);
    var_dump($retval, $redis->getLastError());
    var_dump($redis->get("key"));
    var_dump($redis->set("key", "value2"));
    var_dump($redis->get("key"));
    $redis->close();
});