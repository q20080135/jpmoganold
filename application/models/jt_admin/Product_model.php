<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Product_model extends MY_Model
{
    public function __construct()
    {
        $this->table = 'spe_goods';

        parent::__construct();
    }

    public function getProductDetail($id)
    {

        $fild = '*';
        $where = array('gID' => $id);

        $join = array(
            // 'sep_shops p' => 'sId = p.sId'
            // , 'user u' => 'tjr = u.user',
        );
        if ($id) {
            $detail = $this->model('jt_admin/product')->get_row($fild, $where, $join);
            // dump_query();
            // unset($detail['fenxiang']);
            // dump($detail);

            return $detail;
        } else {
            return null;
        }
    }
   

    public function getListData($where, $order = '', $limit = 10, $offset = 0, $join = array())
    {
        $filds = "*,p.sName,p.sShopName,c.cName,sg.sgName,p.sLevel,pr.region_name as pname,cr.region_name as cname,w.whNum";
        $goods = $this->model('jt_admin/product')->get_list($filds, $where, $join, $order, $limit, $offset);
        return $goods;
    }
    /**
     * 逻辑删除产品
     */
    public function logic_del($id){
        $udata['gDel'] = 1;
        $where['gID'] = intval($id);
        $result = $this->db->update($this->table,$udata, $where);
        return $result;
    }
    /**
     * 恢复产品
     */
    public function recovery($id){
        $udata['gDel'] = 0;
        $where['gID'] = intval($id);
        $result = $this->db->update($this->table,$udata, $where);
        return $result;
    }
}
