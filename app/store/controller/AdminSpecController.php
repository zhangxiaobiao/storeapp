<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/9
 * Time: 下午7:01
 */

namespace app\store\controller;


use app\store\model\ProductTypeModel;
use app\store\model\SpecItemModel;
use app\store\model\SpecModel;
use cmf\controller\AdminBaseController;
use think\Db;


class AdminSpecController extends AdminBaseController
{

    /**
     * 规格管理
     * @adminMenu(
     *     'name'   => '规格管理',
     *     'parent' => 'store/AdminProduct/default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '规格管理',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $specs = SpecModel::has('addItem','>', 0)->order('list_order asc, id desc')->select();
        $this->assign('specs', $specs);
        return $this->fetch();
    }

    /**
     * 添加规格
     * @adminMenu(
     *     'name'   => '添加规格',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加规格',
     *     'param'  => ''
     * )
     */
    public function add()
    {
        if ($this->request->isPost()){
            $post = $this->request->param();
            $items= rtrim($post['items']);
            unset($post['items']);
            $rs = SpecModel::create($post);
            foreach(explode(PHP_EOL, $items) as $k=>$v)
            {
                $item[]['item'] = $v;
            }
            $rst = $rs->addItem()->saveAll($item);
            if ($rst) {
                $this->success('添加成功',url('AdminSpec/index'));
            } else {
                $this->error('添加失败');
            }
        } else {
            $types = ProductTypeModel::all();
            $this->assign('types', $types);
            return $this->fetch();
        }
    }

    /**
     * 修改规格
     * @adminMenu(
     *     'name'   => '修改规格',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '修改规格',
     *     'param'  => ''
     * )
     */
    public function edit($id)
    {
        if ($this->request->isPost()) {
            $post   = $this->request->param();
            $items= rtrim($post['items']);
            unset($post['items']);
            $rs = SpecModel::update($post);
            foreach(explode(PHP_EOL, $items) as $k=>$v)
            {
                $item[]['item'] = $v;
            }
            SpecItemModel::where('spec_id', $rs->id)->delete();
            $rst = $rs->addItem()->saveAll($item);
            if ($rst){
                $this->success('修改成功!', url('AdminSpec/index'));
            } else {
                $this->error('修改失败！');
            }
        } else {
            $data = SpecModel::with('addItem')->find($id);
            $str = '';
            foreach ($data['add_item'] as $k=>$v){
                $str .= $v['item']."\n";
            }

            $data['add_item'] = rtrim($str, '\n');
            $types = ProductTypeModel::all();
            $this->assign('types', $types);
            $this->assign('spec', $data);
            return $this->fetch();
        }
    }

    /**
     * 删除规格
     * @adminMenu(
     *     'name'   => '删除规格',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '删除规格',
     *     'param'  => ''
     * )
     */
    public function delete($id)
    {
        $category = SpecModel::get($id);
        $category->delete_time = time();
        $category->save();
        $this->success('删除成功');

    }


}