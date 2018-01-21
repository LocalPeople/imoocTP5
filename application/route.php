<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

// tp5路由功能（开启会屏蔽相应PATH_INFO路径）
// Route::rule('路由表达式','路由地址','请求类型','路由参数（数组）','变量规则（数组）');
//Route::rule('hello/:id/:name', 'sample/test/hello', 'GET|POST', ['https'=>false]);
//Route::get('hello', 'sample/test/hello');
//Route::post('hello/:id', 'sample/test/hello');
Route::get('api/v1/banner/:id', 'api/v1.banner/getBanner');
