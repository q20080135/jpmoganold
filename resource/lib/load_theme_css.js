function includeLinkStyle(url) {
    var link = document.createElement("link");
    link.rel = "stylesheet";
    link.type = "text/css";
    link.id = "skin";
    link.href = url;
    document.getElementsByTagName("head")[0].appendChild(link);
} 
var name = 'Huiskin';
var thema = 'blue';
var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
if(arr=document.cookie.match(reg)){
    thema = unescape(arr[2]); 
}