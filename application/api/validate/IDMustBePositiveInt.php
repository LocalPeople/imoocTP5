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

    protected $message=[
        'id'=>'id必须是正整数'
    ];
}