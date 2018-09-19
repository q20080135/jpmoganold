<!DOCTYPE html>
<html>
<head>
	 <meta charset="utf-8">
   <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no,minimum-scale=1.0,maximum-scale=1.0" /> 
<meta http-equiv="Cache-Control" content="no-cache"/>
	<title>提交问题</title>
	<link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/new_css.css" />
	<link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/new_style.css" />
	<link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/new_home.css" /> 
	<link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/colorbox.css" /> 
	<link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/reset.css" /> 
	<link rel="stylesheet" type="text/css" media="all" href="/resource/static/front/css/lww.css" />	
<link rel="stylesheet" type="text/css" href="/resource/static/front/css/app.css"></head>
<body>
<?php
Widget::load('front',array('view'=>'header'));
?>
  <script type="text/javascript" src="/resource/static/front/js/jquery-1.8.3.min.js"></script>
  <script type="text/javascript" src="/resource/static/front/js/new_myscript.js"></script> 
<script type="text/javascript" src="/resource/static/front/js/jquery.colorbox.js"></script> 
  <script type="text/javascript" src="/resource/static/front/js/myscript.js"></script>    
  <script type="text/javascript" src="/resource/static/front/js/app.js"></script>    
  
  <!--   <div id="drag" style="position:absolute;right:260px;top:720px;width:80px;height:80px;padding:20px;border-radius:30px;background:url(/resource/static/front/images/kefu.png) no-repeat center;z-index:10000">
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
    <div class="crumb">
      <a href="">首页</a>
      <span>>提交工单</span>
    </div>
    <div class="submit_head">
      <div class="border_color"></div>
      客服Service:提交工单
    </div>
    <div class="submit_banner">
      <img src="/resource/static/front/images/submit_banner.png">
       请尽量清晰详尽的描述您的问题，以便客服Service能够快速帮您解决问题！感谢您的配合！
    </div>
    <div class="submit_content_title">
      提交工单
    </div>
    <div class="submit_content">
      <form action="" method="post" enctype="multipart/form-data">
        <div class="content1">
          <span>*</span>
          <label>问题类别</label>
          <select id="xType" name="type" class="formstyle">
            <option value="0">--请选择问题--</option>
            <?php foreach ($xiaozhi_state as $key => $value) {
            echo '<option value="'.$key.'" '.($key==$this->input->get('type',true)?' selected="selected"':'').'>'.$value.'</option>';
            }?>   
          </select>
        </div>
        <div class="content2">
          <span>*</span>
          <label>问题标题</label>
          <input class="formstyle" type="text" id="xTitle" name="title" placeholder="请填写问题标题" required>
        </div>
        <div class="content3">
          <span>*</span>
          <label>问题描述</label>
          <textarea id="xDescribe" name="desc" rows="10" cols="50" style="height:150px;width:600px;" placeholder="请描述您的问题" class="formstyle" required></textarea>
        </div>
        <div class="content2" style="height:50px;">
          <label>附件上传</label>
          <div class="content5">
            <input class="formfile" id="xImg" type="file" accept="image/*" name="file" placeholder="请填写问题标题"  onchange="readAsDataURL()">
          </div>
          <div class="file_text">
            附件大小不超过3M，支持png/jpg格式 
            请勿上传非法图片
          </div>
        </div>
        <div class="img_show">
            
            <div id="result"></div>
        </div>
        <div class="content2">
          <span>*</span>
          <label>您的姓名</label>
          <input class="formstyle" type="text" id="xName" name="name" placeholder="请输入您的真实姓名" required>
        </div>
        <div class="content2">
          <span>*</span>
          <label>注册账号</label>
          <input class="formstyle" type="text" id="xUser" name="account" placeholder="请输入正确账号" required>
          <i class="error"></i>
        </div>
        <div class="content2">
          <span>*</span>
          <label>MT4账号</label>
          <input class="formstyle" type="text" id="xMt4User" name="mt4acc" placeholder="请输入正确MT4账号" required>
        </div>
        <div class="content2">
          <span>*</span>
          <label>联系手机</label>
          <input class="formstyle" type="text" id="xPhone" name="phone" placeholder="请输入您的手机号码" required>
          <i class="error"></i>
        </div>
        <div class="content2">
          <span>*</span>
          <label>联系邮箱</label>
          <input class="formstyle" type="text" name="mail" id="xEmail" placeholder="请输入您的邮箱" required>
          <i class="error"></i>
        </div>
        <div class="content4">
          <button type="button" name="submitbtn" class="submitbtn" id="submitbtn">提交小智</button>
        </div>
      </form>
    </div>
  </div>
<?php
Widget::load('front',array('view'=>'footer'));
?>
<!-- footer end --> 
<!--   <script type="text/javascript" src="/resource/static/front/js/footer.js"></script> -->
<?=res_url('layer/2.1/layer.js','lib')?>
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
      Risk Warning: Trading Derivatives carries a high level of risk to your capital and you should only trade with money you can afford to lose. Please ensure that you fully understand the risks involved, and seek independent advice if necessary. A Product Disclosure Statement (PDS) can be obtained  from our offices and should be considered before entering into a transaction with us. 
    </div>
  </div>  <script type="text/javascript">


function readAsDataURL(){ 
    //检验是否为图像文件 
    var file = document.getElementById("xImg").files[0]; 
    if(!/image\/\w+/.test(file.type)){ 
        alert("看清楚，这个需要图片！"); 
        return false; 
    } 
    var reader = new FileReader(); 
    //将文件以Data URL形式读入页面 
    reader.readAsDataURL(file); 
    reader.onload=function(e){ 
        var result=document.getElementById("result"); 
        //显示文件 
        //result.innerHTML='<img src="' + this.result +'" alt="" />'; 
        $('.img_show').append('<div class="img">'+
              '<img class="imgs" src="'+this.result+'">'+
              '<div class="submit_close">'+
                '<img class="close_img" src="/resource/static/front/images/close.png">'+
              '</div>'+
            '</div>');
    } 
} 
$(document).on('click','.close_img',function(){
      $(this).parent().parent().remove();
});

 var post_status = true;

function save_data(){
    if(post_status) {
        layer.msg('正在提交...',{
          time:0,
          offset:['200px'],
        });

        //var data = {};
    var formData = new FormData();
    formData.append('xImg', $('#xImg')[0].files[0]);
    formData.append('xType',$("#xType").val());
    formData.append('xTitle',$("#xTitle").val());
    formData.append('xDescribe',$("#xDescribe").val());
    formData.append('xName',$("#xName").val());
    formData.append('xUser',$("#xUser").val());
    formData.append('xMt4User',$("#xMt4User").val());
    formData.append('xPhone',$("#xPhone").val());
    formData.append('xEmail',$("#xEmail").val());
    console.log($('.img_show .imgs').length);
    $('.img_show .imgs').each(function(index, item){
      formData.append('imgs'+index,$(item).attr('src'));
    });

    var url = '<?=site_url('front/index/xiaozhi_save')?>';
    $.ajax({
        type: "POST",
        dataType:'json',
        url:url,
        data:formData,
        contentType: false,  
        processData: false, 

        success: function(data) {
            layer.open({content:data.msg,end:function(index){
              parent.layer.closeAll();
            }}); 
            post_status = true;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            post_status = true;
            layer.alert("提交失败！");     
        }
    });
  }
}








    var EMAIL=false;
    var PHONE=false;
    var MT4=false;
    //手机验证
    $("#xPhone").blur(function(){

       phone=$(this).val(); 
      if(phone=="" || phone.length==0)
      {
         $(this).next(".error").html("请输入您的手机号码").show();
         PHONE=false;
      }
      else if(phone.match(/^[1][3,4,5,7,8][0-9]{9}$/)==null)
      {
        $(this).next(".error").html("手机号格式不正确").show();
        PHONE=false;
      }
      else
      {
          $(this).next(".error").hide();
          PHONE=true;
      }
   
    })
    //邮箱的验证
    $("#xEmail").blur(function(){

       email=$(this).val();
      if(email=="" || email.length==0)
      {
         $(this).next(".error").html("请输入您的邮箱").show();
         EMAIL=false;
      }
      else if(email.match(/^([0-9A-Za-z\-_\.]+)@([0-9a-z]+\.[a-z]{2,3}(\.[a-z]{2})?)$/g)==null)
      {
        $(this).next(".error").html("邮箱格式不正确").show();
        EMAIL=false;
      }
      else
      {
          $(this).next(".error").hide();
          EMAIL=true;
      }
   
    })

    //MT4账号验证
    $("#xMt4User").blur(function(){

          mt4=$(this).val();
          if(mt4=="" || mt4.length==0)
          {
            $(this).next(".error").html("请输入您的MT4账号").show();
              MT4=false;
          }
          else
          {
                   MT4=true;
           /* $.post("test.php",{mt4:mt4},function(data){

                if(data==0)
                {
                   $(this).next(".error").html("MT4账号不存在").show();
                   MT4=false;
                }
                else
                {
                   MT4=true
                }
            })*/
          }
    })

 $("#submitbtn").on('click',function(){

        if(PHONE && EMAIL && MT4)
        {
          //$(this).submit();
          save_data();
          return true;
        }
        else
        {
          console.log(3);
          return false;
        }
          
  });

    
  </script>
</body>
</html>