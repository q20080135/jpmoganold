<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/*  图片文件上传
 * 	
 *	$Author ： linzeyong
 *	$Date : 2016.6.2 14:50 
 */
class UploadImage
{
	// CodeIgniter 对象
	public $CI;
	// 入驻商系统信息
	public $_sysinfo; 
	// 图片大小上限为 1000KB， 下限1KB
	public $max_size = 300;
	public $min_size = 1;
	
	//图片名称 返回结果 允许上传类型
	public $filename, $result, $allow_file_type;
	
	//构造函数
	function __construct()
	{
		$this->CI = & get_instance();
		$this->_sysinfo = $this->CI->config->item('sysinfo');
		$this->filename = date("YmdHis") . rand(10,99);
		$this->allow_file_type = array(
			'jpg' => "image/jpeg",	// jpe, jpeg, jpg, jpz
			'png' => "image/png",	// png, pnz
			'gif' => "image/gif",	// gif, ifm
			'bmp' => "image/bmp",	// bmp (注：网上查资料为application/x-MS-bmp ，测试为：image/bmp)
		);
	}
	
	//返回处理结果
	public function ret($err = 0, $msg = "", $name = "")
	{
		/*
		 * error 大于0 表示出错
		 * 为 -1 时表示上传成功
		 */
		$this->result['err'] = $err;
		$this->result['msg'] = $msg;
		$this->result['name'] = $name;
		
		return $this->result;
	}
	
	/**
	 * 图片文件上传
	 *
	 * @access  public
	 *  
	 * @param   array  	$file  		上传的文件信息
	 * @param   string 	$dir 		存储路径 (每个商家分配一个目录)
	 * @param   string  $src  		图片的调用地址前缀
	 * @param   string	$wh 		图片宽高比,如果未赋值则不限制
	 *  
	 * @return  array  	$result
	 */
	public function upload_image($file, $dir, $wh = "")
	{
		if(empty($file['name'])) {
			return $this->ret(1, "未获取到图片信息。");
		}
		
		if ($file["error"] > 0) {
			return $this->ret(2, $file["error"]);
		}else {
		    $dir = str_replace("\\", "/", $dir);
		    //$max_size = $this->max_size * 1024;
		    //$min_size = $this->min_size * 1024;
		    $file['size'] = sprintf("%.1f", $file['size']/1024);
			// 检查上传文件大小
			if($file["size"] > $this->max_size || $file["size"] < $this->min_size) {
				$str = "上传文件大小（" . $file["size"] . "KB）,超过规定范围(" .
						$this->min_size . "KB - " . $this->max_size . "KB)";
				
				return $this->ret(3, $str);
			}
			
			// 检查上传文件类型
			if(in_array($file["type"], $this->allow_file_type)) {
				$filetype = array_search($file["type"], $this->allow_file_type);
				$img_arr = getimagesize($file['tmp_name']);
				if(empty($img_arr) || empty($img_arr[0]) || empty($img_arr[1])) {
					return $this->ret(5, "获取图片的宽高失败！");
				}

				//如果是版本为5.4以上的版本, 启用压缩
				$versions = explode('.', PHP_VERSION);
				if(($versions[0] == 5 && $versions[1] >= 4) || $versions[0] > 5) {
					
				}

				if($wh && $wh != '') {
					// 检查上传图片宽高
					$arr = explode(":", $wh);
					if(!empty($arr) && !empty($arr[0]) && !empty($arr[1])) {
						$wh1 = intval($arr[1]) * $img_arr[0];
						$wh2 = intval($arr[0]) * $img_arr[1];
						if($wh1 != $wh2) {
							$str = "上传的图片(" . $img_arr[0] . " * " . $img_arr[1]."),";
							$str .= "与规定的宽高比(" . $arr[0] . " : " . $arr[1] . ") 不符";
							return $this->ret(4, $str);
						}
					}
				}

				// 检查目录
				if(!file_exists($dir)) {
					if (!mkdir($dir, 0777, true)) {
						/* 创建目录失败 */
						return $this->ret(7, "不存在上传目录，且创建失败！");
					}
				}
				
				// 生成 路径和文件 名
				$nfile = $this->create_file_name($dir, $this->filename, $filetype);
				// 检查文件
				if($nfile['name'] != "") {
					if(move_uploaded_file($file['tmp_name'], $nfile['dir'])) {
						// 上传成功！
						return $this->ret(-1, "上传成功", $nfile['name']);
					}else {
						$str = "move_uploaded_file 执行失败！";
						return $this->ret(9, $str);
					}
				}else {
					$str = "你上传的文件已存在过多，请到目录查看！";
					return $this->ret(10, $str);
				}
			}else  {
				$str = "上传文件类型不支持，目前支持：jpg,jpeg,png,gif,bmp.";
				return $this->ret(8, $str);
			}
			
		}
	}
	
	/**
	 * 生成图片名
	 * 检查上传文件是否存在
	 * 如果存在 添加后缀(1),(2)....(9)
	 * 其中有一个不存在就返回 新名称
	 * 如果1-9都存在 就返回false
	 * */
	public function create_file_name($dir, $name, $type, $i = 0)
	{
		$nfile = array(
			'name' => '',
			'dir' => ''
		);
		if($i > 9) {
			return $nfile;
		}else {
			if(file_exists($dir.$name.$type)) {
				if($i == 0) {
					$name = $name."(1)";
					$i++;
				}else {
					$name = str_replace("(".$i.")", "(".(++$i).")", $name);
				}
				return $this->create_file_name($dir, $name, $type, $i);
			}else {
				$nfile['name'] = $name . $type;
				$nfile['dir'] = $dir . $name . $type;
				
				return $nfile;
			}
		}
	}

}

?>