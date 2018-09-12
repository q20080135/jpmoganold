;(function ( $, w, d, l, undefined ) { 

    var pluginName = 'myDataTable'
    , methods = []
    , btnSearch = '#btn_search'             // 查询按钮
    , btnReset = '#btn_reset'               // 重置按钮
    , toolbar = '#custom_toolbar_box'
    , defaultBootstrapTableOptions = {
        locale : "zh-CN",                   // 中文语言
        dataField : "rows",                 // 服务端返回数据键值 就是说记录放的键值是rows，分页时使用总记录数的键值为total
        // height : 500,                     // 高度
        // search : true,                      // 是否搜索 (searchText为默认表单文字)
        // searchPlaceholder : '输入商品名称搜索', // 搜索提示文字 [自定义]
        pagination : true,                  // 是否分页
        pageSize : 10,                      // 单页记录数
        pageList : [ 5, 10, 20, 50 ],       // 分页步进值
        sidePagination : "server",          // 服务端分页
        dataType : "json",                  // 期待返回数据类型
        method : "post",                    // 请求方式
        // 发送到服务器的数据编码类型
        // 如果默认值为'application/json'(json字符串)
        // PHP服务端必须用$GLOBALS['HTTP_RAW_POST_DATA'] 接收并json_decode解析
        contentType : "application/x-www-form-urlencoded",
        sortOrder : 'desc',                 // 定义默认排序
        searchAlign : "left",               // 查询框对齐方式
        searchOnEnterKey : false,           // 回车搜索
        showRefresh : true,                 // 刷新按钮
        showColumns : true,                 // 列选择按钮
        showToggle : true,                  // 显示切换视图
        buttonsAlign : "left",              // 按钮对齐方式
        toolbar : toolbar,                  // 指定工具栏
        toolbarAlign : "right",             // 工具栏对齐方式
        detailView : false,                 // 是否显示详情折叠, 
        columns : [],
    }
    ,tempParam = {};

    function myDataTable( e, options ) { 
        this.element = e; 
        this.options = options;
        if(options.toolbar != undefined){
            toolbar = options.toolbar;
        }
        this._defaults = defaultBootstrapTableOptions;

        this.dbtOption = this.setUniqueId(this._defaults);
        this.dbtOption = this.setFormatter(this.dbtOption);
        this.dbtOption.queryParams = this.getQueryParams;
        this.dbtOption = $.extend({}, this.dbtOption, options.option); 
        this.init();  
        // $(this.element).trigger('onLoad',this);
    } 
  
    myDataTable.prototype = {
        setUniqueId: function(dbtOption){   // 从row_id class中获取 data-field名称
            var id = $(this.element).find('thead .row_id').attr('data-field');
            if(id !== undefined){
                dbtOption.uniqueId = id;
            }
            return dbtOption;
        }
        ,setFormatter: function(dbtOption){
            var e = this.element;
            var opt = this.options;
            var columns = dbtOption.columns;

            $(e).find("thead th[data-field]").each(function(idx,el){
                var field = $(el).attr('data-field');
                var url = $(el).attr('update-url');     //这个属性不是bootstrapTable的！
                var col = {
                    field : field
                }
                if(url != undefined){
                    col.url = url     //这个属性不是bootstrapTable的！
                }
                if(typeof opt[field] === 'function'){
                    col.formatter = opt[field]     //对本列数据做格式化
                }
                columns.push(col);
            });
            dbtOption.columns = columns;
            return dbtOption;
        }
        ,init: function(){
            var e = this.element;
            var opt = this.options;
            this.bindRowClick();
            this.bindSearchBtn();
            this.bindResetBtn();
            this.enableAjaxUpdate();
            $(e).bootstrapTable(this.dbtOption);
        }
        ,bindRowClick: function(){
            var e = this.element;
            var opt = this.options;
            var _this = this;

            if(typeof opt.onRowClick === 'function'){
                $(e).on('load-success.bs.table', function (data) {
                    $(e).find('tbody td:not(".action")').smartClick(function () {
                        var colData = _this.getColumnData($(this));
                        if(colData.url == undefined){
                            var id = $.trim($(this).parents('tr').find('.row_id').text());
                            var row = $(e).bootstrapTable('getRowByUniqueId',id);
                            opt.onRowClick(this,id,row);
                        }
                    });
                });
            }
        }
        ,getColumnData: function(obj){
            var dbtOpt = this.dbtOption;
            var _this_row = obj.parents('tr');
            var _this_col = obj.parents('td');
            if($(obj).is('td')) {
                _this_col = obj;
            }
            var col_idx = _this_row.children('td').index(_this_col);
            var data = dbtOpt.columns[col_idx];
            return data;
        }
        ,bindSearchBtn:function(){
            var e = this.element;
            var opt = this.dbtOption;
            var _this = this;
            $(toolbar + ' '+ btnSearch).on('click',function(){
                // var param = _this.getQueryParams();
                $(e).bootstrapTable('refresh');
            });
        }
        ,bindResetBtn: function(){
            var e = this.element;
            var opt = this.dbtOption;
            var _this = this;
            $(toolbar + ' '+ btnReset).on('click',function(){
                $(toolbar + " [id^='filter_']").each(function(){
                    $(this).val('');
                });
                $(e).bootstrapTable('refresh');
            });
        }
        ,getQueryParams: function(params){
            //这里的键的名字和控制器的变量名必须一致
            var filterData = {};
            $(toolbar + " [id^='filter_']").each(function(){
                if($(this).val() !== ''){
                    var filterName = $(this).attr('id').replace(/filter_/,'');
                    filterData[filterName] = $(this).val();
                }
            });
            var sort = params.sort || '';
            var param = {
                action: 'isAjax',
                limit : params.limit,
                offset: params.offset,
                order : params.order,
                search: JSON.stringify(filterData),
                sort  : sort,
            };
            if(tempParam === JSON.stringify(param)){
                if(JSON.stringify(filterData) === '{}'){
                    l.msg('请填写要查询的内容');
                }else{
                    l.msg('不能重复提交');
                }
                return false;
            }else{
                tempParam = JSON.stringify(param);
                return param;
            }
        }
        ,enableAjaxUpdate: function(){
            var targetObj = '.change_state'; 
            var e = this.element;
            var _this = this;
            var opt = this.dbtOption;
            var callback_fun = null;

            $(document).on('click',targetObj,function(){
            
                var _this_col = $(this).parents('td');

                var colData = _this.getColumnData($(this));
                if(colData.url == undefined){
                  l.alert('请在thead>th属性里添加update-url属性');
                  return;
                }
                if(typeof colData.formatter == 'function'){
                    callback_fun = colData.formatter;
                }else{
                    callback_fun = function(val){ return val; }
                }

                var col_name = $(e).find("[data-field='"+colData.field+"']").text();

                var id = $.trim($(this).parents('tr').find('.row_id').text());
                if(id == undefined || id === ''){
                    l.alert("ID不能为空");
                    return;
                }
                var row = $(e).bootstrapTable('getRowByUniqueId',id);

                var val = $(this).attr('val'); 
                var oriVal = $(this).attr('ori_val'); 
                
                var data = {
                  id : id
                  ,val : val
                  ,lval : oriVal
                }

                l.confirm('确定要更改'+col_name+'状态吗？'
                    ,{ btn: ['确定','取消'] }
                    , function(){
                        l.msg('正在提交',{time: 0});
                        post_status = false;
                        $.post(colData.url,data,function(d){
                            l.closeAll();
                            if(d.status){
                                // console.log(col_idx);
                                row[colData.field] = data.val;
                                var html = callback_fun(data.val,row);
                                _this_col.html(html);
                            }else{
                                l.alert(d.msg);
                            }
                            post_status = true;
                        },'json');
                    }
                );
            });
        }
    }

    $.fn[pluginName] = function ( options ) {
        return this.each(function () { 
            if (!$.data(this, 'plugin_' + pluginName)) { 
                $.data(this, 'plugin_' + pluginName, new myDataTable( this, options )); 
            } 
        }); 
    }

    $(methods).each(function(k,v){
        var return_val = undefined;
        $.fn[v] = function(a,b,c,d,e,f,g,h,i,j){
            this.each(function (k,e) {
                if ($.data(this, 'plugin_' + pluginName)) { 
                    thisObj = $.data(this, 'plugin_' + pluginName);
                    if(typeof(thisObj[v]) === 'function'){
                        return_val = thisObj[v](a,b,c,d,e,f,g,h,i,j);
                    }else{
                        console.error(pluginName+': ['+v+'] method not defined!');
                    }
                } 
            }); 
            return return_val;
        }
    });
})(jQuery, window, document, layer);