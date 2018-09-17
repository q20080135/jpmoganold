<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Widget::load('layout_tpl',array('view'=>'pre_header','data'=>array('title'=>'系统信息')));

Widget::load('layout_tpl',array('view'=>'common_script'));?>
 
<?php

Widget::load('layout_tpl',array('view'=>'open_body_tag'));

Widget::load('breadcrumb',array('客服Service','问题列表'));
?>
<div class="page-container">
    <form method="get" class="form form-horizontal" id="form_search_list" >
    <div class="text-c"> 

        <input type="text" id="filter_xName" placeholder="姓名" style="width:150px" class="input-text">
        <input type="text" id="filter_xPhone" placeholder="手机号" style="width:150px" class="input-text">
        <input type="text" id="filter_xEmail" placeholder="邮箱" style="width:150px" class="input-text">
        <input type="text" id="filter_xUser" placeholder="账号" style="width:150px" class="input-text">
        <input type="text" id="filter_xMt4User" placeholder="mt4账号" style="width:150px" class="input-text">
        <span class="select-box" style="width:115px" >
          <select class="select" size="1" id="filter_xStatus">
            <option value="" selected>--处理状态--</option>
            <option value="0">未处理</option>
            <option value="1">已处理</option>
            <option value="2">暂不处理</option>
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
                    <th width="40">ID</th>
                    <th>问题类别</th>
                    <th>问题标题</th>
                    <th>问题描述</th>
                    <th>您的姓名</th>
                    <th>客户端账号</th>
                    <th>mt4账号</th>
                    <th>联系手机</th>
                    <th>联系邮箱</th>
                    <th>处理状态</th>
                    <th>处理结果</th>
                    <th>问题图片</th>
                    <th>提问时间</th>

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
function photos(str){

    var imgs = str.split(",");
    var imgstr = '';
    for (var i=0;i<imgs.length;i++)
    {
        imgstr += '{"src":"/upload/'+imgs[i]+'"}';
        if(i<imgs.length-1){
            imgstr+=',';
        }
    }
    //调用示例
    layer.photos({
      photos: $.parseJSON('{"data": ['+imgstr+']}')
      ,anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
    }); 

}






$(document).ready(function() {
    var columns = [
            { name:'xId', data: 'xId',   searchable: true,   className:'text-c row_id'} 
            ,{ name:'xType', data: "xType",  searchable: true,  className:'text-c',render:function(data,type,row){
                //1 出入金问题 2用户账户问题 3技术类问题 4活动类问题 5其他资讯类
                if(data == 1){
                    data = '出入金问题';
                }else if(data == 2){
                    data = '用户账户问题';
                }else if(data == 3){
                    data = '技术类问题';
                }else if(data == 4){
                    data = '活动类问题';
                }else if(data == 5){
                    data = '其他资讯类';
                }
                return data;
            }} 
            ,{ name:'xTitle', data: "xTitle",  searchable: true,  className:'text-c'} 
            ,{ name:'xDescribe', data: "xDescribe",  searchable: true,  className:'text-c',render:function(data,type,row){
                var ydata = data;
                if(data.length>15){
                    data = data.substring(0,15)+'';
                }
                data = '<div title="'+ydata+'" class="show_data" rsdata="'+ydata+'" id="'+row.xId+'">'+data+' <a href="javascript:void();" style="float:right" class="btn btn-primary size-S radius">详情</a></div>';
                return data;
            }} 
            ,{ name:'xName', data: "xName",  searchable: true,  className:'text-c'} 
            ,{ name:'xUser', data: "xUser",  searchable: true,  className:'text-c'} 
            ,{ name:'xMt4User', data: "xMt4User",  searchable: true,  className:'text-c'} 
            ,{ name:'xPhone', data: "xPhone",  searchable: true,  className:'text-c'} 
            ,{ name:'xEmail', data: "xEmail",  searchable: true,  className:'text-c'} 
            ,{ name:'xStatus', data: "xStatus",  searchable: true,  className:'text-c',render:function(data,type,row){
                var str = '';
                if(data==1){
                    str = '已处理';
                }else if(data==2){
                    str = '暂不处理';
                }else{
                    str = '未处理';
                }
                return str;
            }} 
            ,{ name:'xBeizhu', data: "xBeizhu",  searchable: true,  className:'text-c'} 
            ,{ name:'xImg', data: "xImg",  searchable: true,  className:'text-c',render:function(data,type,row){
                if(data!=null){
                    var str = '<div  onclick="photos(\''+data+'\')"><i class="Hui-iconfont">&#xe665;</i></div>';
                }else{
                    var str = '';
                }
                
               
                return str;
            }} 
            ,{ name:'xAddTime', data: "xAddTime",  searchable: false,  className:'text-c'} 
            ,{ name:'cz',
                data: "xId", 
                className:'text-c action', 
                render:function(data,type,row){
                    if(data != undefined){
                        var func = "javascript:chuli('"+data+"',1);";
                        var funl = "javascript:chuli('"+data+"',2);";
                        return '<a href="'+func+'" class="btn btn-primary size-S radius" target="_blank">处理</a>&nbsp;'+
                        	   '<a href="'+funl+'" class="btn btn-primary size-S radius" target="_blank">暂不处理</a>';
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
            "url": "<?=site_url('jt_admin/xiaozhi/list_data')?>",
            "type": "POST"
        },
        "drawCallback": function( settings ) {
            // console.log(settings);
            render_amount_info( settings ); // datatables/1.10.0/jquery.dataTables.plugin.js
        },
        "columns": columns
    });

    filters = ['xId','xName','xStatus','xEmail','xPhone'];     //搜索内容 Input ID 去除filter_
    set_fiter(table,columns,filters);
	//user，tel，qq，superior，next_num，list_num,time
    //重置时渲染初始数据

 	
});
function chuli(id,status){


layer.open({
title:'处理备注',
  content: '<textarea cols="50" rows="10" id="xBeizhu" name="xBeizhu" placeholder="(内容)"></textarea>'
  ,btn: ['确定', '取消']
  ,yes: function(index, layero){

    $.ajax({
                url:'<?=site_url('jt_admin/xiaozhi/beizhu')?>',
                dataType: "json",   //返回格式为json
                async: true, //请求是否异步，默认为异步，这也是ajax重要特性
                data: { "id":id,"xBeizhu":$('#xBeizhu').val(),'xStatus':status},    //参数值
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
    
  }
});
}
$(document).on('click',".show_data",function(){
    layer.alert($(this).attr('rsdata'));
});
</script>

<?php Widget::load('layout_tpl',array('view'=>'footer'));?>
<?php Widget::load('layout_tpl',array('view'=>'close_body_tag'));?>