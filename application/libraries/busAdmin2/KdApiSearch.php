<?php
defined('BASEPATH') or exit('No direct script access allowed');
// 电商ID
defined('EBusinessID') or define('EBusinessID', 1273146);
// 电商加密私钥，快递鸟提供，注意保管，不要泄漏
defined('AppKey') or define('AppKey', '76da8729-d29d-44f2-b22d-5f7eff9264ac');
// 请求url
defined('ReqURL') or define('ReqURL', 'http://api.kdniao.cc/Ebusiness/EbusinessOrderHandle.aspx');

// 地区
class KdApiSearch
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
     * @param string $orderID  订单ID
     * 
     * @return array 快递查询结果
     */
    function getOrderTracesByJson($kdcode, $kdnumber, $orderID = 0)
    {
        $requestData = "{'OrderCode':'','ShipperCode':'%s','LogisticCode':'%s'}";
        $requestData = sprintf($requestData, $kdcode, $kdnumber);
        
        $datas = array(
            'EBusinessID' => EBusinessID,
            'RequestType' => '1002',
            'RequestData' => urlencode($requestData),
            'DataType' => '2'
        );
        $datas['DataSign'] = $this->encrypt($requestData, AppKey);
        //$result=$this->sendPost(ReqURL, $datas); //(原DEMO代码)
        $temps = array();
        foreach ($datas as $key => $value)
        {
            $temps[] = sprintf('%s=%s', $key, $value);
        }
        $post_data = implode('&', $temps);
        $result = $this->http_request(ReqURL, $post_data);
        
        return json_decode($result, true);
    }

    /**
     * -------------------------------------------
     * 原DEMO代码, 速度过慢, 抛弃
     * -------------------------------------------
     * post提交数据
     * 
     * @param string $url  请求Url
     * @param array $datas 提交的数据
     * 
     * @return url响应返回的html
     */
    function sendPost($url, $datas)
    {
        $temps = array();
        foreach ($datas as $key => $value) {
            $temps[] = sprintf('%s=%s', $key, $value);
        }
        $post_data = implode('&', $temps);
        
        $url_info = parse_url($url);
        if (empty($url_info['port']) || $url_info['port'] == '') {
            $url_info['port'] = 80;
        }
        
        $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
        $httpheader .= "Host:" . $url_info['host'] . "\r\n";
        $httpheader .= "Content-Type:application/x-www-form-urlencoded\r\n";
        $httpheader .= "Content-Length:" . strlen($post_data) . "\r\n";
        $httpheader .= "Connection:close\r\n\r\n";
        $httpheader .= $post_data;
        $fd = fsockopen($url_info['host'], $url_info['port']);
        fwrite($fd, $httpheader);
        $gets = "";
        $headerFlag = true;
        while (! feof($fd)) {
            if (($header = @fgets($fd)) && ($header == "\r\n" || $header == "\n")) {
                break;
            }
        }
        while (! feof($fd)) {
            $gets .= fread($fd, 128);
        }
        fclose($fd);
        
        return $gets;
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

    /**
     * 电商Sign签名生成
     * 
     * @param data   内容
     * @param appkey Appkey
     * 
     * @return DataSign签名
     */
    function encrypt($data, $appkey)
    {
        return urlencode(base64_encode(md5($data . $appkey)));
    }
}
?>