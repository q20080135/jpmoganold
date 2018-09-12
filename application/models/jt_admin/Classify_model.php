<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Classify_model extends MY_Model
{
    public function __construct()
    {
        $this->table = 'spe_classify';

        parent::__construct();
    }

    public function insertClassify($data)
    {

        $classify_item = fillter_data($data, array('cName', 'cDepth', 'cParentID', 'cSort', 'cType','cdImg', 'cAddtime'));
        $ret = array();

        $this->db->trans_start();
        
        $result = $this->insert($classify_item);
        
        if ($result) {
            $ret['id'] = $this->db->insert_id();

            switch ($data['cType']) {
                case 7: // doc
                    $doc_item = fillter_data($data, array('docType', 'docDesc', 'isShow'));
                    $doc_item['cID'] = $ret['id'];
                    $this->db->insert('spe_classify_doc', $doc_item);
                    $ret['doc_id'] = $this->db->insert_id();
                    break;
                    
                case 0: // doc
                    $doc_item = fillter_data($data, array('cdImg'));
                    $doc_item['cID'] = $ret['id'];
                    $this->db->insert('spe_classify_doc', $doc_item);
                    $ret['doc_id'] = $this->db->insert_id();
                    break;
            }
        }
        
        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            return false;
        } else {
            return $ret;
        }
    }

    public function updateClassify($data, $where)
    {

        $c_item = fillter_data($data, array('cName'));
        $c_where = fillter_data($where, array('cID'));

        $this->db->trans_start();
                
        $result = $this->update($c_item, $c_where);
        if ($result) {
            if (isset($data['cType'])) {
                switch ($data['cType']) {
                    case 7: // doc
                        $doc_item = fillter_data($data, array('docType', 'docDesc', 'isShow'));
                        if (isset($where['cdID']) && $where['cdID']) {
                            $this->db->update('spe_classify_doc', $doc_item, $where);
                        } else {
                            $doc_item['cID'] = $where['cID'];
                            $this->db->insert('spe_classify_doc', $doc_item);
                        }
                        break;
                    case 0:
                        $doc_item = fillter_data($data,array('cdImg'));
                        if (isset($where['cdID']) && $where['cdID']) {
                            $lsdata = $this->model('jt_admin/classify_doc')->get_row('cdID,cdImg',$where);
                            $this->db->update('spe_classify_doc', $doc_item, $where);
                            if($lsdata['cdImg']!=$doc_item['cdImg']){
                                removeQiniuFile($lsdata['cdImg']);
                            }
                        } else {
                            $doc_item['cID'] = $where['cID'];
                            $this->db->insert('spe_classify_doc', $doc_item);
                        }
                        break;
                }
            }
        }
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function deleteClassify($where)
    {

        $c_item = array('cDel'=>1);
        $cd_item = array('cdDel'=>1);

        $ctype = $where['cType'];
        unset($where['cType']);

        $this->db->trans_start();
        
        $result = $this->update($c_item, $where);
        if ($result) {
            switch ($ctype) {
                case 'doc': // doc
                    $this->model('jt_admin/classify_doc')->update($cd_item, $where);
                    break;
            }
        }
        
        $this->db->trans_complete();

        return $this->db->trans_status();
    }
}
