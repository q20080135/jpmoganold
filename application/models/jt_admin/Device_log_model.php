<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * app开启设备记录
 * @author 齐福
 * 创建时间 ： 2017年8月28日下午15:35:55
 */
class Device_log_model extends MY_Model{
    public function __construct(){
        $this->table = 'spe_device_log';

        parent::__construct();
    }

}



