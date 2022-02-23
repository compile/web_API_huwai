

























if(typeof doyoo=='undefined' || !doyoo){
var d_genId=function(){
var id ='',ids='0123456789abcdef';
for(var i=0;i<32;i++){ id+=ids.charAt(Math.floor(Math.random()*16)); } return id;
};

var schema='http';
if(location.href.indexOf('https:') == 0){
schema = 'https';
}
var doyoo={
env:{
secure:schema=='https',
mon:'//m6815.talk99.cn/monitor',
chat:'//looyuoms7721.looyu.com/chat',
file:'//bin.jiain.net',
compId:20003252,
confId:10111227,
workDomain:'',
vId:d_genId(),
lang:'',
fixFlash:0,
fixMobileScale:0,
subComp:36422,
_mark:'8836f26f2e8963da7dc444aeda8c6d5f7474a6b61ce59622ba420a1243b983d52142a5dfab5a6650'
},
chat:{
mobileColor:'',
mobileHeight:80,
mobileChatHintBottom:5,
mobileChatHintMode:0,
mobileChatHintColor:'',
mobileChatHintSize:0,
priorMiniChat:0
}

, monParam:{
index:1,
preferConfig:0,

title:'\u5c45\u4f17\u96c6\u56e2 · \u56fd\u5bb6\u65bd\u5de5\u4e00\u7ea7\uff0c\u8bbe\u8ba1\u7532\u7ea7\u8d44\u8d28',
text:'<p><span style="font-family:\u5fae\u8f6f\u96c5\u9ed1;font-size:10.5pt;"><span style="font-family:\u5fae\u8f6f\u96c5\u9ed1;">\u60a8\u597d\uff0c\u5f88\u9ad8\u5174\u4e3a\u60a8\u670d\u52a1\uff0c\u8bf7\u95ee\u60a8\u662f\u6709\u623f\u5b50\u9700\u8981\u88c5\u4fee\u5417\uff1f</span></span></p>',
auto:-1,
group:'10077760',
start:'00:00',
end:'24:00',
mask:false,
status:true,
fx:1,
mini:1,
pos:2,
offShow:0,
loop:0,
autoHide:0,
hidePanel:0,
miniStyle:'#009966',
miniWidth:'340',
miniHeight:'490',
showPhone:0,
monHideStatus:[0,0,0],
monShowOnly:'',
autoDirectChat:-1,
allowMobileDirect:0,
minBallon:1,
chatFollow:1,
backCloseChat:0,
ratio:1
}


, panelParam:{
mobileIcon:'',
mobileIconWidth:0,
mobileIconHeight:0,
category:'icon',
preferConfig:0,
position:1,
vertical:150,
horizon:5


,mode:1,
target:'10077760',
online:'//file.soperson.com/probe/20003252/5da6c59dedc0bae7e0bc4f5d.jpg',
offline:'//file.soperson.com/probe/20003252/5da6c59dedc0bae7e0bc4f5d.jpg',
width:85,
height:304,
status:1,
closable:0,
regions:[{type:"2",l:"0",t:"0",w:"85",h:"100",bk:"",v:"10084946"},{type:"4",l:"0",t:"100",w:"85",h:"100",bk:"",v:"https://www.ijuzhong.com/brand/"},{type:"2",l:"0",t:"200",w:"85",h:"104",bk:"",v:"10084946"}],
collapse:0



}



};

if(typeof talk99Init=="function"){talk99Init(doyoo)}if(!document.getElementById("doyoo_panel")){var supportJquery=typeof jQuery!="undefined";var doyooWrite=function(tag,opt){var el=document.createElement(tag);for(v in opt){if(opt.hasOwnProperty(v)){el.setAttribute(v,opt[v])}}var tar=document.body||document.getElementsByTagName("head")[0];tar.appendChild(el)};doyooWrite("Link.php",{rel:"stylesheet",type:"text/css",href:"//bin.jiain.net/20200520/looyu.f7bf1efc8b105c9c95d249e08b3cceda.css"});doyooWrite("script",{type:"text/javascript",src:"//bin.jiain.net/20200520/looyu.3f61dcaa0a452db6327a02d91b2c76f5.js",charset:"utf-8"})};
}
