<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/9
 * Time: 下午7:01
 */

namespace app\store\controller;


use app\store\model\ProductTypeModel;
use cmf\controller\AdminBaseController;
use think\Db;


class AdminProductTypeController extends AdminBaseController
{

    /**
     * 模型管理
     * @adminMenu(
     *     'name'   => '模型管理',
     *     'parent' => 'store/AdminProduct/default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '模型管理',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $types = ProductTypeModel::all();
        $this->assign('types', $types);
        return $this->fetch();
    }

    /**
     * 添加模型
     * @adminMenu(
     *     'name'   => '添加模型',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加模型',
     *     'param'  => ''
     * )
     */
    public function add()
    {
        if ($this->request->isPost()){
            $post = $this->request->param();
            $rs = ProductTypeModel::create($post);
            if ($rs) {
                $this->success('添加成功',url('AdminProductType/index'));
            } else {
                $this->error('添加失败');
            }
        } else {
            return $this->fetch();
        }
    }

    /**
     * 修改模型
     * @adminMenu(
     *     'name'   => '修改模型',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '修改模型',
     *     'param'  => ''
     * )
     */
    public function edit($id)
    {
        if ($this->request->isPost()) {
            $post   = $this->request->param();
            $rs = ProductTypeModel::update($post);
            if ($rs){
                $this->success('修改成功!', url('AdminProductType/index'));
            } else {
                $this->error('修改失败！');
            }
        } else {
            $data = ProductTypeModel::get($id);
            $this->assign('type', $data);
            return $this->fetch();
        }
    }

    /**
     * 删除模型
     * @adminMenu(
     *     'name'   => '删除模型',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '删除模型',
     *     'param'  => ''
     * )
     */
    public function delete($id)
    {
        $category = ProductTypeModel::get($id);
        $category->delete_time = time();
        $category->save();
        $this->success('删除成功');

    }


}