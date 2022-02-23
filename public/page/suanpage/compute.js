//一线城市
var cityIdF = [114, 973, 2419, 2393];
//二线城市
var cityIdS = [2763, 2722, 1124, 993, 612, 1039, 612, 152, 2533, 133, 2113, 3323, 2243, 627, 1743, 741, 1039, 1794, 1139, 1755, 1008, 11, 1918, 819, 10, 2441, 1237, 1620, 2555, 3087, 1152, 1769, 177, 347];
//三线城市
//var cityIdT = [114, 973, 2419, 2393];

$(function () {
    $(".selectBox ul ul li").on("click", function () {
        var txt = $(this).text();
        $(this).parent().parent("li").find("span").text(txt);
        $("#cityId").val("");
    });
    $(".selectBox ul.city ul li").on("click", function () {
        var txt = $(this).text();
        var cityId = $(this).val();
        $(this).parent().parent().parent("li").find("span").text(txt);
        $("#cityId").val(cityId);
    });
    $(".selectBox ul").click(function () {
        $(this).find("ul").show();
    });
    $(".provinceList,.cityList").on("click", function () {
        $(this).hide();
    });

    $(".selectBox ul.sheng li").on("click", function () {
        $(".cityName").text("市");
    });
    $(".cityList").find("div").hide();
    $(".provinceList li").on("click", function () {
        $(".cityList").find("div").hide();
    });
    $(".selectBox ul.sheng li[name='安徽省']").on("click", function () {
        $(".cityList").find("div[name='安徽省']").show();
    });
    $("li[name='北京市']").on("click", function () {
        $(".cityList").find("div[name='北京市']").show();
    });
    $("li[name='重庆市']").on("click", function () {
        $(".cityList").find("div[name='重庆市']").show();
    });
    $("li[name='福建省']").on("click", function () {
        $(".cityList").find("div[name='福建省']").show();
    });
    $("li[name='广东省']").on("click", function () {
        $(".cityList").find("div[name='广东省']").show();
    });
    $("li[name='广西壮族自治区']").on("click", function () {
        $(".cityList").find("div[name='广西壮族自治区']").show();
    });
    $("li[name='贵州省']").on("click", function () {
        $(".cityList").find("div[name='贵州省']").show();
    });
    $("li[name='甘肃省']").on("click", function () {
        $(".cityList").find("div[name='甘肃省']").show();
    });
    $("li[name='海南省']").on("click", function () {
        $(".cityList").find("div[name='海南省']").show();
    });
    $("li[name='河北省']").on("click", function () {
        $(".cityList").find("div[name='河北省']").show();
    });
    $("li[name='河南省']").on("click", function () {
        $(".cityList").find("div[name='河南省']").show();
    });
    $("li[name='湖北省']").on("click", function () {
        $(".cityList").find("div[name='湖北省']").show();
    });
    $("li[name='湖南省']").on("click", function () {
        $(".cityList").find("div[name='湖南省']").show();
    });
    $("li[name='黑龙江省']").on("click", function () {
        $(".cityList").find("div[name='黑龙江省']").show();
    });
    $("li[name='江苏省']").on("click", function () {
        $(".cityList").find("div[name='江苏省']").show();
    });
    $("li[name='江西省']").on("click", function () {
        $(".cityList").find("div[name='江西省']").show();
    });
    $("li[name='吉林省']").on("click", function () {
        $(".cityList").find("div[name='吉林省']").show();
    });
    $("li[name='辽宁省']").on("click", function () {
        $(".cityList").find("div[name='辽宁省']").show();
    });
    $("li[name='内蒙古自治区']").on("click", function () {
        $(".cityList").find("div[name='内蒙古自治区']").show();
    });
    $("li[name='宁夏回族自治区']").on("click", function () {
        $(".cityList").find("div[name='宁夏回族自治区']").show();
    });
    $("li[name='青海省']").on("click", function () {
        $(".cityList").find("div[name='青海省']").show();
    });
    $("li[name='四川省']").on("click", function () {
        $(".cityList").find("div[name='四川省']").show();
    });
    $("li[name='陕西省']").on("click", function () {
        $(".cityList").find("div[name='陕西省']").show();
    });
    $("li[name='山西省']").on("click", function () {
        $(".cityList").find("div[name='山西省']").show();
    });
    $("li[name='山东省']").on("click", function () {
        $(".cityList").find("div[name='山东省']").show();
    });
    $("li[name='上海市']").on("click", function () {
        $(".cityList").find("div[name='上海市']").show();
    });
    $("li[name='天津市']").on("click", function () {
        $(".cityList").find("div[name='天津市']").show();
    });
    $("li[name='西藏自治区']").on("click", function () {
        $(".cityList").find("div[name='西藏自治区']").show();
    });
    $("li[name='新疆维吾尔自治区']").on("click", function () {
        $(".cityList").find("div[name='新疆维吾尔自治区']").show();
    });
    $("li[name='云南省']").on("click", function () {
        $(".cityList").find("div[name='云南省']").show();
    });
    $("li[name='浙江省']").on("click", function () {
        $(".cityList").find("div[name='浙江省']").show();
    });
});

//计算费用
function yusuanfree() {
    //材料费
    var clfree = 0;
    //人工费
    var rgfree = 0;
    //设计费
    var sjfree = 0;
    //质检费
    var zjfree = 3500;
    //装修预算约
    var zxfree = 0;

    var jcclfree = 200;
    var jcrgfree = 0;
    var jcsjfree = 0;

    var cityid = $("#cityId").val();
    var housearea = $("#housearea").val();
    if (housearea == "" || housearea == undefined || housearea == "undefined") {
        housearea = $("#housecitystrcity").val();
    }
    var area = parseFloat(housearea);

    var shi = $("#shiselect option:selected").val();
    var chu = $("#chuselect option:selected").val();
    var wei = $("#weiselect option:selected").val();

    if ($.inArray(parseInt(cityid), cityIdF) >= 0) {
        jcrgfree = 250;
        jcsjfree = 100;
    } else if ($.inArray(parseInt(cityid), cityIdS) >= 0) {
        jcrgfree = 240;
        jcsjfree = 80;
    } else {
        jcrgfree = 230;
        jcsjfree = 50;
    }
    clfree = area * jcclfree;
    if (parseInt(shi) > 1) {
        clfree = clfree + (shi - 1) * 2000;
    }
    if (parseInt(chu) > 1) {
        clfree = clfree + (chu - 1) * 2000;
    }
    if (parseInt(wei) > 1) {
        clfree = clfree + (wei - 1) * 2000;
    }
    rgfree = area * jcrgfree;
    sjfree = area * jcsjfree;

    zxfree = clfree + rgfree;

    $("#ysfree").html(zxfree);
    $("#clfree").html(clfree);
    $("#rgfree").html(rgfree);
    $("#sjfree").html(0);
    $("#zjfree").html(0);
    $("#sjfreeb").html(sjfree);
    $("#zjfreeb").html(zjfree);
}

function yusuanfreecity(cityid, housearea, shi, chu, wei) {
    //材料费
    var clfree = 0;
    //人工费
    var rgfree = 0;
    //设计费
    var sjfree = 0;
    //质检费
    var zjfree = 3500;
    //装修预算约
    var zxfree = 0;

    var jcclfree = 200;
    var jcrgfree = 0;
    var jcsjfree = 0;

    var area = parseFloat(housearea);


    if ($.inArray(parseInt(cityid), cityIdF) >= 0) {
        jcrgfree = 250;
        jcsjfree = 100;
    } else if ($.inArray(parseInt(cityid), cityIdS) >= 0) {
        jcrgfree = 240;
        jcsjfree = 80;
    } else {
        jcrgfree = 230;
        jcsjfree = 50;
    }
    clfree = area * jcclfree;
    if (parseInt(shi) > 1) {
        clfree = clfree + (shi - 1) * 2000;
    }
    if (parseInt(chu) > 1) {
        clfree = clfree + (chu - 1) * 2000;
    }
    if (parseInt(wei) > 1) {
        clfree = clfree + (wei - 1) * 2000;
    }
    rgfree = area * jcrgfree;
    sjfree = area * jcsjfree;

    zxfree = clfree + rgfree;

    $("#ysfree").html(zxfree);
    $("#clfree").html(clfree);
    $("#rgfree").html(rgfree);
    $("#sjfree").html(0);
    $("#zjfree").html(0);
    $("#sjfreeb").html(sjfree);
    $("#zjfreeb").html(zjfree);
}

function newyusuanfreecity(housearea, shi, wei, chu, cityid, isSecondHand) {
    //材料费
    var clfree = 0;
    //人工费
    var rgfree = 0;
    //设计费
    var sjfree = 0;
    //质检费
    var zjfree = 3500;
    //装修预算约
    var zxfree = 0;

    if (housearea == "" || housearea == null || housearea == undefined) {
        alert("房屋面积不能为空！");
        return;
    }
    if (shi == "" || shi == null || shi == undefined) {
        alert("房间数量不能为空！");
        return;
    }
    if (wei == "" || wei == null || wei == undefined) {
        alert("卫生间数量不能为空！");
        return;
    }
    if (chu == "" || chu == null || chu == undefined) {
        alert("厨房数量不能为空！");
        return;
    }
    if (cityid == "" || cityid == null || cityid == undefined) {
        alert("城市不能为空！");
        return;
    }

    data = {
        "area": housearea,  // 面积
        "rooms": shi,       // 室
        "kitchens": chu,    // 厨
        "bathrooms": wei,   // 卫
        "cityId": cityid,   // 城市id
        "isSecondHand": isSecondHand  // 是否二手房
    };

    $.ajax({
        url: 'https://m.bao315.com/jsonp/getDecorationBudgetJsonp.jhtml', //提交给哪个执行
        data: data,
        type: "post",
        dataType: "jsonp",
        contentType: "application/json",
        success: function (data) {
            if (data.errcode == 0) {
                var resutlt = data.result;
                zxfree = resutlt.ysfree;  // 装修预算
                sjfree = resutlt.sjfree;  // 材料费
                zjfree = resutlt.zjfree;  // 质检费
                clfree = resutlt.clfree;  // 材料费
                rgfree = resutlt.rgfree;  // 材料费

                $("#ysfree").html(zxfree);
                $("#clfree").html(clfree);
                $("#rgfree").html(rgfree);
                $("#sjfree").html(0);
                $("#zjfree").html(0);
                $("#sjfreeb").html($.cookie('sjfreeb'));
                $("#zjfreeb").html($.cookie('zjfreeb'));

                $.cookie('ysfree', zxfree);
                $.cookie('clfree', clfree);
                $.cookie('rgfree', rgfree);
                $.cookie('sjfreeb', 0);
                $.cookie('zjfreeb', 0);
            }
        },
        error: function (data) {
            alert(data.errmsg);
        }
    });
}

function newyusuanfreecitydetail(housearea, shi, wei, chu, yt, ting, cityid, isSecondHand) {
    //材料费
    var clfree = 0;
    //人工费
    var rgfree = 0;
    //设计费
    var sjfree = 0;
    //质检费
    var zjfree = 3500;
    //装修预算约
    var zxfree = 0;

    if (housearea == "" || housearea == null || housearea == undefined) {
        alert("房屋面积不能为空！");
        return;
    }
    if (shi == "" || shi == null || shi == undefined) {
        alert("房间数量不能为空！");
        return;
    }
    if (ting == "" || ting == null || ting == undefined) {
        alert("客厅数量不能为空！");
        return;
    }
    if (wei == "" || wei == null || wei == undefined) {
        alert("卫生间数量不能为空！");
        return;
    }
    if (chu == "" || chu == null || chu == undefined) {
        alert("厨房数量不能为空！");
        return;
    }
    if (yt == "" || yt == null || yt == undefined) {
        alert("阳台数量不能为空！");
        return;
    }
    if (cityid == "" || cityid == null || cityid == undefined) {
        alert("城市不能为空！");
        return;
    }

    data = {
        "area": housearea,  // 面积
        "rooms": shi,       // 室
        "office": ting,     // 厅
        "kitchens": chu,    // 厨
        "bathrooms": wei,   // 卫
        "balcony": yt,      // 阳台
        "cityId": cityid,   // 城市id
        "isSecondHand": isSecondHand  // 是否二手房
    };

    $.ajax({
        url: 'https://m.bao315.com/jsonp/getDecorationBudgetJsonp.jhtml', //提交给哪个执行
        data: data,
        type: "post",
        dataType: "jsonp",
        contentType: "application/json",
        success: function (data) {
            if (data.errcode == 0) {
                var resutlt = data.result;
                zxfree = resutlt.ysfree;  // 装修预算
                sjfree = resutlt.sjfree;  // 材料费
                zjfree = resutlt.zjfree;  // 质检费
                clfree = resutlt.clfree;  // 材料费
                rgfree = resutlt.rgfree;  // 材料费
                $.cookie('ysfree', zxfree);
                $.cookie('clfree', clfree);
                $.cookie('rgfree', rgfree);
                $.cookie('sjfreeb', 0);
                $.cookie('zjfreeb', 0);
                $("#ysfree").html(zxfree);
                $("#clfree").html(clfree);
                $("#rgfree").html(rgfree);
                $("#sjfree").html(0);
                $("#zjfree").html(0);
                $("#sjfreeb").html($.cookie('sjfreeb'));
                $("#zjfreeb").html($.cookie('zjfreeb'));
            }
        },
        error: function (data) {
            alert(data.errmsg);
        }
    });
}


/**
 * @title 装修计算器
 * @date 2019/7/22
 * @author caisc
 * @param cityid        城市id
 * @param area          房屋面积
 * @param rooms         房间
 * @param office        客厅
 * @param kitchens      厨房
 * @param bathrooms     卫生间
 * @param balcony       阳台
 * @param isSecondHand  是否二手房
 */
function getFreeDecorationBudget(cityid, area, rooms, office, kitchens, bathrooms, balcony, isSecondHand) {
    if (isEmpty(cityid)) {
        alert("城市不能为空！");
        return false;
    }
    if (isEmpty(area)) {
        alert("房屋面积不能为空！");
        return false;
    }
    if (isEmpty(rooms)) {
        alert("房间数量不能为空！");
        return;
    }
    if (isEmpty(office)) {
        alert("客厅数量不能为空！");
        return;
    }
    if (isEmpty(kitchens)) {
        alert("厨房数量不能为空！");
        return;
    }
    if (isEmpty(bathrooms)) {
        alert("卫生间数量不能为空！");
        return;
    }
    if (isEmpty(balcony)) {
        alert("阳台数量不能为空！");
        return;
    }
    //材料费
    var clfree = 0;
    //人工费
    var rgfree = 0;
    //设计费
    var sjfree = 0;
    //质检费
    var zjfree = 3500;
    //装修预算约
    var ysfree = 0;
    // 请求参数
    var data = {
        "cityId": cityid,       // 城市id
        "area": area,           // 面积
        "rooms": rooms,         // 室
        "office": office,       // 厅
        "kitchens": kitchens,   // 厨
        "bathrooms": bathrooms, // 卫
        "balcony": balcony,     // 阳台
        "isSecondHand": isSecondHand  // 是否二手房
    };
    console.log("计算器请求参数：" + JSON.stringify(data));
    var href = window.location.href;
    var url = "https://m.bao315.com";
    if (href.indexOf("test") > -1) {
        url = "http://mtest.bao315.com";
    }
    var api = "/jsonp/getDecorationBudgetJsonp.jhtml";
    console.log("计算器请求地址：" + url + api);
    $.ajax({
        url: url + api,
        data: data,
        type: "post",
        dataType: "jsonp",
        contentType: "application/json",
        success: function (data) {
            if (data.errcode == 0) {
                var resutlt = data.result;
                ysfree = resutlt.ysfree;  // 装修预算
                sjfree = resutlt.sjfree;  // 材料费
                zjfree = resutlt.zjfree;  // 质检费
                clfree = resutlt.clfree;  // 材料费
                rgfree = resutlt.rgfree;  // 材料费
                console.log("计算器请求结果：" + JSON.stringify(data));
                $("#ysfree").html(ysfree);
                $("#clfree").html(clfree);
                $("#rgfree").html(rgfree);
                $("#sjfree").html(0);
                $("#zjfree").html(0);
                $("#sjfreeb").html(sjfree);
                $("#zjfreeb").html(zjfree);
                $.cookie('ysfree', ysfree);
                $.cookie('clfree', clfree);
                $.cookie('rgfree', rgfree);
                $.cookie('sjfree', 0);
                $.cookie('zjfree', 0);
                $.cookie('sjfreeb', sjfree);
                $.cookie('zjfreeb', zjfree);
            } else {
                alert(data.errmsg);
            }
        },
        error: function (data) {
            alert("网络错误，请刷新重试！");
        }
    });
}