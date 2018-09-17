<!DOCTYPE html>
<html>
<head>
	 <meta charset="utf-8">
   <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no,minimum-scale=1.0,maximum-scale=1.0" />
<meta http-equiv="Cache-Control" content="no-cache"/>
	<title>帮助中心</title>
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
  
  <!--  <div id="drag" style="position:absolute;right:260px;top:720px;width:80px;height:80px;padding:20px;border-radius:30px;background:url(/resource/static/front/images/kefu.png) no-repeat center;z-index:10000">
       <a href="/helpcenter.html#helpcenter1" id="question" style="width:40px;height:40px;display:block;position:relative;left:0px;top:0px;">
         
       </a>
   </div> -->
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
  	<div class="helpcenter_display">
  	  <div class="helpcenter_display_center">
  		<p>JPMogan</p>
  		<p>THE CUSTOMER REQUIREMENTS</p>
  		<p>帮助<span style="color:#fcb600">中心</span></p>
  	  </div>
  	</div>
  	<div class="helpcenter_text">
  	  <div class="helpcenter_text_top">
  	  	<p><i style="display:inline-block;width:50px;border-bottom:1px solid #b09373;position:relative;top:-5px;left:-30px"></i><b style="position:relative;top:-3px;left:-20px;display:inline-block;width:6px;height:6px;border-radius:3px;background-color:#bfbfbf"></b>
  	  		<span>帮助中心</span>
  	  		<b style="position:relative;top:-3px;left:20px;display:inline-block;width:6px;height:6px;border-radius:3px;background-color:#bfbfbf"></b><i style="position:relative;top:-5px;left:30px;display:inline-block;width:50px;border-bottom:1px solid #b09373"></i>
  	  	</p>
  	  	<p style="color:#444;font-size:28px;font-weight:bold">HELP CENTER</p>
  	  </div>
      <i></i>
  	</div>  
    <div class="helpcenter_main">
      <div class="helpcenter_main_top">
        <input type="radio" name="helpcenter" id="helpcenter1" checked >   
        <label for="helpcenter1" id="xiaozhi">客服Service</label>
        <div class="helpcenter_main_bot">
          <div class="helpcenter_main_bot_kefu">
            <h1>客服Service&nbsp;<i></i>&nbsp;业界最佳客服</h1>
            <p>INDUSTRY BEST CUSTOMER SERVICE</p>
            <div class="helpcenter_main_bot_kefu_bot">
              <span class="span1">
                <h1>客服</h1>
                <h1>SERVICE</h1>
              </span>
              <span class="span2">
                <h1>基本资料</h1>
                <div class="helpcenter_main_bot_title">
                  客服Service
                </div>
                <p>工单处理客服Service,号称"业界最佳客服"，客服Service常以快速、优质、效率的工作态度，深受众多用户喜爱</p>
                <h1>自我评价</h1>
                <p>我常常站在用户角度看待问题，第一时间处理问题，把用户放在首页位置，这是我的工作态度。</p>
                <p>欢迎提交工单给客服Service，我将竭诚为您服务</p>
              </span>
            </div>
          </div>
          <div class="helpcenter_main_content">
            <div class="helpcenter_main_content1 h1">
              <div class="text">
                账户和财务类
              </div>
            </div>
            <div class="helpcenter_main_content2">
              <ul class="u1">
                <li>  
                  <div class="helpcenter_main_content2_ul_t">
                    <i class="i4"></i>
                    <h3>出入金问题</h3>
                    <p>出金、入金、手续费、受理时间等问题</p>
                  </div>
                  <div class="helpcenter_main_content2_ul_b">
                    <a href="">提交问题</a>
                  </div>       
                </li>
                <li> 
                  <div class="helpcenter_main_content2_ul_t">
                    <i  class="i5"></i>
                    <h3>用户账号问题</h3>
                    <p>账户激活、换绑资料、找回密码等相关问题</p>
                  </div>
                  <div class="helpcenter_main_content2_ul_b">
                    <a href="">提交问题</a>
                  </div>      
                </li>
              </ul>       
            </div>
            <div class="triangle_border_right">        
            </div>
            <div class="helpcenter_main_content_change">
              <div class="helpcenter_main_content_change1 h1">
                <div class="text">
                  账户和财务类
                </div>
              </div>
              <div class="helpcenter_main_content_change2">
                <ul class="u1">
                  <li>   
                    <div class="helpcenter_main_content_change_t">
                      <i class="i4"></i>
                      <h3>出入金问题</h3>
                    </div> 
                    <p>出金、入金、手续费、受理时间等问题</p>
                    <div class="helpcenter_main_content_change_b">
                      <a href="submit.html?type=1">提交问题</a>
                    </div>
                  </li>
                  <li>
                    <div class="helpcenter_main_content_change_t">
                      <i  class="i5"></i>
                      <h3>用户账号问题</h3>
                    </div> 
                    <p>账户激活、换绑资料、找回密码等相关问题</p>
                    <div class="helpcenter_main_content_change_b">
                      <a href="submit.html?type=2">提交问题</a>
                    </div>     
                  </li>
                </ul>  
              </div>
            </div>
          </div>
          <div class="helpcenter_main_content h">
            <div class="helpcenter_main_content1 h2">
              <div class="text">
                综合类问题
              </div>
            </div>
            <div class="helpcenter_main_content2">
              <ul class="u2">
                <li>  
                  <div class="helpcenter_main_content2_ul_t">
                    <i class="i1"></i>
                    <h3>技术类问题</h3>
                    <p>官网无法打开、CRM系统忙等问题</p>  
                  </div>
                  <div class="helpcenter_main_content2_ul_b">
                    <a href="">提交问题</a> 
                  </div>
                </li>
                <li> 
                  <div class="helpcenter_main_content2_ul_t">
                    <i  class="i2"></i>
                    <h3>活动类问题</h3>
                    <p>参加活动、活动规则、优惠活动等相关问题</p>     
                  </div>
                  <div class="helpcenter_main_content2_ul_b">
                    <a href="">提交问题</a>
                  </div>      
                </li>
                <li>    
                  <div class="helpcenter_main_content2_ul_t">
                    <i  class="i3"></i>
                    <h3>投诉，建议类问题</h3>
                    <p>若对JPMogan有投诉或建议请点击提交问题</p>
                  </div>
                  <div class="helpcenter_main_content2_ul_b">
                    <a href="">提交问题</a>
                  </div>   
                </li>
              </ul>      
            </div>
            <div class="triangle_border_right">        
            </div>
            <div class="helpcenter_main_content_change">
              <div class="helpcenter_main_content_change1 h2">
                <div class="text">
                  综合类问题
                </div>
              </div>
              <div class="helpcenter_main_content_change2">
                <ul class="u2">
                  <li>   
                    <div class="helpcenter_main_content_change_t">
                      <i class="i1"></i>
                      <h3>技术类问题</h3>
                    </div> 
                    <p>官网无法打开、CRM系统忙等问题</p>
                    <div class="helpcenter_main_content_change_b">
                      <a href="submit.html?type=3">提交问题</a>
                    </div>
                  </li>
                  <li>
                    <div class="helpcenter_main_content_change_t">
                      <i  class="i2"></i>
                      <h3>活动类问题</h3>
                    </div> 
                    <p>参加活动、活动规则、优惠活动等相关问题</p>
                    <div class="helpcenter_main_content_change_b">
                      <a href="submit.html?type=4">提交问题</a>
                    </div>     
                  </li>
                  <li>
                    <div class="helpcenter_main_content_change_t">
                      <i  class="i3"></i>
                      <h3>投诉，建议类问题</h3>
                    </div> 
                    <p>若对JPMogan有投诉或建议请点击提交问题</p>
                    <div class="helpcenter_main_content_change_b">
                      <a href="submit.html?type=5">提交问题</a>
                    </div>     
                  </li>
                </ul>  
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="helpcenter_main_top" >
        <input type="radio" name="helpcenter" id="helpcenter2">   
        <label for="helpcenter2" id="churu">出入金问题</label>
        <div class="helpcenter_main_bot help">
          
          <div class="page_content_list_wrapper"> 
           <div class="page_content_list_content"> 
            <div class="page_content_list_title"> 
             <div class="iocn_box">
              <img src="/resource/static/front/images/jiaoyiyoushi_tit_15.png" alt="" />
             </div> 
             <h2 >入金汇款注意事项</h2> 
            </div> 
            <div class="page_content_list_nr"> 
             <p><strong>请注意：</strong></p> 
             <p>1. 客户需自行承担非JPMogan平台原因所导致的额外费用，如银行退款收取的手续费、存款过程中银行收取的手续费等；<br /> 2. 银行卡最低入金100美元，入金会在3个小时内到账；<br /> 3. 我们不接受第三方转账入金，您的开户名必须与银行卡的开户名保持一致；如果您是联名账户中的其中一员，我们允许您使用联名账户转账；<br /> 4. 我们目前不支持信用卡入金；<br /> 5. 我们严格遵守国际反洗钱法保障您的资金安全。您在JPMogan所提交的任何信息均受到JPMogan 加密技术的保护，我们绝不会在未经过您允许的情况下与第三方分享。</p> 
             <div class="clear"></div> 
            </div> 
           </div> 
           <div class="page_content_list_content" style="margin-top:30px;"> 
            <div class="page_content_list_title"> 
             <div class="iocn_box">
              <img src="/resource/static/front/images/jiaoyiyoushi_tit_15.png" alt="" />
             </div> 
             <h2 >出金取款注意事项</h2> 
            </div> 
            <div class="page_content_list_nr"> 
             <p><strong>请注意：</strong></p> 
             <p>1. 客户在申请出金时，账户内应确保有充足的资金可以出金；<br /> 2. 客户在提交【确认申请】时应确保所填写的资料信息正确无误，任何因客户个人原因填写错误而导致无法出金或由此引发的额外费用，将由客户自行承担；<br /> 3.JPmogan出入金时候，手续费为零。<br /> 4. JPMogan平台，出金一般在后台扣款后的1-3个工作日到账；<br /> 5. 我们严格遵守国际反洗钱法保障您的资金安全。您在JPMogan所提交的任何信息均受到JPMogan加密技术的保护，我们绝不会在未经过您允许的情况下与第三方分享。</p> 
             <div class="clear"></div> 
            </div> 
           </div> 
          </div>
        </div>
      </div>
      <div class="helpcenter_main_top" >
        <input type="radio" name="helpcenter" id="helpcenter3">   
        <label for="helpcenter3" id="zhanghu">账户问题</label>
        <div class="helpcenter_main_bot help">
            <div class="company_overview_content">
              <div class="default_template">
                <div class="helpcenter_main_bot_title">
                  账户问题
                </div>
                <h3 style="margin-bottom: 20px;">1、如何申请真实账户？<i></i></h3>
                <p>您好，根据澳大利亚反洗钱法以及反恐怖主义融资法，JPMogan被要求在客户开户之前必须确认客户身份，真实账户的申请需要您准备以下相关资料：</p>
                <p><strong>身份证</strong></p>
                <ul>
                <li>照片必须彩色并且清晰；</li>
                <li>必须由政府颁发；</li>
                <li>姓名，身份证号，有效期必须清晰可见；</li>
                </ul>
                <p><strong style="font-weight:bold;">常用手机号</strong><br>
                <strong style="font-weight:bold;">常用邮箱</strong></p>
                <p>确认好以上相关信息，点击官网“开立账户”并提交您的客户申请即可，一旦您的开户申请获得通过，JPMogan将会分别发送两封包含后台以及CRM客户管理后台的用户名和密码的邮件，收到邮件后请您妥善保管您的账号密码，防止密码泄露给您资金带来损失，当然您也可以通过平台软件修改您的密码，但也同样要妥善保管您的账号密码，避免泄露给其他人。</p>
                <h3 style="margin-bottom: 20px;">2、如何申请JPMogan平台模拟账户？</h3>
                <p>打开JPMogan官网，点击开设模拟账户，填写相关信息后，我们会在您的邮箱中发送模拟账户；或者您也可以通过MT4客户端，点文件——开新模拟账户，然后按照提示一步一步申请模拟账号。</p>
                <h3 style="margin-bottom: 20px;">3、我的账户的最低入金是多少？</h3>
                <p>您好，在JPMogan开设账户，最小入金为100美金。</p>
                <h3 style="margin-bottom: 20px;">4、我可以在JPMogan开设多少个账户？</h3>
                <p>您好，JPMogan限制每位客户最多开设5个同名交易账户。</p>
                <h3 style="margin-bottom: 20px;">5、JPMogan入金和出金的手续费分别是多少？</h3>
                <p>您好，JPMogan线上入金客户享有入金免手续费的优惠；</p>
                <p>如果客户选择电汇入金或出金，则到账时间大约在3~5工作日左右。</p>
                <p>请客户仔细核算出金金额，避免对交易中的账户产生影响，否则由于出金后保证金不足所引发的损失均由客户本人承担；</p>
                <h3 style="margin-bottom: 20px;">6、我的账户多久不交易会被注销？</h3>
                <p>您好，JPMogan会将客户账户保留一年时间，一年时间内客户账户在资金少于20美金的前提下无任何交易，则会被注销。</p>
                <div class="clear"></div>
              </div>
            </div>
        </div>
      </div>
      <div class="helpcenter_main_top" >
        <input type="radio" name="helpcenter" id="helpcenter4">   
        <label for="helpcenter4" id="product">产品问题</label>
        <div class="helpcenter_main_bot" style="background-color:#fff;padding-top:50px">
          
          <div class="company_overview_content" style="width: 50%;margin:0 auto; text-align: left;"> 
           <div class="default_template"> 
            <div class="helpcenter_main_bot_title">
               产品问题
            </div>
            <h3 style="margin-bottom: 20px;">1、如何查看隔夜利息表？</h3> 
            <p>JPMogan平台的隔夜利息可以在Metatrader4平台里直接查看。在”市场报价“窗口中任意位置点击右键，选择”交易品种“，在弹出的窗口中选择您想查看的货币对，然后点击右边的”属性“，随后弹出的窗口中可以看到”买单掉期库存费“及”卖单掉期库存费“ 即是买入和卖出的隔夜利息。</p> 
            <p>您同时也可以到我们网站的“<a href="">利息表</a>”上查看隔夜利息，因为隔夜利息时常会更新，如网站上的和MT4平台上的不同，请以MT4平台中的利息为准。</p> 
            <div class="table_content"> 
             <table border="0" width="100%" cellspacing="0" cellpadding="0" align="center"> 
              <tbody> 
               <tr> 
                <td style="text-align: center;"></td> 
                <td style="text-align: center;">Long</td> 
                <td style="text-align: center;">Short</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">AUDCAD</td> 
                <td style="text-align: center;">1.36</td> 
                <td style="text-align: center;">-5.244</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">AUDCHF</td> 
                <td style="text-align: center;">3.064</td> 
                <td style="text-align: center;">-7.596</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">AUDJPY</td> 
                <td style="text-align: center;">1.768</td> 
                <td style="text-align: center;">-8.424</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">AUDNAD</td> 
                <td style="text-align: center;">-4.008</td> 
                <td style="text-align: center;">0.816</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">AUDSGD</td> 
                <td style="text-align: center;"></td> 
                <td style="text-align: center;"></td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">AUDUSD</td> 
                <td style="text-align: center;">1.024</td> 
                <td style="text-align: center;">-2.76</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">CADCHF</td> 
                <td style="text-align: center;">1.704</td> 
                <td style="text-align: center;">-4.836</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">CADJPY</td> 
                <td style="text-align: center;">0.408</td> 
                <td style="text-align: center;">-4.284</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">CHFJPY</td> 
                <td style="text-align: center;">-5.94</td> 
                <td style="text-align: center;">0.072</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">EURAUD</td> 
                <td style="text-align: center;">-13.668</td> 
                <td style="text-align: center;">5.576</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">EURCAD</td> 
                <td style="text-align: center;">-8.28</td> 
                <td style="text-align: center;">2.52</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">EURCHF</td> 
                <td style="text-align: center;">0.344</td> 
                <td style="text-align: center;">-2.904</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">EURGBP</td> 
                <td style="text-align: center;">-3.312</td> 
                <td style="text-align: center;">0.48</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">EURJPY</td> 
                <td style="text-align: center;">-4.14</td> 
                <td style="text-align: center;">-0.552</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">EURNZD</td> 
                <td style="text-align: center;">-17.94</td> 
                <td style="text-align: center;">7.688</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">EURSGD</td> 
                <td style="text-align: center;"></td> 
                <td style="text-align: center;"></td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">EURUSD</td> 
                <td style="text-align: center;">-6.624</td> 
                <td style="text-align: center;">2.656</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">GBPAUD</td> 
                <td style="text-align: center;">-93528</td> 
                <td style="text-align: center;">3.88</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">GBPCAD</td> 
                <td style="text-align: center;">-4.968</td> 
                <td style="text-align: center;">0.68</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">GBPCHF</td> 
                <td style="text-align: center;">1.704</td> 
                <td style="text-align: center;">-6.492</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">GBPJPY</td> 
                <td style="text-align: center;">-2.208</td> 
                <td style="text-align: center;">-4.14</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">GBPNZD</td> 
                <td style="text-align: center;">-15.18</td> 
                <td style="text-align: center;">6.056</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">GBPSGD</td> 
                <td style="text-align: center;"></td> 
                <td style="text-align: center;"></td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">GBPUSD</td> 
                <td style="text-align: center;">-2.352</td> 
                <td style="text-align: center;">0.48</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">NADCAD</td> 
                <td style="text-align: center;">2.448</td> 
                <td style="text-align: center;">-6.348</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">NZDCHF</td> 
                <td style="text-align: center;">3.744</td> 
                <td style="text-align: center;">-9.252</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">NZDJPY</td> 
                <td style="text-align: center;">3.472</td> 
                <td style="text-align: center;">-9.528</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">NZDSGD</td> 
                <td style="text-align: center;"></td> 
                <td style="text-align: center;"></td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">NZDUSD</td> 
                <td style="text-align: center;">1.84</td> 
                <td style="text-align: center;">-4.284</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">SGDJPY</td> 
                <td style="text-align: center;">-4.56</td> 
                <td style="text-align: center;">-8.976</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">USDCAD</td> 
                <td style="text-align: center;">-1.104</td> 
                <td style="text-align: center;">-2.484</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">USDCHF</td> 
                <td style="text-align: center;"></td> 
                <td style="text-align: center;"></td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">USDCNG</td> 
                <td style="text-align: center;">-138</td> 
                <td style="text-align: center;">8.84</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">USDJPY</td> 
                <td style="text-align: center;">0.816</td> 
                <td style="text-align: center;">-7.044</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">USDNOK</td> 
                <td style="text-align: center;">-8.28</td> 
                <td style="text-align: center;">-8.28</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">USDSEK</td> 
                <td style="text-align: center;">14.96</td> 
                <td style="text-align: center;">-82.8</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">USDSGD</td> 
                <td style="text-align: center;">-2.484</td> 
                <td style="text-align: center;">-7.176</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">XAGAUS</td> 
                <td style="text-align: center;"></td> 
                <td style="text-align: center;"></td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">XAGUSD</td> 
                <td style="text-align: center;">-1.2</td> 
                <td style="text-align: center;">-0.389</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">XAUAUD</td> 
                <td style="text-align: center;"></td> 
                <td style="text-align: center;"></td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">XAUUSD</td> 
                <td style="text-align: center;">-70.38</td> 
                <td style="text-align: center;">-9.66</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">XPDUSD</td> 
                <td style="text-align: center;"></td> 
                <td style="text-align: center;"></td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">XPTUSD</td> 
                <td style="text-align: center;">-9.4944</td> 
                <td style="text-align: center;">-2.2218</td> 
               </tr> 
              </tbody> 
             </table> 
            </div> 
            <h3 style="margin-bottom: 20px;">2、保证金是什么？如何计算我的保证金？</h3> 
            <p>在MT4平台上，我们将Magin翻译成预付款。一般称为”保证金”。</p> 
            <p>保证金是指您为了开设仓位而必须预付在账户中的一笔款项。与此前固定保证金模式不同，JPMogan采用全新的浮动保证金计算方式—-所交易产品的市场价将关联至保证金的浮动金额，即投资者在JPMogan平台进行的外汇或贵金属交易保证金有可能将跟随其市场价发生变动。JPMogan提供高达400倍的保证金杠杆。</p> 
            <p>所需保证金是以基础货币为单位进行计算然后按现汇价格换算成美元来计算。如果您的可用保证金（预付款）低于您开仓时所需要的保证金，您将不能开仓。</p> 
            <p>可用保证金是用来衡量可以开设多少新仓位所需的保证金。</p> 
            <p>注：保证金的计算变量Market Price指定为成交时交易产品分子直盘的市场价(Market Price)。</p> 
            <p><strong>保证金是用由以下公式计算得出：</strong></p> 
            <p>保证金 = 交易手数(Lots) * 合约数(Contract Size) * 市场价(Market Price) / 默认杠杆(Leverage)举例如下：</p> 
            <p>如果您希望在EUR/USD的现价（1.35645）基础上开仓一个数量为0.1手（1手合约单位为100000基础单位）的订单，账户杠杆是400倍，则您的所需保证金计算公式如下：：</p> 
            <p>(0.1x 100000x 1.35645 ) / 400 = $33.91</p> 
            <p>在这个例子中，下一个0.1手的订单所需保证金为33.91美金，所以您的账户内可用保证金至少有33.91美金，才可以开设仓位成功。</p> 
            <p>如果是USD/JPY 等USD作为基础货币的货币对，则所需保证金则直接为：交易数量/杠杆。</p> 
            <p>如若上述投资者在99.80档位做多1迷你手的美元/日元，则其订单成交当下已用保证金（固定）为：</p> 
            <p>保证金 = 1Lot * 10,000(Contract size) * 1(Market Price) / 100(Leverage) = 100.00(USD)</p> 
            <p>再者，当该交易者在JPMogan平台于0.9460档位做空1迷你手的美元/瑞郎货币对，由于其分子（美元）的直盘市场价为1，则该用户在订单成交当下的已用保证金金额（固定）为：</p> 
            <p>保证金 = 1Lot * 10,000(Contract size) * 1(Market Price) / 100(Leverage) = 100.00(USD)</p> 
            <p>以下是一些关于外汇交叉盘以及黄金产品的保证金计算方式：</p> 
            <p>如，客户A在JPMogan 平台于102.20档位做空2迷你手的澳元/日元，而此时分子直盘澳元/美元的报价为1.0304，则客户A在订单成交当下的已用保证金为：</p> 
            <p>保证金 = 2Lots * 10,000(Contract Size) * 1.0304(Market Price) / 100(Leverage) = 206.08(USD)</p> 
            <p>注：其已用保证金将跟随澳元/美元市场价的变化而不断调整。</p> 
            <p>另，当客户A在JPMogan平台于0.8520档位做空5迷你手的欧元/英镑，而此时分子直盘欧元/美元的报价为1.3048，则该用户的在成交时的保证金为：</p> 
            <p>保证金 = 5Lots * 10,000(Contract Size) * 1.3048(Market Price) / 100(Leverage) = 652.40(USD)</p> 
            <p>注：其已用保证金将跟随欧元/美元市场价的变化而不断调整。</p> 
            <p>最后，此次的保证金新政同样适用于各投资者在JPMogan平台涉及的黄金和白银产品交易。例如：客户A于1440.00美元档位做空10迷你手的黄金（1迷你手的黄金合约为10盎司），则订单成交时，其已用保证金为：</p> 
            <p>保证金 = 10Lots * 10(Contract Size) * 1440(Market Price) / 100(Leverage) = 1440.00(USD)</p> 
            <p>注：其已用保证金将跟随黄金价格（XAU/USD）的变化而不断调整。</p> 
            <p>JPMogan此次杠杆及保证金新政旨在有效控制所有客户在JPMogan平台进行的有关外汇，贵金属产品的投资风险，而此次CFD 差价合约的保证金计算方式仍维持不变。</p> 
            <p>JPMogan再次提醒投资者需完全理解本次政策的更改条例。</p> 
            <h3>JPMogan可以提供哪些杠杆？</h3> 
            <p>您好，JPMogan提供灵活的杠杆，从1:100~1:400，以适应不同的客户需求，修改杠杆需要客户通过后台提交杠杆修改申请。</p> 
            <p>具体杠杆申请门槛如下：</p> 
            <div class="table_content"> 
             <table border="0" width="100%" cellspacing="0" cellpadding="0"> 
              <thead> 
               <tr> 
                <th style="text-align: center;" colspan="3">JPMogan杠杆申请条件</th> 
               </tr> 
              </thead> 
              <tbody> 
               <tr> 
                <td style="text-align: center;">可用杠杆</td> 
                <td style="text-align: center;">最低入金</td> 
                <td style="text-align: center;">最大资金限制</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">1:400</td> 
                <td style="text-align: center;">500$</td> 
                <td style="text-align: center;">50000$</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">1:300</td> 
                <td style="text-align: center;">500$</td> 
                <td style="text-align: center;">100000$</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">1:200</td> 
                <td style="text-align: center;">500$</td> 
                <td style="text-align: center;">250000$</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">1:100</td> 
                <td style="text-align: center;">200$</td> 
                <td style="text-align: center;">&gt;250000$</td> 
               </tr> 
              </tbody> 
             </table> 
            </div> 
            <h3 style="margin-bottom: 20px;">4、JPMogan平台的强制平仓规则是什么？</h3> 
            <p>JPMogan的保证金追缴水平为预付款（保证金）比例到达120%时平台内的最大亏损订单出现颜色提醒，但不会强制平仓。当预付款比例降低到100%以下时，系统便会开始强制平仓，平仓顺序是从亏损最大的订单到亏损最小的订单开始逐个平仓。注意：不是同一时间全部平仓所有仓位，而是逐个平仓。当平掉一个最大的亏损仓位时，预付款比例高于100%，系统不会再继续平仓，而是等待预付款比例再次到达100%以下时，才开始平掉下一个亏损最大的订单。</p> 
            <p>保证金强平公式如下：<br /> 预付款比例水平=净值 / 已用预付款 x 100% = 预付款水平 %</p> 
            <h3 style="margin-bottom: 20px;">5、JPMogan平台可以提供哪些产品交易？</h3> 
            <p>您好JPMogan平台拥有36种货币对，6种商品包括金、银、铜，以及原油（期货/现货）和气，还有12种指数可供交易，更多产品后续将会上架，敬请期待。</p> 
            <h3 style="margin-bottom: 20px;">6、JPMogan平台的模拟账户有有效期限制吗？</h3> 
            <p>您好，JPMogan对于模拟账户的体验时间默认为30天。</p> 
            <h3 style="margin-bottom: 20px;">7、JPMogan平台的单笔最小和最大开仓是多少？</h3> 
            <p>您好，JPMogan平台的所有产品单笔开仓要求如下：</p> 
            <div class="table_content"> 
             <table border="0" width="100%" cellspacing="0" cellpadding="0"> 
              <thead> 
               <tr> 
                <th style="text-align: center;"></th> 
                <th style="text-align: center;">单笔最小手数</th> 
                <th style="text-align: center;">单笔最大手数</th> 
               </tr> 
               <tr> 
                <td style="text-align: center;">外汇</td> 
                <td style="text-align: center;">0.01手</td> 
                <td style="text-align: center;">50手</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">XAUUSD</td> 
                <td style="text-align: center;">0.01手</td> 
                <td style="text-align: center;">25手</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">XAGUSD</td> 
                <td style="text-align: center;">0.01手</td> 
                <td style="text-align: center;">25手</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">CL-OIL</td> 
                <td style="text-align: center;">0.01手</td> 
                <td style="text-align: center;">25手</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">USOUSD</td> 
                <td style="text-align: center;">0.1手</td> 
                <td style="text-align: center;">200手</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">COPPER</td> 
                <td style="text-align: center;">0.01手</td> 
                <td style="text-align: center;">10手</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">GAS</td> 
                <td style="text-align: center;">0.01手</td> 
                <td style="text-align: center;">10手</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">HO</td> 
                <td style="text-align: center;">0.01手</td> 
                <td style="text-align: center;">10手</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">NG</td> 
                <td style="text-align: center;">0.01手</td> 
                <td style="text-align: center;">10手</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">CHINA50</td> 
                <td style="text-align: center;">1手</td> 
                <td style="text-align: center;">125手</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">DAX30</td> 
                <td style="text-align: center;">1手</td> 
                <td style="text-align: center;">125手</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">DJ30</td> 
                <td style="text-align: center;">1手</td> 
                <td style="text-align: center;">125手</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">FTSE100</td> 
                <td style="text-align: center;">1手</td> 
                <td style="text-align: center;">125手</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">HSI</td> 
                <td style="text-align: center;">1手</td> 
                <td style="text-align: center;">125手</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">SP500</td> 
                <td style="text-align: center;">1手</td> 
                <td style="text-align: center;">125手</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">SPI200</td> 
                <td style="text-align: center;">1手</td> 
                <td style="text-align: center;">125手</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">Nikkei225</td> 
                <td style="text-align: center;">50手</td> 
                <td style="text-align: center;">10,000手</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">FRA40</td> 
                <td style="text-align: center;">1手</td> 
                <td style="text-align: center;">125手</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">NAS100</td> 
                <td style="text-align: center;">1手</td> 
                <td style="text-align: center;">125手</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">USDX</td> 
                <td style="text-align: center;">1手</td> 
                <td style="text-align: center;">125手</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">VIX</td> 
                <td style="text-align: center;">1手</td> 
                <td style="text-align: center;">125手</td> 
               </tr> 
              </thead> 
             </table> 
            </div> 
            <h3 style="margin-bottom: 20px;">8、外汇、贵金属、指数在止损设置中距离现价限制是多少？</h3> 
            <p>您好，JPMogan对相关产品的止损设置中要求如下：</p> 
            <div class="table_content"> 
             <table border="0" width="100%" cellspacing="0" cellpadding="0"> 
              <thead> 
               <tr> 
                <th style="text-align: center;">symbol</th> 
                <th style="text-align: center;">挂单距离</th> 
               </tr> 
              </thead> 
              <tbody> 
               <tr> 
                <td style="text-align: center;">外汇</td> 
                <td style="text-align: center;">20points</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">XAUUSD</td> 
                <td style="text-align: center;">200points</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">XAGUSD</td> 
                <td style="text-align: center;">10points</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">CL-OIL</td> 
                <td style="text-align: center;">50points</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">USOUSD</td> 
                <td style="text-align: center;">50points</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">COPPER</td> 
                <td style="text-align: center;">0</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">GAS</td> 
                <td style="text-align: center;">0</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">HO</td> 
                <td style="text-align: center;">0</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">NG</td> 
                <td style="text-align: center;">0</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">CHINA50</td> 
                <td style="text-align: center;">20points</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">DAX30</td> 
                <td style="text-align: center;">500points</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">DJ30</td> 
                <td style="text-align: center;">500points</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">FTSE100</td> 
                <td style="text-align: center;">500points</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">HSI</td> 
                <td style="text-align: center;">0</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">SP500</td> 
                <td style="text-align: center;">200points</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">SPI200</td> 
                <td style="text-align: center;">500points</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">Nikkei225</td> 
                <td style="text-align: center;">1000points</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">FRA40</td> 
                <td style="text-align: center;">500points</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">NAS100</td> 
                <td style="text-align: center;">400points</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">USDX</td> 
                <td style="text-align: center;">0</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">VIX</td> 
                <td style="text-align: center;">1000points</td> 
               </tr> 
              </tbody> 
             </table> 
            </div> 
            <h3 style="margin-bottom: 20px;">9、外汇、贵金属、商品及相关指数的报价开始关闭时间范围是多少？</h3> 
            <p>您好，JPMogan所有产品报价的开关时间如下：</p> 
            <h3 style="margin-bottom: 20px;">外汇</h3> 
            <div class="table_content"> 
             <table border="0" width="100%" cellspacing="0" cellpadding="0"> 
              <thead> 
               <tr> 
                <th style="text-align: center;">市场</th> 
                <th style="text-align: center;">报价时间</th> 
                <th style="text-align: center;">开市时间</th> 
               </tr> 
              </thead> 
              <tbody> 
               <tr> 
                <td style="text-align: center;">AUD/USD </td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">EUR/USD </td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">GBP/USD</td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">NZD/USD</td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">USD/JPY</td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">USD/CAD</td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">GBP/JPY</td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">USD/CHF</td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">AUD/CAD</td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">AUD/CHF</td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">AUD/JPY</td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">AUD/NZD</td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">AUD/SGD</td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">CAD/CHF</td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">CAD/JPY</td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">CHF/JPY</td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">EUR/AUD</td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">EUR/CAD</td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">EUR/CHF</td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">EUR/GBP</td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">EUR/JPY</td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">EUR/NZD</td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">EUR/SGD</td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">GBP/AUD</td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">GBP/CAD</td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">GBP/CHF</td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">GBP/NZD</td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">GBP/SGD</td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">NZD/CAD</td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">NZD/CHF</td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">NZD/SGD</td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">NZD/JPY</td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">SGD/JPY</td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">USD/NOK</td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">USD/SGD</td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">USD/SEK</td> 
                <td style="text-align: center;">00:00-24:00</td> 
                <td style="text-align: center;">00:01-23:59</td> 
               </tr> 
              </tbody> 
             </table>
            </div> 
            <h3 style="margin-bottom: 20px;">商品</h3> 
            <div class="table_content"> 
             <table border="0" width="100%" cellspacing="0" cellpadding="0"> 
              <thead> 
               <tr> 
                <th style="text-align: center;">市场</th> 
                <th style="text-align: center;">报价时间</th> 
                <th style="text-align: center;">开市时间</th> 
               </tr> 
              </thead> 
              <tbody> 
               <tr> 
                <td style="text-align: center;">XAUUSD</td> 
                <td style="text-align: center;">01:00-24:00</td> 
                <td style="text-align: center;">01:00-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">XAGUSD</td> 
                <td style="text-align: center;">01:00-24:00</td> 
                <td style="text-align: center;">01:00-23:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">CL-OIL</td> 
                <td style="text-align: center;">01:00-24:00（周五01:00-23:45）</td> 
                <td style="text-align: center;">01:00-24:00（周五01:00-23:45）</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">USOUSD</td> 
                <td style="text-align: center;">01:00-24:00</td> 
                <td style="text-align: center;">01:00-24:00</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">COPPER</td> 
                <td style="text-align: center;">01:00-24:00</td> 
                <td style="text-align: center;">01:00-24:00</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">GAS</td> 
                <td style="text-align: center;">01:00-24:00</td> 
                <td style="text-align: center;">01:00-24:00</td> 
               </tr> 
              </tbody> 
             </table>
            </div> 
            <h3 style="margin-bottom: 20px;">指数</h3> 
            <div class="table_content"> 
             <table border="0" width="100%" cellspacing="0" cellpadding="0"> 
              <thead> 
               <tr> 
                <th style="text-align: center;">市场</th> 
                <th style="text-align: center;">报价时间</th> 
                <th style="text-align: center;">开市时间</th> 
               </tr> 
              </thead> 
              <tbody> 
               <tr> 
                <td style="text-align: center;">DAX30</td> 
                <td style="text-align: center;">09:00-23:00</td> 
                <td style="text-align: center;">09:00-23:00</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">FTSE100</td> 
                <td style="text-align: center;">09:00-23:00</td> 
                <td style="text-align: center;">09:00-23:00</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">FRA40</td> 
                <td style="text-align: center;">09:00-23:00</td> 
                <td style="text-align: center;">09:00-22:59</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">SP500</td> 
                <td style="text-align: center;">01:00-23:15,23:30-24:00（周五01:00-23:15）</td> 
                <td style="text-align: center;">01:00-23:15,23:30-24:00（周五01:00-23:15）</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">SPI200</td> 
                <td style="text-align: center;">02:50-09:29,10:10-23:59（周五10:10-23:44）</td> 
                <td style="text-align: center;">02:50-09:29,10:10-23:59（周五10:10-23:44）</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">DJ30</td> 
                <td style="text-align: center;">01:00-23:15,23:30-24:00（周五01:00-23:15）</td> 
                <td style="text-align: center;">01:00-23:15,23:30-24:00（周五01:00-23:15）</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">HSI</td> 
                <td style="text-align: center;">04:00-07:00,08:00-11:15</td> 
                <td style="text-align: center;">04:15-07:00,08:00-11:15</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">CHINA50</td> 
                <td style="text-align: center;">04:00-10:55,11:40-21:00（周五11:45-21:00）</td> 
                <td style="text-align: center;">04:00-10:55,11:40-21:00（周五11:40-21:00）</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">USDX</td> 
                <td style="text-align: center;">周一&nbsp;01:00-24:00&nbsp;<br />周二至周五03:00-24:00</td> 
                <td style="text-align: center;">周一&nbsp;01:00-24:00&nbsp;<br />周二至周五03:00-24:00</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">VIX&nbsp;</td> 
                <td style="text-align: center;">01:00-23:15&nbsp;,23:30-24:00</td> 
                <td style="text-align: center;">01:00-23:15&nbsp;,23:30-24:00</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">NAS100&nbsp;</td> 
                <td style="text-align: center;">01:00-23:15&nbsp;,23:30-24:00</td> 
                <td style="text-align: center;">01:00-23:15&nbsp;,23:30-24:00</td> 
               </tr> 
               <tr> 
                <td style="text-align: center;">Nikkei225</td> 
                <td style="text-align: center;">01:00-23:15</td> 
                <td style="text-align: center;">01:00-23:15</td> 
               </tr> 
              </tbody> 
             </table>
            </div> 
            <div class="clear"></div> 
           </div> 
          </div>

        </div>
      </div>
      <div class="helpcenter_main_top"   style="width: 50%;margin:0 auto; text-align: left;">
        <input type="radio" name="helpcenter" id="helpcenter5">   
        <label for="helpcenter5" id="trade">交易问题</label>
        <div class="helpcenter_main_bot" style="background-color:#fff;padding-top:50px">
          
          <div class="company_overview_content"> 
           <div class="default_template">
           <div class="helpcenter_main_bot_title">
              交易问题
           </div>             <h3 style="margin-bottom: 20px;">1、什么是点差？</h3> 
            <p>您好，在外汇交易中，您会看到一个两边的报价，由买价 (ask) 与卖价 (bid) 组成。买价代表您能买入基础货币的价位 (同时卖出非基础货币)；卖价代表您能卖出基础货币的价位 (同时买入非基础货币) 。买价与卖价的差别为点差，交易商通过买卖的点差获利。</p> 
            <h3>2、当我的交易遇到问题，可以使用电话交易吗？</h3> 
            <p>您好，JPMogan提供5天24小时交易，如果在交易中遇到任何问题可以拨打官方客服热线进行交易，但是我们的电话交易只负责修改及关闭仓位，而不接受新开仓的指令。</p> 
            <h3 style="margin-bottom: 20px;">3、什么是滑点？</h3> 
            <p>“滑点”是指一笔交易或挂单交易，实际订单成交价格与预设价格之间存在差异的一种交易现象。它发生在市场价格产生较大变化，而流通量跟不上价格变化的时刻，例如市场跳空，可能是周末结束后重新开市，或者在重大新闻事件后（例如就业数据或利率决议）。所有市场偶尔都会发生滑点是普遍共识，而在ECN撮合交易的公正机制下，当投资者预设一个止盈单、止损单或挂单后，如市场价格达到投资者设定的触发价格时，止盈单、止损单或挂单将会成为市价单，并以当时可执行的最优市场价格成交。因此，滑点可能导致更大的收益，或是更大的损失，收益和风险的概率是相等的。</p> 
            <p>此外，我们建议客户避免或减少在周末或市场收盘前或任何政治事件、重大新闻发布时持仓的风险敞口，并且了解这类型的跳空很有可能经常会发生。</p> 
            <p><strong>如何规避滑点可能造成的负面影响？</strong><br /> a.首先，滑点是无法真正规避的，滑点的范围也是无法预测的。在真实的市场行情中，我们预测不了下一个价位，因此无法给出滑点范围；<br /> b.JPMogan提供的以下策略有助于减少客户交易损失：<br /> 尽可能减少在滑点出现的情况里进行类似限价入场等挂单操作；<br /> 尽可能不要进行重仓交易，保持充足的保证金以抵御无法预知的跳空；</p> 
            <p>JPMogan建议客户熟悉阅读以上风险说明并认可熟知后开户交易，如果您不接受以上风险说明，敬请取消开户或撤资。</p> 
            <h3 style="margin-bottom: 20px;">4、什么是价格跳空？</h3> 
            <p>“跳空”是指发生市场变动从一个报价跳至第二个报价，且幅度较大。订单（止损，限价或新订单）执行报价与先前所设置报价不一致，即发生跳空事件。即上一个价格与下一个价格之间产生超乎寻常的间隔时我们常看到的缺口，英文里用“Gap”来描述。</p> 
            <p><img class="alignnone size-full wp-image-364" src="/resource/static/front/images/Common_problem6.png" alt="common_problem20161024-06" width="356" height="262"  sizes="(max-width: 356px) 100vw, 356px" /></p> 
            <p>这种事件的发生可能有很多种原因。一般来说，因为开盘时的开仓价格与前一交易日收盘价显著不同；或在交易过程中，相关基础市场异常波动或流动性不足等原因，导致价格突然大幅波动；或由于经济、政治、环境或企业新闻等造成了相关基础市场从一个价格跳空并成交在另一个显著不同的价格。</p> 
            <p>此外，我们建议客户避免或减少在周末或市场收盘前或任何政治事件、重大新闻发布时持仓的风险敞口，并且了解这类型的跳空很有可能经常会发生。</p> 
            <p>以下为几种挂单和止盈止损的价格波动情况，这四种情况均发生在价格变动时买卖流动性不对称的情况下：</p> 
            <p><strong>例子1、平仓之限价委托单（止盈）</strong></p> 
            <p>持有多单 – 执行“限价卖出”平仓，即“止盈”。</p> 
            <p><strong>挂单：</strong>客户以市价买入1手现货黄金XAUSUD （持有多单），开仓价为<strong>1375.16</strong>， 同时，该客户马上以<strong>1376.90</strong>，建立一张平仓之限价委托（即止盈）。</p> 
            <p><strong>执行</strong>：建立委托单后，「卖价」之后一直没有升至<strong>1376.90</strong>， 然而之后市场突然出现较大波动， 市场报价「跳空」情况出现, 卖价突然穿越委托单之价格 （<strong>1376.90</strong>），跳至<strong>1377.34</strong>，触发系统以跳空后的第一口市场价<strong>1377.34</strong>执行成交。和预设止盈价<strong>1376.90</strong>相比，多获利<strong>44</strong>美金。</p> 
            <div class="table_content"> 
             <table border="0" cellspacing="0" cellpadding="0"> 
              <tbody> 
               <tr> 
                <td align="center">持仓单类型</td> 
                <td align="center">手数</td> 
                <td align="center">商品</td> 
                <td align="center">价位</td> 
                <td align="center">止盈挂单Sell Limit设置（卖出）</td> 
                <td align="center">成交价格</td> 
               </tr> 
               <tr> 
                <td align="center">买入</td> 
                <td align="center">1</td> 
                <td align="center">XAUUSD</td> 
                <td align="center">1375.16</td> 
                <td align="center">1376.90</td> 
                <td align="center">1377.34</td> 
               </tr> 
              </tbody> 
             </table> 
            </div> 
            <p><strong>例子2：平仓之停损委托单 （止损） </strong></p> 
            <p>持有空单 – 执行“停损买入”平仓，即“止损”。</p> 
            <p><strong>挂单：</strong>客户以市价卖出1手现货黄金XAUSUD （持有空单），开仓价为<strong>1430.23</strong>， 同时，该客户马上以<strong>1432.83</strong>，建立一张平仓之停损委托（即止损）。<br /> <strong>执行：</strong>建立委托单后，「买价」之后一直没有升至<strong>1432.83</strong>， 然而之后市场突然出现较大波动， 市场报价「跳空」情况出现, 买价突然穿越委托单之价格 （<strong>1432.83</strong>），跳至<strong>1433.02</strong>，触发系统以跳空后的第一口市场价<strong>1433.02</strong>执行成交。和预设止损价<strong>1432.83</strong>相比，多损失<strong>19</strong>美金。</p> 
            <div class="table_content"> 
             <table border="0" cellspacing="0" cellpadding="0"> 
              <tbody> 
               <tr> 
                <td align="center">持仓单类型</td> 
                <td align="center">手数</td> 
                <td align="center">商品</td> 
                <td align="center">价位</td> 
                <td align="center">止损挂单Buy Stop设置（买入）</td> 
                <td align="center">成交价格</td> 
               </tr> 
               <tr> 
                <td align="center">买入</td> 
                <td align="center">1</td> 
                <td align="center">XAUUSD</td> 
                <td align="center">1430.23</td> 
                <td align="center">1432.83</td> 
                <td align="center">1433.02</td> 
               </tr> 
              </tbody> 
             </table> 
            </div> 
            <p><strong>例子3：开仓之限价委托单（限价买入）</strong></p> 
            <p>未持仓，挂单入场。</p> 
            <p><strong>挂单：</strong>客户建立了一张限价买入委托单（开仓），买入1手欧美货币对，挂单价为<strong>1.3180</strong>。</p> 
            <p><strong>执行：</strong>成功建立委托单后，「买价」之后一直没有跌至<strong>1.3180</strong>，然而之后市场突然出现较大波动，市场报价「跳空」情况出现,，买价突然穿越委托单之价格 （<strong>1.3180</strong>），下降至<strong>1.3173</strong>，触发系统以跳空后的第一口市场价<strong>1.3173</strong>执行成交。和预设开仓价<strong>1.3180</strong>相比，多获利<strong>70</strong>美金。</p> 
            <div class="table_content"> 
             <table border="0" cellspacing="0" cellpadding="0"> 
              <tbody> 
               <tr> 
                <td align="center">开仓挂单类型</td> 
                <td align="center">手数</td> 
                <td align="center">商品</td> 
                <td align="center">预设价位</td> 
                <td align="center">成交价格</td> 
               </tr> 
               <tr> 
                <td align="center">限价买入Buy Limit</td> 
                <td align="center">1</td> 
                <td align="center">EURUSD</td> 
                <td align="center">1.3180</td> 
                <td align="center">1.3173</td> 
               </tr> 
              </tbody> 
             </table> 
            </div> 
            <p><strong>例子4：开仓之停损委托单（停损卖出）</strong></p> 
            <p>未持仓，挂单入场。</p> 
            <p><strong>挂单：</strong>客户建立了一张停损卖出委托单（开仓），卖出1手镑美货币对，挂单价为<strong>1.6420</strong>。<br /> <strong>执行：</strong>成功建立委托单后，「卖价」之后一直没有跌至<strong>1.6420</strong>，然而之后市场突然出现较大波动，市场报价「跳空」情况出现，卖价突然穿越委托单之价格（<strong>1.6420</strong>），跌至<strong>1.6418</strong>，触发系统以跳空后的第一口市场价<strong>1.6418</strong>执行成交。和预设开仓价<strong>1.6420</strong>相比，少挣或多损失<strong>20</strong>美金。</p> 
            <div class="table_content"> 
             <table border="0" cellspacing="0" cellpadding="0"> 
              <tbody> 
               <tr> 
                <td align="center">开仓挂单类型</td> 
                <td align="center">手数</td> 
                <td align="center">商品</td> 
                <td align="center">价位</td> 
                <td align="center">成交价格</td> 
               </tr> 
               <tr> 
                <td align="center">停损卖出 Sell Stop</td> 
                <td align="center">1</td> 
                <td align="center">GBPUSD</td> 
                <td align="center">1.6420</td> 
                <td align="center">1.6418</td> 
               </tr> 
              </tbody> 
             </table> 
            </div> 
            <p>任何订单（包括止盈、止损、挂单）均可能因市况波动或受跳空的影响，未能在预设的价格执行。如遇上此情况，订单将会按照市场下一个最有利的价格执行，滑点的程度取决于市场买卖双方的流动性。在ECN匿名撮合成交的模式下，每个客户的订单都会被公平匿名撮合，每个客户都可能得到更大的收益或亏损，其收益和风险是双向对等的。</p> 
            <p>一般跳空发生的时间窗口：<br /> a.非农等重要风险财经事件的公布；<br /> b.意料之外的财经数据公布；<br /> c.货币、财政政策变更消息公布；<br /> d.重要财政官员讲话干预；<br /> e.市场针对某产品或某货币的巨大需求产生巨大交易量。</p> 
            <p><strong>价格跳空产生的影响：</strong></p> 
            <p>1.无论是止盈、止损、市场单还是其他进场型挂单，只要遇到行情跳空，其成交就会受到影响。平台会以跳空后的价格为客户成交订单。这个价格由于是市场中存在的真实价格，因此无法预知其与跳空前的价格距离。<br /> 2.跳空会造成订单的滑点成交。<br /> 3.跳空造成的滑点成交可能会造成客户在爆仓后净值为负值。</p> 
            <p>特别声明：由于该现象为市场交易的常规现象，JPMogan强烈建议客户仔细阅读风险说明书，了解真实市场状况后再选择交易，否则由客观市场在特殊情况下价格调控所导致的滑点成交或爆仓，JPMogan不承担任何责任，更不给予任何赔偿。</p> 
            <h3 style="margin-bottom: 20px;">5、什么是差价扩大？为什么会产生差价扩大？</h3> 
            <p>JPMogan作为ECN平台提供商，为客户提供浮动点差的交易，客户可以通过官网交易产品一栏查看点差浮动的基本状况。但是在某些特殊情况下，交易产品也会出现比平均值高出一些的点差情况，我们称之为点差扩大。</p> 
            <p>点差扩大一般发生在特殊的新闻事件公布的时间节点，这时候外汇、贵金属等产品在行情出现价格跳空会有点差扩大的现象，而差价合约类产品CFDs在期货正常交易时间外也会出现点差扩大的现象。</p> 
            <p>在真正了解点差扩大的同时，我们首先需要了解ECN的成交原理：</p> 
            <p><strong>ECN交易平台的客户订单成交过程是这样的：</strong></p> 
            <p>客户下单（买或卖）－－＞订单通过交易商平台－－＞订单被执行到银行间市场（ECN交易网络）中的某家银行接受（卖或买）</p> 
            <p>值得注意的是，在这个过程中，买入和卖出是两个过程，两者并非同时进行，因此这两个操作的执行可能会被不同的银行所接受，具体如下图所示：</p> 
            <p><img class="alignnone size-full wp-image-365" src="/resource/static/front/images/Common_problem7.png" alt="common_problem20161024-07" width="719" height="485"  sizes="(max-width: 719px) 100vw, 719px" /></p> 
            <p>因此报价的形成过程便是：</p> 
            <p>在银行间市场各个银行独自报出该时刻某个货币对的买入价和卖出价，而交易商便从这些报价中筛选出对客户最优的买入和卖出价，客户收到最优价格得到交易最大利润化。</p> 
            <p>比如: 某个时间点 针对EUR/USD<br /> CityBank 报价： &nbsp;买入价：1.32035 卖出价 1.32010<br /> HSBC 报价： &nbsp; &nbsp; &nbsp;买入价：1.32033 卖出价 1.32011<br /> NAB &nbsp;报价： &nbsp; &nbsp; &nbsp;买入价：1.32036 卖出价 1.32013<br /> …………….<br /> …………….</p> 
            <p>这些报价都会瞬时汇聚到银行间报价市场然后传导到ECN交易网络。</p> 
            <p>而在以上超过50家世界级银行报价源中，JPMogan平台商会筛选出对客户的最优价格，从以上案例可以看出买入价最低为 1.32033（HSBC提供），而卖出价最高为 1.32013（NAB)，此时客户看到的报价为1.32033/1.32013。</p> 
            <p>当流动性银行报价源足够时，客户能够得到更好的交易成本。</p> 
            <p><strong>那么点差为什么会扩大？</strong></p> 
            <p>由于在开盘或发生风险事件时，很多银行以及交易机构为了风险管理停止了报价和交易，因此导致流动性报价源流量变小，在极少数银行报价的前提下JPMogan的点差便会随之扩大。</p> 
            <p><strong>一般点差扩大的时间集中在：</strong><br /> a.周末停盘以及周一开盘的5分钟内；<br /> b.重要数据或重大新闻发生。</p> 
            <p><strong>点差扩大对交易可能产生的影响：</strong><br /> a.锁仓账户的爆仓；（如果客户可用保证金不足，点差扩大导致净值减少会导致保证金比例过低，当净值减少到保证金的100%比例的时候，系统会将客户的仓位进行强制平仓，在这个过程中容易伴随滑点的产生，导致客户爆仓后的资金减少）<br /> b.针对锁仓单的止盈止损点位的成交不对称。（因为买入价和卖出价的巨大差价，导致买入价和卖出价的成交价亦发生巨大差异。）</p> 
            <p>因此，JPMogan提醒经常锁仓交易的客户，交易过程中预留充足保证金交易，以免净值低于保证金的100%导致爆仓。</p> 
            <p>由于该现象为市场交易的常规现象，JPMogan强烈建议客户仔细阅读风险说明书，了解真实市场状况后再选择交易，否则由客观市场在特殊情况下点差扩大所导致的滑点成交或爆仓，JPMogan不承担任何责任，更不给予任何赔偿。</p> 
            <h3 style="margin-bottom: 20px;">6、JPMogan平台在市场休市期间能否进行交易？</h3> 
            <p>您好，在市场休市期间，全球银行端报价停止，因此JPMogan平台不允许客户开仓交易。</p> 
            <h3 style="margin-bottom: 20px;">7、JPMogan平台锁仓占用保证金吗？</h3> 
            <p>您好，JPMogan平台中的所有产品锁仓均不占用保证金。</p> 
            <h3 style="margin-bottom: 20px;">8、为什么我周三的隔夜单利息收了三倍？</h3> 
            <p>您好，根据国际银行惯例，外汇交易在2个交易日后结算。隔夜利息是按照结算日计算。周三：3天隔夜利息。周三持仓到周四，结算日为周五到下周一，所以要支付/收取3天利息。</p> 
            <h3 style="margin-bottom: 20px;">9、在同一时间对持有多大订单有限制吗？</h3> 
            <p>您好，在交易的持仓上，JPMogan会根据客户的交易手数调整杠杆，建议客户调整仓位。</p> 
            <h3 style="margin-bottom: 20px;">10、我可以持有我的订单多久？</h3> 
            <p>您好，原则上只要保证金充足，你可以一直持有您的订单。</p> 
            <h3 style="margin-bottom: 20px;">11、JPMogan平台的CFDs是如何计算价格的？</h3> 
            <p>您好，JPMogan的差价合约的价格是根据标的产品与公允价值做出了调整的价格计算。公允价值等于现货价格减去复利和股息后得到的价格。</p> 
            <div class="clear"></div> 
           </div> 
          </div>

        </div>
      </div>
    </div>    
  </div>
  <script type="text/javascript">
    param=window.location.hash.substr(1);
    str="#"+param;
    $(str).attr("checked",true);
    offset=$(str).next().next().offset().top-200;
    $("html,body").animate({ scrollTop: offset}, 500);
  </script>
<?php
Widget::load('front',array('view'=>'footer'));
?>
<!-- footer end --> 
<!--   <script type="text/javascript" src="/resource/static/front/js/footer.js"></script> -->
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

  $(".default_template").find("h3").click(function(){
    if(!$(this).hasClass("selected"))
    {
      $(this).addClass("selected"); 
      $(this).nextUntil("h3").slideDown(500);
    }
    else
    { 
      $(this).removeClass("selected");
      $(this).nextUntil("h3").slideUp(500);   
    }
    return false;
    }); 
</script>
</html>