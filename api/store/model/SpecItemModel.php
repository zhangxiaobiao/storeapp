<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2018/1/22
 * Time: 下午3:57
 */

namespace api\store\model;


use think\Model;

class SpecItemModel extends Model
{

    public function getItemAttr($value)
    {
        return trim($value);
    }
}