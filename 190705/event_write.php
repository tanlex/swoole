<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/5
 * Time: 10:53
 */

$fp = stream_socket_client('tcp://127.0.0.1:9501');
$data = str_repeat('A', 1024 * 1024*2);

swoole_event_add($fp, function($fp) {
    echo fread($fp,8192);
});

swoole_event_write($fp, $data);