<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/9
 * Time: 下午7:01
 */

namespace app\store\controller;


use app\store\model\TruckModel;
use cmf\controller\AdminBaseController;
use think\Db;

/**
 * Class AdminTruckController 货车控制器
 * @package app\store\controller
 * @adminMenuRoot(
 *     'name'   => '货车管理',
 *     'action' => 'default',
 *     'parent' => '',
 *     'display'=> true,
 *     'order'  => 10000,
 *     'icon'   => 'truck',
 *     'remark' => '货车管理'
 * )
 */
class AdminTruckController extends AdminBaseController
{

    /**
     * 货车管理
     * @adminMenu(
     *     'name'   => '货车管理',
     *     'parent' => 'store/AdminTruck/default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '货车管理',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $trucks = TruckModel::order('list_order asc, id desc')->where('delete_time', 'eq', 0)->select();
        $this->assign('trucks', $trucks);
        return $this->fetch();
    }

    /**
     * 添加货车
     * @adminMenu(
     *     'name'   => '添加货车',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加货车',
     *     'param'  => ''
     * )
     */
    public function add()
    {
        if ($this->request->isPost()){
            $post = $this->request->param();
            $rs = TruckModel::create($post);
            if ($rs) {
                $this->success('添加成功',url('AdminTruck/index'));
            } else {
                $this->error('添加失败');
            }
        } else {
            return $this->fetch();
        }
    }

    /**
     * 修改货车
     * @adminMenu(
     *     'name'   => '修改货车',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '修改货车',
     *     'param'  => ''
     * )
     */
    public function edit($id)
    {
        if ($this->request->isPost()) {
            $post   = $this->request->param();
            $rs = TruckModel::update($post);
            if ($rs){
                $this->success('修改成功!', url('AdminTruck/index'));
            } else {
                $this->error('修改失败！');
            }
        } else {
            $data = TruckModel::get($id);
            $this->assign('truck', $data);
            return $this->fetch();
        }
    }

    /**
     * 删除货车
     * @adminMenu(
     *     'name'   => '删除货车',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '删除货车',
     *     'param'  => ''
     * )
     */
    public function delete($id)
    {
        $category = TruckModel::get($id);
        $category->delete_time = time();
        $category->save();
        $this->success('删除成功');

    }

    /**
     * 货车排序
     * @adminMenu(
     *     'name'   => '货车排序',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '货车排序',
     *     'param'  => ''
     * )
     */
    public function listOrder()
    {
        parent::listOrders(Db::name('truck'));
        $this->success("排序更新成功！", '');
    }
}