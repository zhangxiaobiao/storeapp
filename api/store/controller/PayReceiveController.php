<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/17
 * Time: 下午6:07
 */

namespace api\store\controller;


use cmf\controller\RestBaseController;
use api\store\service\WxNotify;
use think\Controller;


class PayReceiveController
{

    public function receiveNotify()
    {
        $xml = file_get_contents('php://input');
        file_put_contents("test.txt", $xml, FILE_APPEND);
        //检测库存量
        //更新订单的status状态
        //减库存
        //如果成功处理，返回微信成功处理的消息，否则，返回没有成功处理
        $notify = new WxNotify();
        $notify->Handle();
    }
}