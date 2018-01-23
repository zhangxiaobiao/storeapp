<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/9
 * Time: 下午10:25
 */

namespace api\store\controller;


use api\store\model\AddressModel;
use cmf\controller\RestBaseController;
use cmf\controller\RestUserBaseController;
use think\Db;

class AddressController extends RestBaseController
{
    /*
     * 根据token获取用户地址
     */
    public function getUserAddress()
    {
        $uid = $this->getUserId();
        $address = Db::name('address')->where(['user_id'=>$uid])->find();
        if (!$address){
            $this->error('未获取到地址列表');
        }
        return $address;
    }

    /*
     * 我要发货
     * 获取用户发货时的地址列表
     */
    public function getAddressList()
    {
        $uid = $this->getUserId();
        $address = AddressModel::where(['user_id'=>$uid,'type'=>2])->order('id', 'desc')->select();
        if ($address){
            $this->success('获取地址成功', $address);
        } else {
            $this->error('获取地址失败');
        }
    }

    /*
     * 根据地址id获取地址详情
     */
    public function getOneAddress($id)
    {
        $data['id'] = $id;
        $rs = $this->validate($data, 'Address.getaddress');
        if ($rs !== true) {
            $this->error($rs);
        }
        $address = Db::name('address')->find($id);
        if (!$address){
            $this->error('未获取到地址详情');
        }
        $this->success('获取地址详情成功',$address);
    }

    //我要发货 更新地址
    public function FHupdateAddress(){
        $address = $this->request->param();
        $rs = $this->validate($address, 'Address.setaddress');
        if ($rs !== true) {
            $this->error($rs);
        }
        $rt = Db::name('address')->where('id', $address['id'])->update($address);
        if ($rt){
            $this->success('更新成功');
        } else {
            $this->error('地址未更新');
        }
    }

    /*
     * 更新用户地址
     */
    public function updateAddress()
    {
        $address = $this->request->param();
        $rs = $this->validate($address, 'Address.setaddress');
        if ($rs !== true) {
            $this->error($rs);
        }
        $rst = Db::name('address')->where(['user_id'=>$this->getUserId(), 'type'=>1])->find();
        if ($rst){
            $rt = Db::name('address')->where(['user_id'=>$this->getUserId(), 'type'=>1])->update($address);
            if ($rt){
                $this->success('更新成功');
            } else {
                $this->error('地址未更新');
            }
        } else {
            $address['user_id']=$this->getUserId();
            $address['type']=1; // 默认1 商城收货地址
            $rt = Db::name('address')->insert($address);
            if ($rt){
                $this->success('添加了一条新地址');
            }
            $this->error('地址未添加成功');
        }
    }
}