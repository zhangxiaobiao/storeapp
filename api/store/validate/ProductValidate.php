<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/10
 * Time: 下午1:28
 */

namespace api\store\validate;


use think\Validate;

class ProductValidate extends Validate
{
    protected $rule = [
        'id' => 'require|number',
    ];

    protected $message = [
        'id.require' => '商品ID未获取到',
        'id.number'  => '商品参数错误'
    ];
}