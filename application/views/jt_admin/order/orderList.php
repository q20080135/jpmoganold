<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->helper('render');
Widget::load('layout_tpl', array('view'=>'pre_header','data'=>array('title'=>'订单列表')));

Widget::load('layout_tpl', array('view'=>'common_script'));
?>
<style>
    input.filter {width: 150px;}
    #filter_aID {width: 70px;}
</style>
<?php
Widget::load('layout_tpl', array('view'=>'open_body_tag'));

Widget::load('breadcrumb', array('订单管理','订单列表'));
?>
<div class="page-container">
    <form method="get" class="form form-horizontal" id="form_search_list" >
    <div class="text-c"> 
        <?=render_list_filter($filters)?>
        <br>
        <span class="select-box" style="width:115px" >
          <select class="select" size="1" id="filter_oStatus">
            
            <option value="" selected>--订单状态--</option>
            <?php foreach ($order_state as $key => $value) {
            echo '<option value="'.$key.'">'.$value.'</option>';
            }?>
          </select>
        </span>
        <span class="select-box" style="width:125px" >
          <select class="select" size="1" id="filter_aodSoID">
            
            <option value="" selected>--代发货状态--</option>
                <option value="`not null`">是</option>
                <option value="`null`">否</option>
          </select>
        </span>
        <span class="select-box" style="width:115px" >
          <select class="select" size="1" id="filter_oPay">
            
            <option value="" selected>--付款状态--</option>
            <?php foreach ($opay_state as $key => $value) {
            echo '<option value="'.$key.'">'.$value.'</option>';
            }?>
          </select>
        </span>
        <span class="select-box" style="width:145px" >
          <select class="select" size="1" id="filter_sLevel">
            <?php echo $grade;?>
          </select>
        </span>
        <span class="select-box" style="width:125px" >
          <select class="select" size="1" id="filter_oType">
            
            <option value="" selected>--拼团订单--</option>
                <option value="1">是</option>
                <option value="0">否</option>
          </select>
        </span>
        <span class="select-box" style="width:125px" >
          <select class="select" size="1" id="filter_ptStatus">
            <option value="" selected>--拼团状态--</option>
                <option value="0">进行中</option>
                <option value="1">拼团成功</option>
                <option value="2">拼团失败</option>
          </select>
        </span>
        <button id="btn_search" class="btn radius btn-success" ><i class="Hui-iconfont">&#xe665;</i> 查询</button>
        <a id="btn_reset" class="btn radius"> 重置</a>
    </div>
    </form>

    <div class="cl pd-5 bg-1 bk-gray mt-20"> 
        <span class="r iRecordsTotal">共：<strong></strong> 条</span> 
        <span class="r iRecordsDisplay">搜索：<strong></strong> 条</span> 
    </div>
    <div class="mt-20">
        <table id="data_list" width="100%" class="table table-border table-bordered  table-striped table-bg table-hover table-sort">
            <thead>
                <tr class="text-c">
                    <th width="60">订单ID</th>
                    <th width="80">订单号</th>
                    <th width="90">用户</th>
                    <th width="190">收货人</th>
                    <th width="130">店铺</th>
                    <th width="70">店铺等级</th>
                    <th width="60">总金额</th>
                    <th width="90" url="<?=adm_url('order/updateState')?>">订单状态</th>
                    <th width="hidden"></th>
                    <th width="60">付款状态</th>
                    <th width="60">订单类型</th>
                    <th width="80">下单时间</th>
                    <th width="hidden"></th>
                    <th width="hidden"></th>
                    <th width="hidden">店铺等级id</th>
                    <th width="hidden">拼团状态</th>
                    <th width="60">操作</th>                    
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<style>
.order_product{
position: relative;
}
.info{
padding:5px;
position: absolute;
z-index: 999;
}
</style>
<?=res_url('datatables/1.10.0/jquery.dataTables.js', 'lib')?>
<?=res_url('datatables/1.10.0/jquery.dataTables.plugin.js', 'lib')?>
<?=res_url('qnick_table_list.js', 'admin')?>
<?=res_url('jquery.smart-click.1.2.js','admin')?>
<script>
function uBusOrder(id,soid){
    //open_new_tab('/jt_admin/Order/uBusOrder/'+id+'/'+soid,'详情');
    layer.open({
      type: 2, 
      content: '/jt_admin/Order/uBusOrder/'+id+'/'+soid ,
      area :['100%','100%']
    }); 
}

function render_state(val,row){
    var id = row.soID
    ,status = row.oStatus;
    
    if(status == undefined){
        status = $('#oStatus'+id).text();
    }
    if(status == '未确认 , 未发货' && row.oType == '1'){
        var ptStatus = {
            0: '<span class="c-warning">拼团中</span>'
            ,1: '<span class="c-green">拼团成功</span>'
            ,2: '<span class="c-error">拼团失败</span>'
        }
        status = ptStatus[row.ptStatus];
    }
    if(val == '`null`'){
        var action = {class:'c-green',icon:'&#xe6e1;',text:' 设置为代发货',val:'`not null`'}
    }else{
        status = status + '<br>' + '<span class="c-warning">代发货<span>';        
        var action = {class:'c-error',icon:'&#xe6a6;',text:' 取消代发货',val:'`null`'}
    }
    var data_set = [
      {text:status,val:val}      //未审核
      ,action
    ];
    return render_ajax_col(data_set,val);
}

$(document).ready(function() {
    ajax_update_col('.orderStatus .change_state',function(post_data,callback_data){        
        return render_state(post_data.val,post_data.id);
    });
    var columns = [
            { name:'soID', data: 'soID',   searchable: true,   className:'text-c row_id soID'},
            { name:'orderNum', data: 'orderNum',   searchable: true,   className:'text-c'}
            ,{ name:'mPhone',
                data: "mPhone", 
                className:'text-c', 
                render:function(data,type,row){
                    var nickName = (data == null) ? row.mPhone : data;
                    return '<span class="nickName">' + nickName + '</span><br>[' + row.mId+ ']';
                }
                ,searchable: false
            }
            ,{ name:'oBuyName',
                data: "oBuyName", 
                className:'text-c', 
                render:function(data,type,row){
                    var val = data + '[TEL: ' + row.oBuyPhone+ ']<br>';
                    val += row.oBuyArea+'<br>'+row.oBuyAddress;
                    return val;
                }
                ,searchable: false
            }
            ,{ name:'sShopName',
                data: "sShopName", 
                render:function(data,type,row){
                   
                   var text = '<div class="order_product">';
                   text += data+"<br>";
                   text += "店铺id:"+row.sId+"<br>";
                   text += "店铺账号:"+row.sName+"<br>";
                   text += '<div class="info" attr="'+row.orderNum+'"></div></div>';
                   return text;
                }
            }
            ,{ name:'sgName', data: "sgName",  searchable: false,  className:'text-c'}     //店铺等级
            ,{ name:'gPrice', data: "gPrice",  searchable: false,  className:'text-c'}  
            ,{ name:'aodSoID', data: "aodSoID",  searchable: true,  className:'text-c action orderStatus',
                render: function(data,type,row){
                    return render_state(data,row);
                }  
            }
            ,{ name:'oStatus', data: "oStatus",  searchable: true,  className:'hidden oStatus',
                render:function(data,type,row){
                    return '<span id="oStatus'+row.soID+'">'+data+'</span>';
                }  
            }
            ,{ name:'oPay', data: "oPay",  searchable: true,  className:'text-c'  } 
            ,{ name:'oType', data: "oType",  searchable: true,  className:'text-c',render:function(data,type,row){
                if(data==1){
                    return '<span class="c-blue">拼团订单</span>';
                }else{
                    return '普通订单';
                }
            }} 
            ,{ name:'oAddtime', data: "oAddtime",  searchable: false,  className:'text-c',
                render:function(data){
                    return data.replace(' ','<br>');
                }
              } 
            ,{ name:'oBuyPhone', data: "oBuyPhone",  searchable: false,  className:'text-c hidden'  }
            ,{ name:'sId', data: "sId",  searchable: false,  className:'text-c hidden'  }
            ,{ name:'sLevel', data: "sLevel",  searchable: true,  className:'text-c hidden'}     //店铺等级id
            ,{ name:'ptStatus', data: "ptStatus",  searchable: true,  className:'text-c hidden'}     //拼团状态
            
            ,{ name:'cz',
                data: "soID", 
                className:'text-c action', 
                render:function(data,type,row){
 

                    if(data != undefined&&row.oType==0){
                        var func = "javascript:uBusOrder("+row.sId+","+data+")";
                        return '<a href="'+func+'" class="btn btn-primary size-S radius" target="_blank">查看</a>&nbsp;';
                    }else if(data != undefined&&row.oType==1){
                        var func = "javascript:open_new_tab('<?=site_url('jt_admin/order/detail/')?>"+data+"','订单详情:"+data+"')";
                        return '<a href="'+func+'" class="btn btn-primary size-S radius" target="_blank">查看拼团</a>&nbsp;';
                    }else return '';
                }
                ,searchable: false
            }


        ];
    var table = $('#data_list').DataTable( {
        "processing": true,
        "serverSide": true,
        "ordering": false,
        "searching": true,
        //'pagingType': 'sPaginationType',
        "sPaginationType" : "full_numbers_input",//simple_numbers,input,full_numbers,two_button
        "ajax": {
            "url": "<?=site_url('jt_admin/order/listData')?>",
            "type": "POST"
        },
        "drawCallback": function( settings ) {
            render_amount_info( settings ); // datatables/1.10.0/jquery.dataTables.plugin.js
            // console.log(settings);
        },
        "columns": columns
    });

    //查看详细
    table.on( 'draw', function () {
        $('#data_list tbody td:not(".action")').smartClick(function(){
            var id = $.trim($(this).parent('tr').find('.row_id').text());
            if(id != ''){
                var nickName = $.trim($(this).find('.nickName').text());
                open_new_tab('<?=site_url('jt_admin/order/detail/')?>'+id,'订单详情:'+nickName);
            }else{
                alert('订单ID不能为空');
            }
        });
    });

    filters = <?=json_encode(array_keys($filters))?>;     //搜索内容 Input ID 去除filter_
    filters.push('oStatus');
    filters.push('oPay');
    filters.push('aodSoID');
    filters.push('sLevel');
    filters.push('oType');
    filters.push('ptStatus');
    set_fiter(table,columns,filters);
    /*console.log(table);*/
    //悬停出现产品
    
    $(document).on("mouseenter",".order_product",function(){
    	$id = $(this).find('.info').attr("attr");
    	var info = $(this).find('.info');
		$.ajax({
			url:'<?=site_url('jt_admin/order/getProduct')?>',
		    dataType: "text",   //返回格式为json
		    async: true, //请求是否异步，默认为异步，这也是ajax重要特性
		    data: { "id":$id},    //参数值
		    type: "POST",   //请求方式

		    success: function(data) {

		    	info.html(data);
		    }
		});

        // 对齐逻辑
        var docWidth = $(document).width();
        var thisX = $(this).parent('td').offset().left;
        var infoBox = $(this).find('.info');
        var boxWidth = 800;
        var containerPadding = $(this).parents('.page-container').css('padding');
        containerPadding = Number(containerPadding.replace(/[^0-9]+/ig,""))*2;
        // console.log('containerPadding:'+containerPadding);
        var infoWidth = ((docWidth<boxWidth) ? docWidth : boxWidth) - containerPadding ;
        var infoLeft = (docWidth - containerPadding - infoWidth)/4*3 - thisX ;        
        infoBox.css({
            'width': infoWidth,
            'left': infoLeft,
        });
        // //对齐逻辑

    	$(this).find('.info').show();
       
    });
    $(document).on("mouseleave",".order_product",function(){  
    	$(this).find('.info').hide();  
       
    });
});
</script>

<?php Widget::load('layout_tpl', array('view'=>'footer'));?>
<?php Widget::load('layout_tpl', array('view'=>'close_body_tag'));?>