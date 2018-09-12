<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 管理员模型类
 * @author 齐福
 * 创建时间 ： 2016年11月18日下午3:06:43
 */
class Admins_model extends MY_Model{
    public function __construct(){
        $this->table = 'spe_admins';

        parent::__construct();
    }
    /**
     * 返回字段文字
     * return array customized attribute labels (name=>label)
     */
    public function attribute_labels()
    {
		return array(
			'uID' => 'uID',
			'uName' => 'U Name',
			'uPwd' => 'U Pwd',
			'uSalt' => 'U Salt',
			'auID' => 'Au',
			'uLastLoginIp' => 'U Last Login Ip',
			'uLastLoginTime' => 'U Last Login Time',
			'uAddtime' => 'U Addtime',
			'uRealName' => 'U Real Name',
			'uStatus' => 'U Status',
		);
    }
}



