<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends MY_Controller
{
    /**
     * 首页
     */
    public function index()
    {
    	$data = $this->model('jt_admin/base')->get_row('*');
        
    	$sql = "SELECT * FROM `spe_articles` WHERE aAddtime<now() and aIsView = 1 and aDel = 0 and aIsRecommend =1 and cID = 142 order by aAddtime desc  limit 0,3";
        $que = $this->db->query($sql);
        $data['wdata1'] = $que->result_array();

        $sql = "SELECT * FROM `spe_articles` WHERE aAddtime<now() and aIsView = 1 and aDel = 0 and aIsRecommend =1 and cID in (134,135) order by aAddtime desc limit 0,3";
        $que = $this->db->query($sql);
        $data['wdata2'] = $que->result_array();

        $sql = "SELECT * FROM `spe_articles` WHERE aAddtime<now() and aIsView = 1 and aDel = 0 and aIsRecommend =1 and cID = 136 order by aAddtime desc limit 0,3";
        $que = $this->db->query($sql);
        $data['wdata3'] = $que->result_array();


        $this->load->view('index',$data);
    }
}
