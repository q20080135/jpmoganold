<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * 代发货状态表
 */
class Admin_order_delivery_model extends MY_Model
{
    public function __construct()
    {
        $this->table = 'spe_admin_order_delivery';

        parent::__construct();
    }

    public function updateDeliveryState($id,$val)
    {
        if ($val == '`null`') {            
            $result = $this->del_by_id($id);
            // dump_query();
            return $result;
        } else if($val == '`not null`') {           
            $data['aodSoID']=$id;
            $result = $this->insert($data);
            // dump_query();
            return $result;
        }
    }

}
