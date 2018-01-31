<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/29
 * Time: 15:21
 */

namespace app\api\service;


use app\lib\enum\OrderStatusEnum;
use app\lib\exception\TokenException;
use app\lib\exception\WxException;
use think\Loader;
use think\Log;

Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');

class Pay
{
    protected $orderID;
    protected $orderNo;

    function __construct($orderID)
    {
        if (!$orderID) {
            throw new \Exception('订单号不能为null');
        }
        $this->orderID = $orderID;
    }

    //订单号是否存在
    //订单号是否和当前用户匹配
    //订单是否已经被支付
    //进行库存量检测
    public function pay()
    {
        $this->checkOrderValid();
        $orderService = new Order();
        $status = $orderService->checkOrderStock($this->orderID);
        if (!$status['pass']) {
            return $status;
        }
        //TODO:调用微信支付接口
        return $this->makeWxPreOrder($status['orderPrice']);
    }

    private function makeWxPreOrder($totalPrice)
    {
        $openid = Token::getCurrentTokenVar('openid');
        if (!$openid) {
            throw new \Exception('openid为空');
        }
        $wxOrderData = new \WxPayUnifiedOrder();
        $wxOrderData->SetOut_trade_no($this->orderNo);
        $wxOrderData->SetTrade_type('JSAPI');
        $wxOrderData->SetTotal_fee($totalPrice * 100);
        $wxOrderData->SetBody('零食商贩');
        $wxOrderData->SetOpenid($openid);
        $wxOrderData->SetNotify_url(config('secure.pay_back_url'));
        return $this->getPaySignature($wxOrderData);
    }

    private function getPaySignature($wxOrderData)
    {
        $wxOrder = \WxPayApi::unifiedOrder($wxOrderData);//向微信服务器提交预支付订单
        if ($wxOrder['return_code'] != 'SUCCESS'
            || $wxOrder['result_code'] != 'SUCCESS') {
            Log::record($wxOrder, 'error');
            Log::record('获取预支付订单失败', 'error');
            throw new WxException([
                'msg' => $wxOrder
            ]);
        }
        $this->recordPrepayID($wxOrder);
        $signature = $this->sign($wxOrder);
        return $signature;
    }

    private function sign($wxOrder)
    {
        $jsApiPayData = new \WxPayJsApiPay();
        $jsApiPayData->SetAppid(config('wx.app_id'));
        $jsApiPayData->SetTimeStamp((string)time());
        $rand = md5(time() . mt_rand(0, 1000));
        $jsApiPayData->SetNonceStr($rand);
        $jsApiPayData->SetPackage('prepay_id=' . $wxOrder['prepay_id']);
        $jsApiPayData->SetSignType('md5');

        $sign = $jsApiPayData->MakeSign();
        $rawValues = $jsApiPayData->GetValues();
        $rawValues['paySign'] = $sign;

        unset($rawValues['appId']);
        return $rawValues;
    }

    private function recordPrepayID($wxOrder)
    {
        \app\api\model\Order::where('id', '=', $this->orderID)
            ->update(['prepay_id' => $wxOrder['prepay_id']]);
    }

    private function checkOrderValid()
    {
        $order = \app\api\model\Order::where('id', '=', $this->orderID)
            ->find();
        if (!$order) {
            throw new \Exception('订单不存在');
        }
        if (!Token::isValidOperate($order->user_id)) {//检查此订单是否属于当前用户
            throw new TokenException([
                'msg' => '订单与用户不匹配',
                'errorCode' => 10003
            ]);
        }
        if ($order->status != OrderStatusEnum::UNPAID) {
            throw new \Exception('订单已支付');
        }
        $this->orderNo = $order->order_no;
        return true;
    }
}