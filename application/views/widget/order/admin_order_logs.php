<style>
.log_item .log_time {
    color: #aaa;    
    float: right;
    padding-right: 13px;
    font-size: 12px;
}
.log_item {
    border-bottom: 1px solid #ccc;
    margin-bottom: 15px;
    width:90%;
}
.log_item .user_id {
    font-size: 13px;
    margin-left: 10px;
    color: #777;
}
.log_item .title {
    font-weight: bold;
}
.msg {
    margin: 9px 8px;
    background: #e6f2ff;
    padding: 4px 9px;
    border-radius: 4px;
}
span.new:before {
    content: ' => ';
}

span.new {
    margin-right: 10px;
}
span.original:after {
}
span.original {
    color: #aaa;
    text-decoration: line-through;
    margin-right: 6px;
}
</style>
 <div id="admin_order_logs_<?=$id?>" class="widget">
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-2 text-r">历史记录：</label>
        <div class="formControls col-xs-8 col-sm-9 grid">
            <!-- 已返款日志 -->
            <?if(isset($payback_log)):?>
            <?foreach($payback_log as $k => $v):?>
            <? 
              $log_data = unserialize($v['log_data']);
            ?>
            <?if(isset($log_data['id']) && in_array($order_id, $log_data['id'])):?>
            <div class="log_item">
              <p>
                <span class="title">批量返款</span>
                <span class="user_id"><?=$v['name'].'('.$v['user_id'].')'?></span>
              <span class="log_time"><?=$v['log_time']?></span>
              </p> 
            </div>
            <?endif;?>
            <?endforeach;?>
            <?endif;?>
            <!-- //已返款日志 -->

            <?foreach($logs as $k => $v):?>
            <div class="log_item">
              <p>
                <span class="title"><?=$v['log_title']?></span>
                <span class="user_id"><?=$v['name'].'('.$v['user_id'].')'?></span>
              <span class="log_time"><?=$v['log_time']?></span>
              </p>
                <? 
                  $log_data = unserialize($v['log_data']);
                  unset($log_data['id']);
                  if(is_array($log_data)){
                    foreach ($log_data as $k => $v) {
                      if(!$log_data[$k]) unset($log_data[$k]);
                    }
                  }
                ?>
              <? if($log_data):?>
              <div class="msg">
                <?
                 // print_r($log_items);?>
                <?foreach ($log_items as $k => $v):?>
                  <?if (isset($log_data[$k])) :?>
                  <p>
                    <label class="c-666"><?=$v?>：</label>
                    <?if (isset($log_data['ori_'.$k])) :?>
                    <span class="original"><?=$log_data['ori_'.$k]?></span>
                    <?endif;?>
                    <span class="<?=(isset($log_data['ori_'.$k]))?'new':''?>"><?=$log_data[$k]?></span>
                  </p>
                  <?endif;?>
                <?endforeach;?>

                <?if (isset($log_data['zt']) && isset($order_state[$log_data['zt']])):?>
                <p><label class="c-666">状态：</label><?=$order_state[$log_data['zt']]?></p>
                <?endif;?>
                
                <?if (isset($log_data['dh']) && isset($log_data['kd']) && isset($express_list[$log_data['kd']])):?>
                <p><label class="c-666">快递信息：</label>【<?=$express_list[$log_data['kd']]?>】<?=$log_data['dh']?></p>
                <?endif;?>

              </div>
              <?endif;?>

                
            </div>
            <?endforeach;?>
        </div>
    </div>
 </div>
<?=res_url('isotope.pkgd.min.js','lib')?>
<script>
$(document).ready(function() {
    var $grid = $('.grid').isotope({  //按时间排序
      getSortData: {
        log_time: '.log_time'
      }
      ,sortBy: [ 'log_time']
      ,sortAscending: false
    });
});
</script>