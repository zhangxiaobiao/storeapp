<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/9
 * Time: 下午3:24
 */

namespace app\store\controller;


use app\store\model\OrderModel;
use cmf\controller\AdminBaseController;

class AdminOrderController extends AdminBaseController
{

    /**
     * 发货订单
     * @adminMenu(
     *     'name'   => '发货订单',
     *     'parent' => 'store/AdminTruck/default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '发货订单',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        if ($this->request->isPost()) {
            $keyword = $this->request->post('keyword');
            $productOrder = OrderModel::with(['userInfo','truckInfo'])
                ->where('delete_time','0')
                ->where('order_no','like',"%$keyword%")
                ->order('id desc')
                ->paginate(20);
            $this->assign('keyword', $keyword);
        } else {
            $productOrder = OrderModel::with(['userInfo','truckInfo'])->where('delete_time','0')->order('id desc')->paginate(20);

        }
        $this->assign('orders', $productOrder);
        return $this->fetch();
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
        $detail = OrderModel::with(['userInfo','truckInfo','sendAddress','receiveAddress'])->where('id', $id)->find();
//        dump($detail->toArray());die;
        $this->assign('detail', $detail);
        return $this->fetch();
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

            $rs = OrderModel::update($post);
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
        $order = OrderModel::get($id);
        if ($order['complete_time'] == 0){
            $this->error('订单未完成，不允许删除');
        } else {
            $order->delete_time = time();
            $order->save();
            $this->success('删除成功');
        }
    }

    public function done($id)
    {
        $rs = OrderModel::where('id', $id)->update(['complete_time'=>time()]);
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