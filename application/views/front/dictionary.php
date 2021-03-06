<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no,minimum-scale=1.0,maximum-scale=1.0" />
<meta http-equiv="Cache-Control" content="no-cache"/>
  <title>词典</title>
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
  
    <!-- <div id="drag" style="position:absolute;right:260px;top:720px;width:70px;height:70px;border-radius:30px;cursor:move;background:url(/resource/static/front/images/kefu.png) no-repeat center;">
       <div id="question" style="width:40px;height:100px;cursor:pointer;background-color:#2bb4e8;position:relative;left:12px;top:60px;display:none;">
         <a href="" style="width:100%;padding-left:12px;padding-top:12px;text-decoration:none;display:block;position:relative;color:#fff;font-size:16px;font-weight:bold;word-wrap:break-word;letter-spacing:10px;">提出问题</a>
       </div>
    </div> -->
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
    <div class="dictionary_display">
      <div class="dictionary_display_center">
      <p>JPMogan</p>
      <p>THE DICTIONARY</p>
      <p><span style="color:#fcb600">FX</span>词典</p>
      </div>
    </div>
    <div class="dictionary_text">
      <div class="dictionary_text_top">
        <p><i style="display:inline-block;width:50px;border-bottom:1px solid #b09373;position:relative;top:-5px;left:-30px"></i><b style="position:relative;top:-3px;left:-20px;display:inline-block;width:6px;height:6px;border-radius:3px;background-color:#bfbfbf"></b>
          <span>FX词典</span>
          <b style="position:relative;top:-3px;left:20px;display:inline-block;width:6px;height:6px;border-radius:3px;background-color:#bfbfbf"></b><i style="position:relative;top:-5px;left:30px;display:inline-block;width:50px;border-bottom:1px solid #b09373"></i>
        </p>
        <p style="color:#444;font-size:28px;font-weight:bold">FOREIGN EXCHANGE DICTIONARY</p>
      </div>
      <i></i>
    </div>  
    <div class="dictionary_main">
      <div class="dictionary_main_top">
        <input type="radio" name="dictionary" id="dictionary1">   
        <label for="dictionary1">常用术语</label>
        <div class="dictionary_main_bot">      
          <div class="company_overview_content"> 
            <div class="company_overview_content_title">
              常用术语
            </div>
            <h3>1、点Pip<i></i></h3> 
            <p>汇率变动的最小单位就是点。如果欧元/美元的汇率由1.2250上升到1.2251,则其变动恰好是1个点。FX报价的最后一位就是点数的个位，倒数第二位就是点数的十位，依此类推。</p> 
            <h3>2、点差Spreads<i></i></h3> 
            <p>点差是买入价（Bid）与卖出价（Ask）之间的差价。买入价和卖出价的价差越小，对于投资者来说意味着成本越小。长期交易下来，点差的大小对短线投资者的整体盈亏情况影响较大，而对中长线投资者几乎没有影响。以欧元/美元为例：买入价（Bid）是1.4390，卖出价（Ask）是1.4393，买卖价之间有3点的点差。如果这时你要买入EUR，将在1.4393成交，盈亏将显示 3点，即-30美元（3*$10=$30）的亏损值。这30美元的亏损可以看成建仓的成本。点差实际上就是我们交易的成本。</p> 
            <h3>3、点值Pip Value<i></i></h3> 
            <p>点值就是在进行FX交易的时候，买入价和卖出价之间一个点的价值。详情请参考FX计算。</p> 
            <h3>4、保证金/杠杆Margin<i></i></h3> 
            <p>保证金是指买方或卖方按照交易市场规定标准交纳的资金，专门用于订单交易的结算和履约保证。 已用保证金=手数*合约单位/杠杆 黄金白银的已用保证金=手数*合约单位*市场价格/杠杆.CFD差价合约的保证金是固定的. 可用保证金=净值-已用保证金-点差</p> 
            <h3>5、追加保证金Variation Margin<i></i></h3> 
            <p>追加保证金是指清算所规定的，在会员保证金帐户金额短少时，为使保证金金额维持在初始保证金水平，而要求会员增加交纳的保证金。当日权益减去持仓保证金就是资金余额。如果当日权益小于持仓保证金，则意味着资金余额是负数，同时也意味着保证金不足了。</p> 
            <h3>6、合约数Contract Size<i></i></h3> 
            <p>FX中的合约数也叫合约单位，就是交易量本身，是买/卖货币的量。比如：FX中，10万的合约单位为1标准手，也叫100K（K=kilogram），也就是指每笔单的最小交易份额是100000个基准货币。</p> 
            <h3>7、STP<i></i></h3> 
            <p>STP,全称 Straight though processing, 直通式处理， 是一种桥接方式，没有交易员后台（交易员后台，英文为dealing desk ,常被翻译为“交易员平台”）在其中报价和控制市场价格(即没有做市)，所有客户的订单直接传至流动性提供商（或称流动性提供商，即其他经纪商与银行），买入/卖出价由那些流动性提供商决定。无交易员后台的STP平台把所有订单信息直接桥接至流动性提供商，流动性提供商用与客户相反的头寸进行交易，同时，通过之后与另一方的交易中对此头寸进行平仓，以期获得利润。<br>
            STPFX平台的三个关键元素<br>
            1) 流动性提供<br /> ECN交易平台将订单传至的ECN流动资金池， 其中有大量在银行间交易的流动性提供商。<br /> STP平台有自已的内部流动资金池，这个资金池由预定的一些流动性提供商构成，只有那些与STP经纪商签过约的流动性提供商才会在里面。这些流动性提供商为来自STP 交易平台的订单提供最好的买入/卖出价格。流动性越好，买入/卖出价会更优惠，点差会越低。如果只有一个流动性提供商，那么流动性提供商之间就没有价格竞争了，这就等于只是加了一个中间人在里面进行交易。<br> 
            2) 点差类型 <br /> 固定点差的STPFX平台：不以多个流动性提供商中的最低买入买出价为依据调整点差大小，点差始终是固定。如果该STP经纪商只有一个流动性提供商，这个流动性提供商的角色就是交易者唯一的反方，这种情况下买入/卖出价全由这个流动性提供商决定。<br /> 浮动点差的STPFX平台：流动性提供商提供最好的买入/卖出价，STP经纪商会从一个流动性提供商中选了一个最好的买入价， 从另一个流通者那选择一个最的买出价，这样就可以为客户提供最低的买卖点差。<br> 
            3) 即时执行还是市价执行<br /> 即时执行指的是订单不会直接进入市场，会被经纪商先处理。<br /> 市价执行提的是订单信息被发送至市场 ， 价格由有市场上的流动性提供商决定。<br /> 提供市价执行的STP经纪商，为客户提供直接市场准入 DMA (Direct Market Access)</p> 
            <h3>8、ECN<i></i></h3> 
            <p>ECN即电子通讯网络（Electronic Communication Network，简称ECN）,使指ECN用户的订单都直接匿名挂在这个网络上，买卖价格均由参与这个ECN环境中的所有交易，包括个人投资者、小型银行、投资机构、对冲基金等，按照价格和时间的最优化公平撮合成交。<br> 
            从广义上讲，ECN模式是包括STP桥接的，ECN的最大优点就是公平，真正的ECN模式，只负责传递客户的订单，赚取手续费，而客户订单则在这个ECN流动性池中与其他对手方进行交易，对手方可能是对冲基金、银行机构或非银行机构，或其他投资者等不一而足。并且，由于ECN汇集了大体量的流动性，所以这些流动性提供方之间为了能够获得更多的订单成交机会，相互间会产生竞价，从而使客户能够享受更低的交易成本也就是点差，并且以最快的速度即时成交。但ECN账户门槛较高，对账户起始规模、交易手数、交易量有一定的要求，适合机构投资者和大资金账户等使用。</p> 
            <h3>9、EA<i></i></h3> 
            <p>智能交易是Expert Advisor(简称EA)的中文译名，也可译作“专家顾问”，俗称智能交易系统，是由电脑模拟交易员的下单操作进行机器交易的过程；电脑根据预先编辑好的交易策略程序来执行交易定单。自动交易策略主要包括三要素：定单执行，风险管理和资金管理。</p> 
            <p>智能交易系统是运行于特定交易平台的国际金融货币交易系统，其原理就是将有效的国际金融货币交易策略用特殊的编程语言（MQL/Java/C++）编写成一个电脑程序,让电脑按照事先设定好的条件自动地执行持仓和买卖，赢亏结果取决于该交易系统的策略质量。</p> 
            <p>完整的交易逻辑包括：1，入场条件判断；2，持仓条件判断；3，仓位控制；4，出场条件判断。交易者可以将自己的交易策略编写成EA，对各种指标的调用、价格循环、历史数据对比等等皆可以在EA中通过编程的方法得以实现。计算机的运算速度远比人脑快，所以它可以在一些转瞬即逝的入场机会中迅速的进行交易，大大提高了交易行为的质量。</p> 
            <p>智能交易系统的好坏直接取决于交易者所制定的交易策略，一个良好的交易策略可以实现稳定的盈利，即使发生亏损也会在极小的范围内得到控制，而差的交易策略则可能会导致交易账户在极短的时间内就发生巨量亏损甚至爆仓。目前市面上流通的EA有全自动和半自动两种，全自动的EA会完全自主的执行交易策略，而半自动的则需要人工辅助其下单或者平仓。<br /> 传统EA分为：网格型、趋势型、对冲型、套利型</p> 
            <h3>10、做市商（MM/Markets Maker）<i></i></h3> 
            <p>指金融市场上的一些独立的证券交易商，为投资者承担某一只证券的买进和卖出，买卖双方不需等待交易对手出现，只要有做市商出面承担交易对手方即可达成交易。做市商通过这种不断买卖来维持市场的流动性，满足公众投资者的投资需求。做市商通过买卖报价的适当差额来补偿所提供服务的成本费用，并实现一定的利润。</p> 
            <p>本质上看，做市商的出现源于买卖供需的不平衡。在缺乏流动性的市场里，由于买方和卖方不见得会同时出现或交易同样数量的产品，这种时空差异导致了交易无法实现。做市商的出现，使得不同时间到达的买卖需求具备了成交的可能。</p> 
            <p><strong>其特点是：</strong></p> 
            <p>1) 盈利模式上，通过控制买卖价差进行盈利，没有明显的投机意图；<br /> 2) 交易方式上，做市商需要向市场提供双边的报价，而且事先并不知道对手的买卖方向，是市场的被动交易，在一定程度上具有平抑市场价格波动的作用；<br /> 3) 风险管理，由于交投清淡，做市商主要采取对冲的方式来管理存货风险；<br /> 4) 做市义务，如果客户询价的时候需要给出报价，报出的买卖价差必须在一定范围内，而且最小的买卖量要符合规定；<br /> 5) 流动性提供，当市场流动性缺乏或价格波动剧烈的时候，做市商通过提供报价促使成交实现。</p> 
            <p>根据和竞价制度的共存模式，做市商制度可分为纯粹做市商制度和混合型做市商制度。所谓纯粹做市商制度，指某一产品的交易完全通过做市商来完成。所谓混合型做市商制度，指某一产品的交易既可能通过竞价交易完成，也可能通过做市商来完成，属于竞价和做市商共存的模式。</p> 
            <p>但MM模式的做市商通常会将客户进行分类，导致客户面临滑点，订单难以成交，重复报价等多重障碍，而且做市商与客户进行对赌交易，通常胜算很大，而透明性则取决于做市商本身。</p> 
            <h3>11、买入价bid/卖出价ask<i></i></h3> 
            <p>买入价是FX市场上愿意买人某个特定货币对的价格。交易人可以以这个价格卖出基本货币，它在报价单的左边。比如，美元／瑞士法郎报价是1．4527／32，其买入价是1．4527；也就是说，你可以把1美元卖1．4527瑞士法郎。<br /> 卖出价是FX市场上愿意卖出某个特定货币对的价格。交易人可以以这个价格买入基本货币，它在报价单的右边。比如，美元／瑞士法郎报价是1．4527／32，其卖出价是1．4532；就是说，你可以以1．4532瑞士法郎买人1美元。FX卖出价又叫卖出汇率。</p> 
            <h3>12、价差Spread<i></i></h3> 
            <p>价差是买入价和卖出价间的差额。</p> 
            <h3>13、报价方式Quotation<i></i></h3> 
            <p>FX市场中的汇率用以下格式来表示：<br /> 基本货币／报价货币 买入价／卖出价<br /> 如： 欧元/美元1．2604／07， 英镑／美元1．5089／94 ，瑞士法郎／日元84．40／45<br /> 正常情况下，只显示最后的两个数字。如果卖出价超过买入价100点，那么斜线的右边就会有三个数字(如欧元／捷克克郎32．5420／780)。只有当报价货币非常疲软时才会出现这种情况。</p> 
            <h3>14、流动性Liquidity<i></i></h3> 
            <p>流动性实际上就是投资者根据市场的基本供给和需求状况，以合理的价格迅速交易一定数量资产的能力。简单地说，流动性就是迅速执行一定数量交易的成本。市场的流动性越高，则进行即时交易的成本就越低。一般而言，较低的交易成本就意味着较高的流动性，或相应的较好的价格。如何衡量流动性？<br /> 市场深度：深度指标主要是指报价深度，即在某个特定价位（通常是最佳买卖报价）上的订单数量。<br /> 成交深度：即交易规模，这是一个事后的指标，衡量在最佳买卖价位上成交的数量。<br /> 深度改进：是指当订单的数量超过最佳买卖报价上的数量时，该订单以等于或优于报价的价格成交的情况。<br /> 成交率：指提交的订单中在该市场实际得到执行的比率。成交率包括三个指标：一是市价订单和优于最佳买卖报价的限价订单整个即时成交的概率；二是订单按照单一价格全部成交的比率；三是订单部分执行时成交量占订单量的比率。对劣于最佳买卖报价的限价订单而言，成交率也是一个非常重要的指标。</p> 
            <h3>15、隔夜利息Swap<i></i></h3> 
            <p>FX交易中，每笔交易均涉及两种货币，当中包含两个不同的利率，而利息的支付或收取都是以两者的利息差和持仓方向而定。利率是按照两国货币利率差额作为计算依据，当投资者卖出息率较高/买入息率较低的货币，便需要支付隔夜利息；当投资者买入息率较高/卖出息率较低的货币，则可以赚取隔夜利息。利息根据银行惯例按照T+2延迟清算，即两个银行工作日后开始计算。参见FX计算<br /> 隔夜利息=年利率差/360天*1标手合约单位*手数*汇率价格（多/空）*计息天数</p> 
            <h3>16、清算Clearing<i></i></h3> 
            <p>把风险抛出给市场或者流动性提供商（银行机构）</p> 
            <h3>17、剥头皮Scalp<i></i></h3> 
            <p>剥头皮交易是指一种快进快出的超短线交易方法,是指交易投资者在非常短的时间内频繁的进行下单平仓等操作。非常简单的快进快出超短线交易。这种要求投资者对市场的走势、支撑阻力位做出一定的准确判断，然后利用高杠杆的利率来盈利，是一种大部分靠概率盈利的模式。</p> 
            <h3>18、PAMM（Percentage Allocation Management Module）<i></i></h3> 
            <p>PAMM管理模式是百分比分配管理模式( Percentage Allocation Management Module) 的缩写，是指一种代客理财账户，投资者和帐户基金经理按照约定比例分配利润。投资者可以利用PAMM帐户经理的智慧和丰富交易经验，将钱投入PAMM帐户，由帐户经理用集中的管理接口代其交易。帐户经理从交易收益中抽取一部分收益做为管理薪酬。</p> 
            <h3>19、MAM（Multiple Account Management）<i></i></h3> 
            <p>MAM是一种多账户管理软件，可以帮助专业的交易人员实现多个账户的统筹化管理，MAM账户可以添加无限数量的交易账户，而且分配模式可以按百分比也可以按资产比例分配。MAM账户订单可以批量成交，瞬时分配多个管理账户，也可以全部成交订单，专为资金管理人而设置。</p> 
            <h3>20、LAMM（Lot Allocation Management Module）<i></i></h3> 
            <p>LAMM管理模式是批组分配管理模式(Lot Allocation Management Module)的缩写，是指资金经理有能力单独交易不同客户账户，并透过单一界面对其进行管理，从而使资金经理得以交易、监管多个账户，并列印多个账户的报告，而无需分别登录每一个客户账户。由于资金经理对每一个客户的账户进行单独管理, 因此不同顾客的保证金、损益和滚存费会有差异。LAMM是一个总的管理账户，客户必须签署《有限授权委托书》，委托操盘手用LAMM账户来管理自己的交易账户，而客户的账户会被放在LAMM之下。LAMM账户每次下单之前都可以选择针对名下的那些账户进行操作，并且设定操作量。LAMM名下的账户是只读账户，客户不可以自行交易。客户可以填写《撤销有限授权委托书》，将自己的账户从LAMM中撤离，此后客户可以交易自己的账户。</p> 
            <div class="clear"></div> 
          </div>
        </div>
      </div>
      <div class="dictionary_main_top">
        <input type="radio" name="dictionary" id="dictionary2" >   
        <label for="dictionary2">专业术语</label>
        <div class="dictionary_main_bot">  
           
            <div class="company_overview_content">
                   <div class="company_overview_content_title">
                    专业术语
                   </div>
                    <h3>1、头寸Position<i></i></h3>
                    <p>头寸是一种市场约定，承诺买卖合约的最初部位，买进合约者是多头，处于盼涨部位；卖出合约为空头，处于盼跌部位。</p>
                    <h3>2、卖出/空头/做空Short<i></i></h3>
                    <p>交易预期未来FX市场的价格将下跌， 即按目前市场价格卖出一定数量的货币或期权合约，等价格下跌后再补进以了结。</p>
                    <h3>3、买入/多头/做多Long<i></i></h3>
                    <p>交易者预期未来FX市场价格将上涨， 以目前的价格买进一定数量的货币，待一段时间汇率上涨后，以较高价格对冲所 持合约部位，从而赚取利润。这种方式属于先买后卖的交易方式。</p>
                    <h3>4、平价/持平At Par<i></i></h3>
                    <p>既非多头，也非空头，即称为平价或持平。如果投资人没有部位，或是所有的部位相互抵消，即称为持平。</p>
                    <h3>5、开仓仓位Open Position<i></i></h3>
                    <p>任何尚未以实质款项付清或以等值的同等或相反交易结算的交易。</p>
                    <h3>6、平仓Closed Position<i></i></h3>
                    <p>通过卖出(买进)相同的货币来了结先前 所买进(卖出)的货币头寸。</p>
                    <h3>7、对冲Hedge<i></i></h3>
                    <p>对冲交易，是一种理念。作为一种交易方式，它遵循“市场中性”原则，它是把一个具体的头寸视为金融向量，向量的方向为敞口，对冲交易就是通过不同方向的金融工具来做敞口的管理，通常是通过配对头寸来拟合敞口（套利）来实现风险敞口管理下的绝对收益。以寻找市场或商品间效率落差而形成的套利空间为主，通过两个或两个以上的交易，利用对冲机制规避风险，使市场风险最小化,。简单地解释就是盈亏相抵的交易,即同时进行两笔行情相关、方向相反、数量相当、盈亏相抵的交易。</p>
                    <h3>8、止损Stop Loss<i></i></h3>
                    <p>止损是指当某一投资出现的亏损达到预定数额时，及时斩仓出局，以避免形成更大的亏损。其目的就在于投资失误时把损失限定在较小的范围内。</p>
                    <h3>9、止盈Stop Profit<i></i></h3>
                    <p>止盈是指当股价涨幅百分之几或涨到某个价位时，就减仓。运用这种方式可以把利润控制到一定的高度，实现自身利益最大化。</p>
                    <h3>10、区间Interval<i></i></h3>
                    <p>货币在一段时间内上下波动的幅度。</p>
                    <h3>11、区间震荡Detrended Price Oscillator<i></i></h3>
                    <p>货币在某一区间内来回、上下波动。</p>
                    <h3>12、上档/下档Shift Up/Shift Down<i></i></h3>
                    <p>价位目标，价位上方称为阻力位，价位下方称为支撑位。</p>
                    <h3>13、底部Bottom<i></i></h3>
                    <p>下档重要的支撑位。</p>
                    <h3>14、长期/中期/短期Long Run/Medium Run/Short Run<i></i></h3>
                    <p>长期：一个月～半年以上(200点以上)；中期：一星期—一个月(100点～200点)；短期：一天—一星期(30～50点)。</p>
                    <h3>15、牛市/熊市Bull Market/Bear Market<i></i></h3>
                    <p>牛市为长期单向市场向上；熊市为长期单向市场向下。</p>
                    <h3>16、牛皮市ChoppyMarket<i></i></h3>
                    <p>价格上升或者下降的幅度很小，价格变化不大，市价像被钉住了似的，如牛皮之坚韧。在牛皮市上往往成交量也很小，牛皮市是一种买卖双方在力量均衡时的价格行市表现。</p>
                    <h3>17、交投清淡/活跃Thin Market/Active Market<i></i></h3>
                    <p>清淡是指交易量小，波幅不大; 活跃则交易量大，波幅很大。</p>
                    <h3>18、上扬/下挫 Up/Down<i></i></h3>
                    <p>货币价值因消息或其他因素有明显方向性的发展。</p>
                    <h3>19、胶着Deadlock<i></i></h3>
                    <p>盘势不明，区间窄小。</p>
                    <h3>20、盘整Correction<i></i></h3>
                    <p>经过一段急速的上涨或下跌后，遇到阻力或支撑，开始小幅度地上下变动，其幅度大约在15%左右。</p>
                    <h3>21、回档/反弹Make Correction<i></i></h3>
                    <p>在价位波动的大趋势中，中间出现的反向行情。</p>
                    <h3>22、打底/筑底Bottoming</h3>
                    <p>当价位下跌到某一地点，一段时间波动不大，区间缩小 (如箱型整理)。</p>
                    <h3>23、破位BreakPosition<i></i></h3>
                    <p>突破支撑或阻力位(一般需突破20—30点以上)。</p>
                    <h3>24、假突破False Breakout<i></i></h3>
                    <p>突然突破支撑或阻力位，但立刻回头。</p>
                    <h3>25、阻力线Uper<i></i></h3>
                    <p>预期可以进行卖出的价位。</p>
                    <h3>26、上探/下探Roll-up/Drill-down<i></i></h3>
                    <p>测试价位。</p>
                    <h3>27、恐慌性抛售Panic Selling<i></i></h3>
                    <p>听到某种消息就卖出平仓，不管价位好坏。</p>
                    <h3>28、多头回补/空头回补Long Covering/Short Covering<i></i></h3>
                    <p>市场是空头市场，后改走多头市（揸入市或揸平仓）; 原本是多头市场，因消息或数据而走（卖出）沽市（沽入市或沽平仓） 市或沽平仓)。</p>
                    <h3>29、单日转向One-day Reversal<i></i></h3>
                    <p>本来走空（多）/沽(揸)市，但下午又往多（空）/揸(沽)市走，且超过开盘价</p>
                    <h3>30、卖压/买气Selling Pressure/Buy Gas<i></i></h3>
                    <p>逢高点的卖单；逢低价的买单。</p>
                    <h3>31、止蚀买盘Stop Buying<i></i></h3>
                    <p>作空头方向于FX市场卖完后，汇率不跌反涨，逼得空头 不得不强补买回。</p>
                    <h3>32、锁单Lock Position<i></i></h3>
                    <p>是保证金操作的手法之一，就是买卖手数相同，但不平仓。</p>
                    <h3>33、漂单<i></i></h3>
                    <p>漂单是指单子处于亏损状态，不及时止损或平仓，任由漂着，抱着侥幸心理等待市场回头。这是第一大帐户杀手，比重仓还厉害的杀手。</p>
                    <h3>34、长效单Good-Till-Cancelled Order<i></i></h3>
                    <p>由交易员保留委托单，在某个固定价格买进或卖出。 委托单被客户取消之前始终有效。</p>
                    <h3>35、限价单Limit Order<i></i></h3>
                    <p>按照限价或低于限价买入，或按照限价或高于限价卖出。</p>
                    <h3>36、即期At Sight(On Demand)<i></i></h3>
                    <p>某项交易即刻成交，但资金通常在成交之后两天内完成。</p>
                    <h3>37、续期Renewal<i></i></h3>
                    <p>根据两种货币的汇差，一项交易的结算展期到另一个起息。</p>
                    <div class="clear"></div>
                </div>

        </div>
      </div>
      <div class="dictionary_main_top">
        <input type="radio" name="dictionary" id="dictionary3" >   
        <label for="dictionary3">基本面术语</label>
        <div class="dictionary_main_bot">
           
          <div class="company_overview_content"> 
            <div class="company_overview_content_title">
              基本面术语
            </div>
            <h3>1、货币对 Currency Pair<i></i></h3> 
            <p>货币是一个国家定制的货币，。最常交易的八种货币(美元USD、欧元EUR、日元JPY、英镑GBP、瑞士法郎CHF、加拿大元CAD、澳大利亚元AUD、新西兰元NZD)叫做主要货币，其他所有的货币都被称作次要货币。货币对是两个货币交叉产生的汇率报价，例EUR/USD（欧元/美元）。</p> 
            <h3>2、直盘 Direct Trade<i></i></h3> 
            <p>指在国际FX市场上，一个国家的货币直接跟美元进行兑换的就是直盘，简单的这样理解：凡是和美元直接联系的都是直盘，例：EUR/USD（欧元/美元）， USD/CAD（美元/加元）等。</p> 
            <h3>3、交叉货币对/交叉盘 Cross Pair/Cross Trade<i></i></h3> 
            <p>没有美元作单位的交叉货币汇率报价，也就是不和美元挂钩，如EUR/GBP（欧元/英镑）， GBP/JPY（英镑/日元）。</p> 
            <h3>4、汇率Exchange Rate<i></i></h3> 
            <p>货币FX汇率（FXRate， Foreign Exchange Rate）是以另一国货币来表示本国货币的价格，如USD/CHF汇率为1.0022，那么意味着1美元等于1.0022瑞郎。</p> 
            <h3>5、大数Big Figure Quote<i></i></h3> 
            <p>指汇率的头几位数字。这些数字在正常的市场波动中很少发生变化，因此通常在交易员的报价中被省略，特别是在市场活动频繁的时候。比如，美元/日元汇率是 107.30/107.35，但是在被口头报价时没有前三位数字，只报”30/35″。</p> 
            <h3>6、固定汇率Fixed Exchange Rate<i></i></h3> 
            <p>固定汇率是以货币的含金量为基础，形成汇率之间的固定比值。这种制定下的汇率或是由黄金的输入输出予以调节，或是在货币当局调控之下，在法定幅度内进行波动，因而具有相对稳定性。它是基本固定的，汇率的波动幅度限制在一个规定的范围内的汇率。</p> 
            <h3>7、浮动汇率Floating Exchange Rate<i></i></h3> 
            <p>浮动汇率制（floating exchange rates）是指一国货币的汇率根据市场货币供求变化，任其自由涨落，各国政府和中央银行原则上不加限制，也不承担义务来维持汇率的稳定，这样的汇率就是浮动汇率制。其正式普遍实行，是20世纪70年代后期美元危机进一步激化后开始的。</p> 
            <h3>8、交叉汇率Cross Rate<i></i></h3> 
            <p>是指制定出基本汇率后，本币对其他外国货币的汇率就可以通过基本汇率加以套算，这样得出的汇率就是交叉汇率，又叫做套算汇率（也叫交叉盘）。FX交易中常常会涉及两种非美元货币的交易，而国际金融市场的报价多数是美元对另一种货币的报价，此时，需要进行汇率套算。</p> 
            <h3>9、同业买卖汇率Inter-Bank Rate<i></i></h3> 
            <p>又称银行间汇率，是指银行间进行FX买卖时的汇率。它高于买入汇率，低于卖出汇率，一般为介于两者之间的中间价。FX银行对银行间汇率另加一定的差额后决定对顾客汇率。银行汇率是批发价，对顾客汇率是零售价。</p> 
            <h3>10、基准货币/标价货币Base Currency/ Quoted Currency<i></i></h3> 
            <p>根据汇率定义，其表达方式为一单位的基准货币可兑换多少单位的标价货币，即：各种标价法下数量固定不变的货币叫做基准货币（Base Currency），数量变化的货币即为标价货币（Quoted Currency）。例如，EUR/USD欧元/美元报价是以1欧元等于多少美元表示，所以在此基准货币为EUR欧元，标价货币为USD美元。</p> 
            <h3>11、直接标价Direct Quotation<i></i></h3> 
            <p>又叫应付标价，表示以一定单位（通常为1）的外国货币为标准，来计算应付多少本国货币的报价。也就是本国货币作为标价货币，外国货币作为基准货币。世界上绝大多数国家都采用直接标价法，例USD/JPY 113.307，表示1美元=113.307日元。</p> 
            <h3>12、间接标价Indirect Quotation<i></i></h3> 
            <p>又叫应收标价，表示以一定单位（通常为1）的本国货币为标准，来计算应收多少外国货币的报价。也就是本国货币作为基准货币，外国货币作为标价货币，例GBP/USD 1.06025，表示1英镑=1.06025美元</p> 
            <h3>13、利率互换Interest Rate Swap<i></i></h3> 
            <p>利率互换是指两笔货币相同、债务额相同(本金相同)、期限相同的资金，作固定利率与浮动利率的调换。这个调换是双方的，如甲方以固定利率换取乙方的浮动利率，乙方则以浮动利率换取甲方的固定利率，故称互换。互换的目的在于降低资金成本和利率风险。</p> 
            <h3>14、货币互换Currency Swap<i></i></h3> 
            <p>货币互换(又称货币掉期)是指两笔金额相同、期限相同、计算利率方法相同，但货币不同的债务资金之间的调换，同时也进行不同利息额的货币调换。简单来说，货币互换双方互换的是货币，它们之间各自的债权债务关系并没有改变。</p> 
            <h3>15、货币权证Currency Warrant<i></i></h3> 
            <p>目前市面上共有6只货币权证，包括AUD/USD澳元/美元,USD/JPY美元/日元的认购证（C）和认沽证（P）可供选择。例，USYEN@EC809，US代表美元，YEN代表日元，C为认购，如果是认购证则是看好美元，看淡日元；认沽证则是看淡美元，看好日元。看好某一只的同时代表看淡另一只。</p> 
            <h3>16、交易成本Transaction Costs<i></i></h3> 
            <p>买入价与卖出价的差价也是一个交易回合的成本。交易回合是指同等数量、相同货币对的一个买人(或卖出)交易和一个用以抵销的卖出(或买入)交易。在表4．1中的欧元／美元例子中，交易成本是三点。计算交易成本的公式是：交易成本=卖出价-买入价</p> 
            <h3>17、展期交割Rollover<i></i></h3> 
            <p>展期交割是将一个交易的原有交割日向后延展到另一个日期的 过程。这个过程的成本由两种货币的利率差价而定。<br /> 用保证金进行FX交易可以提高你的购买力。如果你的保证金账 户中有2，000美元，允许的杠杆是100：1，你就可以最高买人价格 2，000，000美元的FX，因为你只须交购买价格的百分之一作为抵 押。换句话说，你有2，000，000美元的购买力。</p> 
            <h3>18、交易对手Counterparty<i></i></h3> 
            <p>在FX市场交易中，想要买一件产品，必须同时有另一个人卖这个产品，交易才能达成，这种供求关系形成了流动性，而订单的接收方则成为交易对手。也就是说，当你赚钱时，交易对手亏钱；当你亏钱时，交易对手赢钱。当经纪商成为客户的交易对手时，就是B-book模式；当经纪商的上一级流动性提供方：中型银行、做市商银行等成为客户的交易对手时，就是A-Book。</p> 
            <h3>19、A-Book/B-Book<i></i></h3> 
            <p>当经纪商成为客户的交易对手时，就是B-book模式；当经纪商的上一级流动性提供方：中型银行、做市商银行等成为客户的交易对手时，就是A-Book。</p> 
            <h3>20、挂单交易Pending Order<i></i></h3> 
            <p>挂单交易是指由客户指定交易币种、金额以及交易目标价格后，一旦报价达到或优于客户指定的价格，即执行客户的指令，完成交易，成交价格为银行的即时报价。 挂单汇率应优于我行即时汇率，否则，按即时汇率成交。挂单指令当日有效。在成交之前，客户也可以主动撤消未成交指令。客户在进行挂单交易操作后，挂单的金额立即被冻结，在该交易日内该笔金额不能用于支付或其他用途，除非该笔交易取消。<br /> 在挂单交易中有四种类型：buy limit买入限价， sell limit卖出限价，buy stop买入止损，sell stop卖出止损。</p> 
            <p>sell stop：如果你认为汇价下降到x价位后会确定跌势，继续走低，可以在x价位做空，当价格走到x价位的时候系统会自动成交。<br /> buy stop：如果你认为汇价上升到x价位后会确定涨势，继续走高，可以在x价位做多，当价格走到x价位的时候系统会自动成交。<br /> sell limit：如果你认为汇价上升到x价位后会向下反弹，可以在x价位做空，当价格走到x价位的时候系统会自动成交。<br /> buy limit：如果你认为汇价下降到x价位后会向上反弹，可以在x价位做多，当价格走到x价位的时候系统会自动成交。</p> 
            <h3>21、滑点Slippage<i></i></h3> 
            <p>滑点是指一笔交易或挂单交易，实际订单成交价格与预设价格之间存在差异的一种交易现象。因为通过Internet进行交易，都不可避免的出现投资者——服务器——银行三者间一次甚至多次的价格确认所以会出现滑点。同时流动性不足、行情波动剧烈、大数据公布时也是造成滑点的原因。</p> 
            <div class="clear"></div> 
        
          </div>
      
        </div>
      </div>
      <div class="dictionary_main_top">
        <input type="radio" name="dictionary" id="dictionary4" checked>   
        <label for="dictionary4">技术面术语</label>
        <div class="dictionary_main_bot">
           
          <div class="company_overview_content"> 
            <div class="company_overview_content_title">
              技术面术语
            </div>
            <h3>1、MACD平滑异同移动平均线<i></i></h3> 
            <p>平滑异同移动平均线(Moving Average Convergence Divergence，简称MACD指标)，也称移动平均聚散指标, 根据均线的构造原理，对股票价格的收盘价进行平滑处理，求出算术平均值以后再进行计算，是一种趋向类指标。</p> 
            <p><strong>MACD有两大用法：</strong><br /> 顺势操作—金叉/死叉战法<br /> 就是追涨杀跌,在多头市场时金叉买入,在空头市场时死叉卖出。<br /> 逆市操作—顶底背离战法<br /> 就是逃顶抄底,在顶背离时卖空,在底背离时买多.</p> 
            <h3>2、RSI相对强弱指标（Relative Strength Index）<i></i></h3> 
            <p>相对强弱指数（RSI）是通过比较一段时期内的平均收盘涨数和平均收盘跌数来分析市场买沽盘的意向和实力，从而作出未来市场的走势。</p> 
            <p>1) 受计算公式的限制，不论价位如何变动，强弱指标的值均在0与100之间。</p> 
            <p>2) 强弱指标保持高于50表示为强势市场，反之低于50表示为弱势市场。</p> 
            <p>3) 强弱指标多在70与30之间波动。当六日指标上升到达80时，表示股市已有超买现象，如果一旦继续上升，超过90以上时，则表示已到严重超买的警戒区，股价已形成头部，极可能在短期内反转回转。</p> 
            <p>4) 当六日强弱指标下降至20时，表示股市有超卖现象，如果一旦继续下降至10以下时则表示已到严重超卖区域，股价极可能有止跌回升的机会。</p> 
            <p>5) 每种类型股票的超卖超买值是不同的，我们对一只股票采取买/卖行动前，一定要先找出该只股票的超买/超卖水平。至于衡量一只股票的超买/超卖水平，我们可以参考该股票过去12个 月之强弱指标记录。</p> 
            <p>6) 当强弱指标上升而股价反而下跌，或是强弱指标下降而股价反趋上涨，这种情况称之为“背驰”。当RSI在70至80上时，价位破顶而RSI不能破 顶，这就形成了“顶背驰”，而当RSI在30至20下时，价位破底而RSI不能破底就形成了“底背驰”。这种强弱指标与股价变动，产生的背离现象，通常是 被认为市场即将发生重大反转的讯号。</p> 
            <h3>3、KDJ随机指数<i></i></h3> 
            <p>随机指标由 George C．Lane 创制。它综合了动量观念、强弱指标及移动平均线的优点，用来度量股价脱离价格正常范围的变异程度。</p> 
            <p>KDJ指标考虑的不仅是收盘价，而且有近期的最高价和最低价，这避免了仅考虑收盘价而忽视真正波动幅度的弱点。随机指标(KDJ)一般是根据统计学的原理，通过一个特定的周期（常为9日、9周等）内出现过的最高价、最低价及最后一个计算周期的收盘价及这三者之间的比例关系，来计算最后一个计算周期的未成熟随机值RSV，然后根据平滑移动平均线的方法来计算K值、D值与J值，并绘成曲线图来研判股票走势。</p> 
            <p>随机指标(KDJ)是以最高价、最低价及收盘价为基本数据进行计算，得出的K值、D值和J值分别在指标的坐标上形成的一个点，连接无数个这样的点位，就形成一个完整的、能反映价格波动趋势的KDJ指标。它主要是利用价格波动的真实波幅来反映价格走势的强弱和超买超卖现象，在价格尚未上升或下降之前发出买卖信号的一种技术工具。它在设计过程中主要是研究最高价、最低价和收盘价之间的关系，同时也融合了动量观念、强弱指标和移动平均线的一些优点，因此，能够比较迅速、快捷、直观地研判行情。由于KDJ线本质上是一个随机波动的观念，故其对于掌握中短期行情走势比较准确。</p> 
            <h3>4、BOLL指标—布林线<i></i></h3> 
            <p>BOLL指标是美国股市分析家约翰•布林根据统计学中的标准差原理设计出来的一种非常简单实用的技术分析指标。一般而言，股价的运动总是围绕某一价值中枢（如均线、成本线等）在一定的范围内变动，布林线指标指标正是在上述条件的基础上，引进了“股价通道”的概念，其认为股价通道的宽窄随着股价波动幅度的大小而变化，而且股价通道又具有变异性，它会随着股价的变化而自动调整。正是由于它具有灵活性、直观性和趋势性的特点，BOLL指标渐渐成为投资者广为应用的市场上热门指标。</p> 
            <p>在众多技术分析指标中，BOLL指标属于比较特殊的一类指标。绝大多数技术分析指标都是通过数量的方法构造出来的，它们本身不依赖趋势分析和形态分析，而BOLL指标却股价的形态和趋势有着密不可分的联系。BOLL指标中的“股价通道”概念正是股价趋势理论的直观表现形式。BOLL是利用“股价通道”来显示股价的各种价位，当股价波动很小，处于盘整时，股价通道就会变窄，这可能预示着股价的波动处于暂时的平静期；当股价波动超出狭窄的股价通道的上轨时，预示着股价的异常激烈的向上波动即将开始；当股价波动超出狭窄的股价通道的下轨时，同样也预示着股价的异常激烈的向下波动将开始。</p> 
            <p>投资者常常会遇到两种最常见的交易陷阱，一是买低陷阱，投资者在所谓的低位买进之后，股价不仅没有止跌反而不断下跌；二是卖高陷阱，股票在所谓的高点卖出后，股价却一路上涨。布林线特别运用了爱因斯坦的相对论，认为各类市场间都是互动的，市场内和市场间的各种变化都是相对性的，是不存在绝对性的，股价的高低是相对的，股价在上轨线以上或在下轨线以下只反映该股股价相对较高或较低，投资者作出投资判断前还须综合参考其他技术指标，包括价量配合，心理类指标，类比类指标，市场间的关联数据等。总之，BOLL指标中的股价通道对预测未来行情的走势起着重要的参考作用，它也是布林线指标所特有的分析手段。</p> 
            <h3>5、CCI顺势指标<i></i></h3> 
            <p>顺势指标又叫CCI指标，其英文全称为“Commodity Channel Index”，它最早是用于期货市场的判断，后运用于股票市场的研判，并被广泛使用。与大多数单一利用股票的收盘价、开盘价、最高价或最低价而发明出的各种技术分析指标不同，CCI指标是根据统计学原理，引进价格与固定期间的股价平均区间的偏离程度的概念，强调股价平均绝对偏差在股市技术分析中的重要性，是一种比较独特的技术分析指标。</p> 
            <p>在常用的技术分析指标当中，CCI（顺势指标）是最为奇特的一种。CCI指标没有运行区域的限制，在正无穷和负无穷之间变化，但是，和所有其它没有运行区域限制的指标不一样的是，它有一个相对的技术参照区域：+100和—100。按照指标分析的常用思路，CCI指标的运行区间也分为三类：+100以上为超买区，—100以下为超卖区，+100到—100之间为震荡区，但是该指标在这三个区域当中的运行所包含的技术含义与其它技术指标的超买与超卖的定义是不同的。首先在+100到—100之间的震荡区，该指标基本上没有意义，不能够对大盘及个股的操作提供多少明确的建议，因此它在正常情况下是无效的。这也反映了该指标的特点——CCI指标就是专门针对极端情况设计的，也就是说，在一般常态行情下，CCI指标不会发生作用，当CCI扫描到异常股价波动时，立求速战速决，胜负瞬间立即分晓，赌输了也必须立刻了结。</p> 
            <h3>6、ADX平均趋向指标<i></i></h3> 
            <p>平均趋向指数（ADX——Average Directional Indicator）是另一种常用的趋势衡量指标。与趋向系统（DMI）同样是由威尔斯•威尔德（Welles Wilder）所著，利用多空趋向之变化差离与总和判定股价变动之平均趋势，可反映股价走势之高低转折，但无法掌控波段获利水准，因此，发生信号频率甚多而获利却不稳定，常用于辅助其他指标系统操作。</p> 
            <p>ADX无法告诉你趋势的发展方向。可是，如果趋势存在，ADX可以衡量趋势的强度。不论上升趋势或下降趋势，ADX看起来都一样。ADX的读数越大，趋势越明显。衡量趋势强度时，需要比较几天的ADX 读数，观察ADX究竟是上升或下降。ADX读数上升，代表趋势转强；如果ADX读数下降，意味着趋势转弱。当ADX曲线向上攀升，趋势越来越强，应该会持续发展。如果ADX曲线下滑，代表趋势开始转弱，反转的可能性增加。单就ADX本身来说，由于指标落后价格走势，所以算不上是很好的指标，不适合单就ADX进行操作。可是，如果与其他指标配合运用，ADX可以确认市场是否存在趋势，并衡量趋势的强度。</p> 
            <h3>7、动量指标<i></i></h3> 
            <p>动量指标又叫MTM指标，其英文全称是“Momentom Index”，是一种专门研究股价波动的中短期技术分析工具。动量指数以分析股价波动的速度为目的，研究股价在波动过程中各种加速，减速，惯性作用以及股价由静到动或由动转静的现象。动量指数的理论基础是价格和供需量的关系，股价的涨幅随着时间，必须日渐缩小，变化的速度力量慢慢减缓，行情则可反转。反之，下跌亦然。动量指数就是这样通过计算股价波动的速度，得出股价进入强势的高峰和转入弱势的低谷等不同讯号，由此成为投资者较喜爱的一种测市工具。</p> 
            <p>股价在波动中的动量变化可通过每日之动量点连成曲线即动量线反映出来。在动量指数图中，水平线代表时间，垂直线代表动量范围。动量以0为中心线，即静速地带，中心线上部是股价上升地带，下部是股价下跌地带，动量线根据股价波情况围绕中心线周期性往返运动，从而反映股价波动的速度。</p> 
            <h3>8、Gann Fan江恩角度线<i></i></h3> 
            <p>江恩角度线（Gann Fan），亦又称作甘氏线的，是国内投资者较常见的技术分析工具，但由于这一工具的独特性，一些股票分析软件并未深谙其理，操作者无从领略到江恩线强大的测市功效，无疑是一种遗憾。角度线是江恩理论系列中的重要组成部分，它具有非常直观的分析效果，根据角度线提供的纵横交错的趋势线，能帮助分析者作出明确的趋势判断。因而，角度线是一套价廉物美的分析方法，任何人化很少时间都可以轻松学会。</p> 
            <p>在谈到角度线的意义时，江恩宣称：”当时间与价位形成四方形时，市运转势便迫近眼前。”表明角度线并非一般意义上的趋势线，根据时间价格两度空间的概念而促成独特的分析体系。因而有分析人士指出，角度线是江恩最伟大的发明，它打开了时间与价格不可调和但密不可分的格局，从操作的角度说，这是技术理论中甚至是最有价值的一部分。</p> 
            <p>因而，制作江恩线要有一个四方形的概念，所谓四方形亦为正方形，以对角线出现的45度作为四方形的二分一，它代表了时间与价位处于平衡的关系，若根据某一模式的时间、价位同时到达这一平衡点时，市场将发生重大震荡。</p> 
            <p>江恩线体现的是江恩理论中价格与时间的关系。<br /> 江恩理论中最重要的概念就是江恩线与价格运动的关系。<br /> 江恩线在X轴上建立时间，在Y轴上建立价格，江恩线的符号是“TxP”，T为时间，P为价格。</p> 
            <p>江恩线由时间单位和价格单位定义价格运动，每条江恩线由时间和价格的关系所决定。从图上各个明显的顶点和底点画出江恩线，他们彼此互相交叉，构成江恩线之间的关系。它们不仅能确定何时价格会反转，而且能够指出将反转到何种价位，构成时间与价格的美妙和谐。</p> 
            <p>江恩线的基本比例为1：1，即每单位时间内，价格运行一个单位。另外，还有1/8、2/8、1/3、3/8、4/8、5/8、2/3、6/8、7/8等。每条江恩线有其相对应的几何角。</p> 
            <h3>9、SAR抛物线转向指标<i></i></h3> 
            <p>抛物线转向（Stop and Reveres，SAR / The Parabolic Time/Price System）也称停损点转向。“stop”，即停损、止损之意，这就要求投资者在买卖某个股票之前，先要设定一个止损价位，以减少投资风险。而这个止损价位也不是一直不变的，它是随着股价的波动止损位也要不断的随之调整。如何既可以有效地控制住潜在的风险，又不会错失赚取更大收益的机会，是每个投资者所追求的目标。但是股市情况变幻莫测，而且不同的股票不同时期的走势又各不相同，如果止损位设的过高，就可能出现股票在其调整回落时卖出，而卖出的股票却从此展开一轮新的升势，错失了赚取更大利润的机会，反之，止损位定的过低，就根本起不到控制风险的作用。因此，如何准确地设定止损位是各种技术分析理论和指标所阐述的目的，而SAR指标在这方面有其独到的功能。<br /> “Reverse”，即反转、反向操作之意，这要求投资者在决定投资股票前先设定个止损位，当价格达到止损价位时，投资者不仅要对前期买入的股票进行平仓，而且在平仓的同时可以进行反向做空操作，以谋求收益的最大化。这种方法在有做空机制的证券市场可以操作，而目前我国国内市场还不允许做空，因此投资者主要采用两种方法，一是在股价向下跌破止损价位时及时抛出股票后持币观望，二是当股价向上突破SAR指标显示的股价压力时，及时买入股票或持股待涨。</p> 
            <h3>10、变动率指标<i></i></h3> 
            <p>变动率(Rate of change，ROC)，ROC是由当天的股价与一定的天数之前的某一天股价比较，其变动速度的大小,来反映股票市场变动的快慢程度。大多数的书籍上把ROC叫做变动速度指标、变动率指标或变化速率指标。从英文原文直译应该是变化率。<br /> 1) <strong>ROC表示股价上升或下降的速率大小。</strong><br /> 如果是上升趋势，并且ROC为正值,另外ROC步步上扬,则意味着上升趋势正在加速，若ROC开始走平,这就意味着,现在股价的涨幅与数天前的股价涨幅相近,尽管还处于上升趋势,但速度已经放慢;若ROC开始回落,虽然股价还在上升,但上升的力量已经衰落;若ROC开始延伸到0之下,则近期的下降趋势已开始露头,ROC进一步向下,则下降动力正在加强。<br /> ROC是显示一定时间间隔的两头的股价的相对差价。ROC上升,则股价比数天前的股价有所上升。ROC走平，则当前股价涨幅仅仅同数天前一样。ROC向下，则股价已经比数天数的涨幅小了。ROC就是这样显示当前股价趋势的加速和减速状态的。<br /> 对于下降趋势和ROC下降，且为负值的情况，可以类似地叙述。</p> 
            <p>2) <strong>ROC的变化超前于股票价格的变化</strong><br /> 因为ROC的构造特点，ROC的变化总是领先于股价的变化，比价格提前几天上升或下降。股价还在上升时，ROC可能已走平，而股价走平时，ROC可能已经下降了。这一点也是背离思想的基本依据。</p> 
            <p>3) <strong>ROC折变化有一定的范围</strong><br /> ROC可正可负，可大可小，但是ROC的变化基本上是有一个范围的。换句话说，我们可以找到一个正数和一个负数，使得ROC曲线绝大部分落在这两个数构成的范围内,即比这个正数小,比那个负数大。这样，就好像给ROC加上了上下边界一样。这两条边界对我们今后预测股价的上升高度和下降深度很有帮助。我们可以利用这两条边界通过反向运算的方法，计算出未来的上升高度和下降高度。</p> 
            <div class="clear"></div> 
        
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

  $(".company_overview_content").find("h3").click(function(){
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

  param=window.location.hash.substr(1);
    str="#"+param;
    $(str).attr("checked",true);
</script>
</html>