<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no,minimum-scale=1.0,maximum-scale=1.0" />
<meta http-equiv="Cache-Control" content="no-cache"/> 
  <title>资料下载</title>
  <link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/new_css.css" />
  <link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/new_style.css" />
  <link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/new_home.css" /> 
  <link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/colorbox.css" /> 
  <link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/reset.css" /> 
  <link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/lww.css" />
  <link rel="stylesheet" type="text/css" href="/resource/static/front/css/app.css">  
</head>
<body>
   <?php
Widget::load('front',array('view'=>'header'));
?>
  <script type="text/javascript" src="/resource/static/front/js/jquery-1.8.3.min.js"></script>
  <script type="text/javascript" src="/resource/static/front/js/new_myscript.js"></script>
  <script type="text/javascript" src="/resource/static/front/js/jquery.colorbox.js"></script> 
  <script type="text/javascript" src="/resource/static/front/js/myscript.js"></script> 
  <script type="text/javascript" src="/resource/static/front/js/app.js"></script> 
  <script type="text/javascript">
    
    // 客服Service

    $("#drag").mouseover(function(){
         $(this).children("#question").stop().slideDown("fast");

      }).mouseout(function(){
    
          $(this).children("#question").stop().slideUp("fast");

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
    <div class="datadownload_display">
      <div class="datadownload_display_center">
      <p>JPMogan</p>
      <p>DATA DOWNLOAD</p>
      <p>资料<span style="color:#fcb600">下载</span></p>
      </div>
    </div>
    <div class="datadownload_text">
      <div class="datadownload_text_top">
        <p><i style="display:inline-block;width:50px;border-bottom:1px solid #b09373;position:relative;top:-5px;left:-30px"></i><b style="position:relative;top:-3px;left:-20px;display:inline-block;width:6px;height:6px;border-radius:3px;background-color:#bfbfbf"></b>
          <span>资料下载</span>
          <b style="position:relative;top:-3px;left:20px;display:inline-block;width:6px;height:6px;border-radius:3px;background-color:#bfbfbf"></b><i style="position:relative;top:-5px;left:30px;display:inline-block;width:50px;border-bottom:1px solid #b09373"></i>
        </p>
        <p style="color:#444;font-size:28px;font-weight:bold">DATA DOWNLOAD</p>
      </div>
      <i></i>
      <p style="text-align:center;color:#747474;font-size:16px;">用户可在该页面下载JPMogan各款平台的使用指南，以便更好的掌握JPMogan平台的诸多使用功能。<br>请根据您的交易需求，点击以下按钮，选择您需要的平台指南:</p>
    </div>  
    <div class="datadownload_main">
      <div class="datadownload_main_top">
        <input type="radio" name="datadownload" id="datadownload1" checked>   
        <label for="datadownload1">宣传资料下载</label>
        <div class="datadownload_title">
          宣传资料下载
        </div>
        <div class="datadownload_main_bot">
            <dl> 
             <dd> 
              <span>JPMogan宣传介绍页</span>  
              <a href="/resource/static/front/file/jieshao.rar" download="" target="_blank" class="a1">点击下载</a> 
              <embed src="/resource/static/front/file/jieshao.rar" type="application/pdf" width="100%" height="100%">
             </dd> 
        
             <dd> 
              <span>JPMogan宣传册PDF版</span>  
              <a href="/resource/static/front/file/xczl.pdf" download="" target="_blank" class="a1">点击下载</a> 
              <a href="/resource/static/front/file/xczl.pdf" target="_blank" class="a2">在线预览</a>
              <embed src="/resource/static/front/file/xczl.pdf" type="application/pdf" width="100%" height="100%">
             </dd> 
       
             <dd> 
              <span>JPMogan宣传册（打印版）</span>  
              <a href="/resource/static/front/file/xczldy.zip" download="" target="_blank" class="a1">点击下载</a> 
              <embed src="/resource/static/front/file/xczldy.zip" type="application/pdf" width="100%" height="100%">
             </dd> 
            </dl>


            <!-- 移动端web -->
           
            <div class="data_content"> 
              <div class="data_content_title">
               JPMogan宣传介绍页2pages
               <i></i>
              </div> 
              <div class="data_content_text" style="overflow: hidden;"> 
               <div class="default_template"> 
                  <a href="/resource/static/front/file/jieshao.rar" download="" target="_blank" class="a1">点击下载</a>
                  <embed src="/resource/static/front/file/jieshao.rar" type="application/pdf" width="100%" height="100%">
                <div class="clear"></div> 
               </div> 
              </div> 
            </div>

            <div class="data_content"> 
              <div class="data_content_title">
               JPMogan宣传册PDF版
               <i></i>
              </div> 
              <div class="data_content_text" style="overflow: hidden;"> 
               <div class="default_template"> 
                  <a href="/resource/static/front/file/xczl.pdf" download="" target="_blank" class="a1">点击下载</a>
                  <a href="/resource/static/front/file/xczl.pdf" target="_blank" class="a2">在线预览</a>
                  <embed src="/resource/static/front/file/xczl.pdf" type="application/pdf" width="100%" height="100%">
                <div class="clear"></div> 
               </div> 
              </div> 
            </div>
            <div class="data_content"> 
              <div class="data_content_title">
               JPMogan宣传册（打印版）
               <i></i>
              </div> 
              <div class="data_content_text" style="overflow: hidden;"> 
               <div class="default_template"> 
                  <a href="/resource/static/front/file/xczldy.zip" download="" target="_blank" class="a1">点击下载</a>
                  <embed src="/resource/static/front/file/xczldy.zip" type="application/pdf" width="100%" height="100%">
                <div class="clear"></div> 
               </div> 
              </div> 
            </div>
        </div>
      </div>
      <div class="datadownload_main_top" >
        <input type="radio" name="datadownload" id="datadownload2">   
        <label for="datadownload2">使用指南下载</label>
        <div class="datadownload_title">
          指南使用下载
        </div>
        <div class="datadownload_main_bot">  
          <dl> 
            

            <dd> 
              <span>JPMogan入金必备浏览器IE10</span> 
              <a href="/resource/static/front/file/IE10.exe" download="" target="_blank" class="a1">点击下载</a> 
             </dd> 
             <dd> 
              <span>JPMogan合作伙伴流程</span> 
              <a href="/resource/static/front/file/cqs1.pdf" download="" target="_blank" class="a1">PDF下载</a> 
              <a href="/resource/static/front/file/cqs1.pdf" target="_blank" class="a2">在线预览</a>
              <embed src="/resource/static/front/file/cqs1.pdf" type="application/pdf" width="100%" height="100%">
             </dd> 
              <dd> 
              <span>JPMogan客户开户流程</span> 
              <a href="/resource/static/front/file/cqs2.pdf" download="" target="_blank" class="a1">PDF下载</a> 
              <a href="/resource/static/front/file/cqs2.pdf" target="_blank" class="a2">在线预览</a>
              <embed src="/resource/static/front/file/cqs2.pdf" type="application/pdf" width="100%" height="100%">
            </dd> 
             <dd> 
              <span>MT4PC操作指南</span> 
              <a href="/resource/static/front/file/mt4pc.pdf" download="" target="_blank" class="a1">PDF下载</a> 
              <a href="/resource/static/front/file/mt4pc.pdf" target="_blank" class="a2">在线预览</a>
              <embed src="/resource/static/front/file/mt4pc.pdf" type="application/pdf" width="100%" height="100%">
             </dd> 

             <dd> 
              <span>MT4手机操作指南</span> 
              <a href="/resource/static/front/file/mt4mobile.pdf" download="" target="_blank" class="a1">PDF下载</a> 
              <a href="/resource/static/front/file/mt4mobile.pdf" target="_blank" class="a2">在线预览</a>
              <embed src="/resource/static/front/file/mt4mobile.pdf" type="application/pdf" width="100%" height="100%">
             </dd> 

            

            <dd> 
              <span>JPMogan出金指南</span> 
              <a href="/resource/static/front/file/cj.pdf" download="" target="_blank" class="a1">PDF下载</a> 
              <a href="/resource/static/front/file/cj.pdf" target="_blank" class="a2">在线预览</a>
              <embed src="/resource/static/front/file/cj.pdf" type="application/pdf" width="100%" height="100%">
             </dd> 

             <dd> 
              <span>JPMogan入金指南</span> 
              <a href="/resource/static/front/file/rj.pdf" download="" target="_blank" class="a1">PDF下载</a> 
              <a href="/resource/static/front/file/rj.pdf" target="_blank" class="a2">在线预览</a>
              <embed src="/resource/static/front/file/rj.pdf" type="application/pdf" width="100%" height="100%">
             </dd> 



          </dl>
          <!-- 移动端web -->
          <div class="data_content"> 
              <div class="data_content_title">
               JPMogan入金必备浏览器IE10
               <i></i>
              </div> 
              <div class="data_content_text" style="overflow: hidden;"> 
               <div class="default_template"> 
                  <a href="/resource/static/front/file/IE10.exe" target="_blank" class="a2">在线预览</a> 
                <div class="clear"></div> 
               </div> 
              </div> 
          </div>

           <div class="data_content"> 
              <div class="data_content_title">
               JPMogan合作伙伴流程
               <i></i>
              </div> 
              <div class="data_content_text" style="overflow: hidden;"> 
               <div class="default_template"> 
                  <a href="/resource/static/front/file/JPMogan1.pdf" download="" target="_blank" class="a1">点击下载</a>
                  <a href="/resource/static/front/file/JPMogan1.pdf" target="_blank" class="a2">在线预览</a> 
                  <embed src="/resource/static/front/file/JPMogan1.pdf" type="application/pdf" width="100%" height="100%">
                <div class="clear"></div> 
               </div> 
              </div> 
          </div>

           <div class="data_content"> 
              <div class="data_content_title">
               JPMogan客户开户流程
               <i></i>
              </div> 
              <div class="data_content_text" style="overflow: hidden;"> 
               <div class="default_template"> 
                  <a href="/resource/static/front/file/JPMogan2.pdf" download="" target="_blank" class="a1">点击下载</a>
                  <a href="/resource/static/front/file/JPMogan2.pdf" target="_blank" class="a2">在线预览</a> 
                  <embed src="/resource/static/front/file/JPMogan2.pdf" type="application/pdf" width="100%" height="100%">
                <div class="clear"></div> 
               </div> 
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
      <img src="/resource/static/front/images/new_logo.png">
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
</body>
<script type="text/javascript">

  $(".data_content_title").click(function(){
    if(!$(this).hasClass("selected"))
    {
      $(this).addClass("selected"); 
      $(this).parent().find(".data_content_text").slideDown(500);
    }
    else
    { 
      $(this).removeClass("selected");
      $(this).parent().find(".data_content_text").slideUp(500);   
    }
    return false;
    }); 

  param=window.location.hash.substr(1);
    str="#"+param;
    $(str).attr("checked",true);
</script>
</html>