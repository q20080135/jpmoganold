
let htmlWidth= document.documentElement.clientWidth || document.body.clientWidth;

let htmlDom=document.getElementsByTagName('html')[0];

htmlDom.style.fontSize=htmlWidth / 9.375 + 'px';
window.addEventListener('resize',(e)=>{
    let htmlWidth= document.documentElement.clientWidth || document.body.clientWidth;
	htmlDom.style.fontSize=htmlWidth / 9.375 + 'px';
})