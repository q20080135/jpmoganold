<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 会员积分
 * @author 齐福
 * 创建时间 ： 2017年3月28日上午11:46:17
 */
class Integral extends ADMIN_Controller
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
    public function integral_list()
    {
        $this->load->view('/jt_admin/user/integral_list');
    }

    /**
     * 返回积分列表ajax数据
     *
     * @return [json] [积分列表数据]
     */
    public function list_data()
    {
        $limit = form('length');
        if (! $limit || $limit > 100)
            $limit = 10;
        
        $offset = form('start');
        
        $filter = null;
        $total_filter = $filter;

        if (data_form('mPhone'))
            $filter['u.mPhone ='] = data_form('mPhone');
        if (data_form('iType')||data_form('iType')=='0')
            $filter['iType ='] = data_form('iType');
        $filter['uName !='] = 'admin';
        $order = 'spe_integral.iID desc';
        $join = array(
            'spe_members u' => 'spe_integral.mID = u.mId',
        );
        $data['data'] = $this->model('jt_admin/integral')->get_list("spe_integral.*,u.mPhone", $filter, $join, $order, $limit, $offset);

        $data['recordsTotal'] = $this->model('jt_admin/integral')->get_count($total_filter);
        $data['recordsFiltered'] = $this->model('jt_admin/integral')->get_count($filter);
        echo json_encode($data);
        exit();
    }

    /**
     * 添加会员积分
     *
     * @return [view] [添加会员积分页面]
     */
    public function integral_add()
    {
        $mId = intval(isset($_GET['mId'])?$_GET['mId']:0);
    	$data = $this->model('jt_admin/user')->get_row('*', array(
    	    'mId' => $mId
    	));
        $this->load->view('/jt_admin/user/integral_add',$data);
    }

    /**
     * 保存管理员信息
     *
     * @return [view] [管理员列表页面]
     */
    public function Integral_save()
    {
        $mId = intval(form('id'));
        if ($mId>0){
            $data = $this->model('jt_admin/user')->get_row('*', array('mId' => $mId));
        }
        if(intval(form('integral'))==0){
            $json_result['status'] = false;
            $json_result['msg'] = '会员积分充值需要大于0！';
        }else{
            if ($data) {
                 
                $add_item['mID'] = $data['mId'];
                $add_item['uID'] = $this->admin_id;
                $add_item['payPoints'] = intval(form('integral'))*100;
            
                $add_item['iDescribe'] = form('iDescribe');
                $add_item['iType'] = 1;
            
                $this->db->trans_start();
                $admin_log_msg = "会员积分充值。";
                $query = $this->db->insert('spe_integral', $add_item);
                $id = $this->db->insert_id();
                
                $data['mIntegral'] = $data['mIntegral']+$add_item['payPoints'];
                $this->db->update('spe_members', $data, array('mId' => $mId));
                // 先记录操作内容
                $result = $this->model('jt_admin/admin_logs')->log($admin_log_msg, $add_item, $mId);
                $this->db->trans_complete();
                if ($result) {
                    $json_result['status'] = true;
                    $json_result['msg'] = '会员积分充值成功！';
                } else {
            
                    $json_result['status'] = false;
                    $json_result['msg'] = '操作数据库时出错2';
                }
            } else {
                $json_result['status'] = false;
                $json_result['msg'] = '用户名不存在！';
            }
            
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

   
}
