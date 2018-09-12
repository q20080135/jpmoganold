<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 广告模型类
 * 
 * @author 齐福
 *         创建时间 ： 2016年12月12日上午8:54:12
 */
class Ads_model extends MY_Model
{

    public function __construct()
    {
        $this->table = 'spe_ads';
        
        parent::__construct();
    }

    /**
     * 返回字段文字
     * return array customized attribute labels (name=>label)
     */
    public function attribute_labels()
    {
        return array(
            'adID' => 'ID',
            'adName' => '广告名称',
            'adCid' => '广告分类',
            'adProvince' => '省份',
            'adCity' => '城市',
            'adArea' => '地区',
            'adStartTime' => '开始时间',
            'adEndTime' => '结束时间',
            'adType' => '广告类型',//
            'adUrl' => '广告链接',//存出为ID（产品id，店铺id）
            'adClick' => '点击量',
            'adSort' => '广告顺序',
            'adRemark' => '广告备注',
            'adImg' => '广告图片',
            'mId' => '所属入驻商'
        );
    }
}



