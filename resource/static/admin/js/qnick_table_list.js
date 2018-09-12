// 限制只能提交一次
if(post_status == undefined){
    var post_status = true;
}

function set_fiter(table,columns,filters){
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
}

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

function render_liuyan(data){
    var data_set = [
      {text:'未回复',val:'0',filter:true},      //未审核
      {text:'已回复',val:'1'},      //未审核
      {text:'准客户',val:'2'},      //未审核
      {text:'客户',val:'3'},      //未审核
    ];
    return render_ajax_col(data_set,data,'select');
}

/**
 * 使用ajax方式修改列表中的单个值
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
            li_list += '        <li class="change_state" val="'+data_set[i].val+'">';
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
    }else if(type=='select'){


        for (var i =0; i < data_set.length ; i++) {
          if(data_set[i].val != data ){
            li_list += '        <li class="change_state" val="'+data_set[i].val+'">';
            li_list += '        '+data_set[i].text;
            li_list += '        </li>';
          }else if(data_set[i].val == data){
            this_html = data_set[i].text;
          }
        }
        html += '<span class="dropDown dropDown_hover pl-20 pr-20">';
        html += '    <a class="dropDown_A" >'+ this_html +'</a>';
        html += '    <ul class="dropDown-menu menu radius box-shadow">';
        html += li_list;
        html += '    </ul>';
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
 * ajax方式 更改状态(TD值)
 * @param  {string} target   jQuery选择器来指定目标, 默认是[.change_state]
 * @param  {object} callback_function(post_data,callback_data)   重新写入元素内的html函数
 * @return {null}
 *
 * 使用方法
 * 1. ajax_update_col();
 * 2. ajax_update_col('#obj_id');
 * 3. ajax_update_col(function(post_data,callback_data){
 *       return html;
 *    });
 * 4. ajax_update_col('#obj_id',function(post_data,callback_data){
 *       return html;
 *    });
 */
function ajax_update_col(){
  var targetObj = '.change_state'; 
  var callback_fun = function (post_data,callback_data){
    return render_flag(post_data.val);
  }

  var arg1 = typeof(ajax_update_col.arguments[0]);
  var arg2 = typeof(ajax_update_col.arguments[1]);
  if(arg1 == 'string'){
    targetObj = ajax_update_col.arguments[0];
  } 
  if(arg1 == 'function'){
    callback_fun = ajax_update_col.arguments[0];
  }
  if(arg2 == 'function'){ 
    callback_fun = ajax_update_col.arguments[1];
  }

  $(document).on('click',targetObj,function(){
        var _this_row = $(this).parents('tr');
        var _this_col = $(this).parents('td');
        var col_idx = _this_row.children('td').index($(this).parents('td'));
        var col_name = $(this).parents('table').find('thead th').eq(col_idx).text();
        var url = $(this).parents('table').find('thead th').eq(col_idx).attr('url');
        
        if(url == undefined){
          layer.alert('请在 thead>th属性里添加 url');
          return;
        }
        var id = _this_row.find('.row_id').text();
        var val = $(this).attr('val'); 
        var lval = null; 
        if(val==undefined){
          val = $(this).parent().find('input').val();
          lval = $(this).parent().parent().parent().find('.div_text').html();
          if(val==lval){
            layer.alert("值未被改变！");
          }
        }
        
        var data = {
          id : id
          ,val : val
          ,lval : lval
        }

      layer.confirm('确定要更改'+col_name+'状态吗？', {
        btn: ['确定','取消'] //按钮
      }, function(){
        layer.msg('正在提交',{time: 0});
        

        post_status = false;
        $.post(url,data,function(d){
          layer.closeAll();
          if(d.status){
              // console.log(col_idx);
           
              var html = callback_fun(data,d);
              _this_col.html(html);
          }else{
              layer.alert(d.msg);
          }
          post_status = true;
        },'json');
      });
  });
  $(document).on('click','.table_text',function(data){
    $(this).find("*").toggle();
  });
}

/**
 * 列表修改文字
 * @param data
 * @returns {String}
 */
function render_text(data){
  
  return render_ajax_col(null,data,'text');
}
 