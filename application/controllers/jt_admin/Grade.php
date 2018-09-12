<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 用户等级类
 * @author 齐福
 * 创建时间 ： 2016年11月24日上午11:19:21
 */
class Grade extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * 转向用户等级列表页
     *
     * @return [view] [用户等级列表页面]
     */
    public function grade_list()
    {
        $this->load->view('/jt_admin/grade/grade_list');
    }
    
    /**
     * 返回用户等级列表ajax数据
     *
     * @return [json] [用户等级列表数据]
     */
    public function grade_list_data()
    {
        $limit = form('length');
        if (! $limit || $limit > 100)
            $limit = 10;
    
        $offset = form('start');
    
        $filter = null;
        $total_filter = $filter;
        if (data_form('id'))
            $filter['mgID ='] = data_form('id');
        if (data_form('mgName'))
            $filter['mgName ='] = data_form('mgName');
        $order = 'mgID desc';
        $data['data'] = $this->model('jt_admin/user_grade')->get_list("*", $filter, null, $order, $limit, $offset);
        $data['recordsTotal'] = $this->model('jt_admin/user_grade')->get_count($total_filter);
        $data['recordsFiltered'] = $this->model('jt_admin/user_grade')->get_count($filter);
        echo json_encode($data);
        exit();
    }
    /**
     * 添加/编辑会员等级
     *
     * @return [view] [添加/编辑会员等级页面]
     */
    public function grade_edit()
    {
    	$id = urlget('id');
    	if ($id) {
    	    $data = $this->model('jt_admin/user_grade')->get_row('*', array(
    	        'mgID' => $id
    	    ));
    	    if (!$data)
    	        exit('无效id<a href="javascript:history.back(-1);">返回</a>');
    	    $data['title'] = '修改会员等级';
    	} else {
    		$data['title'] = '添加会员等级';
    	}
    	$this->load->view('/jt_admin/grade/grade_edit', $data);
    }
    
    
    
    /**
     * 保存会员等级信息
     *
     * @return [json] [返回信息]
     */
    public function edit_save()
    {

        $data = $this->model('jt_admin/user_grade')->get_row('*', array(
            'mgName' => form('mgNamepd')
        ));
        

        if (! $data | form('id')) {

        	$id = form('id');
        	$add_item = array(
                'mgID' => $id
            );
        	if (gettype(form('mgName')) == 'string')
        	    $add_item['mgName'] = form('mgName');
        	if (gettype(form('mgMinIntegral')) == 'string')
        	    $add_item['mgMinIntegral'] = form('mgMinIntegral');
        	if (gettype(form('mgMaxIntegral')) == 'string')
        	    $add_item['mgMaxIntegral'] = form('mgMaxIntegral');
        	if (gettype(form('mgDiscount')) == 'string'){
        		$add_item['mgDiscount'] = intval(form('mgDiscount'));
        		if(!is_int($add_item['mgDiscount'])||$add_item['mgDiscount']<1||$add_item['mgDiscount']>100)//当不为整数时
        		{
        		    $json_result['status'] = false;
        		    $json_result['msg'] = '设置折扣，请输入1-100之间的整数。';
        		    echo json_encode($json_result);
        		    die;
        		}	
        	}

        	
        	if (form('id')) {

        		$where = array(
        		    'mgID' => $id
        		);
        		if (form('ori_mgMinIntegral'))
        		$log_item['ori_mgMinIntegral'] = form('ori_mgMinIntegral');
        		if (form('ori_mgMaxIntegral'))
        		$log_item['ori_mgMaxIntegral'] = form('ori_mgMaxIntegral');
        		if (form('ori_mgDiscount'))
        		$log_item['ori_mgDiscount'] = form('ori_mgDiscount');
        		if (form('ori_mgName'))
        		$log_item['ori_mgName'] = form('ori_mgName');

        		$query = $this->db->update('spe_member_grade', $add_item,$where);
        		// 先记录操作内容
        		$admin_log_msg = "修改会员等级。";
     
        		$result = $this->model('jt_admin/admin_logs')->log($admin_log_msg, array_merge($add_item, $log_item), $id);
        		if ($result) {
        		    $json_result['status'] = true;
        		    $json_result['msg'] = '修改会员等级成功！';
        		} else {
        		
        		    $json_result['status'] = false;
        		    $json_result['msg'] = '操作数据库时出错';
        		}
       
        	}else{

        		$admin_log_msg = "添加会员等级。";
        		$query = $this->db->insert('spe_member_grade', $add_item);
        		$id = $this->db->insert_id();
        		// 先记录操作内容
        		$result = $this->model('jt_admin/admin_logs')->log($admin_log_msg, $add_item, $id);
        		
        		if ($result) {
        		    $json_result['status'] = true;
        		    $json_result['msg'] = '创建会员等级成功！';
        		} else {
        		
        		    $json_result['status'] = false;
        		    $json_result['msg'] = '操作数据库时出错2';
        		}
        	}
           
          
        } else {
            $json_result['status'] = false;
            $json_result['msg'] = '会员等级名称已存在！';
        }
    
        echo json_encode($json_result);
    }
    /**
     * 删除会员等级
     */
    public function del_grade()
    {
        $id = form('id');
        if ($id) {
            $data = $this->model('jt_admin/user_grade')->get_row('*', array(
                'mgID' => $id
            ));
            if (! $data) {
                $json_result['status'] = false;
                $json_result['msg'] = '未查找到会员等级信息。';
            } else {
                $admin_data = $this->model('jt_admin/user')->get_row('*', array(
                    'mgID' => $id
                ));
                if ($admin_data) {
                    $json_result['status'] = false;
                    $json_result['msg'] = '该信息正在使用中，请调动会员等级后再删除。';
                } else {
                    $this->model('jt_admin/user_grade')->del_by_id($id);
                    $json_result['status'] = true;
                    $json_result['msg'] = '会员等级删除成功。';
                }
            }
        } else {
            $json_result['status'] = false;
            $json_result['msg'] = 'ID有误';
        }
        echo json_encode($json_result);
    }
    /**
     * 修改折扣
     */
    public function mgDiscount_change() {
    	$id = form('id');
    	if ($id) {
    		$where = array(
    		    'mgID' => $id
    		);
    		$log_item['ori_mgDiscount'] = form('lval');
    		$update_item['mgDiscount'] = intval(form('val'));
			if(!is_int($update_item['mgDiscount'])||$update_item['mgDiscount']<1||$update_item['mgDiscount']>100)//当不为整数时
			{
			    $json_result['status'] = false;
				$json_result['msg'] = '设置折扣，请输入1-100之间的整数。';
				echo json_encode($json_result);
				die;
			}
    		$query = $this->db->update('spe_member_grade', $update_item,$where);
    		// 先记录操作内容
    		$admin_log_msg = "修改会员等级。";
    		
    		$result = $this->model('jt_admin/admin_logs')->log($admin_log_msg, array_merge($update_item, $log_item), $id);
    		if ($result) {
    		    $json_result['status'] = true;
    		    $json_result['msg'] = '修改管理员角色成功！';
    		} else {
    		
    		    $json_result['status'] = false;
    		    $json_result['msg'] = '操作数据库时出错';
    		}
		} else {
		    $json_result['status'] = false;
		    $json_result['msg'] = 'ID有误';
		}

    	echo json_encode($json_result);
    }
}
