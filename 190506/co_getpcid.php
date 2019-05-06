<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/6
 * Time: 15:00
 */
echo Co::getPcid(), "\n";
go(function () {
    echo Co::getPcid(), "\n";
    go(function () {
        echo Co::getPcid(), "\n";
        go(function () {
            echo Co::getPcid(), "\n";
            go(function () {
                echo Co::getPcid(), "\n";
            });
            go(function () {
                echo Co::getPcid(), "\n";
            });
            go(function () {
                echo Co::getPcid(), "\n";
            });
        });
        echo Co::getPcid(), "\n";
    });
    echo Co::getPcid(), "\n";
});
echo Co::getPcid(), "\n";