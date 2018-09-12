<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 后台管理员操作类
 *
 * @author 齐福
 *         创建时间 ： 2016年11月17日下午1:50:47
 */
class Admin extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 转向管理员列表页
     *
     * @return [view] [管理员列表页面]
     */
    public function admin_list()
    {
        $this->load->view('/jt_admin/admin/admin_list');
    }

    /**
     * 返回管理员列表ajax数据
     *
     * @return [json] [管理员列表数据]
     */
    public function list_data()
    {
        $limit = form('length');
        if (! $limit || $limit > 100)
            $limit = 10;
        
        $offset = form('start');
        
        $filter = null;
        $total_filter = $filter;
        if (data_form('uID'))
            $filter['uID ='] = data_form('id');
        if (data_form('uName'))
            $filter['uName ='] = data_form('uName');
        if (data_form('uRealName'))
            $filter['uRealName ='] = data_form('uRealName');
        $filter['uName !='] = 'admin';
        $order = 'uID desc';
        $data['data'] = $this->model('jt_admin/admins')->get_list("*", $filter, null, $order, $limit, $offset);
        $data['recordsTotal'] = $this->model('jt_admin/admins')->get_count($total_filter);

        $data['recordsFiltered'] = $this->model('jt_admin/admins')->get_count($filter);
        echo json_encode($data);
        exit();
    }

    /**
     * 添加管理员
     *
     * @return [view] [添加管理员页面]
     */
    public function admin_add()
    {
        $filter['auID !='] = '1';
        $filter['auType'] = 0;
    	$data['data'] = $this->model('jt_admin/auth_group')->get_list("*",$filter, null, null, null, null);
        $this->load->view('/jt_admin/admin/admin_add',$data);
    }

    /**
     * 保存管理员信息
     *
     * @return [view] [管理员列表页面]
     */
    public function add_save()
    {
        if (form('uName'))
            $add_item['uName'] = form('uName');
        $data = $this->model('jt_admin/admins')->get_row('*', array(
            'uName' => $add_item['uName']
        ));
        if (! $data) {
            
            if (form('uRealName'))
                $add_item['uRealName'] = form('uRealName');
            if (form('uPwd')) {
                $add_item['uSalt'] = rand(1000, 9999);
                $add_item['uPwd'] = md5(md5(form('uPwd') . $add_item['uSalt']));
            }
            $add_item['auID'] = form('group');
            $add_item['uAddtime'] = date("Y-m-d H-i-s");
            $admin_log_msg = "添加管理员账号。";
            $query = $this->db->insert('spe_admins', $add_item);
            $id = $this->db->insert_id();
            // 先记录操作内容
            $result = $this->model('jt_admin/admin_logs')->log($admin_log_msg, $add_item, $id);
            
            if ($result) {
                $json_result['status'] = true;
                $json_result['msg'] = '创建管理员用户成功！';
            } else {
                
                $json_result['status'] = false;
                $json_result['msg'] = '操作数据库时出错2';
            }
        } else {
            $json_result['status'] = false;
            $json_result['msg'] = '用户名已存在！';
        }
        
        echo json_encode($json_result);
    }

    /**
     * 转向个人详情页面
     */
    public function admin_detail()
    {
        $id = urlget('id');
        
        if ($id) {
            $data = $this->model('jt_admin/admins')->get_row('*', array(
                'uID' => $id
            ));
            $filter['auID !='] = '1';
            $filter['auType'] = 0;
            $data['data'] = $this->model('jt_admin/auth_group')->get_list("*",$filter, null, null, null, null);
            if (! $data)
                exit('无效管理员id<a href="javascript:history.back(-1);">返回</a>');
            $this->load->view('/jt_admin/admin/admin_detail', $data);
        } else {
            echo '管理员ID有误 <a href="javascript:history.back(-1);">返回</a>';
        }
    }

    /**
     * 保存更改信息
     *
     * @return json 返回成功状态和错误信息
     */
    public function update_save()
    {
        $log_item = array();
        $uID = form('id');
        $update_item = array(
            'uID' => $uID
        );
        
        $where = array(
            'uID' => $uID
        );
        if (form('id')) {
            if (form('uRealName'))
                $update_item['uRealName'] = form('uRealName');
            
            if (form('ori_uRealName'))
                $log_item['ori_uRealName'] = form('ori_uRealName');
            
            $update_item['auID'] = form('group');
            $log_item['ori_auID'] = form('ori_group');
            $admin_log_msg[] = '更改管理员信息';
        }
        $admin_log_msg = implode(', ', $admin_log_msg);
        // 先记录操作内容
        $result = $this->model('jt_admin/admin_logs')->log($admin_log_msg, array_merge($update_item, $log_item), $uID);
        
        if ($result) {
            
            $result2 = $this->db->update('spe_admins', $update_item, $where);
            $json_result['status'] = $result2;
            if (! $result2){
            	$json_result['status'] = false;
            	$json_result['msg'] = '操作数据库时出错1';
            }else{
            	$json_result['status'] = true;
            	$json_result['msg'] = '修改成功。';
            }
                
        } else {
            
            $json_result['status'] = false;
            $json_result['msg'] = '操作数据库时出错2';
        }
        
        echo json_encode($json_result);
    }

    /**
     * 重置密码
     * $return 提示信息
     */
    public function pass_reset()
    {
        if ($this->admin_id) {
            $id = form('id');
            if ($id) {
                $data = $this->model('jt_admin/admins')->get_row('*', array(
                    'id' => $id
                ));
                $pass = generate_Random_String(6);
                $usalt = rand(1000, 9999);
                $passmd5 = md5(md5($pass . $usalt));
                
                $where = array(
                    'uID' => $id
                );
                $update_item = array(
                    'uID' => $id,
                    'uPwd' => $passmd5,
                    'uSalt' => $usalt
                );
                $log_item = array(
                    'ori_uID' => $id,
                    'ori_uPwd' => $data['uPwd']
                );
                $rdata = $this->db->update('spe_admins', $update_item, $where);
                if ($rdata) {
                    $admin_log_msg = '后台重置管理员密码';
                    // 先记录操作内容
                    $result = $this->model('jt_admin/admin_logs')->log($admin_log_msg, array_merge($update_item, $log_item), $id);
                    $json_result['status'] = false;
                    $json_result['msg'] = "管理员用户：" . $data['uRealName'] . "，重置密码成功<br>新密码为：" . $pass;
                } else {
                    $json_result['status'] = false;
                    $json_result['msg'] = "重置密码功能执行错误。";
                }
            } else {
                $json_result['status'] = false;
                $json_result['msg'] = 'id传输错误。';
            }
        } else {
            $json_result['status'] = false;
            $json_result['msg'] = '请登陆后台后操作重置密码功能。';
        }
        ;
        echo json_encode($json_result);
    }

    /**
     * 管理员登录记录列表
     *
     * @return [view] [管理员登录记录列表页面]
     */
    public function loginlog_list()
    {
        $data['order_state'] = 1;
        
        $this->load->view('admin_user/loginlog_list', $data);
    }

    /**
     * 返回管理员登录记录列表ajax数据
     *
     * @return [json] [管理员登录记录列表数据]
     */
    public function loginlog_list_data()
    {
        $limit = form('length');
        if (! $limit || $limit > 100)
            $limit = 10;
        
        $offset = form('start');
        
        $filter = null;
        $total_filter = $filter;
        if (data_form('name'))
            $filter['a.name ='] = data_form('name');
        if (data_form('clientIp'))
            $filter['clientIp ='] = data_form('clientIp');
        $order = 'logId desc';
        $join = array(
            'admins a' => 'logUserId = a.uID'
        );
        $fild = 'spe_admin_logs.*, a.uRealName,a.uName';
        $data['data'] = $this->model('jt_admin/admin_logs')->get_list($fild, $filter, $join, $order, $limit, $offset);
        $data['recordsTotal'] = $this->model('jt_admin/admin_logs')->get_count($total_filter);
        $data['recordsFiltered'] = $this->model('jt_admin/admin_logs')->get_count($filter);
        echo json_encode($data);
        exit();
    }

    /**
     * 个人详情
     *
     * @return [view] [个人详情]
     */
    public function own_update()
    {
        $id = $this->admin_id;
        
        if ($id) {
            $data = $this->model('jt_admin/admins')->get_row('*', array(
                'uID' => $id
            ));
            if (! $data)
                exit('无效id<a href="javascript:history.back(-1);">返回</a>');
            
            $this->load->view('jt_admin/admin/admin_update', $data);
        } else {
            echo 'ID有误 <a href="javascript:history.back(-1);">返回</a>';
        }
    }

    /**
     * 保存后台个人信息
     *
     * @return json 返回成功状态和错误信息
     */
    public function own_update_save()
    {
        $log_item = array();
        $id = $this->admin_id;
        $update_item = array(
            'uID' => $id
        );
        
        $where = array(
            'uID' => $id
        );
        if (form('id')) {
            
            $salt = rand(1000, 9999);
            if (form('uRealName'))
                $update_item['uRealName'] = form('uRealName');
            if (form('uPwd') != "") {
                if (form('uPwd'))
                    $update_item['uPwd'] = md5(md5(form('uPwd') . $salt));
                $update_item['uSalt'] = $salt;
            }
            
            if (form('ori_uRealName'))
                $log_item['ori_uRealName'] = form('ori_uRealName');
            if (form('ori_uPwd') != "") {
                if (form('ori_uPwd'))
                    $log_item['ori_uPwd'] = md5(form('ori_uPwd'));
                $data = $this->model('jt_admin/admins')->get_row('*', array(
                    'uID' => $id
                ));
                $update_item['uSalt'] = $data['uSalt'];
            }
            $admin_log_msg[] = '更改个人信息';
        }
        
        $admin_log_msg = implode(', ', $admin_log_msg);
        // 先记录操作内容
        $result = $this->model('jt_admin/admin_logs')->log($admin_log_msg, array_merge($update_item, $log_item), $id);
        
        if ($result) {
            
            $result2 = $this->db->update('spe_admins', $update_item, $where);
            $json_result['status'] = $result2;
            if ($result2)
                $json_result['msg'] = '个人信息修改成功！';
        } else {
            
            $json_result['status'] = false;
            $json_result['msg'] = '操作数据库时出错2';
        }
        
        echo json_encode($json_result);
    }

    /**
     * 匹配密码
     *
     * @return [string] [msg]
     */
    public function user_ypass()
    {
        $id = $this->admin_id;
        if ($id) {
            $data = $this->model('jt_admin/admins')->get_row('*', array(
                'uID' => $id
            ));
            if (! $data) {
                $json_result['status'] = false;
                $json_result['msg'] = '未查找到用户信息。';
            } else {
                if (md5(md5(form('ypwd') . $data['uSalt'])) == $data['uPwd']) {
                    $json_result['status'] = true;
                    $json_result['msg'] = '密码验证通过。';
                } else {
                    $json_result['status'] = false;
                    $json_result['msg'] = '原密码验证不通过。';
                }
            }
        } else {
            $json_result['status'] = false;
            $json_result['msg'] = 'ID有误';
        }
        echo json_encode($json_result);
    }

    /**
     * 转向管理员日志列表页
     *
     * @return [view] [管理员日志列表页面]
     */
    public function admin_log_list()
    {
        $this->load->view('/jt_admin/admin/admin_log_list');
    }

    /**
     * 返回管理员日志列表ajax数据
     *
     * @return [json] [管理员日志列表数据]
     */
    public function log_list_data()
    {
        $limit = form('length');
        if (! $limit || $limit > 100)
            $limit = 10;
        
        $offset = form('start');
        
        $filter = null;
        $total_filter = $filter;
        if (data_form('uID'))
            $filter['uID ='] = data_form('id');
        if (data_form('uName'))
            $filter['a.uName ='] = data_form('uName');
        if (data_form('uRealName'))
            $filter['a.uRealName ='] = data_form('uRealName');
        $filter['uName !='] = 'admin';
        $order = 'logId desc';
        $join = array(
            'spe_admins a' => 'logUserId = a.uID'
        );
        $fild = 'spe_admin_logs.*, a.uRealName,a.uName';
        $data['data'] = $this->model('jt_admin/admin_logs')->get_list($fild, $filter, $join, $order, $limit, $offset);
        $data['recordsTotal'] = $this->model('jt_admin/admin_logs')->get_count($total_filter);

        $data['recordsFiltered'] = $this->model('jt_admin/admin_logs')->get_count($filter, $join);
        
        echo json_encode($data);
        exit();
    }

    /**
     * 转向管理员角色添加页
     *
     * @return [view] [管理员角色添加页面]
     */
    public function admin_role_edit()
    {
        $offset = form('start');
        $order = 'mSort asc';
        $filter = null;
        $filter['mParentID ='] = 0;
        
        // 查询顶级菜单
        $data['menu'] = $this->model('jt_admin/menu')->get_list("*", $filter, null, $order, null, null);
        foreach ($data['menu'] as $key => $val) {
            $filter['mParentID ='] = $val['mID'];
            // 查询子菜单
            $data['menu'][$key]['sub_node'] = $this->model('jt_admin/menu')->get_list("*", $filter, null, $order, null, null);
        }
        $data['title'] = '添加角色';
        if (isset($_GET['id'])&&$_GET['id']!=1) {
            $data['data'] = $this->model('jt_admin/auth_group')->get_row('*', array(
                'auID' => $_GET['id']
            ));
            $data['data']['menu'] = explode(',', $data['data']['auRight']);
            $data['title'] = '修改角色';
        }
        $this->load->view('/jt_admin/admin/admin_role_edit', $data);
    }

    /**
     * 转向管理员角色列表页
     *
     * @return [view] [管理员日志列表页面]
     */
    public function admin_role_list()
    {
        $this->load->view('/jt_admin/admin/admin_role_list');
    }

    /**
     * 返回管理员角色列表ajax数据
     *
     * @return [json] [管理员日志列表数据]
     */
    public function role_list_data()
    {
        $limit = form('length');
        if (! $limit || $limit > 100)
            $limit = 10;
        
        $offset = form('start');
        
        $filter = null;
        $filter['auType'] = 0;
        $filter['auID !='] = '1';
        $total_filter = $filter;
        if (data_form('auName'))
            $filter['auName ='] = data_form('auName');
        
        $order = 'auID desc';
        $join = array();
        $fild = '*';
        $data['data'] = $this->model('jt_admin/auth_group')->get_list($fild, $filter, $join, $order, $limit, $offset);
        $data['recordsTotal'] = $this->model('jt_admin/auth_group')->get_count($total_filter);
        $data['recordsFiltered'] = $this->model('jt_admin/auth_group')->get_count($filter);
        foreach ($data['data'] as $key => $val) {
            $filter['mID'] = explode(',', $val['auRight']);
            $order = 'mID asc';
            // 查询子菜单
            $data['data'][$key]['sub_node'] = $this->model('jt_admin/menu')->get_list("*", $filter, null, $order, $limit, $offset);
        }
        echo json_encode($data);
        exit();
    }

    /**
     * 添加角色信息
     *
     * @return json 返回成功状态和错误信息
     */
    public function role_add_save()
    {
        if(isset($_POST['auName'])&&$_POST['auName']==''){
            $json_result['status'] = false;
            $json_result['msg'] = '请输入角色名！';
            echo json_encode($json_result);
            die;
        }
        if(!isset($_POST['menu_checkbox'])){
            $json_result['status'] = false;
            $json_result['msg'] = '请选择权限，多少个点权限给人家啊！';
            echo json_encode($json_result);
            die;
        }

        if (form('auName'))
            $add_item['auName'] = form('auName');
        $data = $this->model('jt_admin/auth_group')->get_row('*', array(
            'auName' => $add_item['auName']
        ));

        if (! $data | form('auID')) {
            $add_item['auType'] = 0; // 表示后台角色的意思 其他表示入驻上id
            $add_item['auRight'] = implode(',', $_POST['menu_checkbox']);
            $add_item['auAddtime'] = date("Y-m-d H-i-s");
            $add_item['auAddip'] = ip();
            $admin_log_msg = "添加管理员角色。";
            if (form('auID')) {

                $admin_log_msg = "修改管理员角色。";
                $where = array(
                    'auID' => form('auID')
                );
                $log_item['ori_auRight'] = $data['auRight'];
                $log_item['ori_auName'] = $data['auName'];
                $query = $this->db->update('spe_auth_group', $add_item,$where);
                // 先记录操作内容
                $result = $this->model('jt_admin/admin_logs')->log($admin_log_msg, array_merge($add_item, $log_item), form('auID'));
                
                if ($result) {
                    $json_result['status'] = true;
                    $json_result['msg'] = '修改管理员角色成功！';
                } else {
                    
                    $json_result['status'] = false;
                    $json_result['msg'] = '操作数据库时出错';
                }
            } else {
            	
                $query = $this->db->insert('spe_auth_group', $add_item);
                $id = $this->db->insert_id();
                // 先记录操作内容
                $result = $this->model('jt_admin/admin_logs')->log($admin_log_msg, $add_item, $id);
                
                if ($result) {
                    $json_result['status'] = true;
                    $json_result['msg'] = '创建管理员角色成功！';
                } else {
                    
                    $json_result['status'] = false;
                    $json_result['msg'] = '操作数据库时出错';
                }
            }
        } else {
            $json_result['status'] = false;
            $json_result['msg'] = '角色已存在！';
        }
        
        echo json_encode($json_result);
    }
    /**
     * 删除角色
     */
    public function del_role()
    {
        $id = form('id');
        if ($id) {
            $data = $this->model('jt_admin/auth_group')->get_row('*', array(
                'auID' => $id
            ));
            if (! $data) {
                $json_result['status'] = false;
                $json_result['msg'] = '未查找到角色信息。';
            } else {
                $admin_data = $this->model('jt_admin/admins')->get_row('*', array(
                    'auID' => $id
                ));
                if ($admin_data) {
                    $json_result['status'] = false;
                    $json_result['msg'] = '有管理员属于该角色，请调动角色后再删除。';
                } else {
                    $this->model('jt_admin/auth_group')->del_by_id($id);
                    $json_result['status'] = true;
                    $json_result['msg'] = '角色删除成功。';
                }
            }
        } else {
            $json_result['status'] = false;
            $json_result['msg'] = 'ID有误';
        }
        echo json_encode($json_result);
    }

    public function base(){
        $data = $this->model('jt_admin/base')->get_row('*');
        $this->load->view('/jt_admin/admin/base',$data);
    }
    public function base_save(){
        $websiteDesc = $this->input->POST('websiteDesc',true);
        $websiteTitle = $this->input->POST('websiteTitle',true);
        $websiteKeywork = $this->input->POST('websiteKeywork',true);
       
            $data = $this->model('jt_admin/base')->get_row('*');
            if (! $data) {
                $json_result['status'] = false;
                $json_result['msg'] = '未查找到变量信息。';
            } else {
                $result2 = $this->db->update('spe_base',array('websiteDesc'=>$websiteDesc,'websiteTitle'=>$websiteTitle,'websiteKeywork'=>$websiteKeywork));
                $json_result['status'] = true;
                $json_result['msg'] = '系统设置成功。';
            }
      
        echo json_encode($json_result);
    }
}
