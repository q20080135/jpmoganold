<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Article extends ADMIN_Controller
{
    public $filters = array();

    public function __construct()
    {
        parent::__construct();
        $this->filters = json_decode('{
            "aID" : {"name" : "文章ID"}
            ,"aTitle" : {"name" : "标题","db" : "spe_articles.aTitle %%"}
            ,"uRealName" : {"name" : "作者"}
        }', true);
    }
    
    public function index()
    {
        $this->articleList();
    }
    /**
     * 列表
     * @return [view] [列表页面]
     */
    public function articleList()
    {
        // dump(json_encode(array_keys($this->filters)));
        $data['filters'] = $this->filters;
        $this->load->view('jt_admin/article/article_list', $data);
    }


    /**
     * 返回列表ajax数据
     * @return [json] [列表数据]
     */
    public function listData()
    {
        $this->load->library('AdminList');  //使用方法参照05_库文档
        $list = new AdminList();
        
        $list->setFilters($this->filters);

        $list->setOrder('aID desc');
        $list->setModel('jt_admin/article');

        $data = $list->getListData();
        echo json_encode($data);
        exit;
    }


    public function updateHot()
    {
        $this->load->library('AdminCrud');
        $u = new AdminCrud();
        
        $where['aID'] = form('id');
        $data['aIsHot'] = form('val');

        $u->updateCol('jt_admin/article', $data, $where);
    }

    public function updateView()
    {
        $this->load->library('AdminCrud');
        $u = new AdminCrud();
        
        $where['aID'] = form('id');
        $data['aIsView'] = boolval(form('val'));

        $u->updateCol('jt_admin/article', $data, $where);
    }

    public function updateRecom()
    {
        $this->load->library('AdminCrud');
        $u = new AdminCrud();
        
        $where['aID'] = form('id');
        $data['aIsRecommend'] = form('val');

        $u->updateCol('jt_admin/article', $data, $where);
    }

    public function detail()
    {
        $this->load->library('AdminCrud');
        $r = new AdminCrud();
        $id = urlget('id');
        $data = $this->model('jt_admin/article')->get_row('*', array(
                'aID' => $id
            ));
        $sql = "SELECT `cID`,`cName`,`cParentID` FROM spe_classify WHERE `cType` = 7 AND `cDel` = 0 ORDER BY `cSort` ASC";
        $que = $this->db->query($sql);
        $ret = $que->result_array();
        $data['aType'] = $ret;
        $this->load->view('jt_admin/article/article_detail', $data);
    }

    public function article_add()
    {
        $sql = "SELECT `cID`,`cName`,`cParentID` FROM spe_classify WHERE `cType` = 7 AND `cDel` = 0 ORDER BY `cSort` ASC";
        $que = $this->db->query($sql);
        $ret = $que->result_array();
        $data['aType'] = $ret;

        $this->load->view('/jt_admin/article/article_add',$data);
    }


    public function add_save()
    {
    
        if (form('aTitle')) {
            
        
            $this->load->library('AdminCrud');
            $u = new AdminCrud();
            $u->setData('aTitle');
            $u->setData('cID');
            $u->setData('aDescription');
            $u->setData('aSeoDesc');
            $u->setData('aSeoKeywork');
            $u->setData('aAddtime');
            $u->update_item['aContent'] = $_POST['aContent'];
            $u->update_item['uId'] = $this->admin_info['uID'];
            $this->load->helper('file');
            $file = saveBase64Img2($_POST['aImg'],'',$mime = "png",$max_size = 2);



            if ($file) 
            {
                $u->update_item['aImg'] = $file;
            }
            //$u->update_item['aAddtime'] = date("Y-m-d H-i-s");
            
            $u->isnullSetLogTitle('添加文章。');
    
            // dump($u->update_item);
            // 表单验证规则在 config/form_validation.php 文件
            if ($u->validationAndWriteLog(null)) {
                $result = $this->model('jt_admin/article')->insert($u->update_item);
                 
                // $json_result['status'] = $result;
                if ($result) {
                    $id = $this->db->insert_id();

                    $json_result['status'] = true;
                    $json_result['msg'] = "添加文章成功。";
                } else {
                    $json_result['msg'] = '操作数据库时出错';
                }
    
            }else{
                $json_result['status'] = false;
                $json_result['msg'] = '验证不通过。';
            }
    
        } else {
            $json_result['status'] = false;
            $json_result['msg'] = '文章名不能为空';
        }
    
        die(json_encode($json_result));
    }


    public function update_save()
    {
        $log_item = array();
        $uID = form('id');
        $update_item = array(
            'aID' => $uID
        );
        
        $where = array(
            'aID' => $uID
        );
        if (form('id')) {
            if (form('aTitle'))
                $update_item['aTitle'] = form('aTitle');
            
            if (form('ori_aTitle'))
                $log_item['ori_aTitle'] = form('ori_aTitle');
            

            if (form('cID'))
                $update_item['cID'] = form('cID');
            
            if (form('ori_cID'))
                $log_item['ori_cID'] = form('ori_cID');


            if (form('aDescription'))
                $update_item['aDescription'] = form('aDescription');
            
            if (form('ori_aDescription'))
                $log_item['ori_aDescription'] = form('ori_aDescription');



            if (form('aContent'))
                $update_item['aContent'] = $_POST['aContent'];
            
            if (form('ori_aContent'))
                $log_item['ori_aContent'] = form('ori_aContent');


            if (form('aSeoDesc'))
                $update_item['aSeoDesc'] = $_POST['aSeoDesc'];
            
            if (form('ori_aSeoDesc'))
                $log_item['ori_aSeoDesc'] = form('ori_aSeoDesc');

            if (form('aSeoKeywork'))
                $update_item['aSeoKeywork'] = $_POST['aSeoKeywork'];
            
            if (form('ori_aSeoKeywork'))
                $log_item['ori_aSeoKeywork'] = form('ori_aSeoKeywork');


            if (form('aAddtime'))
                $update_item['aAddtime'] = $_POST['aAddtime'];
            
            if (form('ori_aAddtime'))
                $log_item['ori_aAddtime'] = form('ori_aAddtime');



            if(form('aImg')){
                $this->load->helper('file');
                $file = saveBase64Img2($_POST['aImg'],'',$mime = "png",$max_size = 2);
                if ($file) 
                {
                    $update_item['aImg'] = $file;
                    $log_item['ori_aImg'] = form('ori_aImg');
                }
            }

           

            $admin_log_msg[] = '更改文章信息';
        }
        $admin_log_msg = implode(', ', $admin_log_msg);
        // 先记录操作内容
        $result = $this->model('jt_admin/admin_logs')->log($admin_log_msg, array_merge($update_item, $log_item), $uID);
        
        if ($result) {
            
            $result2 = $this->db->update('spe_articles', $update_item, $where);
            $json_result['status'] = $result2;
            if (! $result2){
                $json_result['status'] = false;
                $json_result['msg'] = '操作数据库时出错1';
            }else{
                $json_result['status'] = true;
                $json_result['msg'] = '修改成功。';
            }
                
        } else {
            
            $json_result['status'] = false;
            $json_result['msg'] = '操作数据库时出错2';
        }
        
        echo json_encode($json_result);
    }


    public function del_article()
    {
        $id = form('id');
        if ($id) {
            $data = $this->model('jt_admin/article')->get_row('*', array(
                'bID' => $id
            ));
    
            if (! $data) {
                $json_result['status'] = false;
                $json_result['msg'] = '未查找到文章信息。';
            } else {
                $this->load->library('AdminCrud');
                $u = new AdminCrud();
                $u->isnullSetLogTitle('文章信息删除。');
                // 表单验证规则在 config/form_validation.php 文件
                if ($u->validationAndWriteLog($id)) {
                    $result = $this->model('jt_admin/article')->logic_del($id);
                    if ($result) {
                        $json_result['status'] = true;
                        $json_result['msg'] = '文章信息删除成功。';
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

}
