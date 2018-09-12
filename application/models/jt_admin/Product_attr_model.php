<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 产品属性模型类
 * @author 齐福
 * 创建时间 ： 2017年11月2日上午9:13:13
 */
class Product_attr_model extends MY_Model{
    public function __construct(){
        $this->table = 'spe_product_attr';

        parent::__construct();
    }
    
}



