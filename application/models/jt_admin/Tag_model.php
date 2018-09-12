<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Tag_model extends MY_Model
{
    public function __construct()
    {
        $this->table = 'spe_tag';

        parent::__construct();
    }
  

    public function getListData($where, $order = '', $limit = 10, $offset = 0, $join = array())
    {
        $filds = "tID, tName, tAuditing, tDel";
        $tags = $this->model('jt_admin/tag')->get_list($filds, $where, array(), $order, $limit, $offset);
             
        return $tags;
    }
}
