<?php
defined('BASEPATH') or exit('No direct script access allowed');
Widget::load('layout_tpl', array('view'=>'pre_header','data'=>array('title'=>'标签审核')));

Widget::load('layout_tpl', array('view'=>'common_script'));
Widget::load('layout_tpl', array('view'=>'open_body_tag'));

Widget::load('breadcrumb', array('商品管理','标签审核'));
?>

<div class="page-container"> 
    <form method="get" class="form form-horizontal" id="form_search_list" >
    <div class="text-c"> 
        <input type="text" id="filter_tID" placeholder=" ID" style="width:150px" class="input-text">
        <input type="text" id="filter_tName" placeholder=" 标签名称" style="width:150px" class="input-text">
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
                    <th width="40">ID</th>
                    <th>标签名称</th>
                    <th width="70" url='<?=adm_url('tag/updateAuditing')?>'>审核</th>
                    <th width="70" url='<?=adm_url('tag/updateDel')?>'>删除</th> 
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<?=res_url('datatables/1.10.0/jquery.dataTables.js', 'lib')?>
<?=res_url('datatables/1.10.0/jquery.dataTables.plugin.js', 'lib')?>
<?=res_url('qnick_table_list.js', 'admin')?>
<?=res_url('jquery.smart-click.1.2.js','admin')?>
<script>
  
// ajax方式 更改状态 【其他使用方法参照 static/admin/js/qnick_table_list.js】
ajax_update_col(); 


$(document).ready(function() {
    var columns = [
            { name:'tID', data: 'tID',   searchable: true,   className:'text-c row_id'}
            ,{ name:'tName', data: "tName",  searchable: false,  className:'text-c'}  
            ,{ name:'tAuditing',
                data: "tAuditing", 
                className:'text-c auditing action', 
                render:function(data,type,row){
                    return render_flag(data);
                }
                ,searchable: false
            }
            ,{ name:'tDel',
                data: "tDel", 
                className:'text-c delete action', 
                render:function(data,type,row){
                    return render_flag(data);
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
            "url": "<?=site_url('jt_admin/tag/listData')?>",
            "type": "POST"
        },
        "drawCallback": function( settings ) {
            // console.log(settings);
            render_amount_info( settings ); // datatables/1.10.0/jquery.dataTables.plugin.js
        },
        "columns": columns
    });

    //查看详细
    // table.on( 'draw', function () {
    //     $('#data_list tbody td:not(".action")').smartClick(function(){
    //         var id = $.trim($(this).parent('tr').find('.row_id').text());
    //         if(id != ''){
    //             // console.log(id);
    //             open_new_tab('<?=site_url('jt_admin/product/detail?id=')?>'+id,'商品详情:'+id);
    //             // layer_show('订单详情','<?=site_url('jt_admin/product/detail?id=')?>'+id,'','620');
    //         }else{
    //             alert('ID不能为空');
    //         }
    //     });

    // });

    filters = ['tID','tName'];     //搜索内容 Input ID 去除filter_ 
    
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
</script>

<?php Widget::load('layout_tpl',array('view'=>'footer'));?>
<?php Widget::load('layout_tpl',array('view'=>'close_body_tag'));?>