<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/2/1
 * Time: 11:50
 */

namespace app\api\validate;


class PageSize extends MyValidate
{
    protected $rule=[
        'page'=>'isPositiveInteger',
        'size'=>'isPositiveInteger'
    ];

    protected $msg=[
        'page'=>'page参数必须为正整数',
        'size'=>'size参数必须为正整数'
    ];
}