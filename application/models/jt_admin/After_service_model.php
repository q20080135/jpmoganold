<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * 售后表
 * @author 齐福
 * 创建时间 ： 2017年5月22日下午9:31:59
 */
class After_service_model extends MY_Model
{
    public function __construct()
    {
        $this->table = 'spe_after_service';

        parent::__construct();
    }

}
