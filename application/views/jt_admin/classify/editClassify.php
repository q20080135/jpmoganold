<?php 
$this->load->helper('render');
?>
<div class="page-container">
    <form id="classify_form" action="<?=adm_url('classify/editClassifyProc')?>">
        <input type="hidden" name="cid" value="<?=$id?>">
        <input type="hidden" name="ctype" value="<?=$ctype['code']?>">
        <input type="hidden" name="doc_id" value="<?php if(isset($cdID)){ echo $cdID;}?>">
        <table class="table table-border table-bordered table-striped"> 
            <tbody>
                <tr>
                    <td colspan="2" style="color: #8e8e8e;">
                        [<?=$parent_name?>]
                        <span style="float:right">编辑</span>
                    </td> 
                </tr>
                <tr>
                    <td class="text-r" width="100">
                        <span style="color: #8e8e8e;float: left;padding-left: 3px;">└ </span>
                        <span class="c-red">*</span><?=$ctype['name']?>：
                    </td> 
                    <td><input type="text" name="cname" class="input-text radius" datatype="*" placeholder="分类名称" value="<?=$content?>"></td> 
                </tr> 
                <?php
                if($ctype['code']==0){?>
                <tr>
                    <td class="text-r" width="100">
                   图片：
                    </td> 
                    <td>
                        <?=single_image_uploader('cdImg', '200', '120', array('placeholder'=>'上传产品图片','datatype'=>'*','nullmsg'=>'请添加产品图片！','ori_data'=>''.$cdImg),$cdImg)?>
                    </td> 
                </tr>
                <?php }?>
            </tbody>
        </table> 
        <div class="cl mt-10">
            <span id="btn_add_classify" class="btn btn-primary radius f-r size-S">保存</span>
        </div>
    </form>
</div>
<script>

$(document).ready(function() {
    $("#classify_form").Validform({
        btnSubmit:"#btn_add_classify", 
        tiptype:function(msg,i){
            if(msg){
                layer.msg(msg);
            }
        }, 
        postonce:true,
        ajaxPost:true,
        callback:function(data){
            // console.log(data);
            if(data.status){
                layer.closeAll();
                var item_obj = $(".dd [data-id='"+data.item.id+"']");
                item_obj.attr('data-content',data.item.content);
                $('.dd').reset();
                $('.classify_right .page-container').remove();
            }else{
                layer.alert(data.msg);
            }
        }
    });
});
</script>
