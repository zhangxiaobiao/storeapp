<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/10
 * Time: 下午1:59
 */

namespace api\store\model;


use think\Model;

class ProductOrderModel extends Model
{
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;

    public static function getSummaryByUser($type,$uid,$page=1,$size=15)
    {
        if ($type == 999 || $type == ''){
            $where = [];
        } else {
            $where['status'] = $type;
        }
        $where['user_id'] = $uid;
        $pagingData = self::where($where)->order('create_time', 'desc')->paginate($size, true,['page'=>$page]);
        return $pagingData;
    }

    public function getSnapItemsAttr($value)
    {
        if (empty($value)){
            return null;
        }
        return json_decode($value);
    }

    public function getSnapAddressAttr($value)
    {
        if (empty($value)){
            return null;
        }
        return json_decode($value);
    }

    public function getCreateTimeAttr($value)
    {
        return date("Y-m-d H:i:s", $value);
    }
}