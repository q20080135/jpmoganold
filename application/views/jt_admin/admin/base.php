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
    '系统设置',
    '变量设置'
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
            <th class="text-c" width="100">网站标题</th>
            <td colspan="2">
                <input type="text"
                class="input-text radius size-MINI" id="websiteTitle" name="websiteTitle" ori_data="" value="<?php echo $websiteTitle;?>">
            </td>
            
        </tr>

        <tr>
            <th class="text-c" width="100">网站关键字</th>
            <td colspan="2">
                <input type="text"
                class="input-text radius size-MINI" id="websiteKeywork" name="websiteKeywork" ori_data="" value="<?php echo $websiteKeywork;?>">
            </td>
            
        </tr>
		<tr>
			<th class="text-c" width="100">网站描述</th>
			<td colspan="2">
                <textarea cols="50" rows="10" id="websiteDesc" name="websiteDesc"  placeholder="(内容)" maxlength="200"><?php echo $websiteDesc;?></textarea>
			</td>
			
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
        
        data['websiteDesc']= $("#websiteDesc").val();
        data['websiteTitle']= $("#websiteTitle").val();
        data['websiteKeywork']= $("#websiteKeywork").val();
        
        
        var url = '<?=site_url('jt_admin/admin/base_save')?>';

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