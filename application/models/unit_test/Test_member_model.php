<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Test_member_model extends MY_Model2{
    public function __construct(){
        $this->table = 'test_member';
        parent::__construct();
    }


}



