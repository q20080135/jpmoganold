<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

//分类
class Shopclassify
{
    //构造函数
    public function __construct()
    {
        $this->preStr = '&nbsp;&nbsp;&nbsp;&nbsp;';
    }

    /**
     * 获取分类列表
     * @param $list      array  列表数据
     * @param $selectid  int    默认选择项
     * @param $selectStr string 用于填充select元素
     * @param level      int    层级(一般不用传) 
     * @return select元素内的字符串
     */
    public function get_classify_select($list, $selectid = 0, $selectStr = '', $level = 0)
    {
        if(!empty($list) && is_array($list)) {
            foreach($list as $val) {
                $selected = $val['cID'] == $selectid ? ' selected="selected"' : '';
                $value = str_repeat($this->preStr, $level) . $val['cName'];
                $selectStr .= "<option value='{$val['cID']}'{$selected}>{$value}</option>";
                if(!empty($val['child'])) {
                    $selectStr .= $this->get_classify_select($val['child'], $selectid, '', ($level + 1));
                }
            }
        }
        return $selectStr;
    }
}

?>
