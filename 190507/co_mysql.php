<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/7
 * Time: 11:53
 */

go(function(){
    $swoole_mysql = new Swoole\Coroutine\MySQL();
    $swoole_mysql->connect([
        'host' => '127.0.0.1',
        'port' => 3307,
        'user' => 'root',
        'password' => 'root3307',
        'database' => 'tang',
    ]);
//    $sql = "INSERT INTO employee(first_name,last_name,age,sex,income) VALUES('tanlex','tang sir',30,'m',3000)";
    $sql = "SELECT * FROM employee";
    $res = $swoole_mysql->query($sql);
    var_dump($res);
});
