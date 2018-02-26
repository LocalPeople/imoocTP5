<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/22
 * Time: 14:06
 */

namespace app\api\validate;


class AppTokenGet extends MyValidate
{
    protected $rule=[
        'ac'=>'require|isNotEmpty',
        'se'=>'require|isNotEmpty'
    ];
}