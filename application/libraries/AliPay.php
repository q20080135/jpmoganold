<?php


require_once 'Payment.php';
require_once 'vendor/alipay/aop/AopClient.php';
require_once 'vendor/alipay/aop/SignData.php';

// 支付API文档： https://docs.open.alipay.com/api_1
class AliPay extends Payment  implements PaymentInterface
{       

    private $aop;
    private $alipay_config; 

    public function platform(){
        return 'alipay';
    }

    private function get_config()
    {
        
        //支付宝帐户
        $config['seller_emaill'] = '493133999@qq.com';
        //合作身份者id，以2088开头的16位纯数字
        $config['partner'] = '2088221281296306';
        //安全检验码，以数字和字母组成的32位字符
        $config['key'] = '42rz37i41e8t0zdplhngof2866jcdv7v';

        //创建应用 https://doc.open.alipay.com/doc2/detail.htm?treeId=216&articleId=105193&docType=1#s3
        $config['app_id'] = '2016122004454914';

        //开发者私钥去头去尾去回车，一行字符串
        $config['rsaPrivateKey'] = "MIICeAIBADANBgkqhkiG9w0BAQEFAASCAmIwggJeAgEAAoGBANgpMkQEGr8NcuFWlYtozRAoR/h2n5MHMN9Ln2QlErF2mqeVI1+LFYtgF7y0kEaVdDg831X4gyOOEcObt0rrYFBFsG0+ZZQBjnDoAS92Qzuwfh8AHKEOQIms5g0NjfZ6+bTG4G4zzt0dDOEji8e5FUQtiP5AsUrPYW9qAUJqRR5NAgMBAAECgYEA16qKnzflI5ccdlz3yWbfqe42mFxqK7xx82e0+KrQcsTd2rO+3jWbYjqWlE0m4XV9xhpdzZ2r4Y5+hMZY4uPia34L2BCEbhnlaV2CpNW1pUG/aeeZZlSe3JP8ymiDdK0PEstoId/hNOdpm0Nu+YrZ5eiuEyJMbKZDorxQd3L984ECQQD73F+bqjyZ6UIj7VexiaBnnMMylNxZa2zNHZUBnya6N/TEXLEuXW5gJifnqOd2ba1RgOXBn0rW/eFN833sHPnhAkEA27agZcpgiaJz6mcj5695a8b/zvlN26OBza2P/ZCVuHcswFNJijehT7eqKxPayqVMxFRRC5w9e4CVAR3jHITp7QJAeXh3xCP+xlxxwdIekUnHSzGYEzUocRgWiXbS/s07aGTEcFAkRDBbo5PDez9DIyMSjFSWeyPQfJBFscrV2KLBAQJBAILrOHpO8+UvStjSqn9kfPpusoEW5oDI1hDDqfgSjlRDlwPm3PwiF9nTe+99PjLf+nVGNKCxcaVEwgTPVUPqIyUCQQDsz9Wd18p+0tOtI6/Ab9pXI55NKdBfg53n3uTeWJwhcP4Omw2nxwtiY8m51CrJNW2xh07wAPdufo5YQ+9xBEEe";
        
        // 支付宝公钥，一行字符串
        $config['alipayrsaPublicKey'] = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDDI6d306Q8fIfCOaTXyiUeJHkrIvYISRcc73s3vF1ZT7XN8RNPwJxo8pWaJMmvyTn9N4HQ632qJBVHf8sxHi/fEsraprwCtzvzQETrNRwVxLO5jVmRGi60j8Ue1efIlzPXV9je9mkjzOmdssymZkh2QhUrCmZYI/FCEa3/cNMW0QIDAQAB';

        return $config;
    }

    public function __construct()
    {
        $this->alipay_config = $this->get_config();
        $config =& $this->alipay_config;

        $this->aop = new AopClient();
        $this->aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
        $this->aop->appId = $config['app_id'];
        $this->aop->rsaPrivateKey =  $config['rsaPrivateKey'];
        $this->aop->alipayrsaPublicKey=  $config['alipayrsaPublicKey'];
        $this->aop->apiVersion = '1.0';
        $this->aop->signType = 'RSA';
        $this->aop->postCharset='UTF-8';
        $this->aop->format='json';
    }


    /**
     * 交易查询
     * @param  String $trade_no     [支付宝交易号]
     * @return [type]               
     * 官网文档： https://docs.open.alipay.com/api_1/alipay.trade.query/
     * 自定义参数：
     *     Float    tk_refund_total_amount    TK为前缀的退款总金额
     *     Float    real_refund_total_amount    实际退款总金额(可能不准确！！,必须要知道已经退款成功的退款标识才可以准确获取)
     *     String   next_out_request_no         退款标识（部分退款时用的）
     */
    public function trade_query()
    {
        $param = $this->get_trade_no();

        $rdata = $this->request('AlipayTradeQueryRequest', $param); 

        $result = array();
        if($rdata['code'] == '10000'){
            switch ($rdata['trade_status']) {
     

                case 'TRADE_SUCCESS':
                case 'TRADE_FINISHED':
                    $result['result_status'] = true;
                    $result['trade_status'] = 'SUCCESS';
                    $result['status_msg'] = $this::SUCCESS;
                    $result['trade_no'] = $rdata['trade_no'];
                    $result['total_amount'] = $rdata['total_amount'];
                    $result['pay_user'] = $rdata['buyer_user_id'];
                    $result['pay_user_name'] = $rdata['buyer_logon_id'];
                    $result['pay_date'] = $rdata['send_pay_date'];
                    unset($rdata['trade_no']);
                    unset($rdata['buyer_user_id']);
                    unset($rdata['buyer_logon_id']);
                    unset($rdata['send_pay_date']);
                    break;
                case 'WAIT_BUYER_PAY': 
                    $result['result_status'] = false;
                    $result['trade_status'] = 'WAIT';
                    $result['status_msg'] = $this::WAIT;
                    break;  
                default:
                    $result['result_status'] = false; 
                    $result['trade_status'] = 'CLOSED';
                    $result['status_msg'] = $this::CLOSED;
                    if(isset($rdata['trade_status_msg'])){
                        $result['status_sub_msg'] = $rdata['trade_status_msg'];
                    }
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
        // return array_merge($trade_query, $refund_info);
     
    }

    /**
     * 退款查询
     * @param  String $trade_no     [支付宝交易号]
     * @return [type]               
     * 官网文档： https://docs.open.alipay.com/api_1/alipay.trade.fastpay.refund.query/
     */
    public function trade_refund_info($out_request_no)
    {

        $param = $this->get_trade_no();
        $param['out_request_no'] = $out_request_no;

        return $this->request('AlipayTradeFastpayRefundQueryRequest',$param);
    }

    /**
     * 退款接口
     * https://docs.open.alipay.com/api_1/alipay.trade.refund/
     * @param  String $trade_no     [支付宝交易号]
     * @param  Number $amount   退款金额
     * @param  String $reason   退款原因
     * @param  array  $param      其他可选参数，参照官网文档
     * @param  boolean $refund_all 防止部分退款，设置false可以部分退款
     * @return [type]           [description]
     */
    // public function trade_refund($trade_no, $amount, $reason, $param = array(), $refund_all = true)
    public function trade_refund($total_amount, $reason, $refund_amount = 0, $out_refund_no = null, $param = array())
    {
        // ※由于查询接口不提供部分退款时的总退款金额，目前的API只提供查询一条退款记录。
        // 为了获取退款总金额，退款标识【$out_request_no】采用自增模式，不接受【out_request_no】参数


        $trade_info = $this->trade_query(); 
        if($refund_amount === 0){
            $refund_amount = $total_amount;
        }

        $request_data = $this->get_trade_no();
        $request_data['refund_amount'] = $refund_amount;
        $request_data['refund_reason'] = $reason;

        $user_info = $this->get_user_info();
        $request_data['operator_id'] = $user_info['name'];
        
        if($trade_info['result_status']){
            if($trade_info['total_amount'] != $total_amount){
                return array(
                    'result_status'=> false
                    ,'trade_status'=> 'ERROR'
                    ,'status_msg'=> '请求总金额与订单总金额不符'
                    ,'request_data'=> $trade_info['request_data']
                );
            }
            // 查询订单金额是否全额退款
            if($refund_amount == 0){
                // 全额退款
                $trade_type = '全额退款';
                $request_data['refund_amount'] = $total_amount;
            }else{
                // 部分退款
                $trade_type = '部分退款';
                if($out_refund_no !== null){
                    $request_data['out_request_no'] = $out_refund_no;  
                }else{
                    $refund_info = $this->trade_refund_query();
                    $next_out_request_no = $this->make_refund_no($refund_info['refund_count']+1);
                    $request_data['out_request_no'] = $next_out_request_no;   
                }
            }

            // 过滤可选请求参数
            $filter_keys = array('operator_id','store_id','terminal_id');
            
            $request_data = $this->filter_merge($request_data,$param,$filter_keys);
            
            $refund_result = $this->request('AlipayTradeRefundRequest',$request_data);
            $refund_result['trade_type'] = $trade_type;

            if($refund_result['status']){
                $this->insert_refund_log($refund_result, $request_data);
                $result = array(
                    'result_status'=> true
                    ,'trade_status'=> 'REFUND_SUCCESS'
                    ,'status_msg'=> '退款成功'
                    ,'trade_no'=> $refund_result['trade_no']
                    ,'total_amount'=> $trade_info['total_amount']
                    ,'refund_amount'=> $refund_result['refund_fee']
                    ,'refund_fee'=> $refund_amount
                );
                if($refund_result['fund_change'] == 'N'){
                    $result['result_status'] = false;
                    $result['trade_status'] = 'REFUND_FAIL';
                    $result['status_msg'] = '该退款请求已退款过';
                }
            }else{

                if($refund_result['sub_code'] == 'ACQ.SELLER_BALANCE_NOT_ENOUGH'){

                    $result = array(
                        'result_status'=> false
                        ,'trade_status'=> 'NOTENOUGH'
                        ,'status_msg'=> '余额不足'
                    );
                }else{
                    $result = array(
                        'result_status'=> false
                        ,'trade_status'=> 'REFUND_FAIL'
                        ,'status_msg'=> '退款失败'
                    );
                }
                
                if(isset($refund_result['sub_msg'])){
                    $result['status_sub_msg'] = $refund_result['sub_msg'];
                    unset($refund_result['sub_msg']);
                }

            }
            $result['request_data'] = $refund_result;

            return $result;
        }else{
            switch ($trade_info['trade_status']) {
                case 'NOTFOUND':
                    break;
                
                default:
                    $trade_info['trade_status'] = 'REFUND_FAIL';
                    $trade_info['status_msg'] = '退款失败';

                    if(isset($trade_info['request_data']['trade_status_msg'])){
                        $trade_info['status_sub_msg'] = $trade_info['request_data']['trade_status_msg'];
                        unset($trade_info['request_data']['trade_status_msg']);
                    }
                    break;
            }
            return $trade_info;
        }

        
    }

    /**
     * 查询对账单下载地址
     * https://docs.open.alipay.com/api_15/alipay.data.dataservice.bill.downloadurl.query
     * @param  [type] $bill_date 账单时间：日账单格式为yyyy-MM-dd，月账单格式为yyyy-MM。
     * @param  string $bill_type 账单类型
     *                             trade： 商户基于支付宝交易收单的业务账单；
     *                             signcustomer： 基于商户支付宝余额收入及支出等资金变动的帐务账单；
     * @return  String            账单下载地址链接，获取连接后30秒后未下载，链接地址失效。
     */
    public function data_dataservice_bill_downloadurl_query($bill_date, $bill_type = 'trade')
    {
        if($bill_type != 'trade' && $bill_type != 'signcustomer'){
            return false;
        }

        $param = array(
            'bill_type' => $bill_type
            ,'bill_date' => $bill_date
        );

        return $this->request('AlipayDataDataserviceBillDownloadurlQueryRequest',$param);
    }

    // 查询退款信息的时候前缀不是TK开始的、自增ID不是从1开始连续的，信息都会有遗漏
    public function trade_refund_query($out_request_no = null){
        
        require_once 'vendor/alipay/myclass/refund_query_helper.php';
        $helper = new RefundQueryHelper($this->get_trade_no()); 

        if($out_request_no === null){

            // 查询退款最多次数
            $max_count = 10;

            for ($i = 1; $i <= $max_count; $i++){
                //这个前缀要保持不变，要不然查询不了更改前的退款记录
                $out_request_no = $this->make_refund_no($i);

                $result = $helper->get_refund_info($out_request_no);

                if(in_array($result['result_code'], array(
                    'NO_REFUND','NOTFOUND','ERROR'
                ))){
                    break;
                }
            } 

            if($helper->refund_result['result_code'] == 'NO_REFUND'){
                $helper->refund_result['status_msg'] = '没有退款交易，退款标识不以\''.Payment::REFUND_PREFIX.'001\'自增模式退款的只能手动对账';
            }

            // 确保信息正确
            if($helper->real_refund_total_amount !== 0
                && intval($helper->real_refund_total_amount*100) != intval($helper->tk_refund_total_amount*100)){
                $helper->refund_result['result_code'] = 'ERROR';
                $helper->refund_result['result_status'] = false;
                $helper->refund_result['status_msg'] = '有遗漏退款信息，请手动核对账单';
            }
            return $helper->refund_result;

        }else{
            return $helper->get_refund_info($out_request_no);
        }        
    }


    protected function request($service_name,$param)
    {
        require_once 'vendor/alipay/aop/request/'.$service_name.'.php';
        
        $request = new $service_name();
        $request->setBizContent(json_encode($param));
        $result = $this->aop->execute($request); 
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        
        return $this->trans_msg($result->$responseNode);   
    }

    public function get_trade_no($param = array())
    {
        if($this->order_no){
            $param['out_trade_no'] = $this->order_no;
        }

        if($this->trade_no){
            $param['trade_no'] = $this->trade_no;
        }

        if(!$this->order_no && !$this->trade_no){
            throw new Exception("订单支付时传入的商户订单号,和支付宝交易号不能同时为空。<br>设置方法请使用【Payment.php】文件的【set_trade_no()】方法。");
        }
        return $param;
    }

    /**
     * 返回数据加工处理，比官网的多了 status， trade_status_msg 属性
     * @param  [object] $responseNode 回调数据
     * @return Array               
     * 官网文档： https://doc.open.alipay.com/docs/doc.htm?spm=a219a.7395905.0.0.9At1AD&treeId=262&articleId=105806&docType=1
     */
    private function trans_msg($responseNode)
    {
        $responseNode = json_decode(json_encode($responseNode),true);

        $msg_code = array(
            '10000' => '操作成功'
            ,'20000' => '服务不可用, 稍后重试'
            ,'20001' => '授权权限不足'
            ,'40001' => '缺少必选参数'
            ,'40002' => '非法的参数'
            ,'40004' => '业务处理失败'
            ,'40006' => '权限不足'
        );

        $trade_status = array(
            'WAIT_BUYER_PAY' => '等待买家付款'
            ,'TRADE_CLOSED' => '交易超时关闭或已全额退款'
            ,'TRADE_SUCCESS' => '支付成功'
            ,'TRADE_FINISHED' => '交易结束，不可退款'
        );

        $sub_code = array(
            'ACQ.SYSTEM_ERROR' => '系统错误'
            ,'ACQ.INVALID_PARAMETER' => '参数无效'
            ,'ACQ.SELLER_BALANCE_NOT_ENOUGH' => '卖家余额不足'
            ,'ACQ.REFUND_AMT_NOT_EQUAL_TOTAL'    => '退款金额超限'
            ,'ACQ.REASON_TRADE_BEEN_FREEZEN' => '请求退款的交易被冻结'
            ,'ACQ.TRADE_NOT_EXIST'   => '交易不存在'
            ,'ACQ.TRADE_HAS_FINISHED'    => '交易已完结'
            ,'ACQ.TRADE_STATUS_ERROR'    => '交易状态非法'
            ,'ACQ.DISCORDANT_REPEAT_REQUEST' => '不一致的请求'
            ,'ACQ.REASON_TRADE_REFUND_FEE_ERR'   => '退款金额无效'
            ,'ACQ.TRADE_NOT_ALLOW_REFUND'    => '当前交易不允许退款'

        );

        // $statusCode = $responseNode->trade_status;
        if(isset($responseNode['trade_status']) && isset($trade_status[$responseNode['trade_status']])){
            $responseNode['trade_status_msg'] = $trade_status[$responseNode['trade_status']];
        }
        if(isset($responseNode['sub_code']) && isset($sub_code[$responseNode['sub_code']])){
            $responseNode['sub_msg'] = $sub_code[$responseNode['sub_code']];
        }

        $resultCode = $responseNode['code'];
        if(!empty($resultCode) && isset($msg_code[$resultCode])){
            if($resultCode == 10000){
                $responseNode['status'] = true;
            }else{
                $responseNode['status'] = false;
            }
            $responseNode['msg'] = $msg_code[$resultCode];
            return $responseNode;
        } else {
            return array('status' => false);
        }
    }
 

/***************************************************************************
 ************************   以下是按需求自定义业务逻辑部分   **********************
 **************************************************************************/


    private function insert_refund_log($request,$param = array()){
        if(isset($request['fund_change']) && $request['fund_change'] === 'Y'){
            // 记录退款日志
            $dataFillter = array('refund_reason','operator_id','out_request_no','refund_fee');
            $etcData = $this->filter_merge(array(), $param, $dataFillter);
            $etcData = $this->filter_merge($etcData, $request, $dataFillter);
            $insertItem = array(
                'goID'           => $request['out_trade_no']
                ,'plPayUser'     => $request['buyer_logon_id']
                ,'plAddtime'     => date("Y-m-d H-i-s")
                ,'plTradeAmount' => -$param['refund_amount']
                ,'plTradeID'     => $request['trade_no']
                ,'plPlatform'    => '支付宝'
                ,'plType'        => $request['trade_type']
                ,'plTradeDatas'  => serialize($etcData)
            );
            $this->insert_log($insertItem);
        }
    }
}
