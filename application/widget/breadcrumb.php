<?php if ( ! defined('WIDGET_PI')) exit('No direct script access allowed widget');

class breadcrumb extends Widget {
    function index($data) {
        if($data){
            $this->load->view('widget/breadcrumb',array('data'=>$data));
        }else{
            exit('no breadcrumb data!');
        }
    }
}
?>