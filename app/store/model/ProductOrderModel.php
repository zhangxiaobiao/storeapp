<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/9
 * Time: 下午3:28
 */

namespace app\store\model;


use think\Db;
use think\Model;

class ProductOrderModel extends Model
{


    public static function getOrderStatus()
    {
        return $status = [
            0=>'未支付',
            1=>'已支付待确认',
            2=>'已确认',
            3=>'已发货',
            4=>'已支付，但库存不足',
            5=>'已关闭（支付超时）',
            6=>'已确认收货,待评价',
            7=>'已完成'
        ];
    }

    public function getUserIdAttr($value)
    {
        $data = Db::name('user')->field('id,mobile,user_nickname')->where('id', $value)->find();
        return $data;
    }

    public function getStatusAttr($value)
    {
        $arr = [
            0=>'未支付',
            1=>'已支付待确认',
            2=>'已确认',
            3=>'已发货',
            4=>'已支付，但库存不足',
            5=>'已关闭（支付超时）',
            6=>'已确认收货,待评价',
            7=>'已完成'
        ];
        return array('status'=>$value,'status_info'=>$arr[$value]);
    }

    public function getSnapAddressAttr($value)
    {
        $address = json_decode($value,true);
        unset($address['id']);
        unset($address['user_id']);
        unset($address['type']);
        unset($address['delete_time']);
//        $address_str = '';
//        foreach ($address as $value){
//            $address_str .= $value.'-';
//        }
//        $address_str = rtrim($address_str,'-');
        return $address;
    }

    public function getPayTimeAttr($value)
    {
        if ($value){
            return date("Y-m-d H:i:s",$value);
        }
        return '未付款';
    }

    public function getSnapItemsAttr($value)
    {
        return json_decode($value, true);
    }

    public function getDetail()
    {
        return $this->hasMany('ProductOrderProductModel', 'order_id', 'id');
    }

    public function orderPrice()
    {
        return $this -> hasOne('EvaluateModel','order_id','id');
    }

}