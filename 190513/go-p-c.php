<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/13
 * Time: 13:55
 */
/**
 * 协程嵌套
 */
/*
echo "main start\n";
go(function () {
    echo "coro ".co::getcid()." parent start\n";
    go(function () {
        echo "coro ".co::getcid()." child start\n";
        co::sleep(.1);
        echo "coro ".co::getcid()." child end\n";
    });
    echo "coro ".co::getcid()." do not wait children coroutine\n";
    co::sleep(.2);
    echo "coro ".co::getcid()." parent end\n";
});
echo "end\n";
*/

echo "main start\n";
go(function () {
    echo "coro ".co::getcid()." parent start\n";
    go(function () {
        echo "coro ".co::getcid()." child start\n";
        co::sleep(.2);
        echo "coro ".co::getcid()." child end\n";
    });
    echo "coro ".co::getcid()." do not wait children coroutine\n";
    co::sleep(.1);
    echo "coro ".co::getcid()." parent end\n";
});
echo "end\n";