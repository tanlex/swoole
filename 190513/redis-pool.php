<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/13
 * Time: 15:09
 */

$pool = new RedisPool();
$server = new Swoole\Http\Server('127.0.0.1', 9501);
$server->set([
    // 如开启异步安全重启, 需要在workerExit释放连接池资源
    'reload_async' => true
]);
$server->on('start', function (swoole_http_server $server) {
    var_dump($server->master_pid);
});
$server->on('workerExit', function (swoole_http_server $server) use ($pool) {
    $pool->destruct();
});
$server->on('request', function (swoole_http_request $req, swoole_http_response $resp) use ($pool) {
    //从连接池中获取一个Redis协程客户端
    $redis = $pool->get();
    //连接失败
    if ($redis === false) {
        $resp->end("ERROR");
        return;
    }
    $result = $redis->hgetall('key');
    $resp->end(var_export($result, true));
    //释放客户端，其他协程可复用此对象
    $pool->put($redis);
});
$server->start();

class RedisPool
{
    protected $available = true;
    protected $pool;

    public function __construct()
    {
        $this->pool = new SplQueue;
    }

    public function put($redis)
    {
        $this->pool->push($redis);
    }

    /**
     * @return bool|mixed|\Swoole\Coroutine\Redis
     */
    public function get()
    {
        //有空闲连接且连接池处于可用状态
        if ($this->available && count($this->pool) > 0) {
            return $this->pool->pop();
        }

        //无空闲连接，创建新连接
        $redis = new Swoole\Coroutine\Redis();
        $res = $redis->connect('127.0.0.1', 6379);
        if ($res == false) {
            return false;
        } else {
            return $redis;
        }
    }

    public function destruct()
    {
        // 连接池销毁, 置不可用状态, 防止新的客户端进入常驻连接池, 导致服务器无法平滑退出
        $this->available = false;
        while (!$this->pool->isEmpty()) {
            $this->pool->pop();
        }
    }
}