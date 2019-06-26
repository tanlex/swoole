<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/26
 * Time: 14:40
 */

$fp = stream_socket_client("tcp://127.0.0.1:8089", $errno, $errstr) or die("error: $errstr\n");
$msg = json_encode(['data' => 'hello ,i am client', 'uid' => 1991]);
fwrite($fp, pack('N', strlen($msg)) . $msg);
sleep(1);
//将显示 hello world\n
$data = fread($fp, 8192);
var_dump(substr($data, 4, unpack('N', substr($data, 0, 4))[1]));
fclose($fp);