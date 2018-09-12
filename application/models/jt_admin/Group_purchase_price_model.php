<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 拼团价格模型类
 * @author 齐福
 * 创建时间 ： 2017年8月30日上午10:02:43
 */
class Group_purchase_price_model extends MY_Model{
    public function __construct(){
        $this->table = 'spe_group_purchase_price';
        parent::__construct();
    }
    public function del_by_gpid($id)
    {
    	return $this->delete(array('gpID' => $id));
    }
}



