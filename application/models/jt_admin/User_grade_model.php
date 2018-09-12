<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 会员等级表
 * @author 齐福
 * 创建时间 ： 2016年11月28日上午8:51:57
 */
class User_grade_model extends MY_Model
{

    public function __construct()
    {
        $this->table = 'spe_member_grade';
        
        parent::__construct();
    }

    /**
     * 返回字段文字
     * return array customized attribute labels (name=>label)
     */
    public function attribute_labels()
    {
    	return array(
    	    'mgID' => 'ID',
    	    'mgName' => '等级名称',
    	    'mgMinIntegral' => '门槛积分',
    	    'mgMaxIntegral' => '晋级积分',
    	    'mgDiscount' => '折扣',
    	);
    }
}



