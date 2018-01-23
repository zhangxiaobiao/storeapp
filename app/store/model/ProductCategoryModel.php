<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/9
 * Time: 下午4:03
 */

namespace app\store\model;


use think\Model;

class ProductCategoryModel extends Model
{

    public function getIsShowAttr($value)
    {
        return $value == 1 ? '显示' : '隐藏';
    }

    /*
     * 获取所有分类
     */
    public static function getAllCategories()
    {
        return self::all();
    }
}