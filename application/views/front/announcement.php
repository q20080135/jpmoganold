<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no,minimum-scale=1.0,maximum-scale=1.0" />
<meta http-equiv="Cache-Control" content="no-cache"/>
  <title>公告通知</title>
  <link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/new_css.css" />
  <link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/new_style.css" />
  <link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/new_home.css" /> 
  <link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/colorbox.css" /> 
  <link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/reset.css" /> 
  <link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/lww.css" />  
 <link rel="stylesheet" type="text/css" href="/resource/static/front/css/app.css">  </head>
<body>
  <?php
Widget::load('front',array('view'=>'header'));
?>
  <script type="text/javascript" src="/resource/static/front/js/jquery-1.8.3.min.js"></script>
  <script type="text/javascript" src="/resource/static/front/js/new_myscript.js"></script> 
    <script type="text/javascript" src="/resource/static/front/js/jquery.colorbox.js"></script> 
  <script type="text/javascript" src="/resource/static/front/js/myscript.js"></script>  
  <script type="text/javascript" src="/resource/static/front/js/app.js"></script>  
  
  <div id="drag" style="position:absolute;right:260px;top:720px;width:80px;height:80px;padding:20px;border-radius:30px;background:url(/resource/static/front/images/kefu.png) no-repeat center;z-index:10000">
       <a href="/helpcenter.html#helpcenter1" id="question" style="width:40px;height:40px;display:block;position:relative;left:0px;top:0px;">
         
       </a>
   </div>
  <script type="text/javascript">
    
    // 客服Service

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
    <div class="announcement_display">
      <div class="announcement_display_center">
      <p>JPMogan</p>
      <p>
        <?php if($cid==142){echo 'The announcement';}else if($cid==143){echo 'The News information';}else{echo 'The Daily information';}?>
        

      </p>
      <p><span style="color:#fcb600"><?php if($cid==142){echo '平台';}else if($cid==143){echo '新闻';}else{echo '每日';}?></span>
        <?php if($cid==142){echo '公告';}else if($cid==143){echo '动态';}else{echo '资讯';}?></p>
      </div>
    </div>
    <div class="announcement_text">
      <div class="announcement_text_top" >
        <p><i style="display:inline-block;width:50px;border-bottom:1px solid #b09373;position:relative;top:-5px;left:-30px"></i><b style="position:relative;top:-3px;left:-20px;display:inline-block;width:6px;height:6px;border-radius:3px;background-color:#bfbfbf"></b>
          <span>平台公告</span>
          <b style="position:relative;top:-3px;left:20px;display:inline-block;width:6px;height:6px;border-radius:3px;background-color:#bfbfbf"></b><i style="position:relative;top:-5px;left:30px;display:inline-block;width:50px;border-bottom:1px solid #b09373"></i>
        </p>
        <p style="color:#444;font-size:28px;font-weight:bold">THE ANNOUNCEMENT</p>
      </div>
      <i></i>
    </div>  
    <div class="announcement_main">
      <div class="announcement_main_top">
        <input type="radio" name="announcement" id="announcement1" <?php echo $cid==142?' checked':'';?>>   
        <label for="announcement1">平台公告</label>
        <div class="announcement_main_bot">        
         <div class="latest">

 <?php foreach ($wdata as $key=>$val):?>
          <div class="latest_news" onclick="window.open('/xq.html/<?php echo $val['aID'];?>')">
             <div class="latest_news_img a<?php echo $key+1;?>" >
               <p style="font-size:18px;font-weight:bold;">平台公告</p>
               <p style="font-size:10px;">PLATFORM ANNOUNCEMENT</p>
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
           <ul id="w142">
            
           </ul>
         </div>
         <div class="oldernewer"> 
            <div class="wp-pagenavi"  id="wp142"> 
              
            </div> 
           </div>
        </div>
      </div>
      <div class="announcement_main_top">
        <input type="radio" name="announcement" id="announcement2" <?php echo $cid==143?' checked':'';?>>   
        <label for="announcement2">新闻动态</label>
        <div class="announcement_main_bot">  
          <div id="w143">
         </div>
         <div class="oldernewer"> 
            <div class="wp-pagenavi" id="wp143"> 
            
            </div> 
         </div>           
       </div>
      </div>
      <div class="announcement_main_top">
        <input type="radio" name="announcement" id="announcement3" <?php echo $cid==144?' checked':'';?>>   
        <label for="announcement3">每日资讯</label>
        <div class="announcement_main_bot">
          <div class="latest">

        <?php foreach ($wdata2 as $key=>$val):?>
          <div class="latest_news" onclick="window.open('/xq.html/<?php echo $val['aID'];?>')">
             <div class="latest_news_img a<?php echo $key+1;?>" >
               <p style="font-size:18px;font-weight:bold;">每日资讯</p>
               <p style="font-size:10px;">DAILY INFORMATION</p>
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
          <ul id="w144">
           
          </ul>
        </div>
          <div class="oldernewer"> 
            <div class="wp-pagenavi" id="wp144"> 
             
            </div> 
         </div>
        </div>
      </div>
    </div>    
  </div>
    <?php
Widget::load('front',array('view'=>'footer'));
?>
  <div class="small_footer">
    <div class="small_footer_logo">
      <img src="./images/new_logo.png">
    </div>
    <div class="small_footer_title">
      <div class="small_footer_title_top">
        <a href="">关于JPMogan</a>
        <a href="">交易产品</a>
        <a href="">交易软件</a>
      </div> 
      <div class="small_footer_title_top">
        <a href="">每日一汇</a>
        <a href="">客户须知</a>
        <a href="">合作伙伴</a>
      </div>  
    </div>
    <div class="small_footer_mail">
      support@jpmorgen.com
    </div>
    <div class="small_footer_text">
      Risk Warning: Trading Derivatives carries a high level of risk to your capital and you should only trade with money you can afford to lose. Please ensure that you fully understand the risks involved, and seek independent advice if necessary. A Product Disclosure Statement (PDS) can be obtained  from our offices and should be considered before entering into a transaction with us. 
    </div>
  </div>
  <script type="text/javascript"> 
    param=window.location.hash.substr(1);
    str="#"+param;
    $(str).attr("checked",true);   
  </script></body>
</html>
<
<script type="text/javascript">

function loadrs(page,cid,page_size){

var ldata = '';
  var url = '<?=site_url('front/index/announcement_data')?>';
    var data = {};
        data['page']= page;
        data['cid']= cid;
        data['page_size']= page_size;
  $.post(url,data,function(data){
      if(cid == 142){
        $("#wp142").html('<span class="pages">'+data.pagenum+'</span>'+data.page);
        $("#w142").html('');
$(data.wdata).each(function(index,val){
  $("#w142").append('<li><a href="/xq.html/'+val.aID+'">'+val.aTitle+'</a><span class="time">'+val.aAddtime+'</span></li>');
               
});
   


      }else if(cid ==143){

$("#wp143").html('<span class="pages">'+data.pagenum+'</span>'+data.page);
$("#w143").html('');
        $(data.wdata).each(function(index,val){
  $("#w143").append('<dl>'+
              '<dt>'+
                  '<img src="/upload/'+val.aImg+'" alt="" class="tit_img">'+
              '</dt>'+
              '<dd>'+
                  '<a href="/xq.html/'+val.aID+'" class="newsLink">'+
                      '<h2 id="title">'+val.aTitle+'</h2>'+
                      '<p  class="abs">'+val.aDescription+'</p>'+
                      '<p class="time">'+val.aAddtime+'</p>'+
                  '</a>'+
              '</dd>'+
            '</dl>');
               
});

      }else if(cid ==144){
$("#wp144").html('<span class="pages">'+data.pagenum+'</span>'+data.page);
$("#w144").html('');
$(data.wdata).each(function(index,val){
  $("#w144").append('<li><a href="/xq.html/'+val.aID+'">'+val.aTitle+'</a><span class="time">'+val.aAddtime+'</span></li>');
  console.log(val.aID);
});


      }
  },'json')
  .error(function(){ 
    console.log('cuowu');
  });
return ldata;
}

function load142(page){
  loadrs(page,142,10);
}
function load143(page){
  loadrs(page,143,4);
}
function load144(page){
  loadrs(page,144,4);
}

$(document).ready(function() {
    load142(0);
    load143(0);
    load144(0);
});
</script>