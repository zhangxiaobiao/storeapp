<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/10
 * Time: 下午1:28
 */

namespace api\store\validate;


use think\Validate;

class OrderValidate extends Validate
{
    protected $rule = [
        'id' => 'require|number',
    ];


    protected $message = [
        'id.require' => '订单ID未获取到',
        'id.number'  => '订单参数错误'

    ];

}