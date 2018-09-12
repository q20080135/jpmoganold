<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 留言
 * @author 齐福
 * 创建时间 ： 2018年6月5日上午11:50:55
 */
class Liuyan_model extends MY_Model{
    public function __construct(){
        $this->table = 'spe_liuyan';

        parent::__construct();
    }
    public function getListData($where, $order = '', $limit = 10, $offset = 0, $join = array())
    {
        $filds = "*";
        $goods = $this->model('jt_admin/liuyan')->get_list($filds, $where, $join, $order, $limit, $offset);
        return $goods;
    }
    /**
     * 逻辑删除
     */
    public function logic_del($id){
        $udata['lIsDel'] = 1;
        $where['lID'] = intval($id);
        $result = $this->db->update($this->table,$udata, $where);
        return $result;
    }
     /**
     * 更改状态
     */
    public function updateType($id,$type){
        $udata['lType'] = intval($type);
        $where['lID'] = intval($id);
        $result = $this->db->update($this->table,$udata, $where);
        return $result;
    }
}



