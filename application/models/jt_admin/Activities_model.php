<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 活动模型类
 * @author 齐福
 * 创建时间 ： 2017年10月23日下午14:12:44
 */
class Activities_model extends MY_Model{
    public function __construct(){
        $this->table = 'spe_activities';
        parent::__construct();
    }

    public function logic_del($id){
    	$udata['actStatus'] = 3;
        $where['actID'] = intval($id);
        $result = $this->db->update($this->table,$udata, $where);
        return $result;
    }
    public function change_status($id,$status){
        $udata['actStatus'] = $status;
        $where['actID'] = intval($id);
        $result = $this->db->update($this->table,$udata, $where);
        return $result;
    }

    public function my_get_list($where,$limit = 10, $offset = 0){

        $whereText = '';

        if(isset($where['g.gName %%'])){
            $whereText = ' and gName like "%'.$where['g.gName %%'].'%"';
        }
        if(isset($where['gpID'])){
            $whereText = ' and gp.gpID = "'.$where['gpID'].'"';
        }
        $sql = '
        SELECT act.*,
               g.gName,g.gThumbPic,g.gPrices,g.gDiscountPrice,
               group_concat(actiPrice SEPARATOR "|||") AS gppPrice,
               group_concat(ai.attrIDs SEPARATOR "|||") AS attrIDs,
               group_concat(actiPeopleNumber SEPARATOR "|||") as gppPeopleNumber

        FROM spe_activities AS act
        LEFT JOIN spe_activities_info AS ai ON act.actID = ai.actID
        LEFT JOIN spe_goods AS g ON act.gID = g.gID
        WHERE actStatus <> 3 '.$whereText.'
        GROUP BY actID 
        ORDER BY actID desc
        LIMIT '.$offset.',' .$limit;

        $result = $this->db->query($sql);
        return $result->result_array();
    }
}



