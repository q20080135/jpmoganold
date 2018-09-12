<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 店铺等级
 * @author 齐福
 * 创建时间 ： 2017年7月29日上午9:37:43
 */
class Grade_model extends MY_Model{
    public function __construct(){
        $this->table = 'spe_shop_grade';

        parent::__construct();
    }

    public function get_select($selectid = 0){

    	$data = $this->get_list('*',null,null,'sgID asc',null,null);
    	$rdata = $this->get_grade_list($data,$selectid);
    	return $rdata;

    }

    /**
     * 获取店铺等级
     * @param  $data     全部数据
     * @param  $selectid 默认选择项
     * @return 所有选项
     */    
    public function get_grade_list($data, $selectid = 0)
    {
        $options = $selectid > 0 ? "" : "<option value=''>--请选择店铺等级--</option>";
        $before = "&nbsp;&nbsp;&nbsp;&nbsp;";
    
        foreach ($data as $val)
        {
            if($val['sgID'] == $selectid)
            {
                $options .= "<option value='{$val['sgID']}' selected='selected'>{$val['sgName']}</option>";
            }
            else
            {
                $options .= "<option value='{$val['sgID']}'>{$val['sgName']}</option>";
            }

        }
    
        return $options;
    }
    
}



