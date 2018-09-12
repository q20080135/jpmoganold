<!DOCTYPE html>
<html>
<head>
	 <meta charset="utf-8">
   <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no,minimum-scale=1.0,maximum-scale=1.0" />
<meta http-equiv="Cache-Control" content="no-cache"/>
	<title>机构交易者</title>
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
<div id="drag" style="position:absolute;right:260px;top:720px;width:80px;height:80px;padding:20px;border-radius:30px;background:url(/resource/static/front/images/kefu.png) no-repeat center;z-index:10000">
       <a href="/helpcenter.html#helpcenter1" id="question" style="width:40px;height:40px;display:block;position:relative;left:0px;top:0px;">
         
       </a>
   </div>
   <script type="text/javascript" src="/resource/static/front/js/jquery-1.8.3.min.js"></script>
  <script type="text/javascript" src="/resource/static/front/js/new_myscript.js"></script> 
  <script type="text/javascript" src="/resource/static/front/js/jquery.colorbox.js"></script> 
  <script type="text/javascript" src="/resource/static/front/js/myscript.js"></script> 
  <script type="text/javascript" src="/resource/static/front/js/app.js"></script> 
  <script src="/resource/static/front/js/gVerify.js"></script>
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
  	<div class="trader_display">
  	  <div class="trader_display_center">
  		<p>JPMogan</p>
  		<p>BUSINESS COOPERATION</p>
  		<p>机构<span style="color:#fcb600">交易者</span></p>
  	  </div>
  	</div>
    <!-- 移动web -->
    <div class="cooperation_display">
      <div class="cooperation_display_center">
        <p>MODE OF COOPERATION</p>
        <p>合作<span style="color:#fcb600">方式</span></p>
      </div>
    </div>
  	<div class="trader_text">
  	  <div class="trader_text_top">
  	  	<p><i style="display:inline-block;width:50px;border-bottom:1px solid #b09373;position:relative;top:-5px;left:-30px"></i><b style="position:relative;top:-3px;left:-20px;display:inline-block;width:6px;height:6px;border-radius:3px;background-color:#bfbfbf"></b>
  	  		<span>机构交易者</span>
  	  		<b style="position:relative;top:-3px;left:20px;display:inline-block;width:6px;height:6px;border-radius:3px;background-color:#bfbfbf"></b><i style="position:relative;top:-5px;left:30px;display:inline-block;width:50px;border-bottom:1px solid #b09373"></i>
  	  	</p>
  	  	<p style="color:#444;font-size:28px;font-weight:bold">INSTITUTIONAL TRADER</p>
  	  </div>
      <i></i>
      <div class="trader_text_bot">
        <p>JPMogan针对公司、企业类的机构交易者提供卓越的交易技术和自动化交易系统。<br>我们先进的交易工具可帮助客户采用最佳交易策略，透明的报价模式及合理的点差能够有效地为客户实现成本效益，<br>全面的报告服务让客户对账户活动了如指掌，精湛的风控管理令客户能够迅速地应对市场变化。<br>同时JPMogan还设有五大数据中心，能够最大限度地为客户带来低延迟的执行质量，以及平稳而顺畅的交易体验。<br>更多的是，凭借着JPMogan与全球顶级流动性提供商的关系，<br>
        机构客户能够直接对接到外汇市场报价中，从而在各种流动性场所包括顶级银行、MTF和ECN交易模式的Currenex平台中获得预期报价。</p>
      </div>  
  	</div>
    <div class="trader_view">
      <div class="trader_view_top">
        <p><i style="display:inline-block;width:50px;border-bottom:1px solid #b09373;position:relative;top:-5px;left:-30px"></i><b style="position:relative;top:-3px;left:-20px;display:inline-block;width:6px;height:6px;border-radius:3px;background-color:#bfbfbf"></b>
          <span>选择JPMogan的理由</span>
          <b style="position:relative;top:-3px;left:20px;display:inline-block;width:6px;height:6px;border-radius:3px;background-color:#bfbfbf"></b><i style="position:relative;top:-5px;left:30px;display:inline-block;width:50px;border-bottom:1px solid #b09373"></i>
        </p>
        <p style="color:#444;font-size:28px;font-weight:bold">REASONS FOR SELECTION</p>
      </div>
      <i></i>
      <br><br>     
    </div>
    <div class="trader_intro">
      <ul>
        <li>
          <i class="t1"></i>
          <p>先进的交易技术</p>
        </li>
        <li>
          <i class="t2"></i>
          <p>严密的风控管理系统</p>
        </li>
        <li>
          <i class="t3"></i>
          <p>全面的账户报告</p>
        </li>
        <li>
          <i class="t4"></i>
          <p>最佳执行速度</p>
        </li>
        <li>
          <i class="t5"></i>
          <p>低点差，低成本</p>
        </li>
        <li>
          <i class="t6"></i>
          <p>深度流动性带来的最优报价</p>
        </li>
      </ul>
    </div>
    <div class="broker_bottom">
      <div class="broker_bottom_text">
        <div class="broker_bottom_text_t">
          <i class="i1"></i>
          <h1>请成为我们合作伙伴</h1>
          <i class="i2"></i>
          <p>PLEASE BE OUR PARTNER</p>
        </div>
        <div class="broker_bottom_text_b">
          <a href="" class="a1" style="text-decoration:none;"><i class="b1"></i>点击登录</a>
          <a href="" class="a2" style="text-decoration:none;"><i class="b2"></i>点击注册</a>
        </div>
      </div>
    </div>
    <div class="cooperation_text_title">
       介绍经纪商
    </div>
    <div class="cooperation_text_content"> 
       <p>JPMogan为卓越的专业人士提供稳健共赢的介绍经纪商(IB)合作方案。<br>我们的IB计划以服务介绍经纪商发展为主要目的，通过前期培训、专业指导、市场推广、管理培训、<br>客服服务等方式不断提高IB的专业水平和市场拓展能力同时还结合其自身的业务需求和优势特性，<br>为其提供富有弹性的经营方案、产品组合、交易机制等。<br>在与JPMogan合作过程中，经纪商不仅能从其客户的交易行为中获取丰厚并持续的佣金，<br>还能在国际金融行业中扩大自己的品牌影响力。</p>
    </div>
    <div class="cooperation_text_image">
       <img src="/resource/static/front/images/cooperation1.png">
    </div>
    <div class="cooperation_text_title">
       机构交易者
    </div>
    <div class="cooperation_text_content"> 
       <p>JPMogan针对公司、企业类的机构交易者提供卓越的交易技术和自动化交易系统。<br>我们先进的交易工具可帮助客户采用最佳交易策略，透明的报价模式及合理的点差能够有效地为客户实现成本效益，<br>全面的报告服务让客户对账户活动了如指掌，精湛的风控管理令客户能够迅速地应对市场变化。<br>同时JPMogan还设有五大数据中心，能够最大限度地为客户带来低延迟的执行质量，以及平稳而顺畅的交易体验。<br>更多的是，凭借着JPMogan与全球顶级流动性提供商的关系，<br>
        机构客户能够直接对接到外汇市场报价中，从而在各种流动性场所包括顶级银行、MTF和ECN交易模式的Currenex平台中获得预期报价。</p>
    </div>
    <div class="cooperation_text_image">
       <img src="/resource/static/front/images/cooperation2.png">
    </div>
    <div class="cooperation_text_title">
       资金管理人
    </div>
    <div class="cooperation_text_content"> 
       <p>JPMogan为专业而优秀的资金管理人提供最得心应手的事——交易，在成为JPMogan的合作伙伴后,<br>资金管理人将充分享受到JPMogan出众的交易优势。<br>我们将配合资金管理人的一切所需为其提供先进的对冲工具，同类中最优质的技术支持，<br>包括特别定制的CRM账户管理系统和利润分配系统等，<br>并以极具竞争力的价格和直通式处理方式使资金管理人在外汇交易中始终处于先人一步的优势地位。</p>
    </div>
    <div class="cooperation_text_image">
       <img src="/resource/static/front/images/cooperation3.png">
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
 
<!-- footer end --> 
<!--   <script type="text/javascript" src="/resource/static/front/js/footer.js"></script> -->
</body>
</html>