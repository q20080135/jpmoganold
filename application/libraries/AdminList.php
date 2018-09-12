<?php
/**
 * List后台管理模块
 *
 * 混合使用框架 DataTables + H-ui + CI
 * 方便后台管理时，规范化，简单化为目的
 * DataTables ： https://datatables.net/
 * H-ui ： http://www.h-ui.net/
 * CI ： http://codeigniter.org.cn/user_guide/
 *
 *
 * @category   Admin
 * @package    Nickspace
 * @copyright  Copyright 2007 - 2016 NickSpace All Rights Reserved. (http://nickspace.cn)
 * @license    http://jquery.org/license    Released under the MIT license
 * @version    1.8.0, 2014-03-02
 */
 
class AdminList
{

    public $filter = array();
    public $where = array();

    public $offset = 0;
    public $limit = 10;

    public $order = null;

    private $CI;
    public $model;
    public $join;

    public function __construct()
    {
        $this->CI = &get_instance();

        $this->offset = form('start');
        $this->limit = form('length');

        if (!$this->limit || $this->limit > 100) {
            $this->limit  = 10;
        }
    }

    /**
     * 设置搜索条件
     *
     * @param [string]  $name      [data_form传递的key_name]
     * @param [string]  $db_col   [数据库表列名称]
     * @param [string]  $default   [data_form为空时候的默认值]
     */
    public function setFilter($name, $db_col = null, $default = null)
    {
        if ($db_col === null) {
            $db_col = $name;
        }
        if (data_form($name)||'0'===data_form($name)) {
            $this->filter[$db_col] = data_form($name);
        } elseif ($default !== null) {
            $this->filter[$db_col] = $default;
        }
    }
    
    /**
     * 自动设置搜索条件
     *
     * @param [array]  $filters      [data_form传递的key_name]
     */
    public function setFilters($filters)
    {
        
        foreach ($filters as $k => $v) {
            $this->setFilter($k, isset($v['db'])?$v['db']:$k);
        }
    }


    public function setWhere($db_col, $val = null)
    {
        $this->where[$db_col] = $val;
    }

    public function setOrder($order)
    {
        $this->order = $order;
    }

    public function setModel($model_name, $join = array())
    {
        $this->model = $this->CI->model($model_name);
        $this->join = $join;
    }

    /**
     * 执行Model里的getListData方法并获取统计数据
     * @param  string $method [获取数据方法名]
     * @return [array] 获取列表数据和统计数据
     */
    public function getListData($method = 'getListData')
    {
        $where = array_merge($this->where, $this->filter);
        $data['data'] = $this->model->$method($where, $this->order, $this->limit, $this->offset, $this->join);
        $data['recordsTotal'] = $this->model->get_count($this->where, $this->join);
        $data['recordsFiltered'] = $this->model->get_count($where, $this->join);
        return $data;
    }
}
