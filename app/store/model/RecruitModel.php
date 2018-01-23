<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/7
 * Time: 上午11:37
 */

namespace app\store\model;


use think\Model;

class RecruitModel extends Model
{
    public function getCreateTimeAttr($value)
    {
        return date("Y-m-d H:i:s", $value);
    }
}