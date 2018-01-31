<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2018/1/30
 * Time: 下午5:27
 */

namespace api\store\controller;


use api\store\model\EvaluateModel;
use app\store\model\ProductOrderProductModel;
use cmf\controller\RestBaseController;

class EvaluateController extends RestBaseController
{
    /**
     * 评价
     */
    public function prise()
    {
        $data = $this->request->param();
        $rs = $this->validate($data, 'IDMustBePostiveInt');
        if (!$rs){
            $this->error($rs);
        }
        $rst = ProductOrderProductModel::get($data['id']);
        if (!$rst){
            $this->error('订单不存在');
        }

        $post['order_id'] = $data['id'];
        $post['star'] = $data['star'];
        $post['message'] = $data['message'];
        $result = EvaluateModel::create($post);
        if ($result){
            $this->success('我们已经收到您的评价');
        } else {
            $this->error('提交失败,请稍后再试');
        }

    }
}