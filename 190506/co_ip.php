<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/6
 * Time: 15:25
 */

use Swoole\Coroutine as co;
go(function(){
    $ip = co::gethostbyname("www.baidu.com", AF_INET, 0.5);
    var_dump($ip);
    $array = co::getaddrinfo("www.baidu.com");
    var_dump($array);
});
