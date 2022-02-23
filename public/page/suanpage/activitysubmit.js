
/**
 * 推广营销提交
 * @param name 用户姓名【必填】
 * @param phone 电话号码【必填】
 * @param classId 栏目ID【必填】
 * @param remark 业主装修要求
 * @param housearea 面积
 * @param provinceId 省
 * @param cityId 城市
 * @param okUrl ok页面地址
 */
function saveactivity(name,phone,classId,remark,housearea,provinceId,cityId,okUrl) {
	var activityName = $("#activityName").val();
    if (activityName != undefined && activityName != "") {
        if (remark == null) remark = "";
        remark = remark + " 活动名称：" + activityName;
    }
	if(classId=="" || classId==null || classId==undefined){
		alert("您的输入有误");
		return;
	}
	nameAndPhoneCookie(name,phone);
    
	var data = getData(name, phone, remark, housearea, classId, provinceId, cityId);
	data.referrerUrl = decodeURI(document.referrer);
	data.referrerUrl1 = window.location.href;
	var leader = getParameter("leader");
	if(leader !=undefined && leader !=null && leader !="null"){
		data.leader = leader;
	}
	var seoNewsId = getParameter("seoNewsId");
	if(seoNewsId !=undefined && seoNewsId !=null && seoNewsId !="null"){
		data.seoNewsId = seoNewsId;
	}
	var SCAN_URLS = getCookie("SCAN_URLS");
	if(SCAN_URLS==undefined || SCAN_URLS=="null"){
		SCAN_URLS = "";
	}
	data.scanUrls = SCAN_URLS;
	var markName = $("#markName").val();
	if(markName!=undefined && markName!=""){
		data.markName = markName;
	}
	$.ajax({
        type: "get",
        url: 'https://interface.bao315.com/activitys/saveActivity.html', //提交给哪个执行
        data: data,
		cache: false,
        dataType: 'jsonp',
        jsonpCallback: "getJson" ,
		jsonp: 'callback',
        success: function (responseValue) {
            if (responseValue.success!="False" && responseValue.success!="false" ) {
				alert("恭喜您，申请成功！\n您申请的联系电话为" + phone + "，保驾护航网的客服将会在一个工作日之内与您取得联系！");
				
				location.reload(true);
				if (okUrl != "" && okUrl != null && okUrl != undefined && okUrl != "") {
				    window.location.href = okUrl;
				}
            }
            else {
                if (responseValue.Message == undefined || responseValue.Message == "") {
                    alert('提交申请失败，请重新申请或直接联系保驾护航网客服热线：400-175-7315！');
                }
                else {
                    alert(responseValue.Message);
                }
				location.reload(true);
            }
        },
        error: function (responseValue) {
			alert("恭喜您，申请成功！\n您申请的联系电话为" + phone + "，保驾护航网的客服将会在一个工作日之内与您取得联系！");
			location.reload(true);
            
        }
    });
}

function getMarkName(){
	var type = $("#type").val();
	if(type==1){
		return "TEL";
	}else if(type==2){
		return "COMMERCE";
	}else{
		return "ACTIVISTS";
	}
}

function saveactivity_city(name,phone,classId,remark,housearea,provinceId,cityId,okUrl) {
	var activityName = $("#activityName").val();
    if (activityName != undefined && activityName != "") {
        if (remark == null) remark = "";
        remark = remark + " 活动名称：" + activityName;
    }
	if(classId=="" || classId==null || classId==undefined){
		alert("您的输入有误");
		return;
	}
	
	var cityid = $("#cityId").val();
    var housearea = $("#housecitystrcity").val();
	

    var shi = $("#shiselect option:selected").val();
    var chu = $("#chuselect option:selected").val();
    var wei = $("#weiselect option:selected").val();

	
	var data = getData(name, phone, remark, housearea, classId, provinceId, cityId);
	data.referrerUrl = decodeURI(document.referrer);
	data.referrerUrl1 = window.location.href;
	var leader = getParameter("leader");
	if(leader !=undefined && leader !=null && leader !="null"){
		data.leader = leader;
	}
	var seoNewsId = getParameter("seoNewsId");
	if(seoNewsId !=undefined && seoNewsId !=null && seoNewsId !="null"){
		data.seoNewsId = seoNewsId;
	}
	var SCAN_URLS = getCookie("SCAN_URLS");
	if(SCAN_URLS==undefined || SCAN_URLS=="null"){
		SCAN_URLS = "";
	}
	data.scanUrls = SCAN_URLS;
	var markName = $("#markName").val();
	if(markName!=undefined && markName!=""){
		data.markName = markName;
	}
	
	$.ajax({
        type: "get",
        url: 'https://interface.bao315.com/activitys/saveActivity.html', //提交给哪个执行
        data: data,
		cache: false,
        dataType: 'jsonp',
        jsonpCallback: "getJson" ,
		jsonp: 'callback',
        success: function (responseValue) {
            if (responseValue.success!="False" && responseValue.success!="false" ) {
				alert("恭喜您，申请成功！\n您申请的联系电话为 " + phone + "，保驾护航网的客服将会在一个工作日之内与您取得联系！");
				yusuanfreecity(cityid,housearea,shi,chu,wei);
				$("#housecitystrcity").val('');
				$("#phonecity").val('');
				$("#namecity").val('');
				if (okUrl != "" && okUrl != null && okUrl != undefined && okUrl != "") {
				    window.location.href = okUrl;
				}
            }
            else {
                if (responseValue.Message == undefined || responseValue.Message == "") {
                    alert('提交申请失败，请重新申请或直接联系保驾护航网客服热线：400-175-7315！');
                }
                else {
                    alert(responseValue.Message);
                }
				location.reload(true);
            }
        },
        error: function (responseValue) {
            alert("恭喜您，申请成功！\n您申请的联系电话为 " + phone + "，保驾护航网的客服将会在一个工作日之内与您取得联系！");
			location.reload(true);
            
        }
    });
}

function getJson(responseValue){
	
}

function getData(name, phone, remark, housearea, classId, provinceId, cityId) {
    if (provinceId != "" && cityId != "") {
        data = {
            "applyUser": name, "mobile": phone, "houseRemark": remark, "houseArea": housearea, "classId": classId, "markName": getMarkName(),
            "provinceId": provinceId, "cityId": cityId
        }
    }
    else if (housearea!="") {
        data = {
            "applyUser": name, "mobile": phone, "houseRemark": remark, "houseArea": housearea, "classId": classId, "markName": getMarkName()
        }
    }
    else {
        data = {
            "applyUser": name, "mobile": phone, "houseRemark": remark,  "classId": classId, "markName": getMarkName()
        }
    }
    return data;
}

/*
*验证是否为“”或者null
*true:是为空；
*/
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

/*
*验证手机
*true:是手机号码；false:不是手机号码
*/
function isMoblie(mobile) {
    var telzz = /^(12|13|14|15|16|17|18|19)\d{9}$/;
    if (telzz.test(mobile)) {
        return true;
    } else {
        return false;
    }
}

/*
*验证数字
*true:是数字；false:不是数字
*/
function isNumber(num) {
    var telzz = /^\d+$/;
    if (telzz.test(num)) {
        return true;
    } else {
        return false;
    }
}

function nameAndPhoneCookie(name,phone) {
     if (name!=null) {
		 name = escape(name);
        setCookie('uname',name,1);
    }
    if (phone!=null) {
         setCookie('phone',phone,1);
    }
}
function setCookie(cname,cvalue,exdays)
{
  var d = new Date();
  d.setTime(d.getTime()+(exdays*24*60*60*1000));
  var expires = "expires="+d.toGMTString();
  document.cookie = cname + "=" + cvalue + "; " + expires + "; " + "domain=.bao315.com" + "; " + "path=/";
}
function getCookie(cname)
{
  var name = cname + "=";
  var ca = document.cookie.split(';');
  for(var i=0; i<ca.length; i++) 
  {
    var c = ca[i].trim();
    if (c.indexOf(name)==0) return c.substring(name.length,c.length);
  }
  return "";
}
/*
*验证数字或者包含两位小数
*true:是数字数字包含两位小数；false:不是数字包含两位小数
*\d{1,2}：最少一位小数，最多两位小数
*/
function isDecimal(num) {
    var telzz = /^-?\d+\.?\d{1,2}$/;
    if (telzz.test(num)) {
        return true;
    } else {
        return false;
    }
}

// 获取url中的参数
function getParameter(name){
	var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
	var r = window.location.search.substr(1).match(reg);
	if (r != null)
		return unescape(r[2]);
	return null;
}

(function() {var _log_code = document.createElement("script");_log_code.src = "https://log.bao315.com/stat";var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(_log_code, s);})();
