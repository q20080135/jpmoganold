<?php  defined('BASEPATH') or exit('No direct script access allowed');

class Product extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
    }
    /**
    *修改入驻商产品
    */
    public function uBusProduct($id,$pid){
            //这里没加权限回头记得加
            $sql = "SELECT * FROM `spe_shops` AS ss LEFT JOIN `spe_shop_grade` AS ssg ON ssg.sgID = ss.sLevel WHERE ss.sId = '{$id}'";
            $que = $this->db->query($sql);
            $_SESSION['bus_info'] = $que->row_array();
            $_SESSION['who'] = 'superMan';
            //echo '<script>window.location.href="/busAdmin/Product/fadd";</script>';
            echo '<script>window.location.href="/busAdmin/Product/fedit/'.$pid.'?who=superMan";</script>';
    }
    public function index()
    {
        $this->productList();
    }

    /**
     * 产品列表
     * @return [view] [产品列表页面]
     */
    public function productList()
    {
        $data = null;
        // $where  = array('id'=>'set','asdf'=>'avvv');
        // $str =  $this->db->get_where($where);·
        // dump($str);
        //商品分类
        $sql = "SELECT `cID`,`cName`,`cParentID` FROM spe_classify WHERE `cType` = 0 AND `cDel` = 0 ORDER BY `cSort` ASC";
        $que = $this->db->query($sql);
        $ret = $que->result_array();
        $crs = tree_array($ret, 'cID', 'cParentID');
        $data['classify'] = $this->get_classify_list($crs);
        $data['classify'] = str_replace("请选择","--请选择分类--",$data['classify']);

        $data['grade'] = $this->model('jt_admin/grade')->get_select();

        $arr1 = $this->model('jt_admin/region')->get_region_list(1);
        $arr2 = $this->model('jt_admin/region')->get_region_list($arr1[0]['region_id']);
        
        $arr1 = array_merge(array(array("region_id"=>"","parent_id"=>"","region_name"=>"--请选择省--")),$arr1);
        $arr2 = array_merge(array(array("region_id"=>"","parent_id"=>"","region_name"=>"--请选择市--")),$arr2);
        $narr1 = $this->set_select_option($arr1);
        $narr2 = $this->set_select_option($arr2);
        //$narr1['range'] =  array_merge("value"=>"0","name"=>"--请选择省--"),$narr1['range']);
        $data['sProvince'] =$narr1;

        $data['sCity'] = $narr2;
        $this->load->view('jt_admin/product/productList', $data);
    }
public function ceshi(){
     $this->load->view('jt_admin/product/ceshi');
}
    /**
     * 产品列表
     * @return [view] [产品列表页面]
     */
    public function productListNew()
    {
        $data = null;
        // $where  = array('id'=>'set','asdf'=>'avvv');
        // $str =  $this->db->get_where($where);·
        // dump($str);
        //商品分类
        $sql = "SELECT `cID`,`cName`,`cParentID` FROM spe_classify WHERE `cType` = 0 AND `cDel` = 0 ORDER BY `cSort` ASC";
        $que = $this->db->query($sql);
        $ret = $que->result_array();
        $crs = tree_array($ret, 'cID', 'cParentID');
        $data['classify'] = $this->get_classify_list($crs);
        $data['classify'] = str_replace("请选择","--请选择分类--",$data['classify']);
        $this->load->view('jt_admin/product/productListNew', $data);
    }

    /**
     * 返回产品列表ajax数据
     * @return [json] [产品列表数据]
     */
    public function listData()
    {
        
        $filter = null;
        $offset = 0;
        
        $filter['gDel'] = 0;
        $total_filter = $filter;

        if (data_form('gID')) {
            $filter['gID'] = data_form('gID');
        }
        if (data_form('gName')) {
            $filter['gName %%'] = data_form('gName');
        }
        if (data_form('gAuditing') !='') {
            $filter['gAuditing'] = data_form('gAuditing');
        }
        
        if (data_form('cID') !='') {
            $filter['cID'] = data_form('cID');
        }
        if (data_form('sLevel') !='') {
            $filter['p.sLevel'] = data_form('sLevel');
        }
        if (data_form('province') !='') {
            $filter['gProvince'] = data_form('province');
        }
        if (data_form('city') !='') {
            $filter['pCity'] = data_form('city');
        }
        if (data_form('isStock') !='') {
            if(data_form('isStock')==1){
                $this->db->where('(w.whNum != 0 or w.whNum IS not null)');
            }else{
                $this->db->where('(w.whNum = 0 or w.whNum IS null)');
            }
        }
        if (data_form('sName') !='') {
            $filter['p.sName %%'] = data_form('sName');
        }
        if (data_form('sShopName') !='') {
            $filter['p.sShopName %%'] = data_form('sShopName');
        }
        if (data_form('gShelves') !='') {
            $filter['gShelves'] = data_form('gShelves');
        }
        if (data_form('gIsLikeRecomend') !='') {
            $filter['gIsLikeRecomend'] = data_form('gIsLikeRecomend');
        }
        $offset = form('start');
        $limit = form('length');
        $order = 'gID desc&spe_goods.gID';
        if (!$limit || $limit > 100) {
            $limit  = 10;
        }
        // $data['data'] = $this->model('product')->get_list("*", $filter, array(), $order, $limit, $offset);
        $join = array(
            'spe_shops p' => 'sId = p.sId',
            'spe_classify c' => 'cID = c.cID',
            'spe_shop_grade sg' => 'p.sLevel = sg.sgID',
            'spe_region pr' => 'gProvince = pr.region_id',
            'spe_region cr' => 'pCity = cr.region_id',
            'spe_warehouse w' => 'gID = w.gID',
            
        );
        $data['data'] = $this->model('jt_admin/product')->getListData($filter, $order, $limit, $offset,$join);

        $data['recordsTotal'] = $this->model('jt_admin/product')->get_count($total_filter);
        if (data_form('isStock') !='') {
            if(data_form('isStock')==1){
                $this->db->where('(w.whNum != 0 or w.whNum IS not null)');
            }else{
                $this->db->where('(w.whNum = 0 or w.whNum IS null)');
            }
        }else{
            unset($join['spe_warehouse w']);
        }
        $data['recordsFiltered'] = $this->model('jt_admin/product')->get_count($filter,$join,'count(distinct `spe_goods`.`gID`)');
        echo json_encode($data);
        exit;
    }


    /**
     * 返回产品列表ajax数据
     * @return [json] [产品列表数据]
     */
    public function listDataNew()
    {
        
        $filter = null;
        $offset = 0;
        
        $filter['gDel'] = 0;
        $total_filter = $filter;

        if (data_form('gID')) {
            $filter['gID'] = data_form('gID');
        }
        if (data_form('gName')) {
            $filter['gName %%'] = data_form('gName');
        }
        if (data_form('gAuditing') !='') {
            $filter['gAuditing'] = data_form('gAuditing');
        }
        
        if (data_form('cID') !='') {
            $filter['cID'] = data_form('cID');
        }


        $offset = form('offset');
        $limit = form('limit');
        $order = form('order');
        $order = 'gID '.$order;
        if (!$limit || $limit > 100) {
            $limit  = 10;
        }
        // $data['data'] = $this->model('product')->get_list("*", $filter, array(), $order, $limit, $offset);
        $join = array(
            'spe_shops p' => 'sId = p.sId'
            , 'spe_classify c' => 'cID = c.cID',
        );
        $data['rows'] = $this->model('jt_admin/product')->getListData($filter, $order, $limit, $offset,$join);
        // dump_query();
       
       $data['offset'] = $offset;
       $data['limit'] = $limit;
       $data['order'] = $order;
        $data['total'] = $this->model('jt_admin/product')->get_count($total_filter);
        $data['recordsFiltered'] = $this->model('jt_admin/product')->get_count($filter);
        // $data['recordsFiltered'] = $data['recordsTotal'];
        // dump($data);

        echo json_encode($data);
        exit;
    }

 
    /**
     * 产品详情
     * @return [view] [产品详情]
     */
    public function detail()
    {
        $id = urlget('id');
        if ($id) {

            $data = $this->model('jt_admin/product')->getProductDetail($id);

            // dump($data);
            if (!$data) {
                exit('无效产品 <a href="javascript:history.back(-1);">返回</a>');
            }
            $data['id'] = $id;
            
            $data['gProvince'] = $this->model('jt_admin/region')->get_ssq_cn($data['gProvince']);
            $data['pCity'] = $this->model('jt_admin/region')->get_ssq_cn($data['pCity']);
            $data['pRegion'] = $this->model('jt_admin/region')->get_ssq_cn($data['pRegion']);
            $query = $this->db->query("select name from `spe_shop_classify` where scID = {$data['scID']}");
            $row = $query->row_array();
            $data['scName'] = '无分类';
            if($row){
                $data['scName'] = $row['name'];
            }

            $data['cName'] = null;
            $this->load->model('busModels/Spe_classify_Model','pclassify');
            $row =  $this->pclassify->getClassifyName($data['cID']);
            if($row){
                 $data['cName']=  $row;
            }
            
            $sql = "SELECT * FROM `spe_goods_attr` WHERE `gID` = " . $data['gID'];
            $que = $this->db->query($sql);
            $arow =  $que->row_array();
            $data['attr'] = $arow;
            
            $sql = "SELECT `pID`,`pUrl`,`isList` FROM `spe_goods_imgs` WHERE `gID` = " . $data['gID'];
            $que = $this->db->query($sql);

            $data['imgrs'] = $que->result_array();

            //商品分类
            $sql = "SELECT `cID`,`cName`,`cParentID` FROM spe_classify WHERE `cType` = 0 AND `cDel` = 0 ORDER BY `cSort` ASC";
            $que = $this->db->query($sql);
            $ret = $que->result_array();
            $crs = tree_array($ret, 'cID', 'cParentID');
            $data['classify'] = $this->get_classify_list($crs, $data['cID']);

            $this->load->view('jt_admin/product/productDetail', $data);
            

        } else {
            echo '产品ID有误 <a href="javascript:history.back(-1);">返回</a>';
        }
    }
    
    /**
     * 更改上架状态
     * @return [json] [返回json状态]
     */
    public function updateSj()
    {
        $this->load->library('AdminCrud');
        $u = new AdminCrud();
        
        $where['gID'] = form('id');
        $data['gShelves'] = form('val');
        $data['gshelvesTime'] = date("Y-m-d H-i-s");

        $u->updateCol('jt_admin/product', $data, $where);
    }

    /**
     * 更改推荐状态
     * @return [json] [返回json状态]
     */
    public function updateTj()
    {
        $this->load->library('AdminCrud');
        $u = new AdminCrud();
        
        $where['gID'] = form('id');
        $data['gIsRecomend'] = form('val');

        $u->updateCol('jt_admin/product', $data, $where);
    }

    /**
     * 更改新品状态
     * @return [json] [返回json状态]
     */
    public function updateNew()
    {
        $this->load->library('AdminCrud');
        $u = new AdminCrud();
        
        $where['gID'] = form('id');
        $data['gIsNew'] = form('val');

        $u->updateCol('jt_admin/product', $data, $where);
    }

    /**
     * 更改热门状态
     * @return [json] [返回json状态]
     */
    public function updateHot()
    {
        $this->load->library('AdminCrud');
        $u = new AdminCrud();
        
        $where['gID'] = form('id');
        $data['gIsHots'] = form('val');

        $u->updateCol('jt_admin/product', $data, $where);
    }
    
    /**
     * 更改热门状态
     * @return [json] [返回json状态]
     */
    public function updateAuditing()
    {
        $this->load->library('AdminCrud');
        $u = new AdminCrud();
        
        $where['gID'] = form('id');
        $data['gAuditing'] = form('val');
        $data['gAuditingTime'] = date("Y-m-d H-i-s");

        $u->updateCol('jt_admin/product', $data, $where);
    }

    /**
     * 更改当日到货
     * @return [json] [返回json状态]
     */
    public function updateOneDay()
    {
        $this->load->library('AdminCrud');
        $u = new AdminCrud();
        
        $where['gID'] = form('id');
        $data['gIsOneDay'] = form('val');

        $u->updateCol('jt_admin/product', $data, $where);
    }

    /**
     * 地区信息管理列表
     * @return [view] [地区信息管理列表页面]
     */
    public function areaInfoList()
    {
        $data = null;

        $data['filters'] = json_decode('{
            "region_id" : {"name" : "地区ID"}
            ,"region_name" : {"name" : "地区名"}
        }', true);
        // $where  = array('id'=>'set','asdf'=>'avvv');
        // $str =  $this->db->get_where($where);·
        // dump($str);
        $this->load->view('jt_admin/product/areaInfoList', $data);
    }


    /**
     * 返回地区信息列表ajax数据
     * @return [json] [地区信息列表数据]
     */
    public function areaInfoListData()
    {
        
        $this->load->library('AdminList');  //使用方法参照05_库文档
        $list = new AdminList();

        $list->setFilter('region_id');
        $list->setFilter('region_type');
        $list->setWhere['region_type <>'] = '0';
        $list->setFilter('region_name', 'region_name %%');
        if (data_form('griInfo') == '1') {
            $list->filter['gri.griInfo !='] = null;
        } elseif (data_form('griInfo') == '2') {
            $list->filter['gri.griInfo'] = null;
        }
        if (data_form('griImg') == '1') {
            $list->filter['gri.griImg !='] = null;
        } elseif (data_form('griImg') == '2') {
            $list->filter['gri.griImg'] = null;
        }


        $list->setOrder('gri.griOrder desc, region_type');

        $join = array(
            'spe_goods_region_info gri' => 'spe_region.region_id = gri.region_id'
            );
        $list->setModel('jt_admin/region', $join);

        $data = $list->getListData('getAreaInfoListData');

        echo json_encode($data);
        exit;
    }

    public function areaInfoDetail()
    {
        $this->load->library('AdminCrud');
        $r = new AdminCrud();
        // dump(urlget('id'));
        $data = $r->getDetail(urlget('id'), 'jt_admin/region');
        // dump_query();
        // dump($data);
        $this->load->view('jt_admin/product/areaInfoDetail', $data);
    }

    public function updataRegionInfo()
    {
        $this->load->helper('file');
        $this->load->library('AdminCrud');
        $u = new AdminCrud();

        $u->setData('id', 'region_id');
        $u->setData('griOrder', 'griOrder');

        if (form('r_icon')) {
            $r_icon = uploadQiniuBase64Img(form('r_icon'), 'region/id_'.form('id'));
            if (gettype($r_icon) == 'string') {
                $u->update_item['griIcon'] = $r_icon;
            }
        }

        if (form('r_img')) {
            $r_img = uploadQiniuBase64Img(form('r_img'), 'region/id_'.form('id'));
            if (gettype($r_img) == 'string') {
                $u->update_item['griImg'] = $r_img;
            }
        }
        if(form('griOrder')){
            $u->update_item['griOrder'] = form('griOrder');
        }
        if(form('griExplain')){
            $u->update_item['griExplain'] = form('griExplain');
        }
        
        $u->setData('r_info', 'griInfo');
        $u->setData('griSpell', 'griSpell');
        

        $u->addLogTitle('添加/更新地区信息');
        // 表单验证规则在 config/form_validation.php 文件
        if ($u->validationAndWriteLog(form('id'))) {
            $result = $this->model('jt_admin/region')->updateRegionInfo($u->update_item);
            if ($result) {
                if (form('ori_r_icon')) {   //删除原来图片
                    removeQiniuFile(form('ori_r_icon'));
                }
                if (form('ori_r_img')) {   //删除原来图片
                    removeQiniuFile(form('ori_r_img'));
                }
                $json_result['status'] = true;
            } else {
                if (isset($u->update_item['griIcon'])) {   //删除刚刚上传图片
                    removeQiniuFile(form('ori_r_icon'));
                }
                if (isset($u->update_item['griImg'])) {   //删除刚刚上传图片
                    removeQiniuFile(form('ori_r_img'));
                }
                $json_result['status'] = false;
                $json_result['msg'] = '操作数据库时出错';
            }
        }

        echo json_encode($json_result);
        exit;
    }

    /**
     * 获取所有的商品分类列表(最大5级)
     * @param  $data     全部数据
     * @param  $selectid 默认选择项
     * @return 所有选项
     */
    public function get_classify_list($data, $selectid = 0)
    {
        $options = $selectid > 0 ? "" : "<option value=''>请选择</option>";
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
    public function update_product_info(){

        $this->load->library('AdminCrud');
        $u = new AdminCrud();
        
        $where['gID'] = form('id');
        $data['cID'] = form('productClassify');
        $data['gIntegral'] = intval($_POST['gIntegral'])*100;
        $data['gOrder'] = intval($_POST['gOrder']);
        $data['gIsLikeRecomend'] = intval($_POST['gIsLikeRecomend']);
        $id = form('id');
        if ($id) {
            $sql = "SELECT * FROM `spe_goods_attr` WHERE `gID` = " .form('id');
            $que = $this->db->query($sql);
            $arow =  $que->row_array();

            $pa= $arow['integralAttrs']!=''?unserialize($arow['integralAttrs']):'';
            $arr = unserialize($arow['chlidAtrrs']);
            $integral = $_POST['integral'];
            $gIntegral = $_POST['gIntegral'];
            foreach ($integral as $key=>$val){
                $str= array();
                $z = count($integral);
                $y = intval($key);
                foreach ($arr as $k=>$v){
                    $z = intval($z/count($v));
                    $str[$k] = intval($y/$z);
                    $y  = intval($y%$z);
                }
                $xb =$str;

                $lp = null;
                $jzb = "";
                $zb ="[";
                $yb = "]";
                $z = 0;
                foreach ($xb as $kx=>$vx){
                    $jzb .= "[".$vx."]";
                }
                eval('$pa'.$jzb." =$val*100;");
                $jfxb = implode(',', $str);
            }
            if (!$data) {
                $json_result['status'] = false;
                $json_result['msg'] = '无效产品';
                echo json_encode($json_result);
                exit;
            }
        
            $update_item['integralAttrs'] = serialize($pa);
            $query = $this->db->update('spe_goods_attr', $update_item,$where);
        } else {
            $json_result['status'] = false;
            $json_result['msg'] = '产品ID有误';
            echo json_encode($json_result);
            exit;
        }
        
        
        
        
        
        
        
        
        
        
        echo $u->updateCol('jt_admin/product', $data, $where);
    }
    
    /**
     * 修改顺序
     */
    public function order_change() {
        $id = form('id');
        if ($id) {
            $where = array(
                'region_id' => $id
            );
            $log_item['ori_griOrder'] = form('lval');
            $update_item['griOrder'] = intval(form('val'));
            if(!is_int($update_item['griOrder'])||$update_item['griOrder']<1)//当不为整数时
            {
                $json_result['status'] = false;
                $json_result['msg'] = '请输入正整数。';
                echo json_encode($json_result);
                die;
            }
            $query = $this->db->update('spe_goods_region_info', $update_item,$where);
            // 先记录操作内容
            $admin_log_msg = "修改地区顺序。";
    
            $result = $this->model('jt_admin/admin_logs')->log($admin_log_msg, array_merge($update_item, $log_item), $id);
            if ($result) {
                $json_result['status'] = true;
                $json_result['msg'] = '修改地区顺序成功！';
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
     * 将数据库的数据转换成html 转换格式数据
     * @param unknown $data
     * @param string $value
     * @return string
     */
    public function set_select_option($data,$value = null){
        foreach ($data as $key=>$val){
            $narr['range'][] = array('value'=>$val['region_id'],'name'=>$val['region_name']);
        }
        $narr['value'] = $value;
        return $narr;
    }
    /**
     * 逻辑删除指定商品
     */
    public function logic_del()
    {
        $id = form('id');
        if ($id) {
            $data = $this->model('jt_admin/product')->get_row('*', array(
                'gID' => $id
            ));
    
            if (! $data) {
                $json_result['status'] = false;
                $json_result['msg'] = '未查找到产品信息。';
            } else {
                $this->load->library('AdminCrud');
                $u = new AdminCrud();
                $u->isnullSetLogTitle('产品逻辑删除。');
                // 表单验证规则在 config/form_validation.php 文件
                if ($u->validationAndWriteLog($id)) {
                    $result = $this->model('jt_admin/product')->logic_del($id);
                    if ($result) {
                        $json_result['status'] = true;
                        $json_result['msg'] = '产品逻辑成功。';
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
     * 回收站产品列表
     * @return [view] [产品列表页面]
     */
    public function del_list()
    {
        $data = null;
        // $where  = array('id'=>'set','asdf'=>'avvv');
        // $str =  $this->db->get_where($where);·
        // dump($str);
        //商品分类
        $sql = "SELECT `cID`,`cName`,`cParentID` FROM spe_classify WHERE `cType` = 0 AND `cDel` = 0 ORDER BY `cSort` ASC";
        $que = $this->db->query($sql);
        $ret = $que->result_array();
        $crs = tree_array($ret, 'cID', 'cParentID');
        $data['classify'] = $this->get_classify_list($crs);
        $data['classify'] = str_replace("请选择","--请选择分类--",$data['classify']);

        $data['grade'] = $this->model('jt_admin/grade')->get_select();

        $arr1 = $this->model('jt_admin/region')->get_region_list(1);
        $arr2 = $this->model('jt_admin/region')->get_region_list($arr1[0]['region_id']);
        
        $arr1 = array_merge(array(array("region_id"=>"","parent_id"=>"","region_name"=>"--请选择省--")),$arr1);
        $arr2 = array_merge(array(array("region_id"=>"","parent_id"=>"","region_name"=>"--请选择市--")),$arr2);
        $narr1 = $this->set_select_option($arr1);
        $narr2 = $this->set_select_option($arr2);
        //$narr1['range'] =  array_merge("value"=>"0","name"=>"--请选择省--"),$narr1['range']);
        $data['sProvince'] =$narr1;

        $data['sCity'] = $narr2;
        $this->load->view('jt_admin/product/productDelList', $data);
    }

    /**
     * 返回回收站产品列表ajax数据
     * @return [json] [产品列表数据]
     */
    public function dellistData()
    {
        
        $filter = null;
        $offset = 0;
        
        $filter['gDel'] = 1;
        $total_filter = $filter;

        if (data_form('gID')) {
            $filter['gID'] = data_form('gID');
        }
        if (data_form('gName')) {
            $filter['gName %%'] = data_form('gName');
        }
        if (data_form('gAuditing') !='') {
            $filter['gAuditing'] = data_form('gAuditing');
        }
        
        if (data_form('cID') !='') {
            $filter['cID'] = data_form('cID');
        }
        if (data_form('sLevel') !='') {
            $filter['p.sLevel'] = data_form('sLevel');
        }
        if (data_form('province') !='') {
            $filter['gProvince'] = data_form('province');
        }
        if (data_form('city') !='') {
            $filter['pCity'] = data_form('city');
        }
        if (data_form('isStock') !='') {
            if(data_form('isStock')==1){
                $this->db->where('(w.whNum != 0 or w.whNum IS not null)');
            }else{
                $this->db->where('(w.whNum = 0 or w.whNum IS null)');
            }
        }
        $offset = form('start');
        $limit = form('length');
        $order = 'gID desc&spe_goods.gID';
        if (!$limit || $limit > 100) {
            $limit  = 10;
        }
        // $data['data'] = $this->model('product')->get_list("*", $filter, array(), $order, $limit, $offset);
        $join = array(
            'spe_shops p' => 'sId = p.sId',
            'spe_classify c' => 'cID = c.cID',
            'spe_shop_grade sg' => 'p.sLevel = sg.sgID',
            'spe_region pr' => 'gProvince = pr.region_id',
            'spe_region cr' => 'pCity = cr.region_id',
            'spe_warehouse w' => 'gID = w.gID',
            
        );
        $data['data'] = $this->model('jt_admin/product')->getListData($filter, $order, $limit, $offset,$join);

        $data['recordsTotal'] = $this->model('jt_admin/product')->get_count($total_filter);
        if (data_form('isStock') !='') {
            if(data_form('isStock')==1){
                $this->db->where('(w.whNum != 0 or w.whNum IS not null)');
            }else{
                $this->db->where('(w.whNum = 0 or w.whNum IS null)');
            }
        }else{
            unset($join['spe_warehouse w']);
        }
        $data['recordsFiltered'] = $this->model('jt_admin/product')->get_count($filter,$join,'count(distinct `spe_goods`.`gID`)');
        echo json_encode($data);
        exit;
    }
    /**
     * 恢复指定商品
     */
    public function recovery()
    {
        $id = form('id');
        if ($id) {
            $data = $this->model('jt_admin/product')->get_row('*', array(
                'gID' => $id
            ));
    
            if (! $data) {
                $json_result['status'] = false;
                $json_result['msg'] = '未查找到产品信息。';
            } else {
                $this->load->library('AdminCrud');
                $u = new AdminCrud();
                $u->isnullSetLogTitle('产品恢复。');
                // 表单验证规则在 config/form_validation.php 文件
                if ($u->validationAndWriteLog($id)) {
                    $result = $this->model('jt_admin/product')->recovery($id);
                    if ($result) {
                        $json_result['status'] = true;
                        $json_result['msg'] = '产品恢复。';
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
     * 更改猜你喜欢
     * @return [json] [返回json状态]
     */
    public function updategIsLikeRecomend()
    {
        $this->load->library('AdminCrud');
        $u = new AdminCrud();
        
        $where['gID'] = form('id');
        $data['gIsLikeRecomend'] = form('val');
        $data['gUpdateTime'] = date("Y-m-d H-i-s");
        $u->updateCol('jt_admin/product', $data, $where);
    }
    
}
