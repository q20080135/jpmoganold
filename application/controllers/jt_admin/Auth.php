<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 后台登录类
 *
 * @author 齐福
 *         创建时间 ： 2016年11月17日下午2:51:42
 */
class Auth extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['redirect'] = $this->input->get('re', TRUE);
        $this->load->view('jt_admin/auth/index',$data);
    }

    public function login()
    {
        $user = form('user');
        $pwd = form('pwd');
        $redirect = form('redirect');
        $data = $this->model('jt_admin/admins')->get_row('*', array(
            'uName' => $user
        ));

        if ($data) {
            if ($data['uPwd'] == md5(md5($pwd . $data['uSalt']))) {
                $_SESSION['admin_info'] = $data;
                $data['uLastLoginTime'] = date("Y-m-d H-i-s");
                $data['uLastLoginIp'] = ip();
                $this->db->update('spe_admins',$data,array('uName' => $user));
                //登录记录
                $log_item = array(
                    'logTitle'    => "后台用户登录"
                    ,'logKey'    => $data['uID']
                    ,'codeType'     => 5
                    ,'logTime'     => date("Y-m-d H-i-s")
                    ,'logUserId'  => $data['uID']
                    ,'logData'     => null
                    ,'callFunction'=> 'privilege/admin_login'
                    ,'clientIp'=> ip()
                );
                $res = $this->db->insert('spe_admin_logs', $log_item);
                $json_result['status'] = true;
                die(json_encode($json_result));

                /*if($redirect === ''){
                    redirect(site_url('jt_admin/main'));                    
                }else{
                    redirect(site_url($redirect));                     
                }*/
            } else {
                $json_result['status'] = false;
                $json_result['msg'] = '密码错误';
                die(json_encode($json_result));
            }
        } else {
            $json_result['status'] = false;
            $json_result['msg'] = '用户不存在';
            die(json_encode($json_result));
        }
    }

    public function adminLogout()
    {
        $this->session->unset_userdata('admin_info');
        redirect(site_url('jt_admin'));
    }
}
