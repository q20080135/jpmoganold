<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('render');
Widget::load('layout_tpl',array('view'=>'pre_header','data'=>array('title'=>'文章详情')));
Widget::load('layout_tpl',array('view'=>'common_script'));
Widget::load('layout_tpl',array('view'=>'open_body_tag'));
Widget::load('breadcrumb', array('文章管理','文章详情'));
?>
<?=res_url('My97DatePicker/WdatePicker.js','lib')?>
<style>
    .form_dizhi{
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
				class="input-text radius size-MINI" id="aTitle" name="aTitle" ori_data="<?php echo $aTitle?>" value="<?php echo $aTitle?>">
			</td>
			

            <th class="text-c" width="100">文章分类</th>
            <td><select class="select" size="1" id="cID" name="cID" ori_data="<?php echo $cID?>">
                    <?php foreach ($aType as $key=>$val):?>
                    <option value="<?=$val['cID']?>" <?php echo $val['cID']==$cID?'selected="selected"':'';?>><?=$val['cName']?></option>
                     <?php endforeach;?>
                    </select></td>
		</tr>

		<tr>
			<th class="text-c" width="100">文章描述</th>
            <td>
                <textarea cols="50" rows="10" id="aDescription" name="aDescription" ori_data="<?php echo $aDescription?>" placeholder="(内容)"><?php echo $aDescription?></textarea>
                <input type="hidden" ori_data="<?php echo $aDescription?>" id ="oriaDescription">
            </td>
            <th class="text-c" width="100">
            图片
            </th> 
            <td>
                <?=single_image_uploader('aImg', '200', '120', array('placeholder'=>'上传图片','datatype'=>'*','nullmsg'=>'请添加文章图片！','ori_data'=>''.$aImg),'/upload/'.$aImg)?>
            </td> 
		</tr>

        <tr>
            <th class="text-c" width="100">文章内容</th>
            <td colspan="4">
                <textarea style="width: 700px;" id="aContent" name="aContent" placeholder="(内容)"><?php echo $aContent?></textarea>
                <input type="hidden" ori_data='<?php echo $aContent?>' id ="neirong">
            </td>

        </tr>
        <tr>
            <th class="text-c" width="100">开始时间</th>
            <td colspan="4"><input type="text" style="width:185px;" class="input-text radius size-MINI" id="aAddtime" name = 'aAddtime' ori_data="<?php echo $aAddtime?>" value="<?php echo $aAddtime?>" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',onpicked:function(dp){timeChange()}})" >
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
                        class="input-text radius size-MINI" id="aSeoKeywork" name="aSeoKeywork" ori_data="<?php echo $aSeoKeywork?>" value="<?php echo $aSeoKeywork?>">
                    </td> 
                    <th class="text-c" width="100">文章描述</th>
                    <td>
                        <textarea cols="50" rows="10" id="aSeoDesc" name="aSeoDesc" ori_data="<?php echo $aSeoDesc?>" placeholder="(内容)"><?php echo $aSeoDesc?></textarea>
                        <input type="hidden" ori_data="<?php echo $aSeoDesc?>" id ="oriaSeoDesc">
                    </td>
                </tr>
            </table>
        </div>
    <form class="form form-horizontal" >
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2 text-r">
              
                <a id="btn_save" class="btn btn-success radius"><i class="Hui-iconfont">&#xe632;</i> 保存</a>

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

function save_data(id,options){
    if(post_status) {
        layer.msg('正在提交...',{time:0});
        if(id == ''){
          layer.msg('请刷新重试一下');
          return;
        }


        var data = {
          id : id
        };
        data = if_change_val_set_data('aTitle',data);
        data = if_change_html_set_data('aDescription',data);
		data = if_change_ue_set_data('aContent',data);
        data = if_change_val_set_data('aImg',data);
        data = if_change_html_set_data('aSeoDesc',data);
        data = if_change_val_set_data('aSeoKeywork',data);
        data = if_change_val_set_data('cID',data);
        data = if_change_val_set_data('aAddtime',data);


        if(Object.keys(data).length == 1){
            layer.msg('没有可提交数据。');
            return;
        }


        var url = '<?=site_url('jt_admin/article/update_save')?>';
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

function is_change(obj){
    var val = $.trim($(obj).val());
    var original = $(obj).attr('ori_data');

    if(val != original && val != ''){   //状态有变更时
        return true;
    }else{
        return false;
    }
}

function is_change_ue(obj){
    var val = ue.getContent();
    var original = $("#neirong").attr('ori_data');
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

function if_change_html_set_data(el_id,data){
    if(is_change('#'+el_id)){   
        data[el_id] = $.trim($('#'+el_id).val());
        data['ori_'+el_id] = $('#ori'+el_id).attr('ori_data');
    }
    return data;
}

function if_change_ue_set_data(el_id,data){
    if(is_change_ue('#'+el_id)){ 
        data[el_id] = ue.getContent();
        data['ori_'+el_id] = $('#'+el_id).attr('ori_data');
    }
    return data;
}

$(document).ready(function() {
    ///确认保存
    $('#btn_save').on('click',function(){
        
        layer.confirm('确认保存？', {btn: ['是', '取消']},function(index){
            var id = '<?=$aID?>';
            save_data(id);
        });
    });


});
</script>

<?php Widget::load('layout_tpl',array('view'=>'footer'));?>
<?php Widget::load('layout_tpl',array('view'=>'close_body_tag'));?>