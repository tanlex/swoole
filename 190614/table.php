<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/25
 * Time: 11:49
 */
use Swoole\Table;

$table = new Table(1024);
$table->column('id',Table::TYPE_INT,4);
$table->column('name',Table::TYPE_STRING,64);
$table->column('num',Table::TYPE_FLOAT);
$table->create();
$table->set('my',['id'=>1,'name'=>'tanlex','num'=>'10.01']);
var_dump($table->get('my','id'));

var_dump($table->incr('my','id',1));

var_dump($table->decr('my','id'));

var_dump($table->exist('my'));