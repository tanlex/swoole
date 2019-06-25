<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/25
 * Time: 11:51
 */

use Swoole\Table;

$table = new Table(1024);
$table->column('id',Table::TYPE_INT,4);
$table->column('name',Table::TYPE_STRING,64);
$table->column('num',Table::TYPE_FLOAT);
$table->create();
$table->set('my',['id'=>0,'name'=>'tanlex','num'=>'10.01']);
//var_dump($table->get('my','name'));

$timer = Swoole\timer::tick(1000,function() use ($table){
    $id = $table->get('my','id');
    $id = $id + 1;
    $table->set('my',['id'=>$id,'name'=>'tanlex','num'=>'10.01']);

    var_dump($table->get('my','id'));

});

Swoole\timer::tick(10,function() use ($timer,$table){
    $id = $table->get('my','id');
    if($id==3){
        Swoole\timer::clear($timer);
    }
});