<!DOCTYPE html>
<html>
<head>
	 <meta charset="utf-8">
	<title>汇市头条</title>
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
  
  
   <div id="drag" style="position:absolute;right:260px;top:720px;width:80px;height:80px;padding:20px;border-radius:30px;background:url(/resource/static/front/images/kefu.png) no-repeat center;z-index:10000">
       <a href="/helpcenter.html#helpcenter1" id="question" style="width:40px;height:40px;display:block;position:relative;left:0px;top:0px;">
         
       </a>
   </div>
  <script type="text/javascript">
    
    // 客服小智

   $("#drag").mouseover(function(){
         $(this).css("background","url(/resource/static/front/images/kefu1.png) center center no-repeat");

      }).mouseout(function(){
    
          $(this).css("background","url(/resource/static/front/images/kefu.png) center center no-repeat");

      })
      function drag(){
         var obj=$("#drag");
         obj.bind('mousedown',start);

         function start(e){
          var e=e || window.event;
          mouseOffsetX=e.pageX-obj.offset().left;
          mouseOffsetY=e.pageY-obj.offset().top;
          $(document).bind({
            'mousemove':move,
            'mouseup':stop
          });
          return false;
         }

         function move(e){
    
          var e= e || window.event;
          var mouseX=e.pageX;          
          var mouseY=e.pageY;
          var moveX=mouseX-mouseOffsetX;
          var moveY=mouseY-mouseOffsetY;
           var pageWidth=document.documentElement.clientWidth; //页面最大宽度
           var pageHeight=document.body.clientHeight;//页面最大高度
           var objWidth=obj[0].offsetWidth;    //浮层最大宽度
           var objHeight=obj[0].offsetHeight;   //浮层最大高度
           var maxX=pageWidth - objWidth;       
           var maxY=pageHeight - objHeight;
           var mX=Math.min(maxX,Math.max(0,moveX));
           var mY=Math.min(maxY,Math.max(0,moveY));
          obj.css({
             "left":moveX=mX,
             "top":moveY=mY
          });
          return false;
         }

         function stop(e){
           $(document).unbind({
             'mousemove':move,
             'mouseup':stop
           });
         }
      }
      drag()
  </script>
  <div class="new_content">
  	<div class="headline_display">
  	  <div class="headline_display_center">
  		<p>JPMogan</p>
  		<p>MARKET HEADLINES</p>
  		<p>汇市<span style="color:#fcb600">头条</span></p>
  	  </div>
  	</div>
  	<div class="headline_text">
  	  <div class="headline_text_top">
  	  	<p><i style="display:inline-block;width:50px;border-bottom:1px solid #b09373;position:relative;top:-5px;left:-30px"></i><b style="position:relative;top:-3px;left:-20px;display:inline-block;width:6px;height:6px;border-radius:3px;background-color:#bfbfbf"></b>
  	  		<span>汇市头条</span>
  	  		<b style="position:relative;top:-3px;left:20px;display:inline-block;width:6px;height:6px;border-radius:3px;background-color:#bfbfbf"></b><i style="position:relative;top:-5px;left:30px;display:inline-block;width:50px;border-bottom:1px solid #b09373"></i>
  	  	</p>
  	  	<p style="color:#444;font-size:28px;font-weight:bold">MARKET HEADLINES</p>
  	  </div>
      <i></i>
  	</div>  
    <div class="announcement_main">
      <div class="announcement_main_top">
        <input type="radio" name="headline" id="headline1" checked>   
        <label for="headline1">每日汇评</label>
        <div class="announcement_main_bot">


           <div class="latest">

          <?php foreach ($wdata as $key=>$val):?>
          <div class="latest_news" onclick="window.open('/xq.html/<?php echo $val['aID'];?>')">
             <div class="latest_news_img a<?php echo $key+1;?>" >
               <p style="font-size:18px;font-weight:bold;">每日汇评</p>
               <p style="font-size:10px;">DAILY REMITTANCE</p>
             </div>
             <div class="latest_news_content">
               <div class="title">
                 <?php echo $val['aTitle'];?>
               </div>
               <div class="content">
                  
                 <?php echo $val['aDescription'];?>
               </div>
               <div class="time">
                 <?php echo $val['aAddtime'];?>
               </div>
             </div>
           </div>
        <?php endforeach;?>
    
         </div>

        <div class="former">
           <ul id="w136">
            
           </ul>
         </div>
         <div class="oldernewer"> 
            <div class="wp-pagenavi"  id="wp136"> 
              
            </div> 
           </div>
        </div>
      </div>
      <div class="headline_main_top" style="background:url(./images/headline02.jpg) center center no-repeat;background-size:cover">
        <input type="radio" name="headline" id="headline2">   
        <label for="headline2">财经日历</label>
        <div class="headline_main_bot" style="width:80%;min-height:800px;padding-top:80px;">  
            <iframe id="economic-calendar" src="https://sslecal2.forexprostools.com/?ecoDayFontColor=%23c5c5c5&amp;ecoDayBackground=%23ffffff&amp;innerBorderColor=%23edeaea&amp;borderColor=%23edeaea&amp;columns=exc_flags,exc_currency,exc_importance,exc_actual,exc_forecast,exc_previous&amp;category=_employment,_economicActivity,_inflation,_credit,_centralBanks,_confidenceIndex,_balance,_Bonds&amp;importance=1,2,3&amp;features=datepicker,timezone,timeselector,filters&amp;countries=29,25,54,145,34,163,32,70,6,27,37,122,15,113,107,55,24,121,59,89,72,71,22,17,51,39,93,106,14,48,33,23,10,35,92,57,94,97,68,96,103,111,42,109,188,7,105,172,21,43,20,60,87,44,193,125,45,53,38,170,100,56,80,52,36,90,112,110,11,26,162,9,12,46,85,41,202,63,123,61,143,4,5,138,178,84,75&amp;calType=week&amp;timeZone=28&amp;lang=6" width="100%" frameborder="0" allowtransparency="true" marginwidth="0" marginheight="0" style="width:40%;display: block;height:600px;
               box-shadow:4px 6px 0px 52px #666;border-radius:5px;float:left;margin-left:10%">
            </iframe> 
            <div class="headline_main_bot_text">
              <h1>财经日历</h1>
              <h2>本周重要财经数据和事件</h2>
              <p>IMPORTANT FINANCIAL DATA AND EVENTS THIS WEEK</p>
            </div>
        </div>
      </div>
    </div>    
  </div>
   <?php
Widget::load('front',array('view'=>'footer'));
?>
<!-- footer end --> 
<!--   <script type="text/javascript" src="/resource/static/front/js/footer.js"></script> -->
</body>
</html>

<script type="text/javascript">

function loadrs(page,cid,page_size){

var ldata = '';
  var url = '<?=site_url('front/index/announcement_data')?>';
    var data = {};
        data['page']= page;
        data['cid']= cid;
        data['page_size']= page_size;
  $.post(url,data,function(data){
      if(cid == 136){
        $("#wp136").html('<span class="pages">'+data.pagenum+'</span>'+data.page);
        $("#w136").html('');
        $(data.wdata).each(function(index,val){
          $("#w136").append('<li><a href="/xq.html/'+val.aID+'">'+val.aTitle+'</a><span class="time">'+val.aAddtime+'</span></li>');
                       
        });
      }
  },'json')
  .error(function(){ 
    console.log('cuowu');
  });
return ldata;
}

function load136(page){
  loadrs(page,136,10);
}
$(document).ready(function() {
    load136(0);
    
});
</script>