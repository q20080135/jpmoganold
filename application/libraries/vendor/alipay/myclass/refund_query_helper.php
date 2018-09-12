<?php
/**
 * 支付宝退款查询辅助类
 */
class RefundQueryHelper extends AliPay
{

	public $tk_refund_total_amount;
	public $real_refund_total_amount;
	public $refund_result;
	public $error_reuslt;
    public $sub_refund;
    public $out_trade_exist;
    private $is_sure;

    public function __construct($param)
    {
        parent::__construct();
	 	$this->tk_refund_total_amount= 0;
        $this->real_refund_total_amount = 0; 
        $this->out_trade_exist = false; 
        $this->is_sure = false; 

        $trade_no = (isset($param['trade_no']))?$param['trade_no']:null;
        $order_no = (isset($param['out_trade_no']))?$param['out_trade_no']:null;
        $this->set_trade_no($trade_no,$order_no);


        $this->refund_result = array(
            'result_status' => false
            ,'result_code' => 'NO_REFUND' 
            ,'status_msg' => '没有退款交易' 
            ,'refund_count' => '0'
        );

        $this->sub_refund = array();
    }

    private function push_result_data($formated_data)
    {

        if(isset($formated_data['refund_type'])){
            $this->refund_result['refund_type'] = $formated_data['refund_type'];
        }
        
        switch ($formated_data['result_code']) {
            case 'SUCCESS':
                $this->refund_result['refund_count']++;
                $this->refund_result['result_status'] = true;
                $this->refund_result['result_code'] = 'SUCCESS'; 
                $this->refund_result['status_msg'] = '查询成功'; 
                $this->refund_result['total_amount'] = $formated_data['total_amount'];

                $this->sub_refund[] = $formated_data['sub_refund'];

                break;
            
            default:
                # code...
                break;
        }

        if(isset($formated_data['is_sure'])){
            $this->refund_result['is_sure'] = $formated_data['is_sure'];
            if($formated_data['is_sure']){
                $this->refund_result['refund_amount'] = $this->real_refund_total_amount;
            }
        }

        if(count($this->sub_refund)){
            $this->refund_result['sub_refund_amount'] = $this->tk_refund_total_amount;
            $this->refund_result['sub_refund'] = $this->sub_refund;
        }


    }

    /**
     * 按照退款响应参数格式化
     * @param  [type]  $result_data             支付宝返回的退款源数据
     * @return [type]                           [description]
     */
    private function format_result($result_data)
    {
        $format_data = array(
            'result_status' => false
            ,'result_code' => 'NO_REFUND' 
            ,'status_msg' => '没有退款交易' 
            ,'refund_count' => '0'
        ); 
        if(isset($result_data['refund_amount'])){
            //确保以退款标识为交易记录存在的情况下,执行退款操作它会返回退款总金额
            if(!$this->is_sure && 
                isset($result_data['refund_amount']) && $result_data['status']
            ){
                // ※：复制调用这个接口前必须看这个函数的注释内容！！！
                $this->real_refund_total_amount = $this->get_refund_total_amount($result_data['out_request_no'], $result_data['refund_amount'], true);
                // ※：复制调用这个接口前必须看这个函数的注释内容！！！

                $this->is_sure = true;
                // $this->refund_result['is_sure'] = true;
                // $this->refund_result['refund_type'] 
                    // = ($result_data['total_amount'] == $this->real_refund_total_amount)?'ALL':'PARTIAL';

                $format_data['is_sure'] = true;
                $format_data['refund_type'] = ($result_data['total_amount'] == $this->real_refund_total_amount)?'ALL':'PARTIAL';

            }
            $this->tk_refund_total_amount += floatval($result_data['refund_amount']);
 
            $format_data['result_status'] = true;
            $format_data['result_code'] = 'SUCCESS';
            $format_data['status_msg'] = '查询成功';
            $format_data['total_amount'] = $result_data['total_amount'];
            $format_data['sub_refund'] = array(
                'result_code' => 'SUCCESS'  //支付宝没有子订单处理中状态
                ,'out_refund_no' => $result_data['out_request_no']
                ,'refund_fee' => $result_data['refund_amount']
                ,'request_data' => $result_data
            );


            $this->push_result_data($format_data);
 

        }


        return $format_data;
    }

    /**
     * 查询退款信息，查询结果会对子订单一直叠加
     * @param  [type] $out_request_no [description]
     * @return [type]                 [description]
     */
    public function get_refund_info($out_request_no)
    {

        $result = $this->trade_refund_info($out_request_no);

        if($result['code'] == '10000'){
            return $this->format_result($result);
        }else{ 

            $this->refund_result['result_status'] = false;

            if(isset($result['sub_code']) 
                && $result['sub_code'] == 'ACQ.TRADE_NOT_EXIST'){
                $this->refund_result['result_code'] = 'NOTFOUND';
            }else{
                $this->refund_result['result_code'] = 'ERROR';
            }

            if(isset($result['sub_msg'])){
                $this->refund_result['status_msg'] = $result['sub_msg'];                
            }
            $this->refund_result['request_data'] = $result;
            return $this->refund_result;
        }

        // return $this->format_result($result);
    }


    /**
     * 获取退款总金额
     * ※：其实这个也有缺陷，必须保证退款标识正确才可以获取实际的退款总金额。 支付宝接口不提供没办法；；
     * @param  String  $trade_no       支付宝交易号
     * @param  String  $out_request_no 退款标识
     * @param  Float   $refund_amount  退款金额
     * @param  boolean $trust          是否受信任数据
     *                                 【※：不是特殊情况就不要用这个选项
     *                                 False: 会获取API数据验证是不是已经退款的单，[请求两次API]
     *                                 True:  要使用True请慎重！！ [请求一次API]
     *                                        没有退款标识为ID的退款记录会发生退款处理
     * @return Float                  返回退款总金额，有错误返回-1, 操作的时候发生了退款操作也会返回-1
     */
    private function get_refund_total_amount($out_request_no, $refund_amount, $trust = false)
    {
        if($trust){
            $param = $this->get_trade_no();
            $param['refund_amount'] = $refund_amount;
            $param['out_request_no'] = $out_request_no;

            //查询的退款标识的时候万一发生了退款操作，那就是程序有问题的了。
            //请检查所有调用get_refund_total_amount函数的语句吧。
            $param['refund_reason'] = '查询退款总金额';    
            

            $result = $this->request('AlipayTradeRefundRequest',$param);

            if(isset($result['fund_change']) && $result['fund_change'] === 'N' && $result['status']) {
                return floatval($result['refund_fee']);
            }else{
                return -1;
            }

        }
    }

}