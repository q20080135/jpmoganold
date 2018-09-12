<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

if (!function_exists('dump')) {

    function dump() {
        switch (ENVIRONMENT) {
            case 'development':
                if(!headers_sent()){
                    header('content-type:text/html;charset=utf-8');
                }
                echo "<pre style='font-size:12px;'>";
                $exit = true;
                $args = func_get_args();
                $num = func_num_args();
                if ($num) {
                    if ($args[$num - 1] === 'n') {
                        $exit = false;
                        array_pop($args);
                        $num --;
                    }
                    for ($i = 0; $i < $num; $i ++) {
                        if (is_bool($args[$i]) || !$args[$i]) {
                            var_dump($args[$i]);
                        } else {
                            print_r($args[$i]);
                        }
                        echo '<hr/>';
                    }
                    if ($exit) {
                        exit();
                    }
                }
                echo '</pre>';
                break;

            default:
                break;
        }
    }

}

if (!function_exists('exit_json')) {

    function exit_json($data) {
        echo json_encode($data);
        exit;
    }

}

if (!function_exists('bench_mark')) {

    function bench_mark($point) {
        $CI = & get_instance();
        $CI->benchmark->mark($point);
    }

}
if (!function_exists('echo_bench_mark')) {

    function echo_bench_mark() {
        if (ENVIRONMENT == 'development') {
            $CI = & get_instance();

            $mark = $CI->benchmark->marker;
            $mark = array_splice($mark, 4, 100);

            if (count($mark) > 1) {
                $str = '';
                foreach ($mark as $k => $v) {
                    if (!isset($temp_key)) {
                        $temp_key = $k;
                    } else {
                        $str .= $temp_key . '~' . $k . ': ';
                        $str .= $CI->benchmark->elapsed_time($temp_key, $k);
                        $str .= '秒<br>';
                    }
                }
                echo $str;
            } else {
                echo 'Mark数量要大于1';
            }
        }
    }

}

if (!function_exists('dump_query')) {

    function dump_query() {
        switch (ENVIRONMENT) {
            case 'development':
                $CI = & get_instance();
                dump($CI->db->last_query(),'n');
                break;

            default:
                break;
        }
    }

}

if (!function_exists('res_url')) {

    function res_url($file, $dir = 'default', $add_type = true) {
        $param = '';
        if (strpos($file, '?')) {
            list($file, $param) = explode('?', $file);
            $param = '?' . $param;
        }
        $file_space = $dir . '@' . $file;
        $res = MY_Controller::$resource;
        if (!isset($res[$file_space])) {    //只加载一次
            $res[$file_space] = true;
            MY_Controller::$resource = $res;
        } else {
            return null;
        }

        $_ext = pathinfo($file, PATHINFO_EXTENSION);
        if (empty($_ext)) {
            $ext = 'js';
            $file .= '.js';
        } else {
            $ext = $_ext;
        }
        if ($dir == 'lib') {
            $tmp = base_url("resource/lib/" . $file);
        } else {
            $dir = 'static/' . $dir;
            $type = ($ext == 'js' || $ext == 'css') ? $ext : 'images';
            if ($add_type) {
                $tmp = base_url("resource/" . $dir . "/" . $type . "/" . $file);
            } else {
                $tmp = base_url("resource/" . $dir . "/" . $file);
            }
        }

        if (base_url() == "/") {
            $_tmp = $tmp;
        } else {
            $_tmp = str_replace(base_url(), "", $tmp);
        }

        $str_return = "";
        if ($ext == 'js') {
            $str_return = "<script type='text/javascript' src='" . $tmp . $param . "'></script>\n";
        } elseif ($ext == 'css') {
            $str_return = "<link type='text/css' href='" . $tmp . $param . "' rel='stylesheet'/>\n";
        } else {
            $str_return = $tmp;
        }
        if (file_exists(FCPATH . $_tmp)) {
            return $str_return;
        } else {
            echo "<script>console.log('无法加载:" . $file . "')</script>";
            return null;
        }
    }

}

/**
 * 返回入驻商样式目录 ‘LIN’目录内
 */
if (!function_exists('bus_style_dir')) {

    function bus_style_dir($suffix = '') {
        $_sysinfo = get_instance()->config->item('sysinfo');
        return base_url($_sysinfo['style_dir'] . $suffix);
    }

}

/**
 * 返回入驻商网站目录
 */
if (!function_exists('bus_url')) {

    function bus_url($suffix = '') {
        // 加载系统信息
        $_sysinfo = get_instance()->config->item('sysinfo');
        return site_url($_sysinfo['c_dir'] . "/" . $suffix);
    }

}

if (!function_exists('adm_url')) {

    function adm_url($url) {
        $CI = & get_instance();
        return site_url('jt_admin/' . $url);
    }

}

if (!function_exists('get_sess')) {

    function get_sess($key) {
        $CI = & get_instance();
        return $CI->session->userdata($key);
    }

}

if (!function_exists('db_error')) {

    function db_error($val) {
        $error = 'db_custom_error_heading';
        $swap = $val;
        $LANG = & load_class('Lang', 'core');
        $LANG->load('db');

        $heading = $LANG->line('db_error_heading');
        $message = is_array($error) ? $error : array(
            str_replace('%s', $swap, $LANG->line($error))
        );

        $trace = debug_backtrace();

        if (ENVIRONMENT == 'development') {
            if (isset($trace[0]['file'], $trace[0]['line'])) {
                $message[] = 'Filename: ' . str_replace(array(
                            APPPATH,
                            BASEPATH
                                ), '', $trace[0]['file']);
                $message[] = 'Line Number: ' . $trace[0]['line'];
            }
            $error = & load_class('Exceptions', 'core');
            echo $error->show_error($heading, $message, 'error_db');
            exit(8); // EXIT_DATABASE
        }
    }

}

if (!function_exists('set_sess')) {

    function set_sess($key, $val) {
        $CI = & get_instance();
        $CI->session->set_userdata($key, $val);
    }

}
if (!function_exists('form')) {

    function form($key = null, $xss = true) {
        $CI = & get_instance();
        $val = $CI->input->post($key, $xss);
        return $val;
        // return $xss ? filterhtml($val) : $val;
    }

}
if (!function_exists('data_form')) { // DataTables 传递的搜索条件 https://datatables.net

    function data_form($key = null, $xss = true) {
        $CI = & get_instance();
        $columns = $CI->input->post('columns', $xss);
        $val = null;
        if ($columns) {
            foreach ($columns as $k => $v) {
                if (isset($v['name']) && $v['search']['value'] != '' && $v['name'] == $key) {
                    $val = $v['search']['value'];
                }
            }
        }
        return $val;
    }

}

if (!function_exists('urlget')) {

    function urlget($key = null, $xss = true) {
        $CI = & get_instance();
        $val = $CI->input->get($key, $xss);
        return $val;
        // return $xss ? filterhtml($val) : $val;
    }

}
if (!function_exists('qiniu_img')) {

    function qiniu_img($url, $width = '', $height = '', $option = 'fit') {
        $param = '';
        if (gettype($option) == 'string') {
            $option = array($option => null);
        }
        if (is_array($option)) {
            if (count($option) == 0) {
                $option = array('crop' => array('size' => $width . 'x' . $height));
            }
            foreach ($option as $k => $v) {
                switch ($k) {
                    case 'crop':
                        // set default
                        if (!isset($v['gravity'])) {
                            $v['gravity'] = 'Center';
                        }
                        if (!isset($v['size'])) {
                            $v['size'] = $width . 'x' . $height;
                        }

                        // set param
                        $param .= '/gravity/' . $v['gravity'] . '/crop/';

                        if (isset($v['position'])) {
                            $param .= '!' . $v['size'] . $v['position'];
                        } else {
                            $param .= $v['size'];
                        }

                        break;
                    case 'fit':
                        $param .= '/thumbnail/!' . $width . 'x' . $height . 'r';
                        $param .= '/gravity/Center';
                        $param .= '/crop/' . $width . 'x' . $height;
                        $param .= '/interlace/1';
                        break;
                    case 'etc':
                        $param .= $v;
                        break;
                }
            }

            if ($width || $height) {
                $url .= '?imageMogr2' . $param;
            }
            return $url;
        } else {
            return null;
        }
    }

}
/**
 * 得到IP信息
 */
if (!function_exists('ip')) {

    function ip() {
        // if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
        // $ip = getenv('HTTP_CLIENT_IP');
        // } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
        // $ip = getenv('HTTP_X_FORWARDED_FOR');
        // } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
        // $ip = getenv('REMOTE_ADDR');
        // } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
        $ip = $_SERVER['REMOTE_ADDR'];
        // }
        // return preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
        return $ip;
    }

}

/**
 * 生成随机字符串
 *
 * @param
 *            int length 长度
 * @return string 生成的字符串
 */
if (!function_exists('generate_Random_String')) {

    function generate_Random_String($length = 10) {   //简单化get_random()
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i ++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

}
if (!function_exists('get_random')) {

    function get_random($length = 10) {
        return generate_Random_String($length);
    }

}

if (!function_exists('fillter_data')) {

    /**
     * 过滤没必要的数组
     *
     * @param [array] $date
     *            [数据源]
     * @param [array] $fillter
     *            [要选取的数据，key数组]
     * @return [array] [过滤后的数据,没有则返回空的数组]
     */
    function fillter_data($date, $fillter) {
        $return = array();
        foreach ($fillter as $v) {
            if (isset($date[$v])) {
                $return[$v] = $date[$v];
            }
        }
        return $return;
    }

}


/**
 * 判断是否是序列化字符串
 *
 * @param unknown $data
 * @return boolean
 */
if (!function_exists('is_serialized')) {

    function is_serialized($data) {
        if (!is_string($data)) {
            return false;
        }
        $data = trim($data);
        if ('N;' == $data) {
            return true;
        }
        if (!preg_match('/^([adObis]):/', $data, $badions)) {
            return false;
        }
        switch ($badions[1]) {
            case 'a':
            case 'O':
            case 's':
                if (preg_match("/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $data)) {
                    return true;
                }
                break;
            case 'b':
            case 'i':
            case 'd':
                if (preg_match("/^{$badions[1]}:[0-9.E-]+;\$/", $data)) {
                    return true;
                }
                break;
        }
        return false;
    }

}
if (!function_exists('tree_array')) {

    function tree_array($arr, $fid, $fparent = 'pid', $fchildrens = 'child', $returnReferences = false) {
        $pkvRefs = array();
        foreach ($arr as $offset => $row) {
            $pkvRefs[$row[$fid]] = & $arr[$offset];
            $pkvRefs[$row[$fid]][$fchildrens] = array();
        }
        $tree = array();
        foreach ($arr as $offset => $row) {
            $parentId = $row[$fparent];
            if ($parentId) {
                if (!isset($pkvRefs[$parentId])) {
                    continue;
                }
                $parent = & $pkvRefs[$parentId];
                $parent[$fchildrens][] = & $arr[$offset];
            } else {
                $tree[] = & $arr[$offset];
            }
        }
        if ($returnReferences) {
            return array('tree' => $tree, 'refs' => $pkvRefs);
        } else {
            return $tree;
        }
    }

    function strpos_array($haystack, $needles) {
        if (is_array($needles)) {
            foreach ($needles as $str) {
                if (is_array($str)) {
                    $pos = strpos_array($haystack, $str);
                } else {
                    $pos = strpos($haystack, $str);
                }
                if ($pos !== FALSE) {
                    return $pos;
                }
            }
        } else {
            return strpos($haystack, $needles);
        }
    }

}
