<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

if (!function_exists('load_payment_by_order_no')) {

    function load_payment_by_order_no($order_no) {
        $CI = & get_instance();
        $sql = "SELECT payName, payNum FROM spe_member_pay_list
                WHERE orderNum = '{$order_no}'
                LIMIT 0, 1";
        $data = $CI->db->query($sql)->row_array();

        if($data){
            $trade_no = $data['payName'];
            if(substr($trade_no, 3,3) == '***'){
                $CI->load->library('AliPay'); 
                $CI->alipay->set_trade_no($data['payNum']);
                return $CI->alipay;
            }else{
                $CI->load->library('WxPay');
                $CI->wxpay->set_trade_no($data['payNum']);
                return $CI->wxpay;
            }
        }else{
            return false;
        }
    }

}

