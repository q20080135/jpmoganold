/**
 *  添加/编辑 商品页面JS
 * ==============================
 *  包含表单检查、输入框格式检查、回车事件、编辑器、图片上传插件等
 *  
 *  作者 ： <linzeyong>
 *  日期 ： 2016.11.29
 *  =============================
 */

	
(function ($) {
	
    $(document).ready(function () {
    	
    	//添加商品页面的框架选择
    	$(".stage_select_Box .botton_select").click(function(){
    		
    		//取消其他已选中的按钮，激活当前点击的按钮
    		$(".stage_select_Box .botton_select").attr("data-state", "");
    		var state = $(this).attr("data-state", "active");
    		
			//隐藏 商品相册->对应商品属性
			$('.product-attr-list').css('display', 'none');
			$('.file-preview-frame').css('border-color', '#ddd');

    		//隐藏所有框架，显示当前选择框架
    		$(".product_stage").hide();
    		var type = $(this).attr("data-type") || "";
    		
    		if(type != "")
			{
    			$(".stage_" + type).show(300);
    			
    			//上传图片框架下，隐藏表单提交按钮
    			if(type == "image")
    			{
    				$(".form-submit.form-last-box").hide();
    			}
    			else
    			{
    				$(".form-submit.form-last-box").show();
    			}
			}
		});
		
		//地区信息
		var areaData = {};
		//获取地区信息
		var getAreaData = function() {
			$(".select_region").each(function(index, item) {
				var key = $(item).attr('id') || null;
				if((key && areaData[key] && areaData[key].data.length > 0) || $(item).find('option').length > 1) {
					if(key) {
						if(!areaData.hasOwnProperty('search') || areaData.search < index) {
							areaData[key] = {
								data: [],
								init: $(item).html(),
							};
							$(item).find('option').each(function(i, option) {
								var k = parseInt($(option).val()) || 0;
								var v = $(option).text() || null;
								if(k > 0 && v) {
									areaData[key].data.push({
										id: k,
										name: v,
									});
								}
							});
						}
						if(areaData[key] && areaData[key].data.length > 0) {
							$(item).siblings('.btnSearchTogger').css('display', 'inline-block');
						}else {
							$(item).siblings('.btnSearchTogger').css('display', 'none');
						}
					}
				}else {
					$(item).siblings('.btnSearchTogger').css('display', 'none');
				}
			});
			// console.log(areaData);
		};
		//开始搜索地区
		var searchArea = function(_input) {
			if($(_input).length === 1) {
				var val = $.trim($(_input).val()) || null;
				var selects = $(_input).parent('.searchItem').siblings('.select_region');
				var _id = selects.attr('id') || null;
				var datas = areaData[_id] || null;
				if(!datas || $.isEmptyObject(datas)) return;
				if(val) {
					var list = [];
					if(datas.data) {
						for(var i in datas.data) {
							var reg = new RegExp(val);
							if(reg.test(datas.data[i].name)) {
								list.push({
									id: datas.data[i].id,
									name: datas.data[i].name,
								});
							}
						}
						if(list.length > 0) {
							areaData.search = parseInt($(selects).data('id'));
							$(_input).val('');
							$(selects).html('');
							$(_input).siblings('.btnAreaSearch').find('i').attr('class', 'icon-random');
							for(var i in list) {
								var option = '<option value="' + list[i].id + '">' + list[i].name + '</option>';
								$(selects).append(option);
							}
							$(selects).find("option[value=" + list[0].id + "]").prop('selected', 'selected').siblings().removeAttr('selected');
							$(selects).trigger('change');
						}
					}
				}else {
					var first = parseInt($(selects).find('option:first').attr('value')) || 0;
					if(_id && datas.init && first > 0) {
						$(_input).siblings('.btnAreaSearch').find('i').attr('class', 'icon-ban-circle');
						areaData.search = parseInt($(selects).data('id'));
						$(selects).html(areaData[_id].init);
						$(selects).trigger('change');
					} 
				}
			}
			event.preventDefault();
		};
		getAreaData();
		//显示、隐藏地区搜索框
		$('.btnSearchTogger').click(function() {
			$(this).siblings('.searchItem').toggle(300);
			event.preventDefault();
		});
		//点击搜索地区
		$('.btnAreaSearch').click(function() {
			var input = $(this).siblings('.inputAreaSearch');
			searchArea(input);
		});
		//回车地区搜索框
		$('.inputAreaSearch').keydown(function(event) {
			var keycode = (event.keyCode ? event.keyCode : event.which);
    		if(keycode == 13) searchArea($(this));
		});
		//监听地区输入框变化, 更换搜索图标
		$('.inputAreaSearch').bind('input propertychange', function() {
			var val = $.trim($(this).val()) || null;
			$btnSpan = $(this).siblings('.btnAreaSearch').find('i');
			$selects = $(this).parent('.searchItem').siblings('.select_region');
			if(val) {
				//允许搜索
				$btnSpan.attr('class', 'icon-search');
			}else {
				var first = parseInt($($selects).find('option:first').attr('value')) || 0;
				if(first > 0) {
					//允许清除(已搜索过)
					$btnSpan.attr('class', 'icon-random');
				}else {
					//不允许搜索
					$btnSpan.attr('class', 'icon-ban-circle');
				}
			}
		});
    	//改变地区后，更换子地区的选项内容
    	$(".select_region").change(function(){
    		var areaid = $(this).val() || 0;
    		var selectid = $(this).attr("data-id") || 0;
    		var url = $("#get_region_url").val() || "";
			selectid = parseInt(selectid);
			if(selectid >= 0 && selectid <= 2) {
				//清除后面子选项的列表
				var str = "<option value='0'>请选择</option>";
				for(var i = selectid + 1; i <= 3; i++) {
					$selects = $(".select_region[data-id=" + i + "]");
					$selects.html(str);
					$selects.siblings('.searchItem').css('display', 'none');
					$selects.siblings('.btnSearchTogger').css('display', 'none');
				}
				if(areaid > 0 && url) {
					//获取子选项内容
					$.getJSON(url,{
						'action' : 'isAjax',
						'areaid' : areaid
					},function(result){
						if(result && result != "") {
							selectid++;
							$(".select_region[data-id='" + selectid + "']").append(result);
							getAreaData();
						}
					});
				}
			}
		});
    	
    	//点击触发添加属性事件
    	$(".btnAddAttr").click(function(){
    		addAttr_fun();
    	});
    	
    	//输入框回车触发添加属性事件
    	$(".inputAddAttr").keydown(function(event){
    		var keycode = (event.keyCode ? event.keyCode : event.which); 
    		
    		if(keycode == 13)
    		{
    			addAttr_fun();
    			return false;
    		}
    	});
    	
    	//添加属性的子内容
    	$(".btnAddChlidAtt").click(function(){
    		addChlidAttr();
    	});
    	
    	//关闭添加属性子内容的窗口
    	$(".btnCloseChlidAtt").click(function(){
    		$(".inputAddChlidAtt").val("");
			$(".allbodybg").hide();
			$(".inputChildAttr").hide();
			$(".messageBg .message-alert").hide();
    	});
    	
    	//输入框回车触发添加子属性事件
    	$(".inputAddChlidAtt").keydown(function(event){
    		var keycode = (event.keyCode ? event.keyCode : event.which); 
    		
    		if(keycode == 13)
    		{
    			addChlidAttr();
    			return false;
    		}
    	});
    	
    	//取消表单内的 input[type=text] 回车自动提交表单
    	$("#content_stage :input:text").keydown(function(event){
    		var keycode = (event.keyCode ? event.keyCode : event.which);
    		if(keycode == 13)
    		{
    			return false;
    		}
    	});
    	
    	/* 初始化fileinput控件（第一次初始化）
    	 * filebatchselected 文件选择完成触发事件
    	 * fileuploaded 文件上传成功回调事件
    	 */
    	var initFileInput = function (ctrlName, uploadUrl) 
    	{
    		var type = $("#product_type").val() || "";
    		var pid = $("#product_id").val() || 0;
    		
    	    $('#' + ctrlName).fileinput({
    	    	minFileCount: 1,
    	    	maxFileCount: 5,
    	        language: 'zh', //设置语言
    	        uploadUrl: uploadUrl, //上传的地址
    	        allowedPreviewTypes : ['image'],
    	        allowedFileExtensions : ['jpg', 'jpeg', 'png', 'gif', 'bmp'],//接收的文件后缀
    	        showUpload: true, //是否显示上传按钮
    	        showCaption: false,//是否显示标题
    	        browseClass: "btn btn-primary", //按钮样式             
    	        uploadExtraData: {
    	    		'type' : type,
    	    		'action': 'isAjax',
    	    		'productid' : pid
    	    	},
    	    }).on('fileuploaded ',function(event, data){
    	    	//返回数据 data.response
    	    	//console.log(data);
    	    	
    	    	//去除上传成功的浏览图片
    	    	$(data.successBox).each(function(){
    	    		$(this).remove();
    	    	});
    	    	
    	    	//把上传成功的图片添加到上面的DIV
    	    	var src = data.response.imgurl || "";
    	    	var id = data.response.id || "";
    	    	var imgbox = 
    	    		"<div class='file-preview-frame'>" +
    	    			"<img src='" + src + "' class='file-preview-image' />" +
    	    			"<div class='imgbox-footer'>" +
    	    				"<button type='button' class='btn btn-xs btn-default pull-right' " +
    	    					"title='删除文件' onclick='delImage(this, " + id + ")'>" +
    	    					"<i class='glyphicon glyphicon-trash text-danger'></i>" +
    	    				"</button>" +
    	    			"</div>" +
    	    		"</div>";
    	    	
    	    	$(".uploadsuccessBOX").append(imgbox);
    	    });
    	}
    	
    	var upurl = $("#upload_url").val();
    	initFileInput("file-Portrait1", upurl);
    	
    });

})(jQuery);

//选择商品设为列表图片
var setIndex = function(btn, id)
{
	var issel = $(btn).attr("data-issel") || 0;
	var seturl = $("#setindex_url").val();
	if(issel != 1)
	{
		$.getJSON(seturl, {
			'action' : 'isAjax',
			'imgid' : id
		}, function(data){
			var err = data.err || 0;
			var msg = data.msg || "";
			layer.alert(msg);
			if(err == "1")
			{
				$(".imgbox-footer .set-index-img").attr("data-issel", 0);
				$(".imgbox-footer .set-index-img > i").attr("class", "icon-bookmark-empty");
				$(btn).attr("data-issel", 1);
				$(btn).find("i").attr("class", "icon-bookmark");
			}
		});
	}
};

//删除商品图片
var delImage = function(btn, id)
{
	var delurl = $("#delimage_url").val();
	$.getJSON(delurl, {
		'action' : 'isAjax',
		'imgid' : id
	}, function(data){
		var err = data.err || 0;
		var msg = data.msg || "";
		
		layer.alert(msg);
		if(err == "1")
		{
			$(btn).parents(".file-preview-frame").remove();
		}
	});
};

//获取商品属性
var getProductAttr = function(btn, pid, imgid)
{
	if(pid > 0 && imgid > 0)
	{
		var root = $("#wwwroot").val();
		var url = root + "product/get_product_attrs_select_list";
		
		$('.file-preview-frame').css('border-color', '#ddd');
		$(btn).parents('.file-preview-frame').css('border-color', '#F44336');
		$.post(url,{
			'action' : 'isAjax',
			'productid' : pid,
			'imageid' : imgid,
		},function(data, state){
			var list = data || [];
			if(list.length > 0) {
				$('.product-attr-list').empty();
				$('.product-attr-list').css('display', 'block');
				$(list).each(function(idx, item){
					var name = item.name || '';
					var options = item.options || '';
					var html = 
						"<div class='attr-age-box'>" +
							"<div class='attr-age-title'>"+name+"</div>" +
							"<select class='form-control select-list' name='attrlist[]' onchange='select_attr();'>" +
								"<option value=''>请选择</option>" +
								options +
							"</select>" +
						"</div>";
					
					$('.product-attr-list').append(html);
				});
				var btnSave = '<button id="btn_attr_img_save" type="submit" class="btn btn-primary" disabled>提交</button>';
				$('.product-attr-list').append(btnSave);

				$("#btn_attr_img_save").click(function(){
					var url2 = root + "product/save_product_attr_img";
					var attrlist = [];
					$('.attr-age-box .select-list').each(function(){
						var _val_ = $(this).val() || null;
						if(_val_){
							attrlist.push(_val_);
						}else {
							return false;
						}
					});
					$.post(url2,{
						'action' : 'isAjax',
						'imageid' : imgid,
						'attrlist': attrlist,
					},function(ret2, state2){
						if(ret2 && ret2.msg) {
							$(".change_alert_box").autoalert(ret2.msg, 1);
						}
					}, 'json');
				});
			}else {
				$(".change_alert_box").autoalert("该商品未添加任何属性！", 1);
				return false;
			}
			
		}, 'json');
	}
};

// 选择商品属性
var select_attr = function() {
	var _able = checkIsAble();
	if(!_able) return false;
	var isok = true;
	$('.attr-age-box .select-list').each(function(){
		var val = $(this).val() || 0;
		if(val <= 0)
		{
			isok = false;
		}
	});

	$("#btn_attr_img_save").prop("disabled", !isok);
};


/*
 * =======================================================================
 * 添加属性 开始
 * =======================================================================
 * attrAge		所有属性集合
 * chlidAttrAge 所有属性的子选项集合
 * attr_id		属性集合的下标(只加不减，避免重叠)
 * selObj		添加属性子选项的元素
 * maxAttr		属性的最多数量
 * maxLength	可以同时被选中属性的最大数量
 * */
var selObj = null;
var maxAttr = 9;
var maxLength = 3;
var obj = {
	"left" : "20px",
	"top" : "-35px",
};

//返回有效数组的长度
var array_length = function(arr)
{
	var n = 0;
	for(var i in arr)
	{
		if(arr[i] != undefined && arr[i] != null && arr[i] != "")
		{
			n++;
		}
	}
	return n;
};

//添加属性行
var addAttr_fun = function()
{
	var _able = checkIsAble();
	if(!_able) return false;
	var name = $(".inputAddAttr").val() || "";
	name = trim(name);
	name = name.replace(/\</g,"&lt;");
	name = name.replace(/\>/g,"&gt;");
	name = name.replace(/\"/g,"\"");
	name = name.replace(/\'/g,"\'");
	
	if(name == ""){
		$(".messageAlertBg").message_alert("属性名不能为空！", obj, 9, ".inputAddAttr");
	}else if(name.indexOf(',') >= 0) {
		$(".messageAlertBg").message_alert("属性中禁止使用逗号！", obj, 8, ".inputAddAttr");
	}else if($.inArray(name, attrAge) >= 0) {
		$(".messageAlertBg").message_alert("该属性名已添加！", obj, 0, ".inputAddAttr");
	}
	else if(array_length(attrAge) >= maxAttr)
	{
		$(".messageAlertBg").message_alert("属性数量已超过最大值！", obj, 0, ".inputAddAttr");
	}
	else
	{
		attrAge[attr_id] = name;
		chlidAttrAge[attr_id] = new Array();
		$(".inputAddAttr").val("");
		
		var sellist = 
			"<div class='oneAttrRow' data-id='" + attr_id +"'>" +
				"<label class='checkbox-inline'>" + 
					"<input type='checkbox' class='addPriceAttr' onclick='addRowAttr(this)' />" + name +
					"<input type='hidden' class='attrIsCheck' name='attrAge[" + attr_id + "][check]' value='0' />" +
					"<input type='hidden' name='attrAge[" + attr_id + "][name]' value='" + name + "' />" +
				"</label>" +
				"<div class='attrRowControl attrRowDel'  onclick='delRowAttr(this)'>" +
					"<i class='icon-minus-sign'></i>" +
				"</div>" +
				"<div class='attrRowControl attrRowAdd' onclick='openChlidAttrBox(this)'>" +
					"<i class='icon-plus-sign'></i>" +
				"</div>" +
			"</div>" +
			"<div class='chlidAttrRow'></div>";
		
		$(".allAttrGather").append(sellist);
    	attr_id++;
	}
};

//点击大行属性
var addRowAttr = function(_this){
	var _able = checkIsAble();
	if(!_able) return false;
	var length = $(".addPriceAttr:checked").length || 0;
	if(length <= maxLength)
	{
		if($(_this).is(":checked"))
		{
			$(_this).next(".attrIsCheck").val(1);
			$(_this).attr("checked", true);
		}
		else
		{
			$(_this).next(".attrIsCheck").val(0);
			$(_this).attr("checked", false);
		}
		
		priceAtrrs = {};
		select_list(false, null);
	}
	else
	{
		$(_this).attr("checked", false);
	}
};

//删除大行属性
var delRowAttr = function(_this){
	var _able = checkIsAble();
	if(!_able) return false;
	var parent = $(_this).parent(".oneAttrRow");
	var id = $(parent).attr("data-id") || -1;
		
	if(id >= 0)
	{
		var pid = $(parent).attr("data-pid") || -1;
		if(pid >= 0)
		{
			priceAtrrs = {};
		}
		
		delete attrAge[id];
		delete chlidAttrAge[id];
		//chlidAttrAge.splice(id, 1);
		select_list(true, parent);
		
		$(parent).next(".chlidAttrRow").remove();
		$(parent).remove();
	}
};

/*
 * obj 是包含 input.addPriceAttr 的 .oneAttrRow父元素
 * 如果checkbox为已打勾的选项，重新绘制表格
 */
var select_list = function(isCheck, obj)
{
	if(!isCheck || (obj != null && $(obj).find("input.addPriceAttr").is(':checked')))
	{
		var attrAge_sel = [];
		var markid = 0;
		$(".addPriceAttr:checked").each(function(_id, _checkbox){
			var pid = $(this).parents(".oneAttrRow").attr("data-id") || -1;
			if(pid >= 0)
			{
				$(this).parents(".oneAttrRow").attr("data-pid", markid);
				markid++;
				//attrAge_sel.push(chlidAttrAge[pid]);
				attrAge_sel[pid] = chlidAttrAge[pid];
			}
		});
		
		//根据新的内容生成组合表格
		//console.log(attrAge_sel);
		createPriceTable(attrAge_sel);
	}
};

var createpriceinput = function(name)
{
	var _name = name.replace(/[\[,\]]/g,"");
	var value = "value";
	if(priceAtrrs[_name] && priceAtrrs[_name] > 0)
	{
		value += " = '" + priceAtrrs[_name] + "'";
	}
	
	return	"<div class='rowspanBox rowspanBoxPrice'>" +
			"<input type='text' class='inputAttrPrice' name='" + name + "' " + value + 
			" onkeyup='checkNum(this, 2);addNumObject(this.name, this.value);' maxlength='12' />" +
			"</div>";
};

//自动生成打勾属性的价格组合表格
var createPriceTable = function(attr)
{
	$(".attrPriceEnsemble").empty();
	var arrN = [];
	var prevN = 1;
	var lastH = 0;
	
	//生成组合行列
	for(var i in attr)
	{
		if(attr[i] != undefined && attr[i] != null && attr[i] != "")
		{
			var html = "<div class='colspanBox'>";
			var chtml = "";
			var height = 30;
			arrN.push(attr[i].length);
			
			//生成子选项的内容
			for(var j in attr[i])
			{
				chtml += 
					"<div class='rowspanBox rowspanBox" + i + "'>" +
						"<span>" + attr[i][j] + "</span>" +
					"</div>";
			}
			
			if(prevN > 1)
			{
				for(var x = 0; x < prevN; x++)
				{
					html += chtml;
				}
			}
			else
			{
				html += chtml;
			}
			
			prevN = prevN * attr[i].length;
			html += "</div>";
			
			//获取该子元素的高度
			var _attr = attr.slice(i);
			var _n = 1;
			for(var n in _attr)
			{
				if(n > 0 && _attr[n] != undefined && _attr[n] != null && _attr[n] != "" & _attr[n].length > 0)
				{
					_n = _n * _attr[n].length;
					height = height * _attr[n].length;
				}
			}
			
			if(_n == 1)
			{
				_n = attr[i].length;
			}
			
			lastH = height;
			$(".attrPriceEnsemble").append(html);
			$(".rowspanBox" + i).css("height", height + "px");
			$(".rowspanBox" + i).css("line-height", height + "px");
		}
	}
	
	
	if(attr.length > 0)
	{
		//生成组合行列后面的价格
		var html = 
			"<div class='colspanBox colspanPriceBox'>" +
				"<div class='batchSetPrice'>" +
					"<input type='text' class='inp-batchPrice' onkeyup='checkNum(this, 2);' maxlength='12' />" + 
					"<span class='btn-batchPrice' onclick='batchprice();'>批量设置</span>" +
				"</div>";
		for(var i = 0; i < arrN[0]; i++)
		{
			var name_str = "attrPriceArr[" + i + "]";
			if(arrN[1] && arrN[1] > 0)
			{
				for(var i2 = 0; i2 < arrN[1]; i2++)
				{
					var name_str2 = "[" + i2 + "]";
					if(arrN[2] && arrN[2] > 0)
					{
						for(var i3 = 0; i3 < arrN[2]; i3++)
						{
							var name_str3 = "[" + i3 + "]";
							html += createpriceinput(name_str + name_str2 + name_str3);
						}
					}
					else
					{
						html += createpriceinput(name_str + name_str2);
					}
				}
			}
			else
			{
				html += createpriceinput(name_str);
			}
		}
		html += "</div>";
		
		$(".attrPriceEnsemble").append(html);
		$(".rowspanBoxPrice").css("height", lastH + "px");
		$(".rowspanBoxPrice").css("line-height", lastH + "px");
	}
};

//批量设置价格
var batchprice = function()
{
	var _able = checkIsAble();
	if(!_able) return false;
	var val = $(".inp-batchPrice").val() || 0;
	if(val > 0)
	{
		$(".inputAttrPrice").attr("value", val);
		$(".inputAttrPrice").val(val);
		$(".inputAttrPrice").each(function(){
			var bname = $(this).attr("name") || '';
			if(bname != '')
			{
				var _bname = bname.replace(/[\[,\]]/g,"");
				priceAtrrs[_bname] = val;
			}
		});
	}
};

//把价格存入数组
var addNumObject = function(name, value)
{
	var _name = name.replace(/[\[,\]]/g,"");
	priceAtrrs[_name] = value;
}

//打开添加子属性窗口
var openChlidAttrBox = function(_this){
	var _able = checkIsAble();
	if(!_able) return false;
	selObj = $(_this).parent(".oneAttrRow");
	$(".allbodybg").show();
	$(".inputChildAttr").show();
	$(".inputAddChlidAtt").focus();
};

//添加属性子列表
var addChlidAttr = function()
{
	var _able = checkIsAble();
	if(!_able) return false;
	var id = $(selObj).attr("data-id") || -1;
	var name = $(".inputAddChlidAtt").val() || "";
	name = $.trim(name);
	name = name.replace(/\</g,"&lt;");
	name = name.replace(/\>/g,"&gt;");
	name = name.replace(/\"/g,"\"");
	name = name.replace(/\'/g,"\'");
	
	if(name == "") {
		$(".messageBg").message_alert("你输入的名字不能为空！", obj, 8, ".inputAddChlidAtt");
	}else if(name.indexOf(',') >= 0) {
		$(".messageBg").message_alert("属性中禁止使用逗号！", obj, 8, ".inputAddChlidAtt");
	}else if(id >= 0) {
		var _cid = $.inArray(name, chlidAttrAge[id]);
		if(_cid >= 0)
		{
			$(".messageBg").message_alert("你添加的该项下的子选项已存在！", obj, 0, ".inputAddChlidAtt");
		}
		else
		{
			var str = 
				"<div class='chlidAttrBox'>" +
					"<span>" + name + "</span>" +
					"<div class='chlidAttrDel' data-id=" + id + " onclick='delChlidAttr(this)'>" +
						"<li class='icon-trash'></li>" +
						"<input type='hidden' class='inputChlidAttr' name='chlidAttrAge[" + id +"][]' value='" + name + "' />" +
					"</div>" +
				"</div>";
			
			
			chlidAttrAge[id].push(name);
			$(selObj).next(".chlidAttrRow").append(str);
			$(".inputAddChlidAtt").val("");
			$(".allbodybg").hide();
			$(".inputChildAttr").hide();

			select_list(true, selObj);
			selObj = null;
		}
	}
};

//删除属性子项
var delChlidAttr = function(_this){
	var _able = checkIsAble();
	if(!_able) return false;
	var __cid = $(_this).attr("data-id") || -1;
	var _name = $(_this).find(".inputChlidAttr").val() || "";
	
	if(__cid >= 0 && _name != "")
	{
		var n = 0;
		var box = $(_this).parents(".chlidAttrBox");
		for(var x = 0; x < 10; x++)
		{
			box = $(box).prev();
			if($(box).length == 0)
			{
				n = x;
				break;
			}
		}
		
		var pid = $(_this).parents(".chlidAttrRow").prev(".oneAttrRow").attr("data-pid") || -1;
		var total = $(_this).parents(".chlidAttrRow").find('.chlidAttrBox').length;

		if(pid >= 0 && total > 0)
		{
			if(total > 1)
			{
				for(var i in priceAtrrs)
				{
					//"attrPriceArr" 占12位
					var s2 = parseInt(i.substr(12 + parseInt(pid), 1));
					
					//第一种方式 去除删除项后面的所有数据
					if(n <= parseInt(s2))
					{
						//priceAtrrs[i] = 0;
					}
					
					//第二种方式 把去除项后面的数据往前移
					if(n == s2)
					{
						priceAtrrs[i] = 0;
					}
					else if(n < s2)
					{
						var idx = 
							i.substring(0, 12 + parseInt(pid)) + 
							(s2 - 1) + 
							i.substring(13 + parseInt(pid));
						priceAtrrs[idx] = priceAtrrs[i];
						priceAtrrs[i] = 0;
					}
				}
			}
			else
			{
				priceAtrrs = {};
			}
		}
		
		var ____cid = $.inArray(_name, chlidAttrAge[__cid]);
		if(____cid >= 0)
		{
			chlidAttrAge[__cid].splice(____cid, 1);
			
			var row = $(_this).parents(".chlidAttrRow").prev(".oneAttrRow");
			select_list(true, row);
			$(_this).parent(".chlidAttrBox").remove();
		}
	}
};

//表单检查
var checkform = function(){
	var name = document.getElementById('productName').value || "";
	var classifly = parseInt(document.getElementById('productClassify').value) || 0;
	var country = parseInt(document.getElementById('region_country').value) || 0;
	var province = parseInt(document.getElementById('region_province').value) || 0;
	var city = parseInt(document.getElementById('region_city').value) || 0;
	var district = parseInt(document.getElementById('region_district').value) || 0;
	var martprice = document.getElementById('productMartPrice').value || "";
	var price = document.getElementById('productSellPrice').value || "";
	var freight = document.getElementById('freightList').value || "";

	//检查名字
	if(trim(name) == "") {
		$(".change_alert_box").autoalert("名字不能为空！", 1);
		document.getElementById('productName').focus();
		return false;
	}
	
	//检查分类
	if(classifly == 0) {
		$(".change_alert_box").autoalert("请选择该商品的所属的分类！", 1);
		document.getElementById('productClassify').focus();
		return false;
	}

	//检查国家
	if(country <= 0) {
		$(".change_alert_box").autoalert("商品所属地区的国家还未选择！", 1);
		document.getElementById('region_country').focus();
		return false;
	}else if(country == 1) {
		//检查省份
		if(province == 0) {
			$(".change_alert_box").autoalert("商品所属地区的省份还未选择！", 1);
			document.getElementById('region_province').focus();
			return false;
		}
		
		//检查城市
		if(city == 0) {
			$(".change_alert_box").autoalert("商品所属地区的城市还未选择！", 1);
			document.getElementById('region_city').focus();
			return false;
		}
		
		//检查区域
		if(district == 0) {
			//$(".change_alert_box").autoalert("商品所属地区的县/区还未选择！", 1);
			//document.getElementById('region_district').focus();
			//return false;
		}
	}
	
	//检查市场价
	if(trim(martprice) == "") {
		$(".change_alert_box").autoalert("还没未设置该商品的市场价！", 1);
		document.getElementById('productMartPrice').focus();
		return false;
	}
	
	//检查销售价
	if(trim(price) == "") {
		$(".change_alert_box").autoalert("还没未设置该商品的销售价！", 1);
		document.getElementById('productSellPrice').focus();
		return false;
	}

	//检查运费模版
	// if(!freight || freight <= 0)
	// {
	// 	$(".change_alert_box").autoalert("请选择运费模版！", 1);
	// 	document.getElementById('freightList').focus();
	// 	return false;
	// }
	
	// var freight = $(".productfreight:checked").val() || 1;
	// var weight = document.getElementById('productWeight').value || 0;
	// weight = parseInt(weight);
	// if(freight == 2 && weight == 0)
	// {
	// 	document.getElementById('productWeight').focus();
	// 	$(".change_alert_box").autoalert("你选择计重运费但未填写商品重量！", 1);
	// 	return false;
	// }
	
	var isok = true;
	var div1 = $(".allAttrGather").html() || "";
	var div2 = $(".attrPriceEnsemble").html() || "";
	$("#divbox1").val($.trim(div1));
	$("#divbox2").val($.trim(div2));

	//检查所有属性是否有价格
	$(".inputAttrPrice").each(function(){
		var val = $(this).val() || "";
		if(val == "") {
			$(".change_alert_box").autoalert("还有其他属性的商品价格未添加，请全部添加！", 1);
			isok = false;
		}
	});
	return isok;
};

//团购商品禁止修改属性
var disAbleEditAttr = true;
var checkIsAble = function() {
	if(disAbleEditAttr) {
		var able =  $('#group_shop_id').val() || 0;
		if(able == 1) {
			$(".change_alert_box").autoalert('该商品已参加团购活动, 禁止修改属性。', 1);
			return false;
		}
	}
	return true;
}
