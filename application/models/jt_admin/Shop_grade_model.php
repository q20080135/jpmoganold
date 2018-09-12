<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 入驻商等级表
 * @author 齐福
 * 创建时间 ： 2017年2月27日下午2:33:46
 */
class Shop_grade_model extends MY_Model
{

    public function __construct()
    {
        $this->table = 'spe_shop_grade';
        
        parent::__construct();
    }

    /**
     * 返回字段文字
     * return array customized attribute labels (name=>label)
     */
    public function attribute_labels()
    {
    	return array(
    	    'sgID' => 'ID',
    	    'sgName' => '等级名称',
    	);
    }
}



