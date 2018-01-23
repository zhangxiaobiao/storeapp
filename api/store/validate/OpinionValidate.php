<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/9
 * Time: 下午11:00
 */

namespace api\store\validate;


use think\Validate;

class OpinionValidate extends Validate
{
    protected $rule = [
        'opinion'        =>  'require'
    ];
    protected $message = [
        'opinion.require'    =>  '反馈建议不能为空'
    ];
}