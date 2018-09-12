<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * 管理员操作日志表
 * @author 齐福
 * 创建时间 ： 2016年11月21日下午3:31:59
 */
class Admin_logs_model extends MY_Model
{
    public function __construct()
    {
        $this->table = 'spe_admin_logs';

        parent::__construct();
    }

    /**
     * 记录操作内容
     * @param  string $log_msg [日志标题]
     * @param  array $data    操作数据
     * @param  int $key     识别主键
     * @return bool          成功返回 true, 失败返回 false
     */
    public function log($log_msg, $data = null, $key = null, $call_function = null, $platform = 'jt_admin')
    {
        // $data = debug_backtrace()[1]['function'];
        // bench_mark('p1');

        if ($call_function === null) {
            $debug=debug_backtrace();
            // bench_mark('p2');
            $call_function=strtolower($debug[1]['class'].'/'.$debug[1]['function']);
        }
        $mUrl = $platform.'/'.$call_function;
        
        // $this->config->load('weitui_static');
        // $log_code_type = $this->config->item('log_code_type');
        // if (!isset($log_code_type[$call_function])) {
        // $con = $this->router->fetch_class();
        //$func = $this->router->fetch_method();
        //$conlfunc =  $con."/".$func;
        $this->db->where('mUrl', $mUrl);//like查询  before = '%words', after = 'words%' , both =  '%words%'
        $query = $this->db->get('spe_auth_menu');
        $arr = $query->row();


        if (isset($arr->mCodeType) && $arr->mCodeType) {
            // $log_code_type[$call_function] = $arr->mCodeType;

            $code_type = $arr->mCodeType;
        } else {
            // echo '在application/config/weitui_static.php<br>文件里设置日志分类 $config[\'log_code_type\']<br>'.$call_function;
            // $msg = '请设置日志分类：<br>在数据表[spe_auth_menu]里设置mCodeType<br>';
            $sql = 'insert into spe_auth_menu (mName, mParentID, mUrl, mCodeType, mHidden)';
            $sql .= 'VALUE ("'.$log_msg.'", {mParentID}, "'.$mUrl.'", {mCodeType}, 1);';

            $json_result['status'] = false;
            $json_result['msg'] = '请设置日志数据, 这个请联系福哥~';
            $json_result['tip'] = '在数据表[spe_auth_menu]里设置mCodeType';
            $json_result['zsql'] = $sql;
            echo json_encode($json_result);
            exit;
        }
        // }

        // 在application/config/weitui_static.php 文件里设置日志分类 $config['log_code_type']
        // $code_type = $log_code_type[$call_function];
        // print_r($code_type);
        // dump($call_function);
        $log_item = array(
            'logTitle'    => $log_msg
            ,'logKey'    => $key
            ,'codeType'     => $code_type
            ,'logTime'     => date("Y-m-d H-i-s")
            ,'logUserId'  => $this->admin_id
            ,'logData'     => serialize($data)
            ,'callFunction'=> $call_function
            ,'clientIp'=> ip()
        );

        // $res = $this->model('admin_logs')->insert($log_item);
        $res = $this->db->insert('spe_admin_logs', $log_item);

        return $res;
    }


    public function get_order_log($id, $log_title = null)
    {

        $fild = 'v_admin_logs.*, a.name as name, a.user as user_id';
        $where = array(
            'code_type =' => 3    //日志分类
            ,'log_key =' => $id
            ,'del_flag =' => 0
            );
        if ($log_title) {
        // dump($log_title);
            if (is_array($log_title)) {
                $where['log_title']  = $log_title;
            } else {
                $where['log_title =']  = $log_title;
            }
        }

        $join = array(
            'admin a' => 'log_user_id = a.id'
        );

        if ($id) {
            $logs = $this->model('admin_logs')->get_list($fild, $where, $join, 'log_id desc', 100, 0);
            // dump_query();
            // dump($logs);
            
            return $logs;
        } else {
            return null;
        }
    }
    /**
     * 获取管理员操作日志
     * @param unknown $id
     * @param string $logTitle
     * @return unknown|NULL
     */
    public function get_admin_log($id, $code_type = null, $log_title = null)
    {
    
        $fild = 'spe_admin_logs.*, a.uRealName, a.uID as uID';
        $where = array(
                'logKey =' => $id
                ,'delFlag =' => 0
        );
        if ($code_type) {
            $where['codeType'] = $code_type;
        }
        if ($log_title) {
            if (is_array($log_title)) {
                $where['logTitle']  = $log_title;
            } else {
                $where['logTitle =']  = $log_title;
            }
        }
    
        $join = array(
                'spe_admins a' => 'logUserId = a.uID'
        );
        if ($id) {
            $logs = $this->model('admin_logs')->get_list($fild, $where, $join, 'logId desc', 100, 0);
            return $logs;
        } else {
            return null;
        }
    }
}
