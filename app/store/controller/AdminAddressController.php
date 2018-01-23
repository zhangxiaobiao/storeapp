<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/9
 * Time: 下午3:08
 */

namespace app\store\controller;


use app\store\model\AddressModel;
use cmf\controller\AdminBaseController;


class AdminAddressController extends AdminBaseController
{

    /*
     * 通过用户id获取用户地址列表
     */
    public function getAddressByUserId($userid)
    {
        $address = AddressModel::where('user_id', $userid)->select();
        $this->assign('address', $address);
        return $this->fetch();
    }

    /*
     * 编辑用户地址
     */
    public function edit($id)
    {
        if ($this->request->isPost()) {
            $post   = $this->request->param();
            $rs = AddressModel::update($post);
            if ($rs){
                $this->success('修改成功!');
            } else {
                $this->error('修改失败！');
            }
        } else {
            $data = AddressModel::get($id);
            $this->assign('address', $data);
            return $this->fetch();
        }
    }


}