<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * App版本更新模型类
 * @author 齐福
 * 创建时间 ： 2017年7月28日下午1:18:43
 */
class Version_model extends MY_Model{
    public function __construct(){
        $this->table = 'spe_version';

        parent::__construct();
    }
    
}



