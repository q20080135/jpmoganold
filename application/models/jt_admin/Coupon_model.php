<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 优惠券模型类
 * 
 * @author 齐福
 *         创建时间 ： 2017年5月4日上午8:54:12
 */
class Coupon_model extends MY_Model
{

    public function __construct()
    {
        $this->table = 'spe_coupon';
        
        parent::__construct();
    }

}



