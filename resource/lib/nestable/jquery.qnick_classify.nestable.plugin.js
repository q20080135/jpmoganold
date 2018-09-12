/*!
 * QNick Classify jQuery Plugin - Copyright (c) 2012 David Bushell - http://nickspace.cn/
 * Nestable jQuery Plugin - Copyright (c) 2012 David Bushell - http://dbushell.github.io/Nestable/
 * Dual-licensed under the BSD or MIT licenses
 */
(function($, window, document, undefined)
{
    // event:
    // click_add_item :
    // click_edit_item :
    // click_delete_item :
    var defaults = {
            listNodeName    : 'ol',
            listClass       : 'dd-list',
            itemClass       : 'dd-item',
            dragClass       : 'dd-dragel',
            handleClass     : 'dd-handle',
            contentClass     : 'dd-content',
            collapsedClass  : 'dd-collapsed',
            placeClass      : 'dd-placeholder',
            noDragClass     : 'dd-nodrag',
            emptyClass      : 'dd-empty',
            btnGroupClass      : 'btn-group',
            btnAddClass      : 'btn_add_classify_item',
            btnEditClass      : 'btn_edit_classify_item',
            btnDeleteClass      : 'btn_del_classify_item',
            btnSaveClass      : 'btn_save_classify',
            btnExpandAll      : '#btn_expand_all',
            btnCollapseAll      : '#btn_collapse_all',
            btnActionGroupClass      : 'btn_action_group',
            btnAddHtml      : '<span class="btn btn-success size-S btn_add_classify_item"><i class="Hui-iconfont">&#xe600;</i></span>',
            btnEditHtml      : '<span class="btn btn-primary size-S btn_edit_classify_item"><i class="Hui-iconfont">&#xe647;</i></span>',
            btnDeleteHtml      : '<span class="btn btn-danger size-S radius btn_del_classify_item"><i class="Hui-iconfont">&#xe6e2;</i></span>',
            maxDepth        : 5,
        };
    function Plugin(element, options)
    {
        this.w  = $(document);
        this.el = $(element);
        this.options = $.extend({}, defaults, options);
        this.data_set = this.options.data_set;
        this.nestable = this.el.nestable(this.options);
        this.init();
    }    
    Plugin.prototype = {
        init: function()
        {   
            this.render_list(this.options.data_set); 
            var el = this.el;
            var opt =  this.options;
            var nestable = this.nestable;
            var _this_plugin = this;
            // var plugin = $(this).data("qnick_classify");
            nestable.on('change',function(e,change_el){
                // console.log(change_el);
                _this_plugin.sort(change_el);
                _this_plugin.re_depth(change_el);
                _this_plugin.reset();
                var d = el.nestable('serialize');
                if (window.JSON) {
                    var json = window.JSON.stringify(d);
                } else {
                    var json = 'JSON browser support required for this demo.'; 
                }
                $('#output').val(json);
            });

            $(document).on('click','.'+opt.btnAddClass,function(){
                var _this = $(this).parents('.'+opt.itemClass);
                var this_data = _this.data();
                var item_id = this_data.id;
                var type = typeof(item_id);
                if(typeof item_id == 'number'){ 
                    $(el).trigger('click_add_item',item_id);
                }else{
                    layer.alert('父母id去哪了？ parent_id呢？');
                }
            });

            $(document).on('click','.'+opt.btnEditClass,function(){
                var _this = $(this).parents('.'+opt.itemClass);
                var this_data = _this.data();
                var item_id = this_data.id;
                var type = typeof(item_id);
                if(typeof item_id == 'number'){
                    $(el).trigger('click_edit_item',item_id);
                }else{
                    layer.alert('id去哪了？ item_id呢？');
                }
            });
            $(document).on('click','.'+opt.btnDeleteClass,function(){
                var _this = $(this).parents('.'+opt.itemClass).first();
                layer.confirm('确认要删除？', {btn: ['是', '取消']},function(index){
                    $(el).trigger('click_delete_item',_this.data());
                    layer.closeAll();
                    _this_plugin.reset();
                });
            });
            $(document).on('click','.'+opt.btnSaveClass,function(){
                    
                layer.confirm('是否保存排序？', {btn: ['是', '取消']},function(index){
                    var change_item = _this_plugin.serialize_change_item();
                    // console.log(change_item);
                    $(el).trigger('save_classify',[change_item]);
                    layer.closeAll();
                });
            });

            $(opt.btnExpandAll).on('click',function(){
                el.nestable('expandAll');
            });
            $(opt.btnCollapseAll).on('click',function(){
                el.nestable('collapseAll');
            });
        },
        serialize_change_item: function(){
            var el = this.el;
            var opt = this.options;
            var change_items = $(el).find('.'+opt.itemClass+'.changed');
            var serialize = [];
            change_items.each(function(){
                var id = $(this).attr('data-id');
                var order = $(this).attr('data-order');
                var ori_order = $(this).attr('data-ori_order');
                var depth = $(this).attr('data-depth');
                var ori_depth = $(this).attr('data-ori_depth');
                var parent = $(this).attr('data-parent');
                var ori_parent = $(this).attr('data-ori_parent');
                var temp = {id:id};
                if(order != ori_order){
                    temp.order = order;
                }
                if(depth != ori_depth){
                    temp.depth = depth;
                }
                if(parent != ori_parent){
                    temp.parent = parent;
                }
                serialize.push(temp);
            });
            // console.log(serialize);
            return serialize;
        },
        get_depth: function(depth_el){
            var opt = this.options;
            return $(depth_el).parents(opt.listNodeName).length;
        },
        re_depth: function(change_el){
            var opt = this.options;
            var _this = this;
            $(change_el).find('.'+opt.itemClass).each(function(i,e){
                var depth = _this.get_depth(e);
                $(e).attr('data-depth',depth);
                // console.log('id: '+$(e).attr('data-id')+' depth: '+ depth);
            });
            // console.log('re_depth');
        },
        sort: function(change_el)
        {
            var opt = this.options;
            var _this = this;

            var parent = $(change_el).parent().parent(opt.itemNodeName).first();
            var parent_id = 0;
            if(parseInt(parent.attr('data-id'))>0){
                parent_id = parseInt(parent.attr('data-id'));
            }
            var depth = this.get_depth(change_el);
            // var next = $(change_el).next(opt.itemNodeName);
            // var prev = $(change_el).prev(opt.itemNodeName);

            // var prev_order = parseFloat(prev.attr('data-order'));
            // var this_order = parseFloat($(change_el).attr('data-ori_order'));
            // var next_order = parseFloat(next.attr('data-order')); 
            
            // if(isNaN(prev_order)) prev_order = 0;
            // if(isNaN(this_order)) this_order = 0;
            // if(isNaN(next_order)) next_order = 0;

            var siblings = $(change_el).parent(opt.listNodeName).children(opt.itemNodeName);
 
            var index = $(siblings).index($(change_el));

            // if(!(prev_order<this_order && (this_order<next_order || next_order == 0))){
                $(change_el).removeAttr('data-order'); 
            //     console.log('removeAttr');
            // }

            // console.log('prev: '+prev_order);
            // console.log('this: '+this_order);
            // console.log('next: '+next_order);
            // console.log('this_prev: '+(prev_order<this_order));
            // console.log('next_this: '+(this_order<next_order));
            // console.log('next_is0: '+(next_order == 0));
            
            //选出要排序的元素
            var start = -1,
            end = -1,
            start_status = false,
            current_status = false,
            end_status = false;

            // console.log($($(change_el)).html()); 
            $(siblings).each(function(i,e){
                // console.log('siblings id:'+$(e).attr('data-id') + ' changed:'+ _this.is_change_order(e));
                if (!(start_status && current_status && end_status)) {
                    if(!start_status){  //判断是否记录开始指针
                        if(!_this.is_change_order(e)){  //保存开始指针
                            start = i;
                            // console.log('set start: '+ i);
                        }else{                          //当前元素有改动不在记录开始指针
                            start_status = true;
                            // console.log('set start true');
                        }
                    }
                    if(!current_status){    //判断是否当前区域
                        if(index == i){
                            start_status = true;
                            current_status = true;
                            // console.log('set current: '+ i);
                            return true;
                        }
                    }
                    if(!end_status){  //判断是否记录结束指针
                        if(current_status && !_this.is_change_order(e)){    
                                end_status = true;
                                end = i;
                                // console.log('set end: '+ i);
                        }else if(!_this.is_change_order(e)){    //重新记录开始指针
                            start_status = false;
                            start = i;
                            // console.log('set start@end: '+ i);
                        }
                    }
                }
                // console.log('break: '+ i);
            });
            var count = (end!=-1?end:$(siblings).length)  - (start!=-1?(start+1):0);
            var min = max = 0;
            if(start>=0){
                min = $(siblings).eq(start).attr('data-order');
            }
            if(end>=0){
                max = $(siblings).eq(end).attr('data-order');
            }
            var numbers = _this.between_num(min,max,count);

            // if(count == 1)
            // console.log(numbers);
            var obj,data;
            for (var i = 0; i < numbers.length; i++) {
                obj = $(siblings).eq(start+i+1);
                data = {
                    order : numbers[i]
                    ,parent : parent_id
                    ,depth : depth
                }
                this.set_content(obj,data);
                // console.log('sibling:'+i+' id:'+obj.attr('data-id'));
                // console.log('sibling:'+i);
                // console.log(data);
            }
            // console.log('min_order_no: '+min);
            // console.log('max_order_no: '+max);
            // console.log('start: '+start);
            // console.log('end: '+end);
            // console.log('count: '+count);
            // console.log('result_end: '+(end?end:$(siblings).length));
            // console.log('length: '+$(siblings).length);
        },
        reset: function(){
            var _this = this;
            var opt = this.options;



            $(this.el).find('.'+opt.itemClass).each(function(i,e){

                // var content = 'id:'+ $(e).attr('data-id');
                // content += ' depth:'+ $(e).attr('data-depth');
                // content += ' ori_dep:'+ $(e).attr('data-ori_depth');

                // $(e).children('.dd-content').children('span.dd-text').text(content);
                
                // $(e).attr('data-content',content);
                $(e).trigger('reset_item',$(e));


                var prev = $(e).prev(opt.itemNodeName);
                var next = $(e).next(opt.itemNodeName);
                if(_this.is_change_order(e)){
                    $(e).addClass('changed');
                }else{
                    $(e).removeClass('changed');
                }
            });

            if($(this.el).find('.changed').length >0){
                // console.log('have change');
                $('.'+opt.btnSaveClass).css('visibility','visible');
            }else{
                // console.log('no change');
                $('.'+opt.btnSaveClass).css('visibility','hidden');
            }

            if($(this.el).find('button[data-action]').length >0){ 
                $('.'+opt.btnActionGroupClass).css('visibility','visible');
            }else{ 
                $('.'+opt.btnActionGroupClass).css('visibility','hidden');
            }
            var item_length = $(this.el).find('.'+opt.itemClass).length;

            if(item_length > 10){
                $('.btn_add_class_top').css('visibility','visible');
            }else{
                $('.btn_add_class_top').css('visibility','hidden');
            }
        },
        set_content: function(e,data){
            // console.log(data);
            e.attr('data-order',data.order);
            e.attr('data-depth',data.depth);
            if(data.parent > 0){
                e.attr('data-parent',data.parent);
            }else{
                e.attr('data-parent',0);
            }
            e.children('.dd-content').children('span.dd-order').text(data.order);
        },
        is_change_order: function(e){
            var order = $(e).attr('data-order');
            var ori_order = $(e).attr('data-ori_order');
            var parent = $(e).attr('data-parent');
            var ori_parent = $(e).attr('data-ori_parent');
            var depth = $(e).attr('data-depth');
            var ori_depth = $(e).attr('data-ori_depth');
            if(order != ori_order || parent != ori_parent || depth != ori_depth){
                return true;
            }else{
                return false;
            }
        },
        slim_num : function(num,step){
            var reg = /[1-9]/g;
            reg.test(step.toString());
            var zero_count = RegExp.leftContext;
            zero_count = zero_count.replace(/\./,'').length;
            var pow = Math.pow(10,zero_count);
            return Math.floor(num * pow)/pow;
        },
        between_num : function(min,max,count){
            min = parseFloat(min);
            max = parseFloat(max);
            count = parseInt(count);

            if(isNaN(min)) min = 0;
            if(isNaN(max)) max = 0;
            if(isNaN(count)) count = 0;

            var gap = max - min;
            var numbers = [];
            if(gap > 0){
                var segment = gap/(count+1);
                // console.log('gap:'+gap);
                // console.log('segment:'+segment);
                var number = min;
                for (var i = 0; i < count; i++) {
                    number += segment;
                    numbers.push(this.slim_num(number,segment));
                }
                return numbers;
            }else{
                if(max == 0){
                    for (var i = 0; i < count; i++) {
                        numbers.push(min+i+1);
                    }
                    return numbers;
                }else{
                    console.log('已有的排序有误！');
                    return null;
                }
            }
        },
        render_list: function(data){
            var container = this.el;

            if(typeof(data) == 'object' && data.length > 0){ 
                $(container).append(this.set_dd_list(data,container));
            }else{
                var dd = this.set_dd_list_wrapper();
                $(container).append(dd);
            }
            this.reset();
        },
        set_dd_list_wrapper: function(){ 
            var ol = '<ol class="'+this.options.listClass+'"></ol>';
            return $(ol);
        },
        set_dd_list: function (list,e){ 
            if(typeof(list) == 'object' && list.length > 0){
                var dd = this.set_dd_list_wrapper();
                // html += '<ol class="dd-list">';
                for (var i = 0; i < list.length ; i++) {
                    dd_item = this.fix_item_data(list[i]);
                    obj_dd_item = this.set_dd_item(dd_item);
                    $(dd).append(obj_dd_item); 

                    if(typeof(dd_item.children) == 'object' && dd_item.children.length > 0){
                        $(obj_dd_item).append(this.set_dd_list(dd_item.children,obj_dd_item));
                    } 
                }
                $(e).append(dd);
            }
        },
        get_last_order_seq: function(parent){

            var el = this.el;
            var opt = this.options;
            
            parent = parseInt(parent);
            if(parseInt(parent) > 0){
                parent_obj = $('.'+opt.itemClass+"[data-id='"+parent+"']");
                if(parent_obj.length > 0){
                    el = parent_obj;
                }
            }

            var order = parseInt($(el).find('.'+opt.itemClass).last().attr('data-order'));


            if(isNaN(order)) {
                order = 0;
            }
            return order;
        },
        set_dd_item: function (item){
            var html = '';
            var attr = '';
            var content = '';
            var order_html = '';

            // console.log(item);
            if(item.ori_order == undefined) item.ori_order = item.order;
            if(item.ori_depth == undefined) item.ori_depth = item.depth;
            if(item.ori_parent == undefined) item.ori_parent = item.parent;
            $.each(item,function(name,value) { 
                if(value == null){
                    value = '';
                }
                attr += ' data-'+name+'="'+value+'"';
                if(name == 'content'){
                    content = value;
                }
                if(name == 'order'){
                    order_html += '<span class="dd-order">'+value+'</span>';
                }
            });
            html += '<li class="'+this.options.itemClass+'"'+attr+'>';
            html += '   <div class="'+this.options.handleClass+'">Drag</div>';
            html += '   <div class="'+this.options.contentClass+'">';
            html += '       <span class="dd-text">'+content+'</span>';
            html +=         order_html;
            html += '       <div class="'+this.options.btnGroupClass+'">';
            html +=             this.options.btnAddHtml;
            html +=             this.options.btnEditHtml;
            html +=             this.options.btnDeleteHtml;
            html += '       </div>';
            html += '   </div>';
            html += '</li>';
            // console.log(html);
            return $(html);
        }
        ,fix_item_data : function(item_data){

            var opt = this.options;

            if(item_data.parent == undefined){
                item_data.parent = 0;
                item_data.ori_parent = 0; 
            }else{
                item_data.ori_parent = item_data.parent; 
            }

            var parent_selector = '.'+opt.itemClass+"[data-id='"+item_data.parent+"']";
            var depth = this.get_depth($(parent_selector));
            if(depth < opt.maxDepth){
                depth = depth + 1;
            }
            
            if(item_data.depth == undefined){
                item_data.depth = depth;
                item_data.ori_depth = -1; 
            }else{
                item_data.ori_depth = item_data.depth; 
                item_data.depth = depth; 
            }

            var last_order = this.get_last_order_seq(item_data.parent);

            // console.log('last_order: '+last_order);
            // console.log(item_data.order);
            //item_data.order 空为 1
            if(item_data.order == undefined){
                item_data.order = last_order+1;
                item_data.ori_order = item_data.order;
            }else{
                if(last_order < item_data.order){
                    // console.log('ori_order');
                    item_data.ori_order = item_data.order;
                }else{
                    // console.log('new_order');
                    item_data.ori_order = item_data.order;
                    item_data.order = last_order+1; 
                }
            }
            return item_data;
        }
    };
    $.fn.is_qnick_classify_plugin = function(callback){
        var plugin = $(this).data("qnick_classify");
        if (!plugin) { 
            console.log('no qnick_classify created');
            return null;
        } else {
            return callback();
        } 
    }
    $.fn.get_data = function(){
        var plugin = $(this).data("qnick_classify"); 
        return $(this).is_qnick_classify_plugin(function(){ 
            return plugin.data_set;
        }); 
    };
    $.fn.remove_item = function(item_data){
        var plugin = $(this).data("qnick_classify"); 
        var opt = plugin.options; 
        var this_obj = $('.'+opt.itemClass+"[data-id='"+item_data.id+"']");
        if($(this_obj).siblings().length == 0){
            var parent = $(this_obj).parents('.'+opt.itemClass).first();
            $(parent).find("button[data-action]").remove();
            $(parent).find('.'+opt.listClass).remove();
        }
        this_obj.remove();
    };
    $.fn.get_last_order_seq = function(item_id){
        var plugin = $(this).data("qnick_classify"); 
        return plugin.get_last_order_seq(item_id); 
    };
    $.fn.get_depth = function(item_id){
        var plugin = $(this).data("qnick_classify");  
        var opt = plugin.options; 
        var parent_selector = '.'+opt.itemClass+"[data-id='"+item_id+"']";
        var depth = plugin.get_depth($(parent_selector)); 
        return depth; 
    };
    $.fn.get_next_depth = function(item_id){
        var plugin = $(this).data("qnick_classify");  
        var opt = plugin.options; 
        var parent_selector = '.'+opt.itemClass+"[data-id='"+item_id+"']";
        var depth = plugin.get_depth($(parent_selector)); 
        if(depth < opt.maxDepth){
            depth += 1;
        }
        return depth; 
    };
    $.fn.reset = function(item_id){
        var plugin = $(this).data("qnick_classify");  
        plugin.reset(); 
    };
    $.fn.add_item = function(item_data){
        var plugin = $(this).data("qnick_classify"); 
        var opt = plugin.options; 
        var el = this.el;
        if(item_data == undefined){
            return false;
        }
        // console.log('parent_depth:'+depth);
        //item_data.parent 空为 0
        item_data = plugin.fix_item_data(item_data);
        var parent_selector = '.'+opt.itemClass+"[data-id='"+item_data.parent+"']";
        var depth = plugin.get_depth($(parent_selector))+1; 


        $(this).is_qnick_classify_plugin(function(){ 

             
            var container = null;
            var item_obj = $('.'+opt.itemClass+"[data-id='"+item_data.id+"']");

            // console.log(item_data);
            var html = plugin.set_dd_item(item_data);

            if(item_obj.length >= 1){
                // console.log('item_obj.length:'+item_obj.length);
                layer.alert('有重复ID['+item_data.id+']!');
                return false;
            }

            if(depth == 1){
                // 添加到root
                container = plugin.el.children(opt.listNodeName);
            }else{

                if (depth > opt.maxDepth) {
                    // 添加到同层
                    // console.log('max depth');
                    container = plugin.el.find(parent_selector).parent(opt.listNodeName);
                }else{
                    // 添加到子层
                    // console.log('添加到子层');
                    // console.log('depth: '+depth);
                    // console.log('opt.maxDepth: '+opt.maxDepth);
                    container = plugin.el.find(parent_selector).children(opt.listNodeName); 
                    if(container.length == 0){
                        var dd = plugin.set_dd_list_wrapper(); 
                        $(parent_selector).append(dd);

                        container = plugin.el.find(parent_selector).children(opt.listNodeName);
                        plugin.el.nestable('setParent',$(parent_selector));
                    } 
                    
                }
 
            }
            $(container).append(html);
            plugin.reset();
        }); 
    };

    $.fn.qnick_classify = function(params)
    {
        var lists  = this,
            retval = this;
 
        var plugin = $(this).data("qnick_classify");
        if (!plugin) {
            $(this).data("qnick_classify", new Plugin(this, params));
            $(this).data("qnick_classify-id", new Date().getTime());
        } else {
            if (typeof params === 'string' && typeof plugin[params] === 'function') {
                retval = plugin[params]();
            }
        } 

        return retval || lists;
    };
})(window.jQuery || window.Zepto, window, document);