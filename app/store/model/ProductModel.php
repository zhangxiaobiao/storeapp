<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/9
 * Time: 上午11:06
 */

namespace app\store\model;


use think\Model;

class ProductModel extends Model
{

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;

    /**
     * 商品轮播图自动转数组
     * @param $value
     * @return string
     */
    public function getThumbAttr($value)
    {
        return json_decode($value,TRUE);
    }

    /**
     * details 自动转化
     * @param $value
     * @return string
     */
    public function getDetailsAttr($value)
    {
        return htmlspecialchars_decode(cmf_replace_content_file_url(htmlspecialchars_decode($value)));
    }

    /**
     * details 自动转化
     * @param $value
     * @return string
     */
    public function setDetailsAttr($value)
    {
        return htmlspecialchars(cmf_replace_content_file_url(htmlspecialchars_decode($value), true));
    }

    /**
     * published_time 自动完成
     * @param $value
     * @return false|int
     */
    public function setPublishedTimeAttr($value)
    {
        return strtotime($value);
    }

    /*
     * product_type 自动转化
     */
//    public function getProductTypeAttr($value)
//    {
//        $data = ProductCategoryModel::get("$value");
//        return $data['name'];
//    }

    /*
     * 关联模型（关联分类）
     */
    public function productType()
    {
        return $this->hasOne('ProductCategoryModel', 'id', 'product_type');
    }


}