<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------
namespace api\user\controller;

use think\Db;
use think\Validate;
use cmf\controller\RestBaseController;

class PublicController extends RestBaseController
{
    // 用户注册
    public function register()
    {
        $validate = new Validate([
            'username'          => 'require',
            'password'          => 'require',
            'verification_code' => 'require'
        ]);

        $validate->message([
            'username.require'          => '请输入手机号!',
            'password.require'          => '请输入您的密码!',
            'verification_code.require' => '请输入数字验证码!'
        ]);

        $data = $this->request->param();
        if (!$validate->check($data)) {
            $this->error($validate->getError());
        }

        $user = [];

        $userQuery = Db::name("user");

        if (Validate::is($data['username'], 'email')) {
            $user['user_email'] = $data['username'];
            $userQuery          = $userQuery->where('user_email', $data['username']);
        } else if (preg_match('/(^(13\d|15[^4\D]|17[013678]|18\d)\d{8})$/', $data['username'])) {
            $user['mobile'] = $data['username'];
            $userQuery      = $userQuery->where('mobile', $data['username']);
        } else {
            $this->error("请输入正确的手机号码!");
        }

        $errMsg = cmf_check_verification_code($data['username'], $data['verification_code']);
        if (!empty($errMsg)) {
            $this->error($errMsg);
        }

        $findUserCount = $userQuery->count();

        if ($findUserCount > 0) {
            $this->error("此账号已存在!");
        }

        $user['create_time'] = time();
        $user['user_status'] = 1;
        $user['user_type']   = 2;
        $user['user_pass']   = cmf_password($data['password']);

        $result = $userQuery->insert($user);


        if (empty($result)) {
            $this->error("注册失败,请重试!");
        }

        $this->success("注册并激活成功,请登录!");

    }

    // 用户登录 TODO 增加最后登录信息记录,如 ip
    public function login()
    {
        $validate = new Validate([
            'username'          => 'require',
            'verification_code' => 'require'
        ]);

        $validate->message([
            'username.require'          => '请输入手机号!',
            'verification_code.require' => '请输入验证码!'
        ]);

        $data = $this->request->param();
        if (!$validate->check($data)) {
            $this->error($validate->getError());
        }

        $userWhere = [];
        if (Validate::is($data['username'], 'email')) {
            $userWhere['user_email'] = $data['username'];
        } else if (preg_match('/(^(13\d|15[^4\D]|17[013678]|18\d)\d{8})$/', $data['username'])) {
            $userWhere['mobile'] = $data['username'];
        } else {
            $this->error("手机号不正确");
        }

        $errMsg = cmf_check_verification_code($data['username'], $data['verification_code']);
        if (!empty($errMsg)) {
            $this->error($errMsg);
        }
        $token = $this->request->header('token');
        $userdata = Db::name('user_token')->where('token', $token)->find();


//        $userQuery = Db::name("user");

//        $userQuery = $userQuery->where($userWhere);
//        $findUser = $userQuery->find();




//        if (empty($findUser)) {
//        if (empty($userdata)) {
//            //新建用户信息，并将token写入数据库
//            $post['user_type'] = 2;
//            $post['last_login_time'] = time();
//            $post['create_time'] = time();
//            $post['mobile'] = $data['username'];
//            $rst = Db::name("user")->insertGetId($post);
//            if ($rst) {
//                $userTokenQuery = Db::name("user_token");
//                $currentTime = time();
//                $expireTime = $currentTime + 24 * 3600 * 180;
//                $token = md5(uniqid()) . md5(uniqid());
//                $actoken = md5($data['username']);
//                $result = $userTokenQuery->insert([
//                    'token' => $token,
//                    'actoken'=>$actoken,
//                    'user_id' => $rst,
//                    'expire_time' => $expireTime,
//                    'create_time' => $currentTime
//                ]);
//                if (!$result) {
//                    $this->error("登录失败!");
//                }
//                $this->success("登录成功!", ['token' => $token,'actoken'=>$actoken]);
//            } else {
//                $this->error("登录失败!");
//            }
//
//        } else {
//            $userTokenQuery = Db::name("user_token");
//            $currentTime = time();
//            $expireTime = $currentTime + 24 * 3600 * 180;
//            $actoken = md5($data['username']);
//
//            $result = $userTokenQuery
//                ->where('user_id', $userdata['user_id'])
//                ->update([
//                    'token' => $token,
//                    'actoken' => $actoken,
//                    'expire_time' => $expireTime,
//                    'create_time' => $currentTime
//                ]);
//            if (!$result) {
//                $this->error("登录失败!");
//            }
//            Db::name('user')->where('id', $userdata['user_id'])->update(['mobile'=>$data['username']]);
//
//        }
        if ($userdata){
            $user_id = $userdata['user_id'];
        } else {
            $user_id = $this->getUserId();
        }
        if (!$user_id){
            $this->error('登录参数错误');
        }
        $userTokenQuery = Db::name("user_token");
        $currentTime = time();
        $expireTime = $currentTime + 24 * 3600 * 180;
        $actoken = md5($data['username']);

        $result = $userTokenQuery
            ->where('user_id', $user_id)
            ->update([
                'token' => $token,
                'actoken' => $actoken,
                'expire_time' => $expireTime,
                'create_time' => $currentTime
            ]);
        if (!$result) {
            $this->error("登录失败!");
        }
        Db::name('user')->where('id', $user_id)->update(['mobile'=>$data['username']]);
        $this->success("登录成功!", ['token' => $token,'actoken'=>$actoken]);
    }

    // 用户退出
    public function logout()
    {
        $userId = $this->getUserId();
        Db::name('user_token')->where([
            'token'       => $this->token,
            'user_id'     => $userId
        ])->update(['actoken'=>'']);

        $this->success("退出成功!");
    }

    // 用户密码重置
    public function passwordReset()
    {
        $validate = new Validate([
            'username'          => 'require',
            'verification_code' => 'require'
        ]);

        $validate->message([
            'username.require'          => '请输入手机号!',
            'verification_code.require' => '请输入数字验证码!'
        ]);

        $data = $this->request->param();
        if (!$validate->check($data)) {
            $this->error($validate->getError());
        }

        $userWhere = [];
        if (Validate::is($data['username'], 'email')) {
            $userWhere['user_email'] = $data['username'];
        } else if (preg_match('/(^(13\d|15[^4\D]|17[013678]|18\d)\d{8})$/', $data['username'])) {
            $userWhere['mobile'] = $data['username'];
        } else {
            $this->error("请输入正确的手机!");
        }

        $errMsg = cmf_check_verification_code($data['username'], $data['verification_code']);
        if (!empty($errMsg)) {
            $this->error($errMsg);
        }

        return true;

    }

    //验证token   post
    public function verifyToken()
    {
        $token = $this->request->param();
        $rs = Db::name('user_token')->where($token)->find();
        if (!$rs){
            $this->error('Token验证失败');
        } else {
            if($rs['expire_time'] > time()){
                $this->success('Token验证成功');
            }
        }
    }
}
