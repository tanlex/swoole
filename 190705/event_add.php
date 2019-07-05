<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/5
 * Time: 10:39
 */

$fp = stream_socket_client("tcp://www.qq.com:80", $errno, $errstr, 30);
var_dump($fp);
$wres = fwrite($fp,"GET / HTTP/1.1\r\nHost: www.qq.com\r\n\r\n");
var_dump($wres);

swoole_event_add($fp, function($fp) {
    $resp = fread($fp, 8192);
    var_dump($resp);
    //socket处理完成后，从epoll事件中移除socket
    swoole_event_del($fp);
    fclose($fp);
});
echo "Finish\n";  //swoole_event_add不会阻塞进程，这行代码会顺序执行