<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->helper('render');
Widget::load('layout_tpl', array('view'=>'pre_header','data'=>array('title'=>'文章列表')));

Widget::load('layout_tpl', array('view'=>'common_script'));
?>
<?=res_url('jquery.smart-click.1.2.js','admin')?>
<style>
    #filter_aID {width: 70px;}
</style>
<?php
Widget::load('layout_tpl', array('view'=>'open_body_tag'));

Widget::load('breadcrumb', array('文章管理','文章列表'));
?>
<div class="page-container">
    <form method="get" class="form form-horizontal" id="form_search_list" >
    <div class="text-c"> 
        <a id="btn_add" class="btn radius btn-success f-l" data-c="<?=site_url('jt_admin/article/article_add')?>" data-t="添加文章">
        <i class="Hui-iconfont">&#xe604;</i> 
                        添加文章
        </a>
        <?=render_list_filter($filters)?>
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
                   <!--  <th width="60" url="<?=adm_url('article/updateHot')?>">热门</th> -->
                    <th width="390">文章标题</th>
                    <th width="90">文章分类</th>
                    <th width="90">管理员</th>
                    <th width="60" url="<?=adm_url('article/updateView')?>">是否显示</th>
                    <th width="60" url="<?=adm_url('article/updateRecom')?>">首页显示</th>
                    <th width="240">添加/发布日期</th>
                    <th width="hidden"></th>
                    <th width="70">操作</th>
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
<script>
    $("#btn_add").on('click',function(){
        var data_c = $(this).attr('data-c');
        var data_t = $(this).attr('data-t');
        open_new_tab(data_c,data_t);
    });
// ajax方式 更改状态 【其他使用方法参照 static/admin/js/qnick_table_list.js】
ajax_update_col();

$(document).ready(function() {
    var columns = [

            { name:'aID', data: 'aID',   searchable: true,   className:'text-c row_id'}
           /* ,{ name:'aIsHot',
                data: "aIsHot", 
                className:'text-c normal action', 
                render:function(data,type,row){
                    return render_flag(data);
                }
                ,searchable: false
            }*/
            ,{ name:'aTitle', data: "aTitle",  searchable: false,  className:'text-c'}     //标题
            ,{ name:'cName', data: "cName",  searchable: false,  className:'text-c'  }           //分类
            ,{ name:'uId',
                data: "uId", 
                className:'text-c normal', 
                render:function(data,type,row){
                    return row.uRealName+'['+data+']';
                }
                ,searchable: false
            }
            ,{ name:'aIsView',
                data: "aIsView", 
                className:'text-c normal action', 
                render:function(data,type,row){
                    return render_flag(data);
                }
                ,searchable: false
            }           //是否显示
            ,{ name:'aIsRecommend',
                data: "aIsRecommend", 
                className:'text-c normal action', 
                render:function(data,type,row){
                    return render_flag(data);
                }
                ,searchable: false
            }
           ,{ name:'aAddtime', data: "aAddtime",  searchable: false,  className:'text-c'  }           //分类
           ,{ name:'uRealName', data: "uRealName",  searchable: false,  className:'text-c hidden'  }           //分类
            ,{ name:'aID',
                data: "aID", 
                className:'text-c normal action', 
                render:function(data,type,row){
                        var func = "javascript:open_new_tab('<?=site_url('jt_admin/article/detail?id=')?>"+data+"','查看:"+data+"');";
                        var funl = "javascript:del('"+data+"');";
                        return '<a href="'+func+'" class="btn btn-primary size-S radius" target="_blank">查看</a>&nbsp;'+
                               '<a href="'+funl+'" class="btn btn-primary size-S radius" target="_blank">删除</a>';



                    return ('操作');
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
            "url": "<?=site_url('jt_admin/article/listData')?>",
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
                open_new_tab('<?=site_url('jt_admin/article/detail?id=')?>'+id,'文章详情:'+id);
                // layer_show('订单详情','<?=site_url('jt_admin/article/detail?id=')?>'+id,'','620');
            }else{
                alert('文章ID不能为空');
            }
        });
    });

    filters = <?=json_encode(array_keys($filters))?>;     //搜索内容 Input ID 去除filter_
    set_fiter(table,columns,filters);
});


function del(id){
    layer.confirm('您确定要删除文章吗？', {
          btn: ['确定','取消'] //按钮
        }, function(){
            $.ajax({
                url:'<?=site_url('jt_admin/article/del_article')?>',
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

<?php Widget::load('layout_tpl', array('view'=>'footer'));?>
<?php Widget::load('layout_tpl', array('view'=>'close_body_tag'));?>