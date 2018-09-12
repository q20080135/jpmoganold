<?php

interface PaymentInterface
{
    public function platform();

    public function get_trade_no($param = array());
    /**
     * 交易查询
     * @param  String $order_no     商家订单号
     * @param  String $trade_no     支付平台交易号
     */
    public function trade_query();

    
    /**
     * 退款查询
     * @param  String $order_no         商家订单号
     * @param  String $out_request_no   退款标识
     */
    public function trade_refund_query($out_request_no = null);


    /**
     * 交易退款
     * @param  String   $order_no           商家订单号
     * @param  Number   $total_amount       订单总金额(单位:元)
     * @param  String   $reason             退款原因
     * @param  Number   $refund_amount      退款金额,0为全额退款 (单位:元)
     * @param  Number   $out_refund_no      退款标识
     * @param  array    $param              其他可选参数
     */
    public function trade_refund($total_amount, $reason, $refund_amount = 0, $out_refund_no = null, $param = array());
}

class Payment
{
    const WAIT     = '等待用户付款';
    const CLOSED   = '交易关闭';
    const SUCCESS  = '支付成功';
    const NOTFOUND = '交易不存在';
    const ERROR    = '发生错误';


    const REFUND_SUCCESS  = '退款成功';
    const REFUND_FAIL  = '退款失败';
    const NOTENOUGH  = '余额不足';
    
    //这个前缀要保持不变，要不然支付宝接口查询不了退款记录，只能下载对账单来查询
    const REFUND_PREFIX = 'TK';


    protected $trade_no = null;
    protected $order_no = null;

    public function set_trade_no($trade_no, $order_no = null)
    {
        $this->trade_no = $trade_no;
        if($order_no){
            $this->order_no = $order_no;
        }
    }


    /**
     * 过滤参数后合并，防止请求外的参数传过来。
     * @param  array $data        要合并的数组
     * @param  array $input_data  要过滤的数组
     * @param  array  $filter_keys 过滤的键名
     * @return array              过滤参数后合并的数据
     */
    protected function filter_merge($data, $input_data, $filter_keys = array())
    {
        if(gettype($filter_keys) == 'string'){
            $filter_keys = array($filter_keys);
        }
        $filter_item = array_intersect_key($input_data, array_fill_keys($filter_keys,null));
        return array_merge($data, $filter_item);
    }

/***************************************************************************
 ************************   以下是针对CI框架为基础的接口   ***************************
 **************************************************************************/

    /**
     * 获取操作人员信息
     * @param  string $format   返回数据格式，现支持格式有 array(默认)，name_id
     * @return Array || String  返回用户信息
     *                            array： array('name' => 'XXX', 'id' => 10)
     *                            name_id:  用户名[用户ID]
     */
    protected function get_user_info($format = 'array')
    {
        $user_info = array('name'=>'','id' => '');
        if(isset($_SESSION['admin_info'])){
            $admin = $_SESSION['admin_info'];
            if(isset($admin['uRealName'])){
                $user_info['name'] = $admin['uRealName'];
            }
            if(isset($admin['uID'])){
                $user_info['id']= $admin['uID'];
            }
        }

        if($format == 'name_id'){
            $name_id = '';
            if(isset($user_info['name'])){
                $name_id .= $user_info['name'];
            }
            if(isset($user_info['id'])){
                $name_id .= '['.$user_info['id'].']';
            }
            return $name_id;
        }
        return $user_info;
    }

    /**
     * 记录支付交易信息
     * @param  [type] $insertItem   接收以下数据
     *                  goID            总订单编号
     *                  plPayUser       支付人
     *                  plAddtime       添加时间
     *                  plTradeAmount   交易金额 
     *                  plTradeID       支付编码
     *                  plPlatform      支付平台('支付宝','微信')
     *                  plType          支付类型('付款','部分退款','全额退款')
     *                  plTradeDatas    其他交易数据(序列化格式的)
     * @return [type]          [description]
     */
     
    protected function insert_log($insertItem){
        $CI =& get_instance();

        $col = array('goID','plPayUser','plAddtime','plTradeAmount','plTradeID','plPlatform','plType','plTradeDatas');
        $insertItem = $this->filter_merge(array(), $insertItem, $col);
        return $CI->model('pay_log')->insert($insertItem);
    }

    protected function make_refund_no($seq){
        $seq = intval($seq);
        if($seq<=0) $seq = 1;
        return $this::REFUND_PREFIX.substr('000'.$seq,-3);
    }
}