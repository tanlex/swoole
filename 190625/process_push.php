<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/25
 * Time: 15:09
 */

/**
 * php process_push.php ： 脚本运行的时候作为一个父进程
 */
$workers = [];
$worker_num = 2;

for($i = 0; $i < $worker_num; $i++)
{
    $process = new swoole_process('callback_function', false, false);
    $process->useQueue();
    $pid = $process->start();
    $workers[$pid] = $process;
    echo "创建一个子进程, PID=".$pid.PHP_EOL;
}

foreach($workers as $pid => $process)
{
    $process->push("hello worker[$pid]\n");
}

//子进程退出后，父进程务必要执行Process::wait进行回收，否则这个子进程就会变为僵尸进程。会浪费操作系统的进程资源
for($i = 0; $i < $worker_num; $i++)
{
    $ret = swoole_process::wait();
    $pid = $ret['pid'];
    unset($workers[$pid]);
    echo "子进程 Exit, PID=".$pid.PHP_EOL;
    var_dump($ret);
}


function callback_function(swoole_process $worker)
{
    echo "子进程: start. PID=".$worker->pid.PHP_EOL;
    //recv data from master
    $recv = $worker->pop();

    echo "From 父进程: $recv".PHP_EOL;

    sleep(10);
    $worker->exit(0);
}