<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

if (!function_exists('single_image_uploader')) {
    function single_image_uploader($id, $width, $height, $attr = array(), $img_url = '', $options = array())
    {
        $html = $attrs = $class_attr = $placeholder = $ori_val = $csswidth = $cssheight = $datatype = '';
        $nullmsg = '';
        
        $uploaderOption = new stdClass;
        if (isset($options['maxWidth'])) {
            $uploaderOption->maxWidth = $options['maxWidth'];
        }
        if (isset($options['maxHeight'])) {
            $uploaderOption->maxHeight = $options['maxHeight'];
        }

        $html .= res_url('megapix-image', 'lib');
        $html .= res_url('image_uploader/img_upload.js?1', 'lib');
        $html .= res_url('image_uploader/style.css?1', 'lib');

        if (isset($attr['placeholder'])) {
            $placeholder = $attr['placeholder'];
        }
        if (isset($attr['datatype'])) {
            $datatype .= 'datatype="'.$attr['datatype'].'" ';
        }
        if (isset($attr['nullmsg'])) {
            $nullmsg = 'nullmsg="'.$attr['nullmsg'].'" ';
        }
        $csswidth = 'width:'.$width.((is_numeric($width))?'px':'').';';
        $cssheight = 'height:'.$height.((is_numeric($height))?'px':'').';';
        $cssBgSize = $btnUploadSize = '';

        if ((intval($width/2) < 76) || intval($height/2) < 60) {
            $cssBgSize = 'background-size:';
            if (intval($width/2) > intval($height/2)) {
                $cssBgSize .= intval($height/2). 'px;';
            } else {
                $cssBgSize .= intval($width/2). 'px;';
            }
        }
        if ((intval($width/2) < 49) || intval($height/2) < 50) {
            $btnUploadSize = ' style="background-size:';
            if (intval($width/2) > intval($height/2)) {
                $btnUploadSize .= intval($height/2).'px;" ';
            } else {
                $btnUploadSize .= intval($width/2).'px;" ';
            }
        }

        unset($attr['type']);
        unset($attr['value']);
        foreach ($attr as $k => $v) {
            $attrs .= $k . '="' . $v . '"';
        }
        $html .= '  <div id="single_image_uploader_'.$id.'" class="single_image_uploader" style="'.$csswidth.$cssheight.$cssBgSize.'">
                        <input type="hidden" id="'.$id.'" name="'.$id.'" class="img_data" '.$attrs.'>
                        <span class="placehold">'.$placeholder.'</span>
                        <img id="img_viewer_'.$id.'" class="img_viewer" src="'.$img_url.'" style="'.$csswidth.$cssheight.'">
                        <div class="siu-hover"></div>';
        if ($width >= 70 && $height >= 120) {
            $html .= '              
                        <a href="javascript:;" class="btn_set btn_rotation_left"></a>
                        <a href="javascript:;" class="btn_set btn_rotation_right"></a>';
        }
        $html .= '
                        <span class="btn-image-upload">
                            <a href="javascript:;" class="btn_upload_img" '.$btnUploadSize.'></a>
                            <input type="file" id="img_file_'.$id.'" name = "img_file_'.$id.'" class="img_uploader" multiple="false" accept="image/gif,image/jpeg,image/jpg,image/png" capture="camera">
                        </span>  
                        <input class="validform" type="text" '.$datatype.$nullmsg.'style=" width: 0px;height: 0px;border: 0px;position: absolute;">
                    </div>
                    <script>$("#single_image_uploader_'.$id.'").singleImageUploader('.json_encode($uploaderOption).');</script>
                    ';
        return $html;
    }
}

if (! function_exists('tag_input')) {
    function tag_input($val, $attr)
    {
        $html = $attrs = $class_attr = $placeholder = $ori_val = '';
        $html .= '<div class="Hui-tags">
                    <div class="Hui-tags-editor cl">';
        if (is_array($val)) {
            foreach ($val as $k => $v) {
                if ($v != '') {
                    $html .= '<span class="Hui-tags-token">' . $v . '</span>';
                }
            }
            $ori_val = implode($val, ',');
        }
        
        if (isset($attr['class'])) {
            $class_attr = ' ' . $attr['class'];
        }
        if (isset($attr['placeholder'])) {
            $placeholder = $attr['placeholder'];
        }
        unset($attr['type']);
        unset($attr['value']);
        foreach ($attr as $k => $v) {
            $attrs .= $k . '="' . $v . '"';
        }
        
        $html .= '  <div class="Hui-tags-iptwrap">
                        <input type="text" class="Hui-tags-input" maxlength="20" value="">
                        <label class="Hui-tags-label">添加' . $placeholder . '，用空格或回车分隔</label>
                    </div>
                </div> 
                <input type="hidden" class="Hui-tags-val' . $class_attr . '" value="' . $ori_val . '" ' . $attrs . '>
            </div>';
        return $html;
    }
}

if (! function_exists('render_list_filter')) {
    function render_list_filter($filters)
    {
        $html = '';
        foreach ($filters as $k => $v) {
            $html .= ' <input type="text" id="filter_'.$k.'" placeholder=" '.$v['name'].'" class="input-text filter">';
        }
        return $html;
    }
}

if (! function_exists('select_options')) {

    /**
     * 渲染 select->option html标签 *
     *
     * @param [type] $key
     *            selected 值
     * @param array $options
     *            选项列表
     * @param bool $is_show_null
     *            选项列表
     * @param bool $select_by_key
     *            判断选项里 是否用Key选择
     * @return [type] string
     */
    function select_options($key = null, $options = array(), $is_show_null = false, $select_by_key = true)
    {
        $html = "";
        
        if ($select_by_key) {
            $check_keys = array_keys($options);
        } else {
            $check_keys = $options;
        }
        if (! in_array($key, $check_keys) || $is_show_null) {
            $default_text = is_string($is_show_null) ? $is_show_null : '请选择';
            $html .= "<option value=\"\">-" . $default_text . "-</option> ";
        }
        foreach ($options as $k => $v) {
            if ($v != '') {
                if ($select_by_key) {
                    $value = $k;
                } else {
                    $value = $v;
                }
                $html .= "<option ";
                if ($value == $key) {
                    $html .= "selected='selected'";
                }
                $html .= " value='" . $value . "'>" . $v . "</option> ";
            }
        }
        return $html;
    }
}


if (! function_exists('get_form_html')) {

    /**
     * 自动生成html标签
     *
     * @param 类型 $type
     * @param 值 $value
     * @param 显示名字 $showName
     * @param 控件名字 $codeName
     * @param
     *            多选项值
     * @param 是否是表格 $istable
     * @return html
     * @abstract get_form_html('text','zhi','name',true);
     *           注：select 的value 格式 $value = array("range"=>array(array('value'=>1,'name'=>'男'),array('value'=>0,'name'=>'女')),"value"=>"1"); value 不传则没有默认选择
     */
    function get_form_html($type, $value, $showName, $codeName, $istable = false)
    {
        $return = '';
        if ($type == 'text') {
            if ($istable) {
                $return = '<table class="table table-border"><td>' . $showName . '</td><td><input class="input radius size-S" name="' . $codeName . '" type="text" value="' . $value . '" size="40" /></td></table>';
            } else {
                $return = '<input  class="input radius size-S" name="' . $codeName . '" type="text" value="' . $value . '2" size="40" />';
            }
        } elseif ($type == 'password') {
            if ($istable) {
                $return = '<table class="table table-border"><td>' . $showName . '</td><td><input  class="input radius size-S" name="' . $codeName . '" type="password" value="' . $value . '" size="40" /></td></table>';
            } else {
                $return = '<input class="input radius size-S" name="' . $codeName . '" type="password" value="' . $value . '2" size="40" />';
            }
        } elseif ($type == 'textarea') {
            if ($istable) {
                $return = '<table class="table table-border"><td>' . $showName . '</td><td><textarea name="' . $codeName . '" cols="40" rows="5">' . $value . '</textarea></td></table>';
            } else {
                $return = '<textarea name="' . $codeName . '" cols="40" rows="5">' . $value . '</textarea>';
            }
        } elseif ($type == 'select') {
            if ($istable) {
                $option = '';
                // 判断是非是序列化字符串
                if (is_serialized($value)) {
                    $value = unserialize($value);
                }
                if (is_array($value)) {
                    foreach ($value['range'] as $optionKey => $optionVal) {
                        $selected = '';
                        $ori_data = '';
                        if (isset($value['value'])) {
                            if ($value['value'] == $optionVal['value']) {
                                $selected = 'selected="selected"';
                            }
                            $ori_data = " ori_data=\"".$value['value']."\"";
                        }
                        $option .= '<option value="' . $optionVal['value'] . '" ' . $selected . '>' . $optionVal['name'] . '</option>';
                    }
                    $return = '<table class="table table-border"><td>' . $showName . '</td><td><select id="' . $codeName . '" name="' . $codeName . '" '.$ori_data.'>' . $option . '</select></td></table>';
                }
                // 字符串 select 只支持 无默认选择项 的下拉类表
                if (is_string($value)) {
                    $option = explode(',', $value);
                    foreach ($option as $optionKey => $optionVal) {
                        $option .= '<option value="' . $optionKey . '">' . $optionVal . '</option>';
                    }
                    $return = '<table class="table table-border"><td>' . $showName . '</td><td><select id="' . $codeName . '" name="' . $codeName . '">' . $option . '</select></td></table>';
                }
            } else {
                $option = '';
                if (is_array($value)) {
                    foreach ($value['range'] as $optionKey => $optionVal) {
                        $selected = '';
                        $ori_data = '';
                        if (isset($value['value'])) {
                            if ($value['value'] == $optionVal['value']) {
                                $selected = 'selected="selected"';
                            }
                            $ori_data = " ori_data=\"".$value['value']."\"";
                        }
                        $option .= '<option value="' . $optionVal['value'] . '" ' . $selected . '>' . $optionVal['name'] . '</option>';
                    }
                    $return = $showName.' <select id="' . $codeName . '" name="' . $codeName . '" '.$ori_data.'>' . $option . '</select>';
                }
                // 字符串 select 只支持 无默认选择项 的下拉类表
                if (is_string($value)) {
                    $option = explode(',', $value);
                    foreach ($option as $optionKey => $optionVal) {
                        $option .= '<option value="' . $optionKey . '">' . $optionVal . '</option>';
                    }
                    $return = $showName.' <select id="' . $codeName . '" name="' . $codeName . '">' . $option . '</select>';
                }
            }
        } elseif ($type == 'radio') {
            if ($istable) {
                $radio = '';
                // 判断是非是序列化字符串
                if (is_serialized($value)) {
                    $value = unserialize($value);
                }
                if (is_array($value)) {
                    foreach ($value['range'] as $k => $v) {
                        $selected = '';
                        if (isset($value['value'])) {
                            if ($value['value'] == $v['value']) {
                                $selected = 'checked';
                            }
                        }
                        $radio .= '<div class="radio-box"><input type="radio" id="' . $codeName . $k . '" name="' . $codeName . '" ' . $selected . ' value="' . $v['value'] . '"><label for="' . $codeName . $k . '">' . $v['name'] . '</label></div>';
                    }
                    $return = '<table class="table table-border"><td>' . $showName . '</td><td>' . $radio . '</td></table>';
                }
            } else {
                $radio = '';
                if (is_array($value)) {
                    foreach ($value['range'] as $k => $v) {
                        $selected = '';
                        if (isset($value['value'])) {
                            if ($value['value'] == $v['value']) {
                                $selected = 'checked';
                            }
                        }
                        $radio .= '<div class="radio-box"><input type="radio" id="' . $codeName . $k . '" name="' . $codeName . '[]" ' . $selected . ' value="' . $v['value'] . '"><label for="' . $codeName . $k . '">' . $v['name'] . '</label></div>';
                    }
                    $return = '' . $showName . $radio ;
                }
            }
        } elseif ($type == 'checkbox') {
            if ($istable) {
                $radio = '';
                // 判断是非是序列化字符串
                if (is_serialized($value)) {
                    $value = unserialize($value);
                }
                if (is_array($value)) {
                    foreach ($value['range'] as $k => $v) {
                        $selected = '';
                        if (isset($value['value'])) {
                            $arr = explode(',', $value['value']);
                            if (in_array($v['value'], $arr)) {
                                $selected = 'checked';
                            }
                        }
                        $radio .= '<div class="check-box"><input type="checkbox" id="' . $codeName . $k . '" name="' . $codeName . '[]" ' . $selected . ' value="' . $v['value'] . '"><label for="' . $codeName . $k . '">' . $v['name'] . '</label></div>';
                    }
                    $return = '<table class="table table-border"><td>' . $showName . '</td><td>' . $radio . '</td></table>';
                }
            } else {
                $radio = '';
                if (is_array($value)) {
                    foreach ($value['range'] as $k => $v) {
                        $selected = '';
                        if (isset($value['value'])) {
                            if ($value['value'] == $v['value']) {
                                $selected = 'checked';
                            }
                        }
                        $radio .= '<div class="check-box"><input type="checkbox" id="' . $codeName . $k . '" name="' . $codeName . '" ' . $selected . ' value="' . $v['value'] . '"><label for="' . $codeName . $k . '">' . $v['name'] . '</label></div>';
                    }
                    $return = '' . $showName . $radio ;
                }
            }
        }
        return $return;
    }
}
