/*! QNickSmartClick.JS - v1.2 - 2017.08.08 ~ 2017.08.10
 * 
 * 这个插件用途主要是跟click事件基本相同，
 * 跟click事件的唯一区别是，用click绑定的时候选择文本也会触发到单击事件
 * 为了解决选择文本的时候不激发click事件采用这个插件。
 * 
 * http://nickspace.cn/
 * Copyright (c) 2017 Nick Quan;
 * Licensed under the MIT license */
;(function ( $, w, d, undefined ) {

        var pluginName = 'smartClick',
            methods = [] ,
            defaults = { 
                cancelRange: 0  //容错基数，鼠标单击时基本上移动距离都为0，触屏的时候没试过
            }; 

        function smartClick(element, callback, options) { 
            this.element = element; 
            this.options = $.extend({}, defaults, options); 
            this._defaults = defaults; 
            this._name = pluginName; 
            this.init(callback); 

        } ;

        smartClick.prototype = {
            init: function(callback) {
                var mousedown = {
                    clientX:0
                    ,clientY:0
                };
                var el = this.element;
                var options = this.options;
                var isSelected = false;
                $(el).on('smartClick', callback);
                $(el).on('select', function(e) {
                    console.log('select');
                });
                $(el).on('mousedown', function(e) {
                    mousedown = e;

                    var text = w.getSelection().toString();
                    w.text = text;
                    if(text.length > 0){
                        isSelected = true;
                    }else{
                        isSelected = false;
                    }
                });
                $(el).on('mouseup', function(mouseup) {
                    if(!isSelected){                        
                        var clientX1 = mousedown.clientX;
                        var clientX2 = mouseup.clientX;
                        var clientY1 = mousedown.clientY;
                        var clientY2 = mouseup.clientY;
                        var moveX = Math.abs(clientX1 - clientX2);
                        var moveY = Math.abs(clientY1 - clientY2);
                        if (moveX <= options.cancelRange && moveY <= options.cancelRange) {
                            $(this).trigger("smartClick");
                        }
                    }
                });
            }
        }; //initialization
          
    $.fn[pluginName] = function ( options, status ) { //플러그인 함수 
        return this.each(function () { 
            if (!$.data(this, 'plugin_' + pluginName)) { 
                $.data(this, 'plugin_' + pluginName, new smartClick( this, options, status )); 
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
})(jQuery, window, document);