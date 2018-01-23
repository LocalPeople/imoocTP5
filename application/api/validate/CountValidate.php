<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/23
 * Time: 9:18
 */

namespace app\api\validate;


class CountValidate extends MyValidate
{
    protected $rule=[
        'count'=>'isPositiveInteger|between:1,15'
    ];
}