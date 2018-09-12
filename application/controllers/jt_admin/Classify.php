<?php  defined('BASEPATH') or exit('No direct script access allowed');

class Classify extends ADMIN_Controller
{
    public $classify = array(
            'product' => array('name'=>'产品分类', 'code'=>'0')
            ,'doc' => array('name'=>'文章分类', 'code'=>'1')
            ,'shop' => array('name'=>'商家分类', 'code'=>'2')
            ,'ad' => array('name'=>'广告分类', 'code'=>'3')
            ,'brand' => array('name'=>'品牌分类', 'code'=>'4')
            ,'express' => array('name'=>'快递分类', 'code'=>'5')
            ,'menu' => array('name'=>'菜单分类', 'code'=>'6')
            ,'doc' => array('name'=>'文章分类', 'code'=>'7')
        );
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->classifyList();
    }

    /**
     * 分类列表
     * @return [view] [分类列表]
     */
    public function classifyList()
    {
        $data = null;

        $join = array();

        $ctype = (urlget('ctype'))?urlget('ctype'):'product';
        $data['ctype'] = $this->classify[$ctype];
        $data['ctype_key'] = $ctype;

        $filds = 'cID as id';
        $filds .= ',cName as content';
        $filds .= ',cSort as order';
        $filds .= ',cParentID as parent';
        $filds .= ',cDepth as depth';
        $where['cType'] = $this->classify[$ctype]['code'];
        $where['cDel'] = 0;
        $order = 'cDepth asc, cSort asc';

        switch ($ctype) {
            case 'doc':
                $filds .= ',d.cdID as doc_id';
                $filds .= ',d.docType as doc_type';
                $filds .= ',d.docDesc as doc_desc';
                $filds .= ',d.isShow as doc_isshow';
                $join = array('spe_classify_doc d' => 'cID = d.cID');
                break;
        }

        $data['data'] = $this->model('jt_admin/classify')->get_list($filds, $where, $join, $order, 100, 0);

        // dump_query();
        // dump($data);

        $this->load->view('jt_admin/classify/classifyList', $data);
    }

    /**
     * 添加分类表单
     * @return [view] [分类列表]
     */
    public function addClassify()
    {
        $ctype = form('ctype');
        if ($ctype) {
            $data['depth'] = form('depth');
            $data['parent'] = form('parent');
            $data['sort'] = form('csort');
            $data['ctype_key'] = form('ctype');
            $data['parent_name'] = form('parent_name')?form('parent_name'):'顶层';
            $data['ctype'] = $this->classify[$ctype];

        } else {
            echo 'no ctype';
            exit();
        }

        switch ($ctype) {
            case 'doc':
                $view = 'jt_admin/classify/addDocClassify';
                break;
            
            default:
                $view = 'jt_admin/classify/addClassify';
                break;
        }


        $this->load->view($view, $data);
    }

    /**
     * 编辑分类表单
     * @return [view] [分类列表]
     */
    public function editClassify()
    {
        $ctype = form('ctype');
        if ($ctype) {
            $data = $this->model('jt_admin/classify_doc')->get_row('cdID,cdImg', array(
                'cID' => form('id')
            ));
            if(!$data){
                $data['cdImg'] = '';
            }
            $data['id'] = form('id');
            $data['content'] = form('content');
            $data['ctype'] = $this->classify[$ctype];
            $data['parent_name'] = form('parent_name')?form('parent_name'):'顶层';
        } else {
            echo 'no ctype';
            exit();
        }

        switch ($ctype) {
            case 'doc':
                $isshow = array('','');
                $isshow[form('doc_isshow')] = 'checked';

                $data['doc_id'] = form('doc_id');
                $data['doc_type'] = form('doc_type');
                $data['doc_desc'] = form('doc_desc');
                $data['isshow'] = $isshow;
                $view = 'jt_admin/classify/editDocClassify';
                break;
            default:
                $view = 'jt_admin/classify/editClassify';
                break;
        }

        $this->load->view($view, $data);
    }

    /**
     * 添加分类
     * @return [json] [添加分类处理结果]
     */
    public function addClassifyProc()
    {
        $this->load->library('AdminCrud');
        $u = new AdminCrud();
        $item = array();
       
        $u->setData('cname', 'cName');
        $u->setData('cdepth', 'cDepth', 1);
        $u->setData('cparent', 'cParentID', 0);
        $u->setData('csort', 'cSort', 1);
        $u->setData('ctype', 'cType');
        $u->update_item['cAddtime'] = date("Y-m-d H-i-s");
        // dump(form('ctype'));
        switch ($u->update_item['cType']) {
            case 7: //doc
                $u->setData('doc_type', 'docType');
                $u->setData('doc_desc', 'docDesc');
                $u->setData('doc_isshow', 'isShow', 0);
                break;
            case 0:
                $img = form('cdImg');
                //加载helper
                $this->load->helper('file');
                // 把图片上传到七牛
                $file_name = uploadQiniuBase64Img($img,'classify');
                $u->update_item['cdImg']=$file_name;
                break;
        }

        $u->isnullSetLogTitle('添加分类');

         // dump($u->update_item);
        // 表单验证规则在 config/form_validation.php 文件
        if ($u->validationAndWriteLog(null)) {
            // $json_result['status'] = $result;
            $result = $this->model('jt_admin/classify')->insertClassify($u->update_item);
            if ($result) {
                $id = $result['id'];
                $u->updateLogKey($id);


                switch ($u->update_item['cType']) {
                    case 7: //doc
                        $item['doc_type'] = $u->update_item['docType'];
                        $item['doc_desc'] = $u->update_item['docDesc'];
                        $item['doc_isshow'] = $u->update_item['isShow'];
                        $item['doc_id'] = $result['doc_id'];
                        break;
                }
                $item['id'] = $id;
                $item['content'] = $u->update_item['cName'];
                $item['depth'] = $u->update_item['cDepth'];
                $item['parent'] = $u->update_item['cParentID'];
                $json_result['status'] = true;
                $json_result['item'] = $item;
            } else {
                $json_result['msg'] = '操作数据库时出错';
            }
        }

        echo json_encode($json_result);
        exit;
    }

    /**
     * 编辑分类
     * @return [json] [编辑分类处理结果]
     */
    public function editClassifyProc()
    {

        $cid = form('cid');
        if (!$cid) {
            $json_result['msg'] = '没有cID';
            $json_result['status'] = false;
            echo json_encode($json_result);
            exit;
        }
        $this->load->library('AdminCrud');
        $u = new AdminCrud();
        $u->setData('cname', 'cName');
        $u->setData('ctype', 'cType');
        $where['cID'] = form('cid');
        if (isset($u->update_item['cType'])) {
            switch ($u->update_item['cType']) {
                case 7: //doc
                    $u->setData('doc_type', 'docType');
                    $u->setData('doc_desc', 'docDesc');
                    $u->setData('doc_isshow', 'isShow', 0);

                    $where['cdID'] = form('doc_id');
                    
                    $item['doc_id'] = $where['cdID'];
                    $item['doc_type'] = $u->update_item['docType'];
                    
                    if (isset($u->update_item['docDesc'])) {
                        $item['doc_desc'] = $u->update_item['docDesc'];
                    }
                    $item['doc_isshow'] = $u->update_item['isShow'];
                    // dump($item);
                    break;
                case 0:
                    $img = form('cdImg');
                    //加载helper
                    $this->load->helper('file');
                    // 把图片上传到七牛
                    $file_name = uploadQiniuBase64Img($img,'classify');
                    $u->update_item['cdImg']=$file_name;
                    $where['cdID'] = form('doc_id');
                    $item['cdImg'] = $file_name;
                    break;
            }
        }

        $u->isnullSetLogTitle('编辑分类');
        
         // dump($u->update_item);
        // 表单验证规则在 config/form_validation.php 文件
        if ($u->validationAndWriteLog($cid)) {
            $result = $this->model('jt_admin/classify')->updateClassify($u->update_item, $where);
        
            if ($result) {
                $item['id'] = $cid;
                $item['content'] = $u->update_item['cName'];
                $json_result['status'] = true;
                $json_result['item'] = $item;
            } else {
                $json_result['msg'] = '操作数据库时出错';
            }

            echo json_encode($json_result);
            exit;
        }
    }
    /**
     * 删除分类
     * @return [json] [删除分类处理结果]
     */
    public function deleteClassifyProc()
    {
        $ids = form('ids');
        if (!is_array($ids)) {
            $json_result['msg'] = '没有cID';
            $json_result['status'] = false;
            echo json_encode($json_result);
            exit;
        }

        $this->load->library('AdminCrud');
        $u = new AdminCrud();

        $where['cID'] = $ids;
        $where['cType'] = form('ctype');

        $u->isnullSetLogTitle('删除分类');
        
         // dump($u->update_item);
        // 表单验证规则在 config/form_validation.php 文件
        if ($u->writeLog($ids[0])) {
            $result = $this->model('jt_admin/classify')->deleteClassify($where);
            
            if ($result) {
                $json_result['status'] = true;
            } else {
                $json_result['status'] = false;
                $json_result['msg'] = '操作数据库时出错';
            }

            echo json_encode($json_result);
            exit;
        }
    }

    /**
     * 保存分类顺序
     * @return [json] [处理结果]
     */
    public function saveClassifyProc()
    {
        $change_items = form('change_items');
        if (!is_array($change_items)) {
            $json_result['msg'] = '传递数据有错误';
            $json_result['status'] = false;
            echo json_encode($json_result);
            exit;
        }
        $data = array();
        foreach ($change_items as $k => $v) {
            if (isset($v['id']) && intval($v['id']) > 0) {
                $data[$k]['cID'] = intval($v['id']);
                if (isset($v['order']) && floatval($v['order']) > 0) {
                    $data[$k]['cSort'] = floatval($v['order']);
                }
                if (isset($v['depth']) && intval($v['depth']) > 0) {
                    $data[$k]['cDepth'] = intval($v['depth']);
                }
                if (isset($v['parent']) && intval($v['parent']) >= 0) {
                    $data[$k]['cParentID'] = intval($v['parent']);
                }
            }
        }
        if (count($data) == 0) {
            $json_result['status'] = false;
            $json_result['msg'] = '没有可更新数据';
            echo json_encode($json_result);
            exit;
        }

        $this->load->library('AdminCrud');
        $u = new AdminCrud();

        $u->isnullSetLogTitle('保存分类');
        
         // dump($u->update_item);
        // 表单验证规则在 config/form_validation.php 文件
        if ($u->writeLog()) {
            $result = $this->db->update_batch('spe_classify', $data, 'cID');
            // dump_query();
            if ($result) {
                $json_result['status'] = true;
            } else {
                $json_result['status'] = false;
                $json_result['msg'] = '操作数据库时出错';
            }

            echo json_encode($json_result);
            exit;
        }
    }
}
