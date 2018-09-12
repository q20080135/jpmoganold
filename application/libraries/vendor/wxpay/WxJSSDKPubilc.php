<?php
/**
 * 微信公众号开发 JS-SDK 帮助库
 * =====================================================
 * 【CommonJsSDK】常用工具：
 * 		trimString()，设置参数时需要用到的字符处理函数
 * 		createNoncestr()，产生随机字符串，不长于32位
 * 		formatBizQueryParaMap(),格式化参数，签名过程需要用到
 * 		getSign(),生成签名
 * 		arrayToXml(),array转xml
 * 		xmlToArray(),xml转 array
 * 		postXmlCurl(),以post方式提交xml到对应的接口url
 * 		postXmlSSLCurl(),使用证书，以post方式提交xml到对应的接口url
*/
	include_once("SDKRuntimeException.php");

/**
 * 所有接口的基类
 */
class Common_JsSDK_pub
{
	function __construct() {
	}
	
	public $Appid = "wxf3fbd509fb3c8918";
	public $AppSecret = "84f79d4c27cd28844f58fc646b3070de";

	function trimString($value)
	{
		$ret = null;
		if (null != $value) 
		{
			$ret = $value;
			if (strlen($ret) == 0) 
			{
				$ret = null;
			}
		}
		return $ret;
	}
	
	/**
	 * 	作用：产生随机字符串，不长于32位
	 */
	public function createNoncestr( $length = 32 ) 
	{
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789";  
		$str ="";
		for ( $i = 0; $i < $length; $i++ )  {  
			$str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);  
		}  
		return $str;
	}
	
	/**
	 * 	作用：格式化参数，签名过程需要使用
	 */
	function formatBizQueryParaMap($paraMap, $urlencode)
	{
		$buff = "";
		
		ksort($paraMap);
		foreach ($paraMap as $k => $v)
		{
		    if($urlencode)
		    {
			   $v = urlencode($v);
			}

			$buff .= ($k . "=" . $v . "&");
		}
		$reqPar;
		if (strlen($buff) > 0) 
		{
			$reqPar = substr($buff, 0, strlen($buff)-1);
		}
		return $reqPar;
	}
	
	/**
	 * 	作用：生成签名
	 */
	public function getSign($Obj)
	{
		$arr = array();
		foreach ($Obj as $k => $v)
		{
			$arr[$k] = $v;
		}
		//签名步骤一：按字典序排序参数
		ksort($arr);
		$String = $this->formatBizQueryParaMap($arr, false);

		//签名步骤二：对String进行sha1加密
		$result_ = sha1($String);

		return $result_;
	}
	
	/**
	 * 	作用：array转xml
	 */
	function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
        	 if (is_numeric($val))
        	 {
        	 	$xml.="<".$key.">".$val."</".$key.">"; 

        	 }
        	 else
        	 	$xml.="<".$key."><![CDATA[".$val."]]></".$key.">";  
        }
        $xml.="</xml>";
        return $xml; 
    }
	
	/**
	 * 	作用：将xml转为array
	 */
	public function xmlToArray($xml)
	{		
        //将XML转为array        
        $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);		
		return $array_data;
	}

	
	/**
	 * 	作用：以get方式提交到对应的接口url
	 */
	public function getDataCurl($url,$second=30)
	{
		//初始化curl
		$ch = curl_init();
		//设置超时
		//curl_setopt($ch, CURLOP_TIMEOUT, $second);
		//这里设置代理，如果有的话
		//curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
		//curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
		//设置header
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		//要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		//运行curl
		$data = curl_exec($ch);
		//curl_close($ch);
		//返回结果
		if($data)
		{
			curl_close($ch);
			return json_decode($data, true);
		}
		else
		{
			$error = curl_errno($ch);
			echo "curl出错，错误码:$error"."<br>";
			echo "<a href='http://curl.haxx.se/libcurl/c/libcurl-errors.html'>错误原因查询</a></br>";
			curl_close($ch);
			return false;
		}
	}
	
	/**
	 * 	作用：打印数组
	 */
	function printErr($wording='',$err='')
	{
		print_r('<pre>');
		echo $wording."</br>";
		var_dump($err);
		print_r('</pre>');
	}
}


/**
 *  生成微信JSSDK config初始化配置
 * */
class JsSDK_config extends Common_JsSDK_pub
{
	function getTicket()
	{
		//获取access_token
		$url1 = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=";
		$url1 .= ($this->Appid . "&secret=" . $this->AppSecret);
		$ret1 = $this->getDataCurl($url1);
		$access_token = $ret1['access_token'];
		//获取jsapi_ticket
		$url2 = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=";
		$url2 .= ($access_token . "&type=jsapi");
		$ret2 = $this->getDataCurl($url2);
		$jsapi_ticket = $ret2['ticket'];
		
		return $jsapi_ticket;
	}
	
	/**
	 * @param array $ApiList 接口列表
	 * @param bool  $debug   是否开启debug
	 * 
	 * @return string json_decode($ret)
	 * */
	function createConfigJson($ApiList, $debug = false)
	{

		$i = 0;
		$url="";
		$timestamp = time();
		$noncestr = $this->createNoncestr();
		if(!empty($_SERVER ['QUERY_STRING']))
		{
			$url = 'http://' . $_SERVER ['HTTP_HOST'] . $_SERVER ['PHP_SELF'] . '?' . $_SERVER ['QUERY_STRING'];
		}
		else
		{
			$url = 'http://' . $_SERVER ['HTTP_HOST'] . $_SERVER ['PHP_SELF'];
		}

		$ticket = $this->getTicket();
		
		//生成签名需要的数据集合
		$arr = array(
			"jsapi_ticket" => $ticket,
			"noncestr" => $noncestr,
			"timestamp" => $timestamp,
			"url" => $url
		);

		//根据数据生成签名
		$sign = $this->getSign($arr);
		
		//生成最终数据集合
		$ret = array(
			"debug" => $debug,
			"appId" => $this->Appid,
			"timestamp" => $timestamp,
			"nonceStr" => $noncestr,
			"signature" => $sign,
			"jsApiList" => $ApiList
		);

		return json_encode($ret);
		//return ($ret);
	}
}


?>