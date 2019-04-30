<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/30
 * Time: 16:38
 */
echo date('Y-m-d H:i:s',time()).PHP_EOL;

//协程版本非阻塞
$c = 10;
while($c--) {
    go(function () {
        //这里使用 sleep 5 来模拟一个很长的命令
        co::exec("sleep 5");
    });
}
/*
//阻塞版本
$c = 10;
while($c--) {
    //这里使用 sleep 5 来模拟一个很长的命令
    shell_exec("sleep 5");
}
*/
echo date('Y-m-d H:i:s',time()).PHP_EOL;