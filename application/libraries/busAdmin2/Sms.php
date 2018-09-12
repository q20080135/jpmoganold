<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//短信
class Sms
{
    //protected $CI;  // CodeIgniter 对象
    //protected $_sysinfo;
    
    //构造函数
    function __construct()
    {
        //$this->CI = & get_instance();
    }
    
    //获取短信内容
    function send_content($id = 0)
    {
        $content = array(
            0 => '您的手机号绑定验证码:%s,请勿泄露,5分钟内有效【境淘商城】',
        );
        return !empty($content[$id]) ? $content[$id] : '';
    }
    
    //发送短信
    function send_sms($mobile, $content, $time = '', $mid = '')
    {
        header("Content-Type: text/html; charset=UTF-8");
        $flag = 0;
        $params='';//要post的数据
        //$verify = rand(123456, 999999);//获取随机验证码
        
        if(!preg_match("/^1[34578]{1}\d{9}$/",$mobile)) {
            return false;
        }
        //以下信息自己填以下
        $argv = array(
            'name' => 'dxwzdwl09',     //必填参数。用户账号
            'pwd' => 'F5414A6FE8A0DCEA2A0614831D7A',     //必填参数。（web平台：基本资料中的接口密码）
            'content' => $content,   //必填参数。发送内容（1-500 个汉字）UTF-8编码
            'mobile' => $mobile,   //必填参数。手机号码。多个以英文逗号隔开
            'stime' => '',   //可选参数。发送时间，填写时已填写的时间发送，不填时为当前时间发送
            'sign' => '',    //必填参数。用户签名。
            'type' => 'pt',  //必填参数。固定值 pt
            'extno' => ''    //可选参数，扩展码，用户定义扩展码，只能为数字
        );
        foreach ($argv as $key=>$value) {
            if ($flag!=0) {
                $params .= "&";
                $flag = 1;
            }
            $params .= $key."="; $params.= urlencode($value);
            $flag = 1;
        }
        $url = "http://web.duanxinwang.cc/asmx/smsservice.aspx?" . $params; //提交的url地址
        $con= substr( file_get_contents($url), 0, 1);  //获取信息发送后的状态
        return $con == '0' ? true : false;
    }
    
    //获取IP
    function getIP()
    {
        if (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
            $ip = getenv('HTTP_X_FORWARDED');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ip = getenv('HTTP_FORWARDED_FOR');
        } elseif (getenv('HTTP_FORWARDED')) {
            $ip = getenv('HTTP_FORWARDED');
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
    
        return $ip;
    }
}

?>
