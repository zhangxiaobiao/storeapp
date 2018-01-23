<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/9
 * Time: 下午10:43
 */

namespace api\store\controller;


use api\store\model\AboutusModel;
use cmf\controller\RestBaseController;

class AboutusController extends RestBaseController
{

    /*
     * 关于我们 客服电话 服务条款
     */
    public function getAboutInfo()
    {
        $info = AboutusModel::limit(1)->find();
        if (!$info){
            $this->error('未获取到关于我们信息');
        }
        $this->success('获取关于我们信息成功', $info);
    }

}