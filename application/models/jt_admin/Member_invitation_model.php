<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 邀请关系表模型类
 * @author 齐福
 * 创建时间 ： 2017年9月5日下午1:18:43
 */
class Member_invitation_model extends MY_Model{
    public function __construct(){
        $this->table = 'spe_member_invitation';

        parent::__construct();
    }
    
}



