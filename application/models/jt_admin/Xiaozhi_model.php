<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 客服小智模型类
 * 
 * @author 齐福
 *         创建时间 ： 2018年7月4日上午11:31:12
 */
class Xiaozhi_model extends MY_Model
{

    public function __construct()
    {
        $this->table = 'spe_xiaozhi';
        
        parent::__construct();
    }
    
}