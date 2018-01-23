<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/13
 * Time: 下午8:28
 */

namespace api\store\service;

use think\Db;

class Token
{
    public static function isValidOperate($checkedUID){

    }

    public static function getCurrentTokenVar($id){
        $data = Db::name('third_party_user')->where('user_id',$id)->find();
        return $data['openid'];
    }
}