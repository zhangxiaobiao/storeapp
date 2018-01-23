<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/16
 * Time: 下午4:01
 */

namespace api\store\controller;


use cmf\controller\RestUserBaseController;

class RestPayController extends RestUserBaseController
{
    public function _initialize()
    {
        parent::_initialize();
        $data = $this->request->header('actoken');
        $user = $this->user;
        if (empty($data) || md5($user['mobile']) != $data){
            $this->error(['code'=>10001, 'msg'=>'actoken验证失败']);
        }

    }
}