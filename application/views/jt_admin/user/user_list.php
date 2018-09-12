<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Widget::load('layout_tpl',array('view'=>'pre_header','data'=>array('title'=>'系统信息')));

Widget::load('layout_tpl',array('view'=>'common_script'));?>
 
<?php

Widget::load('layout_tpl',array('view'=>'open_body_tag'));

Widget::load('breadcrumb',array('会员管理','会员列表'));
?>

<div class="page-container">
    <form method="get" class="form form-horizontal" id="form_search_list" >
    <div class="text-c"> 

        <input type="text" id="filter_mName" placeholder="用户名" style="width:150px" class="input-text">
        <input type="text" id="filter_mPhone" placeholder="手机号" style="width:150px" class="input-text">
        <input type="text" id="filter_mNickName" placeholder="昵称" style="width:150px" class="input-text">
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
                    <th>昵称</th>
                    <th>性别</th>
                    <th>电话</th>
                    <th>余额</th>
                    <th>积分</th>
                    <th>使用积分</th>
                    <th>注册时间</th>
                    <th>会员等级</th>
                    <th>操作</th> 
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<?=res_url('datatables/1.10.0/jquery.dataTables.js','lib')?>
<?=res_url('datatables/1.10.0/jquery.dataTables.plugin.js','lib')?>
<?=res_url('qnick_table_list.js', 'admin')?>
<?=res_url('jquery.smart-click.1.2.js','admin')?>
<script>
$(document).ready(function() {
    var columns = [
            { name:'mId', data: 'mId',   searchable: true,   className:'text-c row_id'} 
            ,{ name:'mName', data: "mName",  searchable: true,  className:'text-c'}               //用户名
            ,{ name:'mNickName', data: "mNickName",  searchable: true,  className:'text-c'}       //昵称
            ,{ name:'mSex', data: "mSex",  searchable: true,  className:'text-c'}       //昵称
            ,{ name:'mPhone', data: "mPhone",  searchable: true,  className:'text-c'}       //昵称
            ,{ name:'mBalance', data: "mBalance",  searchable: true,  className:'text-c'}       //昵称
            ,{ name:'mIntegral', data: "mIntegral",  searchable: true,  className:'text-c',render:function(data,type,row){
                
                    return data/100;
                
            }}
            ,{ name:'useSumPayPoints', data: "useSumPayPoints",  searchable: true,  className:'text-c',render:function(data,type,row){
                
                    return data/100;
                
            }}
            ,{ name:'mAddTime', data: "mAddTime",  searchable: false,  className:'text-c'}       //昵称
            ,{ name:'mgID', data: "mgID",  searchable: false,  className:'text-c'}       //昵称

            ,{ name:'cz',
                data: "mId", 
                className:'text-c action', 
                render:function(data,type,row){
 

                    if(data != undefined){
                        var func = "javascript:open_new_tab('<?=site_url('jt_admin/user/user_detail?id=')?>"+data+"','查看详情:"+data+"');";
                        var funl = "javascript:passReset('"+data+"');";
                        var funi = "javascript:open_new_tab('<?=site_url('jt_admin/integral/integral_add?mId=')?>"+data+"','添加积分:"+data+"');";
                        return '<a href="'+func+'" class="btn btn-primary size-S radius" target="_blank">查看</a>&nbsp;'+
                        	   '<a href="'+funl+'" class="btn btn-primary size-S radius" target="_blank">重置密码</a>&nbsp;'+
                        	   '<a href="'+funi+'" class="btn btn-primary size-S radius" target="_blank">添加积分</a>';
                    }else return '-';
                }
                ,searchable: false
            }   
        ];
    var table = $('#data_list').DataTable( {
        "processing": true,
        "serverSide": true,
        "ordering": true,
        "searching": true,
        "sPaginationType" : "full_numbers_input",
        "ajax": {
            "url": "<?=site_url('jt_admin/user/list_data')?>",
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
                open_new_tab('<?=site_url('jt_admin/user/user_detail?id=')?>'+id,'会员详情:'+id);
            }else{
                alert('会员ID不能为空');
            }
        });
    });

    filters = ['mId','mName','mNickName','mPhone'];     //搜索内容 Input ID 去除filter_
    set_fiter(table,columns,filters);
	//user，tel，qq，superior，next_num，list_num,time
    //重置时渲染初始数据

 	
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