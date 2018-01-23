<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/13
 * Time: 下午8:11
 */

namespace api\store\controller;


use api\store\service\UserToken;
use cmf\controller\RestBaseController;
use cmf\controller\RestUserBaseController;
use think\Db;

class TokenController extends RestBaseController
{

    public function verifyActoken()
    {
        $data = $this->request->header();
        $user = $this->user;
//        if (md5($user['mobile']) == $data['actoken'] && $user['token'] == $data['token']){
            $this->success('actoken验证成功');
//        } else {
//            $this->error(['code'=>10001, 'msg'=>'actoken验证失败']);
//        }
    }
}