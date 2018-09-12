<?=res_url('icheck/jquery.icheck.min.js', 'lib')?>
<?=res_url('icheck/icheck.css', 'lib')?>
<div class="page-container">
    <form id="classify_form" action="<?=adm_url('classify/addClassifyProc')?>">
        <input type="hidden" name="cdepth" value="<?=$depth?>">
        <input type="hidden" name="cparent" value="<?=$parent?>">
        <input type="hidden" name="ctype" value="<?=$ctype['code']?>">
        <input type="hidden" name="csort" value="<?=$sort?>">
        <table class="table table-border table-bordered table-striped"> 
            <tbody>
                <tr>
                    <td colspan="2" style="color: #8e8e8e;">
                        [<?=$parent_name?>]
                        <span style="float:right">添加</span>
                    </td> 
                </tr> 
                <tr>
                    <td class="text-r" width="100">
                        <span style="color: #8e8e8e;float: left;padding-left: 3px;">└ </span>
                        <span class="c-red">*</span><?=$ctype['name']?>：
                    </td> 
                    <td><input type="text" name="cname" class="input-text radius" datatype="*" placeholder="分类名称"></td> 
                </tr> 
                <tr>
                    <td class="text-r" width="100">
                    <span class="c-red">*</span>分类类型：
                    </td> 
                    <td><input type="text" name="doc_type" class="input-text radius" datatype="*" placeholder="分类类型"></td> 
                </tr> 
                <tr>
                    <td class="text-r" width="100">
                    描述：
                    </td> 
                    <td><input type="text" name="doc_desc" class="input-text radius" placeholder="描述"></td> 
                </tr> 
                <tr>
                    <td class="text-r" width="100">
                    显示在导航栏：
                    </td> 
                    <td>
                        <div class="radio-box">
                            <input type="radio" id="isshow1" name="doc_isshow" value="1">
                            <label for="isshow1">是</label>
                        </div>
                        <div class="radio-box">
                            <input type="radio" id="isshow2" name="doc_isshow" checked value="0">
                            <label for="isshow2">否</label>
                        </div>
                    </td> 
                </tr> 
            </tbody>
        </table> 
        <div class="cl mt-10">
            <span id="btn_add_classify" class="btn btn-primary radius f-r size-S">添加</span>
        </div>
    </form>
</div>
<script>

$(document).ready(function() {

    $('.radio-box input').iCheck({
        checkboxClass: 'icheckbox-blue',
        radioClass: 'iradio-blue',
        increaseArea: '20%'
    });
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
                console.log('ok');
                layer.closeAll();
                $('.dd').add_item(data.item);
                $('.classify_right .page-container').remove();
            }else{
                layer.alert(data.msg);
            }
        }
    });
});
</script>
