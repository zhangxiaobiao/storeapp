<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/9
 * Time: 下午9:48
 */

namespace api\store\model;


use think\Model;

class OrderModel extends Model
{
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;

    protected $hidden = [
        'carfollow',
        'complete_time',
        'extrarequire',
        'goodskind',
        'makeorder',
        'order_no',
        'snap_img',
        'snap_name',
        'specialform',
        'total_price',
        'update_time',
        'user_id'
    ];

    public function getCreateTimeAttr($value)
    {
        return date("Y-m-d H:i:s", $value);
    }

    public function truckInfo()
    {
        return $this->belongsTo('TruckModel','truck_id','id');
    }

    public function sendAddress()
    {
        return $this->belongsTo('AddressModel', 'send_addr_id', 'id');
    }

    public function receiveAddress()
    {
        return $this->belongsTo('AddressModel', 'received_addr_id', 'id');
    }
}