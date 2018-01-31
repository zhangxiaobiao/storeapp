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
use think\Db;
use think\Request;

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
        #——————————————————————————————————————————————————————————————————————————————#
//        $detail = ProductOrderModel::where('id', $id)->find();
//        $detail['invoice_info'] = json_decode($detail['invoice_info'],true);
        $detail = $this -> _get_detail($id);
        #——————————————————————————————————————————————————————————————————————————————#
        $this->assign('detail', $detail);
        return $this->fetch();
    }

    /**
     * 获取订单详情
     * by lijiaxiang
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     */
    private function _get_detail($id)
    {
        $detail = ProductOrderModel::with('orderPrice')->where('id', $id)->find();
        $detail['invoice_info'] = json_decode($detail['invoice_info'],true);
        return $detail;
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
        $order->admin_note = key_exists('admin_note',$post)?$post['admin_note']:'';
        $order->status = 2;
        $order->save();

        //更新发货表
        $shipping['order_id'] = $order->id;
        $shipping['order_sn'] = $order->product_order_no;
        $shipping['user_id'] = $order->user_id['id'];
        $shipping['admin_id'] = cmf_get_current_admin_id();
        $address = $order->snap_address;
        $shipping['consignee'] = $address['name'];
//        $shipping['mobile'] = $address['mobile'];
//        $shipping['province'] = $address['province'];
//        $shipping['city'] = $address['city'];
//        $shipping['district'] = $address['country'];
//        $shipping['address'] = $address['detail'];
        $shipping['mobile'] = $address['tel'];
        $shipping['address'] = $address['address'];
        $shipping['shipping_price'] = $order->shipping_price;
        DeliveryModel::create($shipping);

        //更新发票表  start by lîjiâxiâng
        $invoice['order_id'] = $shipping['order_id'];//订单ID
        $invoice['user_id'] = $shipping['user_id'];//用户ID
        unset($shipping);//销毁大数组
        //获取订单的发票详情 && 赋值给新数组
        $detail = $this -> _get_detail($invoice['order_id']);
        $invoice['invoice_type'] = $detail['invoice_info']['invoiceInfo']['type'];//开票者类型
        $invoice['invoice_name'] = $detail['invoice_info']['invType'];//发票类型名
        $invoice['invoice_title'] = $detail['invoice_info']['invoiceInfo']['title'];//发票抬头
        $invoice['taxpayer'] = $detail['invoice_info']['invoiceInfo']['taxNumber'];//纳税人识别号
        $invoice['bank'] = $detail['invoice_info']['invoiceInfo']['bankName'];//银行名称
        $invoice['bank_no'] = $detail['invoice_info']['invoiceInfo']['bankAccount'];//银行账号
        $invoice['phone'] = $detail['invoice_info']['invoiceInfo']['telephone'];//固定场所手机号
        $invoice['address'] = $detail['invoice_info']['invoiceInfo']['companyAddress'];//固定场所地址
        $invoice['invoice_money'] = $detail['total_price'];//发票金额
        $invoice['atime'] = time();//创建时间
        unset($detail);//销毁大数组
        //入库
        Db::name('invoice') -> insert($invoice);
        //更新发票 end by lîjiâxiâng
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

    #——————————————————————————————————————————— 发票模块 Begin By lijixiang ———————————————————————————————————————————#

    /**
     * 查看全部发票信息
     * @return mixed
     */
    public function show_invoice(Request $request)
    {
        $type = array(0=>'待开票',1=>'已开票',2=>'已作废');
        $where = '';
        //如果带了查询条件
        if ($request -> isPost())
        {
            $param = $request->param();
            if ($param['product_order_no']!=''){
                $where .= "o.product_order_no = '".$param['product_order_no']."' and ";
            }
            if ($param['status']!=100)
            {
                $where .= "i.status = '".$param['status']."'";
                $select_type = $param['status'];
            }else{
                $where .='1 = 1';
            }

            //echo $where;die;
            $this -> assign('product_order_no',$param['product_order_no']);
        }

        //获取信息
        $data = Db::name('invoice') -> alias('i')
            -> field('i.invoice_id,invoice_name,i.order_id,invoice_type,i.user_id,i.invoice_title,atime,i.status,o.product_order_no,u.user_nickname,o.total_price')
            -> join('product_order o','o.id = i.order_id','left')
            -> join('user u','u.id = i.user_id','left')
            -> where($where)
            -> order('atime','desc')
            -> paginate(15);

        $select_type = isset($select_type)?$select_type:'1000';
        $this -> assign('type',$type);
        $this -> assign('select_type',$select_type);
        $this -> assign('data',$data);
        return $this -> fetch();

    }

    /**
     * 查看详情
     * @return mixed
     */
    public function invoice_detail()
    {
        $id = Request::instance()->param('id');
        $detail = Db::name('invoice') -> alias('i')
            -> field('invoice_id,product_order_no,user_nickname,mobile,total_price,total_count,atime,ctime,invoice_title,taxpayer,address,phone,bank,bank_no,invoice_type,invoice_name,snap_items,i.status,o.status ostu,snap_address')
            -> join('product_order o','o.id = i.order_id','left')
            -> join('user u','u.id = i.user_id','left')
            -> where('invoice_id',$id)
            -> find();
       // dump($detail);die;
        $this -> assign('detail',$detail);
        return $this -> fetch();
    }

    /**
     * 作废&&开票动作
     */
    public function invoice_do()
    {
        $param  = Request::instance()->param();
            $stu = $param['type']==1?1:2;
            $stu = Db::name('invoice')
                -> where('invoice_id',$param['id'])
                -> update(array('status'=>$stu,'ctime'=>time()));
            if ($stu)
            {
                $this -> success('成功');
            }else{
                $this -> error('失败');
            }


    }

    #——————————————————————————————————————————— 发票模块 End   By lijixiang ———————————————————————————————————————————#
}