<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Widget::load('layout_tpl',array('view'=>'pre_header','data'=>array('title'=>'系统信息')));

Widget::load('layout_tpl',array('view'=>'common_script'));?>
<?=res_url('jquery.smart-click.1.2.js','admin')?>
<?php

Widget::load('layout_tpl',array('view'=>'open_body_tag'));

Widget::load('breadcrumb',array('管理员管理','管理员角色列表'));
?>

<div class="page-container">
    <form method="get" class="form form-horizontal" id="form_search_list" >
    <div class="text-c"> 
        <a id="btn_add" class="btn radius btn-success f-l" data-c="<?=site_url('jt_admin/admin/admin_role_edit')?>" data-t="添加角色">
        <i class="Hui-iconfont">&#xe604;</i> 
                        添加
        </a>
        <input type="text" id="filter_auName" placeholder="角色名称" style="width:150px" class="input-text">
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
                    <th>群组名</th>
                    <th>权限</th>
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
<script>
$(document).ready(function() {
    var columns = [
            { name:'auID', data: 'auID',   searchable: true,   className:'text-c row_id'} 
            ,{ name:'auName', data: "auName",  searchable: false,  className:'text-c'}               //用户名
            ,{ name:'quanxian',
                data: "sub_node", 
                className:'text-c', 
                render:function(data,type,row){
 

                    if(data != undefined){
                        var strArr = new Array();
                    	$.each(data,function(key,value){  
                    		strArr[key] =  value.mName;
                        	
                    	    //console.log("Obj :" + key + '-' + value.mName);  
                    	});
                    	var str = strArr.join(",");
                    	return str;
                    }else return '';
                }
                ,searchable: false
            } 
            ,{ name:'cz',
                data: "auID", 
                className:'text-c action', 
                render:function(data,type,row){
                    if(data != undefined){
                        var func = "javascript:open_new_tab('<?=site_url('jt_admin/admin/admin_role_edit?id=')?>"+data+"','修改:"+data+"');";
                        var funl = "javascript:del('"+data+"');";
                        return '<a href="'+func+'" class="btn btn-primary size-S radius" target="_blank">修改</a>&nbsp;'+
                        	   '<a href="'+funl+'" class="btn btn-primary size-S radius" target="_blank">删除</a>';
                    }else return '-';
                }
                ,searchable: false
            }   
        ];
    var table = $('#data_list').DataTable( {
        "processing": true,
        "serverSide": true,
        "ordering": false,
        "searching": true,
        "sPaginationType" : "full_numbers_input",
        "ajax": {
            "url": "<?=site_url('jt_admin/admin/role_list_data')?>",
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
                open_new_tab('<?=site_url('jt_admin/admin/admin_role_edit?id=')?>'+id,'角色详情:'+id);
            }else{
                alert('订单ID不能为空');
            }
        });
    });

    filters = ['auID','auName'];     //搜索内容 Input ID 去除filter_

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
function del(id){
	layer.confirm('您确定要删除角色吗？注意请先确认是否有管理员为该角色如果有将不能删除。', {
		  btn: ['确定','取消'] //按钮
		}, function(){
			$.ajax({
				url:'<?=site_url('jt_admin/admin/del_role')?>',
			    dataType: "json",   //返回格式为json
			    async: true, //请求是否异步，默认为异步，这也是ajax重要特性
			    data: { "id":id},    //参数值
			    type: "POST",   //请求方式
			    beforeSend: function() {
			        //请求前的处理
			    },
			    success: function(data) {
	            	layer.open({content:data.msg,end:function(index){
	            		 location.replace(location.href);
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
		}, function(){

	});

}
</script>

<?php Widget::load('layout_tpl',array('view'=>'footer'));?>
<?php Widget::load('layout_tpl',array('view'=>'close_body_tag'));?>