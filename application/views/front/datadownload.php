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
    
    // 客服小智

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
              <span>JPMogan品牌介绍</span>  
              <a href="/resource/static/front/file/ppjs.pdf" download="" target="_blank" class="a1">PDF下载</a> 
              <a href="/resource/static/front/file/ppjs.pdf" target="_blank" class="a2">在线预览</a>
              <embed src="/resource/static/front/file/ppjs.pdf" type="application/pdf" width="100%" height="100%">
             </dd> 
            </dl>
            <!-- 移动端web -->
           
            <div class="data_content"> 
              <div class="data_content_title">
               JPMogan品牌介绍
               <i></i>
              </div> 
              <div class="data_content_text" style="overflow: hidden;"> 
               <div class="default_template"> 
                  <a href="/resource/static/front/file/ppjs.pdf" download="" target="_blank" class="a1">点击下载</a>
                  <a href="/resource/static/front/file/ppjs.pdf" target="_blank" class="a2">在线预览</a> 
                  <embed src="/resource/static/front/file/ppjs.pdf" type="application/pdf" width="100%" height="100%">
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
              <a href="/resource/static/front/file/JPMogan1.pdf" download="" target="_blank" class="a1">PDF下载</a> 
              <a href="/resource/static/front/file/JPMogan1.pdf" target="_blank" class="a2">在线预览</a>
              <embed src="/resource/static/front/file/JPMogan1.pdf" type="application/pdf" width="100%" height="100%">
             </dd> 
             <dd> 
              <span>JPMogan客户开户流程</span> 
              <a href="/resource/static/front/file/JPMogan2.pdf" download="" target="_blank" class="a1">PDF下载</a> 
              <a href="/resource/static/front/file/JPMogan2.pdf" target="_blank" class="a2">在线预览</a>
              <embed src="/resource/static/front/file/JPMogan2.pdf" type="application/pdf" width="100%" height="100%">
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
      风险声明:外汇差价合约交易属杠杆交易，具有高风险，并不一定适合所有投资者。高杠杆率意味着高收益与高风险并存，所以在决定进行外汇差价合约交易或其他形式金融投资前，投资者请务必慎重考虑自身投资目标、交易经验、经济承受范围。杠杆交易存在令您损失部分或全部初始入金的可能性，因此，切忌投入无法承受损失的资金数额。客户应对上述外汇交易所存风险清楚了解，若有疑问应向个人金融理财顾问寻求专业的意见。交易前，请仔细阅读我们完整的风险披露、隐私政策、法律文件。
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