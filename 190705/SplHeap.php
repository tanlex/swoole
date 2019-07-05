<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/5
 * Time: 17:01
 */

//堆
//SplHeap数据结构需要指定一个compare方法来进行元素的对比，从而实现自动排序。SplHeap类本身是abstract的，不能直接new。
//需要编写一个子类，并实现compare方法。

//最大堆
class MaxHeap extends SplHeap
{
    protected function compare($a, $b)
    {
        return $a - $b;
    }
}

//最小堆
class MinHeap extends SplHeap
{
    protected function compare($a, $b)
    {
        return $b - $a;
    }
}

$list = new MaxHeap;
$list->insert(56);
$list->insert(22);
$list->insert(35);
$list->insert(11);
$list->insert(88);
$list->insert(36);
$list->insert(97);
$list->insert(98);
$list->insert(26);


foreach($list as $li)
{
    echo $li."\n";
}
