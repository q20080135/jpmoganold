<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Widget::load('layout_tpl',array('view'=>'pre_header','data'=>array('title'=>'系统信息')));

Widget::load('layout_tpl',array('view'=>'common_script'));?>
 
<?=res_url('jquery.smart-click.1.2.js','admin')?>
<?php

Widget::load('layout_tpl',array('view'=>'open_body_tag'));

Widget::load('breadcrumb',array('客户留言','留言列表'));
?>

<div class="page-container">
    <form method="get" class="form form-horizontal" id="form_search_list" >
    <div class="text-c"> 

      <!--   <a id="btn_add" class="btn radius btn-success f-l" data-c="<?=site_url('jt_admin/admin/admin_add')?>" data-t="添加管理员">
        <i class="Hui-iconfont">&#xe604;</i> 
                        添加
        </a> -->
        <input type="text" id="filter_lName" placeholder="留言人姓名" style="width:150px" class="input-text">
        <input type="text" id="filter_lPhone" placeholder="留言人电话" style="width:150px" class="input-text">
        <input type="text" id="filter_lEmail" placeholder="留言人邮箱" style="width:150px" class="input-text">
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
                    <th>留言人姓名</th>
                    <th>留言人电话</th>
                    <th>留言人邮箱</th>
                    <th url="<?=adm_url('liuyan/updateType')?>">处理状态</th>
                    <th>客户留言</th>
                    <th>添加时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<?=res_url('datatables/1.10.0/jquery.dataTables.js', 'lib')?>
<?=res_url('datatables/1.10.0/jquery.dataTables.plugin.js','lib')?>
<?=res_url('qnick_table_list.js?5', 'admin')?>
<script>


// ajax方式 更改状态 【其他使用方法参照 static/admin/js/qnick_table_list.js】
ajax_update_col(function(post_data){
    return render_liuyan(post_data.val);
});
$(document).ready(function() {
    var columns = [
             { name:'lID', data: 'lID',   searchable: true,   className:'text-c row_id'} 
            ,{ name:'lName', data: "lName",  searchable: true,  className:'text-c'}              
            ,{ name:'lPhone', data: "lPhone",  searchable: true,  className:'text-c'}              
            ,{ name:'lEmail', data: "lEmail",  searchable: true,  className:'text-c'}              
            ,{ name:'lType', data: "lType",  searchable: true,  className:'text-c',render:function(data,type,row){
                     return render_liuyan(data);
                }    
             }  
            ,{ name:'lMessage', data: "lMessage",  searchable: false,  className:'text-c'}    
            ,{ name:'lAddtime', data: "lAddtime",  searchable: false,  className:'text-c'}    
            ,{ name:'cz',
                data: "lID", 
                className:'text-c action', 
                render:function(data,type,row){
 

                    if(data != undefined){
                        var funl = "javascript:del('"+data+"');";
                        return '<a href="'+funl+'" class="btn btn-primary size-S radius" target="_blank">删除</a>';
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
            "url": "<?=site_url('jt_admin/liuyan/list_data')?>",
            "type": "POST"
        },
        "drawCallback": function( settings ) {
            // console.log(settings);
            render_amount_info( settings ); // datatables/1.10.0/jquery.dataTables.plugin.js
        },
        "columns": columns
    });


    filters = ['lID','lName'];     //搜索内容 Input ID 去除filter_
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
function del(id){
    layer.confirm('您确定要删除该留言吗？', {
          btn: ['确定','取消'] //按钮
        }, function(){
            $.ajax({
                url:'<?=site_url('jt_admin/liuyan/logic_del')?>',
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