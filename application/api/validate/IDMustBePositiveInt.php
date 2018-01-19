<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/19
 * Time: 15:08
 */

namespace app\api\validate;


class IDMustBePositiveInt extends MyValidate
{
    protected $rule=[
        'id'=>'require|isPositiveInteger'
    ];

    protected function isPositiveInteger($value, $rule='', $data='', $field=''){
        if(is_numeric($value) && is_int($value+0) && ($value+0)>0){
            return true;
        }
        else{
            return $field.'必须是正整数';
        }
    }
}