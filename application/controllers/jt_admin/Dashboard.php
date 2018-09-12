<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends ADMIN_Controller
{

    public function index()
    {
        // 待付款-未付款（确认中）
        // 待发货-已付款（已确认）
        // 待收货-已付款（已发货）
        // 待处理 - 已付款（确认中）
        // 退款/售后 - 收货失败 或 申请退还货
        // 0 and oPay = 0 待付款
        // 1, 待发货
        // 3 待收货
        // 0 and oPay = 1 待处理
        // 5,6 退款售后;

        // oStatus: 订单状态 0确认中,1已确认,2取消订单,3已发货,4收货成功, 5收货失败,6申请退换货,7申请失败,8申请完成
        // oPay: 0 未付款， 1 已付款， 2  退款;
        $order_analisis = array(
            'DaiFuKuan' => 0
            ,'DaiFaHuo' => 0
            ,'DaiShouHuo' => 0
            ,'DaiChuLi' => 0
            ,'TuiKuan' => 0
        );

        // 交易记录
        $order_data = $this->model('jt_admin/analy')->get_order_analisis();
        foreach ($order_data as $k => $v) {
            switch ($v['oStatus']) {
                case '0':
                    if($v['oPay'] == '1'){
                        $order_analisis['DaiChuLi'] += $v['cnt'];
                    }else{
                        $order_analisis['DaiFuKuan'] += $v['cnt'];
                    }
                    break;
                case '1':
                        $order_analisis['DaiFaHuo'] += $v['cnt'];
                    break;
                case '3':
                        $order_analisis['DaiShouHuo'] += $v['cnt'];
                    break;
                case '5':
                        $order_analisis['TuiKuan'] += $v['cnt'];
                    break;
                case '6':
                        $order_analisis['TuiKuan'] += $v['cnt'];
                    break;
            }
        }
        unset($order_data);


        // 所有总数量和昨日统计
        $analisys_data = $this->model('jt_admin/analy')->get_analisis();

        foreach ($analisys_data as $k => $v) {
            $total_data[$v['type']] = $v['count'];
        }
        unset($analisys_data);



        // 获取版本信息
        $platform_data = $this->model('jt_admin/analy')->get_platform();

        $data = array_merge($order_analisis,$total_data,$platform_data);
        // dump($data);
        $this->load->view('jt_admin/dashboard', $data);
    }

    public function get_analisis()
    {
        $where = array(
            'type' => '用户日新增'
        );
        $order = 'id desc';
        $limit = '14';
        $user_analy_data = $this->model('jt_admin/analy')->get_list('date,count',$where,array(),$order,$limit);


        $where = array(
            'type' => '日加入购物车产品数'
        );
        $cart_analy_data = $this->model('jt_admin/analy')->get_list('count',$where,array(),$order,$limit);

        $where = array(
            'type' => '日提交订单数量'
        );
        $order_analy_data = $this->model('jt_admin/analy')->get_list('count',$where,array(),$order,$limit);

        $where = array(
            'type' => '日支付订单数量'
        );
        $pay_analy_data = $this->model('jt_admin/analy')->get_list('count',$where,array(),$order,$limit);
        
        $result = array();

        foreach ($user_analy_data as $k=>$v){
            $result['user_count'][] = $v['count'];
            $result['date'][] = substr($v['date'],5,10);
        }
        $result['user_count'] = array_reverse($result['user_count']);
        $result['date'] = array_reverse($result['date']);
        foreach ($cart_analy_data as $k=>$v){
            $result['cart_count'][] = $v['count'];
        }
        $result['cart_count'] = array_reverse($result['cart_count']);
        foreach ($order_analy_data as $k=>$v){
            $result['order_count'][] = $v['count'];
        }
        $result['order_count'] = array_reverse($result['order_count']);
        foreach ($pay_analy_data as $k=>$v){
            $result['pay_count'][] = $v['count'];
        } 
        $result['pay_count'] = array_reverse($result['pay_count']);
        // dump($user_analy_data,'n');
        // dump($user_analy_data,'n');
        // dump($result['date']);
        echo json_encode($result);
    }
}
