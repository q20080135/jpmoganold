<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Widget::load('layout_tpl',array('view'=>'pre_header','data'=>array('title'=>'JPMogan后台管理')));
Widget::load('layout_tpl',array('view'=>'header'));
Widget::load('layout_tpl',array('view'=>'aside',$menu));?>
<section class="Hui-article-box">
	<div id="Hui-tabNav" class="Hui-tabNav hidden-xs">
		<div class="Hui-tabNav-wp">
			<ul id="min_title_list" class="acrossTab cl">
				<li class="active"><span title="系统信息" data-href="system/info">系统信息</span><em></em></li>
			</ul>
		</div>
		<div class="Hui-tabNav-more btn-group"><a id="js-tabNav-prev" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d4;</i></a><a id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d7;</i></a></div>
	</div>
	<div id="iframe_box" class="Hui-article">
		<div class="show_iframe">
			<div style="display:none" class="loading"></div>
			<!-- <iframe scrolling="yes" frameborder="0" src="<?=site_url('jt_admin/dashboard')?>"></iframe> -->
		</div>
	</div>
</section>
<?php Widget::load('layout_tpl',array('view'=>'common_script'));?>

<script type="text/javascript">

auto_load_tab();
/*资讯-添加*/
function article_add(title,url){
    var index = layer.open({
        type: 2,
        title: title,
        content: url
    });
    layer.full(index);
}
/*图片-添加*/
function picture_add(title,url){
    var index = layer.open({
        type: 2,
        title: title,
        content: url
    });
    layer.full(index);
}
/*产品-添加*/
function product_add(title,url){
    var index = layer.open({
        type: 2,
        title: title,
        content: url
    });
    layer.full(index);
}
/*用户-添加*/
function member_add(title,url,w,h){
    layer_show(title,url,w,h);
}

/*退出*/
function logout(){
    location.href = '<?=site_url('jt_admin/auth/adminLogout')?>';
}
</script> 
<?php Widget::load('layout_tpl',array('view'=>'close_body_tag'));?>