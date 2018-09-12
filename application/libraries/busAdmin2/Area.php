<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

//地区
class Area
{
    protected $CI;
    protected $_sysinfo;
    protected $region;
    
    //构造函数
    function __construct()
    {
        $this->CI = & get_instance();
        $this->_sysinfo = $this->CI->config->item('sysinfo');
        $this->CI->load->model($this->_sysinfo['m_dir'] . '/Spe_region_Model', 'region');
    }
    
    /**
     * 获取所有地区列表 <select>
     * @param integer $country  选中的国家ID
     * @param integer $province 选中的省份ID
     * @param integer $city     选中的城市ID
     * @param integer $district 选中的区域ID
     *
     * @return array $result
     */
    public function get_all_region_select($country = 1, $province = 0, $city = 0, $district = 0)
    {
        $_country = intval($country);
        $_province = intval($province);
        $_city = intval($city);
        $_district = intval($district);
        $result = array();
        //添加数据
        $result['country'] = $this->create_select_string(0, 0, $_country);
        $result['province'] = $_country > 0 ? $this->create_select_string($_country, 1, $_province) : '';
        $result['city'] = $_province > 0 ? $this->create_select_string($_province, 2, $_city) : '';
        $result['district'] = $_city > 0 ? $this->create_select_string($_city, 3, $_district) : '';
        return $result;
    }
    
    /**
     * 生成<select>元素的字符串
     * @param integer $parent  地区ID
     * @param integer $level   地区层级
     * @param integer $selID
     * @param string  $return  select/array 返回数组还是列表项
     *
     * @return string $ret
     */
    public function create_select_string($parent, $level = 0, $selID = 0, $return = 'select')
    {
        $selID = intval($selID);
        $level = intval($level);
        $ret = null;
        if($selID >= 0) {
            $list = $this->CI->region->get_region_list($parent, $level);
            if($return == 'select') {
                foreach ($list as $key => $val) {
                    $selectStr = $val['region_id'] == $selID ? 'selected="selected"' : '';
                    $ret .= "<option value='{$val['region_id']}' {$selectStr}>{$val['region_name']}</option>";
                }
            }else {
                $ret = $list ? $list : '';
            }
        }
        return $ret;
    }
}

?>