<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/10
 * Time: 下午1:28
 */

namespace api\store\validate;


use think\Validate;

class OrderPlaceValidate extends Validate
{
    protected $rule = [
        'products'=> 'checkProducts'
    ];

    protected $singleRule = [
        'id' => 'require|isPositiveInteger',
        'counts' => 'require|isPositiveInteger',
    ];


    protected function checkProducts($values)
    {
        if (is_array($values)){
            return '商品参数不正确';
        }

        if (empty($values)){
            return '商品列表不能为空';
        }

        foreach ($values as $value)
        {
            $this->checkProduct($value);
        }

        return true;

    }

    protected function checkProduct($value)
    {
        $validate = new Validate($this->singleRule);
        $result = $validate->check($value);
        if (!$result){
            return '商品列表参数错误';
        }
    }

    protected function isPositiveInteger($value, $rule='', $data='', $field='')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        }
        return $field.'必须为正整数';
    }
}