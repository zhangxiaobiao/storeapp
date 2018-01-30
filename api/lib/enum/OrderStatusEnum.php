<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/16
 * Time: 下午7:02
 */
namespace api\lib\enum;

class OrderStatusEnum
{
    // 待支付
    const UNPAID = 0;

    // 已支付
    const PAID = 1;

    //已确认
    const AFFIRM = 2;

    // 已发货
    const DELIVERED = 3;

    // 已支付，但库存不足
    const PAID_BUT_OUT_OF = 4;

    // 已处理PAID_BUT_OUT_OF
    const HANDLED_OUT_OF = 5;

    //已确认收货,待评价
    const AFFIRM_GOODS = 6;

    //已评价，完成
    const DONE = 7;

}