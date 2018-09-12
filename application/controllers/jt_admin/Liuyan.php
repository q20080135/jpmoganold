<?php  defined('BASEPATH') or exit('No direct script access allowed');

class Liuyan extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
    }
   

    /**
     * 产品列表
     * @return [view] [产品列表页面]
     */
    public function liuyan_list()
    {
        $data = null;
        $this->load->view('jt_admin/liuyan/liuyan_list', $data);
    }

   

    /**
     * 返回产品列表ajax数据
     * @return [json] [产品列表数据]
     */
    public function list_data()
    {
        
        $filter = null;
        $offset = 0;
        
        $filter['lIsDel'] = 0;
        $total_filter = $filter;
       
        if (data_form('lName')) {
            $filter['lName'] = data_form('lName');
        }
        if (data_form('lPhone')) {
            $filter['lPhone %%'] = data_form('lPhone');
        }
        if (data_form('lEmail')) {
            $filter['lEmail %%'] = data_form('lEmail');
        }

        $offset = form('start');
        $limit = form('length');
        $order = 'lID desc';
        if (!$limit || $limit > 100) {
            $limit  = 10;
        }
        $join = array(
        );
        $data['data'] = $this->model('jt_admin/liuyan')->getListData($filter, $order, $limit, $offset,$join);

        $data['recordsTotal'] = $this->model('jt_admin/liuyan')->get_count($total_filter);
        $data['recordsFiltered'] = $this->model('jt_admin/liuyan')->get_count($filter,$join);
        echo json_encode($data);
        exit;
    }

     /**
     * 逻辑删除
     */
    public function logic_del()
    {
        $id = form('id');
        if ($id) {
            $data = $this->model('jt_admin/liuyan')->get_row('*', array(
                'lID' => $id
            ));
    
            if (! $data) {
                $json_result['status'] = false;
                $json_result['msg'] = '未查找到留言信息。';
            } else {
                $this->load->library('AdminCrud');
                $u = new AdminCrud();
                $u->isnullSetLogTitle('留言逻辑删除。');
                // 表单验证规则在 config/form_validation.php 文件
                if ($u->validationAndWriteLog($id)) {
                    $result = $this->model('jt_admin/liuyan')->logic_del($id);
                    if ($result) {
                        $json_result['status'] = true;
                        $json_result['msg'] = '留言逻辑成功。';
                    } else {
                        $json_result['msg'] = '操作数据库时出错';
                    }
    
                }else{
                    $json_result['status'] = false;
                    $json_result['msg'] = '验证不通过。';
                }

            }
        } else {
            $json_result['status'] = false;
            $json_result['msg'] = 'ID有误';
        }
        echo json_encode($json_result);
    }


     /**
     * 更改状态
     */
    public function updateType()
    {
        $id = form('id');
        $type = form('val');
        if ($id) {
            $data = $this->model('jt_admin/liuyan')->get_row('*', array(
                'lID' => $id
            ));
    
            if (! $data) {
                $json_result['status'] = false;
                $json_result['msg'] = '未查找到产品信息。';
            } else {
                $this->load->library('AdminCrud');
                $u = new AdminCrud();
                $u->isnullSetLogTitle('留言更改状态。');
                // 表单验证规则在 config/form_validation.php 文件
                if ($u->validationAndWriteLog($id)) {
                    $result = $this->model('jt_admin/liuyan')->updateType($id,$type);
                    if ($result) {
                        $json_result['status'] = true;
                        $json_result['msg'] = '留言更改状态。';
                    } else {
                        $json_result['msg'] = '操作数据库时出错';
                    }
    
                }else{
                    $json_result['status'] = false;
                    $json_result['msg'] = '验证不通过。';
                }

            }
        } else {
            $json_result['status'] = false;
            $json_result['msg'] = 'ID有误';
        }
        echo json_encode($json_result);
    }


   


}

