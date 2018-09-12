<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 入驻商申请模型类 
 */
class Settled_merchant_model extends MY_Model{
    public function __construct(){
        $this->table = 'spe_settled_merchant';

        parent::__construct();
    }
}



