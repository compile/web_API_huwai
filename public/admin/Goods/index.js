$(function(){
	let year = new Date().getFullYear()
	$('#year_new').text(year)
})

// 去除以后可以让页面实现刷新以后停留在当前页面，但是有一些页面没有引入footer.tpl 就有问题
sessionStorage.removeItem("refreshPage");
sessionStorage.setItem("refreshPage", "index.php?module=index");

var defaultPage = "index.php?module=index"

var is_open = $('#a-title').val()
console.log($('#a-title').val());
var title = $('#a-title').val()
var content = $('#a-content').html()
var admin_id = $('#admin_id').val()
var tell_id = $('#a-tell-id').val()

window.requestAnimationFrame = window.requestAnimationFrame || function(fn) {
	return setTimeout(fn, 1000 / 60)
}
window.cancelAnimationFrame = window.cancelAnimationFrame || clearTimeout;

requestAnimationFrame(checkLoginPage)

function onClickToHome() {

	sessionStorage.setItem("refreshPage", defaultPage);
	$('.sp5').each(function() {
		$(this).siblings().find(".t2").css("color", "#333");
		$(this).find(".asideImgWrap img").eq(0).hide();
		$(this).find(".asideImgWrap img").eq(1).show();
		$(this).removeClass("sp5");

		$(this).siblings().find(".asideImgWrap img").eq(1).hide();
		$(this).siblings().find(".asideImgWrap img").eq(0).show();
	})


	$('#menu-article').addClass('actived')
	$('#menu-article').addClass('sp5')
	document.getElementsByTagName("iframe")[0].src = defaultPage


}

function setIframePage() {
	var sessionStorage = window.sessionStorage;

	var refreshPage = sessionStorage.getItem("refreshPage");
	if (refreshPage == "index.php?module=Customer&action=Index") {
		refreshPage = defaultPage
		sessionStorage.setItem("refreshPage", refreshPage);
	}

	if (refreshPage != null && refreshPage != "" && refreshPage != undefined) {
		document.getElementsByTagName("iframe")[0].src = refreshPage
		$('.menu-system a').each(function() {
			var href = $(this).attr('_href');
			if (href === refreshPage) {
				var menu = $(this).parent().parent().parent().parent()
				console.log(menu);
				menu.addClass('sp5');

				var dt = $(this).parent().parent().parent().prev();
				$(dt).addClass('selected');

				var dd = $(this).parent().parent().parent();
				$(dd).css({
					display: "block"
				});
				$(this).css({
					color: "rgb(20, 140, 241)"
				})
			}
		})
		if (refreshPage == defaultPage) {
			$('#menu-article').addClass('actived')
			$('#menu-article').addClass('sp5')
			$('#menu-article .t2').css('color', "rgb(20, 140, 241)")
		}


	} else {
		if (refreshPage == defaultPage) {
			$('#menu-article').addClass('actived')
			$('#menu-article').addClass('sp5')
		}
		document.getElementsByTagName("iframe")[0].src = defaultPage
	}
	sessionStorage.setItem("type", 'STORE')
}

// 检测iframe的登录页面，如果是登录页面则跳转到登录页
function checkLoginPage() {
	let iframe = document.getElementsByTagName("iframe")[0];
	if (!iframe) {
		location.href = 'index.php?module=Login'
	}
	let obj = iframe.contentWindow;
	let title = obj.document.title;
	if (title === "欢迎登录后台管理系统") {
		location.href = 'index.php?module=Login'
	} else {
		requestAnimationFrame(checkLoginPage)
	}
}


let filePortraitImg = null;
$("#changePortraitImg").change(function(e) {
	var files = e.target.files,
		file;
	if (files && files.length > 0) {
		// 获取目前上传的文件
		file = files[0]; // 文件大小校验的动作
		if (file.size > 1024 * 1024 * 2) {
			alert('图片大小不能超过 2MB!');
			return false;
		}
		filePortraitImg = file;
		// 获取 window 的 URL 工具
		var URL = window.URL || window.webkitURL;
		// 通过 file 生成目标 url
		var imgURL = URL.createObjectURL(file);
		//用attr将img的src属性改成获得的url
		$(".changePortraitImg1").attr("src", imgURL);
	}
})
$(".changePortraitImg1").mouseover(function() {
	$(".changePortraitImgBtn").show()
})
$("#changePortraitImgBtn").mouseout(function() {
	$("#changePortraitImgBtn").hide()
})


let fileStoreImg = null;
$("#changeStoreImg").change(function(e) {
	var files = e.target.files,
		file;
	if (files && files.length > 0) {
		// 获取目前上传的文件
		file = files[0]; // 文件大小校验的动作
		if (file.size > 1024 * 1024 * 2) {
			alert('图片大小不能超过 2MB!');
			return false;
		}
		fileStoreImg = file;
		// $("#fileStoreImg").val(file);
		// 获取 window 的 URL 工具
		var URL = window.URL || window.webkitURL;
		// 通过 file 生成目标 url
		var imgURL = URL.createObjectURL(file);
		//用attr将img的src属性改成获得的url
		$(".changeStoreImg1").attr("src", imgURL);
	}
})

refreshCount();

$(".changeStoreImg1").mouseover(function() {
	$("#changeImgBtn").show()
})
$("#changeImgBtn").mouseout(function() {
	$("#changeImgBtn").hide()
})
var radioType = 1


function send_btn_xsfh(oid, otype, sNo) {
	console.log("send_btn_xsfh");
	$(".ipt1").val('');
	$(".order_id").val(oid);
	$(".oid").val(sNo);
	$(".otype").val(otype);
	$(".dc").show();

	//  订单输入框
	var numberingDom = $('input[name=danhao]')
	var kuaidi1Dom = $('#kuaidi1')
	var kuaidi2Dom = $('#kuaidi2')


	if (radioType === 2) {
		kuaidi2Dom.show()
		kuaidi1Dom.hide()
	} else if (radioType === 1) {
		kuaidi1Dom.show()
		kuaidi2Dom.hide()
	}

	$('.radio-2').on('click', function(event) {
		// 1 | 手动输入
		if (event.target.title === '1') {
			numberingDom.show()
			kuaidi1Dom.show()
			kuaidi2Dom.hide()
			radioType = 1
		} else {
			numberingDom.hide()
			kuaidi1Dom.hide()
			kuaidi2Dom.show()
			radioType = 2
		}
	})

};

function dump(url) {
	$.ajax({
		type: "get",
		url: 'index.php?module=AdminLogin&store_id1=tc',
		async: true,
		dataType: "json",
		success: function(res) {
			console.log(url)
			sessionStorage.removeItem("refreshPage")
			window.parent.location.href = url;
		},
		error: function(res) {
			$(".dc").hide();
			layer.msg('您没有该权限！');
			let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
			ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
		}
	});
}

$(".ifsAPI").each(function() {
	var href = $(this).find('a').attr('_href');
	var id = $(this).find('a').attr('id');
	$(this).click(function() {
		$(".show_iframe").remove();
		if (id) {
			$("#iframe_box").append(
				'<div class="show_iframe"><div class="loading"></div><iframe onload="onload1()" frameborder="0" src=' +
				href + ' id=' + id + '></iframe></div>')
		} else {
			$("#iframe_box").append(
				'<div class="show_iframe"><div class="loading"></div><iframe onload="onload1()" frameborder="0" src=' +
				href + '></iframe></div>')
		}
		$(".show_iframe").eq(0).show();
	})
})
if ($("#type1").val() != 0) {
	let aBtn = $(".menu-system").eq(0);
	aBtn.find('dt').addClass("selected");
	aBtn.find('dd').show();
	aBtn.find('.t2').css('color', '#2890ff');
	aBtn.find('.asideImg').eq(0).hide();
	aBtn.find('.asideImgRight').eq(0).hide();
	aBtn.find('.asideImg').eq(1).show();
	aBtn.find('.asideImgRight').eq(1).show();
	aBtn.find('.ifsAPI').eq(0).find('a').css('color', '#2890ff');
	aBtn.find('.ifsAPI').eq(0).click();
}

function updateToast (title, content) {
	$("body", parent.document).append(
		`
			<style>
				.maskNewContent-update {
					top: 172px;
					background: none;
					width: 500px;
					position: relative;
				}
				.maskNewContent-update .close-img {
					position: absolute;
					top: 51px;
					right: 27px;
					cursor: pointer;
				}
				.maskNewContent-update h1{
					position: absolute;
					top: 80px;
					width: 100%;
					color: white;
					text-align:center;
				}
				.maskNewContent-update .title{
					background: white;
					text-align:center;
					padding-top: 20px;
					padding-bottom: 0px;
					font-size:24px;
					color: #020202;
				}
				.maskNewContent-update .content{
					background: white;
					padding: 0 36px 36px;
					height: 211px;
					overflow-y: auto;
					border-radius: 0 0 5px 5px;
				}
			</style>
			<div class="maskNew">
				<div class="maskNewContent maskNewContent-update">
					<img src="static/img/update_top.png" alt="">
					<img class="close-img" onclick="closeUpdateToast()" src="static/img/close.png" alt="" />
					<h1>版本升级通知</h1>
					<div class="title">${title}</div>
					<div class="content">
						${content}
					</div>
				</div>
			</div>
			<script>
				function closeUpdateToast() {
				  $('.maskNew').remove()
				}
			</script>
		`
	)
}

window.onload = function() {
	setIframePage();
	checkLoginPage();


	// 升级的系统公告弹窗



	if (this.is_open) {
		let tell_ids = localStorage.getItem('tell_ids')
		if (!tell_ids) {
			tell_ids = tell_id
			localStorage.setItem('tell_ids', tell_ids)
		} else {
			let arr = tell_ids.split(',')
			if (arr.indexOf(tell_id) > -1) {
				return false;
			} else {
				tell_ids = tell_ids + ',' + tell_id
				localStorage.setItem('tell_ids', tell_ids)
			}
		}

		updateToast(title, content);
	}


	var selects = [document.getElementById("select1"), document.getElementById("select2"), document.getElementById(
		"select3")]; //通过标签名获取select对象
	var date = new Date();
	var nowYear = date.getFullYear(); //获取当前的年
	for (var i = nowYear - 100; i <= nowYear; i++) {
		var optionYear = document.createElement("option");
		optionYear.innerHTML = i;
		optionYear.value = i;
		selects[0].appendChild(optionYear);
	}
	for (var i = 1; i <= 12; i++) {
		var optionMonth = document.createElement("option");
		optionMonth.innerHTML = i;
		optionMonth.value = i;
		selects[1].appendChild(optionMonth);
	}
	getDays(selects[1].value, selects[0].value, selects);
}
let data1;
$.ajax({
	type: "post",
	url: "index.php?module=AdminLogin&action=maskContent",
	async: true,
	dataType: "json",
	success: function(data) {
		data1 = data.re[0];
		$("#nickname1").html(data1.nickname);
	},
	error: function(res) {
		$(".dc").hide();
		let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
		ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
	}
});
$("#msgBtn,#msgWrap").mouseout(function() {
	$("#msgDiv").hide();
})
$("#msgDiv,#msgBtn").mouseover(function(event) {
	$("#msgDiv").show();
})
let aDiv = document.getElementsByClassName("msgDiv2")
for (let i = 0; i < $(".msgDiv2").length; i++) {
	aDiv[i].addEventListener("mouseover", function() {
		$("#msgDiv").show();
	})
}
$(".msgDiv1").eq(0).each(function(i) {
	$(this).click(function() {
		//没点击的最原始状态
		if (parseInt($("#msgDiv").css("height")) == 160) {
			$(".msgDiv2").css('height', '160px')
			$(".msgDiv2").eq(0).show();
			$("#msgDiv").css("height", "320px")
			$(this).parent().css("padding-bottom", "160px")
		} //点击后
		else {
			if ($(this).parent().find(".msgDiv2").is(":visible")) {
				//如果取消单个下拉菜单
				$(".msgDiv2").eq(0).hide();
				$("#msgDiv").css("height", "160");
				$(this).parent().css("padding-bottom", "0px")
			} else {
				$(".msgDiv2").hide();
				$(".msgUl1 li").each(function() {
					$(this).css("padding-bottom", "0px")
				})
				$(".msgDiv2").eq(0).show();
				$(this).parent().css("padding-bottom", "120px")

			}
		}
	})
})

$(".msgDiv1").eq(3).each(function(i) {
	$(this).click(function() {
		//没点击的最原始状态
		if (parseInt($("#msgDiv").css("height")) == 160) {
			$(".msgDiv2").css('height', '40px')
			$(".msgDiv2").eq(3).show();
			$("#msgDiv").css("height", "200px")
			$(this).parent().css("padding-bottom", "40px")
		} //点击后
		else {
			if ($(this).parent().find(".msgDiv2").is(":visible")) {
				//如果取消单个下拉菜单
				$(".msgDiv2").eq(3).hide();
				$("#msgDiv").css("height", "160");
				$(this).parent().css("padding-bottom", "0px")
			} else {
				$(".msgDiv2").hide();
				$(".msgUl1 li").each(function() {
					$(this).css("padding-bottom", "0px")
				})
				$(".msgDiv2").eq(3).show();
				$(this).parent().css("padding-bottom", "120px")

			}
		}
	})
})

// $(".msgDiv1").each(function(i) {
// 	$(this).click(function() {
// 		//没点击的最原始状态
// 		if (parseInt($("#msgDiv").css("height")) == 160) {
// 			$(".msgDiv2").eq(i).show();
// 			$("#msgDiv").css("height", "320")
// 			$(this).parent().css("padding-bottom", "160px")
// 		} //点击后
// 		else {
// 			if ($(this).parent().find(".msgDiv2").is(":visible")) {
// 				//如果取消单个下拉菜单
// 				console.log("s");
// 				$(".msgDiv2").eq(i).hide();
// 				$("#msgDiv").css("height", "160");
// 				$(this).parent().css("padding-bottom", "0px")
// 			} else {
// 				$(".msgDiv2").hide();
// 				$(".msgUl1 li").each(function() {
// 					$(this).css("padding-bottom", "0px")
// 				})
// 				$(".msgDiv2").eq(i).show();
// 				$(this).parent().css("padding-bottom", "120px")
//
// 			}
// 		}
// 	})
// })

$(".msgUl2 li").each(function() {
	$(this).mouseover(function() {
		$(this).find(".msgText").css("color", "#2991ff")
	});
	$(this).mouseout(function() {
		$(this).find(".msgText").css("color", "#888f9e")
	})
})
$("#changePsw").click(function() {
	let oldPW = $("[name=oldPW]").val();
	let newPW = $("[name=newPW]").val();
	let curPW = $("[name=curNewPW]").val();

	var space = /\s/g;
	if (space.test(oldPW) || space.test(newPW) || space.test(curPW)) {
		layer.msg('密码包含空格')
		return false;
	}

	if (oldPW === '' || newPW === '' || curPW === '') {
		layer.msg("密码不能为空");
		if (oldPW == '') {
			$("[name=oldPW]")[0].focus()
		} else if (newPW === '') {
			$("[name=newPW]")[0].focus()
		} else if (curPW === '') {
			$("[name=curNewPW]")[0].focus()
		}

		return false
	}

	if (newPW.length < 6 || curPW.length < 6) {
		layer.msg("密码不能小于6位");
		return false
	}
	if (curPW !== newPW) {
		layer.msg("新密码和确认密码不一致");
		return
	}
	if (newPW.length > 20 || curPW.length > 20) {
		layer.msg("密码不能超过20位");
		return false
	}

	$.ajax({
		type: "post",
		url: "index.php?module=AdminLogin&action=changePassword",
		async: true,
		dataType: "json",
		data: {
			oldPW,
			newPW,
			curPW,
		},
		success: function(res) {
			if (res.status == 3) {
				layer.msg(res.info);
				$("#changePassword").hide();
				location.replace(location.href);
			} else {
				layer.msg(res.info);
			}
		},
		error: function(res) {
			$(".dc").hide();
			layer.msg('您没有该权限！');
			// location.replace(location.href);
			let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
			ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
		}
	});
})
$("#changeInf").click(function() {
	let sex = $("[name=sex]:checked").val();
	let birthday = $("#select1").val() + "-" + $("#select2").val() + "-" + $("#select3").val()
	let portrait = $("[name=portrait]").attr('src');
	let nickname = $("[name=name]").val();
	let tel = $("[name=tel]").val();
	let storeImg = $('.changeStoreImg1').attr('src')
	let shop_name = $("[name=shop_name]").val();
	let shop_range = $("[name=shop_range]").val();
	let shop_information = $("[name=shop_information]").val();


	var data = new FormData($("#storeInfoForm")[0]);
	data.append("fileStoreImg", fileStoreImg);
	data.append("filePortraitImg", filePortraitImg);

	if (filePortraitImg) {
		data.append("fileAdminAvatarImg", filePortraitImg);
	}

	if (!(/^1(3|4|5|6|7|8|9)\d{9}$/.test(tel))) {
		layer.msg('手机格式错误')
		return false;
	}

	var patrn = /((?=[\x21-\x7e]+)[^A-Za-z0-9])/g;

	if ($('[name="shop_name"]').val() != '' && patrn.test($('[name="shop_name"]').val())) {
		layer.msg('店铺名称包含特殊字符')
		return
	}

	if (sex.length > 0 && birthday.length > 0 && tel.length == 11 && nickname.length > 0) {
		$.ajax({
			type: "post",
			url: "index.php?module=AdminLogin&action=maskContent",
			async: true,
			// dataType: "json",
			data: data,
			processData: false,
			contentType: false,
			success: function(res1) {
				var res = JSON.parse(res1);
				if (res.status == 3) {
					layer.msg(res.info);
					$("#jbxx").hide();
					$("#nickname1").text(nickname);
					$("#naickname").val(nickname);
					data1 = res.re[0];
					// $("#tel").val(data1.tel);
					$("[name=tel]").val(data1.tel)
				} else {
					layer.msg(res.info);
				}
				location.reload()
			},
			error: function(res) {
				$(".dc").hide();
				let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
				ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
			}
		});
	} else {
		layer.msg("请输入完整信息！");
	}
})

function setContent(a, event) {
	var select = $("#hh");
	/* select.html(""); */

	for (i = 0; i < Arr.length; i++) {
		//若找到包含txt的内容的，则添option
		if (Arr[i].indexOf(a.value) >= 0) {
			var option = $("<option value='" + array[i] + "'></option>").text(Arr[i]);
			select.append(option);
		}
	}
	if (event.keyCode == 40) {
		//按向下的键之后跳转到列表中
		//焦点转移并且选中第一个值
		$("#hh").focus();
		$("#hh").find("option:first").attr("selected", "true");
		return false;
	}
};

function setDemo(a, event) {
	$("#makeInput").val("");
	$("#hh").css({
		"display": "block"
	});
	var select = $("#hh");
};

// 获取某年某月存在多少天
function getDaysInMonth(month, year) {
	var days;
	if (month == 1 || month == 3 || month == 5 || month == 7 || month == 8 || month == 10 || month == 12) {
		days = 31;
	} else if (month == 4 || month == 6 || month == 9 || month == 11) {
		days = 30;
	} else {
		if ((year % 4 == 0 && year % 100 != 0) || (year % 400 == 0)) { // 判断是否为润二月
			days = 29;
		} else {
			days = 28;
		}
	}
	return days;
};

function setDays() {

	var id = "met_cl";
	var dov = document.getElementById(id)

	var selects = dov.getElementsByTagName("select");
	var year = selects[0].options[selects[0].selectedIndex].value;
	var month = selects[1].options[selects[1].selectedIndex].value;
	getDays(month, year, selects);
}

function getDays(month, year, selects) {
	var days = getDaysInMonth(month, year);
	selects[2].options.length = 0;
	for (var i = 1; i <= days; i++) {
		var optionDay = document.createElement("option");
		optionDay.innerHTML = i;
		optionDay.value = i;
		selects[2].appendChild(optionDay);
	}
}

/*菜单导航*/
$(".sp1 li").each(function() {
	$(this).mouseover(function() {
		$(".dropDown_A").css("background", "none")
	})
})
$(".none").each(function() {
	$(this).click(function() {
		$(".mask1").show();
	})
})
$(".closeMask").click(function() {
	$(".mask1").hide();
})

$(".clsCPW").on("click", function() {
	$("#changePassword").hide();

})
$(".sp2").click(function() {
	$(this).siblings().find(".t2").css("color", "#333");
	$(this).find(".t2").css("color", "#148cf1");
	$(this).find(".asideImgWrap img").eq(0).hide();
	$(this).find(".asideImgWrap img").eq(1).show();
	$(".bk_2 div").each(function() {
		$(this).removeClass("sp5");
		$(".sp2").addClass("sp5");
	})

	$(this).siblings().find(".asideImgWrap img").eq(1).hide();
	$(this).siblings().find(".asideImgWrap img").eq(0).show();
	$(this).siblings().find(".asideImgWrapRight img:odd").hide();
	$(this).siblings().find(".asideImgWrapRight img:even").show();
})
$(".textApi a").each(function() {
	$(this).click(function() {
		$(".textApi a").each(function() {
			$(this).css("color", "#666");
		})
		$(this).css("color", "#148cf1");
		$(this).parent().parent().parent().parent().siblings().removeClass("sp5");
		$(this).parent().parent().parent().parent().addClass("sp5");
		$(this).parent().parent().parent().parent().siblings().each(function() {
			$(this).find(".t2").css("color", "#333");
			$(this).find(".asideImgWrap img").eq(1).hide();
			$(this).find(".asideImgWrap img").eq(0).show();

		});
		$(this).parent().parent().parent().siblings().find(".asideImgWrap img").eq(0).hide();
		$(this).parent().parent().parent().siblings().find(".t2").css("color", "#0080ff");
		$(this).parent().parent().parent().siblings().find(".asideImgWrap img").eq(1).show();
		$(".topTitle").text($(this).text())
		$(".sp2").find(".asideImg").eq(1).hide();
		$(".sp2").find(".asideImg").eq(0).show();
		$(".sp2").find(".t2").css("color", "#333");
	})

});

function tab_titleList(obj) {
	var bStop = false,
		bStopIndex = 0,
		href = $(obj).attr('data-href'),
		title = $(obj).attr("data-title"),
		topWindow = $(window.parent.document),
		show_navLi = topWindow.find("#min_title_list li"),
		iframe_box = topWindow.find("#iframe_box");
	if (!href || href == "") {
		layer.msg("data-href不存在，v2.5版本之前用_href属性，升级后请改为data-href属性");
		return false;
	}
	if (!title) {
		layer.msg("v2.5版本之后使用data-title属性");
		return false;
	}
	if (title == "") {
		layer.msg("data-title属性不能为空");
		return false;
	}
	show_navLi.each(function() {
		if ($(this).find('span').attr("data-href") == href) {
			bStop = true;
			bStopIndex = show_navLi.index($(this));
			return false;
		}
	});
	if (!bStop) {
		creatIframe(href, title);
		min_titleList();
	} else {
		show_navLi.removeClass("active").eq(bStopIndex).addClass("active");
		iframe_box.find(".show_iframe").hide().eq(bStopIndex).show().find("iframe").attr("src", href);
	}
}

MessagePlugin.init({
	elem: "#message",
	msgData: [{
		text: "暂无信息",
		id: 1,
		readStatus: 1
	}, ],
	msgUnReadData: 0,
	noticeUnReadData: 0,
	msgClick: function(obj) {
		layer.msg($(obj).text());
	},
	noticeClick: function(obj) {
		layer.msg("提醒点击事件");
	},
	allRead: function(obj) {
		layer.msg("全部已读");
	},
	getNodeHtml: function(obj, node) {
		if (obj.readStatus == 1) {
			node.isRead = true;
		} else {
			node.isRead = false;
		}
		var html = "<p>" + obj.text + "</p>";
		node.html = html;
		return node;
	}
});
$(".menu-system").each(function() {
	$(this).mouseover(function() {
		$(this).find(".asideImg").eq(0).hide();
		$(this).find(".asideImg").eq(1).show();
		$(this).addClass("active");
		$(this).find(".t2").css("color", "#148cf1");
		$(".selected .t2").css("color", "#148cf1");
	})
	$(this).mouseout(function() {
		$(this).find(".asideImg").eq(1).hide();
		$(this).find(".asideImg").eq(0).show();
		$(this).removeClass("active");
		$(".selected .t2").css("color", "#333");
		$(".sp5").find(".asideImgWrap img").eq(0).hide();
		$(".sp5").find(".asideImgWrap img").eq(1).show();
		$(".t2").css("color", "#333");
		$(".sp5").find(".t2").css("color", "#148cf1");
	})

	$(this).click(function() {
		if (!$(".changeAside").hasClass("changed")) {
			$(".menu-system dt").each(function() {
				if ($(this).hasClass("selected")) {
					$(this).find(".asideImgRight").eq(0).hide();
					$(this).find(".asideImgRight").eq(1).show();
				} else {
					$(this).find(".asideImgRight").eq(1).hide();
					$(this).find(".asideImgRight").eq(0).show();
				}
			});
		}
	})
});
$(".changeAside").click(function() {
	if ($(this).hasClass("changed")) {
		$(this).removeClass("changed");
		$("aside").animate({
			width: "200"
		}); //200
		$(".Hui-article-box").animate({
			left: "200"
		}); //200
		$(".Hui-aside .menu_dropdown dl dt").animate({
			paddingLeft: "30"
		})
		setTimeout(function() {
			$(".t2,.asideImgWrapRight").show();
		}, 500);
		$(".asideImg").css("left", "0px");
		$("#menu-article a").css({
			width: "50px",
			height: "50px",
			position: "static"
		})
	} else {
		$(this).addClass("changed");
		$("aside").animate({
			width: "50"
		}); //200
		$(".Hui-article-box").animate({
			left: "50"
		}); //200
		$(".t2,.asideImgWrapRight").hide();
		$(".Hui-aside .menu_dropdown dl dt").animate({
			paddingLeft: "0"
		}); //30
		$(".asideImg").css("left", "15px");
		$(".menu-system dd ").hide();
		$(".asideImgRight:odd").hide();
		$(".asideImgRight:even").show();
		$("#menu-article a").css({
			position: "absolute",
			width: "50px",
			height: "50px",
			left: "0px",
		})

	}
});
$(".menu-system").each(function() {
	$(this).mouseover(function() {
		$(this).removeClass("active");

	})
	$(this).mouseover(function() {
		if ($(".changeAside").hasClass("changed")) {
			$(".menu-system dt").addClass("selected");
			$(this).css({
				paddingRight: "190px",
				background: "#f6f7f8",
			})
			$(this).find("dd").css({
				position: "absolute",
				display: "block",
				left: "50px",
				width: "140px",
				background: "#f6f7f8",
			})
			$(this).find("dt").css({
				background: "#f6f7f8",
			})
			$(this).find(".t2").css({
				position: "absolute",
				display: "block",
				width: "100px",
				left: "70px",
				background: "#f6f7f8",
			})
			$(".Hui-aside .menu_dropdown dd li a").css({
				paddingLeft: "25px",
			})
			$(".Hui-aside .menu_dropdown dd ul").css("padding", 0)
		}

	})
	$(this).mouseout(function() {
		if ($(".changeAside").hasClass("changed")) {
			$(".menu-system dt").removeClass("selected");
			$(this).find("dd").css({
				position: "static",
				display: "none",
				left: "50px",
				width: "200px",
				background: "#fff",
			})
			$(this).css({
				paddingRight: "0px",
				background: "#fff",
			})
			$(this).find("dt").css({
				background: "#fff",
			})
			$(this).find(".t2").css({
				position: "static",
				display: "none",
				width: "130px",
				left: "40px",
				background: "#fff",
			})
			$(".Hui-aside .menu_dropdown dd li a").css({
				paddingLeft: "52px",
			})
			$(".Hui-aside .menu_dropdown dd ul").css("padding", "3px,8px")
		}

	})
})
$(".changeColor li a").each(function() {
	$(this).mouseover(function() {
		$(this).css("backgroundColor", $(this).attr("data-color"));
		$(this).css("color", "#fff");
	})
	$(this).mouseout(function() {
		$(this).css("backgroundColor", "#fff");
		$(this).css("color", "#000");
	})
	$(this).click(function () {
		let data_color = $(this).attr('data-color')
		window.localStorage.setItem('theme_color', data_color)
	})
})
$(".sysBtn li a").each(function() {
	$(this).mouseover(function() {
		$(this).find("img").eq(0).hide();
		$(this).find("img").eq(1).show();
	})
	$(this).mouseout(function() {
		$(this).find("img").eq(1).hide();
		$(this).find("img").eq(0).show();
	})
})
$(".sysBtn li a").eq(0).click(function() {
	$("#changePassword").show();
	$("[name=oldPW]").val("");
	$("[name=newPW]").val("");
	$("[name=curNewPW]").val("");
})
$(".chang_click").click(function() {
	$(".jbxx_div").hide()
})

$(".coljks").click(function() {
	$(".jbxx_div").hide()
})

$(".sysBtn li a").eq(1).click(function() {
	if (data1.portrait) {
		$("[name=portrait]").attr("src", data1.portrait)
	}
	if (data1.nickname) {
		$("[name=name]").val(data1.nickname)
	}
	if (data1.tel) {
		$("[name=tel]").val(data1.tel)
	}
	$("[name=sex]").eq(data1.sex - 1).prop("checked", true);
	if (data1.birthday) {
		let birthday1 = data1.birthday.split("-");
		// if ($("#select1").val() == "1918" && $("#select2").val() == '1' && $("#select3").val() == "1") {
		$("#select1").val(birthday1[0]);
		$("#select2").val(birthday1[1]);
		$("#select3").val(birthday1[2]);
		// }
	}
	if (data1.logo) {
		$("[name=logo]").attr("src", data1.logo)
	}
	if ($("[name=shop_name]").val().length == 0) {
		$("[name=shop_name]").val(data1.shop_name)
	}
	if ($("[name=shop_range]").val().length == 0) {
		$("[name=shop_range]").val(data1.shop_range)
	}
	if ($("[name=shop_information]").val().length == 0) {
		$("[name=shop_information]").val(data1.shop_information)
	}
	$.ajax({
		type: "post",
		url: "index.php?module=AdminLogin&action=maskContent",
		async: true,
		dataType: "json",
		success: function(data) {
			data1 = data.re[0];
			$("#nickname1").html(data1.nickname);
		},
		error: function(res) {
			$(".dc").hide();
			let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
			ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
		}
	});
	$("#jbxx").show();

})
$(".closeA").on("portrait", function() {
	$(this).find("img").attr("src", "images/icon1/gb_h.png");
})
$(".closeA").on("mouseout", function() {
	$(this).find("img").attr("src", "images/icon1/gb.png");
})

function closeMask_p1(id, url, content) {
	$.ajax({
		type: "post",
		url: url + id,
		dataType: "json",
		data: {},
		async: true,
		success: function(data) {
			$(".maskNew").remove();
			console.log(data.status)
			if (data.suc) {
				layer.msg(data.status);
				let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
				ifs.location.href = history.go(-1);
			} else {
				layer.msg(data.status);
			}
		},
		error: function(err) {
			$(".maskNew").remove();
			layer.msg(err + "未知错误，请求失败！");
		}

	});
}

function closeMask__1(id, url, content) {
	$.ajax({
		type: "post",
		url: url + id,
		dataType: "json",
		data: {},
		async: true,
		success: function(res) {
			$(".maskNew").remove();
			if(res.code){
				console.log(1111)
				console.log(res)
				layer.msg(res.Message);
				if(res.code == 200){
					let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
					ifs.location.reload();
				}
				return
			}
			if (res.status == "1") {
				console.log("res.status == 1");
				layer.msg(res.info);
				let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
				ifs.location.reload();
			} else if (res.status == "2") {
				layer.msg(res.info);
			} else {
				console.log("else");
				layer.msg(res.info);
			}
		},
		error: function(err) {
			$(".maskNew").remove();
			layer.msg(err + "未知错误，请求失败！");
		}

	});
}

// 提示框确定（轮播图、店铺、签到、满减）
function closeMask(id, url, content,num) {
	$.ajax({
		type: "post",
		url: url + id,
		dataType: "json",
		data: {},
		async: true,
		success: function(res) {
			$(".maskNew").remove();
			if (res.status == "1") {
				layer.msg(content + "成功!");
				let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
				if(num){
                    var arr = ifs.location.href;
                    var arr0 = arr.split("&");
                    var ifs0 = '';
                    for (var k in arr0)
					{
                        var arr1 = arr0[k].split("=");
						if(arr1[0] == 'page'){
							if(Number(arr1[1]) > 1){
                                var arr2 = Number(arr1[1]) - 1;
                                ifs0 += 'page=' + arr2 + '&';
							}else{
                                ifs0 += 'page=1' + '&';
							}
						}else{
                            ifs0 += arr0[k] + '&';
						}
					}
                    ifs0 = ifs0.substr(0, ifs0.length - 1);

                    if(num <= 1)
                    {
                        ifs.location.href = ifs0;
                    }
                } else{
                    ifs.location.reload();
				}
			} else if (res.status == "2") {
				layer.msg(res.info);
			} else {
                if(typeof res.info != 'undefined'){
                    layer.msg(res.info);
				}
				else
				{
                    layer.msg(content + "失败!");
                }
			}
		},
		error: function(err) {
			$(".maskNew").remove();
			layer.msg(err + "未知错误，请求失败！");
		}

	});
}

// 提示框点确定跳转到相应页面
function confirm_modify_close(url) {
	$(".maskNew").remove();
	let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
	ifs.location.href = url;
}

function closeMaskPP(id, url, del_str, content,num) { //商品删除ajax请求，跳转相应页数
	del_str = JSON.parse(del_str);
    if(num == 1)
    {
        del_str.page = del_str.page - 1;
    }
	$('body').append(
		`<div id="removeTips" style="position: fixed;z-index: 9999999;display:flex;align-items: center;justify-content: center;top:0;bottom:0;left:0;right:0">
				<p style="background: rgba(0,0,0,0.6);color:#ffffff;width: 140px; height: 40px; line-height: 40px; text-align: center; margin-top: -100px; border-radius: 4px;">正在删除中...</p>
			</div>`
	)
	$.ajax({
		type: "post",
		url: url + id,
		dataType: "json",
		data: {},
		async: true,
		success: function(res) {
			$(".maskNew").remove();
			$("#removeTips").remove();
			if (res.code == 200) {
				layer.msg(content + "成功!");
				let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
				ifs.location.reload();
				ifs.location.href = 'index.php?module=product&action=Index&cid=' + del_str.cid + '&brand_id=' + del_str.brand_id +
					'&status=' + status + '&s_type=' + '&product_title=' + del_str.product_title + '&show_adr=' + del_str.show_adr +
					'&page=' + del_str.page + '&pagesize=' + del_str.pagesize
			} else if (res.code == "2") {
				layer.msg(res.Message);
			} else {
				layer.msg(content + "失败!");
			}
		},
		error: function(err) {
			$(".maskNew").remove();
			$("#removeTips").remove();
			layer.msg(err + "未知错误，请求失败！");
		}

	});
}

function closeMaskPC(id, url, del_str, content,num) { //商品分类删除ajax请求，跳转相应页数
	del_str = JSON.parse(del_str);
    if(num == 1)
	{
        del_str.page = del_str.page - 1;
	}
    $.ajax({
		type: "post",
		url: url + id,
		dataType: "json",
		data: {},
		async: true,
		success: function(res) {
			$(".maskNew").remove();
            console.log(res.status)
			if (res.status == "1") {
				layer.msg(content + "成功!");
				let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
				ifs.location.reload();
				ifs.location.href = 'index.php?module=product_class&action=Index&cid=' + del_str.cid + '&pname=' + del_str.pname +
					'&pagesize=' + del_str.pagesize + '&page=' + del_str.page
			} else if (res.status == "2") {
				layer.msg(res.info);
			} else {
				layer.msg(content + "失败!");
			}
		},
		error: function(err) {
			$(".maskNew").remove();
			layer.msg(err + "未知错误，请求失败！");
		}

	});
}

function closeMaskThird(id, url, content) { //第三方授权弹框
	$.ajax({
		type: "post",
		url: url + id,
		dataType: "json",
		data: {},
		async: true,
		success: function(res) {
			$(".maskNew").remove();
			if (res.status == "1") {
				layer.msg(content + "成功!");
				let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
				ifs.location.href = 'index.php?module=third&action=Auth';
				// ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
			} else if (res.status == "2") {
				layer.msg(res.info);
			} else {
				layer.msg(content + "失败!");
			}
		},
		error: function(err) {
			$(".maskNew").remove();
			layer.msg(err + "未知错误，请求失败！");
		}

	});
}

function closeMaskaa(id, url, content) {
	$.ajax({
		type: "get",
		url: url + id,
		dataType: "json",
		async: true,
		success: function(res) {
			$(".maskNew").remove();
			console.log(res.status)
			if (res.status == "1") {
				layer.msg(content + "成功!");
				let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
				ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
			} else if (res.status == "2") {
				layer.msg(res.info);
			} else {
				layer.msg(content + "失败!");
			}
		},
		error: function(err) {
			$(".maskNew").remove();
			layer.msg(err + "未知错误，请求失败！");
		}

	});
}

function closeMask1() {
	$(".maskNew").remove();
}

function closeMask1_1(pagetype) {
	console.log(pagetype)
	$(".maskNew").remove();
	let src = $(".show_iframe").eq(0).find("iframe").attr("src")+'&type='+pagetype
	console.log(src)
	ifs.location.href = src
	// let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
	// ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
}

// 管理员启用禁用
function closeMask2(id, content, url) {
	$(".maskNew").remove();
	$.ajax({
		type: "post",
		url: url + id,
		async: true,
		dataType: "json",
		success: function(res) {
			if (content == "启用") {
				if (res.status == 1) {
					layer.msg("启用成功!");
					let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
					ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
				} else {
					layer.msg("启用失败!");
				}
			} else {
				if (res.status == 1) {
					layer.msg("禁用成功!");
					let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
					ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
				} else if (res.status == 2) {
					layer.msg("该品牌正在使用，不允禁用!");
				} else {
					layer.msg("禁用失败!");
				}
			}
		},
		error: function(res) {
			$(".dc").hide();
			layer.msg('您没有该权限！');
			let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
			ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
		}
	});
}

function closeMask3(id, type, url) {
	$.ajax({
		type: "post",
		url: url + id + '&type=' + type,
		async: true,
		dataType: "json",
		success: function(res) {
			$(".maskNew").remove();
			localStorage.setItem("id_list", '');
			layer.msg(res.Message);
			let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
			ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
		},
		error: function(res) {
			$(".dc").hide();
			layer.msg('您没有该权限！');
			let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
			ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
		}
	});
}

var play = true;

// 提现申请通过
function closeMask4(m, id, user_id, money, s_charge, url, furl) {
	if (!play) {
		return;
	}
	play = false;
	$.get(url, {
		'm': m,
		'id': id,
		'user_id': user_id,
		'money': money,
		's_charge': s_charge
	}, function(res) {
		$(".maskNew").remove();
		play = true;
		if (res == "1") {
			// layer.msg("操作成功!2");
			let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
			ifs.location.reload()
		} else {
			layer.msg("操作失败!");
		}
	}, "json").error(function() {
		$(".maskNew").remove();
		play = true;
		layer.msg("操作失败!");
	});
}

// 提现申请拒绝
function closeMask4_1(m, id, user_id, money, s_charge, url, furl, that) {
	if (!play) {
		return;
	}
	play = false;
	if (!$(that).prop('flag')) {
		$(that).prop('flag', true)
		var reason = $("[name=jujue]").val()

		if (!reason) {
			play = true
			layer.msg("拒绝原因不能为空!");
			return
		}
		$.get(url, {
			'm': m,
			'id': id,
			'user_id': user_id,
			'money': money,
			's_charge': s_charge,
			'reason': reason,

		}, function(res) {
			$(".maskNew").remove();
			play = true;
			if (res == "1") {
				layer.msg("操作成功!");
				let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
				console.log($(ifs).find('.swivch_active').attr('href'))
				ifs.location.reload()
			} else {
				layer.msg("操作失败!");
			}
		}, "json").error(function() {
			$(".maskNew").remove();
			play = true;
			layer.msg("操作失败!");
		});
	}
}

// 商品审核
function closeMask4_2(id, mch_status, url) {
	var reason = $("[name=jujue]").val()

	if (!reason) {
		layer.msg('拒绝原因不能为空！')
		return
	}

	$.get(url, {
		'id': id,
		'mch_status': mch_status,
		'reason': reason,
	}, function(res) {
		$(".maskNew").remove();
		if (res == "1") {
			layer.msg("操作成功!");
			let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
			ifs.location.href = $(ifs).find('.swivch_active').attr('href');
		} else {
			layer.msg("操作失败!");
		}
	}, "json").error(function() {
		$(".maskNew").remove();
		layer.msg("操作失败!");
	});

}

function closeMask_1(id, url, type, pagetype) {
	$.ajax({
		type: "get",
		url: url + id,
		async: true,
		dataType: "json",
		success: function(res) {
			$(".maskNew").remove();
			let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
			let y_is_default = ifs.getElementsByName("is_default");

			if (res.status == "1") {
				if (type == 1) {
					console.log($(ifs).find("#is_default_" + id))
					$(ifs).find("#is_default_" + id).attr("checked", false);
				} else {
					// TODO 可能有问题，之前没有传就删了
					// $(ifs).find("#is_default_" + y_id).attr("checked", false);
					$(ifs).find("#is_default_" + id).attr("checked", true);
				}
				layer.msg("修改成功!");
				let src = $(".show_iframe").eq(0).find("iframe").attr("src")+'&type='+pagetype
				console.log(src)
				ifs.location.href = src
			} else {
				layer.msg("修改失败!");
			}
		},
		error: function(res) {
			$(".dc").hide();
			layer.msg('您没有该权限！');
			let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
			ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
		}
	});
};

function closeMask12() {
	$(".maskNew").remove();
	let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
	ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
}

// 删除管理员日志
function closeMask13(type, Id) {
	$.get("index.php?module=member&action=MemberRecordDel", {
		'id': Id,
		'type': type
	}, function(res) {
		$(".maskNew").remove();
		if (res.status == "1") {
			layer.msg("删除成功!");
			let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
			ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
		} else {
			layer.msg("删除失败!");
		}
	}, "json");
}

function closeMask14(type, id) {
	$.ajax({
		type: "GET",
		url: 'index.php?module=twelve_draw&action=listdel',
		data: "m=" + type + "&id=" + id,
		dataType: 'json',
		success: function(msg) {
			layer.msg(msg.status);
			if (msg.suc) {
				location.href = "index.php?module=twelve_draw";
			}
		},
		error: function(res) {
			$(".dc").hide();
			layer.msg('您没有该权限！');
			let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
			ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
		}
	});
}

function dc() {
	$(".dc").hide();
}

function show_dc() {
	console.log("show_dc")
	$(".dc").show();
}

// 设置默认(运费)
function closeMask_is_default(id, url, type, pagetype) {
    $.ajax({
        type: "get",
        url: url + id,
        async: true,
        dataType: "json",
        success: function(res) {
            $(".maskNew").remove();
            let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
            let y_is_default = ifs.getElementsByName("is_default");

            if (res.code == "200") {
                if (type == 1) {
                    console.log($(ifs).find("#is_default_" + id))
                    $(ifs).find("#is_default_" + id).attr("checked", false);
                } else {
                    // TODO 可能有问题，之前没有传就删了
                    $(ifs).find("#is_default_" + id).attr("checked", true);
                }
                layer.msg(res.Message);
                let src = $(".show_iframe").eq(0).find("iframe").attr("src")+'&type='+pagetype
                ifs.location.href = src
            } else {
                layer.msg(res.Message);
            }
        },
        error: function(res) {
            $(".dc").hide();
            layer.msg('您没有该权限！');
            let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
            ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
        }
    });
};

// 提示框确定（运费）
function closeMask_del(id, url, content) {
    $.ajax({
        type: "post",
        url: url + id,
        dataType: "json",
        data: {},
        async: true,
        success: function(res) {
            $(".maskNew").remove();
            if (res.code == "200") {
                layer.msg(content + "成功!");
                let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                ifs.location.reload();
            } else if (res.status == "2") {
                layer.msg(res.Message);
            } else {
                layer.msg(content + "失败!");
            }
        },
        error: function(err) {
            $(".maskNew").remove();
            layer.msg(err + "未知错误，请求失败！");
        }
    });
}

/**
 * 判断发货选择类型
 */
function isType() {
	if (radioType === 1) {
		return '#kuaidi1'
	}
	return '#kuaidi2'
}

function qd(url, type) {

	var res = isType()

	let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
	let id = $('.order_id').val(); // 订单号
	let oid = $('.oid').val(); // 订单号

	let express = $(res).val(); // 快递公司id

	let express_name = $(res).find("option:selected").text(); // 快递公司名称
	let courier_num = $('input[name=danhao]').val(); // 快递单号

	let otype = $(".otype").val(); // 类型
	let data;

	if (type == 1 || type == 3) {
		data = {
			id: id,
			trade: 3,
			express: express,
			courier_num: courier_num,
			otype: otype,
			express_name: express_name,
			express_type: radioType
		};
	} else if (type == 2) {
		data = {
			id: id,
			express: express,
			courier_num: courier_num,
			express_name: express_name,
			express_type: radioType
		};
	}

	$.ajax({
		url: url,
		type: "post",
		data: data,
		dataType: "json",
		success: function(data) {
			console.log(data)
			if (data.code == 200) {
				layer.msg(data.Message);
				setTimeout(function() {
					let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
					ifs.location.href = 'index.php?module=orderslist&action=Detail&id=' + oid;
				}, 1000)
			} else {
				layer.msg(data.err ? data.err : data.Message);
			}
			$(".dc").hide();
			$("#makeInput").val("");
			$(".ipt1").val("")
		},
		error: function(res) {
			layer.msg('发货失败！');
			setTimeout(function() {
				let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
				ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
			}, 1000)
		}
	});
	// radioType = 1
};

function qd_(url, type) {
	console.log(22222)
	let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
	let id = $('.order_id').val(); // 订单号
	let oid = $('.oid').val(); // 订单号
	let express = $('select[name=kuaidi]').val(); // 快递公司id
	let express_name = $('select[name=kuaidi]').find("option:selected").text(); // 快递公司名称
	let courier_num = $('input[name=danhao_]').val(); // 快递单号
	let otype = $(".otype").val(); // 类型
	let data;
	if (type == 1 || type == 3) {
		data = {
			id: id,
			trade: 3,
			express: express,
			courier_num: courier_num,
			otype: otype,
			express_name: express_name
		};
	} else if (type == 2) {
		data = {
			id: id,
			express: express,
			courier_num: courier_num,
			express_name: express_name
		};
	}
	$.ajax({
		url: url,
		type: "post",
		data: data,
		dataType: "json",
		success: function(data) {
			if (data.code == 200) {
				layer.msg(data.Message);
				setTimeout(function() {
					let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
					ifs.location.href = 'index.php?module=orderslist&action=Detail&id=' + oid;
				}, 1000)
			} else {
				layer.msg(data.Message);
			}
			$(".dc").hide();
			$("#makeInput").val("");
			$(".ipt1").val("")
		},
		error: function(res) {
			layer.msg('发货失败！');
			setTimeout(function() {
				let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
				ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
			}, 1000)
		}
	});
};

function stock_add(url, id, pid, type) {
	var add_num = $("#add_num").val();
	var total_num = $("#total_num").val();
	var num = $("#num").val();
	$.ajax({
		cache: true,
		type: "POST",
		dataType: "json",
		url: url,
		data: {
			id: id,
			pid: pid,
			add_num: add_num,
			total_num: total_num,
			num: num,
		},
		async: true,
		success: function(data) {
			$(".maskNew").hide();
			$("#stock").remove();
			layer.msg(data.status, {
				time: 2000
			});
			if (data.suc) {
				let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
				if (type == 1) {
					ifs.location.href = 'index.php?module=stock';
				} else {
					ifs.location.href = 'index.php?module=stock&action=Warning';
				}
			}
		}
	});
}

/* 查询分类品牌联动开始 */
// 点击分类框
var selectFlag = true //判断点击分类框请求有没有完成,没完成继续点击不会再次请求
var choose_class = true //判断选择分类请求有没有完成,没完成继续点击不会再次请求
function select_class() {
	var class_str = $('.selectDiv option').val()
	var brand_str = $("#brand_class option:selected").val();
	if ($('#selectData').css('display') == 'none') {
		$('#selectData').css('display', 'flex')

		if (selectFlag && choose_class) {
			selectFlag = false
			$.ajax({
				type: "GET",
				url: 'index.php?module=product&action=Ajax',
				data: {
					'class_str': class_str,
					'brand_str': brand_str
				},
				success: function(msg) {
					$('#selectData_1').empty()
					obj = JSON.parse(msg)
					var brand_list = obj.brand_list
					var class_list = obj.class_list
					var rew = '';
					if (class_list.length != 0) {
						var num = class_list.length - 1;
						display(class_list[num])
					}


					if ($("[name=product_class]").val() && $("[name=product_class]").val() > 0) {
						$('#brand_class').empty()
						for (var i = 0; i < brand_list.length; i++) {
							if (brand_list[i].status == true) {
								rew += `<option selected value="${brand_list[i].brand_id}">${brand_list[i].brand_name}</option>`;
							} else {
								rew += `<option value="${brand_list[i].brand_id}">${brand_list[i].brand_name}</option>`;
							}
						}
						$('#brand_class').append(rew)
					}
				},
				complete(XHR, TS) {
					// 无论请求成功还是失败,都要把判断条件改回去
					selectFlag = true
				}
			});
		}
	} else {
		$('#selectData').css('display', 'none')
	}
}

// 选择分类
function class_level(obj, level, cid, type) {
	var text = obj.innerHTML
	var text_num = $('.selectDiv>div>p').length

	$('.selectDiv option').text('').attr('value', cid)

	$(obj).addClass('active').siblings().removeClass('active')
	var brand_str = $("#brand_class option:selected").val();
	// 给当前元素添加class，清除同级别class
	// 获取ul标签数量
	var num = $("#selectData ul").length;
	if (selectFlag && choose_class) {
		choose_class = false
		$.ajax({
			type: "POST",
			url: 'index.php?module=product&action=Ajax',
			data: {
				"cid": cid,
				"brand_str": brand_str,
			},
			success: function(msg) {
				$('#brand_class').empty()
				$('#selectData_1').empty()
				res = JSON.parse(msg)
				var class_list = res.class_list
				var brand_list = res.brand_list
				var rew = '';
				var html = $('.selectDiv>div').html().replace(/^\s*|\s*$/g, ""); // 去除字符串内两头的空格

				if (type == '') {
					if (text_num - 2 == level) {
						var text_num1 = text_num - 1;
						var parent = document.getElementById("div_text");
						var son0 = document.getElementById("p" + text_num);
						var son1 = document.getElementById("p" + text_num1);
						parent.removeChild(son0);
						parent.removeChild(son1);
						if (class_list.length == 0) { // 该分类没有下级
							if (html == '') {
								str =
									`<p class='selectItem' id='p1' tyid='${cid}' onclick='del_sel(this,${level},${cid})'>${text}</p><p class='selectItem del_sel' id='p2' onclick='del_sel(this)'></p>`
							} else {
								$('.del_sel').remove()
								str =
									`<p class='selectItem' id="p${text_num1}" tyid='${cid}' onclick='del_sel(this,${level},${cid})'><span>&gt;</span>${text}</p><p class='selectItem del_sel' id='p${text_num1 + 1}' onclick='del_sel(this)'></p>`
							}
							$('#selectData').css('display', 'none')
						} else {
							display(class_list[0])
							if (html == '') {
								str =
									`<p class='selectItem' id='p1' tyid='${cid}' onclick='del_sel(this,${level},${cid})'>${text}</p><p class='selectItem del_sel' id='p2' onclick='del_sel(this)'><span>&gt;</span>请选择</p>`
							} else {
								$('.del_sel').remove()
								str =
									`<p class='selectItem' id="p${text_num1}" tyid='${cid}' onclick='del_sel(this,${level},${cid})'><span>&gt;</span>${text}</p><p class='selectItem del_sel' id="p${text_num1 + 1}" onclick='del_sel(this)'><span>&gt;</span>请选择</p>`
							}
						}
					} else {
						if (class_list.length == 0) { // 该分类没有下级
							if (html == '') {
								str =
									`<p class='selectItem' id='p1' tyid='${cid}' onclick='del_sel(this,${level},${cid})'>${text}</p><p class='selectItem del_sel' id='p2' onclick='del_sel(this)'></p>`
							} else {
								$('.del_sel').remove()
								str =
									`<p class='selectItem' id="p${text_num}" tyid='${cid}' onclick='del_sel(this,${level},${cid})'><span>&gt;</span>${text}</p><p class='selectItem del_sel' id='p${text_num + 1}' onclick='del_sel(this)'></p>`
							}
							$('#selectData').css('display', 'none')
						} else {
							display(class_list[0])
							if (html == '') {
								str =
									`<p class='selectItem' id='p1' tyid='${cid}' onclick='del_sel(this,${level},${cid})'>${text}</p><p class='selectItem del_sel' id='p2' onclick='del_sel(this)'><span>&gt;</span>请选择</p>`
							} else {
								$('.del_sel').remove()
								str =
									`<p class='selectItem' id="p${text_num}" tyid='${cid}' onclick='del_sel(this,${level},${cid})'><span>&gt;</span>${text}</p><p class='selectItem del_sel' id="p${text_num + 1}" onclick='del_sel(this)'><span>&gt;</span>请选择</p>`
							}
						}
					}
					$('.selectDiv>div').append(str)
				} else {
					display(class_list[0])
				}

				for (var i = 0; i < brand_list.length; i++) {
					if (brand_list[i].status == true) {
						rew += `<option selected value="${brand_list[i].brand_id}">${brand_list[i].brand_name}</option>`;
					} else {
						rew += `<option value="${brand_list[i].brand_id}">${brand_list[i].brand_name}</option>`;
					}
				}
				$('#brand_class').append(rew)
			},
			complete(XHR, TS) {
				// 无论请求成功还是失败,都要把判断条件改回去
				choose_class = true
			}
		});
	}
}

// 显示分类
function display(class_list) {
	var res = '';
	for (var i = 0; i < class_list.length; i++) {
		if (class_list[i].status == true) {
			res +=
				`<li class='active' value='${class_list[i].cid}' onclick="class_level(this,${class_list[i].level},${class_list[i].cid},'')">${class_list[i].pname}</li>`;
			continue
		}
		res +=
			`<li value='${class_list[i].cid}' onclick="class_level(this,${class_list[i].level},${class_list[i].cid},'')">${class_list[i].pname}</li>`;
	}
	$('#selectData_1').append(res)
}

// 删除选中的类别
function del_sel(me, level, cid) {
	if (cid) {
		if (level == 0) {
			var cid1 = 0;
			class_level(me, level, cid1, 'type')
		} else {
			var cid1 = $('#p' + level).eq(0).attr('tyid');
			class_level(me, level - 1, cid1, 'type')
		}
		$(me).nextAll().remove()
		$(me).remove()
		if ($('.selectDiv>div').html() == '') {
			$('.selectDiv option').text('请选择商品类别').attr('value', 0)
		} else {
			if (cid1 == 0) {
				$('.selectDiv option').text('请选择商品类别').attr('value', cid1)
			} else {
				$('.selectDiv option').text('').attr('value', cid1)
				$('.selectDiv>div').append(`<p class='selectItem del_sel' onclick='del_sel(this)'><span>&gt;</span>请选择</p>`)
			}
		}
		if (level) {
			event.stopPropagation()
		}
	}
}

function select_pinpai() {
	var class_str = $("[name=product_class]").val();
	if (class_str == '' || class_str <= 0) {
		layer.msg("请先选择商品类别！", {
			time: 2000
		});
	}
}

/* 查询分类品牌联动结束 */

/* 满减开始 */

// 店铺-调用子页面方法
function range_del_confirm(range) {
	var childWin = $("body").find("iframe[id=subtraction]")[0].contentWindow;
	childWin.confirm_range_del(range);
	$(".maskNew").remove();
}

// 查询商品
function chaxun(obj) {
	var cid = $("#cid").val();
	var brand_id = $("#brand_class").val();
	var product_title = $("#product_title").val();
	$(obj).attr("disabled", true);
	$("#product_list1").empty();
	$.ajax({
		cache: true,
		type: "GET",
		dataType: "json",
		url: 'index.php?module=subtraction&action=Config&m=chaxun',
		data: {
			class_id: cid,
			brand_class_id: brand_id,
			title: product_title
		},
		async: true,
		success: function(data) {
			if (data.product_list == '' || data.product_list == 'undefined') {
				layer.msg('查无此商品', {
					time: 1000
				});
			} else {
				var res = '<div class="tab_table" style="height: auto;">' +
					'<table class="table-border tab_content" style="border: 1px solid #E9ECEF;">' +
					'   <thead>' +
					'       <tr class="text-c tab_tr" style="height: 50px;">' +
					'           <th width="40" style="padding: 9px 10px!important;">' +
					'               <div style="position: relative;display: flex;height: 30px;align-items: center;">' +
					'                   <input name="ipt1" id="ipt1" type="checkbox" value="" class="inputC" >' +
					'                   <label for="ipt1" onclick="quanxuan()"></label>' +
					'                   <span >全选</span>' +
					'               </div>' +
					'           </th>' +
					'           <th  colspan="2" style="padding: 9px 10px!important;">商品名称</th>' +
					'           <th style="padding: 9px 10px!important;">店铺</th>' +
					'           <th style="padding: 9px 10px!important;">价格</th>' +
					'           <th style="padding: 9px 10px!important;">库存</th>' +
					'       </tr>' +
					'   </thead>' +
					'   <tbody>';
				if (data.product_list.length != 0) {
					product_list = data.product_list;
					for (var k in product_list) {
						res +=
							`<tr class="text-c tab_td" >
	                                <td style="height: 59px;">
	                                    <div style="display: flex;align-items: center;height: 60px;">
	                                        <input name="product[]"  id="${product_list[k]['id']}" type="checkbox" class="inputC product" value="${product_list[k]['id']}">
	                                        <label for="${product_list[k]['id']}"></label>
	                                    </div>
	                                </td>
	
	                               <td style="width: 80px;height: 59px;" >
	                                   <img src="${product_list[k]['imgurl']}" style="width: 42px;height: 42px;">
	                               </td>
	                               <td style="text-align: left;height: 59px;">
	                                   <text>${product_list[k]['product_title']}</text>
	                               </td>
	                               <td style="height: 59px;">${product_list[k]['mch_name']}</td>
	                               <td style="height: 59px;">${product_list[k]['present_price']}</td>
	                               <td style="height: 59px;">${product_list[k]['num']}</td>
	                            </tr>`;
					}
					res += "</tbody>" +
						"</table>" +
						"</div>";

					pages_show = data.pages_show;
					res += `<div style="text-align: center;display: flex;justify-content: center;">${pages_show}</div>`;

					document.getElementById('queren').style.display = "";

					$("#product_list1").append(res);
					$(obj).attr("disabled", false);
				}
			}
		}
	});
}

// 选择商品页面跳转
function tiaozhuan(url) {
	$("#product_list1").empty();
	$.ajax({
		cache: true,
		type: "GET",
		dataType: "json",
		url: url,
		async: true,
		success: function(data) {
			var res = '<div class="tab_table" style="height: auto;">' +
				'<table class="table-border tab_content" style="border: 1px solid #E9ECEF;">' +
				'   <thead>' +
				'       <tr class="text-c tab_tr" style="height: 50px;">' +
				'           <th width="40" style="padding: 9px 10px!important;">' +
				'               <div style="position: relative;display: flex;height: 30px;align-items: center;">' +
				'                   <input name="ipt1" id="ipt1" type="checkbox" value="" class="inputC" >' +
				'                   <label for="ipt1" onclick="quanxuan()"></label>' +
				'                   <span >全选</span>' +
				'               </div>' +
				'           </th>' +
				'           <th  colspan="2" style="padding: 9px 10px!important;">商品名称</th>' +
				'           <th style="padding: 9px 10px!important;">店铺</th>' +
				'           <th style="padding: 9px 10px!important;">价格</th>' +
				'           <th style="padding: 9px 10px!important;">库存</th>' +
				'       </tr>' +
				'   </thead>' +
				'   <tbody>';
			if (data.product_list.length != 0) {
				product_list = data.product_list;
				for (var k in product_list) {
					res +=
						`<tr class="text-c tab_td" >
	                                <td style="height: 59px;">
	                                    <div style="display: flex;align-items: center;height: 60px;">
	                                        <input name="product[]"  id="${product_list[k]['id']}" type="checkbox" class="inputC product" value="${product_list[k]['id']}">
	                                        <label for="${product_list[k]['id']}"></label>
	                                    </div>
	                                </td>
	
	                               <td style="width: 80px;height: 59px;" >
	                                   <img src="${product_list[k]['imgurl']}" style="width: 42px;height: 42px;">
	                               </td>
	                               <td style="text-align: left;height: 59px;">
	                                   <text>${product_list[k]['product_title']}</text>
	                               </td>
	                               <td style="height: 59px;">${product_list[k]['mch_name']}</td>
	                               <td style="height: 59px;">${product_list[k]['present_price']}</td>
	                               <td style="height: 59px;">${product_list[k]['num']}</td>
	                            </tr>`;
				}
				res += "</tbody>" +
					"</table>" +
					"</div>";

				pages_show = data.pages_show;
				res += `<div style="text-align: center;display: flex;justify-content: center;">${pages_show}</div>`;
				$("#product_list1").append(res);
			}
			serch = false;
		}
	});
}

// 点击确认
function commodity_confirm() {
	var checkbox = $("input[name='product[]']:checked"); //被选中的复选框对象
	if (checkbox.length > 0) {
		$.each($("input[name='product[]']"), function(index, element) {
			if ($(element).prop('checked') == false) {
				$(element).parents('.protype1').remove();
			}
		});
		productid = '';
		for (var i = 0; i < checkbox.length; i++) {
			productid += checkbox.eq(i).val() + ",";
		}
	} else {
		layer.msg("请选择需要的商品");
		return false;
	}

	var childWin = $("body").find("iframe[id=subtraction]")[0].contentWindow;
	childWin.commodity_confirm(productid);
	$(".maskNew").remove();
}

// 全选
function quanxuan() {
	var checkbox = document.getElementById("ipt1").checked; //被选中的复选框对象
	var str = document.getElementsByClassName("product");
	if (checkbox == false) {
		for (var i = 0; i < str.length; i++) {
			//如果没有被选中
			if (!str[i].checked) {
				//改变选中框的属性，让它选中
				str[i].checked = true;
			}
		}
	} else {
		for (var i = 0; i < str.length; i++) {
			//如果没有被选中
			if (str[i].checked) {
				//改变选中框的属性，让它选中
				str[i].checked = false;
			}
		}
	}
}

// 店铺-调用子页面方法
function position_del_confirm(position) {
	var childWin = $("body").find("iframe[id=subtraction]")[0].contentWindow;
	childWin.confirm_position_del(position);
	$(".maskNew").remove();
}

// 全选
function sel_all() {
	if ($("#sex-all").get(0).checked) {
		//全选
		$("input[type='checkbox']").prop("checked", true);
	} else {
		//全不选
		$("input[type='checkbox']").prop("checked", false);
	}
}

// 选择地址
function add_address() {
	var obj = document.getElementsByName("list");
	var check_val = [];
	for (k in obj) {
		if (obj[k].checked)
			check_val.push(obj[k].value);
	}
	var childWin = $("body").find("iframe[id=subtraction]")[0].contentWindow;
	childWin.add_address(check_val);
	$(".maskNew").remove();
}

<!-- 满减结束 -->

// 除此管理员
function closeMask_role(id, url, content) {
	$.ajax({
		type: "GET",
		url: url + id,
		dataType: "json",
		async: true,
		success: function(res) {
			$(".maskNew").remove();
			if (res.status == "1") {
				layer.msg(content + "成功!");
				let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
				ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
			} else if (res.status == "2") {
				layer.msg(res.info);
			} else {
				layer.msg(content + "失败!");
			}
		},
		error: function(res) {
			$(".dc").hide();
			layer.msg('您没有该权限！');
			// location.replace(location.href);
			let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
			ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
		}
	});
}

function getData1() {
	var ifs1 = $(".show_iframe").eq(0).find("iframe")[0].contentWindow;
	window.ifs1 = ifs1;
}

function yesC() {
	var title = ifs1.arr1.title,
		content = ifs1.arr1.content,
		yestext = ifs1.arr1.yestext,
		notext = ifs1.arr1.notext,
		yesfn = ifs1.arr1.yesfn,
		nofn = ifs1.arr1.nofn,
		id = ifs1.arr1.id,
		url = ifs1.arr1.url,
		nolink = ifs1.arr1.nolink,
		yeslink = ifs1.arr1.yeslink,
		prompt = ifs1.arr1.prompt,
		click_bg = ifs1.arr1.click_bg,
		obj = ifs1.arr1.obj,
		type = ifs1.arr1.type,
		price = ifs1.arr1.price,
		price = Number(price);
	str = ifs1.arr1.str;
	td = ifs1.arr1.td;
	var price = Number($(".prompt-text").val());
	$.ajax({
		type: "GET",
		url: url,
		data: {
			user_id: id,
			m: type,
			price: price
		},
		success: function(res) {
			console.log(res)
			if (res == 1) {
				$(".maskNew").remove();
				layer.msg('提交成功');
				setTimeout(function() {
					let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
					ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
				}, 1000);
			} else {
				$(".maskNew").remove();
				layer.msg('操作失败!');
			}
		},
		error: function(res) {
			$(".dc").hide();
			layer.msg('您没有该权限！');
			let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
			ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
		}
	});
}

function yesB() {
	var title = ifs1.arr1.title,
		content = ifs1.arr1.content,
		yestext = ifs1.arr1.yestext,
		notext = ifs1.arr1.notext,
		yesfn = ifs1.arr1.yesfn,
		nofn = ifs1.arr1.nofn,
		id = ifs1.arr1.id,
		url = ifs1.arr1.url,
		nolink = ifs1.arr1.nolink,
		yeslink = ifs1.arr1.yeslink,
		prompt = ifs1.arr1.prompt,
		click_bg = ifs1.arr1.click_bg,
		obj = ifs1.arr1.obj,
		type = ifs1.arr1.type,
		price = ifs1.arr1.price,
		price = Number(price);
	str = ifs1.arr1.str;
	td = ifs1.arr1.td;
    if (type == 2 || type == 5 || type == 8) {
		var text = $(".prompt-text").val();
		if (text.length > 0) {
			$.ajax({
				type: "POST",
				url: url,
				data: "id=" + id + '&text=' + text + '&m=' + type,
				success: function(res) {
					console.log(res);
                    res = JSON.parse(res)
                    if (res.code == 200) {
                        td.html(str);
                        td.prev().html('<span style="color:#ff2a1f;">已拒绝</span>');
                        $(".maskNew").remove();
                        layer.msg(res.Message);
                        setTimeout(function() {
                            let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                            ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
                        }, 1000);
                    } else {
                        layer.msg(res.Message);
                    }
				},
				error: function(res) {
					$(".dc").hide();
					layer.msg('您没有该权限！');
					let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
					ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
				}
			});

		} else {
			layer.msg('拒绝理由不能为空!');
		}
	} else {
		var text = $(".prompt-text").val();
		if (type == 1 || type == 6) {
			$.ajax({
				type: "POST",
				url: url,
				data: "id=" + id + '&m=' + type,
				success: function(res) {
					console.log(res);
                    res = JSON.parse(res)
                    if (res.code == 200) {
                        td.html(str);
                        if (type == '4' || type == '9') {
                            var status = '<span style="color:#8FBC8F;">已退款</span>';
                        } else {
                            var status = '<span style="color:#A4D3EE;">待买家发货</span>';
                        }
                        td.prev().html('<span style="color:#30c02d;">' + status + '</span>');
                        $(".maskNew").remove();
                        layer.msg(res.Message);
                        setTimeout(function() {
                            let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                            ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
                        }, 1000);
                    } else {
                        layer.msg(res.Message);
                    }
				},
				error: function(res) {
					$(".dc").hide();
					layer.msg('您没有该权限！');
					let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
					ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
				}
			});
		} else {

			if ((Number(text) > 0 && Number(text) <= Number(price)) || !Number(price)) {
				$.ajax({
					type: "POST",
					url: url,
					data: "id=" + id + '&m=' + type + '&price=' + Number(text),
					success: function(res) {
                        res = JSON.parse(res)
                        if (res.code == 200) {
                            td.html(str);
                            if (type == '4' || type == '9') {
                                var status = '<span style="color:#8FBC8F;">已退款</span>';
                            } else {
                                var status = '<span style="color:#A4D3EE;">待买家发货</span>';
                            }
                            td.prev().html('<span style="color:#30c02d;">' + status + '</span>');
                            $(".maskNew").remove();
                            layer.msg(res.Message);
                            setTimeout(function() {
                                let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                                ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
                            }, 1000);
                        } else {
                            layer.msg(res.Message);
                        }
					},
					error: function(res) {
						$(".dc").hide();
						layer.msg('您没有该权限！');
						let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
						ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
					}
				});
			} else {
				layer.msg('输入金额有误,请重新输入2!');
			}

		}
	}

};
//循环执行，每隔30秒钟执行一次    ---------------------------验证登入----------------------------------------------
var t1 = window.setInterval(refreshCount, 30 * 1000);

// 修复禅道 9168，
function export_close1(url, type) {
	$("#pup_div").remove();

	if (type == '') {
		return
	}
	var src = url + '&pageto=' + type
	$('iframe').eq(0).attr("src", src)
}

function autoManage(id, url) {
	$.get("index.php?module=product&action=Shelves", {
		'id': id
	}, function(res) {
		$(".maskNew").remove();
		if (res.code == 200) {
			layer.msg(res.Message);
			intervalId = setInterval(function() {
				clearInterval(intervalId);
				// var src = $('#iframe_box iframe').eq(0).attr('src')
				console.log(url);
				$('#iframe_box iframe').eq(0).attr('src', url)
			}, 2000);
		} else {
			layer.msg(res.Message);
		}
	}, "json");
}
function toEdit1(id) {
	$(".maskNew").remove();
	$('#iframe_box iframe').eq(0).attr('src', 'index.php?module=auction&action=Modify&id=' + id)
}
function onload1() {
    setTimeout(function() {
        refreshCount();
    }, 600)
}
function refreshCount() {
    $.ajax({
        url: location.href,
        type: "post",
        data: {
            'm': 'check'
        },
        success: function(res) {
            var data = JSON.parse(res);
            console.log(data)
            console.log('====')
            var numB = 0;
            $(".msgNum1").each(function(i) {
            	if (Object.values(data.re)[i]) {
					$(this).text(Object.values(data.re)[i]);
					numB += Number(Object.values(data.re)[i]);
				}
            })
            $(".msgDiv1").each(function(i) {
                let numA = 0;
                $(this).parent().find(".msgNum1").each(function(i) {
                    numA += Number($(this).text());
                })

                if (numA > 99) {
                    numA = 99 + '+';
                }
                $(this).find(".msgNum").text(numA);
            })

			console.log('numB', numB);

			if (numB > 99) {
                numB = 99 + '+';
            }
            $("#tatalNum").text(numB);

            /*
            if (data.status == 1) {
                window.clearInterval(t1);
                alert('您的账户已被锁定，请联系客服！');
                parent.location.href = 'index.php?module=Login&action=Logout';
            }
            if(data.code == 1) {
                window.clearInterval(t1);
                parent.location.href='index.php?module=Login&action=Logout';
            }else if(data.code == 2){
                window.clearInterval(t1);
                parent.location.href='index.php?module=Login&action=Logout&logout_status=1&admin_id='+admin_id;
                // location.href='index.php?module=Login&action=Index&logout_status=1';
                // alert('您的账户在其他地方登入，您被迫下线！'); parent.location.href='index.php?module=Login&action=logout';
            }else{

            }
            */
        },
        error: function(res) {
            $(".dc").hide();
            let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
            ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
        }
    });
}
