<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/16
 * Time: 下午6:29
 */

namespace api\store\validate;


use think\Validate;

class IDMustBePostiveIntValidate extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInteger',
    ];
}