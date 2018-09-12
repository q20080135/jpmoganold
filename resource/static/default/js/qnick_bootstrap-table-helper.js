
function render_flag(data){

    var data_set = [
      {class:'c-green',icon:'&#xe6a7;',val:'1'}      //是
      ,{class:'c-error',icon:'&#xe6a6;',val:'0'}     //否
    ];
    return render_ajax_col(data_set,data);
}

function render_auditing(data){
    var data_set = [
      {class:'c-warning',icon:'&#xe63c;',val:'0',filter:true}      //未审核
      ,{class:'c-green',icon:'&#xe6e1;',val:'1'}     //审核通过
      ,{class:'c-error',icon:'&#xe6dd;',val:'2'}     //审核不通过
    ];
    return render_ajax_col(data_set,data);
}

/**
 * 使用ajax方式修改列表中的单个值有change_state class就会触发update
 * @param  {array}              data_set 状态列表显示数据
 *                                       filter: true的时候源数据不等于该值就隐藏该项
 *                                       【例：0未审核，1审核，2审核不同过， 当0（未审核）的数据filter设置为true，当源数据1或2的时候列表上不显示0（未审核）】
 * @param  {[type]}             data     源数据
 * @param  {[undefined|'text']} type     源数据格式
 *                                       undefined(默认)：菜单列表模式, 'text':为修改文字用的
 * @return {string}             生成菜单列表或修改文本HTML
 */
function render_ajax_col(data_set,data,type){ 
    var li_list = '';
    var this_html = '';
    var html = '';
    if(type ==undefined){

        for (var i = data_set.length - 1; i >= 0; i--) {
          if(data_set[i].val != data && !data_set[i].filter){
            li_list += '        <li class="change_state text-c" val="'+data_set[i].val+'" ori_val="'+data+'">';
            li_list += '        '+render_item(data_set[i]);
            li_list += '        </li>';
          }else if(data_set[i].val == data){
            this_html = render_item(data_set[i]);
          }
        }
        html += '<span class="dropDown dropDown_hover pl-20 pr-20">';
        html += '    <a class="dropDown_A" >'+ this_html +'</a>';
        html += '    <ul class="dropDown-menu menu radius box-shadow">';
        html += li_list;
        html += '    </ul>';
        html += '</span>';
    }else if(type == 'text'){
    	//text html
        var html = '';
        html += '<span class="table_text"  style="width:100%;height:100%;">';
        html += '    <div class ="f-l div_text" style="width:100%;height:100%;">'+data+'</div>';
        html += '    <div style="width:170px;height:100%;display:none;" class="f-l"><input type="text" class="input-text hide mr-10" style="width:80px;" value="'+data+'"><a class="btn btn_text" style="display:none;">确定</a></div>';
        html += '</span>';
    }
    return html;
}

function render_item(icon_set){ 
    var icon = text = '';
    if(icon_set.class == undefined){
      icon_set.class = '';
    }

    if(icon_set.icon != undefined){
      icon = '<i class="Hui-iconfont '+icon_set.class+'">'+icon_set.icon+'</i>';
    }

    if(icon_set.text != undefined){
      text = '<span class="'+icon_set.class+'">'+icon_set.text+'</span>';
    }

    return icon + text;
}

/**
 * 列表修改文字
 * @param data
 * @returns {String}
 */
function render_text(data){
	
	return render_ajax_col(null,data,'text');
}
 