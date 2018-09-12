<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * @author 齐福
 * 创建时间 ： 2017年7月28日下午1:18:43
 */
class Base_model extends MY_Model{
    public function __construct(){
        $this->table = 'spe_base';

        parent::__construct();
    }
    
}



