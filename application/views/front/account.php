<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no,minimum-scale=1.0,maximum-scale=1.0" />
<meta http-equiv="Cache-Control" content="no-cache"/> 
  <title>交易账户</title>
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
  <div class="new_content">
    <div class="account_display">
      <div class="account_display_center">
      <p>JPMogan</p>
      <p>TRADING ACCOUNT</p>
      <p>交易<span style="color:#fcb600">账户</span></p>
      </div>
    </div>
    <div class="account_text">
      <div class="account_text_top">
        <p><i style="display:inline-block;width:50px;border-bottom:1px solid #b09373;position:relative;top:-5px;left:-30px"></i><b style="position:relative;top:-3px;left:-20px;display:inline-block;width:6px;height:6px;border-radius:3px;background-color:#bfbfbf"></b>
          <span>交易账户</span>
          <b style="position:relative;top:-3px;left:20px;display:inline-block;width:6px;height:6px;border-radius:3px;background-color:#bfbfbf"></b><i style="position:relative;top:-5px;left:30px;display:inline-block;width:50px;border-bottom:1px solid #b09373"></i>
        </p>
        <p style="color:#444;font-size:28px;font-weight:bold">TRADING ACCOUNT</p>
      </div>
      <i></i>
    </div>

    <div class="account_view">
      <div class="account_view_top">
        <input type="radio" name="account" id="account1" >   
        <label for="account1">三大账户</label>
        <div class="account_view_bot">
           

           <div class="company_overview_content"> 
            <div class="default_template"> 
             <div class="clear"></div> 
            </div> 
           </div> 
           <div class="page_content_list_wrapper"> 
            <div class="page_content_list_content"> 
             <div class="page_content_list_title"> 
              <div class="iocn_box">
               <img src="/resource/static/front/images/account01.png" alt="" />
              </div> 
              <p>JPMogan账户类型</p> 
             </div> 
             <div class="page_content_list_nr"> 
              <div class="page_content_list_table"> 
               <table border="0" width="100%" cellspacing="0" cellpadding="0"> 
                <tbody> 
                 <tr> 
                  <th scope="col"></th> 
                  <th scope="col">标准账户</th> 
                  <th scope="col">VIP账户</th> 
                  <th scope="col">ECN账户</th> 
                 </tr> 
                 <tr> 
                  <td>最低入金</td> 
                  <td>500 USD</td> 
                  <td>500 USD</td> 
                  <td>10,000USD</td> 
                 </tr> 
                 <tr> 
                  <td>常规杠杆</td> 
                  <td>50:1-400:1</td> 
                  <td>50:1-400:1</td> 
                  <td>50:1-400:1</td> 
                 </tr> 
                 <tr> 
                  <td>最小合约单位</td> 
                  <td>0.01</td> 
                  <td>0.01</td> 
                  <td>0.01</td> 
                 </tr> 
                 <tr> 
                  <td>浮动点差（欧美）</td> 
                  <td>2.2-2.8</td> 
                  <td>1.2-1.8</td> 
                  <td>0-0.3</td> 
                 </tr> 
                 <tr> 
                  <td>挂单距离</td> 
                  <td>2.0</td> 
                  <td>2.0</td> 
                  <td>2.0</td> 
                 </tr> 
                 <tr> 
                  <td>平台</td> 
                  <td>MT 4</td> 
                  <td>MT 4</td> 
                  <td>MT 4</td> 
                 </tr> 
                 <tr> 
                  <td>手机交易</td> 
                  <td>是</td> 
                  <td>是</td> 
                  <td>是</td> 
                 </tr> 
                 <tr> 
                  <td>一键交易</td> 
                  <td>是</td> 
                  <td>是</td> 
                  <td>是</td> 
                 </tr> 
                 <tr> 
                  <td>允许锁仓</td> 
                  <td>是</td> 
                  <td>是</td> 
                  <td>是</td> 
                 </tr> 
                 <tr> 
                  <td>强制平仓</td> 
                  <td>50%</td> 
                  <td>50%</td> 
                  <td>50%</td> 
                 </tr> 
                 <tr> 
                  <td>交易限制</td> 
                  <td>无</td> 
                  <td>无</td> 
                  <td>无</td> 
                 </tr> 
                 <tr> 
                  <td>是否支持EA</td> 
                  <td>是</td> 
                  <td>是</td> 
                  <td>是</td> 
                 </tr> 
                </tbody> 
               </table> 
              </div> 
              <p>注：<br /> 1、当遇到风险事件时，平台有权对杠杆进行调整，并提前通知客户，使之有充足时间调整仓位。<br /> 2、点差会随着市场波动而发生变化。</p> 
              <div class="clear"></div> 
             </div> 
            </div> 
           </div> 


           
        </div>
      </div>
      <div class="account_view_top">
        <input type="radio" name="account" id="account2" checked >
        <label for="account2">MAM账户</label>
        <div class="account_view_bot">
          

           <div class="company_overview_content"> 
            <div class="default_template"> 
             <p>MAM多账户管理系统是JPMogan特别为专业资金管理者量身打造的灵活分配方案，通过一个简单实用的界面，实现多个账户的统筹管理。可以让资金管理人同时管理多重交易账户的交易配置。为专业的资金管理者提供了卓越的多账户管理解决方案。同时MAM的功能强大优势明显，每个账户持仓、余额、保证金水平一览无遗。订单批量成交并且瞬时分配多个管理账户，保障各个子账户的资金安全。灵活的分配方案，可按净值，手数从容进行下单分配。MAM为专业的资金管理者提供了卓越的账户管理，节约大量时间成本，从而专注于运筹帷幄，良策金石。<br /> <img src="/resource/static/front/images/mam.png" alt="mam" width="353" height="306" class="aligncenter size-full wp-image-6667" style="padding:50px 0px 0px"  sizes="(max-width: 353px) 100vw, 353px" /></p> 
             <div style="text-align:center;margin-bottom:80px;">
              注：理论上子账户无数量限制，但是为了更好的体验，建议将子账户数量保持在50以内
             </div> 
             <table> 
              <tbody>
               <tr> 
                <th colspan="2">MAM十大功能及优势</th> 
               </tr> 
               <tr> 
                <td>交易账户数量无上限</td> 
                <td>可提供止损，止赢，挂单功能</td> 
               </tr> 
               <tr> 
                <td>两种交易分配模式：按交易百分比分配或资产比例分配</td> 
                <td>可交易标准手/迷你手/微型迷你手,并精确分配到子帐户</td> 
               </tr> 
               <tr> 
                <td>主账户及时同步操作多子账户</td> 
                <td>支持所有智能交易(EA)</td> 
               </tr> 
               <tr> 
                <td>STP 交易执行，即时分配子帐户订单</td> 
                <td>市场透明，交易安全，提供极具竞争力的价差</td> 
               </tr> 
               <tr> 
                <td>智能交易，多种订单交易瞬间执行</td> 
                <td>实时风险订单管理</td> 
               </tr> 
              </tbody>
             </table> 
             <div class="clear"></div> 
            </div> 
           </div> 
           <div class="page_accordion_content_wrapper"> 
            <div class="page_accordion_content"> 
             <div class="page_accordion_content_title selected">
              MAM账户申请条件
          
             </div> 
             <div class="page_accordion_content_text" > 
              <div class="default_template"> 
               <p>1、总资金需达到10万美元以上；</p> 
               <p>2、至少5个子账户（子账户需在同一条代理线下，组别需保持一致）；</p> 
               <p>3、每个子账户资金不得低于5000美金；</p> 
               <p>4、确定好客户不建议随意更改，客户有持仓不能移进移出，MAM账户需在周末创建。</p> 
               <div class="clear"></div> 
              </div> 
             </div> 
            </div> 
            <div class="page_accordion_content"> 
             <div class="page_accordion_content_title">
              MAM账户交易规则
       
             </div> 
             <div class="page_accordion_content_text" > 
              <div class="default_template"> 
               <p>1、子账户在整个申请流程中必须保持空仓状态；</p> 
               <p>2、LPOA表格有两份，均需要发给客户，一份为中英文可供客户参考，一份为全英文，需要签署的协议为全英文版本，打印后在相关的地方签名；</p> 
               <p>3、因MAM建组在周末进行，故请客户务必在每周五12：00前将相关信息提交到**************邮箱。</p> 
               <p>【移进MAM】</p> 
               <p>将需要进入MAM的主账户及子账户信息（资金至少达到$5000，空仓，组别一致）及LPOA协议发送至info邮箱，运营部门将会在1～2个工作日内处理回复。</p> 
               <p>【移出MAM】</p> 
               <p>将需移出MAM的主账户（空仓）及子账户信息（姓名及MT4账号）发送至info邮箱，运营部门将会在1～2个工作日内处理回复。</p> 
               <p>【MAM出金流程】</p> 
               <p>需归属人提供与客户确认盈利分成具体金额的邮件（根据LPOA协议分配），发送给客户经理（客户可在归属人发送邮件后在后台递交出金申请）→客户经理将整理好的确认邮件以及申请MAM出金盈利分配表格发送至<a href="mailto:***********">**************</a>→运营收到邮件后，附上客户的LPOA协议，核对金额无误→发送给财务，财务确认无误可处理MAM出金，并扣除客户应返给归属人的盈利，返至归属人的相应账户，剩余部分按正常出金步骤到客户的银行卡即可；</p> 
               <p>注意：</p> 
               <ol> 
                <li>MAM(多账户管理跟单系统)出金，盈利部分可根据客户自己意愿提交出金申请；</li> 
                <li>盈利出金后，根据LPOA协议分配比例，必须按照合同将属于归属人的金额分配至归属人的相应账户；</li> 
               </ol> 
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
  <script type="text/javascript"> 
    param=window.location.hash.substr(1);
    str="#"+param;
    $(str).attr("checked",true);   
  </script>
</body>
</html>