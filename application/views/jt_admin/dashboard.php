<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Widget::load('layout_tpl',array('view'=>'pre_header','data'=>array('title'=>'总后台管理')));

Widget::load('layout_tpl',array('view'=>'common_script'));?>
<!-- ECharts单文件引入 -->
<script src="https://cdn.bootcss.com/echarts/3.7.1/echarts.common.min.js"></script>
<?=res_url('dash_board.css?1')?>
<style>
.chart{width: 100%; height: 400px}
</style>
<?php

Widget::load('layout_tpl',array('view'=>'open_body_tag'));

?>
<div class="page-container">
    <div class="content-block col-xs-12 col-sm-12">
        <p class="title">交易记录</p>
        <div class="content-info">
            <div class="item">
                <i class="item-icon icon1"></i>
                <div class="item-desc">
                    <p class="count"><?=$DaiFuKuan?></p>
                    <p class="desc">待付款</p>
                </div>
            </div>
            <div class="item">
                <i class="item-icon icon2"></i>
                <div class="item-desc">
                    <p class="count"><?=$DaiFaHuo?></p>
                    <p class="desc">待发货</p>
                </div>
            </div>
            <div class="item">
                <i class="item-icon icon3"></i>
                <div class="item-desc">
                    <p class="count"><?=$DaiShouHuo?></p>
                    <p class="desc">待收货</p>
                </div>
            </div>
            <div class="item">
                <i class="item-icon icon4"></i>
                <div class="item-desc">
                    <p class="count"><?=$DaiChuLi?></p>
                    <p class="desc">待处理</p>
                </div>
            </div>
            <div class="item">
                <i class="item-icon icon5"></i>
                <div class="item-desc">
                    <p class="count"><?=$TuiKuan?></p>
                    <p class="desc">退款/售后</p>
                </div>
            </div>
        </div>
    </div>
    <div class="content-block col-xs-12 col-sm-2 col-25" >
        <p class="title">商品统计</p>
        <div class="content-info">
            <div class="counter">
                <p class="count"><?=$产品日新增?></p>
                <p class="desc">昨日新增</p>
            </div>
            <div class="counter">
                <p class="count"><?=$累计上架商品?></p>
                <p class="desc">累计商品</p>
            </div>
        </div>
    </div>
    <div class="content-block col-xs-12 col-sm-2 col-25">
        <p class="title">入驻商统计</p>
        <div class="content-info">
            <div class="counter">
                <p class="count"><?=$入住商日新增?></p>
                <p class="desc">昨日入驻</p>
            </div>
            <div class="counter">
                <p class="count"><?=$累计入住商?></p>
                <p class="desc">累计入驻</p>
            </div>
        </div>
    </div>
    <div class="content-block col-xs-12 col-sm-3 col-30">
        <p class="title">用户数据</p>
        <div class="content-info">
            <div class="counter">
                <p class="count"><?=$用户日新增?></p>
                <p class="desc">昨日新注册</p>
            </div>
            <div class="counter">
                <p class="count"><?=$日活跃用户?></p>
                <p class="desc">昨日活跃</p>
            </div>
            <div class="counter">
                <p class="count"><?=$总注册用户?></p>
                <p class="desc">总注册用户</p>
            </div>
        </div>
    </div>
    <div class="content-block col-xs-12 col-sm-2 col-20">
        <p class="title mb-5">APP版本信息</p>
        <div class="content-info">
            <div class="platform">
                <i class="platform-icon android"></i>
                <div class="info_wraper">
                    <p class="info">
                        <span class="info-title">当前版本</span>
                        <span class="info-value"><?=$android_now?></span>
                    </p>
                    <p class="info">
                        <span class="info-title">更新版本</span>
                        <span class="info-value"><?=$android_update?></span>
                    </p>
                </div>
            </div>
            <div class="platform">
                <i class="platform-icon ios"></i>
                <div class="info_wraper">
                    <p class="info">
                        <span class="info-title">当前版本</span>
                        <span class="info-value"><?=$ios_now?></span>
                    </p>
                    <p class="info">
                        <span class="info-title">更新版本</span>
                        <span class="info-value"><?=$ios_update?></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="content-block col-xs-12 col-49">
        <div id="chart-user" class="chart"></div>
    </div>
    <div class="content-block col-xs-12 col-50">
        <div id="chart-order" class="chart"></div>
    </div>
    <div class="clear"></div>
</div>



    <script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    var myChart1 = echarts.init(document.getElementById('chart-user'));
    var myChart2 = echarts.init(document.getElementById('chart-order'));

    // 指定图表的配置项和数据
var option = {
    title: {
        text: '用户统计'//报表名
        ,top: 10
        ,left:-5
    },
    grid: {
        top:80
    },
    tooltip : {
        trigger: 'axis'
    },
    legend: {
        top:13
        ,right:'10%'
        ,data:['新增数量','新增数量','平均温度']
    },
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
            axisLine: {
                lineStyle: {
                    color: '#999'
                }
            },

            splitLine: {
                show:true, 
                lineStyle: { 
                    // 使用深浅的间隔色
                    color: ['#ddd'],
                    type:'dashed'
                }
            },
            data : []
        }
    ],
    yAxis : [
        {
            type : 'value'
            ,name : '注册数量'
            ,axisLine: {
                lineStyle: {
                    color: '#999'
                }
            },
            splitLine: {
                show:true, 
                lineStyle: { 
                    // 使用深浅的间隔色
                    color: ['#ddd'],
                    type:'dashed'
                }
            },
        }
    ],
    series : [
        {
            name:'',
            type:'line',
            markPoint: {
                data: [
                    {type: 'max', name: '最大值'}
                ]
            },
            markLine: {
                data: [
                    {type: 'average', name: '平均值'}
                ]
            }
        }

    ]
};



var option1 = {
    title: {
        text: '用户统计'//报表名
    }, 
    yAxis : [
        {
            name : '注册数量'
        }
    ]
};
var option2 = {
    title: {
        text: '交易统计'//报表名
    },
    legend: {
        data:['加入购物车','提交订单','支付订单']
    },
    yAxis : [
        {
            name : '数量'
        }
    ]
};
    setAnalisis();
    // 使用刚指定的配置项和数据显示图表。
    myChart1.setOption($.extend(true,{}, option, option1));
    myChart2.setOption($.extend(true,{}, option, option2));


    function setAnalisis(){
        var url = '<?=site_url('jt_admin/dashboard/get_analisis')?>';
        // 异步加载数据
        var data = {};
        $.get(url,data,function(rs){
            myChart1.setOption({
                xAxis:{data:rs.date},
                series: [{
                    name: '注册数量',
                    itemStyle:{
                        normal:{
                            color:'#305de1'
                        } 
                    }, 
                    data: rs.user_count
                    }]
            });


            myChart2.setOption({
                xAxis:{data:rs.date},
                series: [
                    {
                        name: '加入购物车',
                        type:'line',
                        itemStyle:{
                            normal:{
                                color:'#72cf00'
                            } 
                        }, 
                        data: rs.cart_count
                    }
                    ,{
                        name: '提交订单',
                        type:'line',
                        itemStyle:{
                            normal:{
                                color:'#305de1'
                            } 
                        }, 
                        data: rs.order_count,
                        markPoint: {
                            data: [
                                {type: 'max', name: '最大值'}
                            ]
                        },
                        markLine: {
                            data: [
                                {type: 'average', name: '平均值'}
                            ]
                        }
                    }
                    ,{
                        name: '支付订单',
                        type:'line',
                        itemStyle:{
                            normal:{
                                color:'#d0a500'
                            } 
                        }, 
                        data: rs.pay_count,
                        markPoint: {
                            data: [
                                {type: 'max', name: '最大值'}
                            ]
                        },
                        markLine: {
                            data: [
                                {type: 'average', name: '平均值'}
                            ]
                        }
                    }
                ]
            });
        },'json')
        .error(function(){ 
            layer.alert("加载统计数据失败！"); 
        });

    }


    </script>

<?php Widget::load('layout_tpl',array('view'=>'footer'));?>
<?php Widget::load('layout_tpl',array('view'=>'close_body_tag'));?>