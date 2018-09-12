<?php if ( ! defined('WIDGET_PI')) exit('No direct script access allowed widget');

//用户日志挂件
class admin_user_logs extends Widget {
    function index($id,$data = null) {
        
        if($id){
            $this->config->load('weitui_static');
            $data['express_list'] = $this->config->item('express_list');
            $data['id'] = $id;
            $CI =& get_instance();
            $data['logs'] = $CI->model('jt_admin/admin_logs')->get_user_log($id);
            $data['log_items'] = array(
                'xingming' => '姓名'
                ,'tel' => '电话'
                ,'qq' => 'QQ'
                ,'email' => '邮箱'
                ,'zhifubao' => '支付宝'
                ,'pwd' => '密码'
                );
            if($data['logs'] || (isset($data['payback_log']) && $data['payback_log'])){
                $this->load->view('widget/order/admin_user_logs',$data);                
            }
        }else{
            exit('[admin_order_logs widget] no order_id');
        }
    }
}
?>