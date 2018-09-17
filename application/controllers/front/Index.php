<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Index extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        
      echo '首页';
        //$this->load->view('main');
    }


	public function account()
    {
    	$this->load->view('front/account');
    }
    public function activity()
    {
        $sql = "SELECT * FROM `spe_articles` WHERE aAddtime<now() and aIsView = 1 and aDel = 0 and  cID = 134 order by aAddtime desc";
        $que = $this->db->query($sql);
        $data['wdata'] = $que->result_array();
        
    	$this->load->view('front/activity',$data);
    }
    public function announcement($page,$cid)
    {

        $sql = "SELECT * FROM `spe_articles` WHERE aAddtime<now() and aIsView = 1 and aDel = 0 and  cID = 142 order by aAddtime desc limit 0,3";
        $que = $this->db->query($sql);
        $data['wdata'] = $que->result_array();


        $sql = "SELECT * FROM `spe_articles` WHERE aAddtime<now() and aIsView = 1 and aDel = 0 and  cID = 144 order by aAddtime desc limit 0,3";
        $que = $this->db->query($sql);
        $data['wdata2'] = $que->result_array();
        $data['cid'] = $cid;
    	$this->load->view('front/announcement',$data);
    }

    public function announcement_data()
    {
        $page = $this->input->post('page',true);
        $cid = $this->input->post('cid',true);
        if($cid==142||$cid==144||$cid==136){
            $page =$page+3;
        }
        if($page==''){
            $page = 0 ;
            $_REQUEST['page'] = 0;
        }
       
        $page_size = $this->input->post('page_size',true);

        $sql = "SELECT * FROM `spe_articles` WHERE aAddtime<now() and aIsView = 1 and aDel = 0 and  cID = $cid order by aAddtime desc limit $page,$page_size";
        $que = $this->db->query($sql);
        $data['wdata'] = $que->result_array();


        $sql = "SELECT count(*) num FROM `spe_articles` WHERE aAddtime<now() and aIsView = 1 and aDel = 0 and  cID = $cid order by aAddtime desc";
        $que = $this->db->query($sql);
        $data['con'] = $que->row_array()['num'];

        $this->load->library('pagination');                      //加载分页类
        $config['total_rows']=$data['con'];                               //总的内容 条数
        $config['per_page']=$page_size;                                  //每页显示数量，默认显示10条
        $config['cur_tag_open'] = '<span class="current">';
        $config['cur_tag_close'] = '</span>';
        $config['last_link'] = '最后一页';
        $config['first_link'] = '第一页';
        $config['next_link'] = '下一页';
        $config['prev_link'] = '上一页';
        $data['pagenum'] = $data['con']>0?'页 1 of '.ceil($data['con']/$page_size):'';        
        $this->pagination->initialize($config);                  //加载配置信息
        $data['page']  = $this->pagination->create_ajax_links('load'.$cid);  //要显示到界面的分页信息
        die(json_encode($data));
        
    }
    public function brand_story()
    {
    	$this->load->view('front/brand_story');
    }
    public function back2c()
    {

        $sql = "SELECT * FROM `spe_articles` WHERE aAddtime<now() and aIsView = 1 and aDel = 0 and cID = 135 order by aAddtime desc";
        $que = $this->db->query($sql);
        $data['wdata'] = $que->result_array();
    	$this->load->view('front/back2c',$data);
    }
    public function broker()
    {
    	$this->load->view('front/broker');
    }
    public function crude()
    {
    	$this->load->view('front/crude');
    }
    public function datadownload()
    {
    	$this->load->view('front/datadownload');
    }
    public function dictionary()
    {
    	$this->load->view('front/dictionary');
    }
    public function forex()
    {
    	$this->load->view('front/forex');
    }
    public function linkus()
    {
    	$this->load->view('front/linkus');
    }
    public function manager()
    {
    	$this->load->view('front/manager');
    }
    public function metal()
    {
    	$this->load->view('front/metal');
    }
    public function moneysafety()
    {
    	$this->load->view('front/moneysafety');
    }
    public function mt4pc()
    {
    	$this->load->view('front/mt4pc');
    }
    public function regulations()
    {
    	$this->load->view('front/regulations');
    }
    public function rule()
    {
    	$this->load->view('front/rule');
    }
    public function trader()
    {
    	$this->load->view('front/trader');
    }
    public function training($page = 0)
    {

        $sql = "SELECT * FROM `spe_articles` WHERE aAddtime<now() and aIsView = 1 and aDel = 0 and  cID = 137 order by aAddtime desc limit $page,20 ";
        $que = $this->db->query($sql);
        $data['wdata'] = $que->result_array();

        $sql = "SELECT count(*) num FROM `spe_articles` WHERE aAddtime<now() and aIsView = 1 and aDel = 0 and  cID = 137 order by aAddtime desc";
        $que = $this->db->query($sql);
        $data['con'] = $que->row_array()['num'];

        $this->load->library('pagination');                      //加载分页类
        $config['base_url']=site_url('training.html');         //地址路径
        $config['total_rows']=$data['con'];                               //总的内容 条数
        $config['per_page']=20;                                  //每页显示数量，默认显示10条
        $config['cur_tag_open'] = '<span class="current">';
        $config['cur_tag_close'] = '</span>';
        $config['last_link'] = '最后一页';
        $config['first_link'] = '第一页';
        $config['next_link'] = '下一页';
        $config['prev_link'] = '上一页';
        
        $this->pagination->initialize($config);                  //加载配置信息
        $data['page'] = $this->pagination->create_links();  //要显示到界面的分页信息
    	$this->load->view('front/training',$data);
    }
    public function whyus()
    {
    	$this->load->view('front/whyus');
    }
    public function zhishu()
    {
    	$this->load->view('front/zhishu');
    }
    public function search()
    {
        $s = $this->input->post('s',true);
        $sql = "SELECT * FROM `spe_articles` WHERE aAddtime<now() and aIsView = 1 and aDel = 0 and aContent like '%".$s."%' or aTitle like '%".$s."%' or aDescription like '".$s."'  order by aAddtime desc";
        $que = $this->db->query($sql);
        $data['wdata'] = $que->result_array();
        $data['s'] =$s;
        $this->load->view('front/search',$data);
    }
    public function headline()
    {

        $sql = "SELECT * FROM `spe_articles` WHERE aAddtime<now() and aIsView = 1 and aDel = 0 and  cID = 136 order by aAddtime desc limit 0,3";
        $que = $this->db->query($sql);
        $data['wdata'] = $que->result_array();


        $this->load->view('front/headline',$data);
    }
    public function submit()
    {
        $this->config->load('jt_static');
        $data['xiaozhi_state'] = $this->config->item('xiaozhi_state');
        $this->load->view('front/submit',$data);
    }
    public function helpcenter()
    {
        $this->load->view('front/helpcenter');
    }

    public function xq($id){
        $sql = "SELECT * FROM `spe_articles` WHERE aAddtime<now() and aIsView = 1 and aDel = 0 and  aID = $id order by aAddtime desc";
        $que = $this->db->query($sql);
        $data = $que->row_array();



        $sql = "SELECT * FROM `spe_classify` WHERE cID=".$data['cID'];
        $que = $this->db->query($sql);
        $data['cName'] = $que->row_array()['cName'];

        if($data['cID']==137){
            $data['cUrl'] = '/training.html';
        }else if($data['cID']==136){
            $data['cUrl'] = '/headline.html';
        }else if($data['cID']==134){
            $data['cUrl'] = '/activity.html';
        }else if($data['cID']==142){
            $data['cUrl'] = '/announcement.html/0/142';
        }else if($data['cID']==143){
            $data['cUrl'] = '/announcement.html/0/143';
        }else if($data['cID']==144){
            $data['cUrl'] = '/announcement.html/0/144';
        }
        $this->load->view('front/xq',$data);
    }
    


    public function liuyan_save(){
        $this->load->library('AdminCrud');
        $u = new AdminCrud();
        $u->setData('lName');
        $u->setData('lPhone');
        $u->setData('lEmail');
        $u->setData('lMessage');
        $result = $this->model('jt_admin/liuyan')->insert($u->update_item);
        if ($result) {
            $json_result['status'] = true;
            $json_result['msg'] = '留言成功';
        } else {
            $json_result['msg'] = '操作数据库时出错';
        }

        die(json_encode($json_result));
    }


    public function xiaozhi_save(){
  
        //ci 文件上传

               /* // 上传文件到服务器目录
                $config['upload_path'] = './upload';
                // 允许上传哪些类型
                $config['allowed_types'] = 'gif|png|jpg|jpeg';
                // 上传后的文件名，用uniqid()保证文件名唯一
                $config['file_name'] = uniqid();        
                // 加载上传库
                $this->load->library('upload', $config);
                // 上传文件，这里的pic是视图中file控件的name属性
                $result = $this->upload->do_upload('xImg');
                // 如果上传成功，获取上传文件的信息
                if ($result) 
                {
                    $imgdata = $this->upload->data();
                    $update_item['xImg'] = $imgdata['file_name'];
                }
        */

        $this->load->helper('file');
       
        $imgs = array();
        foreach ($_POST as $key => $value) {

            if(strstr($key,'imgs')){
                $imgs[] = saveBase64Img($value,'',$mime = "png",$max_size = 20);
            }
        }
        if(isset($imgs)){

            $update_item['xImg'] = implode(',',$imgs);
            //$file = saveBase64Img($_POST['aImg'],'',$mime = "png",$max_size = 2);
        }

        
        $update_item['xType'] = $this->input->post('xType',true);
        $update_item['xTitle'] = $this->input->post('xTitle',true);
        $update_item['xDescribe'] = $this->input->post('xDescribe',true);
        $update_item['xName'] = $this->input->post('xName',true);
        $update_item['xUser'] = $this->input->post('xUser',true);
        $update_item['xMt4User'] = $this->input->post('xMt4User',true);
        $update_item['xPhone'] = $this->input->post('xPhone',true);
        $update_item['xEmail'] = $this->input->post('xEmail',true);
        $result = $this->model('jt_admin/xiaozhi')->insert($update_item);
        if ($result) {
            $json_result['status'] = true;
            $json_result['msg'] = '留言成功';
        } else {
            $json_result['msg'] = '操作数据库时出错';
        }
        die(json_encode($json_result));
        
    }

       public function getsina(){
        $hlurl='http://hq.sinajs.cn/list=hf_XAU,hf_XAG,hf_CL,hf_OIL,hf_CHA50CFD,EURUSD,sh000300'; 
        $html = file_get_contents($hlurl);
        echo $html;
    }


}
