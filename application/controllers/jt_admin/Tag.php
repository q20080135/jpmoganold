<?php defined('BASEPATH') or exit('No direct script access allowed');

class Tag extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->tagList();
    }

    /**
     * 产品列表
     * @return [view] [产品列表页面]tag
     */
    public function tagList()
    {
        $data = null;
        // $str =  $this->db->get_where($where);·
        // dump($str);
        $this->load->view('jt_admin/tag/tagList', $data);
    }
    /**
     * 返回产品列表ajax数据
     * @return [json] [产品列表数据]
     */
    public function listData()
    {
        
        $filter = null;
        $offset = 0;
        
        $total_filter = $filter;

        if (data_form('tID')) {
            $filter['tID'] = data_form('tID');
        }
        if (data_form('tName')) {
            $filter['tName'] = data_form('tName');
        }


        $offset = form('start');
        $limit = form('length');
        $order = 'tID';
        if (!$limit || $limit > 100) {
            $limit  = 10;
        }
        // $data['data'] = $this->model('tag')->get_list("*", $filter, array(), $order, $limit, $offset);
        $data['data'] = $this->model('jt_admin/tag')->getListData($filter, $order, $limit, $offset);
        // dump_query();
       
        $data['recordsTotal'] = $this->model('jt_admin/tag')->get_count($total_filter);
        $data['recordsFiltered'] = $this->model('jt_admin/tag')->get_count($filter);
        // $data['recordsFiltered'] = $data['recordsTotal'];
        // dump($data);

        echo json_encode($data);
        exit;
    }

    public function updateAuditing()
    {
        $this->load->library('AdminCrud');
        $u = new AdminCrud();

        $t_id = form('id');
        $tAuditing = form('val');
        
        $where['tID'] = $t_id;
        $data['tAuditing'] = $tAuditing;
        $data['tauditingTime'] = date("Y-m-d H-i-s");

        $u->updateCol('jt_admin/tag', $data, $where);
    }

    public function updateDel()
    {
        $this->load->library('AdminCrud');
        $u = new AdminCrud();

        $t_id = form('id');
        $tDel = form('val');
        
        $where['tID'] = $t_id;
        $data['tDel'] = $tDel;

        $u->updateCol('jt_admin/tag', $data, $where);
    }
}
