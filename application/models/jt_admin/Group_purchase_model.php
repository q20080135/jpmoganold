<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 拼团模型类
 * @author 齐福
 * 创建时间 ： 2017年8月30日上午10:02:43
 */
class Group_purchase_model extends MY_Model{
    public function __construct(){
        $this->table = 'spe_group_purchase';
        parent::__construct();
    }

    public function logic_del($id){
    	$udata['gpStatus'] = 3;
        $where['gpID'] = intval($id);
        $result = $this->db->update($this->table,$udata, $where);
        return $result;
    }
    public function change_status($id,$status){
        $udata['gpStatus'] = $status;
        $where['gpID'] = intval($id);
        $result = $this->db->update($this->table,$udata, $where);
        return $result;
    }

    public function my_get_list($where,$limit = 10, $offset = 0){

        $this->db->query('SET GLOBAL group_concat_max_len=102400');

        $whereText = '';

        if(isset($where['g.gName %%'])){
            $whereText = ' and gName like "%'.$where['g.gName %%'].'%"';
        }
        if(isset($where['gpID'])){
            $whereText = ' and gp.gpID = "'.$where['gpID'].'"';
        }
        $sql = '
        SELECT gp.*,
               g.gName,g.gThumbPic,g.gPrices,g.gDiscountPrice,
               group_concat(gppPrice SEPARATOR "|||") AS gppPrice,
               group_concat(gppPeopleNumber SEPARATOR "|||") as gppPeopleNumber

        FROM spe_group_purchase AS gp
        LEFT JOIN spe_goods AS g ON gp.gID = g.gID
        LEFT JOIN spe_group_purchase_price AS gpp ON gp.gpID = gpp.gpID
        WHERE gpStatus <> 3 '.$whereText.'
        GROUP BY gpID 
        ORDER BY gpID desc
        LIMIT '.$offset.',' .$limit;



        
        $result = $this->db->query($sql);
        return $result->result_array();
    }
}



