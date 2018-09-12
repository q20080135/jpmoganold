jQuery(document).ready(function($){	

	setTimeout(function(){$(".icon_earth").addClass("active");},2000);
	//$(".mainnav").superfish();
	
	/*
	$(".mainnav > li").hover(function(){
		$(this).find(".submenu_box").stop().fadeIn(500);
	},function(){
		$(this).find(".submenu_box").stop().fadeOut(500);
	});
*/

	var sub_count=$(".sub_menu_wrapper .subnav_list > li").length;
	$(".sub_menu_wrapper .subnav_list > li").css("width",100/sub_count+"%");

	if($("#gform_wrapper_1").hasClass("gform_validation_error"))
	{
		var destination = $(".footer_form").offset().top;
		$("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination-0}, 500 );
	}
	if($(".gform_confirmation_message_1").length>0)
	{
		var destination = $(".footer_form").offset().top;
		$("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination-0}, 500 );
	}
	
	
	if($("#gform_wrapper_2").hasClass("gform_validation_error"))
	{
		var destination = $(".page_form").offset().top;
		$("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination-0}, 500 );
	}
	if($(".gform_confirmation_message_2").length>0)
	{
		var destination = $(".page_form").offset().top;
		$("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination-0}, 500 );
	}
	
	if($("#gform_wrapper_3").hasClass("gform_validation_error"))
	{
		var destination = $(".contact_form").offset().top;
		$("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination-0}, 500 );
	}
	if($(".gform_confirmation_message_3").length>0)
	{
		var destination = $(".contact_form").offset().top;
		$("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination-0}, 500 );
	}
	
	$('a.go_top_link').click(function() {
	   var elementClicked = jQuery(this).attr("href");
	   var destination = jQuery(elementClicked).offset().top;
	   jQuery("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination-108}, 500 );
	   return false;
	});
	
	
	$(".view_pic").colorbox({rel:'group1',maxWidth:"90%"});
	
	/*$(".mobile_menu_button").click(function(){	
		if(jQuery(".mobile_menu_content").css("display")!="block")
		{
		    jQuery(".header_wrapper").addClass("z_index_top");
		    jQuery(".mobile_menu_content").addClass("active");
			jQuery(".mobile_menu_content").slideDown("fast");
		}
		else
		{
		    jQuery(".header_wrapper").removeClass("z_index_top");
		    jQuery(".mobile_menu_content").removeClass("active");
			jQuery(".mobile_menu_content").slideUp("fast");
		}
		return false;
	});*/
	
	$(".search_button").click(function(){	
		if(jQuery(".search_form_box").css("display")!="block")
		{
		    jQuery(".search_form_box").addClass("active");
			jQuery(".search_form_box").slideDown("fast");
		}
		else
		{
		    jQuery(".search_form_box").removeClass("active");
			jQuery(".search_form_box").slideUp("fast");
		}
		return false;
	});
	
	var timer;
	$(".search_form_box").hover(function(){
	clearInterval(timer);
	},function(){
	timer=setTimeout(function(){$(".search_form_box").removeClass("active");$(".search_form_box").slideUp("fast");},300);
	}); 
	
	
	var timer;
	$(".mobile_menu_content").hover(function(){
	clearInterval(timer);
	},function(){
	timer=setTimeout(function(){$(".mobile_menu_content").removeClass("active");$(".mobile_menu_content").slideUp("fast");},300);
	}); 
	
	
	
	/***********************************************************************************************/
	$(".dafault_tab_content").hide(); 
	$("ul.dafault_tabs li:first").addClass("active").show();
	$(".dafault_tab_content:first").show(); 
	
	$("ul.dafault_tabs li").click(function() {
		$("ul.dafault_tabs li").removeClass("active"); 
		$(this).addClass("active"); 
		$(".dafault_tab_content").hide();
		var activeTab = $(this).find("a").attr("href");
		$(activeTab).fadeIn(); 
		return false;
	});	
	
	
	
	/*******small menu**************/
	$(".mobile_menu_button").click(function(){
		$(".small_header").slideToggle();
		$(".small_header_wrapper_fixed").show();
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
	$(".small_header").height((((maxMenu+1)*40-7)+maxMenu)+"px");
	


	var stime_menu;

	//给有子标题的标题添加标签
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

	   $(this).toggleClass("selected");

        if($(this).parent().parent().find("ul").css('display')=='none')
        {
        	$(this).parent().parent().find("ul").show();
        }
        else
        {
        	 $(this).parent().parent().find("ul").hide();
        }
	  

	 //   if(menutag==3)
	 //   {
		// $(this).parent().parent().find("ul").eq(0).show();
		// $(".subsubsub_menu_header").append("<a href='"+thishref+"' rel='"+$(this).parent().parent().parent().attr("rel")+"' class='title_link'>"+thistext+"</a>");
		// $(".small_menu").animate({left:"-300%"},500);
		// $(".menu_header_inner").animate({left:"-300%"},500);
		// menutag=4;
	 //   }
	 //   if(menutag==2)
	 //   {
		// $(this).parent().parent().find("ul").eq(0).show();
		// $(".subsub_menu_header").append("<a href='"+thishref+"' rel='"+$(this).parent().parent().parent().attr("rel")+"' class='title_link'>"+thistext+"</a>");
		// $(".small_menu").animate({left:"-200%"},500);
		// $(".menu_header_inner").animate({left:"-200%"},500);
		// menutag=3;
	 //   }
	 //   if(menutag==1)
	 //   {
		// $(this).parent().parent().find("ul").eq(0).show();
		// $(".sub_menu_header").append("<a href='"+thishref+"' rel='"+$(this).parent().parent().parent().attr("rel")+"' class='title_link'>"+thistext+"</a>");
		// $(".small_menu").animate({left:"-100%"},500);
		// $(".menu_header_inner").animate({left:"-100%"},500);
	
		// menutag=2;
	 //   }
	 //   var thish=$(this).parent().parent().find("ul").eq(0).height()+47;
		// $(".small_header").animate({height:thish+"px"},500);
	
	 //   return false;
	 });
	 // $(".back_arrow").click(function(){
		// var thisn=parseInt($(this).parent().find(".title_link").eq(0).attr("rel"),10);
		// var thish=(thisn+1)*47-7+thisn;
		// $(".small_header").animate({height:thish+"px"},500);
	
	 //  if(menutag==2)
	 //  {
	 //   var thisremove=$(this).parent().find(".title_link").eq(0);
	 //   setTimeout(function(){thisremove.remove();$(".small_menu li ul").hide();},500);
	 //   $(".small_menu").animate({left:"0px"},500);
	 //   $(".menu_header_inner").animate({left:"0px"},500);
	 //   menutag=1;
	 //  }
	 //  if(menutag==3)
	 //  {
	 //   var thisremove=$(this).parent().find(".title_link");
	 //   setTimeout(function(){thisremove.remove();$(".small_menu li ul ul").hide();},500);
	 //   $(".small_menu").animate({left:"-100%"},500);
	 //   $(".menu_header_inner").animate({left:"-100%"},500);
	 //   menutag=2;
	 //  }
	 //  if(menutag==4)
	 //  {
	 //   var thisremove=$(this).parent().find(".title_link");
	 //   setTimeout(function(){thisremove.remove();$(".small_menu li ul ul ul").hide();},500);
	 //   $(".small_menu").animate({left:"-200%"},500);
	 //   $(".menu_header_inner").animate({left:"-200%"},500);
	 //   menutag=3;
	 //  }
	 //  return false;
	 // });

/**************************forex  table***************************/
	$(".page_content_list_wrapper .page_content_list_content .page_content_list_nr .page_content_list_table .forex_click_more").click(function(){
		
	 	$(".page_content_list_wrapper .page_content_list_content .page_content_list_nr .page_content_list_table .forex_click_more").hide();
	 	$(".page_content_list_wrapper .page_content_list_content .page_content_list_nr .page_content_list_table .table_more").show();
		return false;
	 });
	$(".page_content_list_wrapper .page_content_list_content .page_content_list_nr .page_content_list_table .forex_click_more_up").click(function(){
		var elementClicked = $(".page_content_list_wrapper .page_content_list_content .page_content_list_nr .page_content_list_table .table_more");
   		var destination = jQuery(elementClicked).offset().top;
   		jQuery("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination-700}, 500 );
	 	$(".page_content_list_wrapper .page_content_list_content .page_content_list_nr .page_content_list_table .table_more").hide();
	 	$(".page_content_list_wrapper .page_content_list_content .page_content_list_nr .page_content_list_table .forex_click_more").show();
		return false;
	 });

/**************************primary  click_stop***************************/
	$(".page_accordion_content .page_accordion_content_text .click_stop").click(function(){

        if(!$(this).parent().parent().parent().find(".page_accordion_content_title").hasClass("selected")){
            $(this).parent().parent().parent().find(".page_accordion_content_title").addClass("selected");
            $(this).parent().parent().slideDown(500); 

        }else{
        	var elementClicked = $(this).parent().parent();
   			var destination = jQuery(elementClicked).offset().top;
   			jQuery("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination-250}, 500 );
            $(this).parent().parent().parent().find(".page_accordion_content_title").removeClass("selected");
            $(this).parent().parent().slideUp(500); 
        }
    });
	
	
	
	
	

	/****************Home Js*******************************/	
	$('.home_slider_down a').click(function() {

		var elementClicked = jQuery(this).attr("href");

		var destination = jQuery(elementClicked).offset().top;

		jQuery("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination}, 500 );

		return false;

	});

	

	if($("#gform_wrapper_5").hasClass("gform_validation_error"))

	{

		var destination = $(".home_contact").offset().top;

		$("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination}, 500 );

	}

	if($(".gform_confirmation_message_5").length>0)

	{

		var destination = $(".home_contact").offset().top;

		$("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination}, 500 );

	}



	

if($("#header").width()<1040){

	$(".home_advantage_section").addClass("active")

	$(".home_start_trading").addClass("active")

	$(".home_app_section").addClass("active")

	$(".home_platform_section").addClass("active")

	$(".home_trading_products").addClass("active")

	$(".home_news_section").addClass("active")

	$(".home_contact").addClass("active")

	$(".home_liquid_section").addClass("active")

}

$(function () {

    if (!window.ActiveXObject && !!document.createElement("canvas").getContext) {
	if($("body").hasClass("page-id-6")){
        $.getScript("cav.js",

            function () {

                var t = {

                    width: 7,

                    height: 7,

                    depth: 10,

                    segments: 70,

                    slices: 6,

                    xRange: 0.8,

                    yRange: 0.1,

                    zRange: 1,

                    ambient: "#525252",

                    diffuse: "#999999",

                    speed: 0.0002

                };

                var G = {

                    count: 2,

                    xyScalar: 1,

                    zOffset: 100,

                    ambient: "#6f01a2",

                    diffuse: "#af1be3",

                    speed: 0.001,

                    gravity: 1200,

                    dampening: 0.95,

                    minLimit: 10,

                    maxLimit: null,

                    minDistance: 20,

                    maxDistance: 400,

                    autopilot: false,

                    draw: false,

                    bounds: CAV.Vector3.create(),

                    step: CAV.Vector3.create(Math.randomInRange(0.2, 1), Math.randomInRange(0.2, 1), Math.randomInRange(0.2, 1))

                };

                var m = "canvas";

                var E = "svg";

                var x = {

                    renderer: m

                };

                var i, n = Date.now();

                var L = CAV.Vector3.create();

                var k = CAV.Vector3.create();

                var z = document.getElementById("home_start_trading");

                var w = document.getElementById("home_start_trading_bg");

                var D, I, h, q, y;

                var g;

                var r;



                function C() {

                    F();

                    p();

                    s();

                    B();

                    v();

                    K(z.offsetWidth, z.offsetHeight);

                    o()

                }



                function F() {

                    g = new CAV.CanvasRenderer();

                    H(x.renderer)

                }



                function H(N) {

                    if (D) {

                        w.removeChild(D.element)

                    }

                    switch (N) {

                        case m:

                            D = g;

                            break

                    }

                    D.setSize(z.offsetWidth, z.offsetHeight);

                    w.appendChild(D.element)

                }



                function p() {

                    I = new CAV.Scene()

                }



                function s() {

                    I.remove(h);

                    D.clear();

                    q = new CAV.Plane(t.width * D.width, t.height * D.height, t.segments, t.slices);

                    y = new CAV.Material(t.ambient, t.diffuse);

                    h = new CAV.Mesh(q, y);

                    I.add(h);

                    var N, O;

                    for (N = q.vertices.length - 1; N >= 0; N--) {

                        O = q.vertices[N];

                        O.anchor = CAV.Vector3.clone(O.position);

                        O.step = CAV.Vector3.create(Math.randomInRange(0.2, 1), Math.randomInRange(0.2, 1), Math.randomInRange(0.2, 1));

                        O.time = Math.randomInRange(0, Math.PIM2)

                    }

                }



                function B() {

                    var O, N;

                    for (O = I.lights.length - 1; O >= 0; O--) {

                        N = I.lights[O];

                        I.remove(N)

                    }

                    D.clear();

                    for (O = 0; O < G.count; O++) {

                        N = new CAV.Light(G.ambient, G.diffuse);

                        N.ambientHex = N.ambient.format();

                        N.diffuseHex = N.diffuse.format();

                        I.add(N);

                        N.mass = Math.randomInRange(0.5, 1);

                        N.velocity = CAV.Vector3.create();

                        N.acceleration = CAV.Vector3.create();

                        N.force = CAV.Vector3.create()

                    }

                }



                function K(O, N) {

                    D.setSize(O, N);

                    CAV.Vector3.set(L, D.halfWidth, D.halfHeight);

                    s()

                }



                function o() {

                    i = Date.now() - n;

                    u();

                    M();

                    requestAnimationFrame(o)

                }



                function u() {

                    var Q, P, O, R, T, V, U, S = t.depth / 2;

                    CAV.Vector3.copy(G.bounds, L);

                    CAV.Vector3.multiplyScalar(G.bounds, G.xyScalar);

                    CAV.Vector3.setZ(k, G.zOffset);

                    for (R = I.lights.length - 1; R >= 0; R--) {

                        T = I.lights[R];

                        CAV.Vector3.setZ(T.position, G.zOffset);

                        var N = Math.clamp(CAV.Vector3.distanceSquared(T.position, k), G.minDistance, G.maxDistance);

                        var W = G.gravity * T.mass / N;

                        CAV.Vector3.subtractVectors(T.force, k, T.position);

                        CAV.Vector3.normalise(T.force);

                        CAV.Vector3.multiplyScalar(T.force, W);

                        CAV.Vector3.set(T.acceleration);

                        CAV.Vector3.add(T.acceleration, T.force);

                        CAV.Vector3.add(T.velocity, T.acceleration);

                        CAV.Vector3.multiplyScalar(T.velocity, G.dampening);

                        CAV.Vector3.limit(T.velocity, G.minLimit, G.maxLimit);

                        CAV.Vector3.add(T.position, T.velocity)

                    }

                    for (V = q.vertices.length - 1; V >= 0; V--) {

                        U = q.vertices[V];

                        Q = Math.sin(U.time + U.step[0] * i * t.speed);

                        P = Math.cos(U.time + U.step[1] * i * t.speed);

                        O = Math.sin(U.time + U.step[2] * i * t.speed);

                        CAV.Vector3.set(U.position, t.xRange * q.segmentWidth * Q, t.yRange * q.sliceHeight * P, t.zRange * S * O - S);

                        CAV.Vector3.add(U.position, U.anchor)

                    }

                    q.dirty = true

                }



                function M() {

                    D.render(I)

                }



                function J(O) {

                    var Q, N, S = O;

                    var P = function (T) {

                        for (Q = 0, l = I.lights.length; Q < l; Q++) {

                            N = I.lights[Q];

                            N.ambient.set(T);

                            N.ambientHex = N.ambient.format()

                        }

                    };

                    var R = function (T) {

                        for (Q = 0, l = I.lights.length; Q < l; Q++) {

                            N = I.lights[Q];

                            N.diffuse.set(T);

                            N.diffuseHex = N.diffuse.format()

                        }

                    };

                    return {

                        set: function () {

                            P(S[0]);

                            R(S[1])

                        }

                    }

                }



                function v() {

                    window.addEventListener("resize", j)

                }



                function A(N) {

                    CAV.Vector3.set(k, N.x, D.height - N.y);

                    CAV.Vector3.subtract(k, L)

                }



                function j(N) {

                    K(z.offsetWidth, z.offsetHeight);

                    M()

                }



                C();

            })

    } else {
    }
	}


});
	
	/****************Home Js End*******************************/	
	
	
});	


/****************Home Js*******************************/

window.onload=function(){	
if(jQuery("body").hasClass("page-id-6")){
	var top1=jQuery(".home_advantage_section").offset().top;

	var top2=jQuery(".home_start_trading").offset().top;

	var top3=jQuery(".home_app_section").offset().top;

	var top4=jQuery(".home_platform_section").offset().top;

	var top5=jQuery(".home_trading_products").offset().top;

	var top6=jQuery(".home_news_section").offset().top;

	var top7=jQuery(".home_contact").offset().top;

	var top8=jQuery(".home_liquid_section").offset().top;

	var headerTag=0;

	var portfolioTag=0;

	

	

	

		

		var WindowHeight=document.documentElement.clientHeight;

		if(jQuery(window).scrollTop()>=(top1-WindowHeight-100)&&jQuery(window).scrollTop()<(top1+jQuery(".home_advantage_section").height()))

		{

			if(!jQuery(".home_advantage_section").hasClass("active"))

			jQuery(".home_advantage_section").addClass("active");

		}

		if(jQuery(window).scrollTop()>=(top2-WindowHeight-100)&&jQuery(window).scrollTop()<(top2+jQuery(".home_start_trading").height()))

		{

			if(!jQuery(".home_start_trading").hasClass("active"))

			jQuery(".home_start_trading").addClass("active");

		}

		if(jQuery(window).scrollTop()>=(top3-WindowHeight-100)&&jQuery(window).scrollTop()<(top3+jQuery(".home_app_section").height()))

		{

			if(!jQuery(".home_app_section").hasClass("active"))

			jQuery(".home_app_section").addClass("active");

		}

		if(jQuery(window).scrollTop()>=(top4-WindowHeight-100)&&jQuery(window).scrollTop()<(top4+jQuery(".home_platform_section").height()))

		{

			if(!jQuery(".home_platform_section").hasClass("active"))

			jQuery(".home_platform_section").addClass("active");

		}

		if(jQuery(window).scrollTop()>=(top5-WindowHeight-100)&&jQuery(window).scrollTop()<(top5+jQuery(".home_trading_products").height()))

		{

			if(!jQuery(".home_trading_products").hasClass("active"))

			jQuery(".home_trading_products").addClass("active");

		}

		if(jQuery(window).scrollTop()>=(top6-WindowHeight-100)&&jQuery(window).scrollTop()<(top6+jQuery(".home_news_section").height()))

		{

			if(!jQuery(".home_news_section").hasClass("active"))

			jQuery(".home_news_section").addClass("active");

		}

		if(jQuery(window).scrollTop()>=(top7-WindowHeight-100)&&jQuery(window).scrollTop()<(top7+jQuery(".home_contact").height()))

		{

			if(!jQuery(".home_contact").hasClass("active"))

			jQuery(".home_contact").addClass("active");

		}

		if(jQuery(window).scrollTop()>=(top8-WindowHeight-100)&&jQuery(window).scrollTop()<(top8+jQuery(".home_liquid_section").height()))

		{

			if(!jQuery(".home_liquid_section").hasClass("active"))

			jQuery(".home_liquid_section").addClass("active");

		}

		

	jQuery(window).scroll(function() {

		

		

		var WindowHeight=document.documentElement.clientHeight;

		if(jQuery(window).scrollTop()>=(top1-WindowHeight-100)&&jQuery(window).scrollTop()<(top1+jQuery(".home_advantage_section").height()))

		{

			if(!jQuery(".home_advantage_section").hasClass("active"))

			jQuery(".home_advantage_section").addClass("active");

		}

		if(jQuery(window).scrollTop()>=(top2-WindowHeight-100)&&jQuery(window).scrollTop()<(top2+jQuery(".home_start_trading").height()))

		{

			if(!jQuery(".home_start_trading").hasClass("active"))

			jQuery(".home_start_trading").addClass("active");

		}

		if(jQuery(window).scrollTop()>=(top3-WindowHeight-100)&&jQuery(window).scrollTop()<(top3+jQuery(".home_app_section").height()))

		{

			if(!jQuery(".home_app_section").hasClass("active"))

			jQuery(".home_app_section").addClass("active");

		}

		if(jQuery(window).scrollTop()>=(top4-WindowHeight-100)&&jQuery(window).scrollTop()<(top4+jQuery(".home_platform_section").height()))

		{

			if(!jQuery(".home_platform_section").hasClass("active"))

			jQuery(".home_platform_section").addClass("active");

		}

		if(jQuery(window).scrollTop()>=(top5-WindowHeight-100)&&jQuery(window).scrollTop()<(top5+jQuery(".home_trading_products").height()))

		{

			if(!jQuery(".home_trading_products").hasClass("active"))

			jQuery(".home_trading_products").addClass("active");

		}

		if(jQuery(window).scrollTop()>=(top6-WindowHeight-100)&&jQuery(window).scrollTop()<(top6+jQuery(".home_news_section").height()))

		{

			if(!jQuery(".home_news_section").hasClass("active"))

			jQuery(".home_news_section").addClass("active");

		}

		if(jQuery(window).scrollTop()>=(top7-WindowHeight-100)&&jQuery(window).scrollTop()<(top7+jQuery(".home_contact").height()))

		{

			if(!jQuery(".home_contact").hasClass("active"))

			jQuery(".home_contact").addClass("active");

		}

		if(jQuery(window).scrollTop()>=(top8-WindowHeight-100)&&jQuery(window).scrollTop()<(top8+jQuery(".home_liquid_section").height()))

		{

			if(!jQuery(".home_liquid_section").hasClass("active"))

			jQuery(".home_liquid_section").addClass("active");

		}

	});
};
}

	/****************Home Js End*******************************/	

