<?php if ( ! defined('WIDGET_PI')) exit('No direct script access allowed widget');

class front extends Widget {
    function index($tpl_name,$data=false) {
        if(isset($tpl_name['view'])){
            if(isset($tpl_name['data'])) $data = $tpl_name['data'];
            $this->load->view('widget/front/'.$tpl_name['view'],$data);
        }else{
            exit('no tpl_name');
        }
    }
}
?>