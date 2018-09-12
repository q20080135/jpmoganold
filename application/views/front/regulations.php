<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
  <title>法律法规</title>
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
    <div class="regulations_display">
      <div class="regulations_display_center">
      <p>JPMogan</p>
      <p>LAWS AND REGULATIONS</p>
      <p><span style="color:#fcb600">法律</span>法规</p>
      </div>
    </div>
    <div class="regulations_text">
      <div class="regulations_text_top">
        <p><i style="display:inline-block;width:50px;border-bottom:1px solid #b09373;position:relative;top:-5px;left:-30px"></i><b style="position:relative;top:-3px;left:-20px;display:inline-block;width:6px;height:6px;border-radius:3px;background-color:#bfbfbf"></b>
          <span>法律法规</span>
          <b style="position:relative;top:-3px;left:20px;display:inline-block;width:6px;height:6px;border-radius:3px;background-color:#bfbfbf"></b><i style="position:relative;top:-5px;left:30px;display:inline-block;width:50px;border-bottom:1px solid #b09373"></i>
        </p>
        <p style="color:#444;font-size:28px;font-weight:bold">LAWS AND REGULATIONS</p>
      </div>
      <i></i>
    </div>  
    <div class="regulations_main">
      <div class="regulations_main_top">
        <input type="radio" name="regulations" id="regulations1" checked>   
        <label for="regulations1">风险披露</label>
        <div class="regulations_main_bot">        
           
           <h3>1.高风险投资</h3> 
           <p>外汇和差价合约交易属于高风险保证金交易，仅适用于有能力承担损失风险的个人及机构投资者。阁下在做决定之前，应该谨慎考虑自身的投资目标、财务状况、经验等级、风险承受能力等状况。本网站仅为阁下提供参考，不做任何建议。阁下应熟稔与保证金交易有关的一切风险，并独立做出谨慎的投资决定。如果您有任何疑问，请咨询专业建议。</p> 
           <h3>2.保证金和杠杆</h3> 
           <p>JPMogan可提供杠杆率高达400:1的外汇交易账户，但高杠杆意味着高收益与高风险并存，小幅的价格浮动可能引起账户资产净值的较大波动，所以杠杆交易存在令您损失部分或全部初始入金的可能性。因此，应根据您的风险承受能力做相应投资。</p> 
           <h3>3.网络交易</h3> 
           <p>使用网络进行交易具有一定的风险，包括但不限于互联网系统故障、软件或硬件故障及其他不可抗力因素。由于JPMogan无法控制您的设备，所以特别申明在交易过程中如遇网络连接或网速问题无法进行平台登录或进行其他操作，JPMogan不对客户因自身网络问题产生的交易损失负责。同时，我们也会不断优化我们的网络环境及服务器，力求给您提供一个良好的交易环境。</p> 
           <h3>4.市场分析</h3> 
           <p>本网站向您发布的所有观点、新闻、分析、价格或其它信息仅为提供一般市场评论，均不构成任何投资建议，或劝诱、推荐您买入或卖出任何场外产品或其它金融工具。由于参考此类信息而可能直接或间接导致的结果，包括（但不限于）利润或损失，您不对JPMogan追究任何责任。</p> 
           <h3>5.网站使用</h3> 
           <p>JPMogan已采取合理的措施以确保网站上此类信息的正确性。网站信息内容可能会在任何时间、在不被通知的情况下产生变动。您可以合法使用网站，但不得未经授权使用、干扰、毁坏、扰乱、攻击网站任何部分。</p> 
           <h3>6.追加保证金</h3> 
           <p>您可能会接到电话临时通知需要大幅增加保证金来维持您的仓位。如果您没有在规定的时间里达到保证金的要求，您的仓位将会被强制平仓，您将自行承担由此产生的损失。</p> 
           <h3>7.关于代客操盘</h3> 
           <p>为保证客户权益，JPMogan己本人操作自己的交易账户，不得将自己的账户交于他人代为操作。如果客户执意将自己的交易账户用户名和密码交于他人交易，JPMogan将视同于客户本人所进行的交易。客户账户所产生的任何损失均由客户本人承担。JPMogan不会同任何代客理财机构合作，JPMogan的员工及代理均不得操作客户的账户，敬请客户知悉！</p> 
           <h3>8.EA跟单交易</h3> 
           <p>任何EA都具有不确定性，因此如果您选择EA跟单交易，请自行承担风险。JPMogan对您使用EA（Expert Advisors）自动交易程序保持中立，JPMogan不会为您推荐任何EA。同时，对于由EA交易导致的仓位问题，开启或关闭，无论何种情况，JPMogan不承担任何责任。</p> 
           <h3>9.交易滑点</h3> 
           <p><strong>1)什么是滑点?</strong><br /> 滑点是交易过程中,客户下单的点位和最后成交的点位有差距。</p> 
           <p><strong>2)产生的原因是什么?</strong></p> 
           <p>产生滑点原因有三种:<br /> a.当网络出现延迟时,客户发出指令也同样会出现延迟,那么其看到的开仓价格与成交价格就会出现差距<br /> 滑点是交易过程中,客户下单的点位和最后成交的点位有差距。<br /> b.由于我们采用无缝式对接（STP+ECN）交易模式，将客户的所有交易的指令直接发送到ECN，而ECN采用电子撮合交易模式，那么就必须保证交易双方的交易量是相互匹配的，如果出现不平衡，那么就会出现所谓的滑点情况。<br /> <strong>以下图为例:</strong>当客户在1.06852这个价格卖出1.1M时,那么就会按照1.06852这个价格成交,但客户如果在1.06852这个价格卖出3.7M时,那么就会把1.2M+1M+1.5M三个深度的价格进行加权平均进行结算,从而得出成交价格.(1.2*1.06852+1*1.06851+1.5*1.06849)/3.7=1.068505,由于MT4平台不提供深度查看,那么在这种情况下就会出现客户认为的滑点情况。</p> 
           <p style="text-align: center;"><img src="/resource/static/front/images/regulations1.png" alt="图片1" width="483" height="292" class="alignnone size-full wp-image-4651" sizes="(max-width: 483px) 100vw, 483px" /></p> 
           <p><strong>3)止盈止损出现滑点的原理</strong><br /> <strong>成交原理：</strong><br /> 止损止盈是指在报价达到或者超过设定价格后触发，在触发后的下一个可以成交的tick报价成交。所以客户设置的止损止盈不一定就是最终的平仓价格，成交价格由市场当时可成交价格来决定。</p> 
           <p>举例：<br /> 在黄金报价（1211.45/1211.75）时进多单（多单平仓看卖价），设定止盈1220.00，价格平稳上涨，假设卖价报价分别是1219.60、1219.80、1220.10、1219.50，则单子会在第一个超过止盈的价格1220.10被触发，在下一个Tick报价1219.5成交；假如价格在1220.10之后的下一个报价是1222则单子极有可能在1222.00附近成交。</p> 
           <p>滑点无法规避，也无法预测范围。因此，JPMogan概不对由市场跳空所造成的滑点承担任何责任，也不对在遭遇特殊行情时由滑点而导致账户强制平仓所带来的亏损承担任何责任。</p> 
           <h3><strong>10.价格跳空</strong></h3> 
           <p><strong>1)价格跳空通常会有两种情况：</strong><br /> a.一种是指上一个价格与下一个价格之间产生超乎寻常的间隔，出现价格空档，如左图中我们看到的“缺口”。<br /> b.在同一分钟内价格出现巨大的变化，如图，这种情况虽然看不到缺口，但是市场依然出现了跳空。</p> 
           <p><img src="/resource/static/front/images/regulations2.png" alt="图片2" width="554" height="376" class="alignnone size-full wp-image-4652" sizes="(max-width: 554px) 100vw, 554px" /><br /> 跳空同点差拉大一样，也容易发生在重大财经数据公布时或出人意料的新闻事件发生时，如非农、美国利率决议公布时，还有周末停盘以及周一开盘时等等。</p> 
           <p><strong>2)跳空对交易的影响是：</strong><br /> a.无论是止盈、止损、市场单还是其他进场型挂单，只要遇到行情跳空，其成交就会受到影响。平台会以跳空后的价格为客户成交订单。这个价格由于是市场中存在的真实价格，因此无法预知其与跳空前的价格距离。<br /> b.跳空会造成订单的滑点成交。<br /> c.跳空造成的滑点成交可能会造成客户在爆仓后净值为负值，在此情况下，JPMogan将会要求客户补充仓位负值。</p> 
           <p>所以，JPMogan有责任在此提醒客户，应在充分了解市场风险的情况下，根据自身的财政状况和交易经验进行审慎投资。而对于由市场跳空产生的滑点或爆仓，JPMogan不承担任何责任。</p> 
           <p>
            <del datetime="2017-06-30T03:47:41+00:00"></del></p> 
           <h3><strong>11.点差扩大</strong></h3> 
           <p>JPMogan作为ECN平台提供商，为客户提供浮动点差的交易，客户可以通过官网交易产品一栏查看点差浮动的基本状况。但是在某些特殊情况下，交易产品也会出现比平均值高出一些的点差情况，我们称之为点差扩大。点差扩大一般发生在特殊的新闻事件公布的时间节点，这时候外汇、贵金属等产品在行情出现价格跳空会有点差扩大的现象，而差价合约类产品CFDs在期货正常交易时间外也会出现点差扩大的现象。</p> 
           <p>那么点差为什么会扩大？</p> 
           <p>由于在开盘或发生风险事件时，很多银行以及交易机构为了风险管理停止了报价和交易，因此导致流动性报价源流量变小，在极少数银行报价的前提下JPMogan的点差便会随之扩大。</p> 
           <p>一般点差扩大的时间集中在：<br /> 1)周末停盘以及每日开盘的5分钟内；<br /> 2)重要数据或重大新闻发生。</p> 
           <p>点差扩大对交易可能产生的影响：<br /> 1)锁仓账户的爆仓；（如果客户可用保证金不足，点差扩大导致净值减少会导致保证金比例过低，当净值减少到保证金的100%比例的时候，系统会将客户的仓位进行强制平仓，在这个过程中容易伴随滑点的产生，导致客户爆仓后的资金减少）<br /> 2)针对锁仓单的止盈止损点位的成交不对称。（因为买入价和卖出价的巨大差价，导致买入价和卖出价的成交价亦发生巨大差异。）</p> 
           <p>因此，JPMogan在此提醒锁仓交易的客户，交易过程中预留充足保证金交易，以免净值低于保证金的100%导致爆仓。由于该现象为市场交易的常规现象，JPMogan强烈建议客户仔细阅读风险声明，了解真实市场状况后再选择交易，否则由客观市场在特殊情况下点差扩大所导致的滑点成交或爆仓，JPMogan不承担任何责任，更不给予任何赔偿。</p> 
           <h3><strong>12.部分成交</strong></h3> 
           <p>客户请求交易，是先从MT4端到Lp，再由LP将结果反馈至MT4，客户最终的成交是由LP反馈给MT4的结果决定。如果交易手数较大，由于LP的市场深度等原因，那么如果当时LP实际只有客户下单量的成交量，从而LP反馈给MT4的成交量是不足客户所下单的实际量的。受当时市场深度已满的影响，使得剩余的部分无法在其他报价层级成交，会造成客户最终开单手数与成交手数不一致的。</p> 
           <p>如客户在MT4请求开单25手AUDCHF，交易手数较大，由于LP的市场深度等原因，LP实际只有20手的成交量，从而LP反馈给MT4的成交量是20手。受当时市场深度已满的影响，使得剩余的部分无法在其他报价层级成交，造成客户最终开单只有20手。<br /> 客户请求交易，是先从MT4端到Lp，再由LP将结果反馈至MT4，客户最终的成交是由LP反馈给MT4的结果决定。</p> 
           <h3><strong>13. 无法平仓</strong></h3> 
           <p>无法平仓出现在流通性较低的时间段，如每日开盘或亚市早盘期间，大量做同一方向交易。这种同时大量同方向的交易行为会对订单成交产生不利影响，受市场深度影响，在平仓的时候被市场拒绝。<br /> 提醒客户注意市场风险，降低仓量。<br /> 另外原油、白银、稀有外汇货币对这类流通性较低的交易品种，报价可能会有非连续性的情况，受市场深度影响，在平仓的时候被市场拒绝。</p> 
           <h3><strong>14. 市场行情影响因素</strong></h3> 
           <p>第一：经济因素<br /> 各国央行利率政策、非农数据、各国央行主要负责人相关新闻发布会以及其他经济数据（工业生产、个人收入、国民生产总值、开工率、库存率、美国经济综合指标的先行指数、新住房开工率、汽车销售数等）</p> 
           <p>第二：政治因素<br /> 地缘政治，宗教冲突、各国领导大选以及公投等等</p> 
           <p>第三：政府对外汇市场的直接干预<br /> 国家债券QE发行、各国领导人经济政策的发言等干预政策</p> 
           <p>第四：供求关系<br /> EIA原油库存数据，各种库存变化等等</p> 
           <p>第五：突发事件<br /> 战争、军事动态、胖手指，黑天鹅，恐怖袭击等等情形属于市场行为。</p> 
        

        </div>
      </div>
      <div class="regulations_main_top">
        <input type="radio" name="regulations" id="regulations2">   
        <label for="regulations2">隐私政策</label>
        <div class="regulations_main_bot">  
         
            <h3>隐私政策</h3>
            <p>JPMogan尊崇客户至上的服务理念，对于客户隐私的维护和保密工作十分重视，这也是JPMogan运营的核心职责。因此，JPMogan出台特定政策来保障您的私人信息，同时也向客户说明JPMogan如何收集个人资料，以及如何披露、使用、保障这些资料。因此，您在接受JPMogan的服务前，请仔细阅读下列隐私政策条款。</p>
            <h3>收集信息</h3>
            <p>JPMogan为了向您提供专属的服务，将会从这些渠道收集您的个人非公开信息，包括：</p>
            <ul>
              <li>您在账户申请（真实账户或模拟账户）过程中自愿提供的能够识别您个人身份的有效信息（例如，您的姓名、电子邮件地址、电话号码、出生日期、身份证号、护照信息、驾照信息、过往投资经验、投资目标等）；</li>
              <li>您通过JPMogan系统进行交易时获取的信息。JPMogan保留了客户账户的所有交易及活动纪录，包括(但不限于)客户账户的平仓资料。</li>
              <li>JPMogan也会从公共资源收集客户信息，例如公司登记册，收集客户资料。JPMogan将会严格地根据1988年私隐法的澳大利亚私隐原则及2012年私隐修订(增加私隐保护)法持有客户的个人资料。</li>
              <li>当个人资料是由第三方处（非客户本人）收集时，JPMogan将会采取合规步骤去确保客户已知悉该资料的收集情况，且已阅读本隐私政策中的相关条款。</li>
              <li>为了防止JPMogan与客户之间的纠纷，会将客户与JPMogan职员之间的电话对话进行录音。该录音源文件或拷贝文件可用以解决客户与JPMogan之间的任何纠纷，并符合JPMogan的法定义务，包括监管机构及其他政府组织的要求。</li>
              <li>JPMogan一般不会采集敏感信息，除非出现以下例外情况：此收集是由澳大利亚法律或法院/审裁处命令授权或要求；出现可疑的非法活动或重大不当行为，或可能威胁到JPMogan运作的行为；如果不收集就无法使JPMogan为您履行服务和满足您需求。</li>
            </ul>
            <h3></h3>
            <h3>个人信息的使用或披露</h3>
            <p>JPMogan充分采取合理的措施来保证您的个人信息的安全性。除非法律法规要求，否则我们不会将个人、非公开信息披露给第三方。JPMogan使用和披露个人信息的主要目的在于采集,以及经个人合法授权下的其他情形。例如，在这些情形下我们可能披露或报告这类信息：</p>
            <ul>
              <li>只要符合相关证券法律法规，出于分析、研究、市场数据编辑、产品创建、定单传递和执行关系的建立或任何其他法律方面的目的，我们会将您的个人信息透露给被我们授权的第三方或我们认为可以建立合同关系的第三方，或关联或联署公司，代理人或其他授权机构或者和执行您的服务的直接或间接的指导者。这种情况下，除非是提供明确的目的，否则我们将禁止第三方使用个人信息。我们禁止他人为产品或服务直接市场推广目的使用您的信息。我们也保证所描述的所有的人在此坚持现行政策的条款并执行合理的措施来保护您的隐私。</li>
              <li>关于或有关遵守任何法律、规例、法令或监管机构的命令的任何用途，包括按照法律或规例要求向任何该等监管机构提供任何该等资料，与执法机关或监管或自监管组织合作。</li>
              <li>向客户推广JPMogan产品及服务；客户已同意的任何其他目的；了解客户可能有兴趣从JPMogan得到什么产品及服务；在有必要授权、完成、监管或执行您所要求或授权的交易的时候；维护及监管您的账户；向您提供账户确认、账单和记录；维持正确的档案记录；执行我们的客户协议及其它协议；满足我们的责任，或保护我们的权利及财产。</li>
            </ul>
            <h3></h3>
            <h3>个人信息保密</h3>
            <ul>
              <li>JPMogan会第一时间让所有新员工及第三方阅读并帮助他们培训本隐私政策，确保JPMogan员工及第三方必须理解及如何处理客户的个人隐私信息。如果员工及相关第三方忽视JPMogan隐私政策，出现违反或不遵守隐私政策的行为，将会受到纪律处分。</li>
              <li>JPMogan将采取所有合理步骤以免客户的个人资料遭到不当使用、遗失、未经授权使用、干扰、更改或披露。</li>
              <li>除非澳大利亚法律或法院/审裁处或其他海外监管及政府机构(即使其不包含在联邦范围)要求继续持有资料，一旦JPMogan不再需要客户的资料，我们也会采取合理步骤删除、销毁我们不再需要的个人的所有信息或除去个人资料识别。</li>
              <li>另外，我们基于互联网的系统加固了诸如加密和防火墙之类的安全措施。</li>
            </ul>
            <h3></h3>
            <h3>客户权利</h3>
            <ul>
              <li>您有权要求我们揭示我们持有一切关于您的个人资料的权利。您可以在任何时间要求查阅JPMogan所持有的关于您的资料，改变任何不准确或不一致的数据，了解您个人资料使用的权利和阻止你的隐私被侵犯的权利。您可以通过我们的网站<a href=""></a>&nbsp;或发送邮件至我们的客服 <a href="" rel="nofollow"></a> 来修改您的个人资料，或者立即联系我们。</li>
              <li>您无需提供我们任何违背自己的意愿的个人资料；然而，这可能导致我们暂时无法为您提供服务。因为您的所有私人信息是否准确，完整和最新更新对我们十分重要，直接影响着我们为您提供完整的服务。</li>
              <li>如果客户需要向JPMogan申请索取个人信息，且要求是复杂的，在这种情况下JPMogan将会告知客户需要额外的时间。</li>
              <li>如果JPMogan有理由怀疑严重的非法活动或不当行为正在或可能被从事，并涉及到JPMogan的职能或运作，那么JPMogan可能会拒绝客户索取个人信息，并向客户提供拒绝的原因(除非向客户提供原因被视为不合适或不合理)、其他监管事项，并提供现有的投诉机制。</li>
              <li>如果您对我们的隐私政策有任何疑问，或您发现们员工或与我们建立合同的第三方有任何违反隐私政策的行为，或者您希望就我们如何处理您的个人信息提出投诉，您可以发送邮件至：<a href="" rel="nofollow"></a> 提出投诉。</li>
            </ul>    
        </div>
      </div>
      <div class="regulations_main_top">
        <input type="radio" name="regulations" id="regulations3">   
        <label for="regulations3">法律文件</label>
        <div class="regulations_main_bot">
           
          <dl> 
             <dt><img src="/resource/static/front/images/regulations3.png">JPMogan相关法律文件下载</dt>
             <dd>    
              <span><img src="/resource/static/front/images/cfd_content_2.png">Financial_service_guide</span> 
              <a href="/resource/static/front/file/Financial_service_guide.docx" download="" target="_blank">点击下载</a> 
             </dd> 
            </dl>
      
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