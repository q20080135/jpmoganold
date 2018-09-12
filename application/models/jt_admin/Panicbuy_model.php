<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 抢购模型类
 * 
 * @author 齐福
 *         创建时间 ： 2016年12月12日上午8:54:12
 */
class Panicbuy_model extends MY_Model
{

    public function __construct()
    {
        $this->table = 'spe_panicbuy';
        
        parent::__construct();
    }

}



