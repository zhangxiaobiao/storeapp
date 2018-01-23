<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/16
 * Time: 下午10:05
 */

namespace api\store\service;

use api\lib\enum\OrderStatusEnum;
use api\store\model\ProductModel;
use api\store\model\ProductOrderModel;
use api\store\service\Order as OrderService;
use think\Db;
use think\Exception;
use think\Loader;
use think\Log;

Loader::import('WxPay.WxPay',EXTEND_PATH,'.Api.php');

class WxNotify extends \WxPayNotify
{
    public function NotifyProcess($data, &$msg)
    {
        if ($data['result_code'] == 'SUCCESS') {
            $orderNo = $data['out_trade_no'];
            Db::startTrans();
            try{
                $order = ProductOrderModel::where('product_order_no', $orderNo)->lock(true)->find();
                if ($order->status == 1){
                    $service = new OrderService();
                    $stockStatus = $service->checkOrderStock($order->id);
                    if ($stockStatus['pass']){
                        $this->updateOrderStatus($order->id, true);
                        $this->reduceStock($stockStatus);
                    }
                    else {
                        $this->updateOrderStatus($order->id, false);
                    }
                }
                Db::commit();
                return true;
            } catch (Exception $ex){
                Db::rollback();
                Log::error($ex);
                return false;
            }
        } else {
            return true;
        }
    }

    private function reduceStock($stockStatus)
    {
        foreach ($stockStatus['pStatusArray'] as $singlePStatus){
            ProductModel::where('id', $singlePStatus['id'])->setDec('store_count', $singlePStatus['count']);
            ProductModel::where('id', $singlePStatus['id'])->setInc('sales_sum', $singlePStatus['count']);
        }
    }

    private function updateOrderStatus($orderID, $success)
    {
        $status = $success ? OrderStatusEnum::PAID : OrderStatusEnum::PAID_BUT_OUT_OF;
        ProductOrderModel::where('id', $orderID)->update(['status'=>$status,'pay_time'=>time()]);
    }
}