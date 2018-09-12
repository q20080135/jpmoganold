<?php if ( ! defined('WIDGET_PI')) exit('No direct script access allowed widget');

//用户日志挂件
class Admin_logs extends Widget {
    function index($uID,$data = null) {
      
        if($uID){
            $this->config->load('weitui_static');
           
            $data['express_list'] = $this->config->item('express_list');
           
            $data['uID'] = $uID;
            $CI =& get_instance();
           
            $data['logs'] = $CI->model('jt_admin/admin_logs')->get_admin_log($uID);
            
            $labels = $CI->model('jt_admin/admins')->attribute_labels();
            $data['log_items'] = $labels;
            
            if($data['logs'] || (isset($data['payback_log']) && $data['payback_log'])){
                $this->load->view('widget/admin/admin_logs',$data);                
            }
        }else{
            exit('[admin_order_logs widget] no order_id');
        }
    }
}
?>