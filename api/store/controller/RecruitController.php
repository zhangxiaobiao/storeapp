<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/10
 * Time: 下午2:09
 */

namespace api\store\controller;


use api\store\model\RecruitModel;
use cmf\controller\RestBaseController;
use cmf\controller\RestUserBaseController;

class RecruitController extends RestBaseController
{

    /*
     * 司机招募表单提交
     */
    public function recruitPost()
    {
        $data = $this->request->post();
        $rs = $this->validate($data, 'Recruit');
        if ($rs !== true){
            $this->error($rs);
        }
        $rt = RecruitModel::create($data);
        if ($rt) {
            $this->success('申请成功！');
        } else {
            $this->error('提交失败，请稍后再试');
        }
    }
}