<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/10
 * Time: 下午12:57
 */

namespace api\store\controller;


use api\store\model\ProductModel;
use cmf\controller\RestBaseController;

class ProductController extends RestBaseController
{

    /*
     * 获取全部商品
     */
    public function getAllProducts()
    {
        $rProducts = ProductModel::where(['category'=>1,'delete_time'=>0])->order('list_order asc, id desc')
            ->field('id,title,price')
            ->select();
        if (!$rProducts){
            $this->error('获取全部服务费商品失败');
        }
//        return $this->fetch();
        $this->success('获取全部服务费商品成功', $rProducts);
    }



    /*
     * 获取某个id商品详情
     */
    public function getOneProduct($id)
    {
        $rs = $this->validate(['id'=>$id], 'Product');
        if ($rs !== true){
            $this->error($rs);
        }
        $product = ProductModel::with('productSpec.SpecWithItem')->find($id);
        if (!$product){
            $this->error('获取商品详情失败');
        }
        $product->hidden(["publish","published_time","create_time","list_order","recommended","product_type","orgprice","initprice","delete_time","category"]);

        $this->success('获取商品详情成功', $product);
    }

}