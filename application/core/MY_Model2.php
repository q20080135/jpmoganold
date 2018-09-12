<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

// 数据库操作基类
class MY_Model2 extends CI_Model
{
    protected $table;                                   // 主表名（无前缀）
    protected $_table;                                  // 主表名（带前缀）
    protected $fields;                                  // 主表字段
    public $_pk         = null;                         // 主表主键
    public $_del        = null;                         // 主表主键
    protected $is_cache = false;                        // 是否开启数据库缓存，默认关闭
    static private $_db = array();

    // 构造函数
    function __construct()
    {
        parent::__construct();
        $this->_set_table($this->table);
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
     * 获取指定字段的总和
     */
    public function get_sum($field, $where = null)
    {
        $_field = "SUM(`{$field}`) as $field";
        $res = $this->get_row($_field, $where);
        return $res ? $res[$field] : null;
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
        $this->db->insert($this->_table, $this->filter($res['item']));
        $res['insert_id'] = $this->db->insert_id();
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
        if (isset($data[$this->_pk]) && $data[$this->_pk]) {
            $get_files_where = $data[$this->_pk];
        } elseif ($where) {
            $get_files_where = $where;
        } else {
            $res['errors'] = array('没有指定更新条件');
            return false;
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

    public function get_list_v2($param = array())
    {
        $select = (isset($param['select'])) ? $param['select'] : '*';
        $where = (isset($param['where'])) ? $param['where'] : null;
        $join = (isset($param['join'])) ? $param['join'] : array();
        $group = (isset($param['group'])) ? $param['group'] : null;
        $order = (isset($param['order'])) ? $param['order'] : null;
        $limit = (isset($param['limit'])) ? $param['limit'] : 10;
        $offset = (isset($param['offset'])) ? $param['offset'] : 0;
        if($group){
            $order = $order.'& '.$group;
        }
        return $this->get_list($select,$where,$join,$order,$limit,$offset);
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
        $tbl_info = $this->get_field_type($join);

        $this->join_tables($join,false);
        
        if (isset($tbl_info['fields'][$this->_table . '.is_del'])) {
            $this->db->where($this->_table . '.is_del', 0);
        }

        if ($where) {
            $where_sql = $this->build_where($where,$tbl_info);
            if($where_sql !== ''){
                $this->db->where($where_sql, null, false);
            }
        }
         
        $select = $this->filter_fields($select,$tbl_info);
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
     * 获取数据表字段类型
     */
    public function get_field_type($join)
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
        } else {
            $_tables[]  = $join[0]; 
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
        return $res;
    }
    public function join_tables($join,$get_query = true)
    {
        if(empty($join)){
            if($get_query){
                return '';
            }
            return null;
        }

        $item = each($join);
        $sql = '';
        if (!is_numeric($item['key'])) {
            $joins = $join;
        } else {
            $joins[$join[0]] = $join[1];
        }
        $join_types = array('LEFT','RIGHT','OUTER','INNER','LEFT_OUTER','RIGHT_OUTER');
        $exception_list = array('AND','=','OR');
        foreach ($joins as $k => $v) {
            $tbl   = explode(' ', trim($k));
            if (count($tbl) == 3) {
                $join_type = $tbl[0];
                $table_name = $tbl[1];
            } else {
                $join_type = 'LEFT';
                $table_name = $tbl[0];
            }
            $join_type = strtoupper($join_type);
            if (!in_array($join_type, $join_types)) {
                $join_type = 'LEFT';
            }
            $alias = end($tbl);

            $join_table = $table_name . ' ' . $alias;
            
            if($get_query){
                $sql .= "\n".$join_type.' JOIN';
                $sql .= ' `'.$table_name . '` `' . $alias.'`';
                $sql .= ' ON';
            }
            $join_key = explode(' ', trim($v));
            $join_keys = '';
            foreach ($join_key as $kk => $vv) {
                $vv = trim($vv);
                if($vv != ''){
                    if(in_array(strtoupper($vv), $exception_list)){
                        $vv = strtoupper($vv);
                        $get_query && $sql .= ' '.$vv;
                    }else{
                        $vv = (substr_count($vv, '.') == 1)?$vv:$this->_table.'.'.$vv;
                        if($get_query){
                            if(substr_count($vv, '.') == 1){
                                $sql .= ' `'.str_replace('.', '`.`',$vv).'`';
                            }else{
                                $sql .= ' `'.$vv.'`';
                            }
                        }
                    }
                }
                $join_keys .= ' '.$vv;
            }
            $get_query || $this->db->join($join_table, $join_keys, $join_type);

        }

        if($get_query){
            return $sql;
        } 
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
     * 过滤字段（用括号包住可以忽略过滤）
     * @param  string $filds      未过滤的列
     * @param  array  $table_info 表、字段信息
     * @return string             过滤后的列
     */
    public function filter_fields($fields,$table_info)
    {
        // 先把括号里的移除掉，放入$brackets里
        $brackets = array();
        $open_bracket = array();
        preg_match_all('/(\(|\))/', $fields, $m1, PREG_OFFSET_CAPTURE);
        
        if(count($m1[0])>0){
            foreach ($m1[0] as $k => $v) {

                if($v[0] == '('){
                    array_push($open_bracket, $v[1]);
                }else{
                    if(end($open_bracket) !== false){
                        $brackets[] = substr($fields, end($open_bracket), $v[1]-end($open_bracket)+1);
                        array_pop($open_bracket);
                    }
                }
            }
            for ($i=count($brackets)-1; $i >= 0; $i--) { 
                $fields = str_replace($brackets[$i], '%'.$i.'%', $fields);
            }
        }

        // 分离字段后再括号内容放回原位
        $select  = explode(',', $fields);
        $_select = array();

        foreach ($select as $k => $v) {
            $v = trim($v);
            preg_match_all('/((?!:\%)\d(?!:\%))/', $v, $m2);
            if(count($m2[0])>0){
                foreach ($m2[0] as $vv) {
                    $v = str_replace('%'.$vv.'%',$brackets[$vv], $v);
                }
                array_push($_select, $v);
                
            }else{
                // array_push($_select, $v);  

                $_tmp = explode(' ', $v);
                $_tmp2 = explode('.',$_tmp[0]);
                if(count($_tmp2) == 2){
                    $_tmp2[0] = strtolower($_tmp2[0]);
                    foreach ($table_info['tables'] as $k => $v) {
                        if(strtolower($k) == $_tmp2[0] || strtolower($v) == $_tmp2[0]){
                            $table_name = $k;
                            break;
                        }else{
                            $table_name = null;
                        }
                    }
                    $filed_name = $_tmp2[1];
                }else{
                    $table_name = $this->_table;
                    $filed_name = $_tmp2[0];
                }
                $field_key = $table_name . '.' . $filed_name;

                if($filed_name == '*'){
                    if (in_array($table_name, array_keys($table_info['tables']))) {
                        $_select[] = $field_key;
                    }else if(in_array($table_name, $table_info['tables'])){
                        $_select[] = $field_key;
                    }
                }else{
                    if($table_name) {
                        if(isset($table_info['fields'][$field_key])){
                            $_select[] = $field_key;
                        }else{
                            foreach ($table_info['fields'] as $k => $v) {
                                if(strtolower($k) == strtolower($field_key)){
                                    $_select[] = $k;
                                }
                            }
                        }
                    }
                }
            }
        }
        $_select = array_unique($_select);

        if(count($table_info['tables']) > 1){
            if($_select){
                $result = implode(', ', $_select);
            }else{
                $result = $this->_table.'.*';
            }
        }else{
            if($_select){
                $result = implode(', ', $_select);
                $result = str_replace($this->_table.'.', '', $result);
            }else{
                $result = '*';
            }
        }
        return $result;
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
        $fields = (isset($table_info['fields']))?$table_info['fields']:array();
        $all_fields = array_merge($fields,$this->fields);
        
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
        if(isset($table_info['tables']) && count($table_info['tables']) > 1){
            return $where_sql;
        }else{
            return str_replace('`'.$this->_table.'`.', '', $where_sql);
        }
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


        if(strpos($key_info['field'],'.') === false){
            $key_info['field'] = '`'.$key_info['field'].'`';
        }else{
            $_tmp = explode('.', $key_info['field']);
            if(count($_tmp) == 2){
                $key_info['field'] = '`'.$_tmp[0].'`.`'.$_tmp[1].'`';
            }
        } 

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
