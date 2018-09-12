<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * banner控制类
 * @author 齐福
 * 创建时间 ： 2017年10月9日上午10:06:11
 */
class Banner extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 转向列表页
     *
     * @return [view] [列表页面]
     */
    public function banner_list()
    {
        $this->load->view('/jt_admin/banner/banner_list');
    }

    /**
     * 返回管理员列表ajax数据
     *
     * @return [json] [管理员列表数据]
     */
    public function list_data()
    {
        $limit = form('length');
        if (! $limit || $limit > 100)
            $limit = 10;
        
        $offset = form('start');
        
        $filter = null;
        if (data_form('bName'))
            $filter['bName %%'] = data_form('bName');
        if (data_form('bType'))
            $filter['bType'] = data_form('bType');
        $order = 'bID desc';
        if(form('order')){
            $ordername = $_POST['columns'][$_POST['order'][0]['column']]['data'];
            $ordervalue = $_POST['order'][0]['dir'];
            $order = ''.$ordername.' '.$ordervalue;
        }
        $lsdata = $this->model('jt_admin/banner')->get_list("*",
        $filter, null , $order, $limit, $offset);
        


        $data['data'] = $lsdata;

        $data['recordsTotal'] = $this->model('jt_admin/banner')->get_count($filter);
        $data['recordsFiltered'] = $this->model('jt_admin/banner')->get_count($filter);
        echo json_encode($data);
        exit();
    }
    /**
     * 转向到banner添加
     */
    public function banner_add(){
        $order = 'gpID';
        $join = array(
                    'spe_goods g'=>'gID = g.gID'
                );
        $where = array(
                    'gpStartTime <'=>date('Y-m-d H:i:s',time()),
                    'gpEndTime >'=>date('Y-m-d H:i:s',time()),
                );
        $arr['gparr'] = $this->model('jt_admin/group_purchase')->get_list("gpID,g.gName,gpStartTime,gpEndTime,g.gID",$where, $join, $order,null, null);
        $this->load->view('/jt_admin/banner/banner_add',$arr);
    }
    
    /**
     * 保存信息
     */
    public function add_save()
    {

        
        $add_item['bName'] = form('bName');
        $img = form('bImg');
        //加载helper
        $this->load->helper('file');
        // 把图片上传到七牛
        $file_name = uploadQiniuBase64Img($img,'banner');

        $this->load->library('AdminCrud');
        $u = new AdminCrud();
        $u->setData('bStartTime');
        $u->setData('bEndTime');
        $u->setData('bName');
        $u->setData('bType');
        $u->setData('bActivityID');
        $u->update_item['bOrder'] = intval($this->input->post('bOrder', true));
        if($u->update_item['bType']==0){
            $u->update_item['bValueID'] = form('addcp');
        }else if($u->update_item['bType']==1){
            $u->update_item['bValueID'] = form('adddp');
        }else{
            $u->update_item['bType'] = form('bTypeActivity');
            $u->update_item['bValueID'] = form('bActivities');
        }
        $u->update_item['bImg']=$file_name;
        $u->isnullSetLogTitle('添加banner。');

        // 表单验证规则在 config/form_validation.php 文件
        if ($u->validationAndWriteLog(null)) {
            $result = $this->model('jt_admin/banner')->insert($u->update_item);
            if ($result) {
                $json_result['status'] = true;
                $json_result['msg'] = "创建banner成功。";
            } else {
                $json_result['msg'] = '操作数据库时出错';
            }

        }else{
            $json_result['status'] = false;
            $json_result['msg'] = '验证不通过。';
        }

        die(json_encode($json_result));
    }
    
    
    /**
     * 删除banner信息
     */
    public function del_banner()
    {
        $id = form('id');
        if ($id) {
            $data = $this->model('jt_admin/banner')->get_row('*', array(
                'bID' => $id
            ));
    
            if (! $data) {
                $json_result['status'] = false;
                $json_result['msg'] = '未查找到banner信息。';
            } else {
                $this->load->library('AdminCrud');
                $u = new AdminCrud();
                $u->isnullSetLogTitle('banner信息删除。');
                // 表单验证规则在 config/form_validation.php 文件
                if ($u->validationAndWriteLog($id)) {
                    $result = $this->model('jt_admin/banner')->logic_del($id);
                    if ($result) {
                        $json_result['status'] = true;
                        $json_result['msg'] = 'banner信息删除成功。';
                    } else {
                        $json_result['msg'] = '操作数据库时出错';
                    }
    
                }else{
                    $json_result['status'] = false;
                    $json_result['msg'] = '验证不通过。';
                }
    
    
    
            }
        } else {
            $json_result['status'] = false;
            $json_result['msg'] = 'ID有误';
        }
        echo json_encode($json_result);
    }
    
    
    /**
     * 转向banner详情页面
     */
    public function banner_detail()
    {
        $id = urlget('id');
    
        if ($id) {
            $data = $this->model('jt_admin/banner')->get_row('*', array(
                'bID' => $id
            ));
            
            if (! $data){
                exit('无效id<a href="javascript:history.back(-1);">返回</a>');
            }else{
                if($data['bType']==0){
                    $data['vdata'] = $this->model('jt_admin/product')->get_row("gID,gName",array(
                    'gID'=>$data['bValueID']
                    ));    
                }else{
                    $data['vdata'] = $this->model('jt_admin/shop')->get_row("sId,sName",array(
                    'sId'=>$data['bValueID']
                    ));    
                }
                
            }


        $type = $data['bType'];
        if($type == 2){
            $order = 'gpID';
            $join = array(
                        'spe_goods g'=>'gID = g.gID'
                    );
            $where = array(
                        'gpStartTime <'=>date('Y-m-d H:i:s',time()),
                        'gpEndTime >'=>date('Y-m-d H:i:s',time()),
                    );
            $this->db->where_in('gpStatus',array(0,1));
            $data['gparr'] = $this->model('jt_admin/group_purchase')->get_list("gpID,g.gName,gpStartTime,gpEndTime,g.gID",$where, $join, $order,null, null);
        }else if ($type == 3){
            $order = 'spe_panicbuy.pbID';
            $where = array(
                        'pbStartTime <'=>date('Y-m-d H:i:s',time()),
                        'pbEndTime >'=>date('Y-m-d H:i:s',time()),
                    );
            $join = array(
                        'spe_panicbuy_goods'=>'spe_panicbuy.pbID = spe_panicbuy_goods.pbID',
                        'spe_goods'=>'spe_goods.gID = spe_panicbuy_goods.gID'
                    );
            $data['gparr'] = $this->model('jt_admin/panicbuy')->get_list("spe_panicbuy.pbID,spe_goods.gID,spe_panicbuy.pbName,spe_panicbuy.pbStartTime,spe_panicbuy.pbEndTime,spe_goods.gName",$where,$join, $order,null, null);
        }else if ($type == 4){
            $order = 'taID';
            $where = array(
                        'taStartTime <'=>date('Y-m-d H:i:s',time()),
                        'taEndTime >'=>date('Y-m-d H:i:s',time()),
                    );
            $this->db->where_in('taStatus',array(0,1));
            $data['gparr']= $this->model('jt_admin/thematic_activities')->get_list("taID,taTitle,taStartTime,taEndTime",$where,null, $order,null, null);
        }
        $this->load->view('/jt_admin/banner/banner_detail',$data);
        } else {
            echo 'ID有误 <a href="javascript:history.back(-1);">返回</a>';
        }
    }
    
    /**
     * 保存更改信息
     *
     * @return json 返回成功状态和错误信息
     */
    public function update_save()
    {

            $bID = intval($_POST['bID']);     


            


            $this->load->library('AdminCrud');
            $u = new AdminCrud();
            $u->setData('bName');
            $u->setData('bStartTime');
            $u->setData('bEndTime');
            $u->setData('bID');
            $u->setData('bType');
            $u->setData('bActivityID');
            $u->update_item['bOrder'] = intval($this->input->post('bOrder', true));
            if($u->update_item['bType']==0){
                $u->update_item['bValueID'] = form('addcp');
            }else if($u->update_item['bType']==1){
                $u->update_item['bValueID'] = form('adddp');
            }else{
                $u->update_item['bType'] = form('bTypeActivity');
                $u->update_item['bValueID'] = form('bActivities');
            }
            $img = form('bImg');
            $this->load->helper('file');
            if($img!=''){
                $file_name = uploadQiniuBase64Img($img,'banner');
                $u->update_item['bImg']=$file_name;
            }
            $u->isnullSetLogTitle('编辑banner。');

            // 表单验证规则在 config/form_validation.php 文件
            if ($u->validationAndWriteLog(null)) {
                $result = $this->model('jt_admin/banner')->update($u->update_item);
                if ($result) {
                    if($img!=''&&isset($_POST['ori_bImg'])){
                     $ori_bImg = form('ori_bImg');
                     $rd =    removeQiniuFile($ori_bImg);
                    }
                    $json_result['status'] = true;
                    $json_result['msg'] = "编辑banner成功。";
                } else {
                    $json_result['msg'] = '操作数据库时出错';
                }
    
            }else{
                $json_result['status'] = false;
                $json_result['msg'] = '验证不通过。';
            }

    
        die(json_encode($json_result));
    }
    
    /**
     * 获取搜索产品
     */
    public function get_adtype_select_data(){
        $text = form('text');

            $order = 'gID desc';
            $filter = null;
            if($text){
                $filter['gName %%'] = $text;
            }

            $arr = $this->model('jt_admin/product')->get_list("gID,gName,gThumbPic,gPrices,gDiscountPrice",$filter, null, $order,null, null);
            die(json_encode($arr));

    }

    /**
     * 获取搜索店铺
     */
    public function get_shop_select_data(){
        $text = form('text');

            $order = 'sId desc';
            $filter = null;
            if($text){
                $filter['sName %%'] = $text;
            }

            $arr = $this->model('jt_admin/shop')->get_list("sId,sName",$filter, null, $order,null, null);
            die(json_encode($arr));

    }

    /**
     * 更改banner状态
     */
    public function change_status()
    {
        $id = form('id');
        if ($id) {
            $data = $this->model('jt_admin/banner')->get_row('*', array(
                'bID' => $id
            ));
    
            if (! $data) {
                $json_result['status'] = false;
                $json_result['msg'] = '未查找到banner信息。';
            } else {
                $this->load->library('AdminCrud');
                $u = new AdminCrud();
                $u->isnullSetLogTitle('更改banner状态。');
                // 表单验证规则在 config/form_validation.php 文件
                if ($u->validationAndWriteLog($id)) {
                    $result = $this->model('jt_admin/banner')->change_status($id,form('status'));
                    if ($result) {
                        $json_result['status'] = true;
                        $json_result['msg'] = '更改banner状态成功。';
                    } else {
                        $json_result['msg'] = '操作数据库时出错';
                    }
    
                }else{
                    $json_result['status'] = false;
                    $json_result['msg'] = '验证不通过。';
                }
    
    
    
            }
        } else {
            $json_result['status'] = false;
            $json_result['msg'] = 'ID有误';
        }
        echo json_encode($json_result);
    }

    /**
     * 修改顺序
     */
    public function bOrder_change() {
        $id = form('id');
        if ($id) {
            $where = array(
                'bID' => $id
            );
            $log_item['ori_bOrder'] = form('lval');
            $update_item['bOrder'] = intval(form('val'));
            if(!is_int($update_item['bOrder']))//当不为整数时
            {
                $json_result['status'] = false;
                $json_result['msg'] = '顺序必须是整数。';
                echo json_encode($json_result);
                die;
            }
            $query = $this->db->update('spe_banner', $update_item,$where);
            // 先记录操作内容
            $admin_log_msg = "修改banner顺序。";
            
            $result = $this->model('jt_admin/admin_logs')->log($admin_log_msg, array_merge($update_item, $log_item), $id);
            if ($result) {
                $json_result['status'] = true;
                $json_result['msg'] = '修改banner顺序成功！';
            } else {
            
                $json_result['status'] = false;
                $json_result['msg'] = '操作数据库时出错';
            }
        } else {
            $json_result['status'] = false;
            $json_result['msg'] = 'ID有误';
        }

        echo json_encode($json_result);
    }

    /**
     * 后去活动的数据
     */
    public function get_activity_select_data(){
        $type = form('type');
        if($type == 2){
            $order = 'gpID';
            $join = array(
                        'spe_goods g'=>'gID = g.gID'
                    );
            $where = array(
                        'gpStartTime <'=>date('Y-m-d H:i:s',time()),
                        'gpEndTime >'=>date('Y-m-d H:i:s',time()),
                    );
            $this->db->where_in('gpStatus',array(0,1));
            $arr = $this->model('jt_admin/group_purchase')->get_list("gpID,g.gName,gpStartTime,gpEndTime",$where, $join, $order,null, null);
            die(json_encode($arr));
        }else if ($type == 3){
            $order = 'spe_panicbuy.pbID';
            $where = array(
                        'pbStartTime <'=>date('Y-m-d H:i:s',time()),
                        'pbEndTime >'=>date('Y-m-d H:i:s',time()),
                    );
            $join = array(
                        'spe_panicbuy_goods'=>'spe_panicbuy.pbID = spe_panicbuy_goods.pbID',
                        'spe_goods'=>'spe_goods.gID = spe_panicbuy_goods.gID'
                    );
            $arr = $this->model('jt_admin/panicbuy')->get_list("spe_goods.gID,spe_panicbuy.pbID,spe_panicbuy.pbName,spe_panicbuy.pbStartTime,spe_panicbuy.pbEndTime,spe_goods.gName",$where,$join, $order,null, null);
            die(json_encode($arr));
        }else if ($type == 4){
            $order = 'spe_thematic_activities.taID';
            $where = array(
                        'taStartTime <'=>date('Y-m-d H:i:s',time()),
                        'taEndTime >'=>date('Y-m-d H:i:s',time()),
                    );
            $this->db->where_in('taStatus',array(0,1));
            $join = array(
                'spe_thematic_activities_price'=>'spe_thematic_activities.taID = spe_thematic_activities_price.taID',
                'spe_goods'=>'spe_goods.gID = spe_thematic_activities_price.gID'
            );
            $arr= $this->model('jt_admin/thematic_activities')->get_list("taID,taTitle,taStartTime,taEndTime,spe_goods.gName,spe_goods.gID",$where,$join, $order,null, null);
            die(json_encode($arr));
        }
        
    }
    
}
