function yunsuancookie() {
    var cityid = $("#cityId").val();
    var housearea = $("#housearea").val();
	if(housearea=="" || housearea==undefined || housearea=="undefined"){
		housearea = $("#housecitystrcity").val();
	}
    var area = parseFloat(housearea);
    var shi = $("#shiselect option:selected").val();
    var chu = $("#chuselect option:selected").val();
    var wei = $("#weiselect option:selected").val();
	var yt = $(".yt option:selected").val();
	var ting = $(".ting option:selected").val();
	$.cookie('cityid',cityid);
	$.cookie('housearea',area);
	$.cookie('ysfree',$("#ysfree").html());
	$.cookie('clfree',$("#ysfree").html());
	$.cookie('rgfree',$("#rgfree").html());
	$.cookie('sjfreeb',$("#sjfreeb").html());
	$.cookie('zjfreeb',$("#zjfreeb").html());
	$.cookie('yt',yt);
	$.cookie('ting',ting);
	$.cookie('shi',shi);
	$.cookie('chu',chu);
	$.cookie('wei',wei);
	$.cookie('cityName',$(".cityName").html());
	$.cookie('provinceName',$("#provinceName").html());
}
function getyscookie() {
	if(!$.cookie('housearea')){
	window.location.href="index.html";
	}
	$("#housearea").val($.cookie('housearea'));
	$("#weiselect").attr("value",$.cookie('wei'))
	$("#chuselect").attr("value",$.cookie('chu'))
	$("#shiselect").attr("value",$.cookie('shi'))
	$(".ting").attr("value",$.cookie('ting'))
	$(".yt").attr("value",$.cookie('yt'))
    $("#ysfree").html($.cookie('ysfree'));
    $("#clfree").html($.cookie('clfree'));
    $("#rgfree").html($.cookie('rgfree'));
    $("#sjfree").html(0);
    $("#zjfree").html(0);
    $("#sjfreeb").html($.cookie('sjfreeb'));
    $("#zjfreeb").html($.cookie('zjfreeb'));
    $("#provinceName").html($.cookie('provinceName'));
    $("li[name='"+$.cookie('provinceName')+"']").click();
    $(".cityName").html($.cookie('cityName'));
    $("#cityId").val($.cookie('cityid'));
}



// 装修计算器
function setyunsuancookie() {
    var cityid = $("#cityId").val();
    var housearea = $("#housearea").val();
	if(housearea=="" || housearea==undefined || housearea=="undefined"){
		housearea = $("#housecitystrcity").val();
	}
    var area = parseFloat(housearea);
    
    var provinceId = $("#sel1 option:selected").val();
    var cityId = $("#city option:selected").val();
    var cityName = $("#city option:selected").text();
    
    var shi = $("#shiselect option:selected").val();
    var chu = $("#chuselect option:selected").val();
    var wei = $("#weiselect option:selected").val();
	var yt = $("#yt option:selected").val();
	var ting = $("#ting option:selected").val();
	var name = $("#name1").val();
	var phone = $("#phone1").val();
	
	$.cookie('cityId',cityId);
	$.cookie('cityName',cityName);
	$.cookie('provinceId',provinceId);
	$.cookie('housearea',area);
	$.cookie('ysfree',$("#ysfree").html());
	$.cookie('clfree',$("#clfree").html());
	$.cookie('rgfree',$("#rgfree").html());
	$.cookie('sjfreeb',$("#sjfreeb").html());
	$.cookie('zjfreeb',$("#zjfreeb").html());
	$.cookie('yt',yt);
	$.cookie('ting',ting);
	$.cookie('shi',shi);
	$.cookie('chu',chu);
	$.cookie('wei',wei);
	$.cookie('name',name);
	$.cookie('phone',phone);
//	alert("2-area:"+$.cookie('housearea'));
//	alert("3-ysfree:"+$.cookie('ysfree'));
//	alert("4-clfree:"+$.cookie('clfree'));
//	alert("5-rgfree:"+$.cookie('rgfree'));
//	alert("6-sjfreeb:"+$.cookie('sjfreeb'));
//	alert("7-zjfreeb:"+$.cookie('zjfreeb'));
//	alert("8-yt:"+$.cookie('yt'));
//	alert("9-ting:"+$.cookie('ting'));
//	alert("10-shi:"+$.cookie('shi'));
//	alert("11-chu:"+$.cookie('chu'));
//	alert("12-wei:"+$.cookie('wei'));
//	alert("13-name:"+$.cookie('name'));
//	alert("14-phone:"+$.cookie('phone'));
//	alert("15-cityId:"+$.cookie('cityid'));
//	alert("16-cityName:"+$.cookie('cityName'));
//	alert("17-provinceId:"+$.cookie('provinceId'));
	
}


// 装修计算器
function setyunsuancookie2() {
    
    var housearea = $("#housearea").val();
	if(housearea=="" || housearea==undefined || housearea=="undefined"){
		housearea = $("#housecitystrcity").val();
	}
    var area = parseFloat(housearea);
    
    var provinceId = $("#provinceId").val();
    var cityId = $("#cityId").val();
    var cityName = $("#cityName").val();
    
    var shi = $("#shi").val();
    var chu = $("#chu").val();
    var wei = $("#wei").val();
	var yt = $("#yt").val();
	var ting = $("#ting").val();
	var name = $("#name1").val();
	var phone = $("#phone1").val();
	var  houseType=$("#houseType").val();
	var room=  $("input[name='room']:checked").val();
	$.cookie('cityId',cityId);
	$.cookie('cityName',cityName);
	$.cookie('provinceId',provinceId);
	$.cookie('housearea',area);
    $.cookie('houseType',houseType);
	$.cookie('room',room);
	$.cookie('yt',yt);
	$.cookie('ting',ting);
	$.cookie('shi',shi);
	$.cookie('chu',chu);
	$.cookie('wei',wei);
	$.cookie('name',name);
	$.cookie('phone',phone);
//	alert("2-area:"+$.cookie('housearea'));
//	alert("3-ysfree:"+$.cookie('ysfree'));
//	alert("4-clfree:"+$.cookie('clfree'));
//	alert("5-rgfree:"+$.cookie('rgfree'));
//	alert("6-sjfreeb:"+$.cookie('sjfreeb'));
//	alert("7-zjfreeb:"+$.cookie('zjfreeb'));
//	alert("8-yt:"+$.cookie('yt'));
//	alert("9-ting:"+$.cookie('ting'));
//	alert("10-shi:"+$.cookie('shi'));
//	alert("11-chu:"+$.cookie('chu'));
//	alert("12-wei:"+$.cookie('wei'));
//	alert("13-name:"+$.cookie('name'));
//	alert("14-phone:"+$.cookie('phone'));
//	alert("15-cityId:"+$.cookie('cityid'));
//	alert("16-cityName:"+$.cookie('cityName'));
//	alert("17-provinceId:"+$.cookie('provinceId'));
	
}

// 装修计算器
function setyunsuanSelectcookie() {
    
    var housearea = $("#housearea").val();
	if(housearea=="" || housearea==undefined || housearea=="undefined"){
		housearea = $("#housecitystrcity").val();
	}
    var area = parseFloat(housearea);
    
     var provinceId = $("#sel1 option:selected").val();
     var cityId = $("#cityId").val();
     var cityName = $("#cityName").val();
    
    var shi = $("#shi").val();
    var chu = $("#chu").val();
    var wei = $("#wei").val();
	var yt = $("#yt").val();
	var ting = $("#ting").val();
	var name = $("#name1").val();
	var phone = $("#phone1").val();
	var  houseType=$("#houseType").val();
	var room=  $("input[name='room']:checked").val();
	$.cookie('cityId',cityId);
	$.cookie('cityName',cityName);
	$.cookie('provinceId',provinceId);
	$.cookie('housearea',area);
    $.cookie('houseType',houseType);
	$.cookie('room',room);
	$.cookie('yt',yt);
	$.cookie('ting',ting);
	$.cookie('shi',shi);
	$.cookie('chu',chu);
	$.cookie('wei',wei);
	$.cookie('name',name);
	$.cookie('phone',phone);
//	alert("2-area:"+$.cookie('housearea'));
//	alert("3-ysfree:"+$.cookie('ysfree'));
//	alert("4-clfree:"+$.cookie('clfree'));
//	alert("5-rgfree:"+$.cookie('rgfree'));
//	alert("6-sjfreeb:"+$.cookie('sjfreeb'));
//	alert("7-zjfreeb:"+$.cookie('zjfreeb'));
//	alert("8-yt:"+$.cookie('yt'));
//	alert("9-ting:"+$.cookie('ting'));
//	alert("10-shi:"+$.cookie('shi'));
//	alert("11-chu:"+$.cookie('chu'));
//	alert("12-wei:"+$.cookie('wei'));
//	alert("13-name:"+$.cookie('name'));
//	alert("14-phone:"+$.cookie('phone'));
//	alert("15-cityId:"+$.cookie('cityid'));
//	alert("16-cityName:"+$.cookie('cityName'));
//	alert("17-provinceId:"+$.cookie('provinceId'));
	
}

// 装修计算器
function setyunsuanNormalcookie() {
    
    var housearea = $("#housearea").val();
	if(housearea=="" || housearea==undefined || housearea=="undefined"){
		housearea = $("#housecitystrcity").val();
	}
    var area = parseFloat(housearea);
    
     var provinceId = $("#sel1 option:selected").val();
     var cityId = $("#cityId").val();
     var cityName = $("#cityName").val();
    
      
    var shi = $("#shiselect option:selected").val();
    var chu = $("#chuselect option:selected").val();
    var wei = $("#weiselect option:selected").val();
	var yt = $("#yt option:selected").val();
	var ting = $("#ting option:selected").val();
	var name = $("#name1").val();
	var phone = $("#phone1").val();
	var  houseType=$("#houseType").val();
	var room=  $("input[name='room']:checked").val();
	$.cookie('cityId',cityId);
	$.cookie('cityName',cityName);
	$.cookie('provinceId',provinceId);
	$.cookie('housearea',area);
    $.cookie('houseType',houseType);
	$.cookie('room',room);
	$.cookie('yt',yt);
	$.cookie('ting',ting);
	$.cookie('shi',shi);
	$.cookie('chu',chu);
	$.cookie('wei',wei);
	$.cookie('name',name);
	$.cookie('phone',phone);
//	alert("2-area:"+$.cookie('housearea'));
//	alert("3-ysfree:"+$.cookie('ysfree'));
//	alert("4-clfree:"+$.cookie('clfree'));
//	alert("5-rgfree:"+$.cookie('rgfree'));
//	alert("6-sjfreeb:"+$.cookie('sjfreeb'));
//	alert("7-zjfreeb:"+$.cookie('zjfreeb'));
//	alert("8-yt:"+$.cookie('yt'));
//	alert("9-ting:"+$.cookie('ting'));
//	alert("10-shi:"+$.cookie('shi'));
//	alert("11-chu:"+$.cookie('chu'));
//	alert("12-wei:"+$.cookie('wei'));
//	alert("13-name:"+$.cookie('name'));
//	alert("14-phone:"+$.cookie('phone'));
//	alert("15-cityId:"+$.cookie('cityid'));
//	alert("16-cityName:"+$.cookie('cityName'));
//	alert("17-provinceId:"+$.cookie('provinceId'));
	
}



// 装修计算器
function getcookie() {
	if(!$.cookie('housearea')){
		window.location.href="index.html";
	}
	$("#housearea").val($.cookie('housearea'));
	$("#weiselect").attr("value",$.cookie('wei'))
	$("#chuselect").attr("value",$.cookie('chu'))
	$("#shiselect").attr("value",$.cookie('shi'))
	$("#ting").attr("value",$.cookie('ting'))
	$("#yt").attr("value",$.cookie('yt'))
    $("#ysfree").html($.cookie('ysfree'));
    $("#clfree").html($.cookie('clfree'));
    $("#rgfree").html($.cookie('rgfree'));
    $("#sjfree").html(0);
    $("#zjfree").html(0);
    $("#sjfreeb").html($.cookie('sjfreeb'));
    $("#zjfreeb").html($.cookie('zjfreeb'));
    
    $("#sel1").attr("value",$.cookie('provinceId'))
    
	$("#sel1 option").each(function(i,o){
		if($(this).attr("selected")){
			$(".sub").hide();
			$(".sub").eq(i).show();
			$(".sub").val("");
			$("#cityId").val("");
			$("#cityName").val("");
		}
	});
    
    $(".sub").attr("value",$.cookie('cityId'))
    
    $("#cityName").val($.cookie('cityName'));
    $("#cityId").val($.cookie('cityId'));
    $("#name1").val($.cookie('name'));
    $("#phone1").val($.cookie('phone'));
    
}

// 装修计算器
function getjsqcookie() {
	if(!$.cookie('housearea')){
		window.location.href="index.html";
	}
	$("#housearea").val($.cookie('housearea'));
	$("#weiselect").attr("value",$.cookie('wei'))
	$("#chuselect").attr("value",$.cookie('chu'))
	$("#shiselect").attr("value",$.cookie('shi'))
	$("#ting").attr("value",$.cookie('ting'))
	$("#yt").attr("value",$.cookie('yt'))
    $("#ysfree").html($.cookie('ysfree'));
    $("#clfree").html($.cookie('clfree'));
    $("#rgfree").html($.cookie('rgfree'));
    $("#sjfree").html(0);
    $("#zjfree").html(0);
    $("#sjfreeb").html($.cookie('sjfreeb'));
    $("#zjfreeb").html($.cookie('zjfreeb'));
     var  houseType = $.cookie('houseType');
     
     if (houseType==null || houseType==""||houseType==undefined) {
          houseType="2室,1厅,1厨,1卫,1阳台"
     	
     }
      var select_result=houseType.split(",");

    $('.calc-five span').each(function(index, el) {
	    $(this).html(select_result[index])
	});
    
    $("#cityName").val($.cookie('cityName'));
    $("#cityId").val($.cookie('cityId'));
    $("#name1").val($.cookie('name'));
    $("#phone1").val($.cookie('phone'));
    
}

// 装修计算器
function getJsqSelectcookie() {
	if(!$.cookie('housearea')){
		window.location.href="index.html";
	}
	$("#housearea").val($.cookie('housearea'));
	$("#weiselect").attr("value",$.cookie('wei'))
	$("#chuselect").attr("value",$.cookie('chu'))
	$("#shiselect").attr("value",$.cookie('shi'))
	$("#ting").attr("value",$.cookie('ting'))
	$("#yt").attr("value",$.cookie('yt'))
    $("#ysfree").html($.cookie('ysfree'));
    $("#clfree").html($.cookie('clfree'));
    $("#rgfree").html($.cookie('rgfree'));
    $("#sjfree").html(0);
    $("#zjfree").html(0);
    $("#sjfreeb").html($.cookie('sjfreeb'));
    $("#zjfreeb").html($.cookie('zjfreeb'));
     var  houseType = $.cookie('houseType');
   $("#sel1").attr("value",$.cookie('provinceId'));
    
	$("#sel1 option").each(function(i,o){
		if($(this).attr("selected")){
			$(".sub").hide();
			$(".sub").eq(i).show();
			$(".sub").val("");
			$("#cityId").val("");
			$("#cityName").val("");
		}
	});
    
    $(".sub").attr("value",$.cookie('cityId'));
     $("#cityName").val($.cookie('cityName'));
    $("#cityId").val($.cookie('cityId'));
    var  room=$.cookie('room')
    if (room!=null && room!=undefined && room==1) {
        $("#newRoom").attr("checked","checked");
    	$("#secRoom").removeAttr("checked");
    }else{
    	$("#secRoom").attr("checked","checked");
    	$("#newRoom").removeAttr("checked");
    }
   
    $("#name1").val($.cookie('name'));
    $("#phone1").val($.cookie('phone'));
     
     if (houseType==null || houseType==""||houseType==undefined) {
          houseType="2室,1厅,1厨,1卫,1阳台"
     	
     }
      var select_result=houseType.split(",");

    $('.calc-five span').each(function(index, el) {
	    $(this).html(select_result[index])
	});
    
    
}


