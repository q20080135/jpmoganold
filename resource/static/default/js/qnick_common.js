
/**       
 * 对Date的扩展，将 Date 转化为指定格式的String       
 * 月(M)、日(d)、12小时(h)、24小时(H)、分(m)、秒(s)、周(E)、季度(q) 可以用 1-2 个占位符       
 * 年(y)可以用 1-4 个占位符，毫秒(S)只能用 1 个占位符(是 1-3 位的数字)       
 * eg:       
 * (new Date()).pattern("yyyy-MM-dd hh:mm:ss.S") ==> 2006-07-02 08:09:04.423       
 * (new Date()).pattern("yyyy-MM-dd E HH:mm:ss") ==> 2009-03-10 二 20:09:04       
 * (new Date()).pattern("yyyy-MM-dd EE hh:mm:ss") ==> 2009-03-10 周二 08:09:04       
 * (new Date()).pattern("yyyy-MM-dd EEE hh:mm:ss") ==> 2009-03-10 星期二 08:09:04       
 * (new Date()).pattern("yyyy-M-d h:m:s.S") ==> 2006-7-2 8:9:4.18       
 */          
Date.prototype.pattern=function(fmt) {           
    var o = {           
    "M+" : this.getMonth()+1, //月份           
    "d+" : this.getDate(), //日           
    "h+" : this.getHours()%12 == 0 ? 12 : this.getHours()%12, //小时           
    "H+" : this.getHours(), //小时           
    "m+" : this.getMinutes(), //分           
    "s+" : this.getSeconds(), //秒           
    "q+" : Math.floor((this.getMonth()+3)/3), //季度           
    "S" : this.getMilliseconds() //毫秒           
    };           
    var week = {           
    "0" : "/u65e5",           
    "1" : "/u4e00",           
    "2" : "/u4e8c",           
    "3" : "/u4e09",           
    "4" : "/u56db",           
    "5" : "/u4e94",           
    "6" : "/u516d"          
    };           
    if(/(y+)/.test(fmt)){           
        fmt=fmt.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));           
    }           
    if(/(E+)/.test(fmt)){           
        fmt=fmt.replace(RegExp.$1, ((RegExp.$1.length>1) ? (RegExp.$1.length>2 ? "/u661f/u671f" : "/u5468") : "")+week[this.getDay()+""]);           
    }           
    for(var k in o){           
        if(new RegExp("("+ k +")").test(fmt)){           
            fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));           
        }           
    }           
    return fmt;           
}

function is_change(obj){
    var val = $.trim($(obj).val());
    var original = $(obj).attr('ori_data');
    if(original == undefined) {
        original = '';
    }

    if(val != original && val != ''){   //状态有变更时
        return true;
    }else{
        return false;
    }
} 
function if_change_val_set_data(el_id,data){
    if(is_change('#'+el_id)){   
        data[el_id] = $.trim($('#'+el_id).val());
        if($('#'+el_id).attr('ori_data') != '' && $('#'+el_id).attr('ori_data') != undefined){            
            data['ori_'+el_id] = $('#'+el_id).attr('ori_data');
        }
    }
    return data;
}

function get_val_by_json(obj,key) {     //get value by json key
    if (typeof(obj) === 'object'){
        if(typeof(obj[key]) !== 'undefined'){
            return obj[key];
        }else{
            return null;
        }
    }else{
        return null;
    }
}
function col_idx(obj,v){    //查询表里列位置
    return $(obj).qnick('find_json_idx',{name:v});
}

function submit_search_form(table,columns,filters){     //使用DataTabl列表是查询提交
    var is_submit = false;
    var v;
    $(filters).each(function(i,item){
        // console.log(item);
        if($.trim($("#filter_"+item).val()) != ''){
            v = $.trim($("#filter_"+item).val());  
            table.column(col_idx(columns,item)).search(v);  
            is_submit = true;              
        }else{
        	$("#filter_"+item).val('');  
            table.column(col_idx(columns,item)).search('');        	
        }
    })
        
    if(is_submit){
        table.ajax.data = {'test':'test1'};
        table.draw();
    }else{
        layer.msg('请输入查询关键词');
    }
}


function reset_filter_form(table,columns,filters){
    var is_submit = false;
    $(filters).each(function(i,item){
        // console.log(item);
        if($.trim($("#filter_"+item).val()) != ''){
            $("#filter_"+item).val('');  
            table.column(col_idx(columns,item)).search('');
            is_submit = true;              
        }
    })            
    if(is_submit){
        table.draw();
    }
}

function get_excel(url,filters){
    $(filters).each(function(i,item){
        // console.log(item);
        if($.trim($("#filter_"+item).val()) != ''){
            if(url.indexOf('?') == -1) {
                url += '?';
            }else{
                url += '&'
            }
            url += item+ '='+$.trim($("#filter_"+item).val());  
        }
    });
    location.href = url;
}

// function get_idx_by_search(obj,key,) {		//get value by json key
//     if (typeof(obj) === 'object'){
//     	if(typeof(obj[key]) !== 'undefined'){
//     		return obj[key];
//     	}else{
// 	    	return null;
//     	}
//     }else{
//     	return null;
//     }
// }

(function($) {
    var json_methods = {
        find_json_idx: function() {
            var option = arguments[0];
            var search_key;
            var key_idx = null;
            if(typeof(option) === 'object'){
                for (var key in option){
                    search_key = key;
                }
            }
            if(typeof(search_key) === 'string'){
                this.each(function(idx,item) {
                    $(item).each(function(i,v){
                        if(typeof(v[search_key]) !== 'undefined'){
                            if(v[search_key] == option[search_key]){
                                key_idx = idx;                                
                            }
                        }                        
                    });
                });
            }
            return key_idx;
        }
    };

    $.fn.qnick = function() {
        var method = arguments[0];
        var options = arguments[1];

        // 检验方法是否存在
        if(json_methods[method]) {

            // 如果方法存在，存储起来以便使用
            // 注意：我这样做是为了等下更方便地使用each（）
            method = json_methods[method];

        // 如果方法不存在，检验对象是否为一个对象（JSON对象）或者method方法没有被传入
        } else if( typeof(method) == 'object' || !method ) {

            // 如果我们传入的是一个对象参数，或者根本没有参数，init方法会被调用
            method = methods.init;
        } else {

            // 如果方法不存在或者参数没传入，则报出错误。需要调用的方法没有被正确调用
            $.error( 'QNick Plugins: Method ' +  method + ' does not exist on jQuery.qnick_json' );
            return this;
        }

        // 调用我们选中的方法
        // 再一次注意我们是如何将each（）从这里转移到每个单独的方法上的
        return method.call(this,options);

    }

})(jQuery);