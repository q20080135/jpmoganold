<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->helper('render');
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
    '文章管理',
    '添加文章'
));
?>
<?=res_url('My97DatePicker/WdatePicker.js','lib')?>
<style>
.form_dizhi {
	width: 140px;
	margin-right: 8px;
}

.textarea-numberbar {
	position: inherit;
}
.orderInfo.docs-example:after {
    content: "优化字段";
}
</style>


<div class="page-container">
	<table class="table table-border table-bordered table-striped">
		<tr>
			<th class="text-c" width="100">文章标题</th>
			<td><input type="text"
				class="input-text radius size-MINI" id="aTitle" name="aTitle" ori_data="" value="">
			</td>
			

            <th class="text-c" width="100">文章分类</th>
            <td><select class="select" size="1" id="cID" name="cID">
                    <?php foreach ($aType as $key=>$val):?>
                    <option value="<?=$val['cID']?>" selected><?=$val['cName']?></option>
                     <?php endforeach;?>
                    </select></td>
		</tr>

		<tr>
			<th class="text-c" width="100">文章描述</th>
            <td>
                <textarea cols="50" rows="10" id="aDescription" name="aDescription" placeholder="(内容)"></textarea>
            </td>
            <th class="text-c" width="100">
            图片
            </th> 
            <td>
                <?=single_image_uploader('aImg', '200', '120', array('placeholder'=>'上传产品图片','datatype'=>'*','nullmsg'=>'请添加产品图片！'))?>
            </td> 
		</tr>

        <tr>
            <th class="text-c" width="100">文章内容</th>
            <td colspan="4">
                <textarea style="width: 700px;" id="aContent" name="aContent" placeholder="(内容)"></textarea>

            </td>

        </tr>
        <tr>
            <th class="text-c" width="100">开始时间</th>
            <td colspan="4"><input type="text" style="width:185px;" class="input-text radius size-MINI" id="aAddtime" name = 'aAddtime' ori_data="" value="<?php echo date('Y-m-d h:m:s',time());?>" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',onpicked:function(dp){timeChange()}})" >
            </td>
            
        </tr>


	</table>
    <div class="codeView orderInfo docs-example">
        <table class="table table-border table-bordered table-striped">
            <tr>
                <th class="text-c" width="100">
                文章关键字
                </th> 
                <td>
                   <input type="text"
                    class="input-text radius size-MINI" id="aSeoKeywork" name="aSeoKeywork" ori_data="" value="">
                </td> 
                <th class="text-c" width="100">文章描述</th>
                <td>
                    <textarea cols="50" rows="10" id="aSeoDesc" name="aSeoDesc" ori_data="" placeholder="(内容)"></textarea>
                </td>
            </tr>
        </table>
    </div>
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
<?=res_url('ueditor/ueditor.config.js', 'lib')?>
<?=res_url('ueditor/ueditor.all.min.js', 'lib')?> 
<script>

    var ue = UE.getEditor('aContent');
// 限制只能提交一次
var post_status = true;

function save_data(){
    if(post_status) {
        layer.msg('正在提交...',{time:0});

        var data = {};

        //data['tel']= $("#tel").val();
        //data['qq']= $("#qq").val();
        data['aTitle']= $("#aTitle").val();
        data['cID']= $("#cID").val();
        data['aDescription']= $("#aDescription").val();
        data['aImg']= $("#aImg").val();
        data['aSeoDesc']= $("#aSeoDesc").val();
        data['aSeoKeywork']= $("#aSeoKeywork").val();
        data['aAddtime']= $("#aAddtime").val();
        data['aImg']= $("#aImg").val();
        data['aContent']= ue.getContent();
        if(data['aTitle']==''){
            layer.msg('请填写文章标题。');
            return;
        }
     
        
        var url = '<?=site_url('jt_admin/article/add_save')?>';

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