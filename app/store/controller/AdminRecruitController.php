<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/7
 * Time: 上午11:29
 */

namespace app\store\controller;


use app\store\model\RecruitModel;
use cmf\controller\AdminBaseController;

/**
 * Class AdminRecruitController 司机招募控制器
 * @package app\store\controller
 * @adminMenuRoot(
 *     'name'   => '司机招募',
 *     'action' => 'default',
 *     'parent' => '',
 *     'display'=> true,
 *     'order'  => 10000,
 *     'icon'   => 'bus',
 *     'remark' => '司机招募'
 * )
 */
class AdminRecruitController extends AdminBaseController
{
    /**
     * 招募管理
     * @adminMenu(
     *     'name'   => '招募管理',
     *     'parent' => 'default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '招募管理',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $recruits = (new RecruitModel())->order('create_time desc')->select();
        $this->assign('recruits', $recruits);
        return $this->fetch();
    }

    /**
     * 删除招募
     * @adminMenu(
     *     'name'   => '删除招募',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '删除招募',
     *     'param'  => ''
     * )
     */
    public function delete($id)
    {
        $rs = RecruitModel::destroy($id);
        if ($rs){
            $this->success('删除成功！');
        } else {
            $this->error('删除失败！');
        }
    }

    /**
     * 标记
     * @adminMenu(
     *     'name'   => '标记已读',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '标记已读',
     *     'param'  => ''
     * )
     */
    public function isread($id)
    {
        $rs = RecruitModel::update(['id'=>$id, 'status'=>1]);
        if ($rs){
            $this->success('标记成功!');
        } else {
            $this->error('标记失败!');
        }
    }
}