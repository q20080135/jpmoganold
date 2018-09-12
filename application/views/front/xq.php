<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no,minimum-scale=1.0,maximum-scale=1.0" />
<meta http-equiv="Cache-Control" content="no-cache"/>
	<title></title>
  <meta name="description" content="<?php echo $aSeoDesc?>" /> 
  <meta name="keywords" content="<?php echo $aSeoKeywork?>" /> 
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
<script type="text/javascript" src="js/jquery.colorbox.js"></script> 
  <script type="text/javascript" src="js/myscript.js"></script>   <div class="new_content">
    <div class="breadcrumbs_wrapper">
  <div class="inner">
        <div class="breadcrumbs">
            <!-- Breadcrumb NavXT 5.6.0 -->
          <span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="/" class="home">Home</a></span><span class="space">&gt;</span><span property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage" href="<?php echo $cUrl;?>" class="taxonomy category"><span property="name"><?php echo $cName;?></span></a><meta property="position" content="2"></span><span class="space">&gt;</span><span property="itemListElement" typeof="ListItem"><span property="name"><?php echo $aTitle;?></span><meta property="position" content="3"></span>            <div class="clear"></div>
        </div>
    </div>
</div>
      <div style="min-height: 500px;width:50%;margin: auto;margin-top: 20px;">
        <h1 style="font-size: 36px;background: url(/resource/static/front/images/bg_page_title_h1.png) left 4px no-repeat;padding: 0px 0px 0px 30px;"><?php echo $aTitle;?></h1>
        <h1 style="font-size: 14px;margin-top:20px;padding: 0px 0px 0px 30px;"><?php echo $aAddtime;?></h1>
        <div style="margin-top: 20px;">
          <?php echo $aContent;?>
        </div>
      </div>
  </div>
<!--footer start--> 
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