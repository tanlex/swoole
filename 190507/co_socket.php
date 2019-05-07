<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/7
 * Time: 11:44
 */

go(function () {
    $socket = new Co\Socket(AF_INET, SOCK_DGRAM, 0);
    $socket->bind('127.0.0.1', 9601);
    while (true) {
        $peer = null;
        $data = $socket->recvfrom($peer);
        echo "[Server] recvfrom[{$peer['address']}:{$peer['port']}] : $data\n";
        $socket->sendto($peer['address'], $peer['port'], "Swoole: $data");
    }
});