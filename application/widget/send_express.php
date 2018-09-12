<?php if ( ! defined('WIDGET_PI')) exit('No direct script access allowed widget');

class send_express extends Widget {
    function index($order_id,$data = null) {
        
        if($order_id){
            $data['order_id'] = $order_id;
            $this->config->load('weitui_static');
            $data['express_list'] = $this->config->item('express_list');
            // dump($data);
            $this->load->view('widget/order/send_express',$data);
        }else{
            exit('[send_express widget] no order_id');
        }
    }
}
?>