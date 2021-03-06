<?php
/* Smarty version 3.1.34-dev-7, created on 2020-11-14 16:25:55
  from '/Volumes/51/idiQu/public/page/templates/mobilepage.htm' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5faf9493689ce4_23099594',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '12acfec07d2c2354329e429c6f52c480f5858aa5' => 
    array (
      0 => '/Volumes/51/idiQu/public/page/templates/mobilepage.htm',
      1 => 1605342353,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5faf9493689ce4_23099594 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta  name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="referrer" content="no-referrer|no-referrer-when-downgrade|origin|origin-when-crossorigin|unsafe-url"/>
    <title>落地页</title>
    <meta http-equiv="cache-control" content="private/must- revalidate" />
    <link href="./mobile_page/swiper-4.1.6.min.css" rel="stylesheet" />
    <link href="./mobile_page/m_style.css" rel="stylesheet" />
    <?php echo '<script'; ?>
 src="./mobile_page/jquery-2.0.0.min.js"><?php echo '</script'; ?>
>
    <link rel="stylesheet" type="text/css" href="https://www.layuicdn.com/layui/css/layui.css"/>
    <?php echo '<script'; ?>
 src="http://zhuangxiu.qilaixiu.com/Theme/t24/pc/Static/js/layer/layer.js"><?php echo '</script'; ?>
>
</head>
<body style="">
<?php echo '<script'; ?>
>
    // 控制跟字体
    var oHtml = document.documentElement;
    getSize();
    function getSize() {
        var screenWidth = oHtml.clientWidth;
        if (screenWidth >= 750) {
            oHtml.style.fontSize = "40px";
        } else if (screenWidth <= 320) {
            oHtml.style.fontSize = "18px";
        } else {
            oHtml.style.fontSize = screenWidth / (700 / 40) + "px";
        }
    }
    window.onresize = function () {
        getSize();
    };

    $(function(){
    $('#onecall').click(function() {
        name1 = $("#name1").val(); //名称
        tel1 = $("#tel1").val(); //电话
        console.log(tel1);
        size1 = $("#size1").val(); //小区
        content = size1;
        console.log(content);
        if (name1 == "请输入您的称呼" && !name1) {
            alert("请输入您的姓名！");
            return false
        }
        if (!tel1 || !tel1.match(/^[0-9,-]{7,13}$/)) {
            alert('请填写您的手机号!');

            return false;
        }
        var actionUrl = "/messages/addno.html";
        $.post(actionUrl, {
                name: name1,
                phone: tel1,
                content: content
            },
            function(data, status) {
                if (data.status) {
                    layer.msg(data.info);
                } else {
                    layer.msg(data.info);
                }
                // if (data.url) {
                // 	location.href=data.url;
                // }
            });

    });

    $('#twocall').click(function() {
        name2 = $("#name2").val(); //名称
        tel2 = $("#tel2").val(); //电话
        lou2 = $("#lou2").val(); //小区
        size2 = $("#size2").val(); //小区
        content = lou2 + size2;
        if (name2 == "请输入您的称呼" && !name2) {
            alert("请输入您的姓名！");
            name2.focus();
            return false
        }
        if (!tel2 || !tel2.match(/^[0-9,-]{7,13}$/)) {
            alert('请填写您的手机号!');
            tel2.focus();
            return false;
        }
        var actionUrl = "/messages/addno.html";
        $.post(actionUrl, {
                name: name2,
                phone: tel2,
                content: content
            },
            function(data, status) {
                if (data.status) {
                    layer.msg(data.info);
                } else {
                    layer.msg(data.info);
                }
                // if (data.url) {
                // 	location.href=data.url;
                // }
            });

    });
    })

<?php echo '</script'; ?>
>

<header class="top container">
    <h1 class="logo">
        <a href=""><img src="./mobile_page/logo.png"/></a>
    </h1>
    <div class="years"></div>
    <em class="city"> </em>
    <div class="tel-phone">
        <a href="tel:15960287938">
            <i></i>
            <div class="phone">
                <span>免费咨询电话</span>
                <p>15960287938</p>
            </div>
        </a>
    </div>
</header>
<hr class="top80" />
<div class="brand-banner">
    <img src="./mobile_page/banner.png" alt="" width="100%" />
</div>
<div class="brand-advantage">
    <div>
        <span>10+</span>
        <p>10年老品牌</p>
    </div>
    <div>
        <span>3<em>万</em>+</span>
        <p>业主口碑认证</p>
    </div>
    <div>
        <span>5+</span>
        <p>直营分公司</p>
    </div>
    <div>
        <span>0+</span>
        <p>0增项漏项</p>
    </div>
</div>
<hr class="interval20" />
<!-- 获取报价 start -->
<div class="offer-wrap">
    <h2>算算我家装修需要多少钱</h2>
    <p>已有<span>15460</span>人获取报价</p>
    <div class="offer index" id="baojia">
        <form>
            <div class="form-item">
                <input
                        class="input-style jz-user-name" id="name1"
                        placeholder="您的称呼"
                />
                <em>请填写您的称呼</em>
            </div>
            <div class="form-item">
                <input
                        class="input-style jz-user-area"
                        type="text"
                        placeholder="您的房屋面积" id="size1"
                />
                <em>请填写您的房屋面积</em>
            </div>
            <div class="form-item">
                <input
                        class="input-style jz-user-phone"
                        type="text"
                        placeholder="您接收报价的手机号" id="tel1"
                />
                <em>请输入正确的手机号</em>
            </div>
            <div class="form-item">
                <input type="button" class="button-style getPrice" id="onecall" value="立即获取报价">

            </div>
            <div class="tips">
                <i>!</i>
                <span>为了您的利益以及我们的口碑，您的隐私将被严格保密！</span>
            </div>
        </form>
    </div>
</div>
<!-- 获取报价 end -->
<hr class="interval20" />
<div class="good-materials">
    <h2 class="Title_name">优质环保材料</h2>
    <p>精选全球50余家优质材料商战略合作</p>
    <p>保障您舒适环保无污染的家居环境</p>
    <div>
        <img src="./mobile_page/img_material_logo.png" alt="" width="100%" />
    </div>
</div>
<hr class="interval20" />
<!-- 获取报价 start -->
<div class="offer-wrap">
    <div
            class="in_back"
            style="
          background: #ce3434;
          color: #fff;
          border-radius: 17px;
          margin: 0 9px;
        "
    >
        <h2 style="padding-top: 16px;">免费报名上门量房设计</h2>
        <div class="offer"  id="baojia" style="padding: 0.8rem 0.65rem; border-radius: 17px;">
            <form>
                <div class="form-item">
                    <input class="input-style jz-user-name" type="text" id = "name2" placeholder="您的称呼" />
                    <em>请填写您的称呼</em>
                </div>
                <div class="form-item">
                    <input class="input-style jz-user-phone" type="text" id="tel2"  placeholder="您接收报价的手机号" />
                    <em>请输入正确的手机号</em>
                </div>
                <div class="form-item">
                    <input class="input-style jz-user-area"  id="lou2" type="text" placeholder="您的小区名称" />
                    <em>请填写您的小区名称</em>
                </div>
                <div class="form-item">
                    <input class="input-style jz-user-area"  id="size2" type="text"  placeholder="您的房屋面积" />
                    <em>请填写您的房屋面积</em>
                </div>
                <div class="form-item">
                    <button
                            type="button"
                            class="getPrice"
                            onclick="getHousePrice(this.parentNode)"
                            style="
                  display: block;
                  margin: 0.5rem auto;
                  padding: 0.5rem 0.8rem;
                  background: #43cabc;
                  border-radius: 0.6rem;
                  line-height: 1rem;
                  border: none;
                  color: #fff;
                  font-size: 0.7rem;
                "
                            id="twocall"
                    >
                        立即获取报价
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- 获取报价 end -->
<!-- 对比 start -->
<div class="industry-effect">
    <h2 class="Title_name">
        <img src="./mobile_page/biaoti.png" style="width: 69%;" />
    </h2>

    <style>
        .pk{
            margin:10px;
            height:230px;
            border-bottom: 1px solid #e6e3e4;
            padding:0 10px;

        }
        .pk h5{
            font-weight:bold;
        }
        .pk  .wj{
            width:55%;
            font-size:0.9em;
            border-bottom:1px #C60F11 solid;
        }
        .pk  .other{
            width:55%;
            font-size:0.9em;
            border-bottom:1px #333333 solid;
        }
        .pk .desc{
            width:50%;
            float:left;
            margin-top:0.3em;
        }
        .pk .desccontent{
            color:#666666;
            font-size:0.3em;
            width: 91%;
        }
        .pk_three{
            float:left;
            width:40%;
        }
        .pk_cen{
            float:left;
            width:20%;
        }
        .lr img{
            width:100%;
        }
        .pk_title_img img{
            width:78%;
        }
        .pkimg{
            display:block;
            width:90%;
            margin:auto;
            margin-top: 24px;
        }

    </style>

    <div class="pk">
        <div class="pk_title_img">
            <img src="./mobile_page/01.png">
        </div>
        <div>
            <div class="pk_three lr">
            <img src="./mobile_page/tu1.png">
            </div>
            <div class="pk_cen">
                <img src="./mobile_page/pk.png" class="pkimg">
            </div>
            <div class="pk_three lr">
            <img src="./mobile_page/tu1_1.png">
            </div>
        </div>
        <div style="width:100%;">
            <div class="desc">
                <h5 class="wj">
                    尚万家装饰
                </h5>
                <p class="desccontent">
                    尚万家水电工艺，让危险消融 于身边，还您一个恬谧的家！
                </p>
            </div>
            <div class="desc">
                <h5 class="other">
                    其他装修公司
                </h5>
                <p class="desccontent">
                    水管漏水、电器短路、安全 事故…
                </p>
            </div>
        </div>
    </div>







    <div class="pk">
        <div class="pk_title_img">
            <img src="./mobile_page/02.png">
        </div>
        <div>
            <div class="pk_three lr">
                <img src="./mobile_page/tu2.png">
            </div>
            <div class="pk_cen">
                <img src="./mobile_page/pk.png" class="pkimg">
            </div>
            <div class="pk_three lr">
                <img src="./mobile_page/tu2_1.png">
            </div>
        </div>
        <div style="width:100%;">
            <div class="desc">
                <h5 class="wj">
                    尚万家装饰
                </h5>
                <p class="desccontent">
                    尚万家木工工艺，苛求每一处木
                    制细节，提升家居环境精致感！
                </p>
            </div>
            <div class="desc">
                <h5 class="other">
                    其他装修公司
                </h5>
                <p class="desccontent">
                    饰面损坏、开胶鼓包、木门变形…
                </p>
            </div>
        </div>
    </div>





    <div class="pk">
        <div class="pk_title_img">
            <img src="./mobile_page/03.png">
        </div>
        <div>
            <div class="pk_three lr">
                <img src="./mobile_page/tu3.png">
            </div>
            <div class="pk_cen">
                <img src="./mobile_page/pk.png" class="pkimg">
            </div>
            <div class="pk_three lr">
                <img src="./mobile_page/tu3_1.png">
            </div>
        </div>
        <div style="width:100%;">
            <div class="desc">
                <h5 class="wj">
                    尚万家装饰
                </h5>
                <p class="desccontent">
                    尚万家瓦工工艺，既要刀枪不入 的坚固，亦要丝丝入扣的合拍！
                </p>
            </div>
            <div class="desc">
                <h5 class="other">
                    其他装修公司
                </h5>
                <p class="desccontent">
                    墙面起鼓、裂缝，砂浆脱水、 瓷砖厚薄不均…
                </p>
            </div>
        </div>
    </div>
    <div class="pk" style="border:0px;">
        <div class="pk_title_img">
            <img src="./mobile_page/04.png">
        </div>
        <div>
            <div class="pk_three lr">
                <img src="./mobile_page/tu4.png">
            </div>
            <div class="pk_cen">
                <img src="./mobile_page/pk.png" class="pkimg">
            </div>
            <div class="pk_three lr">
                <img src="./mobile_page/tu4_1.png">
            </div>
        </div>
        <div style="width:100%;">
            <div class="desc">
                <h5 class="wj">
                    尚万家装饰
                </h5>
                <p class="desccontent">
                    尚万家油工工艺，不仅让家有模 有样，更要让家大放光彩！
                </p>
            </div>
            <div class="desc">
                <h5 class="other">
                    其他装修公司
                </h5>
                <p class="desccontent">
                    其他装修公司偷工减料、墙 面起泡开裂、手感不顺滑、 墙纸扯裂…
                </p>
            </div>
        </div>
    </div>
    <button type="button" class="getPrice" onclick="getHousePrice(this.parentNode)" style="
                  display: block;
                  margin: 0.5rem auto;
                  padding: 0.5rem 3rem;
                  background: #CE3434;
                  border-radius: 0.2rem;
                  line-height: 1rem;
                  border: none;
                  color: #fff;
                  font-size: 0.7rem;
                ">
        点击咨询专业家装顾问
    </button>
</div>
<style>
    .industry-effect ul li{
        background: #ececec;
        /* margin: 10px; */
        /*height:143px;*/
        height: 88px;
        overflow: hidden;
    }
    .industry-effect ul li  p{
        color:#999999;
        font-size:0.4em;
        line-height:20px;
    }
    .industry-effect ul li h5{
        font-size:0.9em;
        font-weight:bold;
    }
    .industry-effect ul li desc{
        font-size:0.5em;
    }
    .industry-effect ul li.img{
       border:1px #c3c4c4 dashed;
    }
    .industry-effect ul li img{
        height:100% !important;
    }
    .industry-effect desc{
        padding:8px;
    }
    .industry-effect .good-materials p{
        font-size:0.4em;
    }
</style>


<div class="industry-effect" style="background: #fff;padding-bottom:0px;">
    <div class="good-materials" style="padding-top:0px;padding-bottom:1.0em;">
        <h2 class="Title_name">
            精于心
            <span
                    style="
              display: inline-block;
              background: #ce3434;
              color: #fff;
              padding: 0 2px;
              border-radius: 5px;
            "
            >践于行</span
            >
        </h2>
        <p>尚万家严苛落实“健康、品质、服务、效率”</p>
        <p>四大保障，表里如一的匠心工程才能配得上您的好房子。</p>
    </div>
    <div class="desc">
        <img src="./mobile_page/changtu.png" style="width: 100%;padding:10px;">
    </div>
</div>
<!-------------------- footer end -------------------->
</body>
</html>
<?php }
}
