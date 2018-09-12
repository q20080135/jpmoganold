<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * 图片关系表
 * @author 齐福
 * 创建时间 ： 2017年5月22日下午9:31:59
 */
class Img_relation_model extends MY_Model
{
    public function __construct()
    {
        $this->table = 'spe_img_relation';

        parent::__construct();
    }

    /**
     * 根据 关系ID 查找图片
     * @param integer $relationID 关系id
     * @param integer $irType 0 售后（spe_after_service）1 退换表 （spe_return）2省广告表（spe_ad_province）
     * @return array
     */
    public function get_imgs_Byrid($relationID,$irType)
    {
        if($relationID > 0)
        {
            $sql = "SELECT `irID`,`relationID`,`irUrl` FROM `{$this->table}` WHERE `relationID` = " . $relationID." and irType = {$irType}";
            $que = $this->db->query($sql);
        
            return $que->result_array();
        }else if($relationID ==0){
        	$sql = "SELECT `irID`,`relationID`,`irUrl` FROM `{$this->table}` WHERE irType = {$irType} and relationID is null";
            $que = $this->db->query($sql);
        
            return $que->result_array();
        }
        else
        {
            return null;
        }
    }


    /**
     * 添加广告图片
     * @param array $arr 添加到数据库的数据集
     * @return
     */
    public function add_product_img($arr)
    {
        if(!empty($arr))
        {
            if($this->db->insert($this->table, $arr))
            {
                return $this->db->insert_id();
            }
        }
    
        return false;
    }
   /**
     * 根据 图片ID 查找图片
     * @param integer $irID 图片ID
     * @return array
     */
    public function get_a_image($irID)
    {
        if($irID > 0)
        {
            $sql = "SELECT * FROM `{$this->table}` WHERE `irID` = " . $irID;
            $que = $this->db->query($sql);
        
            return $que->row_array();
        }
        else
        {
            return null;
        }
    }


     /**
     * 删除图片
     * @param integer $irID 图片ID
     * @return array
     */
    public function del_img_byid($irID)
    {
        if($irID > 0)
        {
            $sql = "SELECT * FROM `{$this->table}` WHERE `irID` = {$irID}";
            $que = $this->db->query($sql);
            $ret = $que->row_array();
            
            if(!empty($ret))
            {
                $sql = "DELETE FROM `{$this->table}` WHERE `irID` = " . $ret['irID'];
                if($this->db->query($sql))
                {
                    return $ret;
                }
            }
        }
        
        return null;
    }

    /**
     * 更新
     * @param integer $adpActivityId 省id
     * @return array
     */
    public function set_list_img($adpId)
    {

        if($adpId > 0)
        {

            $sql = "UPDATE `{$this->table}` SET `relationID` = {$adpId} WHERE `relationID` is null and irType = 2";
            $ret = $this->db->query($sql);
            if($this->db->query($sql))
            {
                return $ret;
            }else{
				return false;
            }

        }
        
        return null;
    }
}
