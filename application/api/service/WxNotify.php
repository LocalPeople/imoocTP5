<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/31
 * Time: 13:49
 */

namespace app\api\service;

use app\api\model\Product;
use app\lib\enum\OrderStatusEnum;
use think\Db;
use think\Loader;
use app\api\model\Order as OrderModel;
use app\api\service\Order as OrderService;
use think\Log;

Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');

class WxNotify extends \WxPayNotify
{
    public function NotifyProcess($data, &$msg)
    {
        if ($data['result_code'] == 'SUCCESS') {
            $orderNo = $data['out_trade_no'];
            Db::startTrans();//添加事务防止重复减少库存
            try {
                $order = OrderModel::where('order_no', '=', $orderNo)
                    ->find();
                if (!$order && $order->status == OrderStatusEnum::UNPAID) {
                    $orderService = new OrderService();
                    $status = $orderService->checkOrderStock($order->id);
                    if ($status['pass']) {
                        $this->updateOrderStatus($order->id, true);
                        $this->reduceStock($status);
                    } else {
                        $this->updateOrderStatus($order->id, false);
                    }
                }
                Db::commit();
                return true;
            } catch (\Exception $e) {
                Db::rollback();
                Log::error($e);
                return false;
            }
        } else {
            return true;
        }
    }

    private function updateOrderStatus($orderID, $success)
    {
        $status = $success ?
            OrderStatusEnum::PAID :
            OrderStatusEnum::PAID_BUT_OUT_OF;
        OrderModel::where('order_id', '=', $orderID)
            ->update(['status' => $status]);
    }

    private function reduceStock($status)
    {
        foreach ($status['pStatusArray'] as $pStatus) {
            Product::where('id', '=', $pStatus['id'])
                ->setDec('stock', $pStatus['count']);
        }
    }
}