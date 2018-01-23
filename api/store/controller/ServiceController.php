<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/9
 * Time: 下午10:05
 */

namespace api\store\controller;


use cmf\controller\RestBaseController;
use think\Db;

class ServiceController extends RestBaseController
{
    /*
     * 获取所有常见问题
     */
    public function getProblems()
    {
        $problems = Db::name('service')->order('list_order asc, id desc')->select();
        if (!$problems){
            $this->error('获取常见问题失败');
        }
        $this->success('获取常见问题成功', $problems);
    }

    //获取某一个常见问题详情
    public function getOneProblem($id)
    {
        $data = Db::name('service')->where('id', $id)->find();
        if (!$data){
            $this->error('获取常见问题失败');
        }
        $this->success('获取常见问题成功', $data);
    }
}