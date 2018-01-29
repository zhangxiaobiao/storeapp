<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------
namespace plugins\mobile_code_demo;//Demo插件英文名，改成你的插件英文就行了
use cmf\lib\Plugin;
use think\Loader;

/**
 * MobileCodeDemoPlugin
 */
//Loader::import('yunpian.YunpianAutoload',EXTEND_PATH,'.php');

class MobileCodeDemoPlugin extends Plugin
{

    public $info = [
        'name' => 'MobileCodeDemo',
        'title' => '手机验证码演示插件',
        'description' => '手机验证码演示插件',
        'status' => 1,
        'author' => 'ThinkCMF',
        'version' => '1.0'
    ];

    public $has_admin = 0;//插件是否有后台管理界面

    public function install() //安装方法必须实现
    {
        return true;//安装成功返回true，失败false
    }

    public function uninstall() //卸载方法必须实现
    {
        return true;//卸载成功返回true，失败false
    }

    //实现的send_mobile_verification_code钩子方法
    public function sendMobileVerificationCode($param)
    {
        $mobile = $param['mobile'];//手机号
        $code = $param['code'];//验证码
        $config = $this->getConfig();
        $expire_minute = intval($config['expire_minute']);
        $expire_minute = empty($expire_minute) ? 30 : $expire_minute;
        $expire_time = time() + $expire_minute * 60;
        $msg = false;
//        return true;

//        $result = [
//            'error'     => 1,
//            'message' => '服务商返回结果错误'
//        ];
//        $smsOperator = new \SmsOperator();
//        $data['mobile'] = "$mobile";
//        $data['tpl_id'] = "2108578";
//        $data['tpl_value'] =
//            urlencode("#code#") . "="
//            . urlencode($code) ;
//        . "&"
//            . urlencode("#company#") . "="
//            . urlencode("云片网");
//        $result = $smsOperator->tpl_send($data);
        $result = $this->test1($mobile, $code);
        if ($result['code'] == 0){
            $msg = [
                'error' => 0,
                'message' => '发送成功！'
            ];
        } else {
            $msg = [
                'error' => '',
                'message' => '发送失败!'
            ];
        }
        return $msg;
    }

    public function test1($mobile,$code){
        $apikey = ""; //修改为您的apikey(https://www.yunpian.com)登录官网后获取
        $text="【云片网】您的验证码是1234";
        $ch = curl_init();

        /* 设置验证方式 */
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8',
            'Content-Type:application/x-www-form-urlencoded', 'charset=utf-8'));
        /* 设置返回结果为流 */
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        /* 设置超时时间*/
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        /* 设置通信方式 */
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// 取得用户信息
        $json_data = $this->get_user($ch,$apikey);
        $array = json_decode($json_data,true);

// 发送短信
//        $data=array('text'=>$text,'apikey'=>$apikey,'mobile'=>$mobile);
//        $json_data = send($ch,$data);
//        $array = json_decode($json_data,true);
//        echo '<pre>';print_r($array);

// 发送模板短信
// 需要对value进行编码
        $data = array(
            'tpl_id' => '2108578',
            'tpl_value' => ('#code#').'='.urlencode($code),
            'apikey' => $apikey,
            'mobile' => $mobile
        );
        $json_data = $this->tpl_send($ch,$data);
        $array = json_decode($json_data,true);
        return $array;

// 发送语音验证码
//        $data=array('code'=>'9876','apikey'=>$apikey,'mobile'=>$mobile);
//        $json_data =voice_send($ch,$data);
//        $array = json_decode($json_data,true);
//        echo '<pre>';print_r($array);

// 发送语音通知，务必要报备好模板
        /*
        模板： 课程#name#在#time#开始。 最终发送结果： 课程深度学习在14:00开始
         */

//        $tpl_id = '123456'; //你自己后台报备的模板id
//        $tpl_value = urlencode('#time#').'='.urlencode('1234').
//            '&'.urlencode('#name#').'='.urlencode('欢乐行');
//        $data=array('tpl_id'=>$tpl_id,'tpl_value'=>$tpl_value,'apikey'=>$apikey,'mobile'=>$mobile);
//        $json_data = notify_send($ch,$data);
//        $array = json_decode($json_data,true);
//        echo '<pre>';print_r($array);

        curl_close($ch);
    }

    //获得账户
    function get_user($ch,$apikey){
        curl_setopt ($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/user/get.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('apikey' => $apikey)));
        $result = curl_exec($ch);
        $error = curl_error($ch);
        $this->checkErr($result,$error);
        return $result;
    }
    function send($ch,$data){
        curl_setopt ($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/single_send.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($ch);
        $error = curl_error($ch);
        $this->checkErr($result,$error);
        return $result;
    }
    function tpl_send($ch,$data){
        curl_setopt ($ch, CURLOPT_URL,
            'https://sms.yunpian.com/v2/sms/tpl_single_send.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($ch);
        $error = curl_error($ch);
        $this->checkErr($result,$error);
        return $result;
    }
    function voice_send($ch,$data){
        curl_setopt ($ch, CURLOPT_URL, 'http://voice.yunpian.com/v2/voice/send.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($ch);
        $error = curl_error($ch);
        $this->checkErr($result,$error);
        return $result;
    }
    function notify_send($ch,$data){
        curl_setopt ($ch, CURLOPT_URL, 'https://voice.yunpian.com/v2/voice/tpl_notify.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($ch);
        $error = curl_error($ch);
        $this->checkErr($result,$error);
        return $result;
    }

    function checkErr($result,$error) {
        if($result === false)
        {
            echo 'Curl error: ' . $error;
        }
        else
        {
            //echo '操作完成没有任何错误';
        }
    }

    public function test()
    {
        // 发送单条短信
        $smsOperator = new SmsOperator();
        $data['mobile'] = '13300000000';
        $data['text'] = '【云片网】您的验证码是1234';
        $result = $smsOperator->single_send($data);
        print_r($result);
//发送批量短信
        $data['mobile'] = '13100000000,13100000001,2,13100000003';
        $result = $smsOperator->batch_send($data);
        print_r($result);
//发送个性化短信
        $data['mobile'] = '13000000000,13000000001,1,13000000003';
        $data['text'] = '【云片网】您的验证码是1234,【云片网】您的验证码是6414,【云片网】您的验证码是0099,【云片网】您的验证码是3451';
        $result = $smsOperator->multi_send($data);
        print_r($result);

//发送指定模板短信(不推荐)
// 模板为【#company#】您的验证码是#code#
// 发送内容：【云片网】您的验证码是1234
        $data['mobile'] = '13400000000,13400000001,1,13400000003';
        $data['tpl_id'] = "1";
        $data['tpl_value'] =
            urlencode("#code#") . "="
            . urlencode("1234") . "&"
            . urlencode("#company#") . "="
            . urlencode("云片网");
        $result = $smsOperator->tpl_send($data);
        print_r($result);


// 流量
        $flowOperator = new FlowOperator();
        $result = $flowOperator->get_package();
        print_r($result);
        $result = $flowOperator->recharge(array("sn" => "1008601", "mobile" => "18700000000"));
        print_r($result);

// 语音
        $voiceOperator = new VoiceOperator();
        $result = $voiceOperator->send(array("mobile" => "18700000000", "code" => "1234"));
        print_r($result);
// 获取用户信息
        $userOperator = new UserOperator();
        $result = $userOperator->get();
        print_r($result);

// 模板
        $tplOperator = new TplOperator();
        $result = $tplOperator->get_default(array("tpl_id" => '2'));
        print_r($result);
        $result = $tplOperator->get();
        print_r($result);
        $result = $tplOperator->add(array("tpl_content" => "【bb】大倪#asdf#"));
        print_r($result);
    }

}