<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/13
 * Time: 18:04
 */

Swoole\Timer::tick(3000, function () {
    echo "after 3000ms.\n";
    Swoole\Timer::tick(14000, function () {
        echo "after 14000ms.\n";
    });
});