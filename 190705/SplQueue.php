<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/5
 * Time: 16:34
 */

//队列

/*
$queue = new SplQueue;
var_dump($queue);

$data = 1;
//入队
$res = $queue->push($data);
var_dump($res);
//出队
$data = $queue->shift();
var_dump($data);
//查询队列中的排队数量
$n = count($queue);
var_dump($n);
*/

//echo date('Y-m-d H:i:s',time()).PHP_EOL;
$t1 = microtime(true);

$splq = new SplQueue;
for($i = 0; $i < 1000000; $i++)
{
    $data = "hello $i\n";
    $splq->push($data);

    if ($i % 100 == 99 and count($splq) > 100)
    {
        $popN = rand(10, 99);
        for ($j = 0; $j < $popN; $j++)
        {
            $splq->shift();
        }
    }
}

$popN = count($splq);
for ($j = 0; $j < $popN; $j++)
{
    $splq->pop();
}

//echo date('Y-m-d H:i:s',time()).PHP_EOL;
$t2 = microtime(true);

$time1 = $t2 - $t1;
echo $time1.PHP_EOL;