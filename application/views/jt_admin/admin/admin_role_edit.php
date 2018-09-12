<?php
defined('BASEPATH') or exit('No direct script access allowed');
Widget::load('layout_tpl', array(
    'view' => 'pre_header',
    'data' => array(
        'title' => '系统信息'
    )
));

Widget::load('layout_tpl', array(
    'view' => 'common_script'
));
Widget::load('layout_tpl', array(
    'view' => 'open_body_tag'
));
Widget::load('breadcrumb', array(
    '管理员管理',
    $title
));
?>
<style>
.form_dizhi {
	width: 140px;
	margin-right: 8px;
}

.textarea-numberbar {
	position: inherit;
}

.Huifold .item {
	position: relative
}

.Huifold .item h4 {
	margin: 0;
	font-weight: bold;
	position: relative;
	border-top: 1px solid #fff;
	font-size: 15px;
	line-height: 22px;
	padding: 7px 10px;
	background-color: #eee;
	cursor: pointer;
	padding-right: 30px
}

.Huifold .item h4 b {
	position: absolute;
	display: block;
	cursor: pointer;
	right: 10px;
	top: 7px;
	width: 16px;
	height: 16px;
	text-align: center;
	color: #666
}

.Huifold .item .info {
	display: none;
	padding: 10px
}
.info ul li {
    display: inline-block;
    margin-right: 20px;
}
</style>


<div class="page-container">
	<form id="form" class="form form-horizontal">
		<table class="table table-border table-bordered table-striped">
			<tr>
				<th class="text-c" width="100">组名称</th>
				<td colspan="2"><input type="hidden" name="auID" id="auID"
					ori_data="" value="<?=isset($data['auID'])?$data['auID']:"";?>"> <input
					type="text" class="input-text radius size-MINI" name="auName"
					id="auName" ori_data=""
					value="<?=isset($data['auName'])?$data['auName']:"";?>"></td>
			</tr>
			<tr>
				<th class="text-c" width="100"><a class="btn btn-default radius" id="cboxall">全选</a></th>
				<td colspan="2">
					<ul id="Huifold1" class="Huifold">

    <?php
    foreach ($menu as $key => $val) :
        ?>  <li class="item">
							<h4><?php echo $val['mName'];?>&nbsp;<input id=""
									name="menu_checkbox[]" class="rolecheck" type="checkbox"
									<?php if(isset($data['menu'])){echo in_array($val['mID'],$data['menu'])?'checked="checked"':'';};?>
									value="<?=$val['mID']?>"><b>-</b>
							</h4>
							<div class="info"  style="display:block;">
								<ul> 
		                    <?php foreach ($val['sub_node'] as $k=>$v):?>
		                                  <li>
		                   				<?php echo $v['mName'];?>
		                   				<input id=""  class="rolecheck" name="menu_checkbox[]"
										type="checkbox"
										<?php if(isset($data['menu'])){echo in_array($v['mID'],$data['menu'])?'checked="checked"':'';};?>
										value="<?=$v['mID']?>"></li>
		                   				
                   			<?php endforeach;?>
                   			</ul>
							</div>
						</li>
                    <?php endforeach;?>

                    
</ul>





				</td>

			</tr>





		</table>

		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2 text-r">

				<a id="btn_save" class="btn btn-success radius"><i
					class="Hui-iconfont">&#xe632;</i> 保存</a>

			</div>
		</div>

	</form>

</div>

<?=res_url('Validform/5.3.2/Validform.min.js','lib')?>

<script>
// 限制只能提交一次
var post_status = true;

function save_data(){
    if(post_status) {
        layer.msg('正在提交...',{time:0});



        var data = $("#form").serialize();
        
        var url = '<?=site_url('jt_admin/admin/role_add_save')?>';

        post_status = false;
        $.post(url,data,function(data){
            if(data.status){
            	layer.open({content:data.msg,end:function(index){
            	  	parent.layer.closeAll();
            	}});     
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
jQuery.Huifold = function(obj,obj_c,speed,obj_type,Event){
	if(obj_type == 2){
		$(obj+":first").find("b").html("-");
		$(obj_c+":first").show();
	}
	$(obj).bind(Event,function(){
		if($(this).next().is(":visible")){
			if(obj_type == 2){
				return false;
			}
			else{
				$(this).next().slideUp(speed).end().removeClass("selected");
				$(this).find("b").html("+");
			}
		}
		else{
			if(obj_type == 3){
				$(this).next().slideDown(speed).end().addClass("selected");
				$(this).find("b").html("-");
			}else{
				$(obj_c).slideUp(speed);
				$(obj).removeClass("selected");
				$(obj).find("b").html("+");
				$(this).next().slideDown(speed).end().addClass("selected");
				$(this).find("b").html("-");
			}
		}
	});
}

$(document).ready(function() {

	$.Huifold("#Huifold1 .item h4","#Huifold1 .item .info","fast",3,"click"); /*5个参数顺序不可打乱，分别是：相应区,隐藏显示的内容,速度,类型,事件*/
    ///确认保存
    $('#btn_save').on('click',function(){
        
        layer.confirm('确认保存？', {btn: ['是', '取消']},function(index){
            save_data();
        });
    });
    $("input[name^='menu_checkbox']").click(function(event){
    	event.stopPropagation();
        if($(this).parent().get(0).tagName=="H4"){
            $(this).parent().parent().find("input[name^='menu_checkbox']").prop("checked",$(this).is(':checked'));
        }else{
            if($(this).is(':checked')){
            	$(this).parent().parent().parent().parent().find("H4 input[name^='menu_checkbox']").prop("checked",true);
            }else{
            	if($(this).parent().parent().parent().find("input[type='checkbox']:checked").length==0){
            		$(this).parent().parent().parent().parent().find("H4 input[name^='menu_checkbox']").prop("checked",false);
                }
            }
        }
    });
    var pdall = true;
    $("#cboxall").click(function(e){
    	$(".rolecheck").prop("checked",pdall);
    	pdall = !pdall;
    })
});
</script>

<?php Widget::load('layout_tpl',array('view'=>'footer'));?>
<?php Widget::load('layout_tpl',array('view'=>'close_body_tag'));?>