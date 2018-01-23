<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/16
 * Time: 下午4:49
 */

namespace api\store\controller;


use api\store\service\Pay as PayService;
use cmf\controller\RestBaseController;

class PayController extends RestBaseController
{

    public function getPreOrder($id='')
    {
        $rs = $this->validate($id, 'IDMustBePostiveInt');
        if (!$rs){
            $this->error($rs);
        }
        $pay = new PayService($id);
        return $pay->pay();
    }

    //trade_state
    public function checkOrderStatus($id='')
    {
        $rs = $this->validate($id, 'IDMustBePostiveInt');
        if (!$rs){
            $this->error($rs);
        }
        $pay = new PayService($id);
        $result = $pay->checkOrderPay();
        dump($result);
    }

}