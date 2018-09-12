
// 限制只能提交一次
var post_status = true;

function post_item(data, options, s_callback){
    if(post_status) {
        var defaults = {
            'limit_length' : 1  //判断有没有提交数据
            ,'confirm_msg' : '确认提交？'
            ,'btn_yes_text' : '是'
            ,'btn_no_text' : '取消'
            ,'post_url' : null
        }
        var opt = $.extend({}, defaults, options);
        if(data.id === undefined){
          layer.msg('没有ID，请刷新重试一下');
          console.log('如果是insert，把data.id设置为null');
          return false;
        }
        if(!$.isNumeric(data.id) && data.id !== null){
          layer.msg('ID不是数字形式！');
          return false;
        }

        if(Object.keys(data).length == opt.limit_length){
            layer.msg('没有可提交数据。');
            return false;
        }
        if(opt.post_url === null){
            layer.msg('请设置post_url！');
            return false;
        }

        layer.confirm(opt.confirm_msg, {btn: [opt.btn_yes_text, opt.btn_no_text]},function(index){            
            layer.msg('正在提交...',{time:0});
            var url = opt.post_url;
            post_status = false;
            $.post(url,data,function(data){
                if(data.status){
                  // location.reload();
                  s_callback();
                }else{
                  layer.alert(data.msg);
                }
                post_status = true;
            },'json')
            .error(function(){ 
                post_status = true;
                layer.alert("提交失败！"); 
            });
        });
    }
}