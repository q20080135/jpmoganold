<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Widget::load('layout_tpl',array('view'=>'pre_header','data'=>array('title'=>'系统信息')));

Widget::load('layout_tpl',array('view'=>'common_script'));
Widget::load('layout_tpl',array('view'=>'open_body_tag'));
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
        <table class="table table-border table-bordered table-striped">
            <tr>
                <th class="text-c" width="100">用户名称</th>
                <td  colspan="2">
					<?=$uName?>
                </td>    
   				<th class="text-c" width="100">姓名</th>
                <td  colspan="3">
                    <input type="text" class="input-text radius size-MINI" id="uRealName" ori_data="<?=$uRealName?>" value="<?=$uRealName?>">
                </td>  
            </tr>
            <!-- 
                      <tr>
                <th class="text-c" width="100">电话</th>
                <td  colspan="2">
                    <input type="text" class="input-text radius size-MINI" id="tel" ori_data="<?=$tel?>" value="<?=$tel?>">
                </td> 
                <th class="text-c" width="100">QQ</th>
                <td colspan="3">
                    <input type="text" class="input-text radius size-MINI" id="qq" ori_data="<?=$qq?>" value="<?=$qq?>">
                </td>   
            </tr>         
             -->
            <tr>
                <th class="text-c" width="100">原密码</th>
                <td colspan="6">
                    <p><input type="password" class="input-text radius size-MINI" style="width:80px;" id="ypwd" ori_data="" value=""></p>
                </td> 
            </tr>  
                                    <tr>
                <th class="text-c" width="100">密码</th>
                <td colspan="6">
                    <p><input type="password" class="input-text radius size-MINI" style="width:80px;" id="uPwd" ori_data="" value=""></p>
                </td> 


            </tr> 
                                    <tr>
                <th class="text-c" width="100">确认密码</th>
                <td colspan="6">
                    <p><input type="password" class="input-text radius size-MINI" style="width:80px;" id="qrpwd" ori_data="" value=""></p>
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

</div>

<?=res_url('Validform/5.3.2/Validform.min.js','lib')?>
<script>
// 限制只能提交一次
var post_status = true;

function save_data(id){
    if(post_status) {
        layer.msg('正在提交...',{time:0});


        var data = {
                id : id
              };
        data = if_change_val_set_data('uRealName',data);
        data = if_change_val_set_data('uPwd',data);
        data = if_change_val_set_data('ypwd',data);
        data = if_change_val_set_data('qrpwd',data);
        var purl = '<?=site_url('jt_admin/admin/user_ypass')?>';
        if(data.qrpwd!=data.uPwd){
            layer.msg('密码输入不一致。');
            return;
        }
        $.post(purl,data,function(rdata){
            if(rdata.status){
            	var url = '<?=site_url('jt_admin/admin/own_update_save')?>';
                post_status = false;
                $.post(url,data,function(data){
                    if(data.status){
                    	layer.open({content:data.msg,end:function(index){
                    	  	parent.layer.closeAll();
                    	}});         
                    }else{
                      layer.alert(data.msg);
                    }
                    post_status = true;
                },'json')
                .error(function(){ 
                    post_status = true;
                    layer.alert("提交失败！"); 
                });
            
            }else{
              layer.alert(rdata.msg);
              
            }
        },'json');
        
    }
}

function is_change(obj){
    var val = $.trim($(obj).val());
    var original = $(obj).attr('ori_data');

    if(val != original && val != ''){   //状态有变更时
        return true;
    }else{
        return false;
    }
}
function if_change_val_set_data(el_id,data){
    if(is_change('#'+el_id)){   
        data[el_id] = $.trim($('#'+el_id).val());
        data['ori_'+el_id] = $('#'+el_id).attr('ori_data');
    }
    return data;
}

$(document).ready(function() {
    ///确认保存
    $('#btn_save').on('click',function(){
        
        layer.confirm('确认保存？', {btn: ['是', '取消']},function(index){
            var id = '<?=$uID?>';
            save_data(id);
        });
    });


});
</script>

<?php Widget::load('layout_tpl',array('view'=>'footer'));?>
<?php Widget::load('layout_tpl',array('view'=>'close_body_tag'));?>