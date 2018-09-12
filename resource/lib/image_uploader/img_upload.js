/**
 * 
 * 单张图片上传
 * CI框架为基础的自定义标签
 * 使用方法：common_helper.php->render_single_image_uploader()
 * <?=res_url('image_uploader/img_upload.js','lib')?>
 * <?=res_url('image_uploader/style.css','lib')?>
 * <?=render_single_image_uploader('p_img','248','165',array('placeholder'=>'上传产品图片','datatype'=>'*','nullmsg'=>'请添加产品图片！'))?>
 *
 * Copyright 2007 - 2016 NickSpace All Rights Reserved. (http://nickspace.cn)
 * 
 */
$(document).ready(function() { 
    $('.single_image_uploader').hover(function(){
        $(this).find('.btn_rotation_left').delay(50);
        $(this).find('.btn_rotation_left').animate({
            filter:"alpha(opacity=100)",opacity:"1",right:0
        },150);
        $(this).find('.btn_rotation_right').animate({
            filter:"alpha(opacity=100)",opacity:"1",right:0
        },150);
    },function(){
        $(this).find('.btn_rotation_left').animate({
            filter:"alpha(opacity=0)",opacity:"0",right:20
        },150);
        $(this).find('.btn_rotation_right').delay(50);
        $(this).find('.btn_rotation_right').animate({
            filter:"alpha(opacity=0)",opacity:"0",right:20
        },150);

    });
});

(function($){     

    var o_set = [1,8,3,6];
    var options = {
        maxWidth: 800, maxHeight: 800
    }
    var curr_orientation = 0;
    if (!window.FileReader) {
        alert('浏览器不支持！');
        // console.log('浏览器不支持！');
        return;
    }
    var reader = new FileReader(); 

    // 在我们插件容器内，创造一个公共变量来构建一个私有方法
    var orientation = function(thisObj,orien,callback){
        var img = thisObj.find('.img_uploader').eq(0);
        var img_file = !!$(img).get(0).files[0] ? $(img).get(0).files[0] : null;
        // console.log(img_file);
        if (img_file == null) {
            if(thisObj.find('.validform').val() == 'uploaded'){
                remove_render_img(thisObj);
            }else{
                alert('上传图片先~');
                console.log('上传图片先~');
            }
            return;

        } 
        reader.onload = function ( event ) {  
            var mpImg = new MegaPixImage(img_file);

            // Render resized image into canvas element.
            var resCanvas = document.createElement('canvas');  

            mpImg.render(resCanvas, { maxWidth: options.maxWidth, maxHeight: options.maxHeight, orientation: orien}, function(d){
                callback(d);
            });

        };
        reader.readAsDataURL(img_file);
    }

    var render_img = function(container,data){
        container.find('.img_viewer').attr('src',data);
        container.find('.img_data').val(data.split(',')[1]);
        container.find('.validform').val('uploaded');
    }
    var remove_render_img = function(container){
        container.find('.img_viewer').attr('src','');
        container.find('.img_data').val('');
        container.find('.validform').val('');
    }
 
    // 通过字面量创造一个对象，存储我们需要的共有方法
    var methods = {
        // 在字面量对象中定义每个单独的方法
        init: function() {
        
            // 为了更好的灵活性，对来自主函数，并进入每个方法中的选择器其中的每个单独的元素都执行代码
            return this.each(function() {
                // 为每个独立的元素创建一个jQuery对象
                var $this = $(this);
                if($("[id='"+$this.attr('id')+"']").length > 1){
                    var id_val = $this.attr('id').replace(/single_image_uploader_/,'');
                    console.error('single_image_uploader: ID名称['+id_val+'] 重复！');
                }
                var input_file_obj = $this.find('.img_uploader').eq(0);

                $this.find('.btn_rotation_left').on('click',function(){   //向左旋转
                    curr_orientation = (curr_orientation+1) % 4;
                    orientation($this,o_set[curr_orientation],function(d){
                        render_img($this,d);
                    });
             
                });
                $this.find('.btn_rotation_right').on('click',function(){   //向右旋转
                    curr_orientation = (curr_orientation+3) % 4;
                    orientation($this,o_set[curr_orientation],function(d){
                        render_img($this,d);
                    });
                });
                input_file_obj.on("change", function(){    //上传图片后显示图片
                    // console.log(input_file_obj);
                    orientation($this,1,function(d){
                        render_img($this,d);
                    }); 
                }); 
            });
        },
        destroy: function() {
            // 对选择器每个元素都执行方法
            return this.each(function() {
                // 执行代码
            });
        }
    };
 
    $.fn.singleImageUploader = function() {
        // 获取我们的方法，遗憾的是，如果我们用function(method){}来实现，这样会毁掉一切的
        var method = arguments[0];
 
        // 检验方法是否存在
        if(methods[method]) {
            method = methods[method];
        } else if( typeof(method) == 'object' || !method ) {
            // 如果我们传入的是一个对象参数，或者根本没有参数，init方法会被调用
            method = methods.init;
        } else {
            $.error( 'Method ' +  method + ' does not exist on jQuery.singleImageUploader' );
            return this;
        }
        return method.call(this);
    }
})(jQuery);    

