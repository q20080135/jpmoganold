<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 子订单模型类
 * @author 齐福
 * 创建时间 ： 2016年12月22日上午10:08:58
 */
class Order_suborder_model extends MY_Model{
    public function __construct(){
        $this->table = 'spe_orders_suborder';

        parent::__construct();
    }
    /**
     * 返回字段文字
     * return array customized attribute labels (name=>label)
     */
    public function attribute_labels()
    {
		return array(
			'osID' => 'Os',
			'gID' => 'G',
			'gNum' => 'G Num',
			'gPrice' => 'G Price',
			'mId' => 'M',
			'mcAttr' => 'Mc Attr',
			'mcAddtime' => 'Mc Addtime',
			'gName' => 'G Name',
			'attrpID' => 'Attrp',
			'gDiscountPrice' => 'G Discount Price',
			'gIsDiscount' => 'G Is Discount',
			'mhID' => 'Mh',
			'gIsIntegral' => 'G Is Integral',
			'osIntegralNum' => 'Os Integral Num',
			'sId' => 'S',
			'actID' => 'Act',
			'gPicture' => 'G Picture',
			'gShopPrice' => 'G Shop Price',
			'orderNum' => 'Order Num',
			'oExpress' => 'O Express',
			'oExpressNum' => 'O Express Num',
			'oPay' => 'O Pay',
			'oStatus' => 'O Status',
			'oPayTime' => 'O Pay Time',
		);
    }

    
}



