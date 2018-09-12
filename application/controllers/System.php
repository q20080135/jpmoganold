<?php
defined('BASEPATH') or exit('No direct script access allowed');

class System extends ADMIN_Controller
{


    public function info()
    {
        $this->load->view('jt_admin/system/info');
    }
}
