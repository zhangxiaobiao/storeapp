<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/13
 * Time: 下午8:15
 */

namespace api\store\validate;


use think\Validate;

class TokenValidate extends Validate
{
    protected $rule = [
        'code' => 'require|isNotEmpty'
    ];

    protected $message = [
        'code' => '缺少code参数'
    ];

    protected function isNotEmpty($value, $rule='', $data='', $field='')
    {
        if (empty($value)) {
            return false;
        } else {
            return true;
        }
    }
}