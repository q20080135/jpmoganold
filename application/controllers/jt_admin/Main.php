<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends ADMIN_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * http://example.com/index.php/welcome
     * - or -
     * http://example.com/index.php/welcome/index
     * - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     *
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {
        $limit = form('length');
        if (! $limit || $limit > 100) {
            $limit = 0;
        }
        $offset = form('start');
        $order = 'mSort asc';
        
        $group_data = $this->model('jt_admin/auth_group')->get_row('*', array(
            'auID' =>$this->admin_info['auID']
        ));
        
        $filter = null;
        $filter['mParentID ='] = 0;
        $filter['mID'] = explode(",", $group_data['auRight']);
        $filter['mHidden'] = 0;
        // 查询顶级菜单
        $data['menu'] = $this->model('jt_admin/menu')->get_list("*", $filter, null, $order, $limit, $offset);
        foreach ($data['menu'] as $key => $val) {
            $filter['mParentID ='] = $val['mID'];
            // 查询子菜单
            $data['menu'][$key]['sub_node'] = $this->model('jt_admin/menu')->get_list("*", $filter, null, $order, $limit, $offset);
        }
        $this->load->view('master_layout', $data);
    }
}
