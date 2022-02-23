var Cts = document.domain;
if(Cts.indexOf("dyrs.com.cn") <= 0 ){
	window.location.href = 'http://www.dyrs.com.cn/';
}
var _ucq = _ucq || [];
window.userclear = {track : function(){}}
// _ucq.push(['enableLinkTracking']);
// (function() {
// var u="//sdk31.lbadvisor.com/";
// _ucq.push(['setTrackerUrl', u+'t.gif']);
// _ucq.push(['setSiteId', '300925020']);
// var d=document, g=d.createElement('script'), 
// s=d.getElementsByTagName('script')[0];
// g.type='text/javascript'; g.async=true; g.defer=true; 
// g.src=u+'js/userclear.min.js'; s.parentNode.insertBefore(g,s);
// })();
/*
window._pt_lt = new Date().getTime();
window._pt_sp_2 = [];
_pt_sp_2.push('setAccount,3dcbc51a');
var _protocol = (("https:" == document.location.protocol) ? " https://" : " http://");
(function() {
	var atag = document.createElement('script'); atag.type = 'text/javascript'; atag.async = true;
	atag.src = _protocol + 'js.ptengine.cn/3dcbc51a.js';
	var s = document.getElementsByTagName('script')[0];
	s.parentNode.insertBefore(atag, s);
})();*/
var ref = ''; 
if (document.referrer.length > 0) { 
	ref = document.referrer; 
} 
try { 
  if (ref.length == 0 && opener.location.href.length > 0) { 
  	ref = opener.location.href; 
  } 
} catch (e) {
	// 获取当前URL
	ref = document.domain;
}
var regref = RegExp(/s\?(wd|word)=/);

var DYRSUUID = getCookie("dyrs_uuid");
if(DYRSUUID == null)
{
	DYRSUUID = guid();
}

(function(){
window.zhuge = window.zhuge || [];
window.zhuge.methods = "_init identify track getDid getSid getKey setSuperProperty setUserProperties setPlatform".split(" ");
window.zhuge.factory = function(b) {
return function() {
var a = Array.prototype.slice.call(arguments);
a.unshift(b);
window.zhuge.push(a);
return window.zhuge;
}
};
for (var i = 0; i < window.zhuge.methods.length; i++) {
var key = window.zhuge.methods[i];
window.zhuge[key] = window.zhuge.factory(key);
}
window.zhuge.load = function(b, x) {
if (!document.getElementById("zhuge-js")) {
var a = document.createElement("script");
var verDate = new Date();
var verStr = verDate.getFullYear().toString()
+ verDate.getMonth().toString() + verDate.getDate().toString();
a.type = "text/javascript";
a.id = "zhuge-js";
a.async = !0;
a.src =(location.protocol == 'http:' ? "http://data.dyrs.com.cn/zhuge.js?v=" : 'https://data.dyrs.com.cn/zhuge.js?v=') + verStr;
a.onerror = function(){
window.zhuge.identify = window.zhuge.track = function(ename, props, callback){
if(callback && Object.prototype.toString.call(callback) === '[object Function]')callback();
};
};
var c = document.getElementsByTagName("script")[0];
c.parentNode.insertBefore(a, c);
window.zhuge._init(b, x)
}
};
//window.zhuge.load('b4403c5cf3ec4de58ab37744db6f26a6', {"did": DYRSUUID});
	window.zhuge.load('b4403c5cf3ec4de58ab37744db6f26a6', {
		 'did':DYRSUUID,
		 autoTrack: true, //全埋点开关
		 singlePage: false //是否为单页面应用 默认为false
	});
})();

zhuge.identify(DYRSUUID);

function bread(a, b)
{
	var reg = new RegExp("/"+b+"\\d+", "gim");
	var c = a.replace(reg, "");
	window.location.href = "//" + c;
}

function guid()
{
	return 'xxxxxxxx-xxxx-xxxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
		var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8);
		return v.toString(16);
	});
}

function getCookie(name)
{
	var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
	if(arr=document.cookie.match(reg))
	{
		return unescape(arr[2]);
	}
	else
	{
		return null;
	}
}