<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 测试
 * @author 齐福
 * 创建时间 ： 2016年12月12日上午9:33:11
 */
class Ceshi extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 转向管理员列表页
     *
     * @return [view] [管理员列表页面]
     */
    public function admin_list()
    {
        $sql = "insert into ceshi(nickname,age,resume) SELECT nickname,age,resume from ceshi as ceshi order by rand()";

        $this->db->query($sql);
        echo "1";
    }
}
