<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

if (!function_exists('save_base64_img')) {

    /**
     * 本地保存图片后随机生成图片名称
     * @param  [string]  $dir         [保存目录]
     * @param  [base64_img]  $base64_img [图片数据]
     * @param  [string]  $mime        [图片格式，只要是图片后缀随便都可以]
     * @param  integer $max_size    [上传图片大小限制，默认1Mb,单位Mb]
     * @return [bool || array || string]   上传失败返回false或array, 成功返回图片路径 
     */
    function saveBase64Img($base64_img, $dir, $mime = "png", $max_size = 1)
    {

        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_img, $result)) {

            $base_img = str_replace($result[1], '', $base64_img);
            
            $default = FCPATH . '/upload/';
            $dir = $default. $dir;
            $file     = base64_decode($base_img);
            $max_size = $max_size * 1024 * 1024;
            if (strlen($file) > $max_size) {
                return array('msg'=>'图片大小不能超过' . $max_size . 'Mb.');
            }
            $string = 'abcdefghijklmnopgrstuvwxyz0123456789';

            $rand     = substr($string, mt_rand(0, strlen($string) - 1), 4);
            $time     = date("ymdHis");
            $filename = $time . $rand . "." . $mime;
            create_folders($dir);

            $file_result = file_put_contents($dir . "/" . $filename, $file);
            if ($file_result) {
                return $filename;
            } else {
                return false;
            }

        }

        
    }
}

if (!function_exists('uploadQiniuBase64Img')) {
    function uploadQiniuBase64Img($base64_img, $dir, $mime = 'png', $max_size = 1)
    {
        $CI = &get_instance();
        $CI->load->library('Qiniu');
        $qiniu = new Qiniu();

        return $qiniu->uploadBase64Img($base64_img, $dir, $mime, $max_size);
    }
}

if (!function_exists('uploadfile')) {
    function uploadfile($filename, $dir,$size, $mime = 'png', $max_size = 2)
    {
        $CI = &get_instance();
        $CI->load->library('Qiniu');
        $qiniu = new Qiniu();

        return $qiniu->uploadfile($filename, $dir,$size, $mime,$max_size);
    }
}
if (!function_exists('removeQiniuFile')) {
    function removeQiniuFile($file_url)
    {
        $CI = &get_instance();
        $CI->load->library('Qiniu');
        $qiniu  = new Qiniu();
        $result = $qiniu->fileRemove($file_url);
        if ($result === null) {
            return true;    //删除成功
        } else {
            return false;
        }
    }
}
if (! function_exists('create_folders')) {
    function create_folders($dir)
    {
        return is_dir($dir) or (create_folders(dirname($dir)) and mkdir($dir, 0777));
    }
}
if (! function_exists('base64EncodeImage')) {
    /**
     * 图片转换为base64
     * @param unknown 文件名
     * @return string
     */
    function base64EncodeImage ($image_file) {
        $base64_image = '';
        $image_info = getimagesize($image_file);
        $image_data = fread(fopen($image_file, 'r'), filesize($image_file));
        $base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));
        return $base64_image;
    }
}

