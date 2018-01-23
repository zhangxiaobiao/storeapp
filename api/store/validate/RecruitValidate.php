<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/10
 * Time: 下午1:28
 */

namespace api\store\validate;


use think\Validate;

class RecruitValidate extends Validate
{
    protected $rule = [
        'name' => 'require|chsAlpha',
        'phone' => '/^1[34578]{1}[0-9]{9}$/',
        'area' => 'require',
        'address' => 'require'
    ];

    protected $message = [
        'name.require' => '姓名必填',
        'name.chsAlpha'  => '姓名必须是汉字或字母',
        'phone' => '请输入正确的手机号',
        'area' => '请输入地址',
        'address' => '请输入详细地址'
    ];
}