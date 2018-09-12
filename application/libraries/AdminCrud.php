<?php
/**
 * CRUD后台管理模块
 *
 * 混合使用框架 DataTables + H-ui + CI
 * 方便后台管理时，规范化，简单化为目的
 * DataTables ： https://datatables.net/
 * H-ui ： http://www.h-ui.net/
 * CI ： http://codeigniter.org.cn/user_guide/
 *
 *
 * @category   Admin-CRUD
 * @package    Nickspace
 * @copyright  Copyright 2007 - 2016 NickSpace All Rights Reserved. (http://nickspace.cn)
 * @license    http://jquery.org/license    Released under the MIT license
 * @version    1.8.0, 2014-03-02
 */
 
class AdminCrud
{

    /**
     * 实际更新到数据库的数据
     * @var array
     */
    public $update_item = array();

    /**
     * 日志标题，可以多个用数组形式
     * @var array
     */
    public $admin_log_msg = array();
    
    /**
     * 要记录内容的数据
     * @var array
     */
    public $log_item = array();
    public $insert_log_id = null;

    private $CI;
    public function __construct()
    {
        $this->CI = &get_instance();
    }

    /**
     * 为了简化下列情况
     * if(form('shr')) $update_item['shr'] = form('shr');
     * if(form('shr')) $log_item['ori_shr'] = form('ori_shr');
     *
     * @param [string]  $name      [post传递的key_name]
     * @param [string]  $db_col   [数据表列名称]
     * @param boolean $isset_log [是否添加到日志里]
     */
    public function setData($name, $db_col = null, $default = null)
    {
        if ($db_col === null) {
            $db_col = $name;
        }
        if (form($name) || form($name) === '0') {
            $this->setUpdateItem($db_col, form($name));
        } elseif ($default !== null) {
            $this->setUpdateItem($db_col, $default);
        }
    }

    public function setUpdateItem($name, $val)
    {
        $this->update_item[$name] = $val;
    }

    public function setLogItem($name, $val)
    {
        if ($val) {
            $this->log_item['ori_'.$name] = $val;
        }
    }
 
    public function isnullSetLogTitle($title)
    {

        if (count($this->admin_log_msg) == 0) {
            $this->addLogTitle($title);
        }
    }

    public function addLogTitle($title)
    {
        $this->admin_log_msg[] = $title;
    }

    public function updateLogKey($pk)
    {
        $item['logKey'] = $pk;
        $where['logId'] = $this->insert_log_id;
        $this->CI->model('jt_admin/admin_logs')->update($item, $where);
    }

    /**
     * [验证数据后写日志]
     * @param  [string,int] $pk 日志表里的logKey值
     * @return [bool,json]     [正常情况下返回true,否则返回json形式的错误信息]
     */
    public function validationAndWriteLog($pk = null)
    {
        $this->admin_log_msg = implode(', ', $this->admin_log_msg);

        // 表单验证规则在 config/form_validation.php 文件
        $this->CI->load->library('form_validation');
        $this->CI->form_validation->set_data($this->update_item);

        if ($this->CI->form_validation->run()) { //验证 update_item 数据
            // dump($this->admin_log_msg);
            //先记录操作内容
            $debug=debug_backtrace();
            $call_function=strtolower($debug[1]['class'].'/'.$debug[1]['function']);
            $result = $this->CI->model('jt_admin/admin_logs')->log($this->admin_log_msg, array_merge($this->update_item, $this->log_item), $pk, $call_function);
            if ($pk==null) {
                $this->insert_log_id = $this->CI->db->insert_id();
            }
            // dump($result);
            if ($result) {    // 更改订单信息
                return true;
            } else {
                $json_result['status'] = false;
                $json_result['msg'] = '操作数据库时出错';
            }
        } else {
            $json_result['status'] = false;
            $json_result['msg'] = validation_errors();
            $json_result['msg_type'] = 'validation_errors [设置:form_validation.php]';
        }
        exit(json_encode($json_result));
    }

    /**
     * [验证数据后写日志]
     * @param  [string,int] $pk 日志表里的logKey值
     * @return [bool,json]     [正常情况下返回true,否则返回json形式的错误信息]
     */
    public function writeLog($pk = null)
    {
        $this->admin_log_msg = implode(', ', $this->admin_log_msg);

        // dump($this->admin_log_msg);
        //先记录操作内容
        $debug=debug_backtrace();
        $call_function=strtolower($debug[1]['class'].'/'.$debug[1]['function']);
        $result = $this->CI->model('jt_admin/admin_logs')->log($this->admin_log_msg, array_merge($this->update_item, $this->log_item), $pk, $call_function);
        if ($pk==null) {
            $this->insert_log_id = $this->CI->db->insert_id();
        }
        // dump($result);
        if ($result) {    // 更改订单信息
            return true;
        } else {
            $json_result['status'] = false;
            $json_result['msg'] = '操作数据库时出错';
        }
        
        exit(json_encode($json_result));
    }

    public function updateCol($model_name, $col, $key)
    {
 
        foreach ($key as $v) {
            if (is_numeric($v)) {
                $result = $this->CI->model($model_name)->update($col, $key);

                if ($result) {    // 更改订单信息
                    $json_result['status'] = true;
                } else {
                    $json_result['status'] = false;
                    $json_result['msg'] = '操作数据库时出错';
                }
            }
            exit(json_encode($json_result));
        }
        
    }

    public function getDetail($id, $model_name)
    {
        if ($id) {
            $data = $this->CI->model($model_name)->getDetailData($id);
            if (!$data) {
                exit('无效ID <a href="javascript:history.back(-1);">返回</a>');
            }
            $data['id'] = $id;
            return $data;
        } else {
            exit('ID有误 <a href="javascript:history.back(-1);">返回</a>');
        }
    }
}
