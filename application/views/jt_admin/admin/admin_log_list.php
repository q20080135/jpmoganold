<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Widget::load('layout_tpl',array('view'=>'pre_header','data'=>array('title'=>'系统信息')));

Widget::load('layout_tpl',array('view'=>'common_script'));?>
 
<?=res_url('jquery.smart-click.1.2.js','admin')?>
<?php

Widget::load('layout_tpl',array('view'=>'open_body_tag'));

Widget::load('breadcrumb',array('管理员管理','管理员日志列表'));
?>

<div class="page-container">
    <form method="get" class="form form-horizontal" id="form_search_list" >
    <div class="text-c"> 

        <input type="text" id="filter_uName" placeholder="账号" style="width:150px" class="input-text">
        <input type="text" id="filter_uRealName" placeholder="真实姓名" style="width:150px" class="input-text">
        <button id="btn_search" class="btn radius btn-success" ><i class="Hui-iconfont">&#xe665;</i> 查询</button>
        <a id="btn_reset" class="btn radius"> 重置</a>


    </div>
    </form>

    <div class="cl pd-5 bg-1 bk-gray mt-20"> 
        
        <span class="r iRecordsTotal">共：<strong></strong> 条</span> 
        <span class="r iRecordsDisplay">搜索：<strong></strong> 条</span> 
    </div>
    <div class="mt-20">
        <table id="data_list" width="100%" class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
                <tr class="text-c">
                    <th width="40">ID</th>
                    <th>用户名</th>
                    <th>真实姓名</th>
                    <th>操作描述</th>
                    <th width="140">操作时间</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<?=res_url('datatables/1.10.0/jquery.dataTables.min.js','lib')?>
<?=res_url('datatables/1.10.0/jquery.dataTables.plugin.js','lib')?>
<script>
$(document).ready(function() {
    var columns = [
            { name:'logId', data: 'logId',   searchable: true,   className:'text-c row_id'} 
            ,{ name:'uName', data: "uName",  searchable: false,  className:'text-c'}               //用户名
            ,{ name:'uRealName', data: "uRealName",  searchable: false,  className:'text-c'}       //真实姓名
            ,{ name:'logTitle', data: "logTitle",  searchable: false,  className:'text-c'}       //操作描述
            ,{ name:'logTime', data: "logTime",  searchable: false,  className:'text-c'}       //操作时间
        ];
    var table = $('#data_list').DataTable( {
        "processing": true,
        "serverSide": true,
        "ordering": false,
        "searching": true,

        "ajax": {
            "url": "<?=site_url('jt_admin/admin/log_list_data')?>",
            "type": "POST"
        },
        "drawCallback": function( settings ) {
            // console.log(settings);
            render_amount_info( settings ); // datatables/1.10.0/jquery.dataTables.plugin.js
        },
        "columns": columns
    });

    //查看详细
    table.on( 'draw', function () {
        $('#data_list tbody td:not(".action")').smartClick(function(){
            var id = $.trim($(this).parent('tr').find('.row_id').text());
            if(id != ''){
                // console.log(id);
                open_new_tab('<?=site_url('admin/admin_detail?id=')?>'+id,'管理员详情:'+id);
                // layer_show('订单详情','<?=site_url('admin/admin_detail?id=')?>'+id,'','620');
            }else{
                alert('订单ID不能为空');
            }
        });
    });

    filters = ['logId','uName','uRealName','logTitle'];     //搜索内容 Input ID 去除filter_
	//user，tel，qq，superior，next_num，list_num,time
    //重置时渲染初始数据
    $("#btn_reset").on('click',function(){

        // reset_filter_form 函数参照 qnick_common.js
        reset_filter_form(table,columns,filters);
    });

    $("#form_search_list").on('submit',function(){   
        // submit_search_form 函数参照 qnick_common.js

        submit_search_form(table,columns,filters);

        return false;
    });
 	
});
function passReset(id){
	layer.confirm('您确定要重置密码吗？', {
		  btn: ['确定','取消'] //按钮
		}, function(){
			$.ajax({
				url:'<?=site_url('jt_admin/admin/pass_reset')?>',
			    dataType: "json",   //返回格式为json
			    async: true, //请求是否异步，默认为异步，这也是ajax重要特性
			    data: { "id":id},    //参数值
			    type: "POST",   //请求方式
			    beforeSend: function() {
			        //请求前的处理
			    },
			    success: function(data) {
		            layer.alert(data.msg);
			    },
			    complete: function() {
			        //请求完成的处理
			    },
			    error: function() {
			        //请求出错处理
			    	layer.alert('提交失败！');
			    }
			});
		}, function(){

	});

}
</script>

<?php Widget::load('layout_tpl',array('view'=>'footer'));?>
<?php Widget::load('layout_tpl',array('view'=>'close_body_tag'));?>