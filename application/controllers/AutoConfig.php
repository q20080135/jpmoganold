<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AutoConfig extends MY_Controller
{
    public function __construct() {
        parent::__construct();
        $this->path = $this->config->_config_paths[0] . 'config/';
        $this->file = $this->path . 'busAdminConfig.php';
    }
}
