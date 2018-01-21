<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/19
 * Time: 14:35
 */

namespace app\api\validate;

use app\lib\exception\ParameterException;
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
        $result = $this->batch()->check($params);

        if(!$result){
            $e=new ParameterException([
                'msg'=>$this->error
            ]);
            throw $e;
        }
        else{
            return true;
        }
    }
}