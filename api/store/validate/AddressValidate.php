<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/10
 * Time: 下午1:28
 */

namespace api\store\validate;


use think\Validate;

class AddressValidate extends Validate
{
    protected $rule = [
        'id' => 'require|number',
        'name' => 'require|chsAlpha',
//        'phone' => '/^1[34578]{1}[0-9]{9}$/',
        'province' => 'require'
    ];

    protected $message = [
        'id.require' => '地址ID未获取到',
        'id.number'  => '地址参数错误',
        'name.require' => '姓名必填',
        'name.chsAlpha'  => '姓名必须是汉字或字母',
//        'phone' => '请输入正确的手机号',
        'province' => '请输入地址'
    ];

    protected $scene = [
        'getaddress'  => [ 'id' ],
        'setaddress' => ['name','province']
    ];
}