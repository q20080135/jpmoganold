<?php

/**
 * 上传到七牛
 * @param $filePath, 本地文件路径
 * @param $key，上传后保存的文件名
 */
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;

require_once dirname(__FILE__) . '/vendor/autoload.php';

class Qiniu
{
    // https://portal.qiniu.com/user/key
    const ACCESSKEY = 'BHG3m2T2ruMR_Pb0kSVX8JKNlxT3tIeL0EmQfFBV'; //访问Key
    const SECREKEY = 'lUO7s9KZn52Oxxh380kqQJyN9gA5QBTwlX-9Mqw8'; //秘钥
    
    const BUCKET = 'jt-mart'; //空间名 [bucket]

    // https://portal.qiniu.com/domain
    // *.bkt.clouddn.com为新创建存储空间后系统默认为用户生成的测试域名，
    // 此类测试域名，限总流量，限单 IP 访问频率，限速，仅供测试使用。
    // 账户余额少于10元，暂无权限使用融合 CDN， 需要充值
    const SERVER = 'http://oh0xc3p8t.bkt.clouddn.com/'; //外链域名
    private $tmp_img_dir = '/upload/qiniu/images'; //图片临时保存文件夹 [以CI根目录为准]

    private $auth;
    private $token;
    public function __construct()
    {
        //初始化
        $this->auth = new Auth(self::ACCESSKEY, self::SECREKEY);
        $this->token = $this->auth->uploadToken(self::BUCKET);
        $this->tmp_img_dir = dirname(dirname(dirname(__FILE__))). $this->tmp_img_dir;

    }
    /**
     * 获取上传权限
     */
    public function getUploadAuthToken()
    {
        return $this->token;
    }
    /**
     * 上传Base64图片到七牛服务器
     * @param  [base64_img]  $base64_img [Base64图片]
     * @param  string  $dir        [description]
     * @param  string  $ext        [description]
     * @param  integer $max_size   [description]
     * @return [bool || array || string]   上传失败返回false或array, 成功返回图片路径 
     */
    public function uploadBase64Img($base64_img, $dir = '', $ext = "png", $max_size = 1)
    {
        /** 保存到临时文件夹  **/
        $file = base64_decode($base64_img);
        $max_size = $max_size * 1024 * 1024;
        if (strlen($file) > $max_size) {
            return array('msg'=>'图片大小不能超过' . $max_size . 'Mb.');
        }
        $string = 'abcdefghijklmnopgrstuvwxyz0123456789';
        
        $rand = substr($string, mt_rand(0, strlen($string) - 1), 4);
        $time = date("ymdHis");
        $filename = $time . $rand . "." . $ext;
        create_folders($this->tmp_img_dir);

        $file_result = file_put_contents($this->tmp_img_dir . "/" . $filename, $file);

        /** //保存到临时文件夹  **/
        
        if ($file_result) {
            if ($dir) {
                $dir = $dir . '/';
            }
            $file_name = $dir . date('Y/m/d/', time()) . uniqid() . '.' . $ext; //存入的文件路径
            $file_name = str_replace('//', '/', $file_name);

            //初始化 UploadManager 对象并进行文件的上传。
            
            $uploadMgr = new UploadManager();
            $temp_file = $this->tmp_img_dir . "/" . $filename;
            list($ret, $err) = $uploadMgr->putFile($this->token, $file_name, $temp_file);

            if ($err !== null) {
                return false;
            } else {
                $url = self::SERVER . $ret['key'];
                //返回url
                return $url;
            }
        } else {
            return false;
        }
    }

    /**
     * 图片删除
     *  @param $url, 一张图片链接地址
     *  @param $key，图片的名称
     *  @return 成功返回NULL，失败返回对象{"error" => "<errMsg string>", ...}
     */
    public function fileRemove($url)
    {
        //去掉七牛的链接，取到文件名
        $url = str_replace(self::SERVER, '', urldecode($url));
        // $option = array('?imageView2/2/w/1280', '?imageView2/2/w/240/h/240', '?imageView2/2/w/640');
        // $key = str_replace($option, '', $url);
        $bucketmgr = new BucketManager($this->auth);
        // dump($url);
        $res = $bucketmgr->delete(self::BUCKET, $url);
        return $res;
    }



        /**
     * 文件上传
     * @param  [filename]  文件路径
     * @param  string  $dir        [description]
     * @param  string  $size  文件大小
     * @param  integer $max_size   [description]
     * @return [bool || array || string]   上传失败返回false或array, 成功返回图片路径 
     */
    public function uploadfile($filename, $dir = '',$size,$mine, $max_size = 2)
    {
        /** 保存到临时文件夹  **/

        $maxsize = $max_size * 1024 * 1024;
        if ($size > $maxsize) {
            return array("msg"=>'图片大小不能超过' . $max_size . 'Mb.');
        }
        
        if ($filename!='') {
            if ($dir) {
                $dir = $dir . '/';
            }
            $lsfile_name = $dir . date('Y/m/d/', time()) . uniqid() . '.' .$mine; //存入的文件路径
            $lsfile_name = str_replace('//', '/', $lsfile_name);

            //初始化 UploadManager 对象并进行文件的上传。
            
            $uploadMgr = new UploadManager();
            list($ret, $err) = $uploadMgr->putFile($this->token, $lsfile_name,$filename);

            if ($err !== null) {
                return false;
            } else {
                $url = self::SERVER . $ret['key'];
                //返回url
                return $url;
            }
        } else {
            return false;
        }
    }

}
