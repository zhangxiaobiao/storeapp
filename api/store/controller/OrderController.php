<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/10
 * Time: 下午1:59
 */

namespace api\store\controller;


use api\store\model\AddressModel;
use api\store\model\OrderModel;
use api\store\service\Order as OrderService;
use cmf\controller\RestBaseController;

class OrderController extends RestBaseController
{

    //创建订单
    public function createOrder()
    {
        $data = $this->request->param();
        $uid = $this->getUserId();
        if (!$uid){
            $this->error('获取用户信息错误');
        }
        $order['order_no'] = 'FH'.OrderService::makeOrderNo();
        $order['user_id'] = $uid;
        $order['truck_id'] = $data['truck']['id']+1;
        $order['specialform'] = $data['truck']['specialform'];
        $order['send_addr'] = $data['sendAddress'];
        $order['received_addr'] = $data['receiveAddress'];
        $order['extrarequire'] = $data['extrarequire'];
        $order['goodskind'] = $data['goodskind'];
        $order['carfollow'] = $data['carfollow'];
        $order['makeorder'] = $data['makeorder'];
        $sendUser = $data['sendUser'];
        $receiveUser = $data['receiveUser'];
        if (in_array('save',$data['sendUser'])){
            $sendUser['type'] = 2;
        } else {
            $sendUser['type'] = 3;
        }
        unset($sendUser['checkBox']);
        if (in_array('save', $data['receiveUser'])){
            $receiveUser['type'] = 2;
        } else {
            $receiveUser['type'] = 3;
        }
        unset($receiveUser['checkBox']);
        $sendUserModel = AddressModel::create($sendUser);
        $order['send_addr_id'] = $sendUserModel->id;
        $receiveUserModel = AddressModel::create($receiveUser);
        $order['received_addr_id'] = $receiveUserModel->id;

        $orderModel = OrderModel::create($order);
        if ($orderModel){
            $this->success('提交成功');
        } else {
            $this->error('提交失败');
        }
    }

    //获取全部（二维数组，已完成和未完成）
    public function getAllOrders(){
        $uid = $this->getUserId();
        $data = OrderModel::order('id desc')->where('user_id', $uid)->select();
        $order = [];
        foreach ($data as $k=>$v){
            if ($v['complete_time'] != 0){
                $order['done'][] = $v;
            } else {
                $order['continue'][] = $v;
            }
        }
        return $order;
    }

    //获取某一个订单详情
    public function getOrderById($id)
    {
        $data = OrderModel::with(['truckInfo','sendAddress','receiveAddress'])->where('id', $id)->find();
        return $data;
    }
    public  function test(){
        $data = [
            'truck'=>[
                'id'=>1,
                'specialform'=>1
            ],
            'sendAddress'=>'xxxxx',
            'receiveAddress'=>'xxxxx',
            'extrarequire'=>'xxx|xxx|xxx',
            'goodskind'=>'xxx',
            'carfollow'=>'xxx',
            'sendUser'=>[

                'name'=>'xxx',
                'mobile'=>'xxx',
                'province'=>'xxx',
                'city'=>'xxx',
                'country'=>'xxx',
                'detail'=>'xxx',

            ],
            'receiveUser'=>[
                'name'=>'xxx',
                'mobile'=>'xxx',
                'province'=>'xxx',
                'city'=>'xxx',
                'country'=>'xxx',
                'detail'=>'xxx',
            ],
            'makeorder'=>''
        ];
    }
}