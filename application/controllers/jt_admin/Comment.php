<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Comment extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        $this->commentList();
    }
    /**
     * 评论列表
     * @return [view] [评论列表页面]
     */
    public function commentList()
    {
        $data = null;
 
        // $where  = array('id'=>'set','asdf'=>'avvv');
        // dump($str);
        $this->load->view('jt_admin/comment/commentList', $data);
    }

    /**
     * 返回评论列表ajax数据
     * @return [json] [评论列表数据]
     */
    public function listData()
    {
        $this->load->library('AdminList');
        $list = new AdminList();

        $list->setFilter('cmID');
        $list->setFilter('cmContent', 'cmContent %%');
        $list->setFilter('cmScore');

        $list->setOrder('cmID desc');
        $list->setModel('jt_admin/comment');

        $data = $list->getListData();

        exit_json($data);
    }

    public function updateView()
    {
        $this->load->library('AdminCrud');
        $u = new AdminCrud();
        
        $where['cmID'] = form('id');
        $data['viewFlag'] = form('val');

        $u->updateCol('jt_admin/comment', $data, $where);
    }

    public function updateDel()
    {
        $this->load->library('AdminCrud');
        $u = new AdminCrud();
        
        $where['cmID'] = form('id');
        $data['delFlag'] = form('val');

        $u->updateCol('jt_admin/comment', $data, $where);
    }
}
