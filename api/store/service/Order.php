<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/16
 * Time: 下午1:12
 */

namespace api\store\service;


use api\store\model\ProductModel;
use api\store\model\ProductOrderModel;
use api\store\model\ProductOrderProductModel;
use app\store\model\AddressModel;
use cmf\controller\RestBaseController;
use think\Db;
use think\Exception;

class Order extends RestBaseController
{
    //订单的商品列表。客户端传递过来的products参数
    protected $oProducts;

    //真实的商品信息（包括库存量）
    protected $products;

    protected $user_note;

    protected $uid;

    public function place($uid, $oProducts)
    {
        //oProducts 和 products 作对比
        //products从数据库中查询出来
        $this->oProducts = $oProducts['products'];
        $this->products = $this->getProductsByOrder($oProducts['products']);
        $this->uid = $uid;
        $this->user_note = $oProducts['user_note'];
        $status = $this->getOrderStatus();
        if (!$status['pass']){
            $status['order_id'] = -1;
            return $status;
        }
        //开始创建订单
        $orderSnap = $this->snapOrder($status);
        $order = $this->createOrder($orderSnap);
        $order['pass'] = true;
        return $order;
    }
    
    //
    private function createOrder($snap)
    {
        Db::startTrans();
        try{
            $orderNo = self::makeOrderNo();
            $order = new ProductOrderModel();
            $order->user_id = $this->uid;
            $order->product_order_no = $orderNo;
            $order->total_price = $snap['orderPrice'];
            $order->snap_img = $snap['snapImg'];
            $order->snap_name = $snap['snapName'];
            $order->snap_subname = $snap['snapsubName'];
            $order->total_count = $snap['totalCount'];
            $order->snap_address = $snap['snapAddress'];
            $order->user_note = $this->user_note;
            $order->snap_items = json_encode($snap['pStatus']);
            $order->save();
            $orderID = $order->id;
            $create_time = $order->create_time;

            foreach ($this->oProducts as &$p){
                $p['order_id'] = $orderID;
                $p['product_id'] = $p['id'];
                $p['count'] = $p['counts'];
                unset($p['id']);
                unset($p['counts']);
            }
            $orderProduct = new ProductOrderProductModel();
            $orderProduct->saveAll($this->oProducts);
            Db::commit();
            return [
                'order_no' => $orderNo,
                'order_id' => $orderID,
                'create_time' => $create_time
            ];

        }
        catch (Exception $ex)
        {
            Db::rollback();
            throw $ex;
        }

    }

    public static function makeOrderNo()
    {
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn =
            $yCode[intval(date('Y')) - 2017] . strtoupper(dechex(date('m'))) . date(
                'd') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf(
                '%02d', rand(0, 99));
        return $orderSn;
    }

    //生成订单快照
    private function snapOrder($status)
    {
        $snap = [
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatus'    => [],
            'snapAddress'=> null,
            'snapName'   => '',
            'snapsubName'=> '',
            'snapImg'    => ''
        ];
        $snap['orderPrice'] = $status['orderPrice'];
        $snap['totalCount'] = $status['totalCount'];
        $snap['pStatus'] = $status['pStatusArray'];
        $snap['snapAddress'] = json_encode($this->getUserAddress());
        $snap['snapName'] = $this->products[0]['title'];
        $snap['snapsubName'] = $this->products[0]['subtitle'];
        $snap['snapImg'] = $this->products[0]['thumb'];
        
        if (count($this->products) > 1){
            $snap['snapName'] .= '等';
        }
        return $snap;
    }

    private function getUserAddress()
    {
        $userAddress = AddressModel::where('user_id', $this->uid)->find();
        if (!$userAddress){
            $this->error('用户收货地址不存在，下单失败');
        }
        return $userAddress->toArray();

    }

    public function checkOrderStock($orderID)
    {
        $oProducts = ProductOrderProductModel::where('order_id',$orderID)->select();
        foreach ($oProducts as &$product){
            $product['id'] = $product['product_id'];
            $product['counts'] = $product['count'];
            unset($product['product_id']);
            unset($product['count']);
        }
        $this->oProducts = $oProducts;
        $this->products = $this->getProductsByOrder($oProducts);
        $status = $this->getOrderStatus();
        return $status;
    }

    private function getOrderStatus()
    {
        $status = [
            'pass' => true,
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatusArray' => []
        ];

        foreach ($this->oProducts as $oProduct)
        {
            $pStatus = $this->getProductStatus($oProduct['id'],$oProduct['counts'],$this->products);
            if (!$pStatus['haveStock']){
                $status['pass'] = false;
            }
            $status['orderPrice'] += $pStatus['totalPrice'];
            $status['totalCount'] += $pStatus['counts'];
            array_push($status['pStatusArray'], $pStatus);
        }
        return $status;
    }

    private function getProductStatus($oPID, $oCount, $products)
    {
        $pIndex = -1;
        $pStatus = [
            'id' => null,
            'haveStock' => false,
            'counts' => 0,
            'price' => 0,
            'title' => '',
            'thumb' => '',
            'totalPrice' => 0
        ];

        for ($i=0; $i<count($products); $i++){
            if ($oPID == $products[$i]['id']){
                $pIndex = $i;
            }
        }

        if ($pIndex == -1){
            $this->error($oPID.'商品不存在,创建订单失败');
        }
        else {
            $product = $products[$pIndex];
            $pStatus['id'] = $product['id'];
            $pStatus['title'] = $product['title'];
            $pStatus['counts'] = $oCount;
            $pStatus['price'] = $product['price'];
            $pStatus['thumb'] = $product['thumb'];
            $pStatus['totalPrice'] = $product['price']*$oCount;
            if ($product['store_count'] - $oCount >= 0){
                $pStatus['haveStock'] = true;
            }

        }
        return $pStatus;
    }

    //根据订单信息查找真实的商品信息
    private function getProductsByOrder($oProducts)
    {
        $oPIDs = [];
       foreach ($oProducts as $item)
       {
           array_push($oPIDs, $item['id']);
       }
       $products = ProductModel::all($oPIDs)->visible(['id','price','store_count', 'title','subtitle', 'thumb'])->toArray();
       return $products;
    }


}