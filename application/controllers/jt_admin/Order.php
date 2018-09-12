<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends ADMIN_Controller
{

    private $wxconfig = array("appId" => 'wxe2c2a29213e78cf7',
                "appSecret" => '8e92a08e7725da14d0749c9e9ba0910d',
                "partnerId" => '1381423402',
                "partnerKey" => 'fejwi352nnvdui9nmdfuio43we908rio');
    public function __construct()
    {
        parent::__construct();
        $this->filters = json_decode('{
            "soID" : {"name" : "订单ID","db":"so.soID"},
            "orderNum" : {"name" : "订单号","db":"so.orderNum"}
            ,"oBuyName" : {
                "name" : "收货人"
                ,"db" : "go.oBuyName"}
            ,"oBuyPhone" : {
                "name" : "收货人电话（尾号）"
                ,"db" : "go.oBuyPhone"}
            ,"sId":{"name":"店铺ID","db":"p.sId"}
            ,"sShopName":{"name":"店铺名称","db":"p.sShopName"}            
        }', true);
    }

    
    public function index()
    {
        $this->orderList();
    }
    /**
     * 订单列表
     * @return [view] [订单列表页面]
     */
    public function orderList()
    {
        $data['filters'] = $this->filters;
        $this->config->load('jt_static');
        $data['order_state'] = $this->config->item('order_state');
        $data['opay_state'] = $this->config->item('opay_state');

        $data['grade'] = $this->model('jt_admin/grade')->get_select();
        $this->load->view('jt_admin/order/orderList', $data);
    }

    public function listData()
    {
        $this->load->library('AdminList');
        $list = new AdminList();
        
        $list->setFilter('oStatus','so.oStatus');
        $list->setFilter('oPay','so.oPay');
        $list->setFilter('aodSoID', 'od.aodSoID');
        $list->setFilter('sLevel', 'p.sLevel');
        $list->setFilter('oType', 'so.oType');
        $list->setFilter('ptStatus', 'so.ptStatus');
        if(isset($list->filter['so.ptStatus'])){
            $list->filter['so.oType'] = 1;
        }
        $list->setFilters($this->filters);
        $data = $this->model('jt_admin/shop_order')->getListData($list->filter,'go.orderNum desc',form('length'),form('start'));
        echo json_encode($data);
        exit;
    }

    public function refundPtOrder()
    {
        $order_id = $this->input->post('order_no');

        if(intval($order_id)>0){
            $order_info = $this->model('jt_admin/shop_order')->getDetail($order_id);

            // 判断是否拼团失败订单
            if(isset($order_info['oType']) && $order_info['oType'] ==1){
                if($order_info['ptStatus'] == 2){

                    // 按订单号加载对应的支付接口
                    $this->load->helper('payment');
                    $payment = load_payment_by_order_no($order_id);

                    if($payment){
                        $trade_info = $payment->trade_query();

                        if($trade_info['result_status']){

                            // 实际退款处理
                            $total_amount = $trade_info['total_amount'];
                            $reason = '拼团失败退款';
                            $refund_result = $payment->trade_refund($total_amount, $reason);
                            
                            if($refund_result['result_status']){

                                // 退款后业务逻辑处理
                                $updata = array(
                                    'soID'=>$order_id,
                                    'oPay'=>2,
                                    'oStatus'=>8
                                );
                                $db_result = $this->model('jt_admin/shop_order')->update($updata);
                                if ($db_result) {    // 更改订单信息
                                    $json_result['status'] = true;
                                    echo json_encode($json_result);
                                    exit;
                                } else {
                                    $json_result['status'] = false;
                                    $json_result['msg'] = '退款成功，但修改状态失败';
                                }

                            }else{
                                $json_result['status'] = false;
                                $json_result['msg'] = $refund_result['status_msg'];
                                // $json_result['data'] = $refund_result['request_data'];
                            }
                        }else{
                            $json_result['status'] = false;
                            $json_result['msg'] = $trade_info['status_msg'];
                            // $json_result['data'] = $result['request_data'];
                        }

                        // $result = $payment->trade_refund_query();
                    }
                }else{
                    $json_result['status'] = false;
                    $json_result['msg'] = '只能处理拼团失败订单！';
                }
            }else{
                $json_result['status'] = false;
                $json_result['msg'] = '不是拼团订单';
            }
        }else{
            $json_result['status'] = false;
            $json_result['msg'] = '订单号有误';
        }

        echo json_encode($json_result);
        exit;
    }

    public function detail($id)
    { 

        if($id > 0)
        {
            $order_info = $this->model('jt_admin/shop_order')->getDetail($id);
            if($order_info['payStatus']=='SUCCESS'){
                $order_info['payStatus'] ='微信';
            }elseif($order_info['payStatus']=='TRADE_SUCCESS'){
                $order_info['payStatus'] ='支付宝';
            }else{
                $order_info['payStatus'] ='';
            }
            $order_info['payMoney'] = $order_info['payMoney']==''?'0':$order_info['payMoney'];
            if(!empty($order_info))
            {
                //解析物流记录信息
                if(!empty($order_info['oExpressTraces']))
                {
                    $order_info['oExpressTraces'] = json_decode($order_info['oExpressTraces'], true);
                }
                else
                {
                    $order_info['oExpressTraces'] = '';
                }
                $data = $order_info;
                $data['PinTuanStatus'] = array(
                    0 => '拼团中'
                    ,1 => '拼团成功,待确认'
                    ,2 => '拼团失败'
                );
                $data['payinfo'] = $this->get_order_info($order_info['payNum'],$order_info['payStatus']);
                $this->config->load('jt_static');

                $data['order_state'] = $this->config->item('order_state');
                $data['opay_state'] = $this->config->item('opay_state');
                $this->load->view('jt_admin/order/orderDetail',$data);
            }
        }
       
    }
    public function getProduct(){
        $id = $_POST['id'];
        $shopwhere = array("orderNum"=>$id);
        $shopjoin = array(
            'spe_shops s'=>'sId = s.sId',
        );
        $rs = $this->model('jt_admin/order_suborder')->get_list('s.sShopName,gName,gPicture,gNum,gPrice',$shopwhere,$shopjoin);
        
        $data['data'] = $rs;
        $this->load->view('widget/order/product',$data);
    }
    public function addProc()
    {


    }


    /**
    *修改入驻商订单
    */
    public function uBusOrder($id,$soid){
            //这里没加权限回头记得加
            $sql = "SELECT * FROM `spe_shops` AS ss LEFT JOIN `spe_shop_grade` AS ssg ON ssg.sgID = ss.sLevel WHERE ss.sId = '{$id}'";
            $que = $this->db->query($sql);
            $_SESSION['bus_info'] = $que->row_array();
            //echo '<script>window.location.href="/busAdmin/Product/fadd";</script>';
            echo '<script>window.location.href="/busAdmin/order/order_info/'.$soid.'?who=superMan";</script>';
    }




    /**
     * 微信查询
     */
    private function get_order_info($payNum,$type) {
        if($type=='微信'){
            error_reporting(E_ALL ^ E_NOTICE); 
            $return_url = "http://api.ub33.cn/api/PayTest/wx_respond";
            define(APPID, $this->wxconfig ['appId']); // appid
            define(APPSECRET, $this->wxconfig ['appSecret']); // appSecret
            define(MCHID, $this->wxconfig ['partnerId']);
            define(KEY, $this->wxconfig ['partnerKey']); // 通加密串
            require_once(APPPATH . "third_party/weixin/WxPayPubHelper.php");
            $jsApi = new OrderQuery_pub();
            $jsApi->setParameter("transaction_id", $payNum); // 商户订单号
            $rdata = $jsApi->getResult();
            return $rdata;

        }elseif($type=='支付宝'){
            require_once(APPPATH . "third_party/alipay-sdk-PHP/aop/AopClient.php");
            require_once(APPPATH . "third_party/alipay-sdk-PHP/aop/request/AlipayTradeAppPayRequest.php");
            $parameter = array(
                'service' => 'single_trade_query',
                'partner' => '2088221281296306',
                '_input_charset' => strtolower('utf-8'),
                //'out_trade_no' => '21', 
                'trade_no' => $payNum, 
                
            );
            ksort($parameter);
            reset($parameter);

            $param = '';
            $sign = '';

            foreach ($parameter AS $key => $val) {
                $param .= "$key=" . urlencode($val) . "&";
                $sign .= "$key=$val&";
            }

            $param = substr($param, 0, -1);
            $sign = substr($sign, 0, -1) . '42rz37i41e8t0zdplhngof2866jcdv7v';
            $url = 'https://mapi.alipay.com/gateway.do?' . $param . '&sign=' . md5($sign) . '&sign_type=MD5';

            $ary = $this->xmlToArray(file_get_contents($url));
            if($ary['is_success']=='T'){
                $ary['response']['trade']['total_fee'] = $ary['response']['trade']['total_fee']*100;
                $ary['response']['trade']['time_end'] = $ary['response']['trade']['gmt_payment'];
                $ary['response']['trade']['transaction_id'] = $ary['response']['trade']['trade_no'];
                return $ary['response']['trade'];
            }else{
                return null;
            }
            
        }
        else{
            return null;
        }
        
        /*$data =  $jsApi->getAppParameters();
        var_dump($data);*/
    }

    private function xmlToArray($xml) {
        libxml_disable_entity_loader(true);
        $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $values;
    }


    /**
     * 更改代发货状态
     * @return [json] [返回json状态]
     */
    public function updateState()
    {
        
        $id = form('id');
        $val = form('val');
        $result = $this->model('jt_admin/admin_order_delivery')->updateDeliveryState($id,$val);

        if ($result) {    // 更改订单信息
            $json_result['status'] = true;
        } else {
            $json_result['status'] = false;
            $json_result['msg'] = '操作数据库时出错';
        }
        exit(json_encode($json_result));
    }


    /**
     * 更改订单状态
     * @return [json] [返回json状态]
     */
    public function update_save()
    {
        
        $id = form('soID');
        $oStatus = form('oStatus');
        $updata = array('soID'=>$id,'oStatus'=>$oStatus);
        $result = $this->model('jt_admin/shop_order')->update($updata);
        if ($result) {    // 更改订单信息
            $json_result['status'] = true;
            $json_result['msg'] = '保存成功';
        } else {
            $json_result['status'] = false;
            $json_result['msg'] = '操作数据库时出错';
        }
        exit(json_encode($json_result));
    }



    /**
     * 佣金结算
     * @return [json] [返回json状态]
     */
    public function commission_settlement()
    {
        $id = form('soID');
        $soJiesuanPrice = form('csPrcie');
        if(!is_numeric($soJiesuanPrice)){
            $json_result['status'] = false;
            $json_result['msg'] = '结算金额不合法。';
            exit(json_encode($json_result));
        }
        $this->load->library('AdminCrud');
        $u = new AdminCrud();
        $u->isnullSetLogTitle('订单佣金结算。');
        // 表单验证规则在 config/form_validation.php 文件
        if ($u->validationAndWriteLog($id)) {
            $updata = array('soID'=>$id,'soJiesuanPrice'=>$soJiesuanPrice,'soIsJiesuan'=>1);
            $result = $this->model('jt_admin/shop_order')->update($updata);
            if ($result) {
                $json_result['status'] = true;
                $json_result['msg'] = '订单佣金结算成功。';
            } else {
                $json_result['msg'] = '操作数据库时出错';
            }

        }else{
            $json_result['status'] = false;
            $json_result['msg'] = '验证不通过。';
        }

        exit(json_encode($json_result));
    }
}
