<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 表单验证文档
 * http://codeigniter.org.cn/user_guide/libraries/form_validation.html
 */

$config = array(
    'jt_admin/classify/addClassifyProc' => array(
        array('field' => 'cName', 'label' => '分类名称',   'rules' => 'trim|required')
    )
    ,'jt_admin/classify/editClassifyProc' => array(
        array('field' => 'cName', 'label' => '分类名称',   'rules' => 'trim|required')
    )
    ,'jt_admin/shop/add_save' => array(
        array('field' => 'sName', 'label' => '用户名',   'rules' => 'trim|required|min_length[6]'),
        array('field' => 'sSartTime', 'label' => '开始时间',   'rules' => 'strtotime|required','errors'=>array(
            'strtotime' => '%s格式不正确.',
            'required' => '请选择%s'
        )),
        array('field' => 'sEndTime', 'label' => '结束时间',   'rules' => 'strtotime|required','errors'=>array(
            'strtotime' => '%s格式不正确.',
            'required' => '请选择%s'
        )),
        array('field' => 'linkmanName', 'label' => '联系人姓名',   'rules' => 'required'),
        array(
            'field' => 'linkmanTel', 
            'label' => '联系人电话',
            'rules' => 'required|regex_match[/^[1][345678][0-9]{9}$/]',
            'errors'=>array('regex_match'=>'电话格式不正确')
        ),
/*        array('field' => 'idCardFront', 'label' => '身份证正面',   'rules' => 'required'),
        array('field' => 'idCardBack', 'label' => '身份张反面',   'rules' => 'required'),*/
        array('field' => 'linkmanEmail', 'label' => '邮箱',   'rules' => 'trim|required|valid_email'),
        
    )
    ,'jt_admin/shop/del_shop' => array(
        array('field' => 'sId', 'label' => 'ID',   'rules' => 'trim'),
    )
    ,'jt_admin/shop/update_save' => array(
        array('field' => 'sId', 'label' => 'ID',   'rules' => 'trim'),
    )
    ,'jt_admin/ad/add_save' => array(
        array('field' => 'adName', 'label' => '广告名',   'rules' => 'trim|required|min_length[2]'),
        array('field' => 'adStartTime', 'label' => '开始时间',   'rules' => 'strtotime|required','errors'=>array(
            'strtotime' => '%s格式不正确.',
            'required' => '请选择%s'
        )),
        array('field' => 'adEndTime', 'label' => '结束时间',   'rules' => 'strtotime|required','errors'=>array(
            'strtotime' => '%s格式不正确.',
            'required' => '请选择%s'
        )),
        array('field' => 'adSort', 'label' => '顺序',   'rules' => 'numeric|required','errors'=>array(
            'numeric' => '%s请输入数字.',
            'required' => '请输入%s')),
        
    )
    ,'jt_admin/ad/del_ad' => array(
        array('field' => 'adID', 'label' => 'ID',   'rules' => 'trim'),
    )
    //广告上下架
    ,'jt_admin/ad/shangxiajia' => array(
        array('field' => 'adID', 'label' => 'ID',   'rules' => 'trim'),
    )
    ,'jt_admin/ad/update_save' => array(
        array('field' => 'adID', 'label' => 'ID',   'rules' => 'trim'),
    )
    ,'jt_admin/product/updataRegionInfo' => array(
        array('field' => 'region_id', 'label' => 'ID',   'rules' => 'numeric|required'),
        array('field' => 'griIcon', 'label' => 'ID',   'rules' => 'trim'),
    )
    ,'jt_admin/ap/add_save' => array(
        array('field' => 'apName', 'label' => '广告位名',   'rules' => 'trim|required|min_length[2]'),
    )
    ,'jt_admin/ap/del_ap' => array(
        array('field' => 'apID', 'label' => 'ID',   'rules' => 'trim'),
    )
    ,'jt_admin/ap/update_save' => array(
        array('field' => 'apID', 'label' => 'ID',   'rules' => 'trim'),
    )
    ,'jt_admin/panicbuy/add_save' => array(
        array('field' => 'pbStartTime', 'label' => '开始时间',   'rules' => 'strtotime|required','errors'=>array(
            'strtotime' => '%s格式不正确.',
            'required' => '请选择%s'
        )),
        array('field' => 'pbEndTime', 'label' => '结束时间',   'rules' => 'strtotime|required','errors'=>array(
            'strtotime' => '%s格式不正确.',
            'required' => '请选择%s'
        )),
    )
    ,'jt_admin/coupon/add_save' => array(
        array('field' => 'hName', 'label' => '优惠券名称',   'rules' => 'trim|required|min_length[2]'),
        array('field' => 'hSendTime', 'label' => '结束时间',   'rules' => 'strtotime|required','errors'=>array(
            'strtotime' => '%s格式不正确.',
            'required' => '请选择%s'
        )),
        array('field' => 'hStartTime', 'label' => '开始时间',   'rules' => 'strtotime|required','errors'=>array(
            'strtotime' => '%s格式不正确.',
            'required' => '请选择%s'
        )),
        
        array('field' => 'hCount', 'label' => '发放数量',   'rules' => 'numeric|required','errors'=>array(
        'numeric' => '%s请输入数字.',
        'required' => '请输入%s')),
    )
    
    //添加版本更新信息
    ,'jt_admin/version/add_save' => array(
        array('field' => 'versionName', 'label' => '版本名称',   'rules' => 'trim|required|min_length[2]'),
    )
    //修改版本更新信息
    ,'jt_admin/version/update_save' => array(
        array('field' => 'versionId', 'label' => 'id',   'rules' => 'trim'),
    )
    ,'jt_admin/version/del_version' => array(
        array('field' => 'versionId', 'label' => 'ID',   'rules' => 'trim'),
    )
  
    //逻辑删除产品
    ,'jt_admin/product/logic_del' => array(
        array('field' => 'gID', 'label' => 'ID',   'rules' => 'trim'),
    )
    //恢复产品
    ,'jt_admin/product/recovery' => array(
        array('field' => 'gID', 'label' => 'ID',   'rules' => 'trim'),
    )
    
    //添加banner
    ,'jt_admin/banner/add_save' => array(
        array('field' => 'bEndTime', 'label' => '结束时间',   'rules' => 'strtotime|required','errors'=>array(
            'strtotime' => '%s格式不正确.',
            'required' => '请选择%s'
        )),
        array('field' => 'bStartTime', 'label' => '开始时间',   'rules' => 'strtotime|required','errors'=>array(
            'strtotime' => '%s格式不正确.',
            'required' => '请选择%s'
        )),
    )
    //更改banner状态
    ,'jt_admin/banner/change_status' => array(
        array('field' => 'bID', 'label' => 'ID',   'rules' => 'trim'),
    )
    //编辑banner
    ,'jt_admin/banner/update_save' => array(
        array('field' => 'bEndTime', 'label' => '结束时间',   'rules' => 'strtotime|required','errors'=>array(
            'strtotime' => '%s格式不正确.',
            'required' => '请选择%s'
        )),
        array('field' => 'bStartTime', 'label' => '开始时间',   'rules' => 'strtotime|required','errors'=>array(
            'strtotime' => '%s格式不正确.',
            'required' => '请选择%s'
        )),
    )
  
    //修改留言状态
    ,'jt_admin/liuyan/updateType' => array(
        array('field' => 'lID', 'label' => 'ID',   'rules' => 'trim'),
    )
     //删除留言
    ,'jt_admin/liuyan/logic_del' => array(
        array('field' => 'lID', 'label' => 'ID',   'rules' => 'trim'),
    )
     //客户添加留言
    ,'front/contact/add_save' => array(
        array('field' => 'lID', 'label' => 'ID',   'rules' => 'trim'),
    )
     //客户添加留言
    ,'register/add_save' => array(
        array('field' => 'email', 'label' => 'ID',   'rules' => 'trim'),
    )

     //添加文章
    ,'article/add_save' => array(
        array('field' => 'aTitle', 'label' => 'ID',   'rules' => 'trim'),
    )
    //删除文章
    ,'jt_admin/article/del_article' => array(
        array('field' => 'aID', 'label' => 'ID',   'rules' => 'trim'),
    )

    
);
