<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 广告位置模型类
 * @author 齐福
 * 创建时间 ： 2016年12月19日下午3:18:43
 */
class Ad_position_model extends MY_Model{
    public function __construct(){
        $this->table = 'spe_ad_position';

        parent::__construct();
    }
    /**
     * 返回字段文字
     * return array customized attribute labels (name=>label)
     */
    public function attribute_labels()
    {
        return array(
            'apID' => 'ID',
            'apName' => '广告位置名称',
        );
    }
}



