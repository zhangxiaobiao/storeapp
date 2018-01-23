<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/21
 * Time: 下午3:44
 */

namespace app\store\model;


use think\Model;

class OrderModel extends Model
{
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;

    public function userInfo()
    {
        return $this->belongsTo('UserModel', 'user_id', 'id');
    }

    public function truckInfo()
    {
        return $this->belongsTo('TruckModel', 'truck_id', 'id');
    }

    public function sendAddress()
    {
        return $this->belongsTo('AddressModel', 'send_addr_id', 'id');
    }

    public function receiveAddress()
    {
        return $this->belongsTo('AddressModel', 'received_addr_id', 'id');
    }

    public function getCompleteTimeAttr($value)
    {
        if ($value == 0){
            return '未完成';
        } else {
            return date("Y-m-d H:i:s", $value);
        }
    }
}