<?php


require_once 'Payment.php';
require_once 'vendor/wxpay/WxPayPubHelper.php';

class WxPayConfig
{
    //=======【基本信息设置】=====================================
    //
    /**
     * TODO: 修改这里配置为您自己申请的商户信息
     * 微信公众号信息配置
     * 
     * APPID：绑定支付的APPID（必须配置，开户邮件中可查看）
     * 
     * MCHID：商户号（必须配置，开户邮件中可查看）
     * 
     * KEY：商户支付密钥，参考开户邮件设置（必须配置，登录商户平台自行设置）
     * 设置地址：https://pay.weixin.qq.com/index.php/account/api_cert
     * 
     * APPSECRET：公众帐号secert（仅JSAPI支付的时候需要配置， 登录公众平台，进入开发者中心可设置），
     * 获取地址：https://mp.weixin.qq.com/advanced/advanced?action=dev&t=advanced/dev&token=2005451881&lang=zh_CN
     * @var string
     */
    
    
    const APPID = 'wxe2c2a29213e78cf7';
    const MCHID = '1381423402';
    const KEY = 'fejwi352nnvdui9nmdfuio43we908rio';
    const APPSECRET = '8e92a08e7725da14d0749c9e9ba0910d';
    
    //=======【证书路径设置】=====================================
    /**
     * TODO：设置商户证书路径
     * 证书路径,注意应该填写绝对路径（仅退款、撤销订单时需要，可登录商户平台下载，
     * API证书下载地址：https://pay.weixin.qq.com/index.php/account/api_cert，下载之前需要安装商户操作证书）
     * @var path
     */
    const SSLCERT_PATH = '/cacert/apiclient_cert.pem';  //绝对路径以WxPayPubHelper.php文件为准
    const SSLKEY_PATH = '/cacert/apiclient_key.pem';    //绝对路径以WxPayPubHelper.php文件为准
 
} 

// 微信API文档： https://pay.weixin.qq.com/wiki/doc/api/index.html
class WxPay extends Payment  implements PaymentInterface
{    

    public function platform(){
        return 'wxpay';
    }

    public function __construct()
    {  
    }

    /**
     * 交易查询
     * @param  [type] $order_no [description]
     * @return [type]           [description]
     */
    public function trade_query($trade_no = null)
    {
        $jsApi = new OrderQuery_pub();

        $jsApi = $this->get_trade_no($jsApi);

        $rdata = $jsApi->getResult();

        $result = array();
        if(isset($rdata['trade_state'])){
            switch ($rdata['trade_state']) {
                case 'REFUND':
                case 'SUCCESS':
                    $result['result_status'] = true;
                    $result['trade_status'] = 'SUCCESS';
                    $result['status_msg'] = $this::SUCCESS;
                    $result['trade_no'] = $rdata['transaction_id'];
                    $result['total_amount'] = strval($rdata['total_fee']/100);
                    $result['pay_user'] = $rdata['openid'];
                    $result['pay_date'] = $this->date_format($rdata['time_end']);
                    unset($rdata['transaction_id']);
                    unset($rdata['openid']);
                    unset($rdata['time_end']);
                    break;
                case 'USERPAYING':
                case 'NOTPAY':
                    $result['result_status'] = false;
                    $result['trade_status'] = 'WAIT';
                    $result['status_msg'] = $this::WAIT;
                    break;  
                default:
                    $result['result_status'] = false; 
                    $result['trade_status'] = 'CLOSED';
                    $result['status_msg'] = $this::CLOSED;
                    break;
            }
        }else{
            $result['result_status'] = false; 
            $result['trade_status'] = 'NOTFOUND';
            $result['status_msg'] = $this::NOTFOUND;
        }
        if(isset($rdata['trade_state_desc'])){
            $result['status_sub_msg'] = $rdata['trade_state_desc'];
            unset($rdata['trade_state_desc']);
        }
        $result['request_data'] = $rdata;
        return $result;
    }
 
    public function trade_refund_query($out_request_no = null)
    {
        $jsApi = new RefundQuery_pub();

        $jsApi = $this->get_trade_no($jsApi);

        // $jsApi->setParameter("out_trade_no", $order_no); // 商户订单号
        if($out_request_no != null){
            $jsApi->setParameter("out_refund_no", $out_request_no); // 商户订单号
        }
        $rdata = $jsApi->getResult();

        return $this->format_refund_result($rdata);
    }
    /**
     * 退款
     * @param  [type]  $trade_no   [description]
     * @param  [type]  $amount     [description]
     * @param  [type]  $reason     [description]
     * @param  array   $etc        [description]
     * @param  boolean $refund_all [description]
     * @return [type]              [description]
     * 官网文档： https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=9_4
     */
    public function trade_refund($total_amount, $reason, $refund_amount = 0, $out_refund_no = null, $param = array())
    {
        $total_amount = $total_amount * 100;
        $refund_amount = $refund_amount * 100;
        $result = array();

        if($out_refund_no === null){    // 生成退款单号 
            // 查询退款信息来生成商户退款单号
            $refund_info = $this->trade_refund_query();
            $request_data = $refund_info['request_data'];
            
            if($request_data['return_code'] == 'SUCCESS'){
                $query_info = $this->trade_query();
                $order_no = $query_info['request_data']['out_trade_no'];

                if($request_data['result_code'] == 'SUCCESS'){

                    $out_refund_no_state = false;
                    $refund_count = $request_data['refund_count'];
                    
                    for ($i=1; $i <= 5 ; $i++) {    // 处理自增ID不规则情况， 最多查询5次有没有生成退款单号
                        $out_refund_no = $order_no.'-'.$this->make_refund_no($refund_count+$i);
                        $sub_refund_info = $this->trade_refund_query($out_refund_no);
                        $sub_data = $sub_refund_info['request_data'];
                        

                        if($sub_data['result_code'] == 'FAIL' && 
                            $sub_data['err_code'] == 'REFUNDNOTEXIST'){
                            $out_refund_no_state = true;
                            break;
                        }

                    }

                    if(!$out_refund_no_state){    
                        $result['result_status'] = false; 
                        $result['result_code'] = 'ERROR';
                        $result['status_msg'] = '生成退款单号失败。';
                        return $result;
                    }
                }else{
                    $refund_count = 0;
                    $out_refund_no = $order_no.'-'.$this->make_refund_no(1);
                }
            }else{            
                $result['result_status'] = false; 
                $result['result_code'] = 'ERROR';
                $result['status_msg'] = $request_data['return_msg'];
                return $result;
            }
        }

        if($refund_amount === 0){
            $refund_amount = $total_amount;
        }
        $jsApi = new Refund_pub();

        $user_info = $this->get_user_info();
        $refund_desc = $reason.'[No:'.$user_info['id'].']';
        $jsApi->setParameter("out_trade_no", $order_no); // 商户订单号
        $jsApi->setParameter("out_refund_no", $out_refund_no); // 商户订单号
        $jsApi->setParameter("total_fee", $total_amount); // 订单金额
        $jsApi->setParameter("refund_fee", $refund_amount); // 退款金额
        $jsApi->setParameter("refund_desc", $refund_desc); // 退款原因
        $rdata = $jsApi->getResult();
 


        $result = array();
        if($rdata['result_code'] == 'SUCCESS'){

            $this->insert_refund_log($rdata,array('refund_reason'=>$reason));

            $refund_detail = $this->trade_refund_query();
            $result['result_status'] = true;
            $result['result_code'] = 'REFUND_SUCCESS';
            $result['status_msg'] = $this::REFUND_SUCCESS;
            $result['trade_no'] = $rdata['transaction_id'];
            $result['total_amount'] = strval($rdata['total_fee']/100);
            $result['refund_amount'] = strval($rdata['refund_fee']/100);
            $result['refund_fee'] = strval($refund_detail['request_data']['refund_fee']/100);
            $result['refund_count'] = $refund_count+1; 
        }else{
            $result['result_status'] = false; 
            switch ($rdata['err_code']) {
                case 'NOTENOUGH':
                    $result['result_code'] = 'NOTENOUGH';
                    $result['status_msg'] = $this::NOTENOUGH;
                    break;
                case 'ORDERNOTEXIST':
                    $result['result_code'] = 'NOTFOUND';
                    $result['status_msg'] = $this::NOTFOUND;
                    break;  
                default:
                    $result['result_code'] = 'ERROR';
                    $result['status_msg'] = $this::ERROR;
                    break;
            }
        }
        if(isset($rdata['err_code_des'])){
            $result['status_sub_msg'] = $rdata['err_code_des'];
            unset($rdata['err_code_des']);
        }
        $result['request_data'] = $rdata;
        return $result;

    }

    public function get_trade_no($param = array())
    {
        if($this->order_no){
            $param->setParameter("out_trade_no", $this->order_no);
        }else{
            //order_no空的时候报错，优先级是transaction_id，所以可以这么用
            $param->setParameter("out_trade_no", '-');  
        }

        if($this->trade_no){
            $param->setParameter("transaction_id", $this->trade_no); 
        }

        if(!$this->order_no && !$this->trade_no){
            throw new Exception("订单支付时传入的商户订单号,和支付宝交易号不能同时为空。<br>设置方法请使用【Payment.php】文件的【set_trade_no()】方法。");
        }

        return $param;
    }

    private function format_refund_result($data)
    {
        $refund_result = array(
            'result_status' => false
            ,'result_code' => 'NO_REFUND' 
            ,'status_msg' => '没有退款交易' 
            ,'refund_count' => '0'
        );
        $sub_refund = array();

        if($data['return_code'] == 'SUCCESS'){
            if($data['result_code'] == 'SUCCESS'){
                $refund_result['result_status'] = true;
                $refund_result['result_code'] = 'SUCCESS';
                $refund_result['status_msg'] = '查询成功';
                $refund_result['refund_count'] = $data['refund_count'];

                $refund_result['refund_type'] 
                    = ($data['refund_fee'] == $data['total_fee'])?'ALL':'PARTIAL';
                $refund_result['total_amount'] = strval($data['total_fee']/100);
                $refund_result['is_sure'] = true;   //只有支付宝返回false的情况
                $refund_result['refund_amount'] = strval($data['refund_fee']/100);
                $refund_result['sub_refund_amount'] = strval($data['refund_fee']/100);  //只有支付宝会有refund_amount和sub_refund_amount不同的情况

                $processing_cnt = 0;
                $fail_cnt = 0;

                for ($i=0; $i < $data['refund_count']; $i++) {
                    
                    if($data['refund_status_'.$i] == 'PROCESSING'){
                        $processing_cnt ++;
                    }


                    if($data['refund_status_'.$i] == 'CHANGE' || $data['refund_status_'.$i] == 'REFUNDCLOSE'){
                        $fail_cnt ++;
                    }

                    $sub_refund[] = array(
                        'result_code' => $data['refund_status_'.$i]
                        ,'out_refund_no' => $data['out_refund_no_'.$i]
                        ,'refund_fee' => strval($data['refund_fee_'.$i]/100)
                    );
                }


                if(count($sub_refund) == $fail_cnt){
                    $refund_result['result_status'] = false;
                    $refund_result['result_code'] = 'REFUND_FAIL';
                    $refund_result['status_msg'] = '退款失败';
                }else if($processing_cnt>0){
                    $refund_result['result_code'] = 'PROCESSING';
                    $refund_result['status_msg'] = '退款处理中';
                }
            }

        }else{
            $refund_result['result_status'] = false;
            $refund_result['result_code'] = 'ERROR';
            $refund_result['status_msg'] = '发生错误';

        }

        if(count($sub_refund)){
            $refund_result['sub_refund'] = $sub_refund;
        }
        $refund_result['request_data'] = $data;

        return $refund_result;

    }

    private function date_format($date)
    {
        $reg = '/(19|20)(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})$/';
        if(preg_match($reg,$date)){

            $pattern = array($reg);
            $replace = array('\1\2-\3-\4 \5:\6:\7');
            // $data = $match['year'].$match['month'].$match['day'].$match['hour'].$match['min'].$match['sec'];
            $format_date = strtotime(preg_replace($pattern, $replace, $date)); 
            if($format_date){
                return date( "Y-m-d h:i:s", $format_date);
            }else{
                return false;
            }
        }else{
            return false;
        }
    } 


/***************************************************************************
 ************************   以下是按需求自定义业务逻辑部分   **********************
 **************************************************************************/

    private function insert_refund_log($request,$param = array()){

        if($request['result_code'] == 'SUCCESS'){
            $jsApi = new OrderQuery_pub();
            $jsApi->setParameter("out_trade_no", $request['out_trade_no']); // 商户订单号
            $trade_info = $jsApi->getResult();

            
            $plPayUser = (isset($trade_info['openid']))?$trade_info['openid']:'-';
            $trade_type = ($request['refund_fee'] == $request['total_fee'])?'全额退款':'部分退款';
            
            if(!isset($param['operator_id'])){
                $user_info = $this->get_user_info();
                $param['operator_id'] = $user_info['name'];
            }
            $request['refund_fee'] = strval($request['refund_fee']/100);

            // 记录退款日志
            $dataFillter = array('refund_reason','operator_id','out_refund_no','refund_fee');
            $etcData = $this->filter_merge(array(), $param, $dataFillter);
            $etcData = $this->filter_merge($etcData, $request, $dataFillter);
            $insertItem = array(
                'goID'           => $request['out_trade_no']
                ,'plPayUser'     => $plPayUser
                ,'plAddtime'     => date("Y-m-d H-i-s")
                ,'plTradeAmount' => -$request['refund_fee']
                ,'plTradeID'     => $request['transaction_id']
                ,'plPlatform'    => '微信'
                ,'plType'        => $trade_type
                ,'plTradeDatas'  => serialize($etcData)
            );
            $this->insert_log($insertItem);
        }
    }
}
