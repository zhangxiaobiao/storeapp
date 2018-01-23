<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/7
 * Time: 下午9:06
 */

namespace app\store\model;


use think\Model;

class AboutusModel extends Model
{

    public function getServiceClauseAttr($value)
    {
        return htmlspecialchars_decode($value);
    }

}