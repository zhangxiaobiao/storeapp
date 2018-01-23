<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/7
 * Time: 下午10:21
 */

namespace app\store\controller;


use app\store\model\InvoiceModel;
use cmf\controller\AdminBaseController;
use think\Db;



class AdminInvoiceController extends AdminBaseController
{

    /**
     * 发票管理
     * @adminMenu(
     *     'name'   => '发票管理',
     *     'parent' => 'store/AdminProductOrder/default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '发票管理',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $services = InvoiceModel::all();
        $this->assign('services', $services);
        return $this->fetch();
    }

    /**
     * 添加发票
     * @adminMenu(
     *     'name'   => '添加发票',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加发票',
     *     'param'  => ''
     * )
     */
    public function add()
    {
        return $this->fetch();
    }

    /**
     * 添加发票提交
     * @adminMenu(
     *     'name'   => '添加发票提交',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加发票提交',
     *     'param'  => ''
     * )
     */
    public function addPost()
    {
        if ($this->request->isPost()) {
            $post   = $this->request->param();
            $rs = InvoiceModel::create($post);
            if ($rs){
                $this->success('添加成功!', url('AdminService/index'));
            } else {
                $this->error('添加失败!');
            }
        }

    }

    /**
     * 编辑发票
     * @adminMenu(
     *     'name'   => '编辑发票',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '编辑发票',
     *     'param'  => ''
     * )
     */
    public function edit($id)
    {
        if ($this->request->isPost()) {
            $post   = $this->request->param();

            $rs = InvoiceModel::update($post);
            if ($rs){
                $this->success('修改成功!', url('AdminService/index'));
            } else {
                $this->error('修改失败！');
            }
        } else {
            $data = InvoiceModel::get($id);
            $this->assign('data', $data);
            return $this->fetch();
        }
    }

    /**
     * 发票删除
     * @adminMenu(
     *     'name'   => '发票删除',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '发票删除',
     *     'param'  => ''
     * )
     */
    public function delete($id)
    {
        $rs = InvoiceModel::destroy($id);
        if ($rs){
            $this->success("删除成功！");
        } else {
            $this->error('删除失败!');
        }
    }


}