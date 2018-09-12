<?php
defined('BASEPATH') or exit('No direct script access allowed');
Widget::load('layout_tpl', array(
    'view' => 'pre_header',
    'data' => array(
        'title' => '系统信息'
    )
));

Widget::load('layout_tpl', array(
    'view' => 'common_script'
));
Widget::load('layout_tpl', array(
    'view' => 'open_body_tag'
));
Widget::load('breadcrumb', array(
    '管理员管理',
    '添加管理员'
));
?>
<style>
.form_dizhi {
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
			<td colspan="2"><input type="text"
				class="input-text radius size-MINI" id="uName" ori_data="" value="">
			</td>
			<th class="text-c" width="100">姓名</th>
			<td><input type="text" class="input-text radius size-MINI"
				id="uRealName" ori_data="" value=""></td>
		</tr>

		<!-- 
                      <tr>
                <th class="text-c" width="100">电话</th>
                <td colspan="2">
                    <input type="text" class="input-text radius size-MINI" id="tel" ori_data="" value="">
                </td> 
                <th class="text-c" width="100">QQ</th>
                <td>
                    <input type="text" class="input-text radius size-MINI" id="qq" ori_data="" value="">
                </td>   
            </tr>
             -->
		<tr>
			<th class="text-c" width="100">密码</th>
			<td colspan="2"><input type="password"
				class="input-text radius size-MINI" style="width: 80px;" id="uPwd"
				ori_data="" value=""></td>
			<th class="text-c" width="100">确认密码</th>
			<td><input type="password" class="input-text radius size-MINI"
				style="width: 80px;" id="qrpwd" ori_data="" value=""></td>
		</tr>

		<tr>
			<th class="text-c" width="100">角色</th>
			<td colspan="4"><select class="select" size="1" id="group" name="group">
                    <?php foreach ($data as $key=>$val):?>
                    <option value="<?=$val['auID']?>" selected><?=$val['auName']?></option>
                     <?php endforeach;?>
                    </select></td>

		</tr>



	</table>
	<form class="form form-horizontal">
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2 text-r">

				<a id="btn_save" class="btn btn-success radius"><i
					class="Hui-iconfont">&#xe632;</i> 保存</a>

			</div>
		</div>

	</form>

</div>

<?=res_url('Validform/5.3.2/Validform.min.js','lib')?>
<script>
// 限制只能提交一次
var post_status = true;

function save_data(){
    if(post_status) {
        layer.msg('正在提交...',{time:0});

        var data = {};

        //data['tel']= $("#tel").val();
        //data['qq']= $("#qq").val();
        data['uName']= $("#uName").val();
        data['uRealName']= $("#uRealName").val();
        data['uPwd']= $("#uPwd").val();
        data['qrpwd']= $("#qrpwd").val();
        data['group']= $("#group").val();
        if(data['uName'].length<6){
            layer.msg('请填写长度大于6的用户名。');
            return;
        }
        if(data['qrpwd']!=data['uPwd']){
            layer.msg('密码输入不一致。');
            return;
        }
        
        var url = '<?=site_url('jt_admin/admin/add_save')?>';

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
    }
}


$(document).ready(function() {
    ///确认保存
    $('#btn_save').on('click',function(){
        
        layer.confirm('确认保存？', {btn: ['是', '取消']},function(index){
            save_data();
        });
    });


});
</script>

<?php Widget::load('layout_tpl',array('view'=>'footer'));?>
<?php Widget::load('layout_tpl',array('view'=>'close_body_tag'));?>