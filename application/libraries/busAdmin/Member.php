<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member
{
    protected $CI;  // CodeIgniter 对象
    protected $_sysinfo;
    private $user;  // 用户信息
    
    private $salt = "lzy94_e_666";  // 加密码
    private $hash;  // 安全码
    private $name;  // username
    
    function __construct()
    {
        $this->CI = & get_instance();
        $this->_sysinfo = $this->CI->config->item('sysinfo');
        
        $this->name = empty($_COOKIE['bus_name']) ? null : $_COOKIE['bus_name'];
        $this->hash = empty($_COOKIE['bus_hash']) ? null : $_COOKIE['bus_hash'];
    }

    /**
     * 检测cookie
     */
    public function check_cookie()
    {
        $name = $this->name;
        $hash = $this->hash;

        //查看cookie内是否包含特殊符号
        if (preg_match("/[<|>|#|$|%|^|*|(|)|{|}|'|\"|;|:]/i", $name) || preg_match("/[<|>|#|$|%|^|*|(|)|{|}|'|\"|;|:]/i", $hash))
        {
            return false;
        }
        else
        {
            //获取数据库内容
            $this->CI->load->model($this->_sysinfo['m_dir'] . '/Spe_shops_Model', 'shop');
            $this->user = $this->CI->shop->getBusInfo($name);

            if(!empty($this->user))
            {
                $scr = $this->makescr($this->user['sName'], $this->user['sPwd']);

                if($scr == $hash)
                {
                    //验证成功，把用户信息存入SESSION
                    $_SESSION['bus_info'] = $this->user;
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else 
            {
                return false;
            }
        }
    }// function check_cookie
    
    /**
     * putcookie
     *
     * 登陆成功后生成cookie，包含安全码
     *
     * @param String $uname 用户名
     * @param String $upwd  密码
     * @param Int $time  有效期默认为1天
     */
    public function put_cookie($uname, $upwd, $time = 1)
    {
        if(!empty($uname) && !empty($upwd))
        {
            $scrStr = $this->makescr($uname, $upwd);
            
            if (!is_numeric($time))
            {
                $time = 1;
            }
            $time = 60 * 60 * 24 * $time;
            setcookie('bus_name', $uname, time() + $time, '/');
            setcookie('bus_hash', $scrStr, time() + $time, '/');
        }
    }
    
    /**
     *  清除cookie
     */
    public function clear_cookie()
    {
        setcookie('bus_name', "", time() - 3600, '/');
        setcookie('bus_hash', "", time() - 3600, '/');
    }
    
    /**
     * 生成安全码
     *
     * @param String $u            
     * @param String $p            
     */
    private function makescr($u, $p)
    {
        return substr(md5($u . $p . $this->salt), 2, 20);
    }
}

?>