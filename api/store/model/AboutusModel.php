<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/9
 * Time: 下午10:45
 */

namespace api\store\model;


use think\Model;

class AboutusModel extends Model
{

    public function getThumbAttr($value)
    {
        return cmf_get_asset_url($value);
    }

    public function getServiceClauseAttr($value)
    {
        $data = explode(PHP_EOL, $value);
        return $data;
    }
}