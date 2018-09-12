<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 广告模型类
 * 
 * @author 齐福
 *         创建时间 ： 2016年12月12日上午8:54:12
 */
class Analy_model extends MY_Model
{

    public function __construct()
    {
        $this->table = 'spe_analy';
        
        parent::__construct();
    }

    public function get_order_analisis()
    {
        $sql = '
        SELECT oStatus,
               oPay,
               count(*) as cnt
        FROM `spe_shop_orders`
        WHERE oStatus in(0,1,3,5,6)
        GROUP BY oStatus,
                 oPay;
        ';

        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function get_analisis()
    {
        $sql = '
        SELECT a.*
        FROM spe_analy AS a
        INNER JOIN
          (SELECT max(id) AS id ,
                  TYPE
           FROM spe_analy
           GROUP BY TYPE) AS b ON a.id = b.id
        ';
        $result = $this->db->query($sql);
        return $result->result_array();

    }

    public function get_platform()
    {
        $result = array(
            'android_update' => '暂无信息'    
            ,'android_now' => '暂无信息'    
            ,'ios_update' => '暂无信息'    
            ,'ios_now' => '暂无信息'    
        );

        $order = 'versionid desc';
        $where = array('versionSys' => '1');
        $data = $this->model('jt_admin/version')->get_row('*',$where,array(),$order);
        
        if($data){

            $result['android_update'] = $data['versionName'];
            if(time() < strtotime($data['updateTime'])){
                
                $where = array(
                    'versionSys' => '1'
                    ,'updateTime <' => date("Y-m-d H-i-s")
                );
                $data = $this->model('jt_admin/version')->get_row('*',$where,array(),$order);
                if($data){
                    $result['android_now'] = $data['versionName'];
                }
            }else{
                $result['android_now'] = $data['versionName'];
            }
        }

        $where = array('versionSys' => '2');
        $data = $this->model('jt_admin/version')->get_row('*',$where,array(),$order);
        
        if($data){            
            $result['ios_update'] = $data['versionName'];
            if(time() < strtotime($data['updateTime'])){
                
                $where = array(
                    'versionSys' => '2'
                    ,'updateTime <' => date("Y-m-d H-i-s")
                );
                $data = $this->model('jt_admin/version')->get_row('*',$where,array(),$order);
                if($data){
                    $result['ios_now'] = $data['versionName'];
                }
            }else{
                $result['ios_now'] = $data['versionName'];
            }
        }

        return $result;
    }
}



