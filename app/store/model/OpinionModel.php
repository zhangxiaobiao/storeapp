<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/7
 * Time: 下午11:13
 */

namespace app\store\model;


use think\Model;

class OpinionModel extends Model
{

    public function userInfo()
    {
        return $this->belongsTo('UserModel', 'user_id', 'id');
    }
}