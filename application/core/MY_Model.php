<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

// 数据库操作基类
class MY_Model extends CI_Model
{
    protected $table;                                   // 主表名（无前缀）
    protected $_table;                                  // 主表名（带前缀）
    protected $fields;                                  // 主表字段
    protected $files    = array();                  // 文件字段
    // $this->files     = array('img'=>1, 'show'=>0);   // 该字段是否必须，默认为1，必须
    // $this->files     = array('img'=>'1,120*120');    // 该字段是否必须，只保存缩略图
    protected $mul_img  = array();                      // 多图字段
    // $this->mul_img   = array('img'=>'string,0,1', 'show'=>'json,0,1,120*120');
    // 0表示上传张数无限制，第3个参数表示是否必须选择图片
    protected $txt_img  = array();                      // 图文字段
    // $this->txt_img   = array('img', 'show');
    protected $upload_flag;                             // 加载文件上传函数标识
    public $_pk         = null;                         // 主表主键
    protected $is_cache = false;                        // 是否开启数据库缓存，默认关闭
    static private $_db = array();

    // 构造函数
    function __construct()
    {
        parent::__construct();
        $this->_set_table($this->table);
        // $this->tables[$this->table] = $this->_table;
        if (($this->files || $this->mul_img || $this->txt_img) && !$this->upload_flag) {
            $this->load->helper('upload');
            $this->upload_flag = 1;
        }
    }

    final public function model($name, $dir = '')
    {
        if (!isset(self::$_db[$name])) {
            $model = "{$name}_m";   // 防止全局变量重命名
            $this->load->model("{$dir}{$name}_model", $model);
            self::$_db[$name] = $this->$model;
        }
        return self::$_db[$name];
    }

    // 设置数据表和定义主键
    private function _set_table($table)
    {
        if (!empty($table)) {
            $this->table = $table;
            $this->_table = $this->db->dbprefix($table);
            $fields = $this->db->field_data($this->_table);
            foreach ($fields as $v) {
                $this->fields[$this->_table . '.' . $v->name] = $v->type;
                if ($v->primary_key) {
                    $this->_pk = $v->name;
                }
            }
        }
    }


    /************************************ 对外接口 ******************************************/

    /**
     * 获取一条记录
     *@param string $select, 要获取的字段
     *@param array $where, 查询条件
     *@param array $join, 连表查询
     *@return array|NULL, 如果查到则返回一维数组，否则返回NULL
     */
    public function get_row($select = "*", $where = null, $join = array(), $order = null)
    {
        $res = $this->get_list($select, $where, $join, $order, 1);
        return $res ? $res[0] : null;
    }

    /**
     * 获取单一值
     */
    public function get_one($field, $where = null, $join = array(), $order = null)
    {
        $tmp = explode(',', $field);
        $field = $tmp[0];
        $res = $this->get_row($field, $where, $join, $order);
        return $res ? $res[$field] : null;
    }

    /**
     * 获取单一值数组
     */
    public function get_arr($field, $where = null, $join = array(), $order = null, $limit = 0, $offset = 0)
    {
        $tmp = explode('.', $field);
        $field = array_pop($tmp);
        $res = $this->get_list($field, $where, $join, $order, $limit, $offset);
        $arr = array();
        foreach ($res as $v) {
            $arr[] = $v[$field];
        }
        return $arr;
    }


    /**
     * 获取指定字段的最大值
     */
    public function get_max($field, $where = null)
    {
        if ($where) {
            $this->db->where($where);
        }

        $res = $this->db->from($this->_table)->select_max($field)->get()->row_array();
        return $res ? $res[$field] : null;
    }

    /**
     * 获取指定字段最大的一行
     */
    public function get_max_row($field, $where = null, $join = array())
    {
        $res = $this->get_list('*', $where, $join, $field + 'desc', 1);
        return $res;
    }

    /**
     * 获取指定字段的最小值
     */
    public function get_min($field, $where = null)
    {
        if ($where) {
            $this->db->where($where);
        }

        $res = $this->db->from($this->_table)->select_min($field)->get()->row_array();
        return $res ? $res[$field] : null;
    }

    /**
     * 获取指定字段的总和
     */
    public function get_sum($field, $where = null)
    {
        $_field = "SUM(`{$field}`) as $field";
        $res = $this->get_row($_field, $where);
        return $res ? $res[$field] : null;
    }

    /**
     * 检索数据，分页
     *@param string $select, 要获取的字段
     *@param array $where, 查询条件
     *@param array $join, 连表查询
     *@param int $limit, 限制条数
     *@param int $offset, 编移
     *@param bool $td, 页码上是否需要加td标签
     *@return array|NULL, 如果查到则返回一维数组，否则返回NULL
     */
    public function search($select = "*", $where = null, $join = array(), $url = '?', $order = null, $page_size = 15, $td = true)
    {
        return $this->_search($select, $where, $join, $url, $order, $page_size, $td, 'search');
    }

    /**
     * 检索数据，分页（页码里不带搜索条件，搜索条件保存在session里）
     * @param string $select, 要获取的字段
     * @param array $where, 查询条件
     * @param array $join, 连表查询
     * @param int $limit, 限制条数
     * @param int $offset, 编移
     * @param bool $td, 页码上是否需要加td标签
     * @return array|NULL, 如果查到则返回一维数组，否则返回NULL
     */
    public function mul_page($select = "*", $where = null, $join = array(), $url = '?', $order = null, $page_size = 15, $td = true)
    {
        return $this->_search($select, $where, $join, $url, $order, $page_size, $td, 'mul_page');
    }

    /**
     * 检索数据基础方法
     */
    private function _search($select = "*", $where = null, $join = array(), $url = '?', $order = null, $page_size = 15, $td = true, $search = 'search')
    {

        $result = array('list'=>array(), 'total'=>0);
        if (isset($where['per_page'])) {
            $cur_page = intval($where['per_page']);
            unset($where['per_page']);
        } else {
            $cur_page = 1;
        }
        // dump($cur_page);
        $result['total'] = $this->get_count($where, $join, 'count(distinct '.$this->table.'.'.$this->_pk.')');

        $result['pages'] = $page_size ? ceil($result['total'] / $page_size) : 1;
        $result['get']   = urlget();
        $cur_page = max(1, min($result['pages'], $cur_page));
        $offset   = ($cur_page -1) * $page_size;
        // echo 'page_size:'.$page_size.'<br>';
        // echo 'page_size:'.$page_size.'<br>';
        // dump($result);
        if ($url) {
            if ($search == 'search') {
                $query = array();
                foreach (urlget() as $k => $v) {
                    if ($v && $k != 'per_page') {
                        $query[$k] = $v;
                    }
                }
                $query && $url .= ((strpos($url, '?') !== false) ? '' : '?') . http_build_query($query);
            }
            $this->load->helper('page');
            $result['page'] = page($url, $page_size, $result['total'], $td);
        }
        $result['list'] = $this->get_list($select, $where, $join, $order, $page_size, $offset);

        return $result;
    }


    /**
     * 获取选项数据
     */
    public function get_opt($select = 'id,name')
    {
        return $this->get_list($select);
    }

    /**
     * 查询记录条数
     */
    public function get_count($where = null, $join = array(), $select = "count(*)")
    {
        if ($this->is_cache) {
            $this->db->cache_on($this);
        }
        $res = $this->get_row($select . ' total', $where, $join);

        return $res ? $res['total'] : 0;
    }
    /**
     * 查询记录条数----去除重复值
     * 时间：20150903
     */
    public function get_count_notr($fileds = array(), $where = array())
    {
        $query = $this->db->select($fileds)
        ->where($where)
        ->group_by($fileds)
        ->get($this->table);

        return $query->num_rows();
    }

    /**
     * 新增数据
     * @param array $data, 新增的数据
     * @return array
     */
    public function insert($data)
    {
        $res = $this->validate($data, 'insert');
        if ($res['errors']) {
            return $res;
        }
        if ($this->files) {
            $tmp = $this->upload_file($res['item']);
            if ($tmp['errors']) {
                return $tmp;
            }
        }
        if ($this->mul_img) {
            $tmp  = $this->upload_mul_img($res['item']);
            if ($tmp['errors']) {
                return $tmp;
            }
        }
        // $tmp = $this->before_insert($res['item']);
        // if($tmp['errors']) return array_merge($res, $tmp);
        foreach ($this->txt_img as $v) {
            $res['item'][$v] = str_replace(config_item('tmp_path'), config_item('image_path'), $res['item'][$v]);
        }
        $this->db->insert($this->_table, $this->filter($res['item']));
        $res['insert_id'] = $this->db->insert_id();
        $need_move = $this->get_files($res['insert_id']);
        if ($need_move) {
            move_files($need_move);
        }
        // $this->after_insert($res['item'], $res['insert_id']);
        return $res;
    }

    /**
     * 编辑数据
     * @param array $data, 要编辑的数据
     * @param array $where, 更新条件
     * @param bool $auto, 是否自动验证
     * @return int, 返回受影响行数
     */
    public function edit($data, $where = null)
    {

        $res = $this->validate($data, 'edit');
        if ($res['errors']) {
            return $res;
        }
        if (isset($data[$this->_pk]) && $data[$this->_pk]) {
            $get_files_where = $data[$this->_pk];
        } elseif ($where) {
            $get_files_where = $where;
        } else {
            $res['errors'] = array('没有指定更新条件');
            return false;
        }
        $old_files = $this->get_files($get_files_where);
        if ($this->files) {
            $tmp = $this->upload_file($res['item']);
            if ($tmp['errors']) {
                return $tmp;
            }
        }
        if ($this->mul_img) {
            $tmp  = $this->upload_mul_img($res['item']);
            if ($tmp['errors']) {
                return $tmp;
            }
        }
        // $tmp = $this->before_update($res);
        // if($tmp['errors']) return array_merge($res, $tmp);
        if ($where) {
            foreach ($where as $k => $v) {
                $fun = 'where';
                if (is_array($v)) {
                    $fun = 'where_in';
                }
                $k = (strpos($k, '.') !== false) ? $k : $this->_table . ".{$k}";
                $this->db->$fun($k, $v);
            }
        } else {
            $this->db->where($this->_pk, $data[$this->_pk]);
        }
        foreach ($this->txt_img as $v) {
            if (isset($res['item'][$v])) {
                $res['item'][$v] = str_replace(config_item('tmp_path'), config_item('image_path'), $res['item'][$v]);
            }
        }
        $this->db->update($this->_table, $this->filter($res['item']));
        if ($this->files || $this->txt_img || $this->mul_img) {
            $need_move = $this->get_files($get_files_where);
            move_files($need_move);
            if ($old_files) {
                $new_files = $this->get_files($get_files_where);
                del_img_by_name(array_diff($old_files, $new_files));
            }
        }
        $res['affected_rows'] = $this->db->affected_rows();
        // $this->after_update($res);
        return $res;
    }

    /**
     * 更新数据
     * @param array $data, 要更新的数据
     * @param array $where, 更新条件
     * @return int, 返回受影响行数
     */
    public function update($data, $where = null)
    {
        $res = array('item'=>$this->create_data($data), 'errors'=>null);
        if ($where) {
            foreach ($where as $k => $v) {
                $fun = 'where';
                if (is_array($v)) {
                    $fun = 'where_in';
                }
                $k = (strpos($k, '.') !== false) ? $k : $this->_table . ".{$k}";
                $this->db->$fun($k, $v);
            }
        } elseif (isset($res['item'][$this->_pk])) {
            $this->db->where($this->_pk, $res['item'][$this->_pk]);
        } else {
            $result['errors'][] = '没有指定更新条件';
            return $result;
        }

        $this->db->update($this->_table, $res['item']);
        $res['affected_rows'] = $this->db->affected_rows();

        return $res;
    }



    /**
     * 根据id删除数据
     * @param int|array $id, 要删除的记录id
     * @param bool $is_del, 真实删除还是标记删除，默认标记删除
     */
    public function del_by_id($id, $is_del = true)
    {
        return $this->delete(array($this->_pk => $id), $is_del);
    }

    /**
     * 根据条件删除数据
     * @param int|array $id, 要删除的记录id
     * @param bool $is_del, 真实删除还是标记删除，默认标记删除
     */
    public function delete($where = array(), $is_del = true)
    {
        if (!is_array($where)) {
            return false;
        }
        foreach ($where as $k => $v) {
            if (is_array($v)) {
                $this->db->where_in($k, $v);
            } else {
                $this->db->where($k, $v);
            }
        }
        if ($is_del && isset($this->fields['is_del'])) {
            $this->db->update($this->_table, array('is_del'=>1));
        } else {
            $this->db->delete($this->_table);
        }

        return $this->db->affected_rows();
    }


    /**
     * 获取多条记录
     * @param string $select, 要获取的字段
     * @param array $where, 查询条件
     * @param array $join, 连表查询
     * @param string $order, 排序条件
     * @param int $limit, 限制条数
     * @param int $offset, 编移
     * @return array|NULL, 如果查到则返回一维数组，否则返回NULL
     */
    public function get_list($select = "*", $where = null, $join = array(), $order = null, $limit = 0, $offset = 0)
    {
        if ($this->is_cache) {
            $this->db->cache_on($this);
        }

        if ($order) {
            $order_group = explode('&', $order);
            /**
             * 以 order & group 拆分
             */
            //获取order_by
            $order_index = array_shift($order_group);
            $this->db->order_by($order_index);

            //获取group_by
            if ($order_group) {
                $group_index = array_shift($order_group);
                $this->db->group_by($group_index);
            }
        }

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $tbl_field = $this->get_field_type($join);
        if ($join) {
            $fields = explode(',', $select);
            $_fields = array();
            foreach ($fields as $v) {
                if (strpos($v, '.') !== false || strpos($v, '(') !== false) {
                    $_fields[] = $v;
                } elseif (strpos($v, '_') && (strrpos($v, '_id') === false) && ($alias = array_search(substr($v, 0, strrpos($v, '_')), $tbl_field['tables']))) {
                    $_fields[] = str_replace($tbl_field['tables'][$alias] . '_', $alias . '.', $v) .  " {$v}";
                } else {
                    $_fields[] = $this->_table . ".{$v}";
                }
            }
            $select = implode(',', $_fields);
        }
        if (isset($tbl_field['fields'][$this->_table . '.is_del'])) {
            $this->db->where($this->_table . '.is_del', 0);
        }

        if ($where) {
            foreach ($where as $key => $val) {
                $or = $not = $in = '';
                $_or = $_not = '';
                $open_l = $open_r = false;
                $like_l = $like_r = false;
                if (strpos($key, '(') === 0) {
                    $key = str_replace('(', '', $key);
                    $open_l = true;
                } elseif (substr($key, -1) == ')') {
                    $key = str_replace(')', '', $key);
                    $open_r = true;
                }

                if (strpos($key, 'or ') === 0) {
                    $key = str_replace('or ', '', $key);
                    $or = $_or = 'or_';
                } elseif (strpos($key, 'not ') === 0) {
                    $key = str_replace('not ', '', $key);
                    $not = '_not';
                    $_not = 'not_';
                } elseif (strpos($key, 'ornot ') === 0) {
                    $key = str_replace('ornot ', '', $key);
                    $or = $_or = 'or_';
                    $not = '_not';
                    $_not = 'not_';
                }

                if (strpos($key, ' %%')) {
                    $like_l = '%';
                    $like_r = '%';
                    $key = str_replace(' %%', '', $key);
                } elseif (strpos($key, ' %_')) {
                    $like_l = '%';
                    $key = str_replace(' %_', '', $key);
                } elseif (strpos($key, ' _%')) {
                    $key = str_replace(' _%', '', $key);
                    $like_r = '%';
                }

                $key = (strpos($key, '.') !== false) ? $key : $this->_table . ".{$key}";
                
                if (isset($tbl_field['fields'][$key])) {

                    if ($val === '`null`') {
                        $not = str_replace('_', '', $not);
                        $this->db->where($key. " is {$not} null",null, false);
                        continue;
                    }
                    if ($val === '`not null`') {
                        $this->db->where($key. " is not null",null, false);
                        continue;
                    }

                    if (($tbl_field['fields'][$key] == 'varchar' || $tbl_field['fields'][$key] == 'char' || $tbl_field['fields'][$key] == 'text') && $val) {
                        $fun = "{$or}where{$not}";

                        if (is_array($val)) {
                            foreach ($val as $k => $v) {
                                $val[$k] = $v;
                            }
                            $in = '_in';
                        } else {
                            // 实现 OR 用括号捆绑情况
                            // ->where('(table.date >=', date("Y-m-d H:i:s"), FALSE)
                            // ->or_where("table.date = '00-00-00 00:00:00')", NULL, FALSE)
                            if ($open_l) {
                                $this->db->$fun("(1=1",null,false);
                                if ($like_l || $like_r) {
                                    $this->db->where("{$key} like", "'{$like_l}{$val}{$like_r}'", false);
                                    continue;
                                }
                            }
                            if ($open_r) {
                                if ($like_l || $like_r) {
                                    $this->db->$fun("{$key} like", "{$like_l}{$val}{$like_r}");
                                    $this->db->where('1=1)', null, false);
                                    continue;
                                }
                            }

                            if ($like_l || $like_r) {
                                $this->db->$fun("{$key} like", "{$like_l}{$val}{$like_r}");
                                continue;
                            }
                        }
                    }
                    if (strpos($tbl_field['fields'][$key], 'int') !== false) {
                        if (is_array($val)) {
                            foreach ($val as $k => $v) {
                                $val[$k] = intval($v);
                            }
                            $in = '_in';
                        } else {
                            $val = intval($val);
                        }
                    } elseif ($tbl_field['fields'][$key] == 'float' || $tbl_field['fields'][$key] == 'decimal' || $tbl_field['fields'][$key] == 'double') {
                        if (is_array($val)) {
                            foreach ($val as $k => $v) {
                                $val[$k] = floatval($v);
                            }
                            $in = '_in';
                        } else {
                            $val = floatval($val);
                        }
                    }
                } else {
                    if (strpos($key, ' ') === false && strpos($key, '(') === false) {
                        continue;
                    } elseif (strpos($key, ' ')) {
                        if (! isset($tbl_field['fields'][substr($key, 0, strpos($key, ' '))])) {
                            continue;
                        }
                    }
                }
                $fun = "{$or}where{$not}{$in}";

                // if($in && empty($val)) return array();
                if ($in && empty($val)) {
                    $this->db->select($select)->get($this->_table)->result_array();
                    return array();
                }

                // 实现 OR 用括号捆绑情况
                // ->where('(table.date >=', date("Y-m-d H:i:s"), FALSE)
                // ->or_where("table.date = '00-00-00 00:00:00')", NULL, FALSE)
                if ($open_l) {
                    $key = '('.$key;
                    $this->db->$fun($key, $val, false);
                    continue;
                }
                if ($open_r) {
                    $this->db->$fun($key, $val);
                    $this->db->where('1=1)', null, false);
                    continue;
                }

                $this->db->$fun($key, $val);
            }
        }

        // 字段过滤
        $select  = explode(',', $select);
        $_select = array();
        foreach ($select as $v) {
            $tmp = explode(' ', trim($v));
            (strpos($tmp[0], '.') === false) && (strpos($tmp[0], '(') === false) && $tmp[0] = $this->_table . '.' . $tmp[0];

            // echo '01:'.$tmp[0].'<br>';
            if (isset($tbl_field['fields'][$tmp[0]]) || strpos($tmp[0], '(') || $tmp[0] == '*') {
                $_select[] = $v;
                    // echo '1:'.$tmp[0].'<br>';
            } else {
                if (strpos($tmp[0], '.')) {
                    list($tbl, $field) = explode('.', $tmp[0]);
                    // echo '2:'.$tmp[0].'<br>';
                    if (in_array($tbl, array_keys($tbl_field['tables'])) && $field == '*') {
                        $_select[] = $v;
                    }
                }
            }
        }
        $select = implode(',', $_select);
                // dump($select);
        return $this->db->select($select)->get($this->_table)->result_array();
    }

    /************************************ 对外接口 ******************************************/





    /**
     * 过滤数据，防止其他字段入库报错
     * @param array $data, 要入库的数据
     * @return array, 返回过滤后的数据
     */
    protected function filter($data)
    {
        $arr = array();
        foreach ($data as $k => $v) {
            if (isset($this->fields[$this->_table . ".{$k}"])) {
                $arr[$k] = $v;
            }
        }
        return $arr;
    }

    /**
     * 根据属性$files, $mul_img, $txt_img获取文件
     */
    protected function get_files($where)
    {
        if (!($this->files || $this->txt_img || $this->mul_img)) {
            return false;
        }

        $need_move = array();
        $fields = implode(',', array_merge(array_keys($this->files), array_keys($this->mul_img), $this->txt_img));
        if (is_array($where)) {
            $res = $this->get_row($fields, $where);
        } else {
            $res = $this->get_row($fields, array($this->_pk=>$where));
        }
        foreach ($this->files as $k => $v) {
            $need_move[] = $res[$k];
        }
        if ($this->txt_img) {
            $pattern = '{src=.*(\d{6}.{1,2}\d{2}.*)"}U';
            $replace = array();
            foreach ($this->txt_img as $v) {
                preg_match_all($pattern, $res[$v], $out);
                foreach ($out[1] as $img) {
                    $need_move[] = $img;
                }
            }
        }
        if ($this->mul_img) {
            $pattern = '{.*(\d{6}.{1,2}\d{2}.*)(?:[,\'\"]|$)}U';
            foreach (array_keys($this->mul_img) as $v) {
                preg_match_all($pattern, $res[$v], $out);
                foreach ($out[1] as $img) {
                    $need_move[] = $img;
                }
            }
        }
        return $need_move;
    }


    /**
     * 根据属性$files自动上传文件
     */
    protected function upload_file(&$data)
    {
        $result = array('errors'=>null);
        if (!$this->files) {
            return $result;
        }

        foreach ($this->files as $k => $v) {
            $tmp = explode(',', $v);
            if ($_FILES[$k]['name']) {
                if (isset($tmp[1])) {
                    list($width, $height) = explode('*', $tmp[1]);
                    $res = upload($k, true, true, $width, $height);
                } else {
                    $res = upload($k);
                }
                if ($info['error']) {
                    $result['errors'][$k] = $res['error'];
                } else {
                    $file = isset($tmp[1]) ? $res['thumb'] : $res['file'];
                }
            }
            if ($file) {
                $data[$k] = $file;
            } elseif ($v) {
                if (!(isset($data[$k]) && $data[$k])) {
                    $result['errors'][$k] = '请选择上传文件';
                }
            }
        }
        return $result;
    }

    /**
     * 多图字段文件上传
     */
    protected function upload_mul_img(&$data)
    {
        $result = array('errors'=>null);
        if (!$this->mul_img) {
            return $result;
        }
        foreach ($this->mul_img as $k => $v) {
            $opts = explode(',', $v);
            $total = (isset($opts[1]) && $opts[1]) ? intval($opts[1]) : 0;
            if ($opts[0] == 'string') {       // 图片路径用逗号隔开
                $res = mul_img($k, false, $total);
                if ($res['errors']) {
                    return $result;
                }
                $tmp = implode(',', $res['imgs']);
                if (isset($data[$k]) && $data[$k]) {
                    $data[$k] .= ',' . $tmp;
                } else {
                    $data[$k] = $tmp;
                }
                if (!(trim($data[$k], ',')) && isset($opts[2]) && $opts[2]) {
                    $result['errors'][$k] = '请选择上传图片';
                    return $result;
                }
            } elseif ($opts[0] == 'json') {
                if (isset($opts[3])) {
                    list($width, $height) = explode('*', $opts[3]);
                    $res = mul_img($k, false, $total, true, true, intval($width), intval($height));
                } else {
                    $res = mul_img($k, false, $total, true, true);
                }
                if ($res['errors']) {
                    return $result;
                }
                if (isset($data[$k]) && $data[$k]) {
                    if (! is_array($data[$k])) {
                        $imgs = explode(',', trim($data[$k], ','));
                    } else {
                        $imgs = $data[$k];
                    }
                    foreach ($imgs as $img) {
                        // 上传的是base64图片编码
                        if (strpos($img, '[removed]') === 0 || strpos($img, 'data:image') === 0) {
                            if (isset($width)) {
                                $tmp = save_base_img($img, '', true, intval($width), intval($height));
                            } else {
                                $tmp = save_base_img($img, '', true);
                            }
                            if ($tmp['error']) {
                                $result['error'][] = $tmp['error'];
                                return $result;
                            }
                            $arr[] = array(
                                'img'   => $tmp['img'],
                                'thumb' => $tmp['thumb']
                                );
                        } else {
                            $pattern = '/(.*)_\d+-\d+(\..*)/U';
                            if (preg_match($pattern, $img)) {
                                // 上传的是原来的缩略图
                                $arr[] = array(
                                    'img'   => preg_replace($pattern, '${1}${2}', $img),
                                    'thumb' => $img
                                    );
                            } else {
                                // 上传的是临时目录的图片路径
                                if (isset($width)) {
                                    $tmp = thumb($img, $width, $height);
                                } else {
                                    $tmp = thumb($img);
                                }
                                if ($tmp['error']) {
                                    $result['errors'][] = $tmp['error'];
                                    return $result;
                                }
                                $arr[] = array(
                                    'img'   => $img,
                                    'thumb' => $tmp['thumb']
                                    );
                            }
                        }
                    }
                    if (!(array_merge($arr, $res['imgs'])) && isset($opts[3]) && $opts[3]) {
                        $result['errors'][$k] = '请选择上传图片';
                        return $result;
                    }
                    $data[$k] = json_encode(array_merge($arr, $res['imgs']));
                } else {
                    if (empty($res['imgs']) && $opts[2]) {
                        $result['errors'][$k] = '请选择上传图片';
                        return $result;
                    }
                    $data[$k] = json_encode($res['imgs']);
                }
            }
        }
        return $result;
    }

    /**
     * 获取数据表字段类型
     */
    private function get_field_type($join)
    {
        $res = array(
            'tables' => array(
                $this->_table => $this->_table
                ),
            'fields' => $this->fields,
            );
        if (empty($join)) {
            return $res;
        }

        $item = each($join);
        if (!is_numeric($item['key'])) {
            $_tables = array_keys($join);
            $joins = $join;
        } else {
            $_tables[]  = $join[0];
            $joins[$join[0]] = $join[1];
        }
        foreach ($_tables as $v) {
            $tbl   = explode(' ', trim($v));
            if (count($tbl) == 3) {
                $table_name = $tbl[1];
            } else {
                $table_name = $tbl[0];
            }
            $alias = end($tbl);
            $res['tables'][$alias] = $table_name;
        }

        foreach ($res['tables'] as $alias => $tbl) {
            if ($alias == $this->_table) {
                continue;
            }

            $tmp = $this->db->field_data($tbl);
            foreach ($tmp as $k => $v) {
                $res['fields'][$alias . '.' . $v->name] = $v->type;
            }
        }
        $join_types = array('left','right','outer','inner','left_outer','right_outer');
        foreach ($joins as $k => $v) {
            $tbl   = explode(' ', trim($k));
            if (count($tbl) == 3) {
                $join_type = $tbl[0];
                $table_name = $tbl[1];
            } else {
                $join_type = 'left';
                $table_name = $tbl[0];
            }
            if (!in_array($join_type, $join_types)) {
                $join_type = 'left';
            }
            $alias = end($tbl);

            $join_table = $table_name . ' ' . $alias;
            $v = (substr_count($v, '.') == 2) ? $v : $this->_table . '.' . $v;
            $this->db->join($join_table, $v, $join_type);
        }

        return $res;
    }

    /**
     * 创建数据，根据数据表字段过滤数据
     */
    protected function create_data($data)
    {
        $rule = array('tinyint'=>'intval', 'smallint'=>'intval', 'int'=>'intval', 'bigint'=>'intval', 'float'=>'floatval', 'decimal'=>'floatval', 'char'=>'trim', 'varchar'=>'trim', 'bit' =>'boolval', 'text'=>null);
        $_data = array();
        foreach ($data as $k => $v) {
            if (isset($this->fields[$this->_table . ".{$k}"])) {
                if (isset($rule[$this->fields[$this->_table . ".{$k}"]])) {
                    if ($k == 'char' || $k == 'varchar') {
                        $v = (string)$v;
                    }
                        $_data[$k] = $rule[$this->fields[$this->_table . ".{$k}"]]($v);
                } else {
                    $_data[$k] = $v;
                }
            }
        }
        return $_data;
    }


    /**
     * 根据验证规则自动验证数据（只能验证非空和长度）
     * 验证规则：
     * 规则中第一部分表示验证时间（新增时：0、编辑时：1和任何时候：2）
     * protected $_validate = array(
     *      $field => '0,1,255,字段名称',       // 1表示最小长度（大于1时验证），255表示最大长度
     *      $field => '1,0,255,字段名称',       // 0表示可以为空，255表示非空时最大长度
     * );
     */
    protected function auto_check($data, $act = 'insert')
    {
        $result = array('item'=>$this->create_data($data), 'errors'=>null);
        if ($result['errors']) {
            return $result;
        }

        if (empty($this->_validate)) {
            return $result;
        }
        $item = $result['item'];
        foreach ($this->_validate as $k => $v) {
            list($moment, $min_length, $max_length, $name) = explode(',', $v);
            if ($moment != 2) {
                if ($moment == 0 && $act != 'insert') {
                    continue;
                } elseif ($moment == 1 && $act != 'edit') {
                    continue;
                }
            }
            if ($min_length) {
                if (empty($item[$k])) {
                    $result['errors'][$k] = "{$name}不能为空";
                } elseif ($max_length && utf8_strlen($item[$k]) > $max_length) {
                    $result['errors'][$k] = "{$name}长度不能超过{$max_length}个字符";
                } elseif ($min_length > 1 && utf8_strlen($item[$k]) < $min_length) {
                    $result['errors'][$k] = "{$name}长度不能少于{$min_length}个字符";
                }
            } else {
                if ($max_length && utf8_strlen($item[$k]) > $max_length) {
                    $result['errors'][$k] = "{$name}长度不能超过{$max_length}个字符";
                }
            }
        }

        return $result;
    }


    /**
     * 验证数据
     * @param array $data, 要验证的数据
     * @param string $act, 新增还是编辑标识
     */
    protected function validate($data, $act = 'insert')
    {
        $result = $this->auto_check($data, $act);

        return $result;
    }

    /**
     * 编辑或新增数据前方法
     */
    protected function before_insert(&$data)
    {
    }
    protected function after_insert($data, $insert_id)
    {
    }
    protected function before_update(&$data)
    {
    }
    protected function after_update($data)
    {
    }

    
    /**
     * 根据数据形式生成SQL条件语句
     * 参照文档: http://doc.nickspace.cn/QNickCI/06_Core/02_MyModel/
     * @param  array  $where      详细使用方法参照文档 
     * @param  array  $table_info JoinTabel字段列表，相当于 get_field_type($join)['fields']
     * @return string             SQL搜索条件语句
     */
    public function build_where($where, $table_info = array())
    {
        $where_sql = '';
        $all_fields = array_merge($table_info,$this->fields);
        
        foreach ($where as $k => $v) {
            $oprt = $this->bulid_operator($k);
            $is_field = true;
            
            if(substr($oprt['field'], 0,1) !== '*'){
                // 判断字段是否存在
                if(!(strpos($oprt['field'],'.')>0)){
                    $oprt['field'] = $this->_table.'.'.str_replace('.','',$oprt['field']);
                }
                if(!isset($all_fields[$oprt['field']])){
                    $is_field = false;
                }else{
                    $v = $this->optimize_val_by_field_type($all_fields[$oprt['field']],$v);
                }
            }else{
                // 忽略字段是否存在
                $oprt['field'] = str_replace('*', '', $oprt['field']);
            }
            if($is_field){
                if($where_sql !== ''){
                    if(isset($oprt['logical'])){
                        $where_sql .= ' '.$oprt['logical'];
                    }else{
                        $where_sql .= ' AND';
                    }
                    $where_sql .= ' ';
                }
                $where_sql .= (isset($oprt['open']))?$oprt['open']:'';
                $where_sql .= $this->build_where_item_query($oprt,$v);
                $where_sql .= (isset($oprt['close']))?$oprt['close']:'';
            }
        }
        return $where_sql;
    } 

    /**
     * 根据解析运算符生成SQL语句
     * @param  array $key_info 解析后运算符, 函数bulid_operator()返回的数据
     * @param  [any] $val      要搜索内容
     * @return string          SQL语句
     */
    public function build_where_item_query($key_info,$val)
    {
        $v = $this->trans_where_val($val);
        $comparison = (isset($key_info['comparison']))?$key_info['comparison']:'=';

        $is_not = ($comparison === '!');

        if($v === 'IS NULL'){
            $str = ($is_not)?'IS NOT NULL':$v;
            return $key_info['field']. ' ' .$str;
        } 
        
        if($v === 'IS NOT NULL'){
            $str = ($is_not)?'IS NULL':$v;
            return $key_info['field']. ' ' .$str;
        }

        if(substr($v, 0,2) === 'IN'){
            if($comparison == '~'){
                if(count($val) == 2){
                    $val = array_values($val);
                    $start = $this->db->escape($val[0]);
                    $end = $this->db->escape($val[1]);
                    return $key_info['field']. ' BETWEEN ' .$start. ' AND ' .$end;
                }else{
                    throw new Exception("The search values does not conform to the parameter specification.");
                    return;
                }
            }else{
                $str = ($is_not)?'NOT '.$v:$v;
                return $key_info['field']. ' ' .$str;
            }
        }

        switch (strtolower($comparison)) {
            case '!':
                return $key_info['field']. ' <> ' .$v;
                break;
            case '~':
                    throw new Exception("The search values does not conform to the parameter specification.");
                break;
            case '%%':
                return $key_info['field']. ' LIKE ' .$this->db->escape('%'.$val.'%');
                break;
            case '%_':
                return $key_info['field']. ' LIKE ' .$this->db->escape('%'.$val);
                break;
            case '_%':
                return $key_info['field']. ' LIKE ' .$this->db->escape($val.'%');
                break;
            case '!%%':
                return $key_info['field']. ' NOT LIKE ' .$this->db->escape('%'.$val.'%');
                break;
            case '!%_':
                return $key_info['field']. ' NOT LIKE ' .$this->db->escape('%'.$val);
                break;
            case '!_%':
                return $key_info['field']. ' NOT LIKE ' .$this->db->escape($val.'%');
                break;
            
            case 'reg':
                return $key_info['field']. ' REGEXP ' .$v;
                break;
            case 'reg_binary':
                return $key_info['field']. ' REGEXP BINARY ' .$v;
                break;
            default:

                $white_list = array('=','>','>=','<','<=','<>','!=');
                if(in_array($comparison, $white_list)){
                    return $key_info['field']. ' '.$comparison.' ' .$v;
                }else{
                    throw new Exception("The search field does not conform to the parameter specification.");
                }
                break;
        }
    }

    /**
     * 解析数据库字段与运算符
     * @param  string $key  参数格式：'logical (field comparison)' 除括号外以空格分隔
     *                      logical     : 逻辑运算符 （可选：or,xor)
     *                      (           : 开括号，可以多个
     *                      field       : 数据库字段(必选)
     *                      comparison  : 比较运算符 （可选：>,>=,<,<=,!,%%,%_,_%,!%%,!%_,!_%,reg,reg_binary)
     *                      ）           : 闭括号，可以多个
     * @return array        以数据形式返回字符串里包含的运算符
     *                      返回例： 
     *                        array(
     *                            'open'        => '('            //可选
     *                            ,'field'      => 'fieldName'    //必须
     *                            ,'logical'    => 'or'           //可选
     *                            ,'comparison' => '%%'           //可选
     *                            ,'close'      => ')'            //可选
     *                        )
     */
    public function bulid_operator($key)
    {
        $result = array();
        $logical = array('or','xor');
        $comparison = array('>','>=','<','<=','!','<>','!=','~','%%','%_','_%','!%%','!%_','!_%','reg','reg_binary');

        $keywords = preg_split("/^[(]|([\s]\(+)+|[\s]|(\)+$)/", $key,0,PREG_SPLIT_NO_EMPTY);
        
        $open_cnt = count(explode('(', $key))-1;
        $close_cnt = count(explode(')', $key))-1;
        $min_cnt = min($open_cnt,$close_cnt); 
        $open_cnt = $open_cnt - $min_cnt;
        $close_cnt = $close_cnt - $min_cnt;

        if($open_cnt>0){
            $str = '';
            for ($i=0; $i < $open_cnt; $i++) { 
                $str .= '(';
            }
            $result['open'] = $str;
        }
        switch (count($keywords)) {
            case 3:
                $result['logical'] = strtoupper($keywords[0]);
                $result['field'] = $keywords[1];
                $result['comparison'] = strtolower($keywords[2]);
                break;
            case 2:
                if(in_array(strtolower($keywords[0]), $logical)){
                    $result['logical'] = strtoupper($keywords[0]);
                    $result['field'] = $keywords[1];
                }else{
                    $result['field'] = $keywords[0];
                    $result['comparison'] = strtolower($keywords[1]);
                }
                break;
            case 1:
                $result['field'] = $keywords[0];
                break;
            default:
                throw new Exception("The search field does not conform to the parameter specification.");
                break;
        }
        if($close_cnt>0){
            $str = '';
            for ($i=0; $i < $close_cnt; $i++) { 
                $str .= ')';
            }
            $result['close'] = $str;
        }
        return $result;
    }

    /**
     * 按照数据库字段自动转换值
     * @param  string  $filed_type  数据库字段类型
     * @param  any     $val         值
     * @param  boolean $except_null 是否处理null值，默认为忽略
     * @return any                  转换后的值
     */
    public function optimize_val_by_field_type($filed_type, $val, $except_null = true)
    {
        $rule = array('tinyint'=>'intval', 'smallint'=>'intval', 'int'=>'intval', 'bigint'=>'intval', 'float'=>'floatval', 'decimal'=>'floatval', 'char'=>'trim', 'varchar'=>'trim', 'bit' =>'boolval', 'text'=>'trim');
        
        if (is_array($val)){
            $types = array_fill(0,count($val),$filed_type);
            $excepts = array_fill(0,count($val),$except_null);
            $val = array_map(array(&$this, 'optimize_val_by_field_type'),$types,$val,$excepts);
            return $val;
        } if (isset($rule[$filed_type])){
            if($except_null && gettype($val) == 'NULL'){
                return $val;
            }
            return $rule[$filed_type]($val);
        } else {
            return $val;
        }
    }

    /**
     * 按照值，编译搜索语句。 按照类型处理null，in, escape等方法
     * @param  any     $val PHP格式的键值
     * @return string       SQL格式字符串
     */
    public function trans_where_val($val)
    {
        switch (gettype($val)) {
            case 'string':
                $trim_val = strtolower(trim($val));
                if($trim_val == '`null`'){
                    return 'IS NULL';
                }elseif($trim_val == '`not null`'){
                    return 'IS NOT NULL';
                }
                return $this->db->escape(trim($val));
                break;
            case 'array':
                if(count($val) == 0){
                    return '\'\'';
                }
                if(count($val) == 1){
                    return $this->db->escape(current($val));
                }

                $val = array_filter($val, function($v, $k) {
                    return gettype($v) != 'NULL';
                }, ARRAY_FILTER_USE_BOTH);
                $str = $this->db->escape($val);
                return 'IN('.implode(',', $str).')';
                break;
            case 'NULL':
                return 'IS NULL';
                break;
            case 'object':
            case 'resource':
            case 'unknown type':
                throw new Exception(gettype($val)." type is not supported.");
                break;
            
            default:
                return $val;
                break;
        }
    }


}

// 入驻商后台模型
class BUS_Model extends CI_Model
{
    protected $busid;
    //构造函数
    public function __construct()
    {
        parent::__construct();
        if(!empty($_SESSION['bus_info']) && !empty($_SESSION['bus_info']['sId'])) {
            $this->busid = $_SESSION['bus_info']['sId'];
        }else {
            exit("无入驻商信息");
        }
    }

    //检查图片地址
    public function checkImageUrl($img)
    {
        if(empty($img)) {
            $img = bus_style_dir('img/empty.jpg');
        }else if(!empty($img) && strpos($img, 'http') !== 0) {
            $img = base_url($img);
        }
        return $img;
    }
}

require_once(APPPATH.'core/MY_Model2.php');
