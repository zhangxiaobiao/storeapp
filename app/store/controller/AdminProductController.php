<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/9
 * Time: 上午11:00
 */

namespace app\store\controller;

use app\store\model\ProductCategoryModel;
use app\store\model\ProductModel;
use app\store\model\ProductTypeModel;
use cmf\controller\AdminBaseController;
use think\Db;

/**
 * Class AdminProductController 产品控制器
 * @package app\store\controller
 * @adminMenuRoot(
 *     'name'   => '产品中心',
 *     'action' => 'default',
 *     'parent' => '',
 *     'display'=> true,
 *     'order'  => 10000,
 *     'icon'   => 'car',
 *     'remark' => '产品中心'
 * )
 */
class AdminProductController extends AdminBaseController
{

    /**
     * 产品中心
     * @adminMenu(
     *     'name'   => '产品中心',
     *     'parent' => 'default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '产品中心',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        if ($this->request->isPost()){
            $category = $this->request->request('category');
            if ($category != 0){
                $products = ProductModel::with('productType')->order('list_order asc, id desc')->where('delete_time', 'eq', 0)->where('product_type',$category)->paginate(20);

            } else {
                $products = ProductModel::with('productType')->order('list_order asc, id desc')->where('delete_time', 'eq', 0)->paginate(20);

            }
            $this->assign('cur_category',$category);
            $this->assign('products', $products);

        } else {
            $products = ProductModel::with('productType')->order('list_order asc, id desc')->where('delete_time', 'eq', 0)->paginate(20);

            $this->assign('products', $products);
            $this->assign('cur_category', 0);
        }
        $this->assign('category', $this->getCategorys());

        return $this->fetch();
    }

    /**
     * 添加产品
     * @adminMenu(
     *     'name'   => '添加产品',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加产品',
     *     'param'  => ''
     * )
     */
    public function add()
    {
        //获取商品模型列表
        $types = ProductTypeModel::all();
        $this->assign('types', $types);
        $this->assign('categories', ProductCategoryModel::getAllCategories());
        return $this->fetch();
    }

    /**
     * 添加产品提交
     * @adminMenu(
     *     'name'   => '添加产品提交',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加产品提交',
     *     'param'  => ''
     * )
     */
    public function addPost()
    {
        if ($this->request->isPost()) {
            $data   = $this->request->param();
            if (!empty($data['photo_names']) && !empty($data['photo_urls'])) {
                $data['thumb']['photos'] = [];
                foreach ($data['photo_urls'] as $key => $url) {
                    $photoUrl = cmf_asset_relative_url($url);
                    array_push($data['thumb']['photos'], ["url" => $photoUrl, "name" => $data['photo_names'][$key]]);
                }
                unset($data['photo_urls']);
                unset($data['photo_names']);
                $data['thumb'] = json_encode($data['thumb']);
            }
            $rs = ProductModel::create($data);
            if ($rs){
                $this->success('添加成功!', url('AdminProduct/index'));
            } else {
                $this->error('添加失败!');
            }
        }
    }

    /**
     * 编辑产品
     * @adminMenu(
     *     'name'   => '编辑产品',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '编辑产品',
     *     'param'  => ''
     * )
     */
    public function edit($id)
    {
        if ($this->request->isPost()) {
            $data   = $this->request->param();
            if (!empty($data['photo_names']) && !empty($data['photo_urls'])) {
                $data['thumb']['photos'] = [];
                foreach ($data['photo_urls'] as $key => $url) {
                    $photoUrl = cmf_asset_relative_url($url);
                    array_push($data['thumb']['photos'], ["url" => $photoUrl, "name" => $data['photo_names'][$key]]);
                }
                unset($data['photo_urls']);
                unset($data['photo_names']);
                $data['thumb'] = json_encode($data['thumb']);
            }
            $rs = ProductModel::update($data);
            if ($rs){
                $this->success('修改成功!', url('AdminProduct/index'));
            } else {
                $this->error('修改失败！');
            }
        } else {
            //获取商品模型列表
            $types = ProductTypeModel::all();
            $this->assign('types', $types);

            $this->assign('categories', ProductCategoryModel::getAllCategories());
            $data = ProductModel::get($id);
            $this->assign('product', $data);
            return $this->fetch();
        }
    }

    /**
     * 产品删除
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
        $rs = ProductModel::where('id', $id)->update(['delete_time'=>time()]);
        if ($rs){
            $this->success("删除成功！");
        } else {
            $this->error('删除失败!');
        }
    }

    /**
     * 产品排序
     * @adminMenu(
     *     'name'   => '产品排序',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '产品排序',
     *     'param'  => ''
     * )
     */
    public function listOrder()
    {
        parent::listOrders(Db::name('product'));
        $this->success("排序更新成功！", '');
    }

    /**
     * 产品推荐
     * @adminMenu(
     *     'name'   => '产品推荐',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '产品推荐',
     *     'param'  => ''
     * )
     */
    public function recommend()
    {
        $param           = $this->request->param();

        if (isset($param['ids']) && isset($param["yes"])) {
            $ids = $this->request->param('ids/a');

            ProductModel::where(['id' => ['in', $ids]])->update(['recommended' => 1]);

            $this->success("推荐成功！", '');

        }
        if (isset($param['ids']) && isset($param["no"])) {
            $ids = $this->request->param('ids/a');

            ProductModel::where(['id' => ['in', $ids]])->update(['recommended' => 0]);

            $this->success("取消推荐成功！", '');

        }
    }

    /**
     * 产品上架
     * @adminMenu(
     *     'name'   => '产品上架',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '产品上架',
     *     'param'  => ''
     * )
     */
    public function publish()
    {
        $param           = $this->request->param();

        if (isset($param['ids']) && isset($param["yes"])) {
            $ids = $this->request->param('ids/a');

            ProductModel::where(['id' => ['in', $ids]])->update(['publish' => 1, 'published_time'=>time()]);

            $this->success("发布成功！", '');
        }

        if (isset($param['ids']) && isset($param["no"])) {
            $ids = $this->request->param('ids/a');

            ProductModel::where(['id' => ['in', $ids]])->update(['publish' => 0]);

            $this->success("取消发布成功！", '');
        }

    }


    //获取分类信息
    public function getCategorys()
    {
        $data = ProductCategoryModel::getAllCategories();
        return $data;
    }

}