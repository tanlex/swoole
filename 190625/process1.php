<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/25
 * Time: 14:50
 */

/*
// exec - 与exec进程进行管道通信
use Swoole\Process;
$process = new Process(function (Process $worker) {
    $worker->exec('/bin/echo', ['hello world']);
    $worker->write('hello');
}, true); // 需要启用标准输入输出重定向
$process->start();
echo "from exec: ". $process->read(). "\n";
*/

$process = new \swoole_process(function(\swoole_process $process){
    sleep(3);
});
$process->start();
$process->setTimeout(2);
$ret = $process->read();
var_dump($ret);