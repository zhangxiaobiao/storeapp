<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/9
 * Time: 下午8:55
 */

namespace api\store\controller;

use api\home\controller\RestController;
use api\store\model\TruckModel;
use think\Config;

class IndexController extends RestController
{
    public function index()
    {
        echo Config::get('wx.app_id');
    }
}