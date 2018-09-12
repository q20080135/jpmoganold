<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 用户类
 * 
 * @author 齐福
 *         创建时间 ： 2016年11月24日上午11:19:21
 */
class User extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 转向用户列表页
     *
     * @return [view] [用户列表页面]
     */
    public function user_list()
    {
        $this->load->view('/jt_admin/user/user_list');
    }

    /**
     * 返回会员列表ajax数据
     *
     * @return [json] [会员列表数据]
     */
    public function list_data()
    {
        $limit = form('length');
        if (! $limit || $limit > 100)
            $limit = 10;
        
        $offset = form('start');
        
        $filter = null;
        $total_filter = $filter;
        if (data_form('mId'))
            $filter['mId ='] = data_form('id');
        if (data_form('mName'))
            $filter['mName ='] = data_form('mName');
        if (data_form('mNickName'))
            $filter['mNickName ='] = data_form('mNickName');
        if (data_form('mPhone'))
            $filter['mPhone ='] = data_form('mPhone');

        $order = 'mID desc';
        if(form('order')){
            $ordername = $_POST['columns'][$_POST['order'][0]['column']]['data'];
            $ordervalue = $_POST['order'][0]['dir'];
            $order = ''.$ordername.' '.$ordervalue;
        }
        $order .=' &mID';
        $join = array(
                    'spe_integral' => 'mId = spe_integral.mID and spe_integral.iPayType = 0 and spe_integral.iType = 0',
                );
        $data['data'] = $this->model('jt_admin/user')->get_list("spe_members.*,SUM(spe_integral.payPoints) as useSumPayPoints", $filter, $join , $order, $limit, $offset);
        $data['recordsTotal'] = $this->model('jt_admin/user')->get_count($total_filter);
        $data['recordsFiltered'] = $this->model('jt_admin/user')->get_count($filter);
        echo json_encode($data);
        exit();
    }

    /**
     * 添加会员
     *
     * @return [view] [添加会员页面]
     */
    public function admin_add()
    {
        $data['data'] = $this->model('jt_admin/auth_group')->get_list("*", null, null, null, null, null);
        $this->load->view('/jt_admin/admin/admin_add', $data);
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
            'mId' => $uID
        );
        
        $where = array(
            'mId' => $uID
        );
        if (form('id')) {
            if (form('mNickName'))
                $update_item['mNickName'] = form('mNickName');
            if (form('mPhone'))
                $update_item['mPhone'] = form('mPhone');
            if (form('mEmail'))
                $update_item['mEmail'] = form('mEmail');
            
            if (form('ori_mNickName'))
                $log_item['ori_mNickName'] = form('ori_mNickName');
            if (form('ori_mPhone'))
                $log_item['ori_mPhone'] = form('ori_mPhone');
            if (form('ori_mEmail'))
                $log_item['ori_mEmail'] = form('ori_mEmail');
            
            $update_item['mSex'] = form('group');
            $log_item['ori_mSex'] = form('ori_group');
            $admin_log_msg[] = '更改会员信息';
        }
        $admin_log_msg = implode(', ', $admin_log_msg);
        // 先记录操作内容
        $result = $this->model('jt_admin/admin_logs')->log($admin_log_msg, array_merge($update_item, $log_item), $uID);
        
        if ($result) {
            
            $result2 = $this->db->update('spe_members', $update_item, $where);
            $json_result['status'] = $result2;
            if (! $result2) {
                $json_result['status'] = false;
                $json_result['msg'] = '操作数据库时出错1';
            } else {
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
                $data = $this->model('jt_admin/user')->get_row('*', array(
                    'id' => $id
                ));
                $pass = generate_Random_String(6);
                $usalt = rand(1000, 9999);
                $passmd5 = md5(md5($pass . $usalt));
                
                $where = array(
                    'mId' => $id
                );
                $update_item = array(
                    'mId' => $id,
                    'mPwd' => $passmd5,
                    'mSalt' => $usalt
                );
                $log_item = array(
                    'ori_mId' => $id,
                    'ori_mPwd' => $data['mPwd']
                );
                $rdata = $this->db->update('spe_members', $update_item, $where);
                if ($rdata) {
                    $admin_log_msg = '后台重置会员密码';
                    // 先记录操作内容
                    $result = $this->model('jt_admin/admin_logs')->log($admin_log_msg, array_merge($update_item, $log_item), $id);
                    $json_result['status'] = false;
                    $json_result['msg'] = "会员用户：" . $data['mName'] . "，重置密码成功<br>新密码为：" . $pass;
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
     * 转向个人详情页面
     */
    public function user_detail()
    {
        $id = urlget('id');
        if ($id) {
            $data = $this->model('jt_admin/user')->get_row('*', array(
                'mId' => $id
            ));
            $filter['invInviter'] = $id;
            $filter['invLevel'] = 1;
            $data['yzrs'] = $this->model('jt_admin/member_invitation')->get_count($filter);
            $data['yzjf'] = $this->model('jt_admin/member_invitation')->get_row("sum(invIntegral) as he",$filter);
            $filter['invLevel'] = 2;
            $data['ezrs'] = $this->model('jt_admin/member_invitation')->get_count($filter);
            $data['ezjf'] = $this->model('jt_admin/member_invitation')->get_row("sum(invIntegral) as he",$filter);
            $filter['invLevel'] = 3;
            $data['szrs'] = $this->model('jt_admin/member_invitation')->get_count($filter);
            $data['szjf'] = $this->model('jt_admin/member_invitation')->get_row("sum(invIntegral) as he",$filter);
            $data['zrs'] = $data['yzrs']+$data['ezrs']+$data['szrs'];
            $data['zjf'] = $data['yzjf']['he']+$data['ezjf']['he']+$data['szjf']['he'];
            
            if (! $data)
                exit('无效会员id<a href="javascript:history.back(-1);">返回</a>');
            $this->load->view('/jt_admin/user/user_detail', $data);
        } else {
            echo '会员ID有误 <a href="javascript:history.back(-1);">返回</a>';
        }
    }


    /**
     * 返回积分列表ajax数据
     *
     * @return [json] [积分列表数据]
     */
    public function integral_list_data()
    {

        $limit = form('length');
        if (! $limit || $limit > 100)
            $limit = 10;
        
        $offset = form('start');
        
        $filter = null;
        $userid = $this->input->post('user_id',true);
       
        $total_filter = $filter;
        $total_filter['mID = '] = $userid;
        if (data_form('mPhone'))
            $filter['u.mPhone ='] = data_form('mPhone');
        if (data_form('iType')||data_form('iType')=='0')
            $filter['iType ='] = data_form('iType');
        $filter['u.mId ='] = $userid;
        $filter['uName !='] = 'admin';
        $order = 'spe_integral.iID desc';
        $join = array(
            'spe_members u' => 'spe_integral.mID = u.mId',
        );
        $data['data'] = $this->model('jt_admin/integral')->get_list("spe_integral.*,u.mPhone", $filter, $join, $order, $limit, $offset);
        $data['recordsTotal'] = $this->model('jt_admin/integral')->get_count($total_filter);
        $data['recordsFiltered'] = $this->model('jt_admin/integral')->get_count($total_filter);
        echo json_encode($data);
        exit();
    }




    /**
     * 返回关系列表ajax数据
     *
     * @return [json] [关系列表数据]
     */
    public function invitation_list_data()
    {

        $limit = form('length');
        if (! $limit || $limit > 100)
            $limit = 10;
        
        $offset = form('start');
        
        $filter = null;
        $userid = $this->input->post('user_id',true);

        if (data_form('invBeinvited')||data_form('invBeinvited')=='0')
            $filter['invBeinvited ='] = data_form('invBeinvited');
       
        $total_filter = $filter;

        $filter['invInviter ='] = $userid;
        $order = 'invID desc';
        $join = array(
                    'spe_members u' => 'spe_member_invitation.invBeinvited = u.mId',
                );
        $data['data'] = $this->model('jt_admin/member_invitation')->get_list("*,u.mPhone", $filter, $join, $order, $limit, $offset);
        $data['recordsTotal'] = $this->model('jt_admin/member_invitation')->get_count($filter);
        $data['recordsFiltered'] = $this->model('jt_admin/member_invitation')->get_count($filter);
        echo json_encode($data);
        exit();
    }
}
