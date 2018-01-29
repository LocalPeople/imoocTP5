<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/29
 * Time: 15:11
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\IDMustBePositiveInt;

class Pay extends BaseController
{
    protected $beforeActionList=[
        'checkExclusiveScope'=>['only'=>'getPreOrder']
    ];

    public function getPreOrder($id=''){
        (new IDMustBePositiveInt())->goCheck();
    }
}