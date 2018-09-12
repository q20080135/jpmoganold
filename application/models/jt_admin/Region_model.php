<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * 地区类
 * @author 齐福
 * 创建时间 ： 2016年12月12日上午11:19:19
 */
class Region_model extends MY_Model
{
    //构造函数
    public function __construct()
    {
        $this->table = 'spe_region';
        parent::__construct();
    }
    
    /**
     * 获取地区列表
     * @param int $parentID 父地区ID
     *
     * @return array 返回子地区列表
     */
    public function get_region_list($parentID = 0)
    {
        $parentID = intval($parentID);
    
        if ($parentID >= 0) {
            $filter['parent_id'] = $parentID;
            $order = 'region_id ASC';
            $data = $this->model('jt_admin/region')->get_list("*", $filter, null, $order, null, null);
            return $data;
        } else {
            return null;
        }
    }
    /**
     * 返回字段文字
     * return array customized attribute labels (name=>label)
     */
    public function attribute_labels()
    {
        return array(
        'region_id' => 'ID',
        'parent_id' => '父ID',
        'region_name' => '地区名',
        'region_type' => '地区类型',
        'agency_id' => '办事处ID（目前用不到）',
        );
    }


    public function getAreaInfoListData($where, $order = '', $limit = 10, $offset = 0, $join = array())
    {
        $filds = "gri.*, spe_region.*";
        // $where['region_type <>'] = '0';
        $data = $this->model('jt_admin/region')->get_list($filds, $where, $join, $order, $limit, $offset);
        // dump_query();
        // dump($where);
        return $data;
    }

    public function getDetailData($id)
    {
        $fild = 'gri.*, spe_region.*';
        $where = array('region_id' => $id);

        $join = array(
        'spe_goods_region_info gri' => 'region_id = gri.region_id'
        );
        if ($id) {
            $detail = $this->get_row($fild, $where, $join);
            
            // dump_query();
            $return = $detail;
            
            
            $return['sheng'] = "";
            $return['shi'] = "";
            $return['qu'] = "";

            if ($detail['region_type'] == 3) {
                $return['qu'] = $detail['region_name'];
                $where = array('region_id' => $detail['parent_id']);
                $detail = $this->get_row('*', $where);
            }

            if ($detail['region_type'] == 2) {
                $return['shi'] = $detail['region_name'];
                $where = array('region_id' => $detail['parent_id']);
                $detail = $this->get_row('*', $where);
            }

            if ($detail['region_type'] == 1) {
                $return['sheng'] = $detail['region_name'];
            }

            return $return;
        } else {
            return null;
        }
    }

    public function updateRegionInfo($item)
    {
        $this->db->set($item);
        $this->db->where('region_id', $item['region_id']);
        $result_update = $this->db->update('spe_goods_region_info');
        if ($result_update) {
            if ($this->db->affected_rows() == 0) {
                $this->db->set($item);
                $result_insert = $this->db->insert('spe_goods_region_info');
                return $result_insert;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
    
    /**
     * 返回中文省市区字样
     * @param unknown $id 
     * @return unknown
     */
    public function get_ssq_cn($id){
        $region_name = $this->model('jt_admin/region')->get_one('region_name', array(
            'region_id' => $id
        ));
        return $region_name;
    }
}
