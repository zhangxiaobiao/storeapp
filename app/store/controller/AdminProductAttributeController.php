<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/9
 * Time: 下午5:34
 */

namespace app\store\controller;


use app\store\model\ProductAttributeModel;
use app\store\model\ProductCategoryModel;
use cmf\controller\AdminBaseController;

class AdminProductAttributeController extends AdminBaseController
{

    /**
     * 商品属性
     * @adminMenu(
     *     'name'   => '商品属性',
     *     'parent' => 'store/AdminProduct/default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '商品属性',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $attributes = ProductAttributeModel::where('delete_time', 'eq', 0)->paginate(20);
        $this->assign('attributes', $attributes);
        return $this->fetch();
    }

    /**
     * 添加属性
     * @adminMenu(
     *     'name'   => '添加属性',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加属性',
     *     'param'  => ''
     * )
     */
    public function add()
    {
        if ($this->request->isPost()){
            $post = $this->request->param();
            $rs = ProductAttributeModel::create($post);
            if ($rs) {
                $this->success('添加成功',url('AdminProductAttribute/index'));
            } else {
                $this->error('添加失败');
            }
        } else {
            $this->assign('categories', ProductCategoryModel::getAllCategories());
            return $this->fetch();
        }
    }

    /**
     * 修改属性
     * @adminMenu(
     *     'name'   => '修改属性',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '修改属性',
     *     'param'  => ''
     * )
     */
    public function edit()
    {
        if ($this->request->isPost()) {
            $post   = $this->request->param();
            $rs = ProductAttributeModel::update($post);
            if ($rs){
                $this->success('修改成功!', url('AdminProductAttribute/index'));
            } else {
                $this->error('修改失败！');
            }
        } else {
            $id = $this->request->param();
            $id = $id['id'];
            $this->assign('categories', ProductCategoryModel::getAllCategories());
            $data = ProductAttributeModel::get($id);
            $this->assign('attribute', $data);
            return $this->fetch();
        }
    }

    /**
     * 删除属性
     * @adminMenu(
     *     'name'   => '删除属性',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '删除属性',
     *     'param'  => ''
     * )
     */
    public function delete($id)
    {
        $category = ProductAttributeModel::get($id);
        $category->delete_time = time();
        $category->save();
        $this->success('删除成功');

    }

    /**
     * 属性排序
     * @adminMenu(
     *     'name'   => '属性排序',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '属性排序',
     *     'param'  => ''
     * )
     */
    public function listOrder()
    {
        parent::listOrders(Db::name('product_attribute'));
        $this->success("排序更新成功！", '');
    }

}