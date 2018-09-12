<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<title>图片压缩拷贝</title>

<style type="text/css">
body {
    margin: 50px;
    padding: 10px;
    border: 1px solid #333;
    border-radius: 10px;
}
h3 {
    font-size: 18px;
    text-align: center;
    margin-bottom: 20px;
}
div.big {
    margin-top: 30px;
    border-top: 2px solid #333;
}
p.big {
    font-size: 16px;
    text-indent: 10px;
}
p.normal {
    font-size: 14px;
    text-indent: 10px;
    padding: 5px 0;
    border-top: 1px solid #666;
    border-bottom: 1px solid #666;
}
p.small {
    font-size: 12px;
    text-indent: 20px;
}
p.small_error {
    font-size: 12px;
    text-indent: 20px;
    font-weight: bold;
    color: #F44336;
}
</style>

</head>
<body>

<?php

session_start();
ini_set('max_execution_time', '0');
$_SESSION['success'] = 0;
$_SESSION['copy'] = 0;
$_SESSION['fail'] = 0;
$_SESSION['starttime'] = time();

/**
 * 生成图片目录
 * @param $src  图片目录
 */
function mkImgDir($src) {
    if(!is_dir($src)) {
        if(!is_dir($src)) {
            mkdir($src, 0777, true);
            echo '<p class="normal">成功创建目录 : ' . iconv('gbk', 'UTF-8', $src) . '</p>';
        }
    }
}

/**
 * 图片缩放并拷贝
 * @param $srcFile  目标图片路径
 * @param $new_dir  存放图片路径
 * @param $parcent  图片缩放比例
 * @param $filedir  当前遍历的目录路径
 */
function foreachImage($srcFile, $new_dir, $parcent = 0.6, $filedir = null) {
    if(empty($filedir)) {
        // if(!preg_match("/^[a-zA-Z0-9\s]+$/", $srcFile) || !preg_match("/^[a-zA-Z0-9\s]+$/", $new_dir)){
        //     echo "<h3>请用合法的英文名的目录名(子目录可用中文名)</h3>";
        //     return false;
        // }
        echo "<h3>正在从目录 {$srcFile} 压缩后拷贝到 {$new_dir} 中</h3>";
        mkImgDir($new_dir);
        $filedir = $srcFile;
    }
    //打开目录
    $dir = @ dir($filedir);
    while (($file = $dir->read()) !== false) {
        $file_fullname = $filedir . '/' . $file;
        if (empty($file) || ($file == ".") || ($file == "..")) {
            continue;
        }else if(is_dir($file_fullname)) {
            echo '<div class="big">';
            echo '<p class="big">正在拷贝：' . iconv('gbk', 'UTF-8', $file_fullname) . ' 目录</p>';
            echo '</div>';
            if(strpos($file_fullname, $srcFile) === 0) {
                mkImgDir($new_dir . substr($file_fullname, strlen($srcFile)));
            }
            foreachImage($srcFile, $new_dir, $parcent, $file_fullname);
        }else {
            echo '<p class="small">文件 : ' . iconv('gbk', 'UTF-8', $file_fullname) . '</p>';
            $name = explode('.', $file);
            $imgs = array('jpg', 'png', 'jpeg', 'gif');
            $file_save = $file_fullname;
            if(strpos($file_fullname, $srcFile) === 0) {
                $file_save = $new_dir . substr($file_fullname, strlen($srcFile));
            }else {
                $file_save = $new_dir . $file_fullname;
            }
            if(!file_exists($file_save) && count($name) > 1 && in_array($name[1], $imgs) && getimagesize($file_fullname)) {
                list($width, $height) = getimagesize($file_fullname);
                $newWidth = $width * $parcent;
                $newheight = $height * $parcent;
                $is_clear = true;
                $dst_im = imagecreatetruecolor($newWidth, $newheight);
                switch ($name[1]) {
                    case 'jpg':
                    case 'jpeg':
                        $src_im = @imagecreatefromjpeg($file_fullname);
                        if($src_im) {
                            imagecopyresized($dst_im, $src_im, 0, 0, 0, 0, $newWidth, $newheight, $width, $height);
                            imagejpeg($dst_im, $file_save);
                            $_SESSION['success']++;
                            echo '<p class="small">成功拷贝 : ' . $file_save . '</p>';
                        }else {
                            $is_clear = false;
                            $_SESSION['fail']++;
                            echo '<p class="small_error">拷贝失败 : ' . $file_save . '</p>';
                            copy($file_fullname, $file_save);
                        }
                        break;
                    case 'png':
                        $color = imagecolorallocate($dst_im, 255, 255, 255);
                        imagecolortransparent($dst_im, $color); 
                        imagefill($dst_im, 0, 0, $color);
                        $src_im = @imagecreatefrompng($file_fullname);
                        if($src_im) {
                            imagecopyresized($dst_im, $src_im, 0, 0, 0, 0, $newWidth, $newheight, $width, $height);
                            imagepng($dst_im, $file_save);
                            $_SESSION['success']++;
                            echo '<p class="small">成功拷贝 : ' . $file_save . '</p>';
                        }else {
                            $is_clear = false;
                            $_SESSION['fail']++;
                            echo '<p class="small_error">拷贝失败 : ' . $file_save . '</p>';
                            copy($file_fullname, $file_save);
                        }
                        break;
                    default:
                        $_SESSION['copy']++;
                        echo '<p class="small">未压缩拷贝 : ' . $file_save . '</p>';
                        copy($file_fullname, $file_save);
                        $is_clear = false;
                }
                if($is_clear) {
                    imagedestroy($dst_im);
                    imagedestroy($src_im);
                }
            }
        }
    }
}

if($_REQUEST) {
    $orignDir = !empty($_REQUEST['orignDir']) ? $_REQUEST['orignDir'] : null;
    $arriveDir = !empty($_REQUEST['arriveDir']) ? $_REQUEST['arriveDir'] : null;
    $ratio = !empty($_REQUEST['ratio']) ? floatval($_REQUEST['ratio']) : 0;
    if(!$orignDir) {
        exit('源目录不能为空!');
    }else if(!$arriveDir) {
        exit('存放目录不能为空!');
    }else if($ratio <= 0 || $ratio >= 1) {
        exit('压缩比率不合法!');
    }else {
        foreachImage($orignDir, $arriveDir, $ratio);

        echo '<div class="big">';
        echo '<p class="small">已成功压缩拷贝 ： ' . $_SESSION['success'] . ' 个</p>';
        echo '<p class="small">未压缩拷贝文件 ： ' . $_SESSION['copy'] . ' 个</p>';
        echo '<p class="small_error">拷贝文件失败 ： ' . $_SESSION['fail'] . ' 个</p>';
        echo '<p class="small">用时 ： ' . (time() - $_SESSION['starttime']) . 's</p>';
        echo '</div>';
    }
}

?>

</body>
</html>