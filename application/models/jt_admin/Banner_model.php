<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * banner模型类
 * @author 齐福
 * 创建时间 ： 2017年10月9日下午1:18:43
 */
class Banner_model extends MY_Model{
    public function __construct(){
        $this->table = 'spe_banner';

        parent::__construct();
    }
    public function change_status($id,$status){
        $udata['bStatus'] = $status;
        $where['bID'] = intval($id);
        $result = $this->db->update($this->table,$udata, $where);
        return $result;
    }
    
}



