

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>企业网站管理系统后台登录</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta http-equiv="Content-Language" content="zh-cn"/>
        <meta content="境掏土特产管理系统后台登录"/>
        <?=res_url('met/images/css/metinfo.css','lib')?>
        <?=res_url('met/images/js/metinfo-min.js','lib')?>
        <?=res_url('jquery/1.9.1/jquery.min.js','lib')?>
        <?=res_url('layer/2.1/layer.js','lib')?>
            <style type="text/css">
                body {
                    font-size: ; 
                    font-family:;
                    background-color:;
                }
            </style>
    </head>
    <script type="text/javascript">
        function check_main_login() {

            
        }
        function pressCaptcha(obj) {
            obj.value = obj.value.toUpperCase();
        }
        function metfocus(intext) {
            intext.focus(function () {
                $(this).addClass('metfocus');
            });
            intext.focusout(function () {
                $(this).removeClass('metfocus');
            });
        }
        $(document).ready(function () {
            var loginheight = $('.login-min').height();
            var bodyheight = $(document).height();
            $('.login-min').css('margin-top', (bodyheight - loginheight) / 2);
            var inputps = $("input[type='text'],input[type='password']");
            if (inputps)
                metfocus(inputps);

        $("#submit").on('click',function(){   

            var url = '<?=site_url("Auth/login")?>';
            post_status = false;


            var name = $("input[name='user']");
            var pass = $("input[name='pwd']");
            if (name.val() == '') {
                alert('用户名不能为空');
                name.focus();
                return false;
            }
            if (pass.val() == '') {
                alert('密码不能为空');
                pass.focus();
                return false;
            }
            var data = {};
            data['user'] = name.val();
            data['pwd'] = pass.val();
            $.post(url,data,function(data){
                if(data.status==1){
                    location.href = '<?=site_url('jt_admin/main')?>';
                }else{
                    layer.alert(data.msg);     
                }
                post_status = true;
            },'json')
            .error(function(){ 
                post_status = true;
                layer.alert("提交失败！"); 
            });
        });

        





        });
    </script>
    <body id="login">
        <div class="login-min">
            <div class="login-minl">
                <div class="login-minr">
                    <div class="login-left">

                    </div>
                    <div class="login-right">	
                        <h1 class="login-title">管理员登录</h1>
                        <div>
                            <form method="post" action="<?=site_url("Auth/login");?>" name="main_login" onSubmit="return check_main_login()">
                                <input type="hidden" name="action" value="login" />
                                <input type="hidden" name="redirect" value="<?=$redirect?>" />

                                <p><label>用户名:</label><input type="text" class="text" name="user" value=""  /></p>
                                <p><label>密&nbsp;&nbsp;&nbsp;&nbsp;码:</label><input type="password" class="text" name="pwd" /></p>
                                <p class="login-code">

                                </p>
                                <p class="login-submit">
                                    <input type="button" id="submit" name="Submit" value="登录" />
                                    <input name="reset" type="reset" value="清除" />
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
