
 <div id="send_express_form_<?=$id?>" class="widget">

    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-2 text-r">快递名称：</label>
        <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                <?foreach ($express_list as $k => $v):?>
                  <div class="radio-box">
                    <input type="radio" id="express_form<?=$id?>_radio<?=$k?>" name="kd" <?=($k ==$kd)?'checked':''?> value="<?=$k?>">
                    <label for="express_form<?=$id?>_radio<?=$k?>"><?=$v?></label>
                  </div>
                <?endforeach;?>
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-2 text-r">快递单号：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="text" class="input-text" style="width:200px" value="<?=$dh?>" placeholder="请输入快递单号" id="send_express_form_<?$id?>_dh" name="dh">
            <a id="btn_delivery_<?=$id?>" class="ml-10 btn btn-primary radius" ><i class="Hui-iconfont">&#xe669;</i> 发货</a>
            <p class="mt-10 c-999">发货功能描述：自动将订单状态改为已发货并<span style="color:#ffa6a6">记录备注和留言,不保存其他信息</span></p>
        </div>
    </div>
 </div>
<?=res_url('icheck/icheck.css','lib')?>
<?=res_url('icheck/jquery.icheck.min.js','lib')?>
<script>
$(function(){
    $('.skin-minimal input').iCheck({
        checkboxClass: 'icheckbox-blue',
        radioClass: 'iradio-blue',
        increaseArea: '20%'
    });
});
$(document).ready(function() {
    $('#btn_delivery_<?=$id?>').on('click',function(){
        var id = '<?=$id?>';
        if(id == ''){
          layer.msg('没有订单号，请刷新重试一下');
          return;
        }
        if(!$.isNumeric(id)){
          layer.msg('订单号格式错误！');
          return;
        }
        var kd = $.trim($("[name='kd']:checked").val());
        if(kd == ''){
          layer.msg('请选择快递名称');
          return;
        }
        var dh = $.trim($('#send_express_form_<?$id?>_dh').val());
        if(dh == ''){
          layer.msg('请输入订单号');
          return;
        }
        if(!$.isNumeric(dh)){
          layer.msg('订单号格式不正确');
          return;
        }


        var url = '<?=site_url('order/add_delivery_no')?>';
        var data = {
          id : id
          ,dh : dh
          ,kd : kd
        };

        //  添加，修改，删除 留言和备注
        var liuyan = $.trim($('#liuyan').val());
        var ori_liuyan = $('#liuyan').attr('ori_data');
        var beizhu = $.trim($('#beizhu').val());
        var ori_beizhu = $('#beizhu').attr('ori_data');
        if(liuyan != ori_liuyan){
            data.liuyan = liuyan;
            data.ori_liuyan = ori_liuyan;
        }
        if(beizhu != ori_beizhu){
            data.beizhu = beizhu;
            data.ori_beizhu = ori_beizhu;
        }


        $.post(url,data,function(data){
            console.log(data);
            if(data.status){
              location.reload();
            }else{
              layer.alert(data.msg);
            }
        },'json').error(function(){ layer.alert("提交失败！"); });
      
    });
});
</script>