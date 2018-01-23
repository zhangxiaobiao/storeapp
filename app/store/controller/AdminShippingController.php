<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/7
 * Time: 下午10:21
 */

namespace app\store\controller;


use app\store\model\ShippingModel;
use cmf\controller\AdminBaseController;
use think\Db;


/**
 * Class AdminShippingController 快递控制器
 * @package app\store\controller
 * @adminMenuRoot(
 *     'name'   => '商城配置',
 *     'action' => 'default',
 *     'parent' => '',
 *     'display'=> true,
 *     'order'  => 10000,
 *     'icon'   => 'puzzle-piece',
 *     'remark' => '商城配置'
 * )
 */
class AdminShippingController extends AdminBaseController
{

    /**
     * 快递管理
     * @adminMenu(
     *     'name'   => '快递管理',
     *     'parent' => 'store/AdminShipping/default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '快递管理',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $shippings = ShippingModel::all();
        $this->assign('shippings', $shippings);
        return $this->fetch();
    }

    /**
     * 添加快递
     * @adminMenu(
     *     'name'   => '添加快递',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加快递',
     *     'param'  => ''
     * )
     */
    public function add()
    {
        return $this->fetch();
    }

    /**
     * 添加快递提交
     * @adminMenu(
     *     'name'   => '添加快递提交',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加快递提交',
     *     'param'  => ''
     * )
     */
    public function addPost()
    {
        if ($this->request->isPost()) {
            $post   = $this->request->param();
            $rs = ShippingModel::create($post);
            if ($rs){
                $this->success('添加成功!', url('AdminShipping/index'));
            } else {
                $this->error('添加失败!');
            }
        }

    }

    /**
     * 编辑快递
     * @adminMenu(
     *     'name'   => '编辑快递',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '编辑快递',
     *     'param'  => ''
     * )
     */
    public function edit($id)
    {
        if ($this->request->isPost()) {
            $post   = $this->request->param();

            $rs = ShippingModel::update($post);
            if ($rs){
                $this->success('修改成功!', url('AdminShipping/index'));
            } else {
                $this->error('修改失败！');
            }
        } else {
            $data = ShippingModel::get($id);
            $this->assign('shipping', $data);
            return $this->fetch();
        }
    }

    /**
     * 快递删除
     * @adminMenu(
     *     'name'   => '快递删除',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '快递删除',
     *     'param'  => ''
     * )
     */
    public function delete($id)
    {
        $rs = ShippingModel::destroy($id);
        if ($rs){
            $this->success("删除成功！");
        } else {
            $this->error('删除失败!');
        }
    }


}