<?php

if (!defined('BASEPATH')) {
    exit('No direct script acess allowed');
}

// 控制器基类
class MY_Controller extends CI_Controller {

    private static $_db = array();
    private static $_lib = array();
    public static $resource = array();

    public function __construct() {
        // header('Content-type:text/html;charset=utf-8');
        parent::__construct();
        $this->_init();
        // $this->CI = & get_instance();
    }

    private function _init() {
        
    }

    final public function model($name, $dir = '') {
        if (!isset(self::$_db[$name])) {
            $model = "{$name}_m"; // 防止全局变量重命名
            $this->load->model("{$dir}{$name}_model", $model);
            self::$_db[$name] = $this->$model;
        }
        return self::$_db[$name];
    }

    public function actor($actor_type, $check_id = null) {
        // 判断用户状态
        $actor_type = '_' . $actor_type;
        if (method_exists('MY_Controller', $actor_type)) {
            if (!$check_id) {
                $check_id = $this->admin_id;
            }
            return $this->$actor_type($check_id);
        } else {
            return false;
        }
    }

}

class USER_Controller extends MY_Controller {

    /**
     * actor_type: login_user 判断登录用户状态
     *
     * @param int $check_id
     *            用户ID
     * @return bool 返回用户登录状态
     */
    private function _login_user($check_id) {
        if ($check_id == $this->admin_id && $this->admin_id) {
            return true;
        } else {
            return false;
        }
    }

}

// 后台管理控制器基类
class ADMIN_Controller extends MY_Controller {

    public $admin_info;
    public $admin_id;

    public function __construct() {
        parent::__construct();
        $this->_init();

        if (!$this->admin_actor('admin_user')) {
            $re = str_replace('/index.php/', '', $_SERVER['REQUEST_URI']);
            if (!($re === 'jt_admin' || $re === 'jt_admin/')) {
                $login_url = site_url('login.html?re=' . urlencode($re));
            } else {
                $login_url = site_url('login.html');
            }
            redirect($login_url);
            exit;
        } else {
            if ($this->admin_info['auID'] != 1) {   //超级管理员例外
                $url = mb_substr($_SERVER['PHP_SELF'], 11);
                $sql = "SELECT * FROM spe_auth_menu where mUrl like '%" . $url . "%' and  find_in_set(mID,(select auRight from spe_auth_group where auID = " . $this->admin_info['auID'] . "))";
                $query = $this->db->query($sql);
                $rs = $query->result();
                $sql = "SELECT * FROM spe_auth_menu where mUrl like '%" . $url . "%'";
                $querynull = $this->db->query($sql);
                $rsnull = $querynull->result();
                if (!$rs && $rsnull) {
                    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                        echo '权限不足 <a href="javascript:history.back(-1)">返回上一页</a>';
                    } else {
                        $json_result['status'] = false;
                        $json_result['msg'] = '权限不足';
                        echo json_encode($json_result);
                    }
                    die;
                }
            }
        }
        // if(!(ENVIRONMENT == 'development' && $_SERVER['HTTP_HOST'] != PRODUCTION_DOMAIN)){ //不检测本地测试时候登录状态
        // }else{
        // }
    }

    private function _init() {
        $this->admin_info = &$_SESSION['admin_info'];
        $this->admin_id = &$this->admin_info['uID'];
        $this->admin_actor('admin_user');
    }

    public function admin_actor($actor_type, $check_id = null) {
        // 判断用户状态
        $actor_type = '_' . $actor_type;
        if (method_exists('ADMIN_Controller', $actor_type)) {
            if (!$check_id) {
                $check_id = $this->admin_id;
            }
            return $this->$actor_type($check_id);
        } else {
            return false;
        }
    }

    /**
     * actor_type: login_user 判断登录用户状态
     *
     * @param int $check_id
     *            用户ID
     * @return bool 返回用户登录状态
     */
    private function _admin_user() {
        if ($this->admin_id) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * actor_type: login_user 判断登录用户状态
     *
     * @param int $check_id
     *            用户ID
     * @return bool 返回用户登录状态
     */
    private function _super_admin($check_id) {
        if ($check_id && $this->admin_info['superior'] == '1') {
            return true;
        } else {
            return false;
        }
    }

}


// 后台管理控制器基类
class ADMIN_V2_Controller extends MY_Controller {

    public $admin_info;
    public $admin_id;

    public function __construct() {
        parent::__construct();
        $this->_init();

        if (!$this->check_actor_type('admin_user')) {
            $re = str_replace('/index.php/','',$_SERVER['REQUEST_URI']);
            if(!($re === 'jt_admin' || $re === 'jt_admin/')){
                $login_url = site_url('login.html?re='.urlencode($re));
            }else{
                $login_url = site_url('login.html');
            }
            redirect($login_url);
            exit;
        } else {
            if ($this->admin_info['auID'] != 1) {   //超级管理员例外
                $url = mb_substr($_SERVER['PHP_SELF'], 11);
                $sql = "SELECT * FROM spe_auth_menu where mUrl like '%" . $url . "%' and  find_in_set(mID,(select auRight from spe_auth_group where auID = " . $this->admin_info['auID'] . "))";
                $query = $this->db->query($sql);
                $rs = $query->result();
                $sql = "SELECT * FROM spe_auth_menu where mUrl like '%" . $url . "%'";
                $querynull = $this->db->query($sql);
                $rsnull = $querynull->result();
                if (!$rs && $rsnull) {
                    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                        echo '权限不足 <a href="javascript:history.back(-1)">返回上一页</a>';
                    } else {
                        $json_result['status'] = false;
                        $json_result['msg'] = '权限不足';
                        echo json_encode($json_result);
                    }
                    die;
                }
            }
        }
        // if(!(ENVIRONMENT == 'development' && $_SERVER['HTTP_HOST'] != PRODUCTION_DOMAIN)){ //不检测本地测试时候登录状态
        // }else{
        // }
    }

    private function _init() {
        $this->admin_info = &$_SESSION['admin_info'];
        $this->admin_id = &$this->admin_info['uID'];
        $this->check_actor_type('admin_user');

        $this->load->library('AdminCrud_v2');
        $this->admin = new AdminCrud_v2();
    }


    public function check_actor_type($actor_type) {
        // 判断用户状态
        $actor_type = '_' . $actor_type;
        if (method_exists('ADMIN_V2_Controller', $actor_type)) {
            return $this->$actor_type();
        } else {
            return false;
        }
    }

    /**
     * actor_type: login_user 判断登录用户状态
     *
     * @param int $check_id
     *            用户ID
     * @return bool 返回用户登录状态
     */
    private function _admin_user() {
        if ($this->admin_id) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * actor_type: login_user 判断登录用户状态
     *
     * @param int $check_id
     *            用户ID
     * @return bool 返回用户登录状态
     */
    private function _super_admin() {
        if ($this->admin_id && $this->admin_info['superior'] == '1') {
            return true;
        } else {
            return false;
        }
    }

}


/**
 * -------------------------------------------
 * 境淘土特产入驻商管理控制器基类
 * Business(商家即入驻商)，以下用Bus代替
 *
 * Actor : linzeyong
 * Date : 2016.11.18 9:30
 */
class Business_Controller extends CI_Controller {

    //受保护类型，用于本类和继承类调用
    protected $bus_info = array();
    protected $_sysinfo;
    protected $_basic = array();
    protected $_data = array();

    //构造函数
    public function __construct() {
        parent::__construct();
        $this->init();

        // 表单请求的，不加载菜单标题等信息
        $no_login = array('insert', 'update', 'isAjax');
        $action = $this->input->post_get("action");

        $this->_basic['title'] = $this->_sysinfo['sys_name'] . " - ";
        $this->_basic['location'] = $this->_sysinfo['sys_name'] . " - ";
        if (!in_array($action, $no_login)) {
            $this->load_menu_title();
        }
    }

    //获取系统信息
    public function getSystemInfo()
    {
        /***
         * 加载系统信息 (废除)
         * 原本想做成可以不同版本可以任意切换
         * 但实现过程中问题颇多
         * 单次只能打开一个版本, 版本可以[sysinfo]在设置
         */
        // $reg = '/^' . str_replace('/', '\\/', site_url()) . '/';
        // $uris = explode('/', preg_replace($reg, '', $_SERVER['REQUEST_URI']));
        // if(!empty($uris) && !empty($uris[0])) {
        //     if($uris[0] === 'busAdmin') {
        //         //加载系统信息
        //         $this->config->load('busAdmin/sysinfo');
        //     }else if($uris[0] == 'busAdmin2') {
        //         //加载系统信息
        //         $this->config->load('busAdmin2/sysinfo');
        //     }
        // }
        $this->_sysinfo = $this->config->item('sysinfo');
    }

    //跳转至设置版本
    public function autolink()
    {
        //去除url携带的get参数
        $url = preg_replace('/\?.*/', '', $_SERVER['REQUEST_URI']);
        $url_arr = explode('/', $url);
        if(!empty($url_arr)) {
            foreach($url_arr as $k => $u) {
                if(!empty($u) && !empty($this->_sysinfo['c_dir'])) {
                    $u = strtolower($u);
                    $cDir = strtolower($this->_sysinfo['c_dir']);
                    if(preg_match('/^busadmin(\d*)/i', $u) && $cDir != $u) {
                        $url_arr[$k] = $this->_sysinfo['c_dir'];
                        redirect(implode('/', $url_arr));
                    }
                }
            }
        }
    }

    //初始化
    public function init() {
        $this->getSystemInfo();
        $this->autolink();
        //获取session值
        $this->bus_info = &$_SESSION['bus_info'];
        //如果未登录，跳转到登录页面
        if (empty($this->bus_info)) {
            //获取用户输入地址，登录后再跳转
            $_SESSION['enter_url'] = $_SERVER['REQUEST_URI'];
            redirect($this->_sysinfo['c_dir'] . '/Login/index');
            exit();
        } else {
            //加载菜单项
            $this->config->load($this->_sysinfo['menu']);
            $this->_basic['menu'] = $this->config->item('menu');
            $this->_basic['showfoot'] = true;
        }
    }

    //获取post数据(包含bootstrapTable的application/json编码类型)
    public function get_post_datas()
    {
        $post1 = $this->input->post();
        $post2 = file_get_contents("php://input");
        $post2 = !empty($post2) ? json_decode($post2, true) : null;
        return !empty($post2) ? $post2 : $post1;
    }

    //自动识别菜单项和标题
    public function load_menu_title() {
        $url_str = $_SERVER['REQUEST_URI'];
        // $request = array_flip($_REQUEST);
        // $url_str = current($request);
        // $url_str = $_SERVER['REDIRECT_URL'];
        //去除url携带的get参数
        $url_str = preg_replace('/\?.*/', '', $url_str);
        if (!empty($url_str)) {
            $url_arr = explode('/', $url_str);
            foreach ($url_arr as $key => $val) {
                //busAdmin, busAdmin2, busAdmin3 ...
                //新版增加且添加自动跳转的时候无法判断相相等, 取前8位(busAdmin)判断即可
                if (strtolower($val) == strtolower($this->_sysinfo['c_dir'])) {
                    $classname = !empty($url_arr[$key + 1]) ? strtolower($url_arr[$key + 1]) : "main";
                    $funcname = !empty($url_arr[$key + 2]) ? strtolower($url_arr[$key + 2]) : 'index';
                    $funcname = str_replace("_", "", $funcname);
                    if (!empty($this->_basic['menu'][$classname])) {
                        $_menu = $this->_basic['menu'][$classname];
                        if ($funcname == "index") {
                            if (!empty($_menu['_index']) && !empty($_menu['_index']['name'])) {
                                $this->_basic['viewfile'] = $classname;
                                $this->_basic['title'] .= $_menu['_index']['name'];
                                $this->_basic['location'] = $this->_basic['title'];
                            }
                        } else {
                            if (!empty($_menu['_chlid'][$funcname]) && !empty($_menu['_chlid'][$funcname]['name'])) {
                                $this->_basic['viewfile'] = $classname . "_" . $funcname;
                                $this->_basic['title'] .= $_menu['_chlid'][$funcname]['name'];
                                $this->_basic['location'] .= $_menu['_index']['name'] . " - " . $_menu['_chlid'][$funcname]['name'];
                            }
                        }
                    }
                }
            }
        }
    }

    //加载bootstrap表格插件和日期插件
    public function load_table_file() {
        //在头部加载
        $this->_basic['head_file'] = array(
            array(
                'name' => 'bootstrap-table.css',
                'dir' => 'public/bootstrap-table',
                'addtype' => false
            ),
            array(
                'name' => 'bootstrap-datetimepicker.css',
                'dir' => 'public/datetimepicker',
                'addtype' => true
            ),
        );

        //在尾部加载
        $this->_basic['foot_file'] = array(
            array(
                'name' => 'bootstrap-table.js',
                'dir' => 'public/bootstrap-table',
                'addtype' => false
            ),
            array(
                'name' => 'bootstrap-table-zh-CN.js',
                'dir' => 'public/bootstrap-table',
                'addtype' => false
            ),
            array(
                'name' => 'bootstrap-datetimepicker.js',
                'dir' => 'public/datetimepicker',
                'addtype' => true
            ),
            array(
                'name' => 'bootstrap-datetimepicker.zh-CN.js',
                'dir' => 'public/datetimepicker',
                'addtype' => true
            ),
            array(
                'name' => 'laydate.js',
                'dir' => 'public/laydate',
                'addtype' => false
            ),
        );
    }

    //加载视图文件
    public function loadview($data = null) {
        if (!empty($this->_basic['viewfile'])) {
            $_data = $data ? $data : $this->_data;
            $this->_basic['hideMenu'] = (!empty($_GET['who']) && strtoupper($_GET['who']) == 'SUPERMAN') ? true : false;
            $this->load->view($this->_sysinfo['v_dir'] . '/header', $this->_basic);
            //----------------------------------------------
            if (!$this->_basic['hideMenu']) {
                $top_data = array(
                    'shopName' => $this->bus_info['sShopName'],
                );
                $this->load->view($this->_sysinfo['v_dir'] . '/top', $top_data);
                $this->load->view($this->_sysinfo['v_dir'] . '/left', $this->_basic);
            }
            //----------------------------------------------
            $this->load->view($this->_sysinfo['v_dir'] . '/' . $this->_basic['viewfile'], $_data);
            $this->load->view($this->_sysinfo['v_dir'] . '/footer', $this->_basic);
        }
    }

    /**
     * 加载操作结果视图
     * @param  integer  $type     分为4个提示等级[1提示、2成功、3警告、4错误]
     * @param  string   $meassge  提示内容
     * @param  array    $links    提供所有跳转链接
     * @param  integer  $autotime 自动跳转时间(为0则不跳转，默认跳转到第一个链接)
     * @param  integer  $iscolse  是否自动关闭(总后台使用)
     */
    public function resulthtml($type, $meassge, $links, $autotime = 0, $isclose = 0) {
        if (!empty($type) && !empty($meassge)) {
            $data['type'] = $type;
            $data['message'] = $meassge;
            $data['links'] = $links;
            $data['autotime'] = $autotime;
            $data['isclose'] = $isclose;
            $this->_basic['viewfile'] = "result";
            $this->loadview($data);
        }
    }

}

class Api_Controller extends CI_Controller {

    var $imgUrl = "http://vpn.jingtaomart.com";

    public function __construct() {
        parent::__construct();
        $this->load->model("api/Spe_NMember_model", "SpeToken");
        if ($_POST) {
            foreach ($_POST as $k => $v) {
                if ($k != 'mPicture') {
                    $v = strtolower($v);
                    if (strpos_array($v, array('select', 'limit', 'val', 'union', 'group', 'like', 'ifnull', 'exisis'))) {
                        exit();
                    }
                }
            }
        }
    }

    /**
     * 过滤参数
     * @param type $str
     * @param type $type
     * @return type
     */
    function strParameFilter($str, $type = '') {
        $str = strtolower($str);
        $str = str_replace('script', ' ', $str);
        $str = str_replace('src', ' ', $str);
        $str = str_replace('select', '', $str);
        $str = str_replace('from', ' ', $str);
        $str = str_replace('src', ' ', $str);
        $str = str_replace('select', '', $str);
        $str = str_replace('and', '', $str);
        $str = str_replace('char', '', $str);
        $str = str_replace('as', '', $str);
        $str = str_replace('ifnull', '', $str);
        $str = str_replace('ord', '', $str);
        return trim($str);
    }

    /**
     * diffDateTime() 计算时间差
     * @param type $begin_time 开始时间
     * @param type $end_time  结束时间
     * @return array
     */
    function diffDateTime($begin_time, $end_time) {
        if ($begin_time < $end_time) {
            $starttime = $begin_time;
            $endtime = $end_time;
        } else {
            $starttime = $end_time;
            $endtime = $begin_time;
        }
        $timediff = $endtime - $starttime;
        $days = intval($timediff / 86400);
        $remain = $timediff % 86400;
        $hours = intval($remain / 3600);
        $remain = $remain % 3600;
        $mins = intval($remain / 60);
        $secs = $remain % 60;
        $res = array("day" => $days, "hour" => $hours, "min" => $mins, "sec" => $secs);
        return $res;
    }

    /**
     * 过滤数组
     * @param type $array
     * @return type
     */
    public function getArrayValue($array) {
        $searchAry = array();
        foreach ($array as $k => $v) {
            if ($v != "" || $v == "0") {
                $searchAry[$k] = $v;
            }
        }
        return $searchAry;
    }

    /**
     * getfourStr() 获取字符串
     * @param type $len
     * @param type $uSalt
     * @return string
     */
    function getfourStr($len, $uSalt = '') {
        $chars_array = array(
            "0", "1", "2", "3", "4", "5", "6", "7", "8", "9"
        );
        if ($uSalt) {
            $chars_array = "";
            $chars_array = array(
                "0", "1", "2", "3", "4", "5", "6", "7", "8", "9",
                "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
                "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",
                "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",
                "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",
                "S", "T", "U", "V", "W", "X", "Y", "Z",
            );
        }
        $charsLen = count($chars_array) - 1;

        $outStr = "";
        for ($i = 0; $i < $len; $i++) {
            $outStr .= $chars_array[mt_rand(0, $charsLen)];
        }
        return $outStr;
    }

    /*
     * @author  wuyongpan
     * @date    2017-05-02 PM
     * @version V1.0 
     * @decripton 生成用户Token
     */

    public function getMemberSuccessLoginToken($mID, $uName, $uSalt) {
        $uToken = strtoupper(md5(md5(trim($mID)) . md5(trim($uName)) . md5(trim($uSalt)) . time()));
        $this->updateOrInsertMemberTokenByUid($mID, $uToken);
        return $uToken;
    }

    /*
     * @author  wuyongpan
     * @date    2017-05-02 PM
     * @version V1.0 
     * @decripton 验证用户Token有效时间
     */

    public function getMemberTokenInfo() {
        if ($_POST) {
            $mToken = $this->input->post('mToken', true);
            $mInfo = $this->SpeToken->getTokenInfoByMemberID(array("tValue" => $mToken));
            if ($mInfo) {
                $tTime = $this->diffDateTime($mInfo['tTime'], time());
                if ($tTime['day'] > 30) {
                    return false;
                } else {
                    $uInfo = $this->SpeToken->getMemeberInfoByWhere(array('mId' => $mInfo['mId'], 'mStatus' => 1));
                    return $uInfo;
                }
            } else {
                return false;
            }
        }
    }

    /*
     * @author  wuyongpan
     * @date    2017-05-02 PM
     * @version V1.0 
     * @decripton 更新用户Token有效时间
     */

    public function updateOrInsertMemberTokenByUid($mID, $uToken) {
        $tInfo = $this->SpeToken->getTokenInfoByMemberID(array('mId' => $mID));
        $tRet = 0;
        if ($tInfo) {
            $tData = array(
                'tValue' => $uToken,
                'tTime' => time()
            );
            $tRet = $this->SpeToken->updateMemberTokenInfoByUid($mID, $tData);
        } else {
            $tData = array(
                'tValue' => $uToken,
                'tTime' => time(),
                'mId' => $mID,
                'tAddip' => $this->input->ip_address()
            );
            $tRet = $this->SpeToken->insertMemberToken($tData);
        }
        return $tRet;
    }

}

class Settled_Controller extends Api_Controller {

    var $imgUrl = "http://vpn.jingtaomart.com";

    public function __construct() {
        parent::__construct();
         $this->load->model("api/settled/Sel_Shops_model", "SelShop");
    }

    /*
     * @author  wuyongpan
     * @date    2017-09-12 PM
     * @version V1.0 
     * @decripton 验证用户Token有效时间
     */

    public function getSettledTokenInfo() {
        if ($_POST) {
            $sToken = $this->input->post('sToken', true);
            $sInfo = $this->SelShop->getSettledTokenInfoByStoken($sToken);
            if ($sInfo) {
                $tTime = $this->diffDateTime($sInfo['sTokenTime'], time());
                if ($tTime['day'] > 30) {
                    return false;
                } else {
                    $sInfo = $this->SelShop->getShopInfoByShopSid($sInfo['sId']);
                    return $sInfo;
                }
            } else {
                return false;
            }
        }
    }

}
