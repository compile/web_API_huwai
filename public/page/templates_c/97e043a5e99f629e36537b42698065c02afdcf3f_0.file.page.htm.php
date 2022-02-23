<?php
/* Smarty version 3.1.34-dev-7, created on 2020-11-14 16:45:54
  from '/Volumes/51/idiQu/public/page/templates/page.htm' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5faf994269eeb5_02266663',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '97e043a5e99f629e36537b42698065c02afdcf3f' => 
    array (
      0 => '/Volumes/51/idiQu/public/page/templates/page.htm',
      1 => 1605076285,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5faf994269eeb5_02266663 (Smarty_Internal_Template $_smarty_tpl) {
?><!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>东易日盛装饰_施工工地展示</title>
<meta name="keywords" content="东易日盛,家庭装修,装修公司,别墅装修,专业别墅设计施工,室内装修,装饰公司,室内设计,家装效果图">


<?php echo '<script'; ?>
 src="./page_files/jquery-1.12.4.min.js"><?php echo '</script'; ?>
>
<style>
/*修复乐语浏览器卡顿闪屏问题*/ 
#doyoo_share{position: inherit;display: none !important;}
.doyoo_f_original body{overflow: auto!important;}
.doyoo_f_original{overflow:auto !important;}
.doyoo_f_frame{display:none !important;}

*{margin:0;padding:0}
body{margin:0;padding:0;font-style:normal;font-family:"microsoft yahei";list-style:none;}
body{position:relative;}
	
	
a{text-decoration: none;outline: none;}
a:hover, a:focus{color:#39545e;}
section{padding: 1em;text-align: center;}
li{list-style:none;}
i{font-style:normal;}
img{border:0;}
table{border:0;}
td{border:0;}
.f1{width:100%;overflow:hidden;}
.f1-i{width:1200px;margin:0 auto;overflow:hidden;position:relative;}
.f1-ii{width:1100px;margin:0 auto;overflow:hidden;position:relative;}
.f1-iii{width:1000px;margin:0 auto;overflow:hidden;position:relative;}
.clear{clear:both;}

.nav{width:100%; background:#333; height:52px; line-height:52px; font-size:18px; color:#fff; position:fixed; z-index:999;}
.nav1{width:1200px; margin:0 auto;}
.nav1 .logo{width:200px;float:left; margin:3px auto;}
.nav1 ul{width:600px; float:left; margin-left:100px; height:52px;}
.nav1 ul li{width:110px; float:left; text-align:center; line-height:52px;}
.nav1 ul li:hover{background:#e88d21;}
.nav1 ul .active{background:#e88d21;}
.nav1 ul li a{color:#fff;}
.tel{width:260px; float:left; background:url(http://img.dyrs.cc/special/737/100/105737/tel.jpg!c) left center no-repeat; padding-left:40px; font-size:24px; line-height:56px;}
.banner1{width:100%; margin:0 auto; background:url(http://img.dyrs.cc/special/845/100/110845/2235e69f03747408-2.jpg!c) center bottom no-repeat; height:281px; padding-top:52px;}
.banner2{width:100%; margin:0 auto; background:url(http://img.dyrs.cc/store/792/034/000/4775dc7c8c0688f7.jpg!c) center center no-repeat; height:200px;}
.banner3{width:100%; margin:0 auto; background:url(http://img.dyrs.cc/store/793/034/000/4975dc7c8c0be389.jpg!c) center center no-repeat; height:171px;}


.title{width:100%; text-align:center;}
.title span{width:100%; margin:0 auto;}
.title p{font-size:18px; line-height:30px; color:#555;}

.tabbox{width:1200px; margin:0 auto; background:#fff;}
.tabbox .tab{overflow:hidden;background:#ccc; width:1200px; margin:0 auto;}
.tabbox .tab a{display:block;float:left;text-decoration:none;color:#333; width:240px; text-align:center; line-height:42px;}
.tabbox .tab a:hover{background:#E64E3F;color:#fff;text-decoration:none;}
.tabbox .tab a.on{background:#E64E3F;color:#fff;text-decoration:none;}
.tabbox .content{overflow:hidden; width:1200px; height:600px; position:relative;}
.tabbox .content ul{position:absolute;left:0;top:0;}
.tabbox .content li{width:1200px; height:600px; float:left;}

/*报名*/
.ts1{width:100%; margin:0 auto; background:#ce3434; border-radius:300px; height:260px;}
.ts1 h1{font-size:36px; width:100%; text-align:center; line-height:60px; color:#fff; padding-top:30px;}
.ts1 form{width:1150px; float:left; margin:20px 0 20px 30px;}
.ts1 .item{width:230px; float:left;}
.ts1 .item input{width:200px; float:left; margin-left:15px; padding:0 0 0 10px; height:42px; line-height:42px; color:#666; background:#fff; border:1px solid #fff; border-radius:5px; font-size:16px;}
.ts1 .submit{width:185px; height:42px; line-height:42px; color:#fff; font-size:20px; padding:0; float:left; margin-left:15px; text-align:center; background:#43cabc; border:1px solid #43cabc; border-radius:5px;}
.ts1 .submit:hover{color:#CF0;}
.ts1 .tel1{width:100%; height:60px; background:url(http://img.dyrs.cc/special/845/100/110845/1805e69f0eb0c135-2.jpg!c) center center no-repeat; margin-top:20px;}

.ts2{width:100%; margin:0 auto;}
.ts2 form{width:100%; float:left;}
.ts2 .item{width:220px; float:left;}
.ts2 .item input{width:180px; float:left; margin-left:15px; padding:0 0 0 10px; height:42px; line-height:42px; color:#ccc; background:#2a2a2a; border:1px solid #fff; border-radius:50px; font-size:16px;}
.ts2 .submit{width:180px; height:42px; line-height:42px; color:#fff; font-size:20px; padding:0; float:left; margin-left:15px; text-align:center; background:#e3161e; border:1px solid #e3161e; border-radius:50px;}

.ts3{width:515px; height:470px; float:right; margin:70px 23px; background-color:rgba(255,255,255,0.5);}
.ts3 h2{width:100%; text-align:center; line-height:80px; color:#e3161e; font-size:28px;text-shadow:0 0 0.2em #fff, -0 -0 0.2em #fff;}
.ts3 form{width:415px; margin:0 50px; float:left;}
.ts3 .item{width:415px; float:left;}
.ts3 .item input{width:415px; float:left; margin:5px auto; text-indent:2em; height:40px; line-height:40px; color:#666; background:#fff; font-size:16px;}
.ts3 .submit{width:315px; height:36px; margin:10px 50px; line-height:36px; color:#fff; font-size:18px; float:left; text-align:center; background:#e3161e;}
.ts3 p{font-size:14px; color:#fff; line-height:20px; width:100%; text-align:center;}
.ts5{width:500px; float:left; margin:0 auto;}
.ts5 h2{width:100%; text-align:center; line-height:80px; color:#333; font-size:28px;text-shadow:0 0 0.3em #ffedcd, -0 -0 0.3em #ffedcd;}
.ts5 form{width:400px; margin:0 50px; float:left;}
.ts5 .item{width:400px; float:left;}
.ts5 .item input{width:400px; float:left; margin:8px auto; text-indent:2em; height:42px; line-height:42px; color:#666; background:#fff; font-size:16px;}
.ts5 .submit{width:320px; height:36px; margin:15px 50px 30px; line-height:36px; color:#fff; font-size:18px; float:left; text-align:center; background:#e3161e;}
.ts5 p{font-size:14px; color:#333; line-height:20px; width:100%; text-align:center;}

.btnst{width:480px;margin:0 auto 20px;overflow:hidden;clear:both;}
.btnst a{width:230px;height:45px;display:block;text-align:center;line-height:45px;float:left;}
.btnst a:first-child{color:#ce3434;font-size:18px;border:1px solid #ce3434;}
.btnst a:first-child+a{color:#fff;font-size:18px;background:#ce3434;border:1px solid #ce3434;margin-left:15px;}
.btnst a:first-child:hover{background:#ce3434;color:#fff;}

.jd{width:100%; margin:0 auto;}
.jd ul{width:100%; float:left;}
.jd ul li{width:230px; float:left; margin:85px 22px; text-align:center;}
.jd ul li span{font-size:24px; color:#c51112; line-height:64px;}
.jd ul li p{font-size:15px; color:#333;}
.pk{width:100%; margin:0 auto;}
.pk table{width:100%; padding:50px 0; border-bottom:1px solid #ccc;}
.pk table tr{width:100%; float:left; margin:10px auto;}
.pk_1{width:180px; float:left; margin:0 20px;}
.pk_1 span{font-size:20px; font-weight:bold; color:#222;}
.pk_1 .line1{width:100%; height:2px; background:#ce3434; margin:10px auto;}
.pk_1 p{font-szie:16px; line-height:22px; color:#555;}
.pk_2{width:180px; float:left; margin:0 20px;}
.pk_2 span{font-size:20px; font-weight:bold; color:#222;}
.pk_2 .line2{width:100%; height:2px; background:#666; margin:10px auto;}
.pk_2 p{font-szie:16px; line-height:22px; color:#555;}
.vr{width:100%; margin:220px auto 0; background:#000;}
.jk{width:100%; margin:30px auto; border:0;}
.jk table{width:100%; margin:0 auto; background:#ececec;}
.jk table tr{width:100%; float:left;}
.jk table tr td{width:299px; float:left;}
.jk_c{width:220px; float:left; margin:40px;}
.jk_c span{font-size:20px; font-weight:bold; color:#333; width:100%; float:left;}
.jk_c .line{width:50px; height:2px; background:#666; margin:10px auto; float:left;}
.jk_c p{font-szie:16px; line-height:24px; color:#666; width:100%; float:left;}

.bw{width:100%; margin:0 auto;}
.bw_c{width:300px; height:140px; padding:50px 40px; background:#ececec;}
.bw_c span{font-size:20px; font-weight:bold; color:#333; width:100%; float:left;}
.bw_c .line{width:50px; height:2px; background:#666; margin:10px auto; float:left;}
.bw_c p{font-szie:16px; line-height:24px; color:#666; width:100%; float:left;}
.bw ul{width:100%; height:170px; float:left; margin-left:270px; margin-top:-130px;}
.bw ul li{width:295px; height:170px; float:left; margin-left:15px;}

.gy{width:450px; float:left; margin:170px 0 0 685px; font-size:16px; line-height:28px; color:#fff;}
.gz{width:100%; margin:0 auto;}
.sjs-ul{width: 1200px;margin:40px auto; float:left;}
.sjs-ul li{float: left;width: 363px;text-align:center; font-size:14px; line-height:22px;}
.sjs{width: 1200px;margin:30px auto 0; float:left;}
.sjs .dsff{float: left;width: 156px;height: 295px;position: relative;float: left;margin-left: 8px;margin-bottom: 26px;cursor: pointer;background: #000; text-align:center;}
.sjs .dsff div{padding-top: 16px;background: #fff;height: 84px; width:100%; text-align:center; line-height:28px;}
.sjs .dsff p{position: absolute;width: 100%;height: 100%;top: 0;left: 0;line-height: 212px;text-align: center;color: #ff9900;display: none;}
.sjs .dsff:hover p{display: block;}
.sjs>.dsff>img{display: block;transition: 1s all;}
.sjs>.dsff:hover>img{display: block;opacity: .3;filter: alpha(opacity=50);background: #000;background: rgba(0, 0, 0, .5);cursor: pointer;}
.sjs-last{text-align: center;display: block;padding-top: 10px;color: #333;font-size: 14px;}

.theme-popover-mask{z-index:9998; position:fixed; top:0; left:0; width:100%; height:100%; background:#000; opacity:0.6; filter:alpha(opacity=60); display:none;}
.theme-popover{z-index:9999; position:fixed; top:40%; left:50%; width:530px; height:600px; margin:-260px 0 0 -300px; border-radius:5px; border:solid 2px #666; background-color:#fff; display:none; box-shadow:0 0 10px #666;}
.theme-poptit{padding:12px; position:relative;}
.theme-popbod{padding:0 15px; color:#444; height:148px;}
.theme-popbom{padding:15px; background-color:#f6f6f6; border-top:1px solid #ddd; border-radius:0 0 5px 5px; color:#666;}
.theme-poptit .close{float:right; color:#999; padding:5px; margin:0; font:bold 24px/24px simsun; text-shadow:0 1px 0 #ddd;}
.theme-poptit .close:hover{color:#444;}
.btn.theme-reg{position:absolute; top:8px; left:43%; display:none;}
.inp-gray, .feed-mail-inp{border:1px solid #ccc; background-color:#fdfdfd; width:220px; height:16px; padding:4px; color:#444; margin-right:6px;}
.dform{text-align:center;}

.zz{width:560px; float:left; margin:65px 0 0 60px;}
.zz ul{width:100%; float:left;}
.zz ul li{width:270px; height:230px; float:left; margin:5px; overflow:hidden;}
.zz ul li a >img{display:block; transition:all 1s;}
.zz ul li a:hover > img {display: block; transform: scale(1.08); cursor: pointer;}
/*在施工地*/
.title{width:100%; margin:0 auto; text-align:center;}
.title h1{width:100%; background:url(http://img.dyrs.cc/special/555/100/104555/bg_t1.png!c) center center no-repeat; line-height:72px; font-size:48px; font-weight:bold; color:#000;}
.title span{color:#91471c; font-size:14px; text-transform:uppercase; line-height:32px;}
.title p{color:#91471c; font-size:16px; line-height:22px;}
.title p strong{font-size:24px; line-height:64px;}
.tab-show-center {
	box-sizing: border-box;
	-webkit-box-sizing: border-box;
	width: 1200px;
	margin: 0 auto;
}
.tab-show-center-img {
	width: 100%;
}
.show-container {
	margin: 00px auto 0;
	width: 290px;
	height: 220px;
	overflow: hidden;
	position: relative;
	margin-left: 10px;
	margin-bottom: 10px;
	color: #fff;
	float: left;
}
.show-bg-img {
	width: 100%;
	transition: .5s all;
}
.show-container:hover .show-bg-img {
	transform: scale(1.1, 1.1);
}
.right-top-tip {
	background: #D18E4A;
	position: absolute;
	top: 0;
	left: 0;
	height: 74px;
	width: 90px;
	padding-top: 6px;
	box-sizing: border-box; text-align:center;
}
.show-container:hover .right-top-tip, .show-container:hover .description-test {
	display: block;
}
.show-container:hover .detail-wrap {
	opacity: 1;
}
.big-font {
	font-size: 25px;
	display: inline-block;
	padding-right: 5px;
	font-weight: bold;
}
.description-test {
	bottom: 0;
	left: 0;
	line-height: 44px;
	height: 44px;
	width: 100%;
	text-align: center;
	position: absolute;
	background: rgba(0,0,0,.8);
}
.detail-wrap {
	position: absolute;
	left: 0;
	top: 0;
	width: 100%;
	height: 100%;
	background: rgba(0,0,0,.8);
	box-sizing: border-box;
	padding: 30px 20px 0;
	opacity: 0;
	transition: 1s .1s all;
}
.detail-img {
	width: 81px;
	display: block;
}
.detail-text a {
	display: block;
	color: #fff;
	font-size: 14px;
	font-weight: bold;
	margin-top: 20px;
	background: #900;
	width: 100px;
	height: 33px;
	line-height: 33px;
	text-decoration: none;text-align:center;
	margin: 66px auto 0;
}
.hot {
	width: 50px;
	height: 50px;
	position: absolute;
	margin-top: -220px;
	margin-left: 240px;
}
.right-top-tip1 {
	background: #d81e06; text-align:center;
	position: absolute;
	top: 0;
	left: 0;
	height: 74px;
	width: 90px;
	padding-top: 6px;
	box-sizing: border-box;
}

/*八大工艺*/

.headline{width:100%; margin:0 auto; text-align:center;}
.headline span{font-size:36px; line-height:72px; font-weight:bold; color:#191919;}
.headline .line{background:url(http://img.dyrs.cc/special/028/100/104028/line.png!c) center center no-repeat; height:8px;}
.headline p{font-size:18px; line-height:48px; color:#999;}
.nav_9{background:url(http://img.dyrs.cc/special/028/100/104028/4_03.jpg!c) no-repeat center; width:100%; height:599px}
.weixin{width:32px; height:32px; position:relative}
.weixin a{width:65px; height:62px; display:block; position:absolute; left:115px; top:125px;}
.weixin .weixin_nr{text-align:center; position:absolute; left:-45px; top:45px; display:none}
.weixin.on .weixin_nr{display:block; background:url(http://img.dyrs.cc/special/028/100/104028/fang.png!c) no-repeat center; width:352px; height:108px; margin-left:205px; padding-top:105px}
.weixin1{width:32px; height:32px; position:relative}
.weixin1 a{width:65px; height:62px; display:block; position:absolute; left:286px; top:350px;}
.weixin1 .weixin_nr1{text-align:center; position:absolute; left:-45px; top:45px; display:none}
.weixin1.on .weixin_nr1{display:block; background:url(http://img.dyrs.cc/special/028/100/104028/bao.png!c) no-repeat center; width:352px; height:108px; margin-left:390px; padding-top:565px}
.weixin2{width:32px; height:32px; position:relative}
.weixin2 a{width:65px; height:62px; display:block; position:absolute; left:266px; top:-20px;}
.weixin2 .weixin_nr2{text-align:center; position:absolute; left:-45px; top:45px; display:none}
.weixin2.on .weixin_nr2{display:block; background:url(http://img.dyrs.cc/special/028/100/104028/kai.png!c) no-repeat center; width:352px; height:108px; margin-left:370px; margin-top:-85px}
.weixin3{width:32px; height:32px; position:relative}
.weixin3 a{width:65px; height:62px; display:block; position:absolute; left:504px; top:-68px;}
.weixin3 .weixin_nr3{text-align:center; position:absolute; left:-45px; top:45px; display:none}
.weixin3.on .weixin_nr3{display:block; background:url(http://img.dyrs.cc/special/028/100/104028/fu.png!c) no-repeat center; width:352px; height:108px; margin-left:600px; margin-top:-135px}
.weixin4{width:32px; height:32px; position:relative}
.weixin4 a{width:65px; height:62px; display:block; position:absolute; left:656px; top:-92px;}
.weixin4 .weixin_nr4{text-align:center; position:absolute; left:-45px; top:45px; display:none}
.weixin4.on .weixin_nr4{display:block; background:url(http://img.dyrs.cc/special/028/100/104028/zao.png!c) no-repeat center; width:352px; height:108px; margin-left:730px; margin-top:-155px}
.weixin5{width:32px; height:32px; position:relative}
.weixin5 a{width:65px; height:62px; display:block; position:absolute; left:702px; top:-6px;}
.weixin5 .weixin_nr5{text-align:center; position:absolute; left:-45px; top:45px; display:none}
.weixin5.on .weixin_nr5{display:block; background:url(http://img.dyrs.cc/special/028/100/104028/chu.png!c) no-repeat center; width:352px; height:108px; margin-left:810px; margin-top:-70px}
.weixin6{width:32px; height:32px; position:relative}
.weixin6 a{width:65px; height:62px; display:block; position:absolute; left:456px; top:-6px;}
.weixin6 .weixin_nr6{text-align:center; position:absolute; left:-45px; top:45px; display:none}
.weixin6.on .weixin_nr6{display:block; background:url(http://img.dyrs.cc/special/028/100/104028/bo.png!c) no-repeat center; width:352px; height:108px; margin-left:530px; margin-top:-70px}
.weixin7{width:32px; height:32px; position:relative}
.weixin7 a{width:65px; height:62px; display:block; position:absolute; left:598px; top:90px;}
.weixin7 .weixin_nr7{text-align:center; position:absolute; left:-45px; top:45px; display:none}
.weixin7.on .weixin_nr7{display:block; background:url(http://img.dyrs.cc/special/028/100/104028/shui.png!c) no-repeat center; width:352px; height:108px; margin-left:701px; margin-top:25px}
.anniu ul li{width:240px; height:56px; text-align:center; font-size:24px; color:#FFF; float:left; background:#2d84d6; margin-right:20px; line-height:56px}

.fanhui{position:fixed; right:75px; bottom:40px;}
.sizhang{overflow:hidden;margin: 0 auto;}
.cemian{position:fixed; top:95px; left:20px; background:url(http://img.dyrs.cc/store/882/937/000/2675d27fcade2b11.png!c) no-repeat center; width:160px; height:373px; z-index:999;}
.one1{width:140px; height:32px; line-height:32px; color:#fff; font-size:14px; margin-bottom:11px; text-align:center; border-radius:5xp;}
.one2{width:120px; height:32px; line-height:32px; color:#fff; font-size:14px; text-align:center; background-color:red; margin-left:20px; border-radius:5xp;}
/*fixed box*/
.cd-popup {
    position: fixed;
    left: 0;
    top: 0;
    height: 100%;
    width: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    opacity: 0;
    visibility: hidden;
    -webkit-transition: opacity 0.3s 0s, visibility 0s 0.3s;
    -moz-transition: opacity 0.3s 0s, visibility 0s 0.3s;
    transition: opacity 0.3s 0s, visibility 0s 0.3s;
    z-index: 9999;
}

.cd-popup.is-visible {
    opacity: 1;
    visibility: visible;
    -webkit-transition: opacity 0.3s 0s, visibility 0s 0s;
    -moz-transition: opacity 0.3s 0s, visibility 0s 0s;
    transition: opacity 0.3s 0s, visibility 0s 0s;
}

.cd-popup-container {
    position: relative;
    width: 479px;
    margin: 150px auto;
    height: 471px;
    background: url(http://img.dyrs.cc/special/845/100/110845/z5.png!c) no-repeat center;
    text-align: center;
    -webkit-transform: scale(1.2);
    -moz-transform: scale(1.2);
    -ms-transform: scale(1.2);
    -o-transform: scale(1.2);
    transform: scale(1.2);
    -webkit-backface-visibility: hidden;
    -webkit-transition-property: -webkit-transform;
    -moz-transition-property: -moz-transform;
    transition-property: transform;
    -webkit-transition-duration: 0.3s;
    -moz-transition-duration: 0.3s;
    -ms-transition-duration: 0.3s;
    -o-transition-duration: 0.3s;
    transition-duration: 0.3s;
}

.is-visible .cd-popup-container {
    -webkit-transform: scale(1);
    -moz-transform: scale(1);
    -ms-transform: scale(1);
    -o-transform: scale(1);
    transform: scale(1);
}

.cd-popup-close {
    position: absolute;
    right: 10px;
    top: 4px;
    z-index: 10;
    width: 2rem;
    height: 2rem;
    display: block;
    font-size: 14px;
    float: right;
    font: bold 14px/14px simsun;
    text-shadow: 0 1px 0 #ddd;
    text-decoration: none;
    text-indent: -9999em;
}

.cd-buttons input {
    width: 416px;
    height: 59px;
    color: #b1b1b1;
    font-size: 16px;
    padding-left: 5px;
    font-family: Microsoft Yahei;
    border: 1px solid #e0e0e0;
    margin-bottom:9px;
}

.cd-buttons .comitBtn {
    width: 321px;
    height: 54px;
    line-height: 54px;
    display: inline-block;
    text-decoration:none;
    cursor:pointer;
}
</style>

<body style="position: inherit;">
<!--报名1-->
<div class="f1" style="margin-top:60px;">
    <div class="f1-i">
		<div class="ts1">
			<h1>免费报名预约参观工地</h1>
			<form action="/special/20200401/110845">
				<div class="item"><input type="text" value="请输入您的称呼" id="name1"></div>
				<div class="item"><input type="text" value="请输入您的电话" id="tel1"></div>
				<div class="item"><input type="text" value="请输入您的小区名称" id="lou1"></div>
				<div class="item"><input type="text" value="请输入您的装修面积" id="size1"></div>
				<a href="javascript:;" onclick="ckform1();" class="submit">立即预约</a>
			</form>
			<div class="clear"></div>
			<div class="tel1"></div>
		</div>
    </div>
</div>

<div class="f1" style="margin:10px auto;background:#f2f2f2;">
	<div class="f1-i" style="background:#f2f2f2; padding:50px;">
		<div class="title">
			<span><img src="./page_files/st_1.jpg!c" alt=""></span>
			<p style="margin-top:20px; font-size:16px;">东易日盛经过十数载的施工实践积累，根据中国建筑特性对施工工艺不断沉淀、创新，先后引入德系工艺体系及德系专利技术应用，同时企业<br>不断研发新型施工解决方案，推出欧洲8+N工艺体系及数十项自主研发改良的专利技术，为消费者提供行业装饰施工方案</p>
		</div>
		<div class="pk">
			<table>
				<tbody><tr>
					<th colspan="5" align="left"><img src="./page_files/pk_t1.jpg!c" alt=""></th>
				</tr>
				<tr>
					<td width="280" headers="180"><img src="./page_files/pk1_1.jpg!c" alt=""></td>
					<td width="220">
						<div class="pk_1">
							<h3>东易日盛装饰</h3>
							<div class="line1"></div>
							<p>东易水电工艺，让危险消融于身边，还您一个恬谧的家！</p>
						</div>
					</td>
					<td width="200" align="center"><img src="./page_files/pk.jpg!c" alt=""></td>
					<td width="280" headers="180"><img src="./page_files/pk1_2.jpg!c" alt=""></td>
					<td width="220">
						<div class="pk_2">
							<h3>其他装修公司</h3>
							<div class="line2"></div>
							<p>水管漏水、电器短路、安全事故…</p>
						</div>
					</td>
				</tr>
			</tbody></table>
			<table>
				<tbody><tr>
					<th colspan="5" align="left"><img src="./page_files/pk_t2.jpg!c" alt=""></th>
				</tr>
				<tr>
					<td width="280" headers="180"><img src="./page_files/pk2_1.jpg!c" alt=""></td>
					<td width="220">
						<div class="pk_1">
							<h3>东易日盛装饰</h3>
							<div class="line1"></div>
							<p>东易木工工艺，苛求每一处木制细节，提升家居环境精致感！</p>
						</div>
					</td>
					<td width="200" align="center"><img src="./page_files/pk.jpg!c" alt=""></td>
					<td width="280" headers="180"><img src="./page_files/pk2_2.jpg!c" alt=""></td>
					<td width="220">
						<div class="pk_2">
							<h3>其他装修公司</h3>
							<div class="line2"></div>
							<p>饰面损坏、开胶鼓包、木门变形…</p>
						</div>
					</td>
				</tr>
			</tbody></table>
			<table>
				<tbody><tr>
					<th colspan="5" align="left"><img src="./page_files/pk_t3.jpg!c" alt=""></th>
				</tr>
				<tr>
					<td width="280" headers="180"><img src="./page_files/pk3_1.jpg!c" alt=""></td>
					<td width="220">
						<div class="pk_1">
							<h3>东易日盛装饰</h3>
							<div class="line1"></div>
							<p>东易瓦工工艺，既要刀枪不入的坚固，亦要丝丝入扣的合拍！</p>
						</div>
					</td>
					<td width="200" align="center"><img src="./page_files/pk.jpg!c" alt=""></td>
					<td width="280" headers="180"><img src="./page_files/pk3_2.jpg!c" alt=""></td>
					<td width="220">
						<div class="pk_2">
							<h3>其他装修公司</h3>
							<div class="line2"></div>
							<p>墙面起鼓、裂缝，砂浆脱水、瓷砖厚薄不均…</p>
						</div>
					</td>
				</tr>
			</tbody></table>
			<table style="border:0;">
				<tbody><tr>
					<th colspan="5" align="left"><img src="./page_files/pk_t4.jpg!c" alt=""></th>
				</tr>
				<tr>
					<td width="280" headers="180"><img src="./page_files/pk4_1.jpg!c" alt=""></td>
					<td width="220">
						<div class="pk_1">
							<h3>东易日盛装饰</h3>
							<div class="line1"></div>
							<p>东易油工工艺，不仅让家有模有样，更要让家大放光彩！</p>
						</div>
					</td>
					<td width="200" align="center"><img src="./page_files/pk.jpg!c" alt=""></td>
					<td width="280" headers="180"><img src="./page_files/pk4_2.jpg!c" alt=""></td>
					<td width="220">
						<div class="pk_2">
							<h3>其他装修公司</h3>
							<div class="line2"></div>
							<p>偷工减料、墙面起泡开裂、手感不顺滑、墙纸扯裂…</p>
						</div>
					</td>
				</tr>
			</tbody></table>
		</div>
		<ul class="btnst">
			<a target="_blank" href="/service/benefit">了解更多施工工艺</a>
			<a href="javascript:void(0)" onclick="openZoosUrl(&#39;chatwin&#39;)" target="_blank">点击咨询专业家装顾问 </a>
		</ul>
	</div>
</div>







<div class="f1">
	<div class="f1-i">
		<div class="title" style="margin:60px auto 30px;">
			<span><img src="./page_files/bg_40.jpg!c" alt=""></span>
			<p style="margin-top:20px; font-size:16px;">东易日盛严苛落实“健康、品质、服务、效率”四大保障，表里如一的匠心工程才能配得上您的好房子。</p>
		</div>
		<div class="jk">
			<table border="0">
				<tbody><tr>
					<td>
						<div class="jk_c">
							<span>全面保护</span>
							<div class="line"></div>
							<p>我们对每一户家从场外到场内<br>均作全面细致的保护<br>确保工地规范、安全、可靠。</p>
						</div>
					</td>
					<td colspan="2" style="width:598px;"><img src="./page_files/j_1.jpg!c" alt=""></td>
					<td>
						<div class="jk_c">
							<span>材料堆放严格</span>
							<div class="line"></div>
							<p>行之有效的材料管理制度<br>确保东易工地材料质量始终如一</p>
						</div>
					</td>
				</tr>
				<tr>
					<td><img src="./page_files/j_2.jpg!c" alt=""></td>
					<td>
						<div class="jk_c">
							<span>工人培训提升</span>
							<div class="line"></div>
							<p>专业的人做专业的事<br>提升工人综合素质，提高施工效率</p>
						</div>
					</td>
					<td><img src="./page_files/j_3.jpg!c" alt=""></td>
					<td>
						<div class="jk_c">
							<span>规范施工标准</span>
							<div class="line"></div>
							<p>8+28企业内控<br>8+N环保工艺体系<br>……</p>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="jk_c">
							<span>智能监管</span>
							<div class="line"></div>
							<p>监控摄像头、微信服务群<br>线上及时沟通交流<br>您在不在现场都一样！</p>
						</div>
					</td>
					<td><img src="./page_files/j_4.jpg!c" alt=""></td>
					<td>
						<div class="jk_c">
							<span>检查验收严格</span>
							<div class="line"></div>
							<p>各个环节细致检查、严格验收<br>“审判官”为东易精品工地证言！</p>
						</div>
					</td>
					<td><img src="./page_files/j_5.jpg!c" alt=""></td>
				</tr>
			</tbody></table>
		</div>
		<ul class="btnst" style="padding-top:50px;">
			<a target="_blank" href="/construction">了解更多精品工地</a>
			<a href="javascript:void(0)" onclick="openZoosUrl(&#39;chatwin&#39;)" target="_blank">预约参观在施工地</a>
		</ul>

	</div>
</div>

<div class="theme-popover-mask"></div>


<div class="f1 l1 us">
	<div class="f1-i">
		<div class="title" style="margin-top:30px; margin-bottom:20px;">
			<div class="f1">
				<div class="f1-i" style="width:1300px; padding:50px; background:#fff;">
					<div class="title">
						<span><img src="./page_files/t_3.jpg!c" alt=""></span>
					</div>
				</div>
			</div>

			<p><strong>2020服务楼盘</strong></p>
		</div>
		<div class="tab-show-center">
    
     <div class="show-container"> <img class="show-bg-img" src="./page_files/001.jpg">
      <div class="right-top-tip1"> <span><span class="big-font">158</span>户</span><br>
        <span>签约业主</span> </div>
         <div class="hot">
        <img src="./page_files/hot3.png!c">
        </div>
      <p class="description-test"> 香山美墅</p>
      <div class="detail-wrap">
        <p class="detail-text"> <a href="/case" target="_blank"> 浏览案例</a> </p>
      </div>
    </div>
     <div class="show-container"> <img class="show-bg-img" src="./page_files/002.jpg">
      <div class="right-top-tip1"> <span><span class="big-font">36</span>户</span><br>
        <span>签约业主</span> </div>
         <div class="hot"> <img src="./page_files/hot5.png!c"> </div>
      <p class="description-test"> 宏发前城 </p>
      <div class="detail-wrap">
        <p class="detail-text"> <a href="/case" target="_blank"> 浏览案例</a> </p>
      </div>
    </div>
    
       <div class="show-container"> <img class="show-bg-img" src="./page_files/003.jpg">
      <div class="right-top-tip1"> <span><span class="big-font">12</span>户</span><br>
        <span>签约业主</span> </div>
         <div class="hot"> <img src="./page_files/hot5.png!c"> </div>
      <p class="description-test">绿景红树湾 </p>
      <div class="detail-wrap">
        <p class="detail-text"> <a href="/case" target="_blank"> 浏览案例</a> </p>
      </div>
    </div>
    
    <div class="show-container"> <img class="show-bg-img" src="./page_files/010.jpg">
      <div class="right-top-tip1"> <span><span class="big-font">75</span>户</span><br>
        <span>签约业主</span> </div>
         <div class="hot">
        <img src="./page_files/hot3.png!c">
        </div>
      <p class="description-test">深业东岭</p>
      <div class="detail-wrap">
        <p class="detail-text"> <a href="/case" target="_blank"> 浏览案例</a> </p>
      </div>
    </div>
    
    
    <div class="show-container"> <img class="show-bg-img" src="./page_files/004.jpg">
      <div class="right-top-tip"> <span><span class="big-font">21</span>户</span><br>
        <span>签约业主</span> </div>
     
      <p class="description-test"> 壹方中心</p>
      <div class="detail-wrap">
        <p class="detail-text"> <a href="/case" target="_blank"> 浏览案例</a> </p>
      </div>
    </div>
    
    
      <div class="show-container"> <img class="show-bg-img" src="./page_files/006.jpg">
      <div class="right-top-tip"> <span><span class="big-font">62</span>户</span><br>
        <span>签约业主</span> </div>
      <p class="description-test">前海东岸</p>
      <div class="detail-wrap">
        <p class="detail-text"> <a href="/case" target="_blank" );"=""> 浏览案例</a> </p>
      </div>
    </div>
    
  
    <div class="show-container"> <img class="show-bg-img" src="./page_files/007.jpg">
      <div class="right-top-tip"> <span><span class="big-font">18</span>户</span><br>
        <span>签约业主</span> </div>
      <p class="description-test">新天鹅堡</p>
      <div class="detail-wrap">
        <p class="detail-text"> <a href="/case" target="_blank"> 浏览案例</a> </p>
      </div>
    </div>
   
    <div class="show-container"> <img class="show-bg-img" src="./page_files/jiangwancheng.jpg">
      <div class="right-top-tip"> <span><span class="big-font">67</span>户</span><br>
        <span>签约业主</span> </div>
      <p class="description-test"> 碧海君庭 </p>
      <div class="detail-wrap">
        <p class="detail-text"> <a href="/case" target="_blank"> 浏览案例</a> </p>
      </div>
    </div>
  

     <div class="show-container"> <img class="show-bg-img" src="./page_files/008.jpg">
      <div class="right-top-tip"> <span><span class="big-font">43</span>户</span><br>
        <span>签约业主</span> </div>
      <p class="description-test">博林天瑞</p>
      <div class="detail-wrap">
        <p class="detail-text"> <a href="/case" target="_blank"> 浏览案例</a> </p>
      </div>
    </div>

    
    <div class="show-container"> <img class="show-bg-img" src="./page_files/tianyuanshijia.jpg">
      <div class="right-top-tip"> <span><span class="big-font">59</span>户</span><br>
        <span>签约业主</span> </div>
      <p class="description-test"> 华润城 </p>
      <div class="detail-wrap">
        <p class="detail-text"> <a href="/case" target="_blank"> 浏览案例</a> </p>
      </div>
    </div>

    
     <div class="show-container"> <img class="show-bg-img" src="./page_files/wankerunyuan.jpg">
      <div class="right-top-tip"> <span><span class="big-font">18</span>户</span><br>
        <span>签约业主</span> </div>
      <p class="description-test"> 万科第五园 </p>
      <div class="detail-wrap">
        <p class="detail-text"> <a href="/case" target="_blank"> 浏览案例</a> </p>
      </div>
    </div>

    
    <div class="show-container"> <img class="show-bg-img" src="./page_files/009.jpg">
      <div class="right-top-tip"> <span><span class="big-font">8</span>户</span><br>
        <span>签约业主</span> </div>
      <p class="description-test"> 星河丹堤 </p>
      <div class="detail-wrap">
        <p class="detail-text"> <a href="/case" target="_blank"> 浏览案例</a> </p>
      </div>
    </div>


	</div>
</div>
<div class="f1" style="background:url(http://img.dyrs.cc/store/993/073/000/4925e0d9d97c32fc.jpg!c) center center no-repeat; height:500px; margin:60px auto 0;"></div>

<div class="f1" style="background:url(http://img.dyrs.cc/special/737/100/105737/bg_76.jpg!c) center center no-repeat; height:620px;">
	<div class="f1-i">
		<div class="ts3">
			<h2>免费预约参观工地</h2>
			<form action="/special/20200401/110845">
				<div class="item"><input type="text" value="请输入您的称呼" id="name3"></div>
				<div class="item"><input type="text" value="请输入您的电话" id="tel3"></div>
				<div class="item"><input type="text" value="请输入您的小区名称" id="lou3"></div>
				<div class="item"><input type="text" value="请输入您的装修面积" id="size3"></div>
				<p>*您的信息将严格保密，请放心填写！</p>
				<a href="javascript:;" onclick="ckform3();" class="submit">预约参观工地</a>
			</form>
			<p style="font-size:16px; line-height:32px;">24小时免费服务热线</p>
			<p style="font-size:30px; font-weight:bold;">400-6180-779</p>
		</div>
		<div class="zz">
			<ul>
				<li><a href="/case" target="_blank"><img src="./page_files/b_1.jpg!c" alt=""></a></li>
				<li><a href="/designer" target="_blank"><img src="./page_files/b_2.jpg!c" alt=""></a></li>
				<li><a href="/column/guide" target="_blank" );"=""><img src="./page_files/b_3.jpg!c" alt=""></a></li>
				<li><a href="/building" target="_blank"><img src="./page_files/b_4.jpg!c" alt=""></a></li>
			</ul>
		</div>
	</div>
</div>
<?php echo '<script'; ?>
>
var ts_input=$("input");
ts_input.each(function(){
    var val=$(this).val();
    $(this).focus(function(){
        $(this).val("");
    });
    $(this).blur(function(){
        if($(this).val()==""){
            $(this).val(val)
        }else if(!$(this).val){
            val=$(this).val
        }
    })
})
function ckform1(){
    var $form=$('.ts1 form'),$name=$('#name1'),$phone=$('#tel1'),$loupan=$('#lou1'),$acreage=$('#size1');
    if($name.val()=="请输入您的称呼"){
        alert("请输入您的姓名！");$name.focus();return false
    }
    if (! $phone.val() | ! $phone.val().match(/^[0-9,-]{7,13}$/)){
        alert('请填写您的手机号!');$phone.focus();return false;
    }else{
        $.ajax({
            url:'/api/user/special_appoint.php',
            dataType:'jsonp',   //返回数据
            data:{
                name:$name.val(),           //姓名
                phone:$phone.val(),         //电话
                loupan:$loupan.val(),      //楼盘
                acreage:$acreage.val(),      //面积
                desc:"工地专题报名",            //描述
                // specialid:specialid,     //专题id 
                action:'specials'           //专题类型
            },
            success:function(d){
             if(d.code==1){
             zhuge.track('工地专题报名', d);
             }
                alert(d.msg);
                if(d.code== 1){
                    $form[0].reset();
                }
            },
            error:function(d){str = JSON.parse(d.responseText);alert(str.msg);$form[0].reset();}
         })
    }
}
function ckform2(){
    var $form=$('.ts2 form'),$name=$('#name2'),$phone=$('#tel2'),$loupan=$('#lou2'),$acreage=$('#size2');
    if($name.val()=="请输入您的称呼"){
        alert("请输入您的姓名！");$name.focus();return false
    }
    if (! $phone.val() | ! $phone.val().match(/^[0-9,-]{7,13}$/)){
        alert('请填写您的手机号!');$phone.focus();return false;
    }else{
        $.ajax({
            url:'/api/user/special_appoint.php',
            dataType:'jsonp',   //返回数据
            data:{
                name:$name.val(),           //姓名
                phone:$phone.val(),         //电话
                loupan:$loupan.val(),      //楼盘
                acreage:$acreage.val(),      //面积
                desc:"工地专题报名",            //描述
                // specialid:specialid,     //专题id 
                action:'specials'           //专题类型
            },
            success:function(d){
             if(d.code==1){
             zhuge.track('工地专题报名', d);
             }
                alert(d.msg);
                if(d.code== 1){
                    $form[0].reset();
                }
            },
            error:function(d){str = JSON.parse(d.responseText);alert(str.msg);$form[0].reset();}
         })
    }
}
function ckform3(){
    var $form=$('.ts3 form'),$name=$('#name3'),$phone=$('#tel3'),$loupan=$('#lou3'),$acreage=$('#size3');
    if($name.val()=="请输入您的称呼"){
        alert("请输入您的姓名！");$name.focus();return false
    }
    if (! $phone.val() | ! $phone.val().match(/^[0-9,-]{7,13}$/)){
        alert('请填写您的手机号!');$phone.focus();return false;
    }else{
        $.ajax({
            url:'/api/user/special_appoint.php',
            dataType:'jsonp',   //返回数据
            data:{
                name:$name.val(),           //姓名
                phone:$phone.val(),         //电话
                loupan:$loupan.val(),      //楼盘
                acreage:$acreage.val(),      //面积
                desc:"工地专题底部报名",            //描述
                // specialid:specialid,     //专题id 
                action:'specials'           //专题类型
            },
            success:function(d){
             if(d.code==1){
             zhuge.track('工地专题报名', d);
             }
                alert(d.msg);
                if(d.code== 1){
                    $form[0].reset();
                }
            },
            error:function(d){str = JSON.parse(d.responseText);alert(str.msg);$form[0].reset();}
         })
    }
}
function ckform5(){
    var $form=$('.ts5 form'),$name=$('#name5'),$phone=$('#tel5'),$loupan=$('#lou5'),$acreage=$('#size5');
    if($name.val()=="请输入您的称呼"){
        alert("请输入您的姓名！");$name.focus();return false
    }
    if (! $phone.val() | ! $phone.val().match(/^[0-9,-]{7,13}$/)){
        alert('请填写您的手机号!');$phone.focus();return false;
    }else{
        $.ajax({
            url:'/api/user/special_appoint.php',
            dataType:'jsonp',   //返回数据
            data:{
                name:$name.val(),           //姓名
                phone:$phone.val(),         //电话
                loupan:$loupan.val(),      //楼盘
                acreage:$acreage.val(),      //面积
                desc:"工地专题报名",            //描述
                // specialid:specialid,     //专题id 
                action:'specials'           //专题类型
            },
            success:function(d){
             if(d.code==1){
             zhuge.track('工地专题报名', d);
             }
                alert(d.msg);
                if(d.code== 1){
                    $form[0].reset();
                }
            },
            error:function(d){str = JSON.parse(d.responseText);alert(str.msg);$form[0].reset();}
         })
    }
}
function ckform6(){
    var $form=$('.ts6 form'),$name=$('#name6'),$phone=$('#tel6'),$loupan=$('#lou6'),$acreage=$('#size6'),names=$name.val(),
		    names=$name.val() ,  phones=$phone.val() ,  loupans=$loupan.val() ,acreages=$acreage.val();
    if($name.val()=="请输入您的称呼"){
        alert("请输入您的姓名！");$name.focus();return false
    }
    if (! $phone.val() | ! $phone.val().match(/^[0-9,-]{7,13}$/)){
        alert('请填写您的手机号!');$phone.focus();return false;
    }else{
		
        $.ajax({
            url:'/api/user/special_appoint.php',
            dataType:'jsonp',   //返回数据
            data:{
                name:$name.val(),           //姓名
                phone:$phone.val(),         //电话
                loupan:$loupan.val(),      //楼盘
                acreage:$acreage.val(),      //面积
                desc:"工地专题报名",            //描述
                // specialid:specialid,     //专题id 
                action:'specials'           //专题类型
            },
            success:function(d){
             if(d.code==1){
             zhuge.track('工地专题报名', d);
             }
				alert(d.msg);
				$name.val(names);          //姓名
                $phone.val(phones);        //电话
                $loupan.val(loupans);    //楼盘
                $acreage.val(acreages);
                if(d.code== 1){
                    $form[0].reset();
                }
            },
            error:function(d){str = JSON.parse(d.responseText);alert(str.msg);$form[0].reset();}
         })
    }
}
<?php echo '</script'; ?>
>
<!--tabbox-->
<?php echo '<script'; ?>
>
$(function(){
	$('.tabbox .content ul').width(1200*$('.tabbox .content li').length+'px');
	$(".tabbox .tab a").mouseover(function(){
		$(this).addClass('on').siblings().removeClass('on');
		var index = $(this).index();
		number = index;
		var distance = -1200*index;
		$('.tabbox .content ul').stop().animate({
			left:distance
		});
	});
	
	var auto = 1;  //等于1则自动切换，其他任意数字则不自动切换
	if(auto ==1){
		var number = 0;
		var maxNumber = $('.tabbox .tab a').length;
		function autotab(){
			number++;
			number == maxNumber? number = 0 : number;
			$('.tabbox .tab a:eq('+number+')').addClass('on').siblings().removeClass('on');
			var distance = -1200*number;
			$('.tabbox .content ul').stop().animate({
				left:distance
			});
		}
		var tabChange = setInterval(autotab,3000);
		//鼠标悬停暂停切换
		$('.tabbox').mouseover(function(){
			clearInterval(tabChange);
		});
		$('.tabbox').mouseout(function(){
			tabChange = setInterval(autotab,3000);
		});
	  }





	$('#sub_oldhouse').click(function(){



		var actionUrl = "/messages/addno.html";
		$.post(actionUrl,function(data,status){

			alert("Data: " + data + "nStatus: " + status);

			// if(data.status){
			// 	layer.msg(data.info);
			// }else{
			// 	layer.msg(data.info);
			// }
			//
			//
			// if (data.url) {
			// 	location.href=data.url;
			// }
		});
	});
});
jQuery(document).ready(function ($) {
    //打开窗口
    $('.cd-popup-trigger').on('click', function (event) {
        event.preventDefault();
        $('.cd-popup').addClass('is-visible');
    });
    //关闭窗口
    $('.cd-popup').on('click', function (event) {
        if ($(event.target).is('.cd-popup-close') || $(event.target).is('.cd-popup')) {
            event.preventDefault();
            $(this).removeClass('is-visible');
        }
    });
    //ESC关闭
    $(document).keyup(function (event) {
        if (event.which == '27') {
            $('.cd-popup').removeClass('is-visible');
        }
    });
});
<?php echo '</script'; ?>
>




	<style>
    .LR_yaoqing-form{
        box-sizing: content-box !important;
    }
</style>


<?php }
}
