<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no,minimum-scale=1.0,maximum-scale=1.0" />
<meta http-equiv="Cache-Control" content="no-cache"/> 
  <title>联系我们</title>
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
  <script src="/resource/static/front/js/gVerify.js"></script>
  <div class="new_content">
    <div class="linkus_display">
      <div class="linkus_display_center">
      <p>CONTACT US</p>
      <p>我们将<span style="color:#fbb600">竭力为您服务</span></p>
      <p>WE WILL DO OUR BEST TO SERVE YOU</p>
      </div>
    </div>
    <div class="linkus_text">
      <div class="linkus_text_top">
        <p><i style="display:inline-block;width:50px;border-bottom:1px solid #b09373;position:relative;top:-5px;left:-30px"></i><b style="position:relative;top:-3px;left:-20px;display:inline-block;width:6px;height:6px;border-radius:3px;background-color:#bfbfbf"></b>
          <span>客户服务</span>
          <b style="position:relative;top:-3px;left:20px;display:inline-block;width:6px;height:6px;border-radius:3px;background-color:#bfbfbf"></b><i style="position:relative;top:-5px;left:30px;display:inline-block;width:50px;border-bottom:1px solid #b09373"></i>
        </p>
        <p style="color:#444;font-size:28px;font-weight:bold">CUSTOMER SERVICE</p>
      </div>
      <i></i>
      <div class="linkus_customer">
        客户服务
      </div>
      <div class="linkus_text_bot">
        <h1>如果您有任何问题，欢迎联系我们，我们将24*5小时竭力为您服务</h1>
        <span>
          <i class="i1"></i>
          <p>support@jpmorgen.com</p>
        </span>
        <span>
          <i class="i2"></i>
          <p>在线客服</p>
        </span>
        <span>
          <i class="i3"></i>
          <p>地址：中国香港</p>
        </span>
      </div>  
    </div> 
    <div class="linkus_message">
      <div class="linkus_message_title">
        *投诉、建议请在下方填写并提交
      </div>
      <div class="linkus_message_l">
        <form>
          <input type="text" name="name" placeholder="(姓名)">
          <input type="text" name="phone" placeholder="(联系电话)">
          <input type="text" name="email" placeholder="(电邮地址)">
          <textarea cols="50" rows="10" name="contents" placeholder="(投诉、建议内容)"></textarea>
          <input type="text" name="checkcode" placeholder="(验证码)" id="authCodeId"><span id="imgcode"></span>

          <input type="button" name="submit" value="提交" id="SubmitId">
        </form>
      </div>
      <div class="linkus_message_r">
        <img src="/resource/static/front/images/linkus_message.png">
      </div>
    </div>
  </div>
  <script type="text/javascript">
    var verifyCode = new GVerify("imgcode");
    document.getElementById("SubmitId").onclick = function(){
      var res = verifyCode.validate(document.getElementById("authCodeId").value);
      if(!res){
          
         alert("验证码错误");
      }
    }
  </script>
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
</html>