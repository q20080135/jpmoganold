<?php
/**
* 极光类
*/
class Jpush
{
	private $app_key = '1aadf1738200964f6fd4d9b8';//4805ff13416b3cc4966f8e6f  /c8c34967b8c52b0a8e695c25
    private $master_secret = 'd5e0773bc942b3ba87addb8a';  //serect:462208a3baeef2b6e7c4a991  cc7bc868e3272aed90364303
    public $client = '';
	function __construct()
	{
		$this->ci = & get_instance();
		$this->client = new \JPush\Client($this->app_key,$this->master_secret);
	}
	/**
	 * 注册id发送
	 * @param id 注册id
	 * @param title 标题
	 * @param content 内容
	 * @param extras 参数 数组
	 */
	public function sendById($id,$title = '',$content = '',$extras = null){

 		try {
	    	$response = $this->client->push()
	        ->setPlatform(array('ios','android'))
	        // 一般情况下，关于 audience 的设置只需要调用 addAlias、addTag、addTagAnd  或 addRegistrationId
	        // 这四个方法中的某一个即可，这里仅作为示例，当然全部调用也可以，多项 audience 调用表示其结果的交集
	        // 即是说一般情况下，下面三个方法和没有列出的 addTagAnd 一共四个，只适用一个便可满足大多数的场景需求

	        // ->addAlias('alias')
	        //->addTag(array('tag1', 'tag2'))
	        ->addRegistrationId($id)
	        ->androidNotification($content, array(
	        	//提示框标题
	            'title' => $title,
	            'extras' =>$extras,
	        ))
	        ->iosNotification($content, array(
	            'sound' => 'sound.caf',
	            // 'badge' => '+1',
	            // 'content-available' => true,
	            // 'mutable-content' => true,
	            'category' => 'jiguang',
	            'extras' => $extras,
	        ))
	        /*->message($message['content'], array(
	            'title' => $message['title'],
	            // 'content_type' => 'text',
	            'extras' =>$message['data'],
	        ))*/
	        ->options(array(
	            // sendno: 表示推送序号，纯粹用来作为 API 调用标识，
	            // API 返回时被原样返回，以方便 API 调用方匹配请求与返回
	            // 这里设置为 100 仅作为示例

	            // 'sendno' => 100,

	            // time_to_live: 表示离线消息保留时长(秒)，
	            // 推送当前用户不在线时，为该用户保留多长时间的离线消息，以便其上线时再次推送。
	            // 默认 86400 （1 天），最长 10 天。设置为 0 表示不保留离线消息，只有推送当前在线的用户可以收到
	            // 这里设置为 1 仅作为示例

	            // 'time_to_live' => 1,

	            // apns_production: 表示APNs是否生产环境，
	            // True 表示推送生产环境，False 表示要推送开发环境；如果不指定则默认为推送生产环境

	            'apns_production' => false,

	            // big_push_duration: 表示定速推送时长(分钟)，又名缓慢推送，把原本尽可能快的推送速度，降低下来，
	            // 给定的 n 分钟内，均匀地向这次推送的目标用户推送。最大值为1400.未设置则不是定速推送
	            // 这里设置为 1 仅作为示例

	            // 'big_push_duration' => 1
	        ))
	        ->send();

			
			if($response['http_code']==200){
				$data = array(
					'jpType'=>'1',
					'jpRegid'=>$id,
					'jpExtras'=>serialize($extras),
					'jpTitle'=>$title,
					'jpContent'=>$content,
					'jpResponse'=>serialize($response),
				);
				$this->ci->load->model("jt_admin/Jpush_model",'jpush_m');
				$rdata = $this->ci->jpush_m->insert($data);
				if($rdata){
					$data = array(
        				'status' => 1,
        				'message' => '推送成功',
        			);
				}else{
					$data = array(
        				'status' => 2,
        				'message' => '推送成功,插入数据库失败。',
        			);
				}
				
            	return $data;
			}else{
				$data = array(
        				'status' => 3,
        				'message' => '推送失败',
        			);
            	return $data;
			}
        } catch (\JPush\Exceptions\APIConnectionException $e) {
        	$data = array(
        				'status' => 4,
        				'message' => '推送失败',
        				'error' => $e
        			);
            return $data;
        } catch (\JPush\Exceptions\APIRequestException $e) {
            $data = array(
        				'status' => 5,
        				'message' => '推送失败',
        				'error' => $e
        			);
            return $data;
        }
	}
	/**
	 * 群发
	 * @param message 信息 (群发时标题为app 应用名  所以直接传内容)
	 * @param extras 参数 数组
	 */
	public function sendAll($message,$extras =null){
        try {
        	$push_payload = $this->client->push()->setPlatform('all')->addAllAudience()->setNotificationAlert($message)
        	->androidNotification($message, array(
	        	//提示框标题
	            'extras' =>$extras,
	        ))->iosNotification($message, array(
	            'sound' => 'sound.caf',
	            // 'badge' => '+1',
	            // 'content-available' => true,
	            // 'mutable-content' => true,
	            'category' => 'jiguang',
	            'extras' => $extras,
	        ));
            $response = $push_payload->send();
   			if($response['http_code']==200){
				$data = array(
					'jpType'=>'0',
					'jpContent'=>$message,
					'jpResponse'=>serialize($response),
					'jpExtras'=>serialize($extras),
				);
				$this->ci->load->model("jt_admin/Jpush_model",'jpush_m');
				$rdata = $this->ci->jpush_m->insert($data);
				if($rdata){
					$data = array(
        				'status' => 1,
        				'message' => '推送成功',
        			);
				}else{
					$data = array(
        				'status' => 2,
        				'message' => '推送成功,插入数据库失败。',
        			);
				}
				
            	return $data;
			}else{
				$data = array(
        				'status' => 3,
        				'message' => '推送失败',
        			);
            	return $data;
			}
        } catch (\JPush\Exceptions\APIConnectionException $e) {
        	$data = array(
        				'status' => 4,
        				'message' => '推送失败',
        				'error' => $e
        			);
            return $data;
        } catch (\JPush\Exceptions\APIRequestException $e) {
            $data = array(
        				'status' => 5,
        				'message' => '推送失败',
        				'error' => $e
        			);
            return $data;
        }
	}

}
function classLoader($class)
{
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $file = __DIR__ . '/src/' . $path . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
}
spl_autoload_register('classLoader');

