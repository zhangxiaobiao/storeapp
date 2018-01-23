<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2018/1/19
 * Time: 上午11:28
 */

namespace app\store\model;


use think\Model;

class SpecModel extends Model
{

    public function addItem()
    {
        return $this->hasMany('SpecItemModel', 'spec_id');
    }


}