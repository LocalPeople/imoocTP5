<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/26
 * Time: 9:36
 */

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\validate\OrderPlace;
use app\api\service\Token as TokenService;
use app\api\service\Order as OrderService;

class Order extends BaseController
{
    //查询相关商品库存信息
    //如果有库存，将订单数据写入数据库并返回可以支付信息回客户端
    //客户端调用我们的支付接口进行支付
    //再次检查库存
    //服务器调用微信支付接口进行支付
    //小程序根据服务器返回结果拉起微信支付
    //等待微信返回支付结果
    //成功：再再次检查库存，进行库存的扣除

    protected $beforeActionList=[
        'checkExclusiveScope'=>['only'=>'placeOrder']
    ];

    public function placeOrder(){
        (new OrderPlace())->goCheck();
        $products=input('post.products/a');
        $uid=TokenService::getCurrentUid();
        $order=new OrderService();
        $status=$order->place($uid, $products);
        return $status;
    }
}