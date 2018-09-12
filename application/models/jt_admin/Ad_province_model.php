<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 省广告模型类
 * @author 齐福
 * 创建时间 ： 2018年1月9日下午13:58:43
 */
class Ad_province_model extends MY_Model{
    public function __construct(){
        $this->table = 'spe_ad_province';

        parent::__construct();
    }
    /**
     * 修改状态
     */
    public function change_status($id,$status){
        $udata['adpStatus'] = $status;
        $where['adpId'] = intval($id);
        $result = $this->db->update($this->table,$udata, $where);
        return $result;
    }
}



