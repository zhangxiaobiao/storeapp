<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/16
 * Time: 下午10:56
 */

namespace api\store\validate;


use think\Validate;

class PagingParameterValidate extends BaseValidate
{
    protected $rule = [
        'page' => 'isPositiveInteger',
        'size' => 'isPositiveInteger'
    ];

    protected $message = [
        'page' => '分页参数必须是正整数',
        'size' => '分页参数必须是正整数'
    ];
}