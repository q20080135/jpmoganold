<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 积分详情
 * @author 齐福
 * 创建时间 ： 2017年3月28日上午11:50:55
 */
class Integral_model extends MY_Model{
    public function __construct(){
        $this->table = 'spe_integral';

        parent::__construct();
    }
    /**
     * 返回字段文字
     * return array customized attribute labels (name=>label)
     */
    public function attribute_labels()
    {
        
        return array(
            'iID' => '积分id',
            'mID' => '用户id',
            'uID' => '管理员id',
            'payPoints' => '积分',
            'iDescribe' => '说明',
            'iType' => '类型',
            'iAddTime' => '插入时间',
        );
    }
}



