<!DOCTYPE html>
<html>
<head>
	 <meta charset="utf-8">
	<title>精彩回看</title>
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
  	<div class="back2c_display">
  	  <div class="back2c_display_center">
  		<p>WONDERFUL</p>
  		<p>精彩<span style="color:#fbb600">回看</span></p>
  		<p>WONDERFUL BACK TO SEE</p>
  	  </div>
  	</div>
  	<div class="back2c_text">
  	  <div class="back2c_text_top">
  	  	<p><i style="display:inline-block;width:50px;border-bottom:1px solid #b09373;position:relative;top:-5px;left:-30px"></i><b style="position:relative;top:-3px;left:-20px;display:inline-block;width:6px;height:6px;border-radius:3px;background-color:#bfbfbf"></b>
  	  		<span>精彩回看</span>
  	  		<b style="position:relative;top:-3px;left:20px;display:inline-block;width:6px;height:6px;border-radius:3px;background-color:#bfbfbf"></b><i style="position:relative;top:-5px;left:30px;display:inline-block;width:50px;border-bottom:1px solid #b09373"></i>
  	  	</p>
  	  	<p style="color:#444;font-size:28px;font-weight:bold">WONDERFUL BACK TO SEE</p>
  	  </div>
      <i></i>
      <ul>

         <?php foreach ($wdata as $key=>$val):?>
          <li>
            <div class="back2c_img_top">
              <img src="/upload/<?php echo $val['aImg'];?>" width="100%">
            </div>
            <div class="back2c_text_bot">
              <h1><?php echo $val['aTitle'];?> </h1>
              <p><?php echo $val['aDescription'];?></p>
              <a href="/xq.html/<?php echo $val['aID'];?>">更多</a>
            </div>
          </li>
        <?php endforeach;?>
      </ul> 
  	</div>
  </div>
 <?php
Widget::load('front',array('view'=>'footer'));
?>
<!-- footer end --> 
<!--   <script type="text/javascript" src="/resource/static/front/js/footer.js"></script> -->
</body>
</html>