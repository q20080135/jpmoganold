<?php

class WaterChinese {

    var $Path = "./resource/static/api/images/"; //图片所在目录相对于调用此类的页面的相对路径
    var $FileName = "yhq.png"; //背景图片的名字
    var $Text = ""; //图片要加上的水印文字，支持中文
    var $TextColor = "#ffffff"; //文字的颜色，gif图片时，字体颜色只能为黑色
    var $TextBgColor = "#000000"; //文字的背景条的颜色
    var $Font = './resource/static/api/font/vh.ttf'; //字体的存放目录，相对路径
    var $Type = 1;
    var $x;
    var $y;

    public function __construct() {
        $this->Font = './resource/static/api/font/vh.ttf';
    }

    /* 功能：类的析构函数(php5.0以上的形式) */

    function __destruct() {
        
    }

    function Run() {
        if ($this->FileName == "" || $this->Text == "")
            return;
        /* 检测是否安装GD库 */
        if (false == function_exists("gd_info")) {
            echo "系统没有安装GD库，不能给图片加水印.";
            return;
        }
        /* 设置输入、输出图片路径名 */
        $arr_in_name = explode(".", $this->FileName);
        $inImg = $this->Path . $this->FileName;
        $outImg = $inImg;
        $tmpImg = $this->Path . $arr_in_name[0] . "_tmp." . $arr_in_name[1]; //临时处理的图片，很重要
        /* 检测图片是否存在 */
        if (!file_exists($inImg))
            return;
        /* 获得图片的属性 */
        $groundImageType = @getimagesize($inImg);
        $imgWidth = $groundImageType[0];
        $imgHeight = $groundImageType[1];
        $imgType = $groundImageType[2];
        /* 图片不是jpg/jpeg/gif/png时，不处理 */
        switch ($imgType) {
            case 1:
                $image = imagecreatefromgif($inImg);
                $this->TextBgColor = "#ffffff"; //gif图片字体只能为黑，所以背景颜色就设置为白色
                break;
            case 2:
                $image = imagecreatefromjpeg($inImg);
                break;
            case 3:
                $image = imagecreatefrompng($inImg);
                break;
            default:
                return;
                break;
        }
        /* 生成一个空的图片，它的高度在底部增加水印高度 */
        $newHeight = $imgHeight;
        $objTmpImg = @imagecreatetruecolor($imgWidth, $newHeight);
        /* 把原图copy到临时图片中 */
        @imagecopy($objTmpImg, $image, 0, 0, 0, 0, $imgWidth, $imgHeight);

        /* 创建要写入的水印文字对象 */
        $sAry = $this->Text;
        /* 写入文字水印 */
        if ($this->Type == 1) {
            $moneyColor = @imagecolorallocate($image, 229, 86, 69);
        } else {
            $moneyColor = @imagecolorallocate($image, 250, 144, 60);
        }
        $fontColor = @imagecolorallocate($image, 78, 78, 78);
        $timeColor = @imagecolorallocate($image, 210, 210, 210);
        $titleColor = @imagecolorallocate($image, 255, 255, 255);
        @imagettftext($objTmpImg,20, 0,20,60, $moneyColor, $this->Font, $sAry[0]);
        @imagettftext($objTmpImg,25, 0,45, 60, $moneyColor, $this->Font, $sAry[1]);
        @imagettftext($objTmpImg,12, 0,110,68, $fontColor, $this->Font, $sAry[2]);
        @imagettftext($objTmpImg,12, 0,25,83, $fontColor, $this->Font, $sAry[3]);
        @imagettftext($objTmpImg,9, 0,110,93, $timeColor, $this->Font, $sAry[4]);
        @imagettftext($objTmpImg,10, 0,114,29, $titleColor, $this->Font, $sAry[5]);
        header('Content-type:image/png');
        ob_clean();
        imagepng($objTmpImg);
        @imagedestroy($objTmpImg);
        @imagedestroy($image);
    }

}
