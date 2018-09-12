<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 会员模型类
 * @author 齐福
 * 创建时间 ： 2016年11月24日上午11:45:51
 */
class User_model extends MY_Model{
    public function __construct(){
        $this->table = 'spe_members';

        parent::__construct();
    }
    /**
     * 返回字段文字
     * return array customized attribute labels (name=>label)
     */
    public function attribute_labels()
    {
		return array(
			'mId' => 'ID',
			'mName' => '用户名',
			'mSex' => '性别',
			'mPhone' => '电话',
			'mPwd' => '密码',
			'mSalt' => '密码盐',
			'mStatus' => '会员状态',
			'mSource' => '会员来源',
			'mParentId' => '邀请人ID',
			'mBalance' => '会员余额',
			'mIntegral' => '会员积分',
			'mProvince' => '会员省份',
			'mCity' => '会员城市',
			'mRegion' => '会员地区',
			'mAddress' => '会员详细地址',
			'mPicture' => '会员头像',
			'mBirthday' => '会员生日',
			'mNickName' => '会员昵称',
			'mAddTime' => '加入时间',
			'mAddIp' => '添加IP',
			'mEmail' => '会员邮箱',
			'mEmailVerification' => '邮箱验证状态',
			'auID' => '角色',
			'mDel' => '删除状态',
			'mgID' => '用户等级',
		);
    }
}



