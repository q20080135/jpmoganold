<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 极光推送
 * @author 齐福
 * 创建时间 ： 2017年9月19日下午5:30:43
 */
class Jpush_model extends MY_Model{
    public function __construct(){
        $this->table = 'spe_jpush';

        parent::__construct();
    }
    
}
