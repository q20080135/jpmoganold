<?php if ( ! defined('WIDGET_PI')) exit('No direct script access allowed widget');

//查看物流信息挂件
class delivery_express extends Widget {
    function index($order_id,$data = null) {
        
        if($order_id){
            $data['order_id'] = $order_id;
            $this->config->load('weitui_static');
            $express_list = $this->config->item('express_list');
            if(isset($express_list[$data['kd']])){
                $data['kd_name'] = $express_list[$data['kd']];                
            }
            // dump($data);
            $this->load->view('widget/order/delivery_express',$data);
        }else{
            exit('[send_express widget] no order_id');
        }
    }
}
?>