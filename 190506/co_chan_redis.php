<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/6
 * Time: 15:37
 */
class RedisPool
{
    /**
     * @var \Swoole\Coroutine\Channel
     */
    protected $pool;

    /**
     * RedisPool constructor.
     * @param int $size 连接池的尺寸
     */
    function __construct($size = 5)
    {
        $this->pool = new Swoole\Coroutine\Channel($size);
        for ($i = 0; $i < $size; $i++)
        {
            $redis = new Swoole\Coroutine\Redis();
            $res = $redis->connect('127.0.0.1', 6379);
            if ($res == false)
            {
                throw new RuntimeException("failed to connect redis server.");
            }
            else
            {
                $this->put($redis);
            }
        }
    }

    function put($redis)
    {
        $this->pool->push($redis);
    }

    function get()
    {
        return $this->pool->pop();
    }

    function length(){
        return $this->pool->length();
    }

    function isEmpty(){
        return $this->pool->isEmpty();
    }
}

go(function(){
    $redispool = new RedisPool();

    var_dump($redispool->get());
    var_dump($redispool->get());
    var_dump($redispool->get());
    var_dump($redispool->get());
    var_dump($redispool->get());
    var_dump($redispool->isEmpty());
    var_dump($redispool->length());
});


