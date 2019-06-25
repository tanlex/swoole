<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/25
 * Time: 11:48
 */
$n = new Swoole\Atomic;

if(pcntl_fork() >0){
    echo "master start\n";
    $n->wait(-1); //设置为-1时表示永不超时，会持续等待直到有其他进程唤醒
    echo "master end\n";
}else{
    echo "child start\n";
    sleep(1);
    $n->wakeup();
    echo "child end\n";
}