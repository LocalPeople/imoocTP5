<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/18
 * Time: 16:33
 */

namespace app\sample\controller;


use think\Request;

class Test
{
    public function hello(/*$id, $name, $age*/){
        $id = Request::instance()->param('id');
        $name = Request::instance()->param('name');
        $age = Request::instance()->param('age');

        echo $id;
        echo '|';
        echo $name;
        echo '|';
        echo $age;
//        return 'hello, diamon';
    }
}