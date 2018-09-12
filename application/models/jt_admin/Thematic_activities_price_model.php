<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 专题活动价格模型类
 * @author 齐福
 * 创建时间 ： 2017年8月30日上午10:02:43
 */
class Thematic_activities_price_model extends MY_Model{
    public function __construct(){
        $this->table = 'spe_thematic_activities_price';
        parent::__construct();
    }
}



