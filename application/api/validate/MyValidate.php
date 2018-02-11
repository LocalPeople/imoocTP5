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

    protected function isPositiveInteger($value, $rule='', $data='', $field=''){
        if(is_numeric($value) && is_int($value+0) && ($value+0)>0){
            return true;
        }
        else{
            return false;
        }
    }

    protected function isNotEmpty($value, $rule='', $data='', $field=''){
        if(empty($value)){
            return false;
        }
        else{
            return true;
        }
    }

    protected function isMobile($value){
        if($value=='020-81167888'){
            return true;
        }
        $rule='/^1[3578][0-9]\d{8}$/';
        $result=preg_match($rule, $value);
        if($result){
            return true;
        }
        else{
            return false;
        }
    }

    public function getDataByRule($array){
        if(array_key_exists('user_id', $array)|array_key_exists('uid', $array)){
            throw new ParameterException([
                'msg'=>'参数中包含非法参数名user_id或uid'
            ]);
        }
        $newArray=[];
        foreach($this->rule as $key=>$value){
            $newArray[$key]=$array[$key];
        }
        return $newArray;
    }
}