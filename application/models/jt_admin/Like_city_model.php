<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 推荐城市模型类
 * @author 齐福
 * 创建时间 ： 2017年11月22日下午1:18:43
 */
class Like_city_model extends MY_Model{
    public function __construct(){
        $this->table = 'spe_like_city';

        parent::__construct();
    }
}



