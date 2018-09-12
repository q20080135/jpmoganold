<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

//查询参数
class FormatQuery
{
    protected $CI;
    protected $maxLimit;
    protected $defalutLimit;
    protected $defalutOrder;
    protected $defalutSort;
    protected $orderArr;
    protected $sortArr;
    protected $searchArr;
    protected $query;
    
    //构造函数
    function __construct($config = array())
    {
        // $this->CI = & get_instance();
        $this->init($config);
    }

    /**
     * $config 配置信息
     * maxLimit  [int]      最大的limit (默认: 50)
     * defLimit  [int]      默认的limit (默认: 10)
     * defOrder  [string]   默认的order (默认: desc)
     * defSort   [string]   默认的sort
     * sortArr   [array]    允许排序的字段 key为post字段, value为数据库字段(如: array('addtime' => 'so.oAddTime'))
     * searchArr [array]    允许搜索的字段 (可为null, 会自动转为空数组)
     *  -- alias [string]   别名,如果没有则用键值名
     *  -- allow [array]    指定搜索的内容范围
     *  -- value [int/string]     用于设置必选字段的默认值, 可不在allow之内
     *  -- except[array]    特殊字段
     *  -- except_func [function] 处理特殊字段的函数, 最优处理
     *  -- myfunction  [function] 自定义添加的处理函数
     */
    protected function init($config)
    {
        $max_limit = 50;
        $default_limit = 10;
        $default_order = 'DESC';
        $this->maxLimit = (isset($config['maxLimit']) && $config['maxLimit'] > 0) ? $config['maxLimit'] : $max_limit;
        $this->defalutLimit = (isset($config['defLimit']) && $config['defLimit'] > 0) ? $config['defLimit'] : $default_limit;
        if($this->defalutLimit > $this->maxLimit) $this->defalutLimit = $this->maxLimit;
        $this->defalutOrder = !empty($config['defOrder']) ? $config['defOrder'] : $default_order;
        $this->orderArr = array('DESC', 'ASC');
        if(!empty($config['defSort'])) $this->defalutSort = $this->formartkey($config['defSort']);
        if(!empty($config['sortArr']) && is_array($config['sortArr'])) $this->sortArr = $config['sortArr'];
        if(!empty($config['searchArr']) && is_array($config['searchArr'])) $this->searchArr = $config['searchArr'];
        $this->query = array(
            'order' => $this->defalutOrder,
            'sort' => $this->defalutSort,
            'offset' => 0,
            'limit' => $this->defalutLimit,
            'searchs' => array(),
            'wheres' => array(),
            'sorts' => array(),
            'whereStr' => ' ',
            'whereAfter' => ' ',
        );
    }
    
    //设置参数
    public function setParams($params)
    {
        $this->query['order'] = (!empty($params['order']) && in_array(strtoupper($params['order']), $this->orderArr)) ? 
            $params['order'] : $this->defalutOrder;
        $this->query['sort'] = (!empty($params['sort']) && !empty($this->sortArr) && !empty($this->sortArr[$params['sort']])) ? 
            $this->formartkey($this->sortArr[$params['sort']]) : $this->defalutSort;
        $this->query['offset'] = !empty($params['offset']) ? $params['offset'] : 0;
        $this->query['limit'] = (!empty($params['limit']) && $params['limit'] > 0) ? 
            ($params['limit'] > $this->maxLimit ? $this->maxLimit : $params['limit']) : $this->defalutLimit;
        if(!empty($this->query['sort'])) {
            $this->query['sorts'][] = "{$this->query['sort']} {$this->query['order']}";
        }
        if(!empty($params['search']) && !empty($this->searchArr)) {
            $searchs = is_array($params['search']) ? $params['search'] : json_decode($params['search'], true);
            $searchs = !empty($searchs) ? $searchs : array();
            $default_searchs = array();
            foreach($this->searchArr as $key => $val) {
                //取出默认值
                if(isset($val['value'])) $default_searchs[$key] = $val['value'];
                //验证搜索设置是否正确
                else if(is_null($val) || !is_array($val)) $this->searchArr[$key] = array();
            }
            $searchs = array_merge($default_searchs, $searchs);
            foreach($searchs as $key => $val) {
                /**
                 * 验证是否允许搜索
                 * 1. 是否在允许范围内
                 * 2. 搜索内容是否为空
                 */
                if(isset($this->searchArr[$key]) && $this->allowEmpty($val)) {
                    $string = null;
                    $value = addslashes(trim($val));
                    $item = $this->searchArr[$key];
                    $name = !empty($item['alias']) ? $item['alias'] : $key;
                    $name = $this->formartkey($name);
                    if(!empty($item) && is_array($item)) {
                        if(isset($item['allow']) && is_array($item['allow']) && !in_array($val, $item['allow']) && !isset($item['value'])) {
                            //如果包含搜索范围, 且在范围之外, 也没有默认值, 则不予搜索
                            continue;
                        }else if(isset($item['except']) && is_array($item['except']) && in_array($val, $item['except'])) {
                            //如果存在特殊字段的处理, 则优先给予处理
                            if(isset($item['except_func']) && is_callable($item['except_func'])) {
                                $string = call_user_func($item['except_func'], $value);
                            }
                        }else if(isset($item['myfunction']) && is_callable($item['myfunction'])) {
                            //如果存在自定义处理函数, 则用自定义函数处理
                            $string = call_user_func($item['myfunction'], $value);
                        }else if(!empty($item['rule'])) {
                            //此处慎用sprintf, 因为$item['rule']可能含有%会导致错误
                            $string = str_replace('%s', $value, $item['rule']);
                        }
                    }
                    $string = str_replace('%alias%', $name, $string);
                    //如果上面的情况都未出现, 则用默认的条件
                    if(!$string) $string = "{$name} = '{$value}'";
                    $this->query['searchs'][$key] = $value;
                    $this->query['wheres'][] = $string;
                }
            }
        }
    }

    //格式化sql查询字段: a.id => `a`.`id` 
    public function formartkey($keyname)
    {
        if(!empty($keyname) && is_string($keyname)) {
            $arr = array_map(function($item) {return "`{$item}`";}, explode('.', $keyname));
            $keyname = implode('.', $arr);
        }
        return $keyname;
    }

    //允许为空的值
    public function allowEmpty($val)
    {
        if(isset($val) && $val === 0 || $val === '0' || $val === false) {
            return true;
        }else {
            return !empty($val);
        }
    }

    //添加搜索条件
    public function setWhere($addwhere)
    {
        if(!empty($addwhere) && is_array($addwhere)) {
            $this->query['wheres'] = array_merge($this->query['wheres'], $addwhere);
        }
    }

    //添加排序规则
    public function setSort($addsort, $onAfter = true)
    {
        if(!empty($addsort)) {
            if(is_string($addsort)) {
                if($onAfter) {
                    array_push($this->query['sorts'], $addsort);
                }else {
                    array_unshift($this->query['sorts'], $addsort);
                }
            }else if(is_array($addsort)) {
                $this->query['sorts'] = $onAfter ? array_merge($this->query['sorts'], $addsort) : 
                    array_merge($addsort, $this->query['sorts']);
            }
        }
    }

    //返回参数
    public function getParams()
    {
        //拼接起来的sql字符串
        if(!empty($this->query['wheres'])) {
            $this->query['whereStr'] = ' WHERE ' . implode(' AND ', $this->query['wheres']);
        }
        if(!empty($this->query['sorts'])) {
            $this->query['whereAfter'] = ' ORDER BY ' . implode(',', $this->query['sorts']) .
            " LIMIT {$this->query['offset']}, {$this->query['limit']}";
        }
        return $this->query;
    }
}
