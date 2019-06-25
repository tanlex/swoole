<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/25
 * Time: 11:40
 */

class WebsocketTest {
    public $server;
    public function __construct() {
        $this->server = new Swoole\WebSocket\Server("0.0.0.0", 890);
        $this->server->on('open', function (swoole_websocket_server $server, $request) {
            echo "server: handshake success with fd{$request->fd}\n";
        });
        $this->server->on('message', function (Swoole\WebSocket\Server $server, $frame) {
            echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
            $server->push($frame->fd, "this is server");
        });
        $this->server->on('close', function ($ser, $fd) {
            echo "client {$fd} closed\n";
        });
        $this->server->on('request', function ($request, $response) {
            // 接收http请求从get获取message参数的值，给用户推送
            // $this->server->connections 遍历所有websocket连接用户的fd，给所有用户推送
            foreach ($this->server->connections as $fd) {
                // 需要先判断是否是正确的websocket连接，否则有可能会push失败
                if ($this->server->isEstablished($fd)) {
                    $this->server->push($fd, $request->get['message']);
                }
            }
        });
        $this->server->start();
    }
}
new WebsocketTest();


/*
var wsServer = 'ws://120.78.209.236:890';
var websocket = new WebSocket(wsServer);
websocket.onopen = function (evt) {
    console.log("onopen");
    var message = { 
             keyword: '杨女士', 
             status: '', 
             start: '',
                    end: '' 
                };
    websocket.send(JSON.stringify(message)); 
}
websocket.onclose = function (evt) {
    console.log("onclose");
};
websocket.onmessage = function (evt) {
    console.log('onmessage: ' + evt.data);
};
websocket.onerror = function (evt, e) {
    console.log('Error occured: ' + evt.data);
};
 */