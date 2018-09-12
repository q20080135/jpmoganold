<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Comment_model extends MY_Model
{
    public function __construct()
    {
        $this->table = 'spe_comment';

        parent::__construct();
    }


    public function getListData($where, $order = '', $limit = 10, $offset = 0, $join = array())
    {
        $filds = "spe_comment.*, m.mName, g.gName,m.mPhone";
        $where['delFlag'] = '0';

        $join = array(
            'spe_members m' => 'mId = m.mId'
            ,'spe_goods g' => 'gID = g.gID'
        );
        $goods = $this->model('jt_admin/comment')->get_list($filds, $where, $join, $order, $limit, $offset);
        
        return $goods;
    }
}
