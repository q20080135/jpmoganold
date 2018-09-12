<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Classify_doc_model extends MY_Model
{
    public function __construct()
    {
        $this->table = 'spe_classify_doc';

        parent::__construct();
    }
}
