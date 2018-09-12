<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 专题活动模型类
 * @author 齐福
 * 创建时间 ： 2017年8月30日上午10:02:43
 */
class Thematic_activities_model extends MY_Model{
    public function __construct(){
        $this->table = 'spe_thematic_activities';
        parent::__construct();
    }
    /**
     * 更改活动专题状态
     */
    public function status_change($id,$status){
        //状态 默认为 0 ， 0 未开启  1 开启  2 暂时下线 3 逻辑删除 
    	$udata['taStatus'] = $status;
        $where['taID'] = intval($id);
        $result = $this->db->update($this->table,$udata, $where);
        return $result;
    }

    public function logic_del($id){
        $udata['taStatus'] = 3;
        $where['taID'] = intval($id);
        $result = $this->db->update($this->table,$udata, $where);
        return $result;
    }
    
    
}



