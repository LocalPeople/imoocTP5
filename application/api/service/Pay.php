<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/29
 * Time: 15:21
 */

namespace app\api\service;


class Pay
{
    protected $orderID;
    protected $orderNo;

    function __construct($orderID)
    {
        if(!$orderID){
            throw new \Exception('订单号不能为null');
        }
        $this->orderID=$orderID;
    }

    public function pay(){

    }
}