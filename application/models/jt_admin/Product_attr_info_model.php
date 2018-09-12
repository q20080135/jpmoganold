<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 产品属性详情模型类
 * @author 齐福
 * 创建时间 ： 2017年11月2日上午9:11:11
 */
class Product_attr_info_model extends MY_Model{
    public function __construct(){
        $this->table = 'spe_product_attr_info';

        parent::__construct();
    }
    
}



