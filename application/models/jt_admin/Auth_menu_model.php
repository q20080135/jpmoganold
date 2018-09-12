<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 菜单模型类
 * @author 齐福
 * 创建时间 ： 2016年11月21日上午9:49:13
 */
class Auth_menu_model extends MY_Model{
    public function __construct(){
        $this->table = 'spe_auth_menu';

        parent::__construct();
    }
    /**
     * 返回字段文字
     * return array customized attribute labels (name=>label)
     */
    public function attribute_labels()
    {
		return array(
			'mID' => 'M',
			'mName' => 'M Name',
			'mParentID' => 'M Parent',
			'mUrl' => 'M Url',
			'mSort' => 'M Sort',
			'mType' => 'M Type',
			'mLcon' => 'M Lcon',
		);
    }
}



