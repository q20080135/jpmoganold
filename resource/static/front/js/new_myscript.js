jQuery(document).ready(function($){	
$(".header_language .title").click(function(){
	if(!$(this).hasClass("current"))
	{
	  $(this).addClass("current");	
	  $(this).parent().find(".item_list").slideDown("fast");
	}
	else
	{ 
	  $(this).removeClass("current");
	  $(this).parent().find(".item_list").slideUp("fast");
	}
	
	return false;
});

		 
// menu-header-menu				 
// jQuery("#menu-header-menu > li").each(function(i){

// 	  if(jQuery(this).find("ul").length>0)
// 	  {
// 		  jQuery(this).append("<div class='submenu_box submenu_box"+(i+1)+"'><div class='submenu_inner'></div></div>");
// 		  jQuery(".submenu_box"+(i+1)+" .submenu_inner").append("<div class='subtitle'></div>");
// 		  jQuery(".submenu_box"+(i+1)+" .submenu_inner").append(jQuery(this).find("ul").eq(0));
// 	  }

// });

// jQuery(".submenu_box1 .submenu_inner").append($(".sub_menu_right_box").html());
// jQuery(".submenu_box2 .submenu_inner").append($(".sub_menu_right_box").html());
// jQuery(".submenu_box3 .submenu_inner").append($(".sub_menu_right_box").html());
// jQuery(".submenu_box4 .submenu_inner").append($(".sub_menu_right_box").html());
// jQuery(".submenu_box5 .submenu_inner").append($(".sub_menu_right_box").html());
// jQuery(".submenu_box6 .submenu_inner").append($(".sub_menu_right_box").html());

$("#menu-header-menu > li").hover(function(){
	$(this).find(".submenu_box").show();
},function(){
	$(this).find(".submenu_box").hide();
});
// menu-header-menu


//导航栏MT4电脑版 移动版 app版跳转到指定位置
$("#pc").click(function(){
   var t=$('.mt4pc_view_bot').offset().top+650;
   $("html,body").animate({ scrollTop: t}, 500);
   $("#mt4pc1").attr("checked",true)
})
$("#mobile").click(function(){
   var t=$('.mt4pc_view_bot').offset().top+650;
   $("html,body").animate({ scrollTop: t}, 500);
  $("#mt4pc2").attr("checked",true)
})

$("#app").click(function(){
   var t=$('.mt4pc_view_bot').offset().top+650;
   $("html,body").animate({ scrollTop: t}, 500);
  $("#mt4pc3").attr("checked",true)
})

//帮助中心跳转到指定位置
$("#xiaozhi").click(function(){
   var t=$('.helpcenter_main_top').offset().top-180;
   $("html,body").animate({ scrollTop: t}, 500);
   $("#helpcenter1").attr("checked",true)
})
$("#churu").click(function(){
   var t=$('.helpcenter_main_top').offset().top-180;
   $("html,body").animate({ scrollTop: t}, 500);
   $("#helpcenter2").attr("checked",true)
})

$("#zhanghu").click(function(){
   var t=$('.helpcenter_main_top').offset().top-180;
   $("html,body").animate({ scrollTop: t}, 500);
   $("#helpcenter3").attr("checked",true)
})
$("#product").click(function(){
   var t=$('.helpcenter_main_top').offset().top-180;
   $("html,body").animate({ scrollTop: t}, 500);
   $("#helpcenter4").attr("checked",true)
})

$("#trade").click(function(){
   var t=$('.helpcenter_main_top').offset().top-180;
   $("html,body").animate({ scrollTop: t}, 500);
   $("#helpcenter5").attr("checked",true)
})


//产品规则
$("#ruler1").click(function(){
   $("#rule1").attr("checked",true);
  
})
$("#ruler2").click(function(){
   $("#rule2").attr("checked",true);
})

$("#ruler3").click(function(){
   $("#rule3").attr("checked",true);
})

//平台公告
$("#platform").click(function(){
   $("#announcement1").attr("checked",true)
})
$("#news").click(function(){
   $("#announcement2").attr("checked",true)
})

$("#dailynews").click(function(){
   $("#announcement3").attr("checked",true)
})

// 账户
$("#sanda").click(function(){
   $("#account1").attr("checked",true)
})
$("#mam").click(function(){
   $("#account2").attr("checked",true)
})

//资料下载
$("#ziliao").click(function(){
   $("#datadownload1").attr("checked",true)
})
$("#zhinan").click(function(){
   $("#datadownload2").attr("checked",true)
})

//培训课堂
$("#xiaobai").click(function(){
   $("#training1").attr("checked",true)
})
$("#gaoshou").click(function(){
   $("#training2").attr("checked",true)
})

$("#shipin").click(function(){
   $("#training3").attr("checked",true)
})

//FX词典

$("#common").click(function(){
   $("#dictionary1").attr("checked",true)
})
$("#professional").click(function(){
   $("#dictionary2").attr("checked",true)
})

$("#basic").click(function(){
   $("#dictionary3").attr("checked",true)
})
$("#technical").click(function(){
   $("#dictionary4").attr("checked",true)
})
$(".home_news_section .right_box .title_box a").click(function(){
		if(!$(this).hasClass("active"))
		{
			var thisid=$(this).attr("rel");
			$(this).parent().find("a").removeClass("active");
			$(this).addClass("active");
			$(this).parent().parent().find(".tab_box").hide();
			$(this).parent().parent().find("#"+thisid).show();
		}
		return false;
	});



/*******small menu**************/
	/*$(".mobile_menu_button").click(function(){
		$(".small_header").slideToggle();
		return false;		
	});	
	var maxMenu=0;
	$(".mobile_menu ul").each(function(){
		$(this).attr("rel","0");
	});
	$(".small_menu li").each(function(i){
		var menucount=parseInt($(this).parent().attr("rel"),10)+1;
		$(this).parent().attr("rel",menucount);
	});

	maxMenu=parseInt($(".small_menu > li").length,10);
	$(".small_header").height((((maxMenu+1)*47-7)+maxMenu)+"px");
	

	var stime_menu;
	$(".small_menu li").each(function(){
		if($(this).find("ul").length>0)
		{
			var thistext=$(this).find("a").eq(0).html();
			$(this).find("a").eq(0).html("<span class='text_box'>"+thistext+"</span><span class='arrow_box'>&gt;</span>");
		}
		else
		{
			var thistext=$(this).find("a").eq(0).html();
			$(this).find("a").eq(0).html("<span class='full_text_box'>"+thistext+"</span>");
		}
	});
	function GetWidth()
	{
		var maxwidth=$(window).width();
		$(".mobile_menu").css("width",maxwidth+"px");
		$(".mobile_menu .text_box").css("width",(maxwidth-50-40)+"px")
		stime_menu=setTimeout(function(){GetWidth();},10);
	}
	
	$(window).resize(function(){
		clearTimeout(stime_menu);
		GetWidth();
	});
	GetWidth();
	var menutag=1;
	$(".arrow_box").click(function(){
	
	  var thishref=$(this).parent().attr("href");
	  var thistext=$(this).parent().find(".text_box").eq(0).html();
	   if(menutag==3)
	   {
		$(this).parent().parent().find("ul").eq(0).show();
		$(".subsubsub_menu_header").append("<a href='"+thishref+"' rel='"+$(this).parent().parent().parent().attr("rel")+"' class='title_link'>"+thistext+"</a>");
		$(".small_menu").animate({left:"-300%"},500);
		$(".menu_header_inner").animate({left:"-300%"},500);
		menutag=4;
	   }
	   if(menutag==2)
	   {
		$(this).parent().parent().find("ul").eq(0).show();
		$(".subsub_menu_header").append("<a href='"+thishref+"' rel='"+$(this).parent().parent().parent().attr("rel")+"' class='title_link'>"+thistext+"</a>");
		$(".small_menu").animate({left:"-200%"},500);
		$(".menu_header_inner").animate({left:"-200%"},500);
		menutag=3;
	   }
	   if(menutag==1)
	   {
		$(this).parent().parent().find("ul").eq(0).show();
		$(".sub_menu_header").append("<a href='"+thishref+"' rel='"+$(this).parent().parent().parent().attr("rel")+"' class='title_link'>"+thistext+"</a>");
		$(".small_menu").animate({left:"-100%"},500);
		$(".menu_header_inner").animate({left:"-100%"},500);
	
		menutag=2;
	   }
	   var thish=$(this).parent().parent().find("ul").eq(0).height()+47;
		$(".small_header").animate({height:thish+"px"},500);
	
	   return false;
	 });
	 $(".back_arrow").click(function(){
		var thisn=parseInt($(this).parent().find(".title_link").eq(0).attr("rel"),10);
		var thish=(thisn+1)*47-7+thisn;
		$(".small_header").animate({height:thish+"px"},500);
	
	  if(menutag==2)
	  {
	   var thisremove=$(this).parent().find(".title_link").eq(0);
	   setTimeout(function(){thisremove.remove();$(".small_menu li ul").hide();},500);
	   $(".small_menu").animate({left:"0px"},500);
	   $(".menu_header_inner").animate({left:"0px"},500);
	   menutag=1;
	  }
	  if(menutag==3)
	  {
	   var thisremove=$(this).parent().find(".title_link");
	   setTimeout(function(){thisremove.remove();$(".small_menu li ul ul").hide();},500);
	   $(".small_menu").animate({left:"-100%"},500);
	   $(".menu_header_inner").animate({left:"-100%"},500);
	   menutag=2;
	  }
	  if(menutag==4)
	  {
	   var thisremove=$(this).parent().find(".title_link");
	   setTimeout(function(){thisremove.remove();$(".small_menu li ul ul ul").hide();},500);
	   $(".small_menu").animate({left:"-200%"},500);
	   $(".menu_header_inner").animate({left:"-200%"},500);
	   menutag=3;
	  }
	  return false;
	 });*/
});	

jQuery(document).ready(function($){
        $(window).resize(function () {
            if($(window).width()>768){
                $(".small_header").css({"display":"none"});
            }
        });

        var win=$(window);
        var sc=$(document);

        window.onload=function(){
            if(sc.scrollTop()>=200){
              if(!$("#header").hasClass("fixed_header")){
                  $("#header").addClass("fixed_header");
              }
                
            }else{
               $("#header").removeClass("fixed_header");
            }
        };
        win.scroll(function(){
            if(sc.scrollTop()>=200){
              if(!$("#header").hasClass("fixed_header")){
                  $("#header").addClass("fixed_header");
                  $(".small_header_wrapper").addClass("small_header_wrapper_fixed");
              }
                
            }else{
               $("#header").removeClass("fixed_header");
               $(".small_header_wrapper").removeClass("small_header_wrapper_fixed");
            }
        });

    
    });