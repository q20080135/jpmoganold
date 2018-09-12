<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>境掏土特产-家乡的味道</title>
	<?=res_url('main.sprite.css')?>
	<script>
		var setPosition = function(){			
			var h=document.documentElement.clientHeight;
			el=document.getElementById('wraper');
			var wraperHeight = 367;
			var mt = h - wraperHeight;
			if(mt > 0){
				mt = mt/8*2;
			}
			el.style.marginTop=mt+"px";
		}
		window.onresize = function() {
	        setPosition();
	    };
		//第二版入驻商提示
		var secondSystemAlert = function() {
			alert('需整体升级后才能进入!\n配套的后台、APP、接口等数据必须全部统一');
		};
	</script>
</head>
<body>
	<div id="wraper">		
		<div class="logo"></div>
		<div id="btn_set">
			<a href="<?=site_url('AutoConfig/createFirst')?>"><div class="provider"></div></a>
			<a href="<?=site_url('AutoConfig/createSecond')?>" title="目前仅供测试人员使用">
				<div class="provider" id="provider2"></div>
			</a>
			<a href="<?=site_url('jt_admin')?>"><div class="admin"></div></a>		
		</div>
	</div>
	<script>setPosition();</script>
</body>
</html>