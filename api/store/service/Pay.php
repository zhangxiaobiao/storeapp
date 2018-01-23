<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/16
 * Time: 下午6:35
 */

namespace api\store\service;


use api\lib\enum\OrderStatusEnum;
use api\store\controller\RestPayController;
use api\store\model\OrderModel;
use api\store\model\ProductOrderModel;
use api\store\service\Order as OrderService;
use cmf\controller\RestBaseController;
use think\Config;
use think\Loader;
use think\Log;

Loader::import('WxPay.WxPay',EXTEND_PATH,'.Api.php');
class Pay extends RestBaseController
{
    private $orderID;
    private $orderNO;

    function __construct($orderID)
    {
        parent::__construct();
        if (!$orderID){
            $this->error('订单号不允许为null');
        }
        $this->orderID = $orderID;
    }

    //查询订单是否支付
    public function checkOrderPay()
    {
        $this->checkOrderValid();
        if($this->getOrderStauts()){
            return true;
        }
        $wxApi = new \WxPayOrderQuery();
        $wxApi->SetOut_trade_no($this->orderNO);
        return \WxPayApi::orderQuery($wxApi);
    }
    //如果订单已经支付，则不发请求
    public function getOrderStauts()
    {
        $order = ProductOrderModel::where('id', $this->orderID)->find();
        if ($order['status'] == 3){
            return true;
        } else {
            return false;
        }
    }

    public function pay()
    {
        //订单号可能根本不存在
        //订单号确实存在的，但是，订单号和当前用户是不匹配的
        //订单有可能已经被支付过
        //进行库存量检测
        $this->checkOrderValid();
        $orderService = new OrderService();
        $status = $orderService->checkOrderStock($this->orderID);
        if (!$status['pass']){
            return $status;
        }
        return $this->makeWxPreOrder($status['orderPrice']);
    }

    private function makeWxPreOrder($totalPrice)
    {
        $openid = Token::getCurrentTokenVar($this->getUserId());
        if (!$openid){
            $this->error('openid未获取到');
        }
        $wxOrderData = new \WxPayUnifiedOrder();
        $wxOrderData->SetOut_trade_no($this->orderNO);
        $wxOrderData->SetTrade_type('JSAPI');
        $wxOrderData->SetTotal_fee($totalPrice);
        $wxOrderData->SetTotal_fee($totalPrice*100);
        $wxOrderData->SetBody('凹凸臻品商城');
        $wxOrderData->SetOpenid($openid);
        $wxOrderData->SetNotify_url(Config::get('secure.pay_back_url'));
        return $this->getPaySignature($wxOrderData);
    }

    private function getPaySignature($wxOrderData)
    {
        $wxOrder = \WxPayApi::unifiedOrder($wxOrderData);
        if($wxOrder['return_code'] != 'SUCCESS' || $wxOrder['result_code'] !='SUCCESS'){
            Log::record($wxOrder,'error');
            Log::record('获取预支付订单失败','error');
        }
//        dump($wxOrder);
        $this->recordPreOrder($wxOrder);
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
        $jsApiPayData->SetPackage('prepay_id='.$wxOrder['prepay_id']);
        $jsApiPayData->SetSignType('md5');

        $sign = $jsApiPayData->MakeSign();
        $rawValues = $jsApiPayData->GetValues();
        $rawValues['paySign'] = $sign;

        unset($rawValues['appId']);

        return $rawValues;
    }

    private function recordPreOrder($wxOrder)
    {
        ProductOrderModel::where('id', $this->orderID)->update(['prepay_id'=>$wxOrder['prepay_id']]);
    }

    private function checkOrderValid()
    {
        $order = ProductOrderModel::where('id', $this->orderID)->find();
        if (!$order){
            $this->error('订单号不存在');
        }

        if ($order->status != OrderStatusEnum::UNPAID){
            $this->error('订单已经支付过了');
        }

        $this->orderNO = $order->product_order_no;
        return true;
    }
}