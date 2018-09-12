function rem(){
	var vw =375;
	var vfontsize =16;
	var html=document.documentElement;
	var fontsize=html.clientWidth*vfontsize/vw;
	html.style.fontsize=fontsize+'px';
}

rem();
window.onresize=function(){

	 rem();
}