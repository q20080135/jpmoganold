<?php if ( ! defined('WIDGET_PI')) exit('No direct script access allowed widget');

//订单日志挂件
class admin_order_logs extends Widget {
    function index($order_id,$data = null) {
        
        if($order_id){
            $this->config->load('weitui_static');
            $data['express_list'] = $this->config->item('express_list');
            $data['order_state'] = $this->config->item('order_state');
            $data['order_id'] = $order_id;
            // if(isset($express_list[$data['kd']])){
            //     $data['kd_name'] = $express_list[$data['kd']];                
            // }
            $CI =& get_instance();
            $data['logs'] = $CI->model('jt_admin/admin_logs')->get_order_log($order_id);
            if(isset($data['tjr'])) {
                $log_titles = array('返款选择订单','返款所有订单');
                $data['payback_log'] = $CI->model('jt_admin/admin_logs')->get_order_log($data['tjr'], $log_titles);
                // dump_query();
                // dump($log_titles);
            }
            $data['log_items'] = array(
                'shr' => '收货人'
                ,'tel' => '收货人电话'
                ,'dz' => '收货地区'
                ,'xdz' => '收货详细地址'
                ,'only_suk' => '订单套餐'
                ,'liuyan' => '留言'
                ,'beizhu' => '备注'
                );
            // dump($data);
            if($data['logs'] || (isset($data['payback_log']) && $data['payback_log'])){
                $this->load->view('widget/order/admin_order_logs',$data);                
            }
        }else{
            exit('[admin_order_logs widget] no order_id');
        }
    }
}
?>