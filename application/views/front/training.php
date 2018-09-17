<!DOCTYPE html>
<html>
<head>
	 <meta charset="utf-8">
   <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no,minimum-scale=1.0,maximum-scale=1.0" />
<meta http-equiv="Cache-Control" content="no-cache"/>
	<title>培训课堂</title>
	<link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/new_css.css" />
	<link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/new_style.css" />
	<link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/new_home.css" /> 
	<link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/colorbox.css" /> 
	<link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/reset.css" /> 
	<link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/lww.css" />	
<link rel="stylesheet" type="text/css" href="/resource/static/front/css/app.css">	</head>
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
  	<div class="training_display">
  	  <div class="training_display_center">
  		<p>JPMogan</p>
  		<p>THE TRAINING CLASS</p>
  		<p><span style="color:#fcb600">培训</span>课堂</p>
  	  </div>
  	</div>
  	<div class="training_text">
  	  <div class="training_text_top">
  	  	<p><i style="display:inline-block;width:50px;border-bottom:1px solid #b09373;position:relative;top:-5px;left:-30px"></i><b style="position:relative;top:-3px;left:-20px;display:inline-block;width:6px;height:6px;border-radius:3px;background-color:#bfbfbf"></b>
  	  		<span>培训课堂</span>
  	  		<b style="position:relative;top:-3px;left:20px;display:inline-block;width:6px;height:6px;border-radius:3px;background-color:#bfbfbf"></b><i style="position:relative;top:-5px;left:30px;display:inline-block;width:50px;border-bottom:1px solid #b09373"></i>
  	  	</p>
  	  	<p style="color:#444;font-size:28px;font-weight:bold">THE TRAINING CLASS</p>
  	  </div>
      <i></i>
  	</div>  
    <div class="training_main">
      <div class="training_main_top">
        <input type="radio" name="training" id="training1" checked>   
        <label for="training1">小白上路</label>
        <div class="training_main_bot">
          <div class="training_main_top_title">
           小白上路
          </div>
          <div class="noob_trading"> 
           <ul> 
            
            <?php foreach ($wdata as $key=>$val):?>
              <li class="post_tit">
                <img src="/resource/static/front/images/cfd_content_2.png" alt="" /> 
                <span><?php echo $key+1;?></span>、
                <a title="<?php echo $val['aTitle'];?>" href="/xq.html/<?php echo $val['aID'];?>"> <?php 
                 if(mb_strlen($val['aTitle'],'UTF-8')> 22){
                    echo mb_substr($val['aTitle'],0,22,"utf-8").'...';
                 }else{
                    echo $val['aTitle'];
                 };?></a>
              </li> 
            <?php endforeach;?>
            <div class="clear"></div> 
           </ul> 
           <div class="oldernewer"> 
            <div class="wp-pagenavi">
              <span class="pages"><?php echo $con!=0?'页 1 of '.ceil($con/20):'';?></span>
              <?php echo $page;?>
            </div>
           </div> 
           



          </div>
        </div>
      </div>
      <div class="training_main_top">
        <input type="radio" name="training" id="training2">   
        <label for="training2">高手加速</label>
        <div class="training_main_bot">  
             <div class="training_main_top_title">
                高手加速
             </div>
             <div class="page_content"> 
              <div class="page_content_title" style="margin-top:50px;">
               <em class="e1"></em>
               交易心理
               <i></i>
              </div> 
              <div class="page_content_text" style="display: none;background-color: #f6f6f6"> 
               <div class="default_template"> 
                <p>1、 <a href="javascript:void();">技术指标不可怕，心理偏向定方向</a><br /> 2、 <a href="javascript:void();">如何以正确的姿势认识运气和赌博？</a><br /> 3、<a href="javascript:void();">原来这才是交易成功的门槛！</a></p> 
                <div class="clear"></div> 
               </div> 
              </div> 
             </div> 
             <div class="page_content"> 
              <div class="page_content_title" style="margin-top:20px;">
                <em class="e2"></em>
               交易系统
               <i></i>
              </div> 
              <div class="page_content_text" style="display: none;background-color: #f6f6f6"> 
               <div class="default_template"> 
                <p>1、 <a href="javascript:void();">不忘初心，始终明记自身的交易目标</a><br /> 2、 <a href="javascript:void();">期望收益不正 何谈长期赢利？</a><br /> 3、 <a href="javascript:void();">一文告诉你交易的机会成本有多重要</a><br /> 4、 <a href="javascript:void();">长期交易盈利虽困难重重，但依然存在途径</a><br /> 5、 <a href="javascript:void();">这几种交易理念，总有一款适合你！</a></p> 
                <div class="clear"></div> 
               </div> 
              </div> 
             </div> 
             <div class="page_content"> 
              <div class="page_content_title" style="margin-top:20px;">
               <em class="e3"></em>
               交易方法
               <i></i>
              </div> 
              <div class="page_content_text" style="display: none;background-color: #f6f6f6"> 
               <div class="default_template"> 
                <p>1、 <a href="javascript:void();">交易路上不翻车，老司机带你识别可靠的入场信号灯</a><br /> 2、 <a href="javascript:void();">交易入场前的必备条件，一样都不能少！</a><br /> 3、 <a href="">入场先买票，这份入场技术攻略请收好！</a><br /> 4、 <a href="javascript:void();">五大安全通道，让你离场不慌张！</a><br /> 5、 <a href="javascript:void();">要想成功交易，先掌握这六大法宝！</a></p> 
                <div class="clear"></div> 
               </div> 
              </div> 
             </div> 
             <div class="page_content"> 
              <div class="page_content_title" style="margin-top:20px;">
                <em class="e4"></em>
               风险管理
               <i></i>
              </div> 
              <div class="page_content_text" style="display: none;background-color: #f6f6f6"> 
               <div class="default_template"> 
                <p>1、 <a href="javascript:void();">综述风险以及风险管理的含义</a></p> 
                <p>2、<a href="javascript:void();" target="_blank">个人如何进行外汇风险管理？你需要这些深入了解</a></p> 
                <p>3、<a href="javascript:void();" target="_blank">外汇风险管理之平衡设置风险盈亏比</a></p> 
                <div class="clear"></div> 
               </div> 
              </div> 
             </div> 
             <div class="page_content" style="margin-bottom:50px;"> 
              <div class="page_content_title" style="margin-top:20px;">
               <em class="e5"></em>
               资金管理
               <i></i>
              </div> 
              <div class="page_content_text" style="display: none;background-color: #f6f6f6"> 
               <div class="default_template"> 
                <p>1、 <a href="javascript:void();">通向目标有一点最关键，资金管理不可或缺！</a><br /> 2、 <a href="javascript:void();">资金管理如同投注，赢钱可多投，亏钱必少投</a></p> 
                <div class="clear"></div> 
               </div> 
              </div> 
             </div> 

        </div>
      </div>
      <div class="training_main_top">
        <input type="radio" name="training" id="training3">   
        <label for="training3">视频课堂</label>
        <div class="shipin_main_bot">
            <div class="training_main_top_title">
                视频课堂
            </div>
            <div class="shipin_box"> 




               <div class="shipin_item"> 
                <div class="video_box"> 
                 <video width="100%" height="100%" controls="controls"> 
                  <source src="/resource/static/front/video/001.mp4" type="video/mp4"></source> 
                 <!--  <source src="/video/Crude_oil_futures_640.mp4.ogv" type="video/ogg"></source> 
                  <source src="/video/Crude_oil_futures_640.mp4.webm" type="video/webm"></source> --> 
                 </video> 
                 <div class="video_back video_back0"></div> 
                </div> 
                <div class="text_box"> 
                 <div class="tit">
                  1.杠杆的真实意义
                 </div> 
                 <div class="txt">
                  交易知识科普
                 </div> 
                </div> 
               </div> 


               <div class="shipin_item"> 
                <div class="video_box"> 
                 <video width="100%" height="100%" controls="controls"> 
                  <source src="/resource/static/front/video/002.mp4" type="video/mp4"></source> 
                 <!--  <source src="/video/Crude_oil_futures_640.mp4.ogv" type="video/ogg"></source> 
                  <source src="/video/Crude_oil_futures_640.mp4.webm" type="video/webm"></source> --> 
                 </video> 
                 <div class="video_back video_back0"></div> 
                </div> 
                <div class="text_box"> 
                 <div class="tit">
                  2.什么是资金管理
                 </div> 
                 <div class="txt">
                  交易知识科普
                 </div> 
                </div> 
               </div> 



               <div class="shipin_item"> 
                <div class="video_box"> 
                 <video width="100%" height="100%" controls="controls"> 
                  <source src="/resource/static/front/video/003.mp4" type="video/mp4"></source> 
                 <!--  <source src="/video/Crude_oil_futures_640.mp4.ogv" type="video/ogg"></source> 
                  <source src="/video/Crude_oil_futures_640.mp4.webm" type="video/webm"></source> --> 
                 </video> 
                 <div class="video_back video_back0"></div> 
                </div> 
                <div class="text_box"> 
                 <div class="tit">
                  3.如何设置止损
                 </div> 
                 <div class="txt">
                  交易知识科普
                 </div> 
                </div> 
               </div> 



               <div class="shipin_item"> 
                <div class="video_box"> 
                 <video width="100%" height="100%" controls="controls"> 
                  <source src="/resource/static/front/video/004.mp4" type="video/mp4"></source> 
                 <!--  <source src="/video/Crude_oil_futures_640.mp4.ogv" type="video/ogg"></source> 
                  <source src="/video/Crude_oil_futures_640.mp4.webm" type="video/webm"></source> --> 
                 </video> 
                 <div class="video_back video_back0"></div> 
                </div> 
                <div class="text_box"> 
                 <div class="tit">
                  4.为什么期货展期后会导致账户金额改变
                 </div> 
                 <div class="txt">
                  交易知识科普
                 </div> 
                </div> 
               </div> 





            </div>

        </div>
      </div>
    </div>    
  </div>
   <script type="text/javascript">
    $(".page_content_title").click(function(){
    if(!$(this).hasClass("selected"))
    {
      $(this).addClass("selected"); 
      $(this).parent().find(".page_content_text").slideDown(500);
    }
    else
    { 
      $(this).removeClass("selected");
      $(this).parent().find(".page_content_text").slideUp(500);   
    }
    return false;
    }); 

    
    param=window.location.hash.substr(1);
    str="#"+param;
    $(str).attr("checked",true);
    offset=$(str).next().next().offset().top-400;
    $("html,body").animate({ scrollTop: offset}, 500);


  </script>
  <?php
Widget::load('front',array('view'=>'footer'));
?>
<!-- footer end --> 
<!--   <script type="text/javascript" src="/resource/static/front/js/footer.js"></script> -->
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
      风险声明:外汇差价合约交易属杠杆交易，具有高风险，并不一定适合所有投资者。高杠杆率意味着高收益与高风险并存，所以在决定进行外汇差价合约交易或其他形式金融投资前，投资者请务必慎重考虑自身投资目标、交易经验、经济承受范围。杠杆交易存在令您损失部分或全部初始入金的可能性，因此，切忌投入无法承受损失的资金数额。客户应对上述外汇交易所存风险清楚了解，若有疑问应向个人金融理财顾问寻求专业的意见。交易前，请仔细阅读我们完整的风险披露、隐私政策、法律文件。
    </div>
  </div>
   <script type="text/javascript"> 
    param=window.location.hash.substr(1);
    str="#"+param;
    $(str).attr("checked",true);   
  </script>
</body>
</html>