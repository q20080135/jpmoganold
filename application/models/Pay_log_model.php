<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Pay_log_model extends MY_Model{
    public function __construct(){
        $this->table = 'spe_pay_log';

        parent::__construct();
    }

}



