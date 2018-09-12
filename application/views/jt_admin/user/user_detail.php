<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Widget::load('layout_tpl',array('view'=>'pre_header','data'=>array('title'=>'系统信息')));

Widget::load('layout_tpl',array('view'=>'common_script'));
Widget::load('layout_tpl',array('view'=>'open_body_tag'));
Widget::load('breadcrumb',array('会员管理','会员详情'));
?>
<style>
    .form_dizhi{
        width: 140px;
        margin-right: 8px;
    }
    .textarea-numberbar {
        position: inherit;
    }

    .byqr.docs-example:after {
        content: "被邀请人";
    }

    .jfxq.docs-example:after {
        content: "积分详情";
    }
    .docs-example{
        padding: 39px 19px 60px;
        margin: 52px 0;
    }

</style>


<div class="page-container">
        <table class="table table-border table-bordered table-striped">
            <tr>
                <th class="text-c" width="100">用户名</th>
                <td  colspan="2">
					<?=$mName?>
                </td>    
   				<th class="text-c" width="100">昵称</th>
                <td>
                    <input type="text" class="input-text radius size-MINI" id="mNickName" ori_data="<?=$mNickName?>" value="<?=$mNickName?>">
                </td>  
            </tr>
            <tr>
                <th class="text-c" width="100">电话</th>
                <td  colspan="2">
					<input type="text" class="input-text radius size-MINI" id="mPhone" ori_data="<?=$mPhone?>" value="<?=$mPhone?>">
                </td>    
   				<th class="text-c" width="100">性别</th>
                <td>
                  <select class="select" size="1" id="group" name="group" ori_data="<?=$mSex?>">
                        <option value="1" <?=($mSex==1)?"selected":"";?>>男</option>
                        <option value="0" <?=($mSex==0)?"selected":"";?>>女</option>

                        </select>
                </td>   
            </tr>
            <tr>
                <th class="text-c" width="100">会员状态</th>
                <td  colspan="2">
					<?=$mStatus?>
                </td>    
   				<th class="text-c" width="100">会员来源</th>
                <td>
                    <?=$mSource?>
                </td>  
            </tr>
            <tr>
                <th class="text-c" width="100">邀请人</th>
                <td  colspan="2">
					<?=$mParentId?>
                </td>    
   				<th class="text-c" width="100">会员余额</th>
                <td>
                    <?=$mBalance?>
                </td>  
            </tr>
            <tr>
                <th class="text-c" width="100">会员积分</th>
                <td  colspan="2">
					<?=$mIntegral/100?>
                </td>    
   				<th class="text-c" width="100">会员邮箱</th>
                <td>
                    <input type="text" class="input-text radius size-MINI" id="mEmail" ori_data="<?=$mEmail?>" value="<?=$mEmail?>">
                </td>  
            </tr>
            <tr>
                <th class="text-c" width="100">省市区</th>
                <td  colspan="2">
					<input type="text" class="input-text radius size-MINI" id="uRealName" ori_data="<?=$mNickName?>" value="<?=$mNickName?>">
                </td>    
   				<th class="text-c" width="100">详细地址</th>
                <td>
                    <?=$mAddress?>
                </td>  
            </tr>
            <tr>
                <th class="text-c" width="100">会员生日</th>
                <td  colspan="2">
					<?=$mBirthday?>
                </td>    
   				<th class="text-c" width="100">加入时间</th>
                <td>
                    <?=$mAddTime?>
                </td>  
            </tr>
            <tr>
                <th class="text-c" width="100">用户等级</th>
                <td  colspan="2">
					<?=$mgID?>
                </td>    
   				<th class="text-c" width="100">邮箱验证状态</th>
                <td>
                    <?=$mEmailVerification?>
                </td>  
            </tr>
            <tr>
                <th class="text-c" width="100">添加IP</th>
                <td  colspan="4">
					<?=$mAddIp?>
                </td>    

            </tr>


        </table>

        <form class="form form-horizontal" >
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2 text-r">
              
                <a id="btn_save" class="btn btn-success radius"><i class="Hui-iconfont">&#xe632;</i> 保存</a>

            </div>
        </div>

        </form>
    <div class="codeView jfxq docs-example">
        <form method="get" class="form form-horizontal" id="form_search_list" action="<?=site_url('jt_admin/user/integral_list_data')?>">
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

    <div class="codeView byqr docs-example">

         <form method="get" class="form form-horizontal" id="iform_search_list" action="<?=site_url('jt_admin/user/invitation_list_data')?>">
        <div class="text-c">
            <input type="text" id="filter_invBeinvited" placeholder="用户ID" style="width:150px" class="input-text">
            <button id="ibtn_search" class="btn radius btn-success" ><i class="Hui-iconfont">&#xe665;</i> 查询</button>
            <a id="ibtn_reset" class="btn radius"> 重置</a>


        </div>
        </form>
        <div class="mt-20">
            <table id="i_data_list" width="100%" class="table table-border table-bordered table-bg table-hover table-sort">
                <thead>
                    <tr class="text-c">
                        <th width="hidden">ID</th>
                        <th>用户ID</th>
                        <th>手机号</th>
                        <th>邀请级别</th>
                        <th>注册IP</th>
                        <th>注册时间</th>
                        <th>积分</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <table  class="table table-border table-bordered table-bg table-hover table-sort">
                <tr class="text-c">
                    <th>一级总人数</th>
                    <th>二级总人数</th>
                    <th>三级总人数</th>
                    <th>总人数</th>
                    <th>一级总积分</th>
                    <th>二级总积分</th>
                    <th>三级总积分</th>
                    <th>总积分</th>
                </tr>
                <tr>
                    <th><?php echo $yzrs?></th>
                    <th><?php echo $ezrs?></th>
                    <th><?php echo $szrs?></th>
                    <th><?php echo $zrs?></th>
                    <th><?php echo $yzjf['he']?></th>
                    <th><?php echo $ezjf['he']?></th>
                    <th><?php echo $szjf['he']?></th>
                    <th><?php echo $zjf?></th>
                </tr>
            </table>
        </div>
    </div>
    <?//Widget::load('admin_logs',$uID);?>
</div>

<?=res_url('Validform/5.3.2/Validform.min.js','lib')?>
<?=res_url('datatables/1.10.0/jquery.dataTables.js','lib')?>
<?=res_url('datatables/1.10.0/jquery.dataTables.plugin.js','lib')?>
<?=res_url('jquery.smart-click.1.2.js','admin')?>
<script>
    var columns = [
            { name:'iID', data: 'iID',   searchable: true,   className:'text-c row_id'} 
            ,{ name:'mID', data: "mID",  searchable: false,  className:'text-c'}
            ,{ name:'mPhone', data: "mPhone",  searchable: false,  className:'text-c'}              
            ,{ name:'uID', data: "uID",  searchable: false,  className:'text-c'}       
            ,{ name:'payPoints', data: "payPoints",  searchable: false,  className:'text-c'}       
            ,{ name:'iDescribe', data: "iDescribe",  searchable: false,  className:'text-c',render:function(data,type,row){
                if(row.iPayType==1)
                {
                    return data;
                }else
                {
                    return '-'+data; 
                }
            }}       
            ,{ name:'iType', data: "iType",  searchable: false,  className:'text-c',render:function(data,type,row){
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
            "url": "<?=site_url('jt_admin/user/integral_list_data')?>",
            "type": "POST",
            "data":{"user_id":"<?=$mId?>"}
        },
        "drawCallback": function( settings ) {
            // console.log(settings);
            render_amount_info( settings ); // datatables/1.10.0/jquery.dataTables.plugin.js
        },
        "columns": columns
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






    var icolumns = [
            { name:'invID', data: 'invID',   searchable: true,   className:'text-c row_id'} 
            ,{ name:'invBeinvited', data: "invBeinvited",  searchable: false,  className:'text-c'}
            ,{ name:'mPhone', data: "mPhone",  searchable: true,  className:'text-c'}
            ,{ name:'invLevel', data: "invLevel",  searchable: false,  className:'text-c',render:function(data,type,row){
                if(data==1)
                {
                    return '一级';
                }else if(data==2)
                {
                    return '二级'; 
                }else if(data==3)
                {
                    return '三级'; 
                }else
                {
                    return '其他'; 
                }
            }}
            
            ,{ name:'invIP', data: "invIP",  searchable: false,  className:'text-c'}

            ,{ name:'invAddTime', data: "invAddTime",  searchable: false,  className:'text-c'}
            ,{ name:'invIntegral', data: "invIntegral",  searchable: false,  className:'text-c'}

        ];
        var itable = $('#i_data_list').DataTable( {
        "processing": true,
        "serverSide": true,
        "ordering": false,
        "searching": true,
        "sPaginationType" : "full_numbers_input",
        "ajax": {
            "url": "<?=site_url('jt_admin/user/invitation_list_data')?>",
            "type": "POST",
            "data":{"user_id":"<?=$mId?>"}
        },
        "drawCallback": function( settings ) {
            // console.log(settings);
            render_amount_info( settings ); // datatables/1.10.0/jquery.dataTables.plugin.js
        },
        "columns": icolumns
    });

    ifilters = ['invID','invBeinvited'];     //搜索内容 Input ID 去除filter_
    //user，tel，qq，superior，next_num，list_num,time
    //重置时渲染初始数据
    $("#ibtn_reset").on('click',function(){

        // reset_filter_form 函数参照 qnick_common.js
        reset_filter_form(itable,icolumns,ifilters);
    });

    $("#iform_search_list").on('submit',function(){   
        // submit_search_form 函数参照 qnick_common.js

        submit_search_form(itable,icolumns,ifilters);

        return false;
    });


// 限制只能提交一次
var post_status = true;

function save_data(id,options){
    if(post_status) {
        layer.msg('正在提交...',{time:0});
        if(id == ''){
          layer.msg('请刷新重试一下');
          return;
        }


        var data = {
          id : id
        };
        data = if_change_val_set_data('mNickName',data);
        data = if_change_val_set_data('mPhone',data);
        data = if_change_val_set_data('mEmail',data);
        data = if_change_val_set_data('group',data);

        console.log(data);
        if(Object.keys(data).length == 1){
            layer.msg('没有可提交数据。');
            return;
        }


        var url = '<?=site_url('jt_admin/user/update_save')?>';
        post_status = false;
        $.post(url,data,function(data){
           
            if(data.status){
            	layer.open({content:data.msg,end:function(index){
            	  	parent.layer.closeAll();
            	}});    
              //location.reload();
            }else{
              layer.alert(data.msg);
            }
            post_status = true;
        },'json')
        .error(function(){ 
            post_status = true;
            layer.alert("提交失败！"); 
        });
    }
}

function is_change(obj){
    var val = $.trim($(obj).val());
    var original = $(obj).attr('ori_data');

    if(val != original && val != ''){   //状态有变更时
        return true;
    }else{
        return false;
    }
}
function if_change_val_set_data(el_id,data){
    if(is_change('#'+el_id)){   
        data[el_id] = $.trim($('#'+el_id).val());
        data['ori_'+el_id] = $('#'+el_id).attr('ori_data');
    }
    return data;
}

$(document).ready(function() {
    ///确认保存
    $('#btn_save').on('click',function(){
        
        layer.confirm('确认保存？', {btn: ['是', '取消']},function(index){
            var id = '<?=$mId?>';
            save_data(id);
        });
    });

});
</script>

<?php Widget::load('layout_tpl',array('view'=>'footer'));?>
<?php Widget::load('layout_tpl',array('view'=>'close_body_tag'));?>