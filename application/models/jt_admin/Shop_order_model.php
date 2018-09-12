<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * 入驻商订单模型
 * @author 齐福
 * 创建时间 ： 2017年3月6日下午5:49:55
 */
class Shop_order_model extends MY_Model
{
    public function __construct()
    {
        $this->table = 'spe_shop_orders';

        parent::__construct();
    }

    public function getListData($where, $order = '', $limit = 10, $offset = 0)
    {

        $wherestr = '';
        foreach ($where as $key => $value) {


            
            if($key == 'go.oBuyPhone'){
                $wherestr .= ' and '.$key.' like \'%'.$value.'\'';
            }else if($key == 'so.orderNum'){
                $wherestr .= ' and '.$key.' like \'%'.$value.'%\'';
            }else if($key == 'p.sShopName'){
                $wherestr .= ' and '.$key.' like \'%'.$value.'%\'';
            }else if($key == 'go.oBuyName'){
                $wherestr .= ' and '.$key.' like \'%'.$value.'%\'';
            }else if($key == 'od.aodSoID'){
                if($value=='`not null`'){
                    $wherestr .= ' and '.$key.' is not null';
                }else{
                    $wherestr .= ' and '.$key.' is null';
                }
                
            }else{
                $wherestr .= ' and '.$key.' = '.$value;
            }
            
        }




        $sql = "SELECT so.*, go.*, m.mNickName,m.mPhone, p.sShopName, p.sName, od.aodSoID, p.sLevel, sg.sgName 
                FROM spe_shop_orders so
                LEFT JOIN spe_goods_order go ON so.orderNum = go.orderNum  and so.mid = go.mid
                LEFT JOIN spe_members m ON go.mId = m.mId 
                LEFT JOIN spe_shops p ON so.sId = p.sId 
                LEFT JOIN spe_admin_order_delivery od ON soID = od.aodSoID 
                LEFT JOIN spe_shop_grade sg ON p.sLevel = sg.sgID 
                WHERE 1=1 ".$wherestr."
                order by {$order} LIMIT {$offset},{$limit}";
        $que = $this->db->query($sql);
        $goods  = $que->result_array();
        $this->config->load('jt_static');
        $order_state = $this->config->item('order_state');
        $opay_state = $this->config->item('opay_state');
        foreach ($goods as $k=>$v){
            $goods[$k]['oStatus'] = $order_state[$v['oStatus']];
            $goods[$k]['oStatusVal'] = $v['oStatus'];
            $oPayClass = ($v['oPay'] == 1)?'c-green':'c-error';
            $goods[$k]['oPay'] = '<span class="'.$oPayClass.'">'.$opay_state[$v['oPay']].'</span>';
            $goods[$k]['aodSoID'] = ($v['aodSoID'] == null)?'`null`':'`not null`';
        }


        $sql = "SELECT count(so.soID) as con
                FROM spe_shop_orders so
                LEFT JOIN spe_goods_order go ON so.orderNum = go.orderNum 
                LEFT JOIN spe_members m ON go.mId = m.mId 
                LEFT JOIN spe_shops p ON so.sId = p.sId 
                LEFT JOIN spe_admin_order_delivery od ON soID = od.aodSoID 
                LEFT JOIN spe_shop_grade sg ON p.sLevel = sg.sgID 
                WHERE so.ptHead=so.oType  
                order by {$order}";
        
        $que = $this->db->query($sql);
        $rowc  = $que->row_array();

        $sql = "SELECT count(so.soID) as con
                FROM spe_shop_orders so
                LEFT JOIN spe_goods_order go ON so.orderNum = go.orderNum 
                LEFT JOIN spe_members m ON go.mId = m.mId 
                LEFT JOIN spe_shops p ON so.sId = p.sId 
                LEFT JOIN spe_admin_order_delivery od ON soID = od.aodSoID 
                LEFT JOIN spe_shop_grade sg ON p.sLevel = sg.sgID 
                WHERE so.ptHead=so.oType  ".$wherestr."
                order by {$order}";


        $que = $this->db->query($sql);
        $recordsFiltered  = $que->row_array();

        $data['data'] = $goods;
        $data['recordsFiltered'] = $recordsFiltered['con'];
        $data['recordsTotal'] = $rowc['con'];
        /*$sql = "SELECT `scID`, `name`, `parentID` FROM `{$this->table}` WHERE `sID` = " . $this->busid . " ORDER BY `scID` ASC";
        $que = $this->db->query($sql);
        
        $ret = $que->result_array();*/
    
        return $data;
    }

    public function getDetail($id)
    {

    
        if ($id) {
            $fild = 'spe_shop_orders.*,spe_shop_orders.oIntegral as jifen,go.*,pl.payMoney,pl.payStatus,pl.payNum';
            $where = array('soID' => $id);
            
            $join = array(
                'spe_goods_order go' => 'orderNum = go.orderNum and go.mId = spe_shop_orders.mId',
                'spe_member_pay_list pl' => 'pl.orderNum =spe_shop_orders.soID'
            );
            $order = $this->get_row($fild, $where, $join);
            if(!empty($order) && !empty($order['orderNum']))
            {
                //获取订单商品信息
                $where = array(
                    'sId'=>$order['sId'],
                    'orderNum'=>$order['orderNum'],
                    'mId'=>$order['mId'],
                    );
                $sql2 =
                $this->db->select('gID, gName, mcAttr, gNum, gPrice, gDiscountPrice, gPicture')
                ->where($where)
                ->get_compiled_select('spe_orders_suborder');
                $order['product'] = $this->db->query($sql2)->result_array();
            
                //获取订单操作记录
                $sql3 =
                $this->db->select(' * ')
                ->where('soID', $order['soID'])
                ->order_by('logTime', 'DESC')
                ->get_compiled_select('spe_shop_orders_log');
            
                $order['log'] = $this->db->query($sql3)->result_array();
                $order['orderp'] = $this->getzprice($order['orderNum']);
                //获取订单优惠券
                if(!empty($order['oScouponID']))
                {
                    $sql4 = "SELECT * FROM `spe_coupon` WHERE `hID` = '{$order['oScouponID']}'";
                    $order['coupon'] = $this->db->query($sql4)->row_array();
                }
                //是否是拼团订单 如果是拼团订单 则查询出 团内的所有订单号和id
                if($order['oType']==1){
                    $this->db->select('so.orderNum,so.ptHead,so.soID,so.mId,go.oBuyName,m.mPicture,m.mPhone');
                    $this->db->where('so.orderNum',$order['orderNum']);
                    $this->db->where('so.oPay',1);
                    $this->db->join('spe_members m','m.mId = so.mId');
                    $this->db->join('spe_goods_order go','go.mId = so.mId and go.orderNum = so.orderNum');
                    $gparr = $this->db->get($this->table.' so')->result_array();
                    $order['gparr'] = $gparr;
                }
            }

            return $order;
        } else {
            return null;
        }
        
        
        
   
    }
    private function getzprice($orderNum){
        $sql = "SELECT SUM(soPrice) AS zp,IFNULL(SUM(oExpressMoney),0) AS em,IFNULL(SUM(spe_coupon.hMoney),0) as coupon,IFNULL(SUM(oIntegral) / 100,0) as jifen,
    SUM(soPrice) + IFNULL(SUM(oExpressMoney),0) - IFNULL(SUM(oIntegral) / 100,0)-IFNULL(SUM(spe_coupon.hMoney),0) AS zps FROM spe_shop_orders LEFT JOIN spe_coupon ON spe_coupon.hID = spe_shop_orders.oScouponID WHERE orderNum = '{$orderNum}'";
        $orderp = $this->db->query($sql)->row_array();
        $orderp['jifen'] = number_format($orderp['jifen'], 2, '.','');
        $orderp['zps'] = number_format($orderp['zps'], 2, '.','');
        return $orderp;
    }
}
