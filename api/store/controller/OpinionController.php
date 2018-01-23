<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/9
 * Time: 下午10:56
 */

namespace api\store\controller;


use api\store\model\OpinionModel;
use cmf\controller\RestBaseController;
use cmf\controller\RestUserBaseController;
use think\Db;

class OpinionController extends RestBaseController
{

    /*
     * 意见反馈提交
     */
    public function opinionPost()
    {
        $uid = $this->getUserId();
        $post = $this->request->post();
        $post['user_id'] = $uid;
        $result          = $this->validate($post, 'Opinion');
        if ($result !== true) {
            $this->error($result);
        }
        $rs = OpinionModel::create($post);
        if ($rs) {
            $this->success('感谢您的反馈');
        } else {
            $this->error('反馈失败');
        }
    }
}