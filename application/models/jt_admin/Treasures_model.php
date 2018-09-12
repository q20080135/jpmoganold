<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 珍品模型类
 * @author 齐福
 * 创建时间 ： 2017年7月28日下午1:18:43
 */
class Treasures_model extends MY_Model{
    public function __construct(){
        $this->table = 'spe_treasures';

        parent::__construct();
    }
    public function change_status($id,$status){
        $udata['trStatus'] = $status;
        $where['trID'] = intval($id);
        $result = $this->db->update($this->table,$udata, $where);
        return $result;
    }
    
}



