<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
  <title>搜索文章</title>
  <link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/new_css.css" />
  <link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/new_style.css" />
  <link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/new_home.css" /> 
  <link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/colorbox.css" /> 
  <link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/reset.css" /> 
  <link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/lww.css" /> 
</head>
<body>
<?php
Widget::load('front',array('view'=>'header'));
?>

   <script type="text/javascript" src="/resource/static/front/js/jquery-1.8.3.min.js"></script>
  <script type="text/javascript" src="/resource/static/front/js/new_myscript.js"></script> 
  <div class="new_content">
      <div style="min-height: 500px;width:50%;margin: auto;margin-top: 20px;">

          <h1 style="font-size: 32px">搜索关键字：<?php echo $s;?></h1>
          <br>

          <?php
          if(count($wdata)==0){
            echo '没有结果';
          }

           foreach ($wdata as $key=>$val):?>

            <h1 style="font-size: 28px;"><?php echo $val['aTitle'];?></h1>
            <h1 style="font-size: 14px;margin-top:20px;"><?php echo $val['aAddtime'];?></h1>
            <div style="margin-top: 20px;">
            <?php echo $val['aContent'];?>
            <?php 
            if($key<count($wdata)-1){
              echo '<hr />';
            }
            ?>
          <?php endforeach;?>
        </div>
      </div>
          

      
  </div>
<!--footer start--> 
<?php
Widget::load('front',array('view'=>'footer'));
?>
<!-- footer end --> 
<!--   <script type="text/javascript" src="/resource/static/front/js/footer.js"></script> -->
</body>
</html>