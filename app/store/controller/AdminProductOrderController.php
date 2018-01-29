<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/9
 * Time: 下午3:24
 */

namespace app\store\controller;


use app\store\model\DeliveryModel;
use app\store\model\ProductOrderModel;
use app\store\model\ShippingModel;
use cmf\controller\AdminBaseController;

/**
 * Class AdminProductOrderController 订单管理
 * @package app\store\controller
 * @adminMenuRoot(
 *     'name'   => '订单管理',
 *     'action' => 'default',
 *     'parent' => '',
 *     'display'=> true,
 *     'order'  => 10000,
 *     'icon'   => 'slideshare',
 *     'remark' => '订单管理'
 * )
 */

class AdminProductOrderController extends AdminBaseController
{

    /**
     * 产品订单
     * @adminMenu(
     *     'name'   => '产品订单',
     *     'parent' => 'store/AdminProductOrder/default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '产品订单',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $this->checkOrderStatus();
        if ($this->request->isPost()){
            $keyword = $this->request->post('keyword');
            $status = $this->request->post('status');
            if ($status == 999){
                $where = [];
            } else {
                $where['status'] = $status;
            }
            $productOrder = ProductOrderModel::where('product_order_no','like', "%$keyword%")
                ->where($where)
                ->where('delete_time', '=', 0)
                ->paginate(20);
            $this->assign('keyword', $keyword);
            $this->assign('current_status', $status);
        } else {
            $this->assign('current_status', 999);
            $productOrder = ProductOrderModel::order('id desc')->where('delete_time', '=', 0)->paginate(20);

        }
        $this->assign('orders', $productOrder);
        $this->assign('status', ProductOrderModel::getOrderStatus());
        return $this->fetch();
    }

    public function checkOrderStatus()
    {
        $data = ProductOrderModel::where('status', 0)->select();
        foreach ($data as $k=>$v){
            if (time() - $v['create_time'] > 7200){
                ProductOrderModel::where('id', $v['id'])->update(['status'=>5]);//设为过期
            }
        }
    }

    /**
     * 查看订单
     * @adminMenu(
     *     'name'   => '查看订单',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '查看订单',
     *     'param'  => ''
     * )
     */
    public function detail($id)
    {
        $detail = ProductOrderModel::where('id', $id)->find();
        $this->assign('detail', $detail);
        return $this->fetch();
    }

    /**
     * 确认订单
     * @adminMenu(
     *     'name'   => '确认订单',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '确认订单',
     *     'param'  => ''
     * )
     */
    public function confirm()
    {
        $post = $this->request->param();
        $order = ProductOrderModel::get($post['id']);
        $order->admin_note = $post['admin_note'];
        $order->status = 2;
        $order->save();

        //更新发货表
        $shipping['order_id'] = $order->id;
        $shipping['order_sn'] = $order->product_order_no;
        $shipping['user_id'] = $order->user_id;
        $shipping['admin_id'] = cmf_get_current_admin_id();
        $address = $order->snap_address;
        $shipping['consignee'] = $address['name'];
        $shipping['mobile'] = $address['mobile'];
        $shipping['province'] = $address['province'];
        $shipping['city'] = $address['city'];
        $shipping['district'] = $address['country'];
        $shipping['address'] = $address['detail'];
        $shipping['shipping_price'] = $order->shipping_price;

        DeliveryModel::create($shipping);
        //更新发票表
        //todo

        $rs = true;
        if ($rs){
            $this->success('确认订单成功!', url('AdminProductOrder/index'));
        } else {
            $this->error('确认失败！');
        }
    }


    /**
     * 修改订单
     * @adminMenu(
     *     'name'   => '修改订单',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '修改订单',
     *     'param'  => ''
     * )
     */
    public function edit($id)
    {
        if ($this->request->isPost()) {
            $post   = $this->request->param();

            $rs = ProductOrderModel::update($post);
            if ($rs){
                $this->success('修改成功!', url('AdminProduct/detail',['id'=>$post['id']]));
            } else {
                $this->error('修改失败！');
            }
        } else {
            $data = ProductOrderModel::get($id);
            $this->assign('detail', $data);
            return $this->fetch();
        }
    }

    /**
     * 删除订单
     * @adminMenu(
     *     'name'   => '删除订单',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '删除订单',
     *     'param'  => ''
     * )
     */
    public function delete($id)
    {
        $order = ProductOrderModel::get($id);
        if (!$order['done_time']){
            $this->error('订单未完成，不允许删除');
        } else {
            $order->delete_time = time();
            $order->save();
            $this->success('删除成功');
        }
    }

    public function done($id)
    {
        $rs = ProductOrderModel::where('id', $id)->update(['done_time'=>time(),'status'=>3]);
        if ($rs){
            $this->success('标记成功');
        } else {
            $this->error('标记失败');
        }
    }

    /**
     * 添加订单
     * @adminMenu(
     *     'name'   => '添加订单',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加订单',
     *     'param'  => ''
     * )
     */
    public function add()
    {

    }
}