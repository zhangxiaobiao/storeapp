<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/7
 * Time: 下午8:58
 */

namespace app\store\controller;


use app\store\model\AboutusModel;
use cmf\controller\AdminBaseController;

/**
 * Class AdminAboutusController 关于我们控制器
 * @package app\store\controller
 * @adminMenuRoot(
 *     'name'   => '关于我们',
 *     'action' => 'default',
 *     'parent' => '',
 *     'display'=> true,
 *     'order'  => 10000,
 *     'icon'   => 'lastfm-square',
 *     'remark' => '关于我们'
 * )
 */
class AdminAboutusController extends AdminBaseController
{
    /**
     * 关于我们
     * @adminMenu(
     *     'name'   => '关于我们',
     *     'parent' => 'default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '关于我们',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $data = (new AboutusModel())->find();
        $this->assign('data', $data);
        return $this->fetch();
    }

    /**
     * 编辑关于我们
     * @adminMenu(
     *     'name'   => '编辑关于我们',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '编辑关于我们',
     *     'param'  => ''
     * )
     */
    public function edit()
    {
        if ($this->request->isPost()) {
            $post   = $this->request->param();

            $rs = AboutusModel::update($post);
            if ($rs){
                $this->success('添加成功!', url('AdminAboutus/index'));
            } else {
                $this->error('添加失败！');
            }
        }


    }
}