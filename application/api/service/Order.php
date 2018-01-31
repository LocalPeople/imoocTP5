<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/27
 * Time: 13:56
 */

namespace app\api\service;


use app\api\model\OrderProduct;
use app\api\model\Product;
use app\api\model\UserAddress;
use think\Db;

class Order
{
    protected $oProducts;
    protected $products;
    protected $uid;

    public function place($uid, $oProducts)
    {
        $this->oProducts = $oProducts;
        $this->products = $this->getProductsByOrderProducts($oProducts);
        $this->uid = $uid;

        $status = $this->getOrderStatus();
        if (!$status['pass']) {
            $status['order_id'] = -1;
            return $status;
        }
        //TODO:开始创建订单
        $orderSnap = $this->snapOrder($status);
        $order=$this->createOrder($orderSnap);
        $order['pass']=true;
        return $order;
    }

    private function createOrder($snap)
    {
        try{
            Db::startTrans();
            $orderNo = self::makeOrderNum();
            $order = new \app\api\model\Order();
            $order->user_id = $this->uid;
            $order->order_no = $orderNo;
            $order->total_price = $snap['orderPrice'];
            $order->total_count = $snap['totalCount'];
            $order->snap_img = $snap['snapImg'];
            $order->snap_name = $snap['snapName'];
            $order->snap_address = $snap['snapAddress'];
            $order->snap_items = json_encode($snap['pStatus']);
            $order->save();

            $orderID=$order->id;
            $createTime=$order->create_time;
            foreach ($this->oProducts as &$oProduct) {
                $oProduct['order_id']=$orderID;
            }
            $orderProduct=new OrderProduct();
            $orderProduct->saveAll($this->oProducts);
            Db::commit();
        }
        catch(\Exception $e){
            Db::rollback();
            throw $e;
        }

        return [
            'order_no' => $orderNo,
            'order_id' => $orderID,
            'create_time' => $createTime
        ];
    }

    public static function makeOrderNum()
    {
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn =
            $yCode[intval(date('Y')) - 2017] . strtoupper(dechex(date('m')))
            . date('d') . substr(time(), -5) . substr(microtime(), 2, 5)
            . sprintf('%02d', rand(0, 99));
        return $orderSn;
    }

    //生成订单快照
    private function snapOrder($status)
    {
        $snap = [
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatus' => [],
            'snapAddress' => null,//订单快照地址详情（收货人，收货地址，收货电话等）
            'snapName' => '',//订单快照总称
            'snapImg' => ''//订单快照缩略图
        ];

        $snap['orderPrice'] = $status['orderPrice'];
        $snap['totalCount'] = $status['totalCount'];
        $snap['pStatus'] = $status['pStatusArray'];
        $snap['snapAddress'] = json_encode($this->getUserAddress());
        $snap['snapName'] = $this->products[0]['name'];
        if (count($this->products) > 1) {
            $snap['snapName'] .= '等';
        }
        $snap['snapImg'] = $this->products[0]['main_img_url'];
        return $snap;
    }

    private function getUserAddress()
    {
        $userAddress = UserAddress::where('user_id', '=', $this->uid)->find();
        if (!$userAddress) {
            throw new \Exception('用户下单地址不存在，下单失败');
        }
        return $userAddress->toArray();
    }

    //检查订单库存量
    public function checkOrderStock($orderID){
        $oProducts=OrderProduct::where('order_id', '=', $orderID)->select();
        $this->oProducts=$oProducts;
        $this->products=$this->getProductsByOrderProducts($oProducts);
        $status=$this->getOrderStatus();
        return $status;
    }

    private function getOrderStatus()
    {
        $status = [
            'pass' => true,
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatusArray' => []//历史订单相关信息(用于构建订单快照)
        ];

        foreach ($this->oProducts as $oProduct) {
            $pStatus = $this->getProductStatus($oProduct['product_id'], $oProduct['count'], $this->products);
            if (!$pStatus['haveStock']) {
                $status['pass'] = false;
            }
            $status['orderPrice'] += $pStatus['totalPrice'];
            $status['totalCount'] += $pStatus['count'];
            array_push($status['pStatusArray'], $pStatus);
        }
        return $status;
    }

    private function getProductStatus($oPID, $count, $products)
    {
        $pIndex = -1;

        $pStatus = [
            'id' => null,
            'haveStock' => false,
            'count' => 0,
            'name' => '',
            'totalPrice' => 0
        ];
        for ($i = 0; $i < count($products); $i++) {
            if ($oPID == $products[$i]['id']) {
                $pIndex = $i;
                break;
            }
        }
        if ($pIndex == -1) {
            throw new \Exception('id为' . $oPID . '的商品不存在，创建订单失败');
        } else {
            $product = $products[$pIndex];
            $pStatus['id'] = $product['id'];
            $pStatus['count'] = $count;
            $pStatus['name'] = $product['name'];
            $pStatus['totalPrice'] = $product['price'] * $count;
            if ($product['stock'] - $count >= 0) {
                $pStatus['haveStock'] = true;
            }
            return $pStatus;
        }
    }

    private function getProductsByOrderProducts($oProducts)
    {
        $oPIDs = [];
        foreach ($oProducts as $oProduct) {
            array_push($oPIDs, $oProduct['product_id']);
        }
        $products = Product::all($oPIDs)->visible(['id', 'price', 'stock', 'name', 'main_img_url'])->toArray();
        return $products;
    }
}