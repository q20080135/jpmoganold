<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Widget::load('layout_tpl',array('view'=>'pre_header','data'=>array('title'=>'系统信息')));

Widget::load('layout_tpl',array('view'=>'common_script'));
Widget::load('layout_tpl',array('view'=>'open_body_tag'));
Widget::load('breadcrumb',array('会员管理','会员积分充值'));
?>
<style>
    .form_dizhi{
        width: 140px;
        margin-right: 8px;
    }
    .textarea-numberbar {
        position: inherit;
    }
</style>


<div class="page-container">
        <table class="table table-border table-bordered table-striped"  style="width:400px;margin: 0 auto;">
            <tr>
                <th class="text-c" width="100">手机号</th>
                <td  colspan="2">
					<?=isset($mPhone)?$mPhone:""?>
                </td>    
            </tr>
            <tr>
   				<th class="text-c" width="100">昵称</th>
                <td>
                    <?=isset($mNickName)?$mNickName:""?>
                </td>  
            </tr>

            <tr>
                <th class="text-c" width="100">会员积分</th>
                <td  colspan="2">
					<input maxlength="7" type="text" style="width:200px;" class="input-text radius size-MINI" id="integral"  onblur="parseint_integral()" onkeyup="value=value.replace(/[^\d]/g,'')">
                </td>    
 
            </tr>
         
            <tr>
   				<th class="text-c" width="100">描述</th>
                <td>
                    <input type="text" style="width:200px;" class="input-text radius size-MINI" id="iDescribe">
                </td>  
            </tr>
        </table>
    <form class="form form-horizontal" >
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2 text-r">
              
                <a id="btn_save" class="btn btn-success radius"><i class="Hui-iconfont">&#xe632;</i> 保存</a>

            </div>
        </div>

    </form>
    <?//Widget::load('admin_logs',$uID);?>
</div>

<?=res_url('Validform/5.3.2/Validform.min.js','lib')?>

<script>
// 限制只能提交一次
var post_status = true;

function save_data(id){
    if(post_status) {
        layer.msg('正在提交...',{time:0});
        if(id == ''){
          layer.msg('请刷新重试一下');
          return;
        }
        var data = {
          id : id
        };
        data['integral'] = $('#integral').val();
        data['iDescribe'] = $('#iDescribe').val();
        
        var url = '<?=site_url('jt_admin/integral/integral_save')?>';
        post_status = false;
        $.post(url,data,function(data){
           
            if(data.status){
            	layer.open({content:data.msg,end:function(index){
            	  	parent.layer.closeAll();
            	}});    
              //location.reload();
            }else{
              layer.alert(data.msg);
            }
            post_status = true;
        },'json')
        .error(function(){ 
            post_status = true;
            layer.alert("提交失败！"); 
        });
    }
}

$(document).ready(function() {
    ///确认保存
    $('#btn_save').on('click',function(){
        
        layer.confirm('确认保存？', {btn: ['是', '取消']},function(index){
            var id = '<?=$mId?>';
            save_data(id);
        });
    });

});
</script>

<?php Widget::load('layout_tpl',array('view'=>'footer'));?>
<?php Widget::load('layout_tpl',array('view'=>'close_body_tag'));?>