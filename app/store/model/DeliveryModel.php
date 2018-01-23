<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2018/1/20
 * Time: 下午4:17
 */

namespace app\store\model;


use think\Model;

class DeliveryModel extends Model
{

    protected $table = 'cmf_delivery_doc';

    protected $autoWriteTimestamp = true;
    protected $updateTime = false;


    public function deliveryOrder()
    {
        return $this->belongsTo('ProductOrderModel', 'order_id', 'id');
    }

}