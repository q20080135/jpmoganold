<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Member_pay_model extends MY_Model{
    public function __construct(){
        $this->table = 'spe_member_pay_list';

        parent::__construct();
    }


}



