<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 入驻商模型
 * @author 齐福
 * 创建时间 ： 2016年12月12日下午1:35:19
 */
class Shop_model extends MY_Model{
    public function __construct(){
        $this->table = 'spe_shops';

        parent::__construct();
    }
    /**
     * 返回字段文字
     * return array customized attribute labels (name=>label)
     */
    public function attribute_labels()
    {
		return array(
			'sId' => 'ID',
			'sName' => '用户名',
			'sPwd' => '密码',
			'sShopMoney' => '商铺余额',
			'sShopName' => '店铺名',
			'sSales' => '销售量',
			'sLogo' => 'Logo',
			'sIntroduction' => '店铺简介',
			'sLevel' => '店铺级别(具体待定）',
			'sType' => '店铺类型',//1企业0个人
			'sDel' => '是否删除',
			'sSartTime' => '店铺开始时间',
			'sEndTime' => '店铺结束时间',
		    'sAddTime' => '插入时间',
		    'sProvince' => '省',
		    'sCity' => '市',
		    'sDistinct' => '区',
		);
    }
}



