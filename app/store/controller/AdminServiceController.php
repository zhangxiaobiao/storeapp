<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/7
 * Time: 下午10:21
 */

namespace app\store\controller;


use app\store\model\ServiceModel;
use cmf\controller\AdminBaseController;
use think\Db;


/**
 * Class AdminServiceController 客服中心控制器
 * @package app\store\controller
 * @adminMenuRoot(
 *     'name'   => '客服中心',
 *     'action' => 'default',
 *     'parent' => '',
 *     'display'=> true,
 *     'order'  => 10000,
 *     'icon'   => 'yelp',
 *     'remark' => '客服中心'
 * )
 */
class AdminServiceController extends AdminBaseController
{

    /**
     * 客服中心
     * @adminMenu(
     *     'name'   => '客服中心',
     *     'parent' => 'default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '客服中心',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $services = ServiceModel::order('list_order asc, id desc')->select();
        $this->assign('services', $services);
        return $this->fetch();
    }

    /**
     * 添加客服中心
     * @adminMenu(
     *     'name'   => '添加客服中心',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加客服中心',
     *     'param'  => ''
     * )
     */
    public function add()
    {
        return $this->fetch();
    }

    /**
     * 添加客服中心提交
     * @adminMenu(
     *     'name'   => '添加客服中心提交',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加客服中心提交',
     *     'param'  => ''
     * )
     */
    public function addPost()
    {
        if ($this->request->isPost()) {
            $post   = $this->request->param();
            $rs = ServiceModel::create($post);
            if ($rs){
                $this->success('添加成功!', url('AdminService/index'));
            } else {
                $this->error('添加失败!');
            }
        }

    }

    /**
     * 编辑客服中心
     * @adminMenu(
     *     'name'   => '编辑客服中心',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '编辑客服中心',
     *     'param'  => ''
     * )
     */
    public function edit($id)
    {
        if ($this->request->isPost()) {
            $post   = $this->request->param();

            $rs = ServiceModel::update($post);
            if ($rs){
                $this->success('修改成功!', url('AdminService/index'));
            } else {
                $this->error('修改失败！');
            }
        } else {
            $data = ServiceModel::get($id);
            $this->assign('data', $data);
            return $this->fetch();
        }
    }

    /**
     * 客服中心删除
     * @adminMenu(
     *     'name'   => '客服中心删除',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '客服中心删除',
     *     'param'  => ''
     * )
     */
    public function delete($id)
    {
        $rs = ServiceModel::destroy($id);
        if ($rs){
            $this->success("删除成功！");
        } else {
            $this->error('删除失败!');
        }
    }

    /**
     * 客服中心排序
     * @adminMenu(
     *     'name'   => '客服中心排序',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '客服中心排序',
     *     'param'  => ''
     * )
     */
    public function listOrder()
    {
        parent::listOrders(Db::name('service'));
        $this->success("排序更新成功！", '');
    }
}