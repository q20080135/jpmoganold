<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Widget::load('layout_tpl',array('view'=>'pre_header','data'=>array('title'=>'系统信息')));

Widget::load('layout_tpl',array('view'=>'common_script'));?>
 
<?php

Widget::load('layout_tpl',array('view'=>'open_body_tag'));

Widget::load('breadcrumb',array('会员管理','会员积分'));
?>

<div class="page-container">
    <form method="get" class="form form-horizontal" id="form_search_list" >
    <div class="text-c">
        <input type="text" id="filter_mPhone" placeholder="手机号" style="width:150px" class="input-text">

        <span class="select-box" style="width:115px" >
          <select class="select" size="1" id="filter_iType">
            <option value="" selected = "selected">--类型--</option>
            <option value="0">消费</option>
            <option value="1">充值</option>
            <option value="2">购买产品赠送积分</option>
            <option value="3">注册积分</option>
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
        <table id="data_list" width="100%" class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
                <tr class="text-c">
                    <th width="40">积分ID</th>
                    <th>用户ID</th>
                    <th>手机号</th>
                    <th>管理员ID</th>
                    <th>积分点</th>
                    <th>描述</th>
                    <th>类型</th>
                    <th>时间</th>
                   <!--  <th>操作</th> --> 
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<?=res_url('datatables/1.10.0/jquery.dataTables.js','lib')?>
<?=res_url('datatables/1.10.0/jquery.dataTables.plugin.js','lib')?>
<?=res_url('jquery.smart-click.1.2.js','admin')?>
<script>
$(document).ready(function() {
    var columns = [
            { name:'iID', data: 'iID',   searchable: true,   className:'text-c row_id'} 
            ,{ name:'mID', data: "mID",  searchable: false,  className:'text-c mrow_id'}
            ,{ name:'mPhone', data: "mPhone",  searchable: false,  className:'text-c'}              
            ,{ name:'uID', data: "uID",  searchable: false,  className:'text-c'}       
            ,{ name:'payPoints', data: "payPoints",  searchable: false,  className:'text-c',render:function(data,type,row){
  
                    return (data/100);
                
            }}       
            ,{ name:'iDescribe', data: "iDescribe",  searchable: false,  className:'text-c',render:function(data,type,row){
            	if(row.iPayType==1)
                {
                    return data;
                }else
                {
                    return '-'+data; 
                }
            }}       
            ,{ name:'iType', data: "iType",  searchable: true,  className:'text-c',render:function(data,type,row){
            	if(data==0)
                {
                    return '消费';
                }else if(data==1)
                {
                    return '充值'; 
                }else if(data==2)
                {
                    return '购买产品赠送积分'; 
                }else if(data==3)
                {
                    return '注册积分'; 
                }
            }}
            ,{ name:'iAddTime', data: "iAddTime",  searchable: false,  className:'text-c'}

            /*,{ name:'cz',
                data: "mId", 
                className:'text-c', 
                render:function(data,type,row){
 

                    if(data != undefined){
                        var func = "javascript:open_new_tab('<?=site_url('jt_admin/user/user_detail?id=')?>"+data+"','查看详情:"+data+"');";
                        var funl = "javascript:passReset('"+data+"');";
                        return '<a href="'+func+'" class="btn btn-primary size-S radius" target="_blank">查看</a>&nbsp;'+
                        	   '<a href="'+funl+'" class="btn btn-primary size-S radius" target="_blank">重置密码</a>';
                    }else return '-';
                }
                ,searchable: false
            } */  
        ];
    var table = $('#data_list').DataTable( {
        "processing": true,
        "serverSide": true,
        "ordering": false,
        "searching": true,
        "sPaginationType" : "full_numbers_input",
        "ajax": {
            "url": "<?=site_url('jt_admin/integral/list_data')?>",
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
            var id = $.trim($(this).parent('tr').find('.mrow_id').text());
            if(id != ''){
                // console.log(id);
                open_new_tab('<?=site_url('jt_admin/user/user_detail?id=')?>'+id,'会员详情:'+id);
            }else{
                alert('会员ID不能为空');
            }
        });
    });

    filters = ['iID','mPhone','iType'];     //搜索内容 Input ID 去除filter_
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
    $("#btn_add").on('click',function(){
    	var data_c = $(this).attr('data-c');
    	var data_t = $(this).attr('data-t');
    	open_new_tab(data_c,data_t);
    });
});
function passReset(id){
	layer.confirm('您确定要重置密码吗？', {
		  btn: ['确定','取消'] //按钮
		}, function(){
			$.ajax({
				url:'<?=site_url('jt_admin/user/pass_reset')?>',
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