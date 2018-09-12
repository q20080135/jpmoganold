<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
 * 阿里服务商快递接口信息
 * https://market.aliyun.com/products/57126001/cmapi010996.html?spm=5176.730005.0.0.L4RGIO#sku=yuncode499600008
 * 服务商:昆明秀派科技有限公司
 * 注：每个服务商的URL及访问参数和返回参数都不一样，请谨慎修改
 */
defined('HOST') or define('HOST', "http://ali-deliver.showapi.com");
defined('PATH') or define('PATH', "/showapi_expInfo");
defined('APPCODE') or define('APPCODE', "76fe363a4b6c474e9df7c0bcc0a0e813");

// 地区
class AliShowApi
{
    protected $CI;
    protected $_sysinfo;
    
    // 构造函数
    function __construct()
    {
        $this->CI = & get_instance();
        $this->_sysinfo = $this->CI->config->item('sysinfo');
    }

    /**
     * Json方式 查询订单物流轨迹
     * @param string $kdcode   快递公司代码
     * @param string $kdnumber 快递单号
     * 
     * @return array 快递查询结果
     */
    function getAliKDdate($kdnumber, $kdcode = 'auto')
    {
        $querys = sprintf('com=%s&nu=%s', $kdcode, $kdnumber);
        $result = $this->http_get($querys);
        
        $result = json_decode($result, true);
        //var_dump($result);
        //exit();
        return $result;
    }

    //阿里云快递接口提供的DEMO
    public function http_get($querys)
    {
        $method = "GET";
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . APPCODE);
        $url = HOST . PATH . "?" . $querys;
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        if (1 == strpos("$".HOST, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        
        $output = curl_exec($curl);
        curl_close($curl);
        
        return $output;
    }

    /**
     * HTTPS请求 (POST)
     *
     * @access protected
     * @param $url curl HTTP地址
     * @param $data post数据
     *
     * @return string
     */
    public function http_request($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        
        if (! empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        
        $output = curl_exec($curl);
        curl_close($curl);
        
        return $output;
    }
}
?>