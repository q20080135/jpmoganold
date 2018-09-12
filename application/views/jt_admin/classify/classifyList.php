<?php
defined('BASEPATH') or exit('No direct script access allowed');
Widget::load('layout_tpl', array('view'=>'pre_header','data'=>array('title'=>$ctype['name'])));

Widget::load('layout_tpl', array('view'=>'common_script'));?>
<?=res_url('Validform/5.3.2/Validform.min.js', 'lib')?>
<?=res_url('nestable/jquery.nestable.js', 'lib')?>
<?=res_url('nestable/jquery.qnick_classify.nestable.plugin.js?5', 'lib')?>
<?=res_url('nestable/style.css', 'lib')?>
<style>
    .classify_left{
        width: 340px;
        min-height: 500px;
        overflow: hidden;
    }
    .classify_right{
        /*background: #fc9;*/
        display: inline-block;
        vertical-align: top;
        position: absolute;
        top: 84px;
        bottom: 135px;
        right: 10px;
        left: 340px;
        /*visibility:hidden;*/
    }
</style>
<?php Widget::load('layout_tpl', array('view'=>'open_body_tag'));

Widget::load('breadcrumb', array('分类管理',$ctype['name']));
?> 
<div class="classify_left">
    <div class="page-container ml-20">  
        <div class="cl mb-10 btn_action_group invisible">
            <span class="btn btn-primary radius size-S" id="btn_expand_all">
                <i class="Hui-iconfont">&#xe600;</i>打开所有</span>
            <span class="btn btn-primary radius size-S" id="btn_collapse_all">
                <i class="Hui-iconfont">&#xe6a1;</i>关闭所有</span>
            <span class="btn btn-success radius size-S btn_add_class f-r btn_add_class_top invisible"><i class="Hui-iconfont">&#xe600;</i>添加</span>
        </div>
        <div class="cl">
            <div class="dd_wraper"> 
                <div class="dd"></div>
            </div> 
        </div>
        <div class="cl mt-10">
            <span class="btn btn-success radius size-S btn_add_class"><i class="Hui-iconfont">&#xe600;</i>添加</span>
            <span class="btn btn-primary radius f-r size-S btn_save_classify invisible">保存</span>
        </div>
    </div>
    <ul id="classify_data" class="hidden">
        <?php foreach ($data as $v) :?>
        <li><?=json_encode($v)?></li>
        <?php endforeach;?>
    </ul>
    
</div> 
<div class="classify_right">
    <!-- 输入区域 -->
</div>
<script> 
var ctype = '<?=$ctype_key?>';
function strToJson(str){    //如果是string格式的json转换为json格式，不是json格式返回 true
    try {
        return (new Function("return " + str))(); 
    } catch (e) {
        return {'status':true};
    }
    
} 
$(document).ready(function() {
    var dd = $('.dd').qnick_classify(); 

    dd.on('click_add_item',function(e,parent_id){
        // var test = {id: test_id++, content: "vvvv", depth: "3", parent: "21"};
        // $('.dd').add_item(test);
        layer.msg('正在加载...',{time:0});
        
        var url = '<?=adm_url('classify/addClassify')?>';
        var order = $(dd).get_last_order_seq(parent_id)+1;
        var depth = $(dd).get_next_depth(parent_id); 
        var parent_name = $(".dd [data-id='"+parent_id+"']").attr('data-content');

        data = {
            ctype : ctype
            ,sort : order
            ,parent : parent_id
            ,depth : depth
            ,parent_name : parent_name
        }
        $.post(url,data,function(data){
            layer.closeAll();
            json_data = strToJson(data);
            if(json_data.status){
                $('.classify_right').html(data);  
            }else{
                if(json_data.msg == undefined){
                    layer.msg('加载失败！!');
                }else{
                    layer.alert(json_data.msg);
                }
            }
        });
    });
    dd.on('click_edit_item',function(e,item_id){
        layer.msg('正在加载...',{time:0});

        var url = '<?=adm_url('classify/editClassify')?>';
        var content = $(".dd [data-id='"+item_id+"']").attr('data-content');
        var parent_id = $(".dd [data-id='"+item_id+"']").attr('data-parent');
        var parent_name = $(".dd [data-id='"+parent_id+"']").attr('data-content');
        data = {
            id : item_id
            ,content : content
            ,ctype : ctype
            ,parent_name : parent_name
        }
        if(ctype == 'doc'){
            var doc_type = $(".dd [data-id='"+item_id+"']").attr('data-doc_type');
            var doc_desc = $(".dd [data-id='"+item_id+"']").attr('data-doc_desc');
            var doc_isshow = $(".dd [data-id='"+item_id+"']").attr('data-doc_isshow');
            var doc_id = $(".dd [data-id='"+item_id+"']").attr('data-doc_id');
            data['doc_type'] = doc_type;
            data['doc_desc'] = doc_desc;
            data['doc_isshow'] = doc_isshow;
            data['doc_id'] = doc_id;
        }
        $.post(url,data,function(data){
            layer.closeAll();

            json_data = strToJson(data);
            if(json_data.status){
                $('.classify_right').html(data);  
            }else{
                if(json_data.msg == undefined){
                    layer.msg('加载失败！!');
                }else{
                    layer.alert(json_data.msg);
                }
            }
        });
    });
    dd.on('click_delete_item',function(e,item_data){

        var item_obj = $(".dd [data-id='"+item_data.id+"']");
        var delete_item = [];
        delete_item.push(item_obj.attr('data-id'));
        item_obj.find('li.dd-item').each(function(){
            delete_item.push($(this).attr('data-id'));
        });
        var url = '<?=adm_url('classify/deleteClassifyProc')?>';
        
        data = {
            ids : delete_item
            ,ctype : ctype
        }
        $.post(url,data,function(data){
            if(data.status){
                item_obj.remove();                
            }else{
                if(data.msg == undefined){
                    layer.msg('删除失败！!');
                }else{
                    layer.alert(data.msg);
                }
            }
        },'json')
        .error(function(){ 
            post_status = true;
            layer.alert("提交失败！"); 
        });
    });

    // 保存排序
    dd.on('save_classify',function(e,change_items){
        
        var url = '<?=adm_url('classify/saveClassifyProc')?>';
        
        data = {
            change_items : change_items
        }
        $.post(url,data,function(data){
            if(data.status){         
                location.reload();
            }else{
                if(data.msg == undefined){
                    layer.msg('保存失败！!');
                }else{
                    layer.alert(data.msg);
                }
            }
        },'json');
    });

    // 加载数据之后自定义显示功能
    dd.on('reset_item',function(e,item){
        var content = $(item).attr('data-content');
        // content += ' depth:'+ $(item).attr('data-depth');
        // content += ' ori_dep:'+ $(item).attr('data-ori_depth');
        $(item).children('.dd-content').children('span.dd-text').text(content);
        // $(item).attr('data-content',content);
        
        if(ctype == 'doc'){
            var doc_type = $(item).attr('data-doc_type');
            var doc_isshow = $(item).attr('data-doc_isshow');
            if(doc_isshow == 1) {
                doc_isshow = '<i class="Hui-iconfont pr-5 c-green">&#xe6a7;</i>';  //显示
            }else{
                doc_isshow = '<i class="Hui-iconfont pr-5 c-error">&#xe6a6;</i>'; //隐藏
            }
            
            var d_text = $(item).children('.dd-content').children('span.dd-text');
            
            d_text.html(doc_isshow + content + ' - [' + doc_type + ']');
        }
    });

    //必须先绑定reset_item事件之后添加数据；
    $('#classify_data li').each(function(i,e){
        var data = $(this).text();
        data = $.parseJSON(data);
        $(dd).add_item(data);
    });
    $('#classify_data').remove();


    //添加分类到顶层
    $('.btn_add_class').on('click',function(){
        layer.msg('正在加载...',{time:0});
        var url = '<?=adm_url('classify/addClassify')?>';
        var order = $(dd).get_last_order_seq()+1;
        // console.log(order);
        data = {
            ctype : ctype
            ,csort : order
        }
        $.post(url,data,function(data){
            layer.closeAll();
            json_data = strToJson(data);
            if(json_data.status){
                $('.classify_right').html(data);  
            }else{
                if(json_data.msg == undefined){
                    layer.msg('加载失败！!');
                }else{
                    layer.alert(json_data.msg);
                }
            }
        });
    });

    
});
</script>

<?php Widget::load('layout_tpl', array('view'=>'footer'));?>
<?php Widget::load('layout_tpl', array('view'=>'close_body_tag'));?>