<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/21
 * Time: 下午8:50
 */

namespace api\store\controller;


use cmf\controller\RestBaseController;
use think\Db;

class UserController extends RestBaseController
{

    public function getUserInfo()
    {
        $uid = $this->getUserId();
        $user = Db::name('user')->where('id', $uid)->field('avatar,mobile')->find();
        if ($user){
            $this->success('获取头像成功', $user);
        } else {
            $this->error('获取头像失败');
        }
    }

}