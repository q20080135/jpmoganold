<!DOCTYPE html>
<html>
<head>
	 <meta charset="utf-8">
	<title>活动预告</title>
	<link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/new_css.css" />
	<link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/new_style.css" />
	<link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/new_home.css" /> 
	<link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/colorbox.css" /> 
	<link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/reset.css" /> 
	<link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/lww.css" />
  <link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/mediaelementplayer.min.css" />
</head>
<body>
<?php
Widget::load('front',array('view'=>'header'));
?>
  <script type="text/javascript" src="/resource/static/front/js/jquery-1.8.3.min.js"></script>
  <script type="text/javascript" src="/resource/static/front/js/new_myscript.js"></script>
  <script type="text/javascript" src="/resource/static/front/js/myscript.js"></script>
  <script type="text/javascript" src="/resource/static/front/js/mediaelement-and-player.min.js"></script>  
  <div class="new_content">
  	<div class="activity_display">
  	  <div class="activity_display_center">
  		<p>JPMogan</p>
  		<p>活动<span style="color:#fbb600">预告</span></p>
  		<p>UPCOMING EVENTS</p>
  	  </div>
  	</div>
  	<div class="activity_text">
  	  <div class="activity_text_top">
  	  	<p><i style="display:inline-block;width:50px;border-bottom:1px solid #b09373;position:relative;top:-5px;left:-30px"></i><b style="position:relative;top:-3px;left:-20px;display:inline-block;width:6px;height:6px;border-radius:3px;background-color:#bfbfbf"></b>
  	  		<span>活动预告</span>
  	  		<b style="position:relative;top:-3px;left:20px;display:inline-block;width:6px;height:6px;border-radius:3px;background-color:#bfbfbf"></b><i style="position:relative;top:-5px;left:30px;display:inline-block;width:50px;border-bottom:1px solid #b09373"></i>
  	  	</p>
  	  	<p style="color:#444;font-size:28px;font-weight:bold">UPCOMING EVENTS</p>
  	  </div>
      <i></i>      
  	</div>
    <div class="activity_content">    
      <div class="page_accordion_content_wrapper add_padding_left"> 

        <?php foreach ($wdata as $key=>$val):?>
          <div class="page_accordion_content"> 
          <div class="page_accordion_content_title">
          <?php echo $val['aTitle'];?> 
          <i></i>
          </div> 
          <div class="page_accordion_content_text" style="display: none;"> 
              <?php echo $val['aContent'];?> 
          </div> 
          </div> 
        <?php endforeach;?>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    $(".page_accordion_content_title").click(function(){
    if(!$(this).hasClass("selected"))
    {
      $(this).addClass("selected"); 
      $(this).parent().find(".page_accordion_content_text").slideDown(500);
    }
    else
    { 
      $(this).removeClass("selected");
      $(this).parent().find(".page_accordion_content_text").slideUp(500);   
    }
    return false;
    }); 
  
    // $(".page_accordion_content_title").eq(0).trigger("click");
  </script>
  <!--footer start--> 
<?php
Widget::load('front',array('view'=>'footer'));
?>
<!-- footer end --> 
<!--   <script type="text/javascript" src="/resource/static/front/js/footer.js"></script> -->
</body>
</html>