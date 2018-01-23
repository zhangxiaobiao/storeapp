<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2018/1/22
 * Time: 下午3:58
 */

namespace api\store\model;


use think\Model;

class SpecModel extends Model
{

    public function SpecWithItem()
    {
        return $this->hasMany('SpecItemModel', 'spec_id', 'id');
    }
}