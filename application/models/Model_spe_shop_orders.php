<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
  |--------------------------------------------------------------------------
  | 入驻商后台管理  - 模型 - 订单表
  |--------------------------------------------------------------------------
  | 用于自动取消订单和自动收货
  |
 */

class Model_spe_shop_orders extends CI_Model {

    //构造函数
    public function __construct() {
        parent::__construct();
        $this->table = "spe_shop_orders";
    }

    //自动取消订单
    public function auto_cancel($_date) {
        if (!empty($_date) && strtotime($_date)) {
            $this->db->set('oStatus', 2);
            $this->db->where('oPay', 0);
            $this->db->where('oType', 0);
            $this->db->where("oAddTime < '{$_date}'");
            $this->db->where('(oStatus = 0 OR oStatus = 1)');
            // $sql = $this->db->get_compiled_update($this->table, false);
            // error_log($sql);
            $this->db->update($this->table);
            $number = $this->db->affected_rows();
            echo date('Y-m-d H:i:s') . " : {$number}条订单被自动取消。\r\n";
        }
    }

    //自动收货
    public function auto_finish($_date) {
        if (!empty($_date) && strtotime($_date)) {
            $this->db->set('oStatus', 4);
            $this->db->where('oPay', 1);
            $this->db->where('oType', 0);
            $this->db->where("oPayTime < '{$_date}'");
            $this->db->where('oStatus', 3);
            // $sql = $this->db->get_compiled_update($this->table, false);
            // error_log($sql);
            $this->db->update($this->table);
            $number = $this->db->affected_rows();
            echo date('Y-m-d H:i:s') . " : {$number}条订单被自动收货。\r\n";
        }
    }

    /**
     * 关闭普通订单
     */
    public function automatic_closing_transaction($hour) {
        $this->db->set(array(
            'oStatus' => 2,
            'osClose' => 1
        ));
        $this->db->where(array(
            'oPay' => 0,
            'oType' => 0,
            'UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(oAddTime) >' => $hour * 60 * 60
        ));
        $this->db->where('(oStatus = 0 OR oStatus = 1)');
        $this->db->update($this->table);
        $number = $this->db->affected_rows();
        if($number > 0) echo date('Y-m-d H:i:s') . " : {$number}条普通订单被自动关闭。\r\n";
    }

    /**
     * 自动收货
     */
    public function automatic_receiving($day) {
        $this->db->set(array(
            'oStatus' => 4,
            'osClose' => 1
        ));
        $this->db->where(array(
            'oStatus' => 3,
            'oPay' => 1,
            'UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(oExpressTime) >' => $day * 24 * 60 * 60
        ));
        $this->db->where_not_in('oExpressNum', array('已退款', '测试', '退款'));
        $this->db->update($this->table);
        $number = $this->db->affected_rows();
        if($number > 0) echo date('Y-m-d H:i:s') . " : {$number}条普通订单被自动收货。\r\n";
    }

    /**
     * 关闭拼团订单
     */
    public function automatic_closing_fight_groups() {
        $time=date('Y-m-d H:i:s',time());
        $fSql = 'UPDATE spe_shop_orders SET oStatus=2,ptStatus=2,osClose=1,osCloseTime="{$time}" WHERE orderNum in ('
                . 'SELECT orderNum FROM('
                . 'SELECT soID,orderNum,oAddTime,CASE WHEN oPayTime IS NULL THEN oAddTime ELSE oPayTime END AS oPayTime FROM spe_shop_orders WHERE oType = 1 AND ptHead = 1 AND oStatus = 0 AND ptStatus = 0 AND UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(oPayTime) > 86400) as SpeFight)';
        $this->db->query($fSql);
        $number = $this->db->affected_rows();
        if($number > 0) echo date('Y-m-d H:i:s') . " : {$number}条团购订单被自动关闭。\r\n";
    }

}
