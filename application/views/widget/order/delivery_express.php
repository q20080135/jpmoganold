
 <div id="delivery_express_<?=$id?>" class="widget">

    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-2 text-r">快递信息：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <span class="kd_name"><?=$kd_name?></span>
            <span id="delivery_express<?=$id?>_dh" class="ml-10 dh btn-link">快递单号：<?=$dh?></span>
            <?if(isset($zt) && $zt == '2'):?>
            <a id="btn_caiwu_<?=$id?>" class="ml-10 btn btn-primary radius" > 确认已签收</a>
            <a id="btn_rejected_<?=$id?>" class="ml-10 btn btn-warning radius" > 拒收</a>
            <?endif;?>
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-2 text-r">发货时间：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <span class="fh_time"><?=$fh_time?></span>
        </div>
    </div>
 </div>
<script>
$(document).ready(function() {

    // 限制只能提交一次
    var post_status = true;

    //查看物流信息
    $('#delivery_express<?=$id?>_dh').on('click',function(){
        layer_show('物流信息','http://m.kuaidi100.com/index_all.html?postid=<?=$dh?>','430','');
    });

    ///确认已签收
    $('#btn_caiwu_<?=$id?>').on('click',function(){
        layer.confirm('确定已签收了么？', {btn: ['是', '取消']},function(index){
            
            var id = '<?=$id?>';
            var options = {zt:3};
            //  save_data 函数位置： zhegeshihoutaidizhia/v2/application/views/order/order_detail.php 
            save_data(id,options);
        });
    });

    ///拒收
    $('#btn_rejected_<?=$id?>').on('click',function(){
        layer.confirm('确定拒收吗？', {btn: ['是', '取消']},function(index){

            var id = '<?=$id?>';
            var options = {zt:7};
            //  save_data 函数位置： zhegeshihoutaidizhia/v2/application/views/order/order_detail.php 
            save_data(id,options);
        });
    });

});
</script>