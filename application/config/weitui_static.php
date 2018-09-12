<?php
defined('BASEPATH') or exit('No direct script access allowed');

//订单状态
$config['order_state'] = array(
    '1'     =>  "确认中",
    '9'     =>  "已确认",
    '10'    =>  "假单",
    '11'    =>  "联系不上",
    '2'     =>  "已发货",
    '3'     =>  "未返款",
    '6'     =>  "退货完成",
    '7'     =>  "拒收",
    '8'     =>  "已返款",
    '13'    =>  "已取消",
    '14'    =>  "待发货",
    // '4'     =>  "申请退货",     //这些不要
    // '5'     =>  "同意退货",     //这些不要
    // '0'     =>  "未付款",     //这些不要
    // '12'    =>  "已付款",     //这些不要
    '15'    =>  "重单"
);

//快递列表
$config['express_list'] = array(
    '顺丰'   =>   "顺丰",
    '中通'    =>  "中通",
    '德邦'    =>  "德邦",
    'EMS'    => "EMS",
    '圆通'    =>  "圆通",
    '金峰'    =>  "金峰"
);

//订单状态变更制约条件
$config['order_state_tree'] = array(
    '1'   =>    array(1,9,10,11,2,7,6,13,14,15),      //确认中
    '9'   =>    array(1,9,10,11,2,7,6,13,14,15),      //已确认
    '10'   =>   array(1,9,10,11,2,7,6,13,14,15),      //假单
    '11'   =>   array(1,9,10,11,2,7,6,13,14,15),      //联系不上
    '13'   =>   array(1,9,10,11,2,7,6,13,14,15),      //已取消
    '14'   =>   array(1,9,10,11,2,7,6,13,14,15),      //待发货
    '15'   =>   array(1,9,10,11,2,7,6,13,14,15),      //重单
    '3'   =>    array(3,2,8),                         //未返款
    '2'   =>    array(2,1,9,10,11,2,7,6,13,14,15,3),    //已发货
    // '8'   =>    array(),                            //已返款
    '7'   =>    array(7,2,6),                           //拒收
    '6'   =>    array(6,2)                            //退货完成
);


//日志分类
$config['log_code_type'] = array(
    'product/updata_product_info'         =>    '2'    //产品类2
    ,'product/add_product_proc'         =>    '2'    //产品类2
    
    ,'order/add_delivery_no'         =>    '3'    //订单类3
    ,'order/express_result'         =>    '3'    //订单类3
    ,'order/updata_order_info'         =>    '3'    //订单类3
    ,'excel/order_list'         =>    '3'    //订单类3
    ,'order/user_payback'         =>    '3'    //订单类3
    ,'order/user_payback_all'         =>    '3'    //订单类3

    ,'user/add'         =>    '4'       //会员类4
    ,'user/update_info'     =>    '4'    //会员类4
    ,'user/pass_reset'     =>    '4'    //会员类4
    
    ,'privilege/admin_login'         =>    '5'    //管理员类5

    ,'caiwu/rewarding'         =>    '6'    //财务类6
    ,'system/home_save'         =>    '1'    //系统类1
    ,'bgconfig/update_save' => '1' //系统类1
        
    ,'ad/add_save' => '7' //广告类1
    ,'ad/del_ad' => '7' //广告类1
    ,'ad/update_save' => '7' //广告类1
    
    
);
