<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no,minimum-scale=1.0,maximum-scale=1.0" />
<meta http-equiv="Cache-Control" content="no-cache"/>
  <title>资金管理人</title>
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
    <div class="manager_display">
      <div class="manager_display_center">
      <p>JPMogan</p>
      <p>BUSINESS COOPERATION</p>
      <p>资金<span style="color:#fcb600">管理人</span></p>
      </div>
    </div>
    <!-- 移动web -->
    <div class="cooperation_display">
      <div class="cooperation_display_center">
        <p>MODE OF COOPERATION</p>
        <p>合作<span style="color:#fcb600">方式</span></p>
      </div>
    </div>
    <div class="manager_text">
      <div class="manager_text_top">
        <p><i style="display:inline-block;width:50px;border-bottom:1px solid #b09373;position:relative;top:-5px;left:-30px"></i><b style="position:relative;top:-3px;left:-20px;display:inline-block;width:6px;height:6px;border-radius:3px;background-color:#bfbfbf"></b>
          <span>资金管理人</span>
          <b style="position:relative;top:-3px;left:20px;display:inline-block;width:6px;height:6px;border-radius:3px;background-color:#bfbfbf"></b><i style="position:relative;top:-5px;left:30px;display:inline-block;width:50px;border-bottom:1px solid #b09373"></i>
        </p>
        <p style="color:#444;font-size:28px;font-weight:bold">MONEY MANAGER</p>
      </div>
      <i></i>
      <div class="manager_text_bot">
        <p>JPMogan为专业而优秀的资金管理人提供最得心应手的事——交易，在成为JPMogan的合作伙伴后,<br>资金管理人将充分享受到JPMogan出众的交易优势。<br>我们将配合资金管理人的一切所需为其提供先进的对冲工具，同类中最优质的技术支持，<br>包括特别定制的CRM账户管理系统和利润分配系统等，<br>并以极具竞争力的价格和直通式处理方式使资金管理人在FX交易中始终处于先人一步的优势地位。</p>
      </div>  
    </div>
    <div class="manager_view">
      <div class="manager_view_top">
        <p><i style="display:inline-block;width:50px;border-bottom:1px solid #b09373;position:relative;top:-5px;left:-30px"></i><b style="position:relative;top:-3px;left:-20px;display:inline-block;width:6px;height:6px;border-radius:3px;background-color:#bfbfbf"></b>
          <span>定制版CRM账户管理系统</span>
          <b style="position:relative;top:-3px;left:20px;display:inline-block;width:6px;height:6px;border-radius:3px;background-color:#bfbfbf"></b><i style="position:relative;top:-5px;left:30px;display:inline-block;width:50px;border-bottom:1px solid #b09373"></i>
        </p>
        <p style="color:#444;font-size:28px;font-weight:bold">CRM ACCOUNT MANAGEMENT SYSTEM</p>
      </div>
      <i></i>
       <div class="manager_view_bot">
        <h1>CRM账户管理系统</h1>
        <p>JPMogan定制版CRM账户管理系统是专门为使用MT4平台的投资经理而设计的。<br>系统拓展了MT4交易平台的功能，投资经理能够在使用MT4界面的情况下有效管理账户。<br>JPMogan定制版CRM账户管理系统所有处理方式都是基于服务器集中处理，使其整合了速度与可靠性这两大优势。<br>JPMogan定制版CRM账户管理系统对所关联的订单或账户中的不一致情况保持警惕，<br>为每个 投资者或投资经理设置分配方案并且跟踪他们的盈亏。</p>
      </div>
    </div>
    <div class="manager_advantage">
      <div class="manager_advantage_top">
        <p>
          <i style="display:inline-block;width:80px;border-bottom:2px solid #898989;position:relative;top:-8px;left:-10px"></i>
          <span>JPMogan定制版CRM系统突出优点</span>
          <i style="position:relative;top:-8px;left:10px;display:inline-block;width:80px;border-bottom:2px solid #898989"></i>
        </p>
      </div>
       <div class="manager_advantage_bot">
         <div class="manager_advantage_bot1">
           <p>JPMogan定制版账户管理系统拥有在线视频和直播功能</p>
         </div>
         <div class="manager_advantage_bot2">
           <p style="color:#3d3d3d;font-weight:bold;font-size:14px;text-align:center">JPMogan定制版账户管理系统可实时监控管理账户的净值与盈亏，并可实时的操控所有管理账户的开仓数额，获取历史报告并计算佣金</p>
         </div>
         <div class="manager_advantage_bot3">
           <p style="color:#3d3d3d;font-weight:bold;font-size:14px;text-align:center">JPMogan定制版账户管理系统拥有绝无仅有的新科技：在线CRM 跟单功能。</p>
         </div>
       </div>
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
        机构客户能够直接对接到FX市场报价中，从而在各种流动性场所包括顶级银行、MTF和ECN交易模式的Currenex平台中获得预期报价。</p>
    </div>
    <div class="cooperation_text_image">
       <img src="/resource/static/front/images/cooperation2.png">
    </div>
    <div class="cooperation_text_title">
       资金管理人
    </div>
    <div class="cooperation_text_content"> 
       <p>JPMogan为专业而优秀的资金管理人提供最得心应手的事——交易，在成为JPMogan的合作伙伴后,<br>资金管理人将充分享受到JPMogan出众的交易优势。<br>我们将配合资金管理人的一切所需为其提供先进的对冲工具，同类中最优质的技术支持，<br>包括特别定制的CRM账户管理系统和利润分配系统等，<br>并以极具竞争力的价格和直通式处理方式使资金管理人在FX交易中始终处于先人一步的优势地位。</p>
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
      Risk Warning: Trading Derivatives carries a high level of risk to your capital and you should only trade with money you can afford to lose. Please ensure that you fully understand the risks involved, and seek independent advice if necessary. A Product Disclosure Statement (PDS) can be obtained  from our offices and should be considered before entering into a transaction with us. 
    </div>
  </div>
</body>
</html>