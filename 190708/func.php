<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/8
 * Time: 11:57
 */

/*
swoole_set_process_name("swoole_process_server");
var_dump($argv);
sleep(1000);
*/

/*
$title = "My Amazing PHP Script";
$pid = getmypid(); // you can use this to see your process title in ps

if (!cli_set_process_title($title)) {
    echo "Unable to set process title for PID $pid...\n";
    exit(1);
} else {
    echo "The process title '$title' for PID $pid has been set for your process!\n";
    sleep(1000);
}
*/

//var_dump(swoole_version());

//var_dump(swoole_strerror(swoole_last_error(), 9));

//var_dump(swoole_errno());

// 获取本机所有网络接口的IP地址
//$list = swoole_get_local_ip();
//print_r($list);

//网卡mac
//print_r(swoole_get_local_mac());

//print_r(swoole_cpu_num());

//获取最近一次Swoole底层的错误码。
print_r(swoole_last_error());


//在讨论epoll的实现细节之前，先把epoll的相关操作列出：

//epoll_create 创建一个epoll对象，一般epollfd = epoll_create()
//
//epoll_ctl （epoll_add/epoll_del的合体），往epoll对象中增加/删除某一个流的某一个事件
//比如
//epoll_ctl(epollfd, EPOLL_CTL_ADD, socket, EPOLLIN);//注册缓冲区非空事件，即有数据流入
//epoll_ctl(epollfd, EPOLL_CTL_DEL, socket, EPOLLOUT);//注册缓冲区非满事件，即流可以被写入
//epoll_wait(epollfd,...)等待直到注册的事件发生
//（注：当对一个非阻塞流的读写发生缓冲区满或缓冲区空，write/read会返回-1，并设置errno=EAGAIN。而epoll只关心缓冲区非满和缓冲区非空事件）。
//一个epoll模式的代码大概的样子是：
/*
while true {
    active_stream[] = epoll_wait(epollfd)
    for i in active_stream[] {
        read or write till
    }
}
*/





