<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Menu_model extends MY_Model{
    public function __construct(){
        $this->table = 'spe_auth_menu';

        parent::__construct();
    }

}



