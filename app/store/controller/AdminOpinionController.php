<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/7
 * Time: 下午11:08
 */

namespace app\store\controller;


use cmf\controller\AdminBaseController;
use app\store\model\OpinionModel;

/**
 * Class AdminOpinionController 意见反馈控制器
 * @package app\store\controller
 * @adminMenuRoot(
 *     'name'   => '意见反馈',
 *     'action' => 'default',
 *     'parent' => '',
 *     'display'=> true,
 *     'order'  => 10000,
 *     'icon'   => 'twitch',
 *     'remark' => '意见反馈'
 * )
 */
class AdminOpinionController extends AdminBaseController
{

    /**
     * 反馈管理
     * @adminMenu(
     *     'name'   => '反馈管理',
     *     'parent' => 'default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '反馈管理',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $opinions = (new OpinionModel())->with('userInfo')->order('create_time desc')->select();
        $this->assign('opinions', $opinions);
        return $this->fetch();
    }

    /**
     * 删除反馈
     * @adminMenu(
     *     'name'   => '删除反馈',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '删除反馈',
     *     'param'  => ''
     * )
     */
    public function delete($id)
    {
        $rs = OpinionModel::destroy($id);
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
        $rs = OpinionModel::update(['id'=>$id, 'status'=>1]);
        if ($rs){
            $this->success('标记成功!');
        } else {
            $this->error('标记失败!');
        }
    }}