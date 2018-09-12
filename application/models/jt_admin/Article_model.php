<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Article_model extends MY_Model
{
    public function __construct()
    {
        $this->table = 'spe_articles';

        parent::__construct();
    }

    public function getListData($where, $order = '', $limit = 10, $offset = 0, $join = array())
    {
        $filds = "spe_articles.*, c.cName, a.uRealName";
        $where['aDel'] = '0';

        $join = array(
            'spe_classify c' => 'cID = c.cID'
            ,'spe_admins a' => 'uId = a.uID'
        );
        $goods = $this->get_list($filds, $where, $join, $order, $limit, $offset);

        return $goods;
    }



    public function getDetailData($id)
    {

        $fild = '*';
        $where = array('id' => $id);

        $join = array(
            // 'product p' => 'sp_id = p.id'
            // , 'user u' => 'tjr = u.user',
        );

        if ($id) {
            $detail = $this->get_row($fild, $where, $join);

            return $detail;
        } else {
            return null;
        }
    }

    public function logic_del($id){
        $udata['aDel'] = 1;
        $where['aID'] = intval($id);
        $result = $this->db->update($this->table,$udata, $where);
        return $result;
    }

}
