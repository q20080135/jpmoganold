<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->helper('render');
Widget::load('layout_tpl', array('view'=>'pre_header','data'=>array('title'=>'订单列表')));
Widget::load('layout_tpl', array('view'=>'common_script'));
error_reporting(E_ALL & ~E_NOTICE);
?>
<link rel="stylesheet" href="<?=base_url('resource/static/LIN/css/order_info.css')?>" />

<style>
.form_dizhi {
	width: 140px;
	margin-right: 8px;
}

.textarea-numberbar {
	position: inherit;
}

.orderInfo.docs-example:after {
	content: "订单信息";
}

.productInfo.docs-example:after {
	content: "商品信息";
}

.czrz.docs-example:after {
	content: "操作日志";
}
.ordergpInfo.docs-example:after {
    content: "拼团信息";
}
.ordergpInfo img{
    width: 30px;
    height: 30px;
}
.ordergpInfo .btn{
    height: 40px;
}
.small_p_img{
    width: 100px;
    height: auto;
}

.list-group-item {
    position: relative;
    display: block;
    padding: 10px 15px;
    margin-bottom: -1px;
    background-color: #fff;
    border: 1px solid #ddd;
}
ol,ul {
    margin-top: 0; 
    margin-bottom: 0px;
}
.layui-layer-page .layui-layer-content {
    overflow: hidden;
}
.row.cl {
    margin-top: 15px;
}
</style>
<?php
Widget::load('layout_tpl', array('view'=>'open_body_tag'));

Widget::load('breadcrumb', array('订单管理','订单详情'));
?>

<div class="page-container">
    <?php if(isset($gparr)){ ?>
    <div class="codeView ordergpInfo docs-example">
        <span><?=count($gparr)?> / <?=$ptPeople?></span>
        <?php 
                foreach ($gparr as $key => $value) {
                    if($soID == $value['soID']){
                        $color = 'btn-success';
                    }else{
                        if($value['ptHead']==1){
                            $color = 'btn-warning'; 
                        }else{
                            $color = 'btn-primary';
                        }
                    }
                    if($value['mPicture']==''){
                        $value['mPicture'] = base_url('resource/static/admin/images/user-picture.png');
                    }
                    if($value['ptHead']==1){
                        echo '<div class="btn '.$color.' ml-10" attrid ="'.$value['soID'].'">团长('.$value['oBuyName'].') 
                        <img src="'.$value['mPicture'].'"></div>';
                    }else{
                        echo '<div class="btn '.$color.' ml-10" attrid ="'.$value['soID'].'">团员('.$value['oBuyName'].')
                        <img src="'.$value['mPicture'].'"></div>';
                    }
                    
                }
        ?>
        
        
    </div>
    <?php }?>
	<div class="codeView orderInfo docs-example">
        
    		<table class="table table-border table-bordered table-striped">
    			<tr>
    				<th class="text-c" width="100">订单号</th>
    				<td colspan="2"><?=$orderNum?></td>
    				<th class="text-c" width="100">订单状态</th>
    				<td>
                    <form class="form form-horizontal" id = "qifrom">        
                        <span class="select-box" style="width:140px" >
                            <select class="select" size="1" id="oStatus" name="oStatus">
                                <?php foreach ($order_state as $key => $value) {
                                $selectstr = $key==$oStatus?'selected=selected':'';
                                if($value == '未确认 , 未发货' && isset($gparr)){
                                    $value = $PinTuanStatus[$ptStatus];
                                }
                                echo '<option value="'.$key.'"  '.$selectstr.'>'.$value.'</option>';
                                }?>
                          </select>
                        </span>
                    <?=$opay_state[$oPay]?>
                    <input type="hidden" value="<?php echo $soID?>" id="soID" name = "soID">
                    </form>
                    </td>
    			</tr>
    			<tr>
    				<th class="text-c" width="100">下单时间</th>
    				<td colspan="2"><?=$oPayTime?></td>
    				<th class="text-c" width="100">付款时间</th>
    				<td><?=$oPayTime?></td>
    			</tr>
    			<tr>
    				<th class="text-c" width="100">收货人</th>
    				<td colspan="2"><?=$oBuyName?></td>
    				<th class="text-c" width="100">联系电话</th>
    				<td><?=$oBuyPhone?></td>
    			</tr>
    			<tr>
    				<th class="text-c" width="100">收货区域</th>
    				<td colspan="2"><?=$oBuyArea;?></td>
    				<th class="text-c" width="100">详细地址</th>
    				<td><?=$oBuyAddress?></td>
    			</tr>
    			<tr>
    				<th class="text-c" width="100">快递单号</th>
    				<td colspan="2"><?=$oExpressNum?></td>
    				<th class="text-c" width="100">支付详情</th>
    				<td><button id="paybtn" class="btn btn-primary size-S radius" target="_blank">查看实付数据</button>
                    <?=$payStatus?>实付金额<?=$payMoney?></td>
    			</tr>
                <tr>
                    <th class="text-c" width="100">佣金</th>
                    <td colspan="2"><?=$soPrice*($sFCPercent/100)?>(佣金分成比<?=$sFCPercent/100;?>) 
                    <?php if(!$soIsJiesuan){?>
                        <button id="btn_jiesuan" class="btn btn-primary size-S radius" target="_blank">结算佣金</button></td>
                    <?php }?>
                    
                </tr>

    		</table>
              <div class="row cl">
                  <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2 text-r">
                    <a id="btn_save" class="btn btn-success radius"><i
                      class="Hui-iconfont">&#xe632;</i> 保存</a>
                        <?php if($oType==0||($oType==1&&$ptStatus==1)):?>
                            <a href="javascript:uBusOrder(<?php echo $sId?>,<?php echo $soID?>)" class="btn btn-primary radius">查看入驻商订单</a>
                        <?php elseif($oType==1&&$ptStatus==2&&$oStatus==0):?>
                            <a href="#refund" id="refund_pt_order" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6cd;</i> 退款</a>
                        <?php endif;?>
                    

                  </div>
                </div>
        
	</div>

  
	<div class="codeView productInfo docs-example">
		<table class="table table-border table-bordered table-striped">
			<tr>
				<th class="text-c" width="100">商品图片</th>
				<th>商品名称</th>
				<th class="text-c" width="100">属性</th>
				<th>价格</th>
				<th>数量</th>
				<th>小计</th>
									
			</tr>
			<tr>
    			<?php 
        $all_p_total = 0;
        if(!empty($product))
        {
            foreach ($product as $val)
            {
                $p_img = !empty($val['gPicture']) ? $val['gPicture'] : '';
                $p_name = !empty($val['gName']) ? $val['gName'] : '';
                $p_attr = !empty($val['mcAttr']) ? $val['mcAttr'] : '';
                $p_price = !empty($val['gPrice']) ? $val['gPrice'] : '';
                $p_num = !empty($val['gNum']) ? $val['gNum'] : '';
                $p_total = (!empty($val['gNum']) && !empty($val['gPrice'])) ? ($val['gNum'] * $val['gPrice']) : '';
                $p_img = $p_img;
                
                //统计商品总价
                if(!empty($p_total))
                {
                    $all_p_total = $all_p_total + $p_total;
                }
                $all_p_total = number_format($all_p_total, 2, '.','');
                echo "<tr>";
                echo "<td class='table-title'><img class='small_p_img' src='{$p_img}' /></td>";
                echo "<td>{$p_name}</td>";
                echo "<td>{$p_attr}</td>";
                echo "<td>{$p_price}</td>";
                echo "<td class='table-title'>{$p_num}</td>";
                echo "<td class='table-title'>{$p_total}</td>";
                echo "</tr>";
            }
            
            //优惠券 (0优惠券， 1红包)
            $use_ok = false; //判断是否使用过优惠券
            $use_m = 0; //使用了多少钱的优惠券
            if(isset($coupon['hType']) && $coupon['hType'] == 0)
            {
                $umoney = !empty($coupon['hUseMoney']) ? $coupon['hUseMoney'] : 0;
                $cmoney = !empty($coupon['hMoney']) ? $coupon['hMoney'] : 0;
                if($all_p_total >= $umoney)
                {
                    $use_ok = true;
                    $use_m = $cmoney;
                }
            }
            //积分
            $jifen = $jifen/100;
            //运费金额
            $yun_money = !empty($oExpressMoney) ? $oExpressMoney : 0;
            //实收金额
            $s_total_money = $all_p_total - $use_m + $yun_money - $jifen;
            //应收金额
            $y_total_money = $all_p_total - $use_m + $yun_money - $jifen;

            echo "<tr>";
            echo "<td></td>";
            echo "<td></td>";
            echo "<td></td>";
            echo "<td></td>";
            echo "<td class='ralign'><strong>共计：</strong></td>";
            echo "<td class='table-title'><strong>{$all_p_total}</strong></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td class='td-right' style='text-align: right;padding-right:30px;' colspan='6'>";
            echo "<span class='total-title p-total-title'>商品总额</span>：<span class='total-money p-total-money'>{$all_p_total}</span>";
            if($use_ok)
            {
                echo " - <span class='total-title c-total-title' title='点击显示优惠券'><i class='icon-money'></i>优惠金额";
                
                /*----------------- start ---------------------
                 * 显示实体优惠券
                 */
                $c_stime = !empty($coupon['hStartTime']) ? $coupon['hStartTime'] : '';
                $c_etime = !empty($coupon['hSendTime']) ? $coupon['hSendTime'] : '';
                $c_stime = substr($c_stime, 0, 10);
                $c_etime = substr($c_etime, 0, 10);
                $use_m = intval($use_m);
                $umoney = intval($umoney);
                
                echo "<div class='coupon-box'  title='点击关闭优惠券'>";
                echo "<div class='left-first-row'>";
                echo "<div class='small-icon'>¥</div>";
                echo "<div class='big-money'>{$use_m}</div>";
                echo "<div class='small-txt'>满{$umoney}元使用</div>";
                echo "</div>";
                echo "<div class='left-two-row'>";
                echo "有效期 {$c_stime} - {$c_etime}";
                echo "</div>";
                echo "</div>";
                // ----------------- end ----------------------
                
                echo "</span>：<span class='total-money c-total-money'>{$use_m}</span>";
            }
            echo " + <span class='total-title y-total-title'>运费金额</span>：<span class='total-money y-total-money'>{$yun_money}</span>";
            echo " - <span class='total-title y-total-title'>积分</span>：<span class='total-money y-total-money'>{$jifen}</span>";
            echo "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td class='td-right' style='text-align: right;padding-right:30px;' colspan='6'>";
            //echo "<span class='total-title2'>应收金额</span>：<span class='total-money'>{$y_total_money}</span>";
            echo "<span class='total-title2'>实收金额</span>：<span class='total-money'>{$s_total_money}</span>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
			
			

		</table>
        <ul id="payinfo" class="list-group" style="width: 400px;display: none;">
        <?php if($payinfo){
            $total_fee = number_format($payinfo['total_fee']/100, 2, '.','');
            $s_total_money = number_format($s_total_money, 2, '.','');
                if($orderp['zps']!=$s_total_money){
                    $zPrice = '，总订单('.$orderp['zps'].')';
                    $zPrice .= '<br>订单商品金额 = '.$orderp['zp'];
                    $zPrice .= '<br>订单运费总金额 = '.$orderp['em'];
                    $zPrice .= '<br>订单优惠券总金额 = '.$orderp['coupon'];
                    $zPrice .= '<br>订单积分总金额 = '.$orderp['jifen'];
                    $zPrice .= '<br>'.
                    $orderp['zp']."+".
                    $orderp['em']."-".
                    $orderp['coupon']."-".
                    $orderp['jifen']."=".
                    $orderp['zps'];
                }else{
                    $zPrice = null;
                }
            ?>
        <li class="list-group-item">交易类型-<?=$payStatus?></li>
        <li class="list-group-item">交易时间-<?=date('Y-m-d H:i:s',strtotime($payinfo['time_end']))?>
            <?php 
                if(date('Y-m-d H:i:s',strtotime($payinfo['time_end']))==$oPayTime){
                    echo '<i class="Hui-iconfont c-green"></i>';
                }else{
                    echo '<i class="Hui-iconfont c-error"></i>';
                }
            ?>
        </li>
        <li class="list-group-item" attr1="<?php echo $total_fee;?>" attr2="<?php echo $all_p_total;?>">交易金额-<?=$total_fee.$zPrice;?>
            <?php 
                if($orderp['zps']!=$s_total_money){
                    if($total_fee==$orderp['zps']){
                        echo '<i class="Hui-iconfont c-green"></i>';
                    }else{
                        echo '<i class="Hui-iconfont c-error"></i>';
                    }  
                }else{
                    if($total_fee==($all_p_total-$jifen)){
                        echo '<i class="Hui-iconfont c-green"></i>';
                    }else{
                        echo '<i class="Hui-iconfont c-error"></i>';
                    }    
                }
                
            ?>
        </li>
        <li class="list-group-item">交易订单号-<?=$payinfo['transaction_id'];?>
            <?php 
                if($payinfo['transaction_id']==$payNum){
                    echo '<i class="Hui-iconfont c-green"></i>';
                }else{
                    echo '<i class="Hui-iconfont c-error"></i>';
                }
            ?>
        </li>
        <?php }else{?>
        <li class="list-group-item">暂无支付信息</li>
        <?php }?>
    </ul>
	</div>
	<div class="codeView czrz docs-example">
		<table class="table table-border table-bordered table-striped">
			<tr>

				<th class="text-c" width="100">操作者</th>
				<th>付款状态</th>
				<th class="text-c" width="100">订单状态</th>
				<th>备注</th>
				<th>操作时间</th>

									
			</tr>
			 <?php 
            if(!empty($log))
            {
                foreach ($log as $val)
                {
                    $c_user = !empty($val['mID']) ? $val['mID'] : '--';
                    $c_pay = (isset($val['soPay']) && $val['soPay'] >= 0) ? $pay_arr[$val['soPay']] : '--';
                    $c_state = (isset($val['soStatus']) && $val['soStatus'] >= 0) ? $state_arr[$val['soStatus']] : '--';
                    $c_mark = !empty($val['logMark']) ? $val['logMark'] : '';
                    $c_time = !empty($val['logTime']) ? $val['logTime'] : '';
                
                    echo "<tr>";
                    echo "<td>{$c_user}</td>";
                    echo "<td>{$c_pay}</td>";
                    echo "<td>{$c_state}</td>";
                    echo "<td>{$c_mark}</td>";
                    echo "<td class='table-title'>{$c_time}</td>";
                    echo "</tr>";
                }
            }
        ?>

		</table>
	</div>
    <?php //Widget::load('admin_logs',$uID);?>
</div>

<script type="text/javascript">
function uBusOrder(id,soid){
    //open_new_tab('/jt_admin/Order/uBusOrder/'+id+'/'+soid,'详情');
    layer.open({
      type: 2, 
      content: '/jt_admin/Order/uBusOrder/'+id+'/'+soid ,
      area :['100%','100%']
    }); 
}

// 限制只能提交一次
var post_status = true;
var post_goods_count = '<?php echo count($datas);?>';
var pd_gid = '<?php echo $gID;?>';
function save_data(){
    if(post_status) {
        layer.msg('正在提交...',{time:0});

        var data = {};
        data = $("#qifrom").serialize();
        var url = '<?=site_url('jt_admin/order/update_save')?>';
        post_status = false;
        $.post(url,data,function(data){
              layer.open({content:data.msg,end:function(index){
                  parent.layer.closeAll();
                  location.replace(location.href);
                  
              }});
        },'json')
        .error(function(){ 
            post_status = true;
            layer.alert("提交失败！"); 
        });
    }
}
    $(document).ready(function(){
        layer.config({
            extend: 'extend/layer.ext.js'
        });
        $('#refund_pt_order').on('click',function(){
            var url = '<?=site_url('jt_admin/order/refundPtOrder')?>'
            var data = {
                order_no: '<?=$soID?>'
            }

            layer.msg('正在提交...',{time:0});

            $.post(url,data,function(d){
                    
                if(d.status){
                    layer.alert('退款成功');
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                }else{
                  layer.alert(d.msg);
                }
            },'json')
            .error(function(){ 
                layer.alert("返回数据有误"); 
            });
        });

        $('.ordergpInfo .btn').click(function(){
            var id = $.trim($(this).attr('attrid'));
            if(id != ''){
                var nickName = $.trim($(this).find('.nickName').text());
                open_new_tab('<?=site_url('jt_admin/order/detail/')?>'+id,'订单详情:'+nickName);
            }else{
                alert('订单ID不能为空');
            }
        });
        //显示优惠券
        $(".c-total-title").click(function(){
            $(".coupon-box").show();
        });
        
        //隐藏优惠券
        $(".coupon-box").click(function(){
            $(".coupon-box").hide();
            return false;
        });

        $("#paybtn").click(function(){
            layer.open({
                type: 1,
                content: $('#payinfo'),
                area :['401','']
            });
        });

        $('#btn_save').on('click',function(){
            layer.confirm('确认保存？', {btn: ['是', '取消']},function(index){
                save_data();
            });
        });

        $('#btn_jiesuan').on('click',function(){
            var id = '<?=$soID?>';
            layer.prompt({title: '输入结算金额。', formType: 3,value:'<?=$soPrice*($sFCPercent/100)?>'}, function(rRefuseExplain, index){
                $.ajax({
                    url:'<?=site_url('jt_admin/order/commission_settlement')?>',
                    dataType: "json",   //返回格式为json
                    async: true, //请求是否异步，默认为异步，这也是ajax重要特性
                    data: {"soID":id,"csPrcie":rRefuseExplain},    //参数值
                    type: "POST",   //请求方式
                    beforeSend: function() {
                        //请求前的处理
                    },
                    success: function(data) {
                        layer.open({content:data.msg,end:function(index){
                             
                        }});     
                    },
                    complete: function() {
                        //请求完成的处理
                    },
                    error: function() {
                        //请求出错处理
                        layer.alert('提交失败！');
                    }
                });
                layer.close(index);

            });

        });
    });

        


</script>
<?php Widget::load('layout_tpl', array('view'=>'footer'));?>
<?php Widget::load('layout_tpl', array('view'=>'close_body_tag'));?>