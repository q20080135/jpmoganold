<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 客服小智
 * @author 齐福
 * 创建时间 ： 2018年7月4日上午9:33:11
 */
class Xiaozhi extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

   
    public function xiaozhi_list()
    {
        $this->load->view('/jt_admin/xiaozhi/xiaozhi_list');
    }


    public function list_data()
    {
        $limit = form('length');
        if (! $limit || $limit > 100)
            $limit = 10;
        
        $offset = form('start');
        
        $filter = null;
        $total_filter = $filter;
        if (data_form('xName'))
            $filter['xName'] = data_form('xName');
        if (data_form('xStatus'))
            $filter['xStatus'] = data_form('xStatus');
        if (data_form('xEmail'))
            $filter['xEmail'] = data_form('xEmail');
        if (data_form('xPhone'))
            $filter['xPhone'] = data_form('xPhone');
        $filter['xIsDel'] = 0;
        $order = 'xId desc';
        if(form('order')){
            $ordername = $_POST['columns'][$_POST['order'][0]['column']]['data'];
            $ordervalue = $_POST['order'][0]['dir'];
            $order = ''.$ordername.' '.$ordervalue;
        }
        $data['data'] = $this->model('jt_admin/xiaozhi')->get_list("*", $filter, null, $order, $limit, $offset);
        $data['recordsTotal'] = $this->model('jt_admin/xiaozhi')->get_count($total_filter);
        $data['recordsFiltered'] = $this->model('jt_admin/xiaozhi')->get_count($filter);
        echo json_encode($data);
        exit();
    }
    public function beizhu(){
        $id = $this->input->post('id',true);
        $xBeizhu = $this->input->post('xBeizhu',true);
        $xStatus = $this->input->post('xStatus',true);
        if($id!=''){
            $update_item['xBeizhu'] = $xBeizhu;
            $update_item['xStatus'] = $xStatus;
            $where['xId'] = $id;
            $rdata = $this->db->update('spe_xiaozhi', $update_item, $where);    
            if($rdata){
                $json_result['status'] = true;
                $json_result['msg'] = '处理成功';
            }else{
                $json_result['status'] = false;
                $json_result['msg'] = '处理失败';
            }

        }else{
                $json_result['status'] = false;
                $json_result['msg'] = '处理失败';
        }
        die(json_encode($json_result));
    }
}
