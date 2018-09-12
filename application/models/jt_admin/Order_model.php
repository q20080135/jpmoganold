<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * 订单模型类
 * @author 齐福
 * 创建时间 ： 2016年12月22日上午10:08:58
 */
class Order_model extends MY_Model
{
    public function __construct()
    {
        $this->table = 'spe_goods_order';

        parent::__construct();
    }
    /**
     * 返回字段文字
     * return array customized attribute labels (name=>label)
     */
    public function attribute_labels()
    {
        return array(
            'orderNum' => 'Order Num',
            'gID' => 'G',
            'gPrice' => 'G Price',
            'oNum' => 'O Num',
            'oAddtime' => 'O Addtime',
            'mId' => 'M',
            'saID' => 'Sa',
            'oID' => 'O',
        );
    }


    public function getListData($where, $order = '', $limit = 10, $offset = 0, $join = array())
    {
        $filds = "spe_goods_order.*, m.mNickName";
        $filds .= ', ma.saName, ma.saDistinct, ma.saCity, ma.saAddress, ma.saPhone,s.sId,p.sShopName';

        $join = array(
            'inner spe_member_address ma' => 'saID = ma.saID'
            ,'spe_members m' => 'mId = m.mId'
            ,'spe_shop_orders s' => 'orderNum = s.orderNum'
            ,'spe_shops p' => ' = p.sId = s.sId'
        );

        $goods = $this->get_list($filds, $where, $join, $order, $limit, $offset);
       
        $this->config->load('jt_static');
        $order_state = $this->config->item('order_state');
        foreach ($goods as $k=>$v){
            $shopwhere = array("orderNum"=>$v['orderNum']);
            $shopjoin = array(
                'spe_shops s'=>'sId = s.sId',
            ); 
            $data = $this->model('jt_admin/shop_order')->get_list('s.sShopName,oStatus,s.sId',$shopwhere,$shopjoin);
            foreach ($data as $key =>$val){
                $data[$key]['oStatus'] = $order_state[$val['oStatus']];
            }
            $goods[$k]['shopNames'] = $data;
        }
         
        
        return $goods;
    }
    
    

    public function getDetailData($id)
    {
        $fild = '*';
        $where = array('id' => $id);
    
        $join = array(
            // 'product p' => 'sp_id = p.id'
            // , 'user u' => 'tjr = u.user',
        );
    
        if ($id) {
            
            $detail = $this->get_row($fild, $where, $join);

            return $detail;
        } else {
            return null;
        }
    }

}
