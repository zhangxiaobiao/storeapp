<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/7
 * Time: 下午10:21
 */

namespace app\store\controller;


use app\store\model\DeliveryModel;
use app\store\model\ProductOrderModel;
use app\store\model\ShippingModel;
use cmf\controller\AdminBaseController;
use think\Db;



class AdminDeliveryController extends AdminBaseController
{

    /**
     * 发货管理
     * @adminMenu(
     *     'name'   => '发货管理',
     *     'parent' => 'store/AdminProductOrder/default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '发货管理',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        if ($this->request->isPost()){
            $keyword = $this->request->post('keyword');
            $status = $this->request->post('status');
            if ($keyword){
                $where2['order_sn'] = ['like',"%$keyword%"];
            } else {
                $where2 = [];
            }
            if ($status != 999){
                $where1['status'] = $status;
            } else {
                $where1['status'] = ['<',999];
            }

            $delivery = DeliveryModel::hasWhere('deliveryOrder', $where1)->where($where2)->paginate(20);
            $this->assign('keyword', $keyword);
        } else {
            $delivery = DeliveryModel::with('deliveryOrder')->order('id desc')->where('delete_time', '=', 0)->paginate(20);

        }
//        dump($delivery);die;
        $this->assign('delivery', $delivery);
        return $this->fetch();
    }

    /**
     * 添加发货
     * @adminMenu(
     *     'name'   => '添加发货',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加发货',
     *     'param'  => ''
     * )
     */
    public function add()
    {
        return $this->fetch();
    }

    /**
     * 添加发货提交
     * @adminMenu(
     *     'name'   => '添加发货提交',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加发货提交',
     *     'param'  => ''
     * )
     */
    public function addPost()
    {
        if ($this->request->isPost()) {
            $post   = $this->request->param();
            $rs = DeliveryModel::create($post);
            if ($rs){
                $this->success('添加成功!', url('AdminDelivery/index'));
            } else {
                $this->error('添加失败!');
            }
        }

    }

    /**
     * 编辑发货
     * @adminMenu(
     *     'name'   => '编辑发货',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '编辑发货',
     *     'param'  => ''
     * )
     */
    public function edit($id)
    {
        if ($this->request->isPost()) {
            $post   = $this->request->param();

            $rs = DeliveryModel::update($post);
            if ($rs){
                $this->success('修改成功!', url('AdminDelivery/index'));
            } else {
                $this->error('修改失败！');
            }
        } else {
            $data = DeliveryModel::get($id);
            $this->assign('data', $data);
            return $this->fetch();
        }
    }

    /**
     * 发货删除
     * @adminMenu(
     *     'name'   => '发货删除',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '发货删除',
     *     'param'  => ''
     * )
     */
    public function delete($id)
    {
        $rs = DeliveryModel::destroy($id);
        if ($rs){
            $this->success("删除成功！");
        } else {
            $this->error('删除失败!');
        }
    }

    /**
     * 发货
     * @adminMenu(
     *     'name'   => '发货',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '发货',
     *     'param'  => ''
     * )
     */
    public function send($id)
    {
        if ($this->request->isPost()){
            $post = $this->request->param();
            $shipping = ShippingModel::where('shipping_code', $post['shipping_code'])->field('shipping_name')->find();
            $post['shipping_name'] = $shipping['shipping_name'];

            $rs = DeliveryModel::update($post);
            if ($rs){
                $deliveryInfo = DeliveryModel::get($rs->id);
                ProductOrderModel::update(['id'=>$deliveryInfo->order_id,'status'=>3]);
                $this->success('发货成功!');
            } else {
                $this->error('发货失败！');
            }
        } else {
            $delivery = DeliveryModel::with('deliveryOrder')->order('id desc')->where('order_id', '=', $id)->find();
            $shippings = ShippingModel::all();

            $this->assign('shippings', $shippings);
//        dump($delivery->toArray());die;
            $this->assign('delivery', $delivery);
            return $this->fetch();
        }


    }



}