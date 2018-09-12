<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 搜索模型类
 * @author 齐福
 * 创建时间 ： 2016年12月27日上午11:17:06
 */

class Keys_model extends MY_Model {
    public function __construct()
    {
        $this->table = 'spe_keys';
        
        parent::__construct();
    }

}
