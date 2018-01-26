<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/26
 * Time: 9:36
 */

namespace app\api\controller\v1;

use app\api\service\Token as TokenService;

class Order
{
    //查询相关商品库存信息
    //如果有库存，将订单数据写入数据库并返回可以支付信息回客户端
    //客户端调用我们的支付接口进行支付
    //再次检查库存
    //服务器调用微信支付接口进行支付并拉起客户端支付界面
    //等待微信返回支付结果
    //成功：再再次检查库存，进行库存的扣除

    public function placeOrder(){

    }
}