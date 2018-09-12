<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * 后台配置模型类
 * @author 齐福
 * 创建时间 ： 2016年12月6日上午11:42:47
 */
class Config_model extends MY_Model
{
    public function __construct()
    {
        $this->table = 'spe_config';

        parent::__construct();
    }
    /**
     * 返回字段文字
     * return array customized attribute labels (name=>label)
     */
    public function attribute_labels()
    {
    	return array(
    	    'conID' => 'id',
    	    'conName' => '配置名',
    	    'conType' => '配置类型',
    	    'conData' => '配置数据',
    	    'conCallName' => '配置调用名',
    	    'conParentID' => '父类id',
    		'conRange' => '范围',
    	);
    }
}
