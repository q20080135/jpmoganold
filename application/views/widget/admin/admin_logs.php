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
 <div id="admin_order_logs_<?=$uID?>" class="widget">
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-2 text-r">历史记录：</label>
        <div class="formControls col-xs-8 col-sm-9 grid">
            <?foreach($logs as $k => $v):?>
            <div class="log_item">
              <p>
                <span class="title"><?=$v['logTitle']?></span>
                <span class="user_id"><?=$v['uRealName'].'('.$v['uID'].')'?></span>
              <span class="log_time"><?=$v['logTime']?></span>
              </p>
                <? 
                  $log_data = unserialize($v['logData']);
                  unset($log_data['id']);
                  if(is_array($log_data)){
                    foreach ($log_data as $k => $val) {
                      if(!$log_data[$k]) unset($log_data[$k]);
                    }
                  }
                ?>
              <? if($log_data):?>
              <?if ($v['logTitle']=="还没有想到很好的展现形式"):?>
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
              </div>
               <?endif;?>
              <?endif;?>

                
            </div>
            <?endforeach;?>
        </div>
    </div>
 </div>