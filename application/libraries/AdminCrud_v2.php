<?php
/**
 * CRUD后台管理模块
 *
 * 混合使用框架 DataTables + H-ui + CI
 * 方便后台管理时，规范化，简单化为目的
 * Bootstrap Tables ： http://bootstrap-table.wenzhixin.net.cn/zh-cn/documentation/
 * H-ui ： http://www.h-ui.net/
 * CI ： http://codeigniter.org.cn/user_guide/
 *
 *
 * @category   Admin-CRUD
 * @package    Nickspace
 * @copyright  Copyright 2007 - 2017 NickSpace All Rights Reserved. (http://nickspace.cn)
 * @license    http://jquery.org/license    Released under the MIT license
 * @version    2.0.0, 2017-08-12
 */
 
class AdminCrud_v2
{

    /**
     * 实际更新到数据库的数据
     * @var array
     */
    private $update_item = array();

    /**
     * 日志标题，可以多个用数组形式
     * @var array
     */
    public $log_key = null;
    
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

/********************************
/********************************
 * 共同部分
 */

    public function resultJsonOk($msg)
    {
        $json_result['status'] = true;
        $json_result['msg'] = $msg;
        echo json_encode($json_result);
        exit;
    }
    public function resultJsonError($msg,$data = null)
    {
        if(is_array($data)){
            $json_result = $data;
        }else if($data !== null){
            $json_result['data'] = $data;
        }
        $json_result['status'] = false;
        $json_result['msg'] = $msg;
        echo json_encode($json_result);
        exit;
    }
    public function resultError($msg,$data = null)
    {
        $this->CI->output->set_status_header(500);
        echo $msg;
        exit;
    }


    public function resetUpdateKey($name, $db_col)
    {
        if ($name !== $db_col && isset($this->search[$name])) {
            $this->search[$db_col] = $this->search[$name];
            unset($this->search[$name]);
        }
    }
    

/**
 * //共同部分
 *******************************
 *******************************/



/********************************
/********************************
 * 日志关联的
 */

    /**
     * 记录更改数据前的数据
     * @param [type] $name [description]
     * @param [type] $val  [description]
     */
    public function setLogItem($name, $val)
    {
        if ($val) {
            $this->log_item[$name] = $val;
        }
    }
    /**
     * 记录纯数据
     * @param [type] $data [description]
     */
    public function setLogItems($data)
    {
        $this->log_item[] = $data;
    }


    public function setLogKey($key)
    {
        $this->log_key = $key;
    }

    /**
     * 功能：更新日志主键
     * 
     * 说明：更新日志标识，写日志是在提交数据库前写的，因为操作数据库的时候有可能发生错误
     * 可是先写日志的话插入数据操作时还不知道主键是什么
     * 所以当插入完数据后在执行这个！
     * @param  [int] $pk [日志数据的标识]
     * @return [type]     [description]
     */
    public function updateLogKey($pk)
    {
        $item['logKey'] = $pk;
        $where['logID'] = $this->insert_log_id;
        return $this->CI->model('system/activity_log')->update($item, $where);
    }

    /**
     * [验证数据后写日志]
     * @return [bool,json]     [正常情况下返回true,否则返回json形式的错误信息]
     */
    public function validationAndWriteLog()
    {

        // 表单验证规则在 config/form_validation.php 文件
        $this->CI->load->library('form_validation');
        if(count($this->update_item) === 0){
            $this->resultError('没有要更新的内容！请使用下面方法来设置内容: <br>
                $this->admin->setUpdatebleItem($col);<br>
                $this->admin->setUpdateItem("colName",$val);');
        }
        $this->CI->form_validation->set_data($this->update_item);

        if ($this->CI->form_validation->run()) { //验证 update_item 数据
            //先记录操作内容

            $result = $this->insertLog();

            if ($result) {    // 更改订单信息
                return true;
            } else {
                $this->resultError('操作数据库时出错！');
            }
        } else {
            $json_result['status'] = false;
            $json_result['msg'] = (validation_errors())?validation_errors():'验证表单失败！';
            $json_result['msg_type'] = 'validation_errors [设置:form_validation.php]';
        }
        exit(json_encode($json_result));
    }

    /**
     * [写日志]
     * @return [bool,json]     [正常情况下返回true,否则返回json形式的错误信息]
     */
    public function writeLog()
    {
        $result = $this->insertLog();

        if ($result) {    // 更改订单信息
            return true;
        } else {
            $json_result['status'] = false;
            $json_result['msg'] = '操作数据库时出错';
        }        
        exit(json_encode($json_result));
    }

    private function insertLog()
    {
        $pk = $this->log_key;

        $data = array_merge($this->update_item, $this->log_item);
        $result = $this->CI->model('system/activity_log')->insertLog($data, $pk);
        
        if ($pk==null) {
            $this->insert_log_id = $this->CI->db->insert_id();
        }
        // dump($result);
        if ($result) {    // 更改订单信息
            return true;
        } else {
            return false;
        }
    }

/**
 * //日志关联的
 *******************************
 *******************************/

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
    public function getUpdateItem($name = null)
    {
        if($name === null){
            return $this->update_item;
        }else{
            return $this->update_item[$name];
        }
    }

    public function setUpdateItems($data)
    {
        $this->update_item = $data;
    }


/********************************
/********************************
 * 列表操作关联的
 */
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

/**
 * //列表操作关联的
 *******************************
 *******************************/



/********************************
/********************************
 * 添加操作关联的
 */


/**
 * //添加操作关联的
 *******************************
 *******************************/
    
    public function insert($model, $param = null)
    {

        // 表单验证规则在 config/form_validation.php 文件
        if ($this->validationAndWriteLog()) {

            // insertItem必须要返回['result' = true|false, 'id' = insert_id]
            $resultData = $this->CI->model($model)->insertItem($this->update_item, $param);
            
            // dump($resultData);
            if ($resultData['result']) {
                $this->updateLogKey($resultData['id']);
                return true;
            } else {
                $this->resultError('操作数据库时出错');
            }
        }
    }

/********************************
/********************************
 * 修改操作关联的
 */

    public function update($model,$pk,$param = null)
    {

        // 表单验证规则在 config/form_validation.php 文件
        $this->setLogKey($pk);
        if ($this->validationAndWriteLog()) {

            $result = $this->CI->model($model)->updateItem($this->update_item, $pk, $param);
            if ($result) {
                return true;
            } else {
                $this->resultError('操作数据库时出错');
            }
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

    public function setUpdatebleItem($filds = array())
    {
        $data = array_intersect_key(form(), array_fill_keys($filds,null));
        $this->update_item = array_filter($data, 
            function ($v, $k)
            {
                $prefix = 'ori-data-';
                return $v !== '' && $v !== null && $v !== false && form($prefix.$k) != $v ;
            },ARRAY_FILTER_USE_BOTH
        );
        return $this->update_item;
    }

/**
 * //修改操作关联的
 *******************************
 *******************************/
}
