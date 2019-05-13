<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/13
 * Time: 16:16
 */

/**
 * 错误代码
 * http://127.0.0.1:890/a
 * http://127.0.0.1:890/b
 * 全局变量用法会造成协程1全局变量受协程2影响
 */
/*
$serv = new Swoole\Http\Server('0.0.0.0',890);
$_array = [];
$serv->on("Request", function ($req, $resp){
    global $_array;
    //请求 /a（协程 1 ）
    if ($req->server['request_uri'] == '/a') {
        $_array['name'] = 'a';
        co::sleep(2.0);
        echo $_array['name'];
        $resp->end($_array['name']);
    }
    //请求 /b（协程 2 ）
    else {
        $_array['name'] = 'b';
        $resp->end();
    }
});
$serv->start();
*/

/**
 * 正确代码
 * 使用Context管理上下文
 */
use Swoole\Coroutine;

class Context
{
    protected static $pool = [];

    static function get($key)
    {
        $cid = Coroutine::getuid();
        if ($cid < 0)
        {
            return null;
        }
        if(isset(self::$pool[$cid][$key])){
            return self::$pool[$cid][$key];
        }
        return null;
    }

    static function put($key, $item)
    {
        $cid = Coroutine::getuid();
        if ($cid > 0)
        {
            self::$pool[$cid][$key] = $item;
        }

    }

    static function delete($key = null)
    {
        $cid = Coroutine::getuid();
        if ($cid > 0)
        {
            if($key){
                unset(self::$pool[$cid][$key]);
            }else{
                unset(self::$pool[$cid]);
            }
        }
    }
}
$serv = new Swoole\Http\Server('0.0.0.0',890);
$serv->on("Request", function ($req, $resp) {
    if ($req->server['request_uri'] == '/a') {
        Context::put('name', 'a');
        co::sleep(3.0);
        echo Context::get('name');
        $resp->end(Context::get('name'));
        //退出协程时清理
        Context::delete('name');
    } else {
        Context::put('name', 'b');
        $resp->end(Context::get('name'));
        //退出协程时清理
        Context::delete();
    }
});
$serv->start();