<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 产品分享奖励模型类
 * @author 齐福
 * 创建时间 ： 2017年12月27日下午13:58:43
 */
class Distribution_model extends MY_Model{
    public function __construct(){
        $this->table = 'spe_distribution';

        parent::__construct();
    }
    /**
     * 商品分享奖励设支持奖励状态
     */
    public function support_change($id,$status){
        $udata['dSupport'] = $status;
        $where['dId'] = intval($id);
        $result = $this->db->update($this->table,$udata, $where);
        return $result;
    }
}



