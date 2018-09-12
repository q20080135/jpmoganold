<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 权限组表
 * 
 * @author 齐福
 *         创建时间 ： 2016年11月21日下午3:24:52
 */
class Auth_group_model extends MY_Model
{

    public function __construct()
    {
        $this->table = 'spe_auth_group';
        
        parent::__construct();
    }

    /**
     * 返回字段文字
     * return array customized attribute labels (name=>label)
     */
    public function attribute_labels()
    {
        return array(
            'auID' => 'Au',
            'auName' => 'Au Name',
            'auRight' => 'Au Right',
            'auAddtime' => 'Au Addtime',
            'auAddip' => 'Au Addip',
            'auType' => 'Au Type'
        );
    }
}



