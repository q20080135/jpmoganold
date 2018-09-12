<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 活动价格模型类
 * @author 齐福
 * 创建时间 ： 2017年11月2日下午15:30:43
 */
class Activities_info_model extends MY_Model{
    public function __construct(){
        $this->table = 'spe_activities_info';

        parent::__construct();
    }
    public function del_by_actid($id)
    {
    	return $this->delete(array('actID' => $id));
    }
}



