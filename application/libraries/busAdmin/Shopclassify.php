<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

//分类
class Shopclassify
{
    //protected $CI;
    //protected $_sysinfo;
    //protected $shop_classify;
    
    //构造函数
    public function __construct()
    {
        //$this->CI = & get_instance();
        //$this->CI->config->load('busAdmin/sysinfo');
        //$this->_sysinfo = $this->CI->config->item('sysinfo');
        //$this->load->model($this->_sysinfo['m_dir'] . '/Spe_shop_classify_Model', 'shop_classify');
    }
    
    
    /**
     * 获取所有的商品分类列表(最大5级)
     * @param  $data     全部数据
     * @param  $selectid 默认选择项
     * @return 所有选项
     */
    public function get_classify_list($data, $selectid = 0)
    {
        $options = $selectid > 0 ? "" : "<option value='0'>请选择</option>";
        $before = "&nbsp;&nbsp;&nbsp;&nbsp;";
    
        foreach ($data as $val)
        {
            if($val['cID'] == $selectid)
            {
                $options .= "<option value='{$val['cID']}' selected='selected'>{$val['cName']}</option>";
            }
            else
            {
                $options .= "<option value='{$val['cID']}'>{$val['cName']}</option>";
            }
    
            if(!empty($val['child']))
            {
                foreach ($val['child'] as $val2)
                {
                    $name2 = str_repeat($before, 1) . $val2['cName'];
                    if($val2['cID'] == $selectid)
                    {
                        $options .= "<option value='{$val2['cID']}' selected='selected'>{$name2}</option>";
                    }
                    else
                    {
                        $options .= "<option value='{$val2['cID']}'>{$name2}</option>";
                    }
    
                    if(!empty($val2['child']))
                    {
                        foreach ($val2['child'] as $val3)
                        {
                            $name3 = str_repeat($before, 2) . $val3['cName'];
                            if($val3['cID'] == $selectid)
                            {
                                $options .= "<option value='{$val3['cID']}' selected='selected'>{$name3}</option>";
                            }
                            else
                            {
                                $options .= "<option value='{$val3['cID']}'>{$name3}</option>";
                            }
    
                            if(!empty($val3['child']))
                            {
                                foreach ($val3['child'] as $val4)
                                {
                                    $name4 = str_repeat($before, 3) . $val4['cName'];
                                    if($val4['cID'] == $selectid)
                                    {
                                        $options .= "<option value='{$val4['cID']}' selected='selected'>{$name4}</option>";
                                    }
                                    else
                                    {
                                        $options .= "<option value='{$val4['cID']}'>{$name4}</option>";
                                    }
    
                                    if(!empty($val4['child']))
                                    {
                                        foreach ($val4['child'] as $val5)
                                        {
                                            $name5 = str_repeat($before, 4) . $val5['cName'];
                                            if($val4['cID'] == $selectid)
                                            {
                                                $options .= "<option value='{$val5['cID']}' selected='selected'>{$name5}</option>";
                                            }
                                            else
                                            {
                                                $options .= "<option value='{$val5['cID']}'>{$name5}</option>";
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    
        return $options;
    }
}

?>
