<?php
/* Smarty version 3.1.34-dev-7, created on 2020-11-27 14:42:59
  from '/Volumes/51/idiQu/public/page/templates/suanpage.htm' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5fc09ff372dad4_80768506',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2cde9fa45c9bd603ae3dec435f4f5960f3e1e301' => 
    array (
      0 => '/Volumes/51/idiQu/public/page/templates/suanpage.htm',
      1 => 1606459376,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5fc09ff372dad4_80768506 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <?php echo '<script'; ?>
 id="hz6d_send_acc" src="./suanpage/sendacc.html" charset="utf-8"><?php echo '</script'; ?>
>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no,shrink-to-fit=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="email=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="./suanpage/zxjsq.css">
    <link rel="stylesheet" href="./suanpage/common.css">
    <link rel="stylesheet" href="./suanpage/header.css">
    <?php echo '<script'; ?>
 src="./suanpage/stat"><?php echo '</script'; ?>
><?php echo '<script'; ?>
 src="./suanpage/jquery-1.8.0.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="http://zhuangxiu.qilaixiu.com/Theme/t24/pc/Static/js/layer/layer.js"><?php echo '</script'; ?>
>
    <title>计算器报价</title>
    <style type="text/css">
        .sub{
            display:none;
            float:right!important;
        }
    </style>
    <?php echo '<script'; ?>
 type="text/javascript">
        $(function () {
            $("#sel1").change(function(){
                $("#sel1 option").each(function(i,o){
                    if(this.selected){
                        $(".sub").hide();
                        $(".sub").eq(i).show();
                        //$(".sub").val("");
                        $("#cityId").val("");
                        $("#cityName").val("");
                    }
                });
            });
            $("#sel1").change();
            $(".sub").change(function(){
                $("#cityId").val($(this).find("option:selected").val());
                $("#cityName").val($(this).find("option:selected").text());
            });
        });
    <?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript">
        function CheckContact(phone, name,housearea, cityid) {
            if (cityid == "" || cityid == undefined || cityid == null || cityid=="undefined" || cityid=="请选择城市") {
                alert("请选择城市");
                return false;
            }
            if (housearea == "" || housearea == null || housearea == undefined) {
                alert("房屋面积必须填写");
                $("#housearea").focus();
                $("#housearea").val("");
                return false;
            }
            else if(!isDecimal(housearea)) {
                alert("输入的房屋面积必须是整数或者包含两位小数");
                $("#housearea").focus();
                $("#housearea").val("");
                return false;
            }
            if (phone == "" || phone == null || phone == undefined) {
                alert("手机号码必须填写");
                $("#phone1").focus();
                $("#phone1").val("");
                return false;
            }
            if (!isMoblie(phone)) {
                alert("请填写真实的手机号码。");
                $("#phone1").focus();
                return false;
            }
            if (name == "" || name==undefined || name == null) {
                alert("请输入您的姓名");
                $("#name1").focus();
                return false;
            }

            return true;
        }
        var isApplySubmit = true;
        // 点击开始计算或获取报价
        function FreeApply() {
            var phone = $("#phone1").val();
            var housearea = $("#housearea").val();
            var name = $("#name1").val();
            var cityid=$("#cityId").val();
            var cityName=$("#cityName").val();
            var provinceId = $("#sel1 option:selected").val();
            var shi = $("#shiselect option:selected").val();
            var ting = $("#tingselect option:selected").val();
            var chu = $("#chuselect option:selected").val();
            var wei = $("#weiselect option:selected").val();
            var yt = $("#ytselect option:selected").val();
            var remark = "所在城市："+cityName+" 建筑面积：" + housearea ;
            if (CheckContact(phone,name, housearea, cityid)) {
                if (isApplySubmit) {
                    isApplySubmit = false;
                    // console.log('phone'+phone);
                    // console.log('houserare'+housearea);
                    // console.log('name'+ name);
                    // console.log('cityid'+ cityid);
                    // console.log('cityName'+ cityName);
                    // console.log('provinceId'+provinceId);
                    // console.log('shi'+shi);
                    // console.log('ting'+ting);
                    // console.log('chu'+chu);
                    // console.log('wei'+wei);
                    // console.log('yt'+yt);
                    // console.log('remark'+remark);
                    console.log( remark+  shi + '室' + ting + '厅' + chu + '厨 ' + wei + '卫  ' + yt + '阳台 ');
                    var actionUrl = "/messages/addno.html";
                    $.post(actionUrl, {
                            name: name,
                            phone: phone,
                            content: remark+  shi + '室' + ting + '厅' + chu + '厨 ' + wei + '卫  ' + yt + '阳台 '
                        },
                        function (data, status) {
                            if (data.status) {
                                layer.msg(data.info);
                            } else {
                                layer.msg(data.info);
                            }
                            // if (data.url) {
                            // 	location.href=data.url;
                            // }
                        });

                }
                else {
                    alert("请勿重复提交或者请刷新页面重试！");
                }
            }
        };
    <?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript">
        var isApplySubmit2 = true;
        function FreeApplyMF() {
            var name = $("#name2").val();
            var phone = $("#phone2").val();
            if (isEmpty(name)) {
                $("#name2").focus()
                alert("请输入您的姓名");
                return true;
            }
            if (isEmpty(phone)) {
                $("#phone2").focus()
                alert("请输入您的手机号码");
                return true;
            }
            if (!isMoblie(phone)) {
                $("#phone2").focus()
                alert("您输入的手机号码不正确！");
                return true;
            }
            if (isApplySubmit2) {
                isApplySubmit2 = false;
                //<!--转化代码-->
            }
            else {
                alert("请勿重复提交或者请刷新页面重试！");
            }
        }



        function isEmpty(str) {
            if (str == null || str == undefined || str == "undefined") {
                return true;
            }
            else {
                if (str.replace(/(^s*)|(s*$)/g, "").length > 0) {
                    return false;
                }
                else {
                    return true;
                }
            }
        }

        function isMoblie(mobile) {
            var telzz = /^(12|13|14|15|16|17|18|19)\d{9}$/;
            if (telzz.test(mobile)) {
                return true;
            } else {
                return false;
            }
        }

        function isDecimal(num) {
            var telzz = /^-?\d+\.?\d{1,2}$/;
            if (telzz.test(num)) {
                return true;
            } else {
                return false;
            }
        }


    <?php echo '</script'; ?>
>
</head>
<body>
<!-- 导航栏开始 -->
<div class="top-zt">
    <div class="nav-index-wrap-zt nav-wrap">
        <div class="nav-index-zt">
            <a href="" class="nav-logo-zt"><img src="./suanpage/logo@2x.png" alt=""></a>
            <div class="nav-main-zt nav-main-white">
                <a href="/" class="nav-col"><span class="nav-name-zt active03">首页</span></a>
                <a href="/page/" class="nav-col"><span class="nav-name-zt">私人定制</span></a>
                <a href="http://www.swjzx.com/lists/2.html" class="nav-col"><span class="nav-name-zt">装修效果图</span></a>
                <a href="http://www.swjzx.com/lists/5.html" class="nav-col"><span class="nav-name-zt">在建工地</span></a>
                <a href="http://www.swjzx.com/lists/6.html" class="nav-col"><span class="nav-name-zt">设计师</span></a>
                <a href="http://www.swjzx.com/page/7.html" class="nav-col"><span class="nav-name-zt">品质工艺</span></a>
                <a href="http://www.swjzx.com/lists/8.html" class="nav-col"><span class="nav-name-zt">装修知识</span></a>
                <a href="http://www.swjzx.com/lists/26.html" class="nav-col"><span class="nav-name-zt">家装案例</span></a>
            </div>
        </div>
        <div class="nav-cont-wrap-zt nav-cont-wrap01">
            <div class="nav-cont-zt nav-cont-white">
                <div class="nav-cont-div"></div>
                <div class="nav-cont-div-zt">

                </div>
                <div class="nav-cont-div-zt">

                </div>
                <div class="nav-cont-div-zt">
                </div>
                <div class="nav-cont-div-zt"></div>
                <div class="nav-cont-div-zt nav-ser">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 导航栏结束 -->
<div class="cal_pop">
    <!-- <img src="images/bg.jpg" alt="" /> -->
    <div class="cal_pop_pic">
        <img src="./suanpage/wenzi@2x.png" alt="">
    </div>
    <div class="cal_pop_cont">
        <img src="./suanpage/jsq-out.png" class="cal_pop_close">
        <div class="cal_pop_input clear">
            <form class="cal_pop_input_main " id="cityJsqForm">
                <div class="cal_title-box">
                    <p class="cal_title">装修计算器</p>
                    <p class="cal_p">今天已有<span>1960</span>位业主获取了装修预算</p>
                </div>
                <div class="cal_pop_input_col clear">
                    <div class="cal_pop_input_col_text">
                        <span>所在城市：</span>
                        <img src="./suanpage/cal_star.png">
                    </div>
                    <div class="cal_pop_input_col_ri">
                        <input type="hidden" id="cityId" value="">
                        <input type="hidden" id="cityName" value="">
                        <select id="sel1" style="width: 45%;">
                            <option value="">请选择省份</option>
                            <option value="9">福建省</option>
                            <option value="113">北京市</option>
                            <option value="132">天津市</option>
                            <option value="151">河北省</option>
                            <option value="346">山西省</option>
                            <option value="488">内蒙古自治区</option>
                            <option value="611">辽宁省</option>
                            <option value="740">吉林省</option>
                            <option value="818">黑龙江省</option>
                            <option value="972">上海市</option>
                            <option value="992">江苏省</option>
                            <option value="1123">浙江省</option>
                            <option value="1236">安徽省</option>
                            <option value="1619">江西省</option>
                            <option value="1742">山东省</option>
                            <option value="1917">河南省</option>
                            <option value="2112">湖北省</option>
                            <option value="2242">湖南省</option>
                            <option value="2392">广东省</option>
                            <option value="2554">广西壮族自治区</option>
                            <option value="2692">海南省</option>
                            <option value="2721">重庆市</option>
                            <option value="2762">四川省</option>
                            <option value="2983">贵州省</option>
                            <option value="3086">云南省</option>
                            <option value="3240">西藏自治区</option>
                            <option value="3322">陕西省</option>
                            <option value="3450">甘肃省</option>
                            <option value="3563">青海省</option>
                            <option value="3616">宁夏回族自治区</option>
                            <option value="3649">新疆维吾尔自治区</option>
                        </select>
                        <select style="width: 50%; display: block;" class="sub">
                            <option>请选择城市</option>
                        </select>
                        <select class="sub" id="city" style="display: none;">
                            <option>请选择城市</option>
                            <option value="10">福州市</option>
                            <option value="11">厦门市</option>
                            <option value="12">莆田市</option>
                            <option value="13">三明市</option>
                            <option value="14">泉州市</option>
                            <option value="15">漳州市</option>
                            <option value="16">南平市</option>
                            <option value="17">龙岩市</option>
                            <option value="18">宁德市</option>
                            <option value="31">福清市</option>
                            <option value="32">长乐市</option>
                            <option value="58">永安市</option>
                            <option value="69">石狮市</option>
                            <option value="70">晋江市</option>
                            <option value="71">南安市</option>
                            <option value="83">龙海市</option>
                            <option value="91">邵武市</option>
                            <option value="92">武夷山市</option>
                            <option value="93">建瓯市</option>
                            <option value="94">建阳市</option>
                            <option value="102">漳平市</option>
                            <option value="111">福安市</option>
                            <option value="112">福鼎市</option>
                        </select>
                        <select class="sub" style="display: none;">
                            <option>请选择城市</option>
                            <option value="114">北京市</option>
                            <option value="129">县</option>
                        </select>
                        <select class="sub" style="display: none;">
                            <option>请选择城市</option>
                            <option value="133">天津市</option>
                            <option value="147">县</option>
                        </select>
                        <select class="sub" style="display: none;">
                            <option>请选择城市</option>
                            <option value="152">石家庄市</option>
                            <option value="177">唐山市</option>
                            <option value="193">秦皇岛市</option>
                            <option value="202">邯郸市</option>
                            <option value="223">邢台市</option>
                            <option value="244">保定市</option>
                            <option value="271">张家口市</option>
                            <option value="290">承德市</option>
                            <option value="303">沧州市</option>
                            <option value="321">廊坊市</option>
                            <option value="333">衡水市</option>
                        </select>
                        <select class="sub" style="display: none;">
                            <option>请选择城市</option>
                            <option value="347">太原市</option>
                            <option value="359">大同市</option>
                            <option value="372">阳泉市</option>
                            <option value="379">长治市</option>
                            <option value="394">晋城市</option>
                            <option value="402">朔州市</option>
                            <option value="410">晋中市</option>
                            <option value="423">运城市</option>
                            <option value="438">忻州市</option>
                            <option value="454">临汾市</option>
                            <option value="473">吕梁市</option>
                        </select>
                        <select class="sub" style="display: none;">
                            <option>请选择城市</option>
                            <option value="489">呼和浩特市</option>
                            <option value="500">包头市</option>
                            <option value="511">乌海市</option>
                            <option value="516">赤峰市</option>
                            <option value="530">通辽市</option>
                            <option value="540">鄂尔多斯市</option>
                            <option value="550">呼伦贝尔市</option>
                            <option value="565">巴彦淖尔市</option>
                            <option value="574">乌兰察布市</option>
                            <option value="587">兴安盟</option>
                            <option value="594">锡林郭勒盟</option>
                            <option value="607">阿拉善盟</option>
                        </select>
                        <select class="sub" style="display: none;">
                            <option>请选择城市</option>
                            <option value="612">沈阳市</option>
                            <option value="627">大连市</option>
                            <option value="639">鞍山市</option>
                            <option value="648">抚顺市</option>
                            <option value="657">本溪市</option>
                            <option value="665">丹东市</option>
                            <option value="673">锦州市</option>
                            <option value="682">营口市</option>
                            <option value="690">阜新市</option>
                            <option value="699">辽阳市</option>
                            <option value="708">盘锦市</option>
                            <option value="714">铁岭市</option>
                            <option value="723">朝阳市</option>
                            <option value="732">葫芦岛市</option>
                        </select>
                        <select class="sub" style="display: none;">
                            <option>请选择城市</option>
                            <option value="741">长春市</option>
                            <option value="753">吉林市</option>
                            <option value="764">四平市</option>
                            <option value="772">辽源市</option>
                            <option value="778">通化市</option>
                            <option value="787">白山市</option>
                            <option value="795">松原市</option>
                            <option value="802">白城市</option>
                            <option value="809">延边朝鲜族自治州</option>
                        </select>
                        <select class="sub" style="display: none;">
                            <option>请选择城市</option>
                            <option value="819">哈尔滨市</option>
                            <option value="839">齐齐哈尔市</option>
                            <option value="857">鸡西市</option>
                            <option value="868">鹤岗市</option>
                            <option value="878">双鸭山市</option>
                            <option value="888">大庆市</option>
                            <option value="899">伊春市</option>
                            <option value="918">佳木斯市</option>
                            <option value="930">七台河市</option>
                            <option value="936">牡丹江市</option>
                            <option value="948">黑河市</option>
                            <option value="956">绥化市</option>
                            <option value="968">大兴安岭地区</option>
                        </select>
                        <select class="sub" style="display: none;">
                            <option>请选择城市</option>
                            <option value="973">上海市</option>
                            <option value="990">县</option>
                        </select>
                        <select class="sub" style="display: none;">
                            <option>请选择城市</option>
                            <option value="993">南京市</option>
                            <option value="1008">无锡市</option>
                            <option value="1018">徐州市</option>
                            <option value="1030">常州市</option>
                            <option value="1039">苏州市</option>
                            <option value="1049">昆山市</option>
                            <option value="1052">南通市</option>
                            <option value="1062">连云港市</option>
                            <option value="1071">淮安市</option>
                            <option value="1081">盐城市</option>
                            <option value="1092">扬州市</option>
                            <option value="1100">镇江市</option>
                            <option value="1108">泰州市</option>
                            <option value="1116">宿迁市</option>
                        </select>
                        <select class="sub" style="display: none;">
                            <option>请选择城市</option>
                            <option value="1124">杭州市</option>
                            <option value="1139">宁波市</option>
                            <option value="1152">温州市</option>
                            <option value="1165">嘉兴市</option>
                            <option value="1174">湖州市</option>
                            <option value="1181">绍兴市</option>
                            <option value="1189">金华市</option>
                            <option value="1200">衢州市</option>
                            <option value="1208">舟山市</option>
                            <option value="1214">台州市</option>
                            <option value="1225">丽水市</option>
                        </select>
                        <select class="sub" style="display: none;">
                            <option>请选择城市</option>
                            <option value="1237">合肥市</option>
                            <option value="1248">芜湖市</option>
                            <option value="1258">蚌埠市</option>
                            <option value="1267">淮南市</option>
                            <option value="1275">马鞍山市</option>
                            <option value="1283">淮北市</option>
                            <option value="1289">铜陵市</option>
                            <option value="1295">安庆市</option>
                            <option value="1308">黄山市</option>
                            <option value="1317">滁州市</option>
                            <option value="1327">阜阳市</option>
                            <option value="1337">宿州市</option>
                            <option value="1344">六安市</option>
                            <option value="1353">亳州市</option>
                            <option value="1359">池州市</option>
                            <option value="1365">宣城市</option>
                        </select>
                        <select class="sub" style="display: none;">
                            <option>请选择城市</option>
                            <option value="1620">南昌市</option>
                            <option value="1631">景德镇市</option>
                            <option value="1637">萍乡市</option>
                            <option value="1644">九江市</option>
                            <option value="1659">新余市</option>
                            <option value="1663">鹰潭市</option>
                            <option value="1668">赣州市</option>
                            <option value="1688">吉安市</option>
                            <option value="1703">宜春市</option>
                            <option value="1715">抚州市</option>
                            <option value="1728">上饶市</option>
                        </select>
                        <select class="sub" style="display: none;">
                            <option>请选择城市</option>
                            <option value="1743">济南市</option>
                            <option value="1755">青岛市</option>
                            <option value="1769">淄博市</option>
                            <option value="1779">枣庄市</option>
                            <option value="1787">东营市</option>
                            <option value="1794">烟台市</option>
                            <option value="1808">潍坊市</option>
                            <option value="1822">济宁市</option>
                            <option value="1836">泰安市</option>
                            <option value="1844">威海市</option>
                            <option value="1850">日照市</option>
                            <option value="1856">莱芜市</option>
                            <option value="1860">临沂市</option>
                            <option value="1874">德州市</option>
                            <option value="1887">聊城市</option>
                            <option value="1897">滨州市</option>
                            <option value="1906">菏泽市</option>
                        </select>
                        <select class="sub" style="display: none;">
                            <option>请选择城市</option>
                            <option value="1918">郑州市</option>
                            <option value="1932">开封市</option>
                            <option value="1944">洛阳市</option>
                            <option value="1961">平顶山市</option>
                            <option value="1973">安阳市</option>
                            <option value="1984">鹤壁市</option>
                            <option value="1991">新乡市</option>
                            <option value="2005">焦作市</option>
                            <option value="2017">濮阳市</option>
                            <option value="2025">许昌市</option>
                            <option value="2033">漯河市</option>
                            <option value="2040">三门峡市</option>
                            <option value="2048">南阳市</option>
                            <option value="2063">商丘市</option>
                            <option value="2074">信阳市</option>
                            <option value="2086">周口市</option>
                            <option value="2098">驻马店市</option>
                            <option value="2110">省直辖县级行政区划</option>
                        </select>
                        <select class="sub" style="display: none;">
                            <option>请选择城市</option>
                            <option value="2113">武汉市</option>
                            <option value="2128">黄石市</option>
                            <option value="2136">十堰市</option>
                            <option value="2146">宜昌市</option>
                            <option value="2161">襄阳市</option>
                            <option value="2172">鄂州市</option>
                            <option value="2177">荆门市</option>
                            <option value="2184">孝感市</option>
                            <option value="2193">荆州市</option>
                            <option value="2203">黄冈市</option>
                            <option value="2215">咸宁市</option>
                            <option value="2223">随州市</option>
                            <option value="2228">恩施土家族苗族自治州</option>
                            <option value="2237">省直辖县级行政区划</option>
                        </select>
                        <select class="sub" style="display: none;">
                            <option>请选择城市</option>
                            <option value="2243">长沙市</option>
                            <option value="2254">株洲市</option>
                            <option value="2265">湘潭市</option>
                            <option value="2272">衡阳市</option>
                            <option value="2286">邵阳市</option>
                            <option value="2300">岳阳市</option>
                            <option value="2311">常德市</option>
                            <option value="2322">张家界市</option>
                            <option value="2328">益阳市</option>
                            <option value="2336">郴州市</option>
                            <option value="2349">永州市</option>
                            <option value="2362">怀化市</option>
                            <option value="2376">娄底市</option>
                            <option value="2383">湘西土家族苗族自治州</option>
                        </select>
                        <select class="sub" style="display: none;">
                            <option>请选择城市</option>
                            <option value="2393">广州市</option>
                            <option value="2407">韶关市</option>
                            <option value="2419">深圳市</option>
                            <option value="2427">珠海市</option>
                            <option value="2432">汕头市</option>
                            <option value="2441">佛山市</option>
                            <option value="2448">江门市</option>
                            <option value="2457">湛江市</option>
                            <option value="2468">茂名市</option>
                            <option value="2476">肇庆市</option>
                            <option value="2486">惠州市</option>
                            <option value="2493">梅州市</option>
                            <option value="2503">汕尾市</option>
                            <option value="2509">河源市</option>
                            <option value="2517">阳江市</option>
                            <option value="2523">清远市</option>
                            <option value="2533">东莞市</option>
                            <option value="2534">中山市</option>
                            <option value="2535">潮州市</option>
                            <option value="2540">揭阳市</option>
                            <option value="2547">云浮市</option>
                        </select>
                        <select class="sub" style="display: none;">
                            <option>请选择城市</option>
                            <option value="2555">南宁市</option>
                            <option value="2569">柳州市</option>
                            <option value="2581">桂林市</option>
                            <option value="2600">梧州市</option>
                            <option value="2609">北海市</option>
                            <option value="2615">防城港市</option>
                            <option value="2621">钦州市</option>
                            <option value="2627">贵港市</option>
                            <option value="2634">玉林市</option>
                            <option value="2642">百色市</option>
                            <option value="2656">贺州市</option>
                            <option value="2662">河池市</option>
                            <option value="2675">来宾市</option>
                            <option value="2683">崇左市</option>
                        </select>
                        <select class="sub" style="display: none;">
                            <option>请选择城市</option>
                            <option value="2693">海口市</option>
                            <option value="2699">三亚市</option>
                            <option value="2701">省直辖县级行政区划</option>
                        </select>
                        <select class="sub" style="display: none;">
                            <option>请选择城市</option>
                            <option value="2722">重庆市</option>
                            <option value="2742">县</option>
                        </select>
                        <select class="sub" style="display: none;">
                            <option>请选择城市</option>
                            <option value="2763">成都市</option>
                            <option value="2784">自贡市</option>
                            <option value="2792">攀枝花市</option>
                            <option value="2799">泸州市</option>
                            <option value="2808">德阳市</option>
                            <option value="2816">绵阳市</option>
                            <option value="2827">广元市</option>
                            <option value="2836">遂宁市</option>
                            <option value="2843">内江市</option>
                            <option value="2850">乐山市</option>
                            <option value="2863">南充市</option>
                            <option value="2874">眉山市</option>
                            <option value="2882">宜宾市</option>
                            <option value="2894">广安市</option>
                            <option value="2901">达州市</option>
                            <option value="2910">雅安市</option>
                            <option value="2920">巴中市</option>
                            <option value="2926">资阳市</option>
                            <option value="2932">阿坝藏族羌族自治州</option>
                            <option value="2946">甘孜藏族自治州</option>
                            <option value="2965">凉山彝族自治州</option>
                        </select>
                        <select class="sub" style="display: none;">
                            <option>请选择城市</option>
                            <option value="2984">贵阳市</option>
                            <option value="2996">六盘水市</option>
                            <option value="3001">遵义市</option>
                            <option value="3017">安顺市</option>
                            <option value="3025">毕节市</option>
                            <option value="3035">铜仁市</option>
                            <option value="3047">黔西南布依族苗族自治州</option>
                            <option value="3056">黔东南苗族侗族自治州</option>
                            <option value="3073">黔南布依族苗族自治州</option>
                        </select>
                        <select class="sub" style="display: none;">
                            <option>请选择城市</option>
                            <option value="3087">昆明市</option>
                            <option value="3103">曲靖市</option>
                            <option value="3114">玉溪市</option>
                            <option value="3125">保山市</option>
                            <option value="3132">昭通市</option>
                            <option value="3145">丽江市</option>
                            <option value="3152">普洱市</option>
                            <option value="3164">临沧市</option>
                            <option value="3174">楚雄彝族自治州</option>
                            <option value="3185">红河哈尼族彝族自治州</option>
                            <option value="3199">文山壮族苗族自治州</option>
                            <option value="3208">西双版纳傣族自治州</option>
                            <option value="3212">大理白族自治州</option>
                            <option value="3225">德宏傣族景颇族自治州</option>
                            <option value="3231">怒江傈僳族自治州</option>
                            <option value="3236">迪庆藏族自治州</option>
                        </select>
                        <select class="sub" style="display: none;">
                            <option>请选择城市</option>
                            <option value="3241">拉萨市</option>
                            <option value="3251">昌都地区</option>
                            <option value="3263">山南地区</option>
                            <option value="3276">日喀则地区</option>
                            <option value="3295">那曲地区</option>
                            <option value="3306">阿里地区</option>
                            <option value="3314">林芝地区</option>
                        </select>
                        <select class="sub" style="display: none;">
                            <option>请选择城市</option>
                            <option value="3323">西安市</option>
                            <option value="3338">铜川市</option>
                            <option value="3344">宝鸡市</option>
                            <option value="3358">咸阳市</option>
                            <option value="3374">渭南市</option>
                            <option value="3387">延安市</option>
                            <option value="3402">汉中市</option>
                            <option value="3415">榆林市</option>
                            <option value="3429">安康市</option>
                            <option value="3441">商洛市</option>
                        </select>
                        <select class="sub" style="display: none;">
                            <option>请选择城市</option>
                            <option value="3451">兰州市</option>
                            <option value="3461">嘉峪关市</option>
                            <option value="3463">金昌市</option>
                            <option value="3467">白银市</option>
                            <option value="3474">天水市</option>
                            <option value="3483">武威市</option>
                            <option value="3489">张掖市</option>
                            <option value="3497">平凉市</option>
                            <option value="3506">酒泉市</option>
                            <option value="3515">庆阳市</option>
                            <option value="3525">定西市</option>
                            <option value="3534">陇南市</option>
                            <option value="3545">临夏回族自治州</option>
                            <option value="3554">甘南藏族自治州</option>
                        </select>
                        <select class="sub" style="display: none;">
                            <option>请选择城市</option>
                            <option value="3564">西宁市</option>
                            <option value="3573">海东地区</option>
                            <option value="3580">海北藏族自治州</option>
                            <option value="3585">黄南藏族自治州</option>
                            <option value="3590">海南藏族自治州</option>
                            <option value="3596">果洛藏族自治州</option>
                            <option value="3603">玉树藏族自治州</option>
                            <option value="3610">海西蒙古族藏族自治州</option>
                        </select>
                        <select class="sub" style="display: none;">
                            <option>请选择城市</option>
                            <option value="3617">银川市</option>
                            <option value="3625">石嘴山市</option>
                            <option value="3630">吴忠市</option>
                            <option value="3637">固原市</option>
                            <option value="3644">中卫市</option>
                        </select>
                        <select class="sub" style="display: none;">
                            <option>请选择城市</option>
                            <option value="3650">乌鲁木齐市</option>
                            <option value="3660">克拉玛依市</option>
                            <option value="3666">吐鲁番地区</option>
                            <option value="3670">哈密地区</option>
                            <option value="3674">昌吉回族自治州</option>
                            <option value="3682">博尔塔拉蒙古自治州</option>
                            <option value="3686">巴音郭楞蒙古自治州</option>
                            <option value="3696">阿克苏地区</option>
                            <option value="3706">克孜勒苏柯尔克孜自治州</option>
                            <option value="3711">喀什地区</option>
                            <option value="3724">和田地区</option>
                            <option value="3733">伊犁哈萨克自治州</option>
                            <option value="3744">塔城地区</option>
                            <option value="3752">阿勒泰地区</option>
                            <option value="3760">自治区直辖县级行政区划</option>
                            <option value="3863">内江市</option>
                            <option value="3864">内江</option>
                        </select>
                        <input name="classId" type="hidden" value="146">
                    </div>
                </div>
                <div class="cal_pop_input_col clear">
                    <div class="cal_pop_input_col_text">
                        <span>房屋面积：</span>
                        <img src="./suanpage/cal_star.png">
                    </div>
                    <div class="cal_pop_input_col_ri">
                        <input type="number" name="houseArea" id="housearea" placeholder="请输入您的房屋面积">
                    </div>
                </div>
                <div class="cal_pop_input_col clear">
                    <div class="cal_pop_input_col_text">
                        <span>房屋户型：</span>
                        <img src="./suanpage/cal_star.png">
                    </div>
                    <div class="cal_pop_input_col_ri">
                        <select class="spe" id="shiselect">
                            <option value="1">1室</option>
                            <option value="2">2室</option>
                            <option value="3">3室</option>
                            <option value="4">4室</option>
                            <option value="5">5室</option>
                            <option value="6">6室</option>
                        </select>
                        <select class="spe" id="tingselect">
                            <option value="1">1厅</option>
                            <option value="2">2厅</option>
                        </select>
                        <select class="spe" id="chuselect">
                            <option value="1">1厨</option>
                            <option value="2">2厨</option>
                        </select>
                        <select id="weiselect">
                            <option value="1">1卫</option>
                            <option value="2">2卫</option>
                            <option value="3">3卫</option>
                            <option value="4">4卫</option>
                        </select>
                        <select id="ytselect">
                            <option value="1">1阳台</option>
                            <option value="2">2阳台</option>
                            <option value="3">3阳台</option>
                            <option value="4">4阳台</option>
                        </select>
                    </div>
                </div>
                <div class="cal_pop_input_col clear">
                    <div class="cal_pop_input_col_text">
                        <span>手机号码：</span>
                        <img src="./suanpage/cal_star.png">
                    </div>
                    <div class="cal_pop_input_col_ri">
                        <input type="text" name="mobile" id="phone1" placeholder="报价结果将发送到您的手机">
                    </div>
                </div>
                <div class="cal_pop_input_col clear">
                    <div class="cal_pop_input_col_text">
                        <span>您的姓名：</span>
                        <img src="./suanpage/cal_star.png">
                    </div>
                    <div class="cal_pop_input_col_ri">
                        <input type="text" name="applyUser" id="name1" placeholder="如何称呼您">

                    </div>

                </div>
                <div class="cal_pop_input_col clear" style="line-height: 1.5rem;">温馨提示：您的信息将被严格保密！稍后客服人员将以客服总机0592电话与您取得联系，请保持电话畅通</div>
            </form>

            <div class="cal_pop_btn">
                <div class="cal_pop_btn_span" id="submit" onclick="FreeApply()">
                </div>
                <div class="cal_pop_btn_div">
                    <div class="cal_pop_btn_line_01"></div>
                </div>
            </div>

            <div class="cal_pop_mid ">
                <p class="cal_title">您的装修预算<span class="totle" id="ysfree">*</span>元</p>
                <div class="cal_pop_mid_div">
                    <section>
                        <span class="cal_pop_mid_span">材料费</span>
                        <span id="clfree">*</span>
                        <span>元</span>
                    </section>
                    <section>
                        <span class="cal_pop_mid_span">设计费</span>
                        <span id="sjfree">*</span>
                        <span>元</span>
                    </section>
                    <section>
                        <span class="cal_pop_mid_span">人工费</span>
                        <span id="rgfree">*</span>
                        <span>元</span>
                    </section>
                    <section>
                        <span class="cal_pop_mid_span">质检费</span>
                        <span id="zjfree">*</span>
                        <span>元</span>
                    </section>
                </div>
                <div class="tip">装修预算数据由保驾护航历史服务<span>1000万</span>业主装修数据、各大城市装修公司合同数据经过大数据实时分析计算。</div>
            </div>
        </div>

    </div>
</div>
<!-- 底部结束 -->
<?php echo '<script'; ?>
 type="text/javascript">
    var index01;
    $('.nav-col').hover(function () {
        index01 = $(this).index()
        $(this).addClass('active01')
        $('.nav-cont-div-zt').hide()
        $('.nav-cont-zt').children().eq(index01).toggle()
    }, function () {
        $(this).removeClass('active01')
    })
    $('.nav-cont-zt').mouseleave(function () {
        $('.nav-cont-zt').children().stop().hide('fast')
    })

    var arr = [135988, 86057, 116892, 98415, 214585, 158428, 85792, 115452, 98488, 158263, 175742, 102515, 258648, 302142]
    var clearTime = 0,
        i = 0,
        length = arr.length;

    function random() {
        if(i >= length) {
            i = 0;
        }
        $('#clfree').text(parseInt(arr[i]*0.65))
        $('#sjfree').text(parseInt(arr[i]*0.1))
        $('#rgfree').text(parseInt(arr[i]*0.13))
        $('#zjfree').text(parseInt(arr[i]*0.12))
        $('#ysfree').text(arr[i])
        i++;
    }
    clearTime = setInterval(random, 200)


<?php echo '</script'; ?>
>

</body></html><?php }
}
