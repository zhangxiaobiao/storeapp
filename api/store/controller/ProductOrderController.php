<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/9
 * Time: 下午9:48
 */

namespace api\store\controller;


use api\lib\enum\OrderStatusEnum;
use api\store\model\ProductOrderModel;
use app\store\model\DeliveryModel;
use cmf\controller\RestBaseController;
use cmf\controller\RestUserBaseController;
use api\store\service\Order as OrderService;
use think\Db;

class ProductOrderController extends RestBaseController
{

    //用户在选择商品后，向api提交包含他所选商品的相关信息
    //api在接收到的信息后，需要检查订单相关商品的库存量
    //有库存，把订单数据存入数据库中，下单成功了，返回客户端消息，告诉客户端可以支付了
    //调用我们的支付接口，进行支付
    //还需要再次进行库存量检测
    //服务器这边就可以调用微信的支付接口进行支付
    //小程序根据服务器返回的结果拉起微信支付
    //微信会返回给我们一个支付的结果（异步）
    //成功：也需要进行库存量的检测
    //成功：进行库存量的扣除， 失败：返回一个支付失败的结果

    public function getSummarySByUser($page=1, $size=5)
    {
        $this->checkOrderStatus();
        $data = $this->request->param();
        $type = $this->request->get('type');
        $rs = $this->validate($data, 'PagingParameter');
        if (!$rs){
            $this->error($rs);
        }
        $uid = $this->userId;
        $pagingOrders = ProductOrderModel::getSummaryByUser($type,$uid,$page,$size);
        if ($pagingOrders->isEmpty()){
            return [
                'data' => [],
                'current_page' => $pagingOrders->getCurrentPage()
            ];
        }
        $data = $pagingOrders->hidden(['prepay_id','snap_address','invoice_info'])->toArray();

        return [
            'data'=>$data,
            'current_page' => $pagingOrders->getCurrentPage()
        ];
    }

    public function checkOrderStatus()
    {
        $data = ProductOrderModel::where(['status'=>1, 'delete_time'=>0])->select();

        foreach ($data as $k=>$v){
            if (time() - strtotime($v['create_time']) > 7200){
                ProductOrderModel::where('id', $v['id'])->update(['status'=>5]);//设为过期
            }
        }
    }

    public function getDetail($id)
    {
        $this->checkOrderStatus();
        $data = $this->request->param();
        $rs = $this->validate($data, 'IDMustBePostiveInt');
        if (!$rs){
            $this->error($rs);
        }
        $orderDetail = ProductOrderModel::get($id);
        if (!$orderDetail){
            $this->error('订单获取错误');
        }
        return $orderDetail->hidden(['prepay_id']);
    }

    public function pleaceOrder()
    {
        $data = $this->request->param();
        $rs = $this->validate($data['products'],'OrderPlace');
        if (!$rs){
            $this->error($rs);
        }
        $uid = $this->getUserId();

        $order = new OrderService();
        $status = $order->place($uid, $data);
        return $status;
    }

    /**
     * 统计订单 各状态以及数量
     */
    public function statusNum()
    {
        $uid = $this->userId;
        $status['type1'] = ProductOrderModel::where(['user_id'=>$uid,'status'=>0])->count();
        $status['type2'] = ProductOrderModel::where(['user_id'=>$uid,'status'=>3])->count();
        $status['type3'] = ProductOrderModel::where(['user_id'=>$uid,'status'=>6])->count();
        $status['type4'] = ProductOrderModel::where(['user_id'=>$uid])->count();
        return $status;
    }

    /**
     * 确认收货
     */
    public function affirmGoods($id){
        $data = $this->request->param();
        $rs = $this->validate($data, 'IDMustBePostiveInt');
        if (!$rs){
            $this->error($rs);
        }
        $this->success('确认收货成功！',OrderStatusEnum::AFFIRM_GOODS);
        $orderDetail = ProductOrderModel::get($id);
        $orderDetail->status = OrderStatusEnum::AFFIRM_GOODS;
        if ($orderDetail->save()){
            $this->success('确认收货成功！',OrderStatusEnum::AFFIRM_GOODS);
        } else {
            $this->error('确认失败！');
        }
    }

    /**
     * 根据订单号获取物流信息
     */
    public function getExpressById($id)
    {
        $express = DeliveryModel::where('order_id',$id)->find();
        if ($express){
            $data = $this->getExpressByCode($express['invoice_no'],$express['shipping_code']);
            if ($data['status'] == 0){
                $this->success($data['msg'],$data['result']);
            } else {
                $this->error($data['msg'],$data['result']);
            }

        } else {
            $this->error('此产品包邮,无物流信息');
        }
    }


    /**
     * 接口获取物流信息
     */
    public function getExpressByCode($code,$name)
    {
        $host = "https://wuliu.market.alicloudapi.com";
        $path = "/kdi";
        $method = "GET";
        $appcode = "fd81db4673c844aeaca67eda520b3ca3";
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);
        $querys = "no=$code&type=$name";
        $bodys = "";
        $url = $host . $path . "?" . $querys;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        if (1 == strpos("$".$host, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        $data = curl_exec($curl);
        return json_decode($data,true);
    }



}