<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/19
 * Time: 14:35
 */

namespace app\api\validate;

use think\Exception;
use think\Request;
use think\Validate;

/*
 * BaseValidate
 * 自定义验证器基类
 */
class MyValidate extends Validate
{

    public function goCheck(){
        $params=Request::instance()->param();
        $result = $this->check($params);

        if(!$result){
            $error = $this->error;
            throw new Exception($error);
        }
        else{
            return true;
        }
    }
}