<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/24
 * Time: 14:31
 */

namespace app\api\controller\v1;


use app\api\validate\AddressNew;
use app\api\service\Token as TokenService;

class Address
{
    public function createOrUpdateAddress(){
        (new AddressNew())->goCheck();

        //TODO:根据Token获取uid
        $uid=TokenService::getCurrentUid();
        //TODO:根据uid来查找用户数据，判断用户是否存在，如果不存在抛出异常
        //TODO:获取用户从客户端提交来的地址信息
        //TODO:根据用户地址信息是否存在，从而判断是添加地址还是更新地址
    }
}