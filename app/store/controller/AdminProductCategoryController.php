<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/9
 * Time: 下午4:02
 */

namespace app\store\controller;


use app\store\model\ProductCategoryModel;
use app\store\model\ProductModel;
use cmf\controller\AdminBaseController;

class AdminProductCategoryController extends AdminBaseController
{

    /**
     * 商品分类
     * @adminMenu(
     *     'name'   => '商品分类',
     *     'parent' => 'store/AdminProduct/default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '商品分类',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $categories = ProductCategoryModel::where('delete_time', 'eq', 0)->select();
        $this->assign('categories', $categories);
        return $this->fetch();
    }

    /**
     * 添加分类
     * @adminMenu(
     *     'name'   => '添加分类',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加分类',
     *     'param'  => ''
     * )
     */
    public function add()
    {
        if ($this->request->isPost()){
            $post = $this->request->param();
            $rs = ProductCategoryModel::create($post);
            if ($rs) {
                $this->success('添加成功',url('AdminProductCategory/index'));
            } else {
                $this->error('添加失败');
            }
        } else {
            return $this->fetch();
        }
    }

    /**
     * 修改分类
     * @adminMenu(
     *     'name'   => '修改分类',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '修改分类',
     *     'param'  => ''
     * )
     */
    public function edit($id)
    {
        if ($this->request->isPost()) {
            $post   = $this->request->param();

            $rs = ProductCategoryModel::update($post);
            if ($rs){
                $this->success('修改成功!', url('AdminProductCategory/index'));
            } else {
                $this->error('修改失败！');
            }
        } else {
            $data = ProductCategoryModel::get($id);
            $this->assign('category', $data);
            return $this->fetch();
        }
    }

    /**
     * 删除分类
     * @adminMenu(
     *     'name'   => '删除分类',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '删除分类',
     *     'param'  => ''
     * )
     */
    public function delete($id)
    {
        $product = ProductModel::where('product_type', $id)->find();
        if ($product){
            $this->error('该订单下有商品，不允许删除');
        } else {
            $category = ProductCategoryModel::get($id);

            $category->delete_time = time();
            $category->save();
            $this->success('删除成功');
        }

    }

}