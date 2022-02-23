var del_str = JSON.parse($('#a-del_str').html())
$(document).on('click', '#unit', function() {
	var unit = $("#unit").val();
	page.unit = $("#unit").val();
	$(".unit").val(unit);
});
$(function() {
    if($("#status").val() != 1){
        $('.inputC1').attr("disabled", true);
		$('.inputC1+label').css('color','#D5DBE8')
		$('.inputC1:checked+label').css('color','#292B2C')
    }
	$('#div_text').append(`<p class="selectItem del_sel" id="p${$('#div_text>p').length+1}" onclick="del_sel(this)"></p>`)
	
	
	// 活动类型检测
	active_select('', 1);
	$("#imgurls").change(function() {
		var files = this.files;
		if (files && files.length > 5) {
			layer.msg("超过5张");
			this.value = "" //删除选择
		}
	});
	//富文本编辑器
	var ue = UE.getEditor('editor');
	//分销显示
	if ($("input[name='active']:checked").val() == 1) {
		$("#show_adr").show();
		$("#xd_fx").hide();
	} else if ($("input[name='active']:checked").val() == 5) {
		$("#show_adr").hide();
		$("#xd_fx").show();
	} else {
		$("#show_adr").hide();
		$("#xd_fx").hide();
	}
	//看是否能修改'支持活动类型'
	var active = $("#active").val();
	var id = $("#id").val();
	$.ajax({
		cache: true,
		type: "POST",
		dataType: "json",
		url: 'index.php?module=product&action=Shelves&id=' + id,
		data: {},
		async: true,
		success: function(data) {
			// 如果不能修改
			if (data.status == 2) {
                // 将默认类型选中
				$("#active-" + active).prop("checked", "checked");
				// 其他类型 使其无法选中 颜色变浅
				var arr = $("input[name='active'][type='radio']")
				for (var i = 0; i < arr.length; i++) {
					if (arr[i].id != "active-" + active) {
						$("#" + arr[i].id).prop("disabled", "disabled")
						var lab = $("#" + arr[i].id).nextAll()
						lab.css("opacity", "0.6")
					}
				}
			}
		}
	});
})

//控制价格显示小数点2位
function noNumbers(e) {
	var keynum
	var keychar
	var numcheck
	if (window.event) // IE
	{
		keynum = e.keyCode
	} else if (e.which) // Netscape/Firefox/Opera
	{
		keynum = e.which
	}
	keychar = String.fromCharCode(keynum);
	//判断是数字,且小数点后面只保留两位小数
	if (!isNaN(keychar)) {
		var index = e.currentTarget.value.indexOf(".");
		if (index >= 0 && e.currentTarget.value.length - index > 2) {
			return false;
		}
		return true;
	}
	//如果是小数点 但不能出现多个 且第一位不能是小数点
	if ("." == keychar) {
		if (e.currentTarget.value == "") {
			return false;
		}
		if (e.currentTarget.value.indexOf(".") >= 0) {
			return false;
		}
		return true;
	}
	return false;
}

// 选择类型
function active_select(obj, obj1) {
	var as = $(obj).val();
	var active = $("#active").val();
	if (obj1) {
		if (as == 1) {
			$("#show_adr").show();
			$("#xd_fx").hide();
		} else if (as == 5) {
			$("#show_adr").hide();
			$("#xd_fx").show();
		} else {
			$("#show_adr").hide();
			$("#xd_fx").hide();
			$("#xd_fx").find(".select").val(0);
		}
	} else {
		if (as == 1) {
			$("#show_adr").show();
			$("#xd_fx").hide();
		} else if (as == 5) {
			$("#show_adr").hide();
			$("#xd_fx").show();
		} else {
			$("#show_adr").hide();
			$("#xd_fx").hide();
			$("#xd_fx").find(".select").val(0);
		}
	}
}

//设置成本价等
function set_cbj(obj) {
	page.cbj = $(obj).val();
	if (page.strArr.length > 0) {
		for (k in page.strArr) {
			page.strArr[k].cbj = $(obj).val();
		}
	}
}

function set_yj(obj) {
	page.yj = $(obj).val();
	if (page.strArr.length > 0) {
		for (k in page.strArr) {
			page.strArr[k].yj = $(obj).val();
		}
	}
}

function set_sj(obj) {
	page.sj = $(obj).val();
	if (page.strArr.length > 0) {
		for (k in page.strArr) {
			page.strArr[k].sj = $(obj).val();
		}
	}
}

function changeUnit(obj){
	page.unit = $(obj).val();
	if (page.strArr.length > 0) {
		for (k in page.strArr) {
			page.strArr[k].unit = $(obj).val();
		}
	}
}

function set_kucun(obj) {
	page.kucun = $(obj).val();
	if (page.strArr.length > 0) {
		for (k in page.strArr) {
			page.strArr[k].kucun = $(obj).val();
		}
	}
}

//设置主图---设置排序
function set_center(obj) {
	$(".form_new_words").each(function(i) {
		$(this).removeClass('set_center');
		$(this).text('设为主图');
		$(this).next().attr("name", "imgurls[]");
		// $(this).parent().css("order",i);
	});
	$(obj).addClass('set_center');
	$(obj).text('主图');
	$(obj).next().attr("name", "imgurls[center]");

	$(obj).parents('.form_new_img').siblings().eq(0).before($(obj).parents('.form_new_img'));
}

//设置主图---设置排序
var Map = function() {
	this._data = [];
	this.set = function(key, val) {
		for (var i in this._data) {
			if (this._data[i].key == key) {
				this._data[i].val = val;
				return true;
			}
		}
		this._data.push({
			key: key,
			val: val,
		});
		return true;
	};
	this.get = function(key) {
		for (var i in this._data) {
			if (this._data[i].key == key)
				return this._data[i].val;
		}
		return null;
	};
	this.delete = function(key) {
		for (var i in this._data) {
			if (this._data[i].key == key) {
				this._data.splice(i, 1);
			}
		}
		return true;
	};
};
var map = new Map();

var page = new Vue({
	el: "#page",
	data: {
		sub_cat_list: [],
		attrTitle: JSON.parse($('#a-attr_group_list').html(), true), //可选规格数据
		strArr: JSON.parse($('#a-checked_attr_list').html(), true), //已选规格数据
		old_checked_attr_list: [],
		goods_card_list: [],
		card_list: [],
		goods_cat_list: [{
			"cat_id": null,
			"cat_name": null
		}],
		select_i: '',
		cbj: $('#a-cbj').html(),
		yj: $('#a-yj').html(),
		sj: $('#a-sj').html(),
		kucun: $('#a-kucun').html(),
		unit: $('#a-unit').html()
	},
	created() {
		var list = JSON.parse($('#a-attr_group_list').html(), true)
		for (var i = 0; i < list.length; i++) {
			list[i].isShow = false
			for (var j = 0; j < list[i].attr_list.length; j++) {
				list[i].attr_list[j].chooseMe = true
			}
		}
		this.attrTitle = list
	},
	methods: {
		change: function(item, index) {
			this.strArr[index] = item;
		},
		chooseMe(item) {
			item.chooseMe = !item.chooseMe
			var tr = $(`[value='${item.attr_name}']`).parents('tr')
			for (var i = 0; i < tr.length; i++) {
				var dis, disName;
				var oldName = $(tr).eq(i).attr('disName')
				var oldDis = $(tr).eq(i).css('display')
				if (!oldName) {
					dis = item.chooseMe ? '' : 'none';
					disName = item.chooseMe ? '' : item.attr_name
				} else if (oldName == item.attr_name) {
					dis = ''
					disName = ''
				} else if (oldName.indexOf(item.attr_name) < 0) {
					dis = oldDis
					disName = item.chooseMe ? oldName : (oldName + '' + item.attr_name)
				} else if (oldName.indexOf(item.attr_name) >= 0) {
					dis = oldDis
					disName = oldName.replace(item.attr_name, '')
				}
				$(tr).eq(i).css('display', dis).attr('disName', disName)
			}
		},
		isShow(attr_group) {
			attr_group.isShow = !attr_group.isShow
		}
	}
});

document.onkeydown = function(e) {
	if (!e) e = window.event;
	if ((e.keyCode || e.which) == 13) {
		$("[name=Submit]").click();
	}
}

var t_check = true;

var GetLength = function(str) {
	///<summary>获得字符串实际长度，中文2，英文1</summary>
	///<param name="str">要获得长度的字符串</param>
	var realLength = 0,
		len = str.length,
		charCode = -1;
	for (var i = 0; i < len; i++) {
		charCode = str.charCodeAt(i);
		if (charCode >= 0 && charCode <= 128) realLength += 1;
		else realLength += 2;
	}
	return realLength;
};

function check() {
	var url = 'index.php?module=product&action=Modify';
	if (!t_check) {
		layer.msg('请勿重复提交！', {
			time: 2000
		});
		return false;
	}

	t_check = false;

	var setimg = $('#sortList').find("[type='hidden']")
	var product_img = []
	for (var i = 0; i < setimg.length; i++) {
		product_img.push(
			$(setimg).eq(i).val()
		)
	}
	var imgattr = $('.attr-table .file-input')
	for (var j = 0; j < imgattr.length; j++) {
		page.strArr[j].img = $(imgattr).eq(j).val()
	}
	var attrArr = page.strArr
	var id = $("[name='id']").val()
	var mch_id = $("[name='mch_id']").val()
	var product_title = $("[name='product_title']").val()
	var subtitle = $("[name='subtitle']").val()
	var keyword = $("[name='keyword']").val()
	var weight = $("[name='weight']").val()
	var product_number = $("[name='product_number']").val()
	var product_class = $("[name='product_class']").val()
	var brand_class = $("[name='brand_class']").val()
	var cbj = $("[name='initial[cbj]']").val()
	var yj = $("[name='initial[yj]']").val()
	var sj = $("[name='initial[sj]']").val()
	var unit = $("[name='initial[unit]']").val()
	var kucun = $("[name='initial[kucun]']").val()
	var initial = {
		cbj: cbj,
		yj: yj,
		sj: sj,
		unit: unit,
		kucun: kucun,
	}
	var min_inventory = $("[name='min_inventory']").val()
	var freight = $("[name='freight']").val()
    var s_type = []
    for (var i = 0; i < $("[name='s_type[]']:checked").length; i++) {
        s_type.push($("[name='s_type[]']:checked").eq(i).val())
    }
	var show_adr = []
	for (var i = 0; i < $("[name='show_adr[]']:checked").length; i++) {
		show_adr.push($("[name='show_adr[]']:checked").eq(i).val())
	}

	var active = $("input[name='active']:checked").val();
	var distributor_id = $("[name='distributor_id']").val();

	var ue = UE.getEditor('editor');
	if (ue.getContent()) {
		var content = ue.getContent()
	} else {
		var content = ''
	}
	var data = {
		id: id,
		mch_id: mch_id,
		product_title: product_title,
		subtitle: subtitle,
		keyword: keyword,
		weight: weight,
		product_number: product_number,
		product_class: product_class,
		brand_class: brand_class,
		imgurls: product_img,

		initial: initial,
		attr: JSON.stringify(attrArr),
		min_inventory: min_inventory,
		freight: freight,
        s_type: s_type,
        show_adr: show_adr,
		content: content,
		active: active,
		distributor_id: distributor_id
	}

	$.ajax({
		cache: true,
		type: "POST",
		dataType: "json",
		url: url,
		data: data, // 你的formid
		async: true,
		success: function(data) {
			t_check = true;
			layer.msg(data.Message, {
				time: 2000
			});
			if (data.code) {
				location.href = 'index.php?module=product&action=Index&cid=' + del_str.cid + '&brand_id=' + del_str.brand_id +
					'&status=' + status + '&product_title=' + del_str.product_title + '&show_adr=' + del_str.show_adr + '&page=' +
					del_str.page + '&pagesize=' + del_str.pagesize;
			}
		}
	});
}

function select_pinpai() {
	var class_str = $("[name=product_class]").val();
	if (class_str == '' || class_str <= 0) {
		layer.msg("请先选择商品类别！", {
			time: 2000
		});
	}
}

// 点击分类框
$(document).on('click',function(){
	$('#selectData').css('display', 'none')
})

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
					$('#brand_class').empty()
					obj = JSON.parse(msg)
					var brand_list = obj.brand_list
					var class_list = obj.class_list
					var rew = '';
					$('#selectData_1').empty()
					if (class_list.length != 0) {
						var num = class_list.length - 1;
						display(class_list[num])
					}
					
					if($("[name=product_class]").val() == '' || $("[name=product_class]").val()<=0 || $("[name=product_class]").val() == '0'){
						brand_list.length = 1
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
					selectFlag = true
				}
			});
		}
	} else {
		$('#selectData').css('display', 'none')
	}
	
	event.stopPropagation()
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
				res = JSON.parse(msg)
				var class_list = res.class_list
				var brand_list = res.brand_list
				var rew = '';
				$('#selectData_1').empty() // 清空数据
				if (type == '') {
					if (text_num - 2 == level) {
						var text_num1 = text_num - 1;
						var parent = document.getElementById("div_text");
						var son0 = document.getElementById("p" + text_num);
						var son1 = document.getElementById("p" + text_num1);
						parent.removeChild(son0);
						parent.removeChild(son1);
						if (class_list.length == 0) { // 该分类没有下级
							if ($('.selectDiv>div').html() == '') {
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
							if ($('.selectDiv>div').html() == '') {
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
							if ($('.selectDiv>div').html() == '') {
								str =
									`<p class='selectItem' id='p1' tyid='${cid}' onclick='del_sel(this,${level},${cid})'>${text}</p><p class='selectItem del_sel' id='p2' onclick='del_sel(this)'>`
							} else {
								$('.del_sel').remove()
								str =
									`<p class='selectItem' id="p${text_num}" tyid='${cid}' onclick='del_sel(this,${level},${cid})'><span>&gt;</span>${text}</p><p class='selectItem del_sel' id='p${text_num + 1}' onclick='del_sel(this)'></p>`
							}
							$('#selectData').css('display', 'none')
						} else {
							display(class_list[0])

							if ($('.selectDiv>div').html() == '') {
								str =
									`<p class='selectItem' id='p1' tyid='${cid}' onclick='del_sel(this,${level},${cid})'>${text}</p><p class='selectItem del_sel' id='p2' onclick='del_sel(this)'><span>&gt;</span>请选择</p>`
							} else {
								$('.del_sel').remove()
								if (level == 0) {
									str =
										`<p class='selectItem' id='p1' tyid='${cid}' onclick='del_sel(this,${level},${cid})'>${text}</p><p class='selectItem del_sel' id='p2' onclick='del_sel(this)'><span>&gt;</span>请选择</p>`
								} else {
									str =
										`<p class='selectItem' id="p${text_num}" tyid='${cid}' onclick='del_sel(this,${level},${cid})'><span>&gt;</span>${text}</p><p class='selectItem del_sel' id="p${text_num + 1}" onclick='del_sel(this)'><span>&gt;</span>请选择</p>`
								}
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
	
	event.stopPropagation()
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
			$('.selectDiv>div').append();
			class_level(me, level, cid1, 'type')
		} else {
			var cid1 = $('#p' + level)[0].getAttribute('tyid');
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

var num = page.attrTitle.length;
var _chooseVal = ''; //选中的数据
var _chooseText = ''; //选中的数据
var attrFlag = true //控制添加属性只能点一次

var attrIndex = 1
var customAttr = [] //自定义的属性

// 点击添加属性按钮
$('.Attribute').on('click', () => {
	
	var imgattr = $('.attr-table .file-input')
	page.imgArr = []
	for (var j = 0; j < imgattr.length; j++) {
		page.strArr[j].img = $(imgattr).eq(j).val()
	}
	
	page.imgArr = JSON.parse(JSON.stringify(page.strArr))
	
	page.imgArr.filter(items=>{
		
		items.attrStr = ''
		
		items.attr_list.filter(item=>{
			
			items.attrStr += ',' + item.attr_name
			
		})
		
		items.attrStr = items.attrStr.replace(',','')
		
	})
	
	if (attrFlag) {
		attrFlag = false
		var price1 = $("input[name='initial[cbj]']").val() //成本价
		var price2 = $("input[name='initial[yj]']").val() //原价
		var price3 = $("input[name='initial[sj]']").val() //售价
		var size = $("#unit").val() //单位
		page.$data.unit = size
		var kucun = $("input[name='initial[kucun]']").val() //库存

		if (!(price1 && price2 && price3 && size != 0 && kucun)) {
			layer.msg("商品属性不能为空！");
			attrFlag = true
			return
		}
		$.ajax({
			type: "GET",
			url: 'index.php?	module=product&action=Ajax&m=attribute',
			data: {
				"strArr": page.attrTitle
			},
			success: function(msg) {
				// 以下为添加属性的方法
				var res = JSON.parse(msg)
				var attrName = res.attribute

				var attrStr = ''
				var attrStr1 = ''
				var optionStr = ''
				attrName.filter((item, index) => {
					if (item.status) {
						var children = ''
						item.children.filter(items => {
							if (items.status) {
								children +=
									`<label class="checkbox">
            <input name="attr_${item.id}" type="checkbox" checked value="${items.id}">
            <i></i>
            ${items.name}
        </label>`
							} else {
								children +=
									`<label class="checkbox">
            <input name="attr_${item.id}" type="checkbox" value="${items.id}">
            <i></i>
            ${items.name}
        </label>`
							}
						})
						attrStr1 +=
							`<div>
    <div class="attr_title" style="width: 90px;height: 36px;">
        <img src="images/icon1/gb.png" data-index='${index}'>
        ${item.name}
    </div>
    <div class="attr_content" data-index="${index}">
        ${children}
    </div>
</div>`

						attrStr +=
							`<li>
<label>
<label class="checkbox">
<input name="attr_name" checked="true" type="checkbox" value="${item.id}">
<i></i>
${item.name}
</label>
</label>
</li>`

						optionStr += ',' + item.name
					} else {
						attrStr +=
							`<li>
<label>
<label class="checkbox">
<input name="attr_name" type="checkbox" value="${item.id}">
<i></i>
${item.name}
</label>
</label>
</li>`
					}
				})

				optionStr = optionStr.replace(',', '')

				var addAttrStr = ''
				console.log(customAttr)
				customAttr.filter(item => {
					addAttrStr +=
						`<div class="custom_attr" style="padding-bottom: 10px;">
            <span class="left_text">${item.attr_group_name}：</span>
            <input type="text" placeholder="请输入属性值" style="width: 212px;">
            <a class="addBtn addB" href="javascript:;">添加属性</a>
            <a class="removeBtn" href="javascript:;">删除属性</a>
        </div>
        <div class="custom_attrVlue" style="padding: 0 70px 10px;">
        `
					item.attr_list.filter(items => {
						addAttrStr +=
							`<a href="javascript:;">
                ${items.attr_name}
                <img src="images/icon1/gb.png">
            </a>`
					})
					addAttrStr += '</div>'
				})

				var str =
					`
<div id="attrMask" class="maskNew" style="z-index: 9999;">
<div class="maskNewContent mask-content" style="margin-left: -100px!important;">
<p class="mask-title">添加属性</p>
<a href="javascript:void(0);" class="closeA closeAttr" style="display: block;">
<img src="images/icon1/gb.png"/>
</a>
<div class="mask-content-data">
<div>
    <label style="margin-right: 10px;margin-bottom: 0;height: 27px;line-height: 27px;">添加方式：</label>
    <div>
        <div style="display: flex;">
            <div class="radio">
                <input id="radio1" name="attrStyle" type="radio" value="1" ${attrIndex == 1 ? 'checked' : ''}>
                <label for="radio1">选择属性名称</label>
            </div>
            <div class="radio">
                <input id="radio2" name="attrStyle" type="radio" value="2" ${attrIndex == 2 ? 'checked' : ''}>
                <label for="radio2">自定义属性名称</label>
            </div>
        </div>
        <div id="shooser_attrDiv" class="shooser_attrDiv" ${attrIndex == 1 ? '' : 'style="display: none;"'}>
            <div style="padding-bottom: 10px;">
                <span>请选择属性名称：</span>
                <div style="position: relative;">
                    <select name="" id="chooseAttr" style="padding-left: 8px;">
                        <option value="">${optionStr}</option>
                    </select>
                    <div style="position: absolute;left: 0;top: 0;width: 240px;height: 36px;"></div>
                    <ul id="choose_ul" style="display: none;">
                        ${attrStr}
                    </ul>
                </div>
            </div>

            <div id="chooseAttrBox" style="display: block;">
                ${attrStr1}
            </div>
        </div>

        <div id="custom_attrDiv" class="shooser_attrDiv" ${attrIndex == 2 ? '' : 'style="display: none;"'}>
            <div style="padding-bottom: 10px;">
                <span class="left_text">属性名称：</span>
                <input type="text" placeholder="请输入属性名称" style="width: 310px;">
                <a class="addBtn addA" href="javascript:;">添加属性</a>
            </div>
            ${addAttrStr}
        </div>
    </div>
</div>
</div>
<div class="mask-bottom">
<input type="button" class="closeAttr" value="取消">
<input type="button" value="添加" id="confirmMask">
</div>
</div>
</div>
`

				$('body', parent.document).append(str)

				attrFlag = true

				// 打开关闭添加属性弹窗
				$('body', parent.document).find('#chooseAttr').next().off()
				$('body', parent.document).find('#chooseAttr').next().on('click', function() {
					$('body', parent.document).find('#choose_ul').toggle()
				})

				// 选择属性名
				$('body', parent.document).find('[name="attr_name"]').off()
				$('body', parent.document).find('[name="attr_name"]').on('change', function() {
					var val = $(this).val()
					var str = '' //显示在选择框中的内容  颜色,大小尺寸
					var attrStr = '' //显示在选择框下面的属性与属性值

					attrName.filter((item, index) => {
						if (item.id == val) {
							item.status = !item.status
						}
						if (item.status) {
							str += ',' + item.name

							var children = ''
							item.children.filter(items => {
								if (items.status) {
									children +=
										`<label class="checkbox">
            <input name="attr_${item.id}" type="checkbox" checked value="${items.id}">
            <i></i>
            ${items.name}
        </label>`
								} else {
									children +=
										`<label class="checkbox">
            <input name="attr_${item.id}" type="checkbox" value="${items.id}">
            <i></i>
            ${items.name}
        </label>`
								}
							})
							attrStr +=
								`
<div>
    <div class="attr_title" style="width: 90px;height: 36px;">
        <img src="images/icon1/close_red.png" data-index='${index}'>
        ${item.name}
    </div>
    <div class="attr_content" data-index="${index}">
        ${children}
    </div>
</div>
`
						}
					})
					str = str.replace(',', '')
					$(this).parents('#attrMask').find('#chooseAttr').empty()
					$(this).parents('#attrMask').find('#chooseAttr').append(`
<option value="">${str}</option>
`)
					$(this).parents('#attrMask').find('#chooseAttrBox').empty()
					$(this).parents('#attrMask').find('#chooseAttrBox').append(attrStr)

					// 选择属性值
					$(this).parents('#attrMask').find('#chooseAttrBox [type="checkbox"]').off()
					$(this).parents('#attrMask').find('#chooseAttrBox [type="checkbox"]').on('change', function() {
						var index1 = $(this).parents('.attr_content').attr('data-index')
						var index2 = $(this).parent().index()
						attrName[index1].children[index2].status = !attrName[index1].children[index2].status
					})

					//删除属性名
					$(this).parents('#attrMask').find('#chooseAttrBox img').off()
					$(this).parents('#attrMask').find('#chooseAttrBox img').on('click', function() {
						var index = Number($(this).attr('data-index'))

						var text1 = $(this).parents('#attrMask').find('#chooseAttr option').text()
						text1 = text1.replace(',' + attrName[index].name, '').replace(attrName[index].name + ',', '').replace(
							attrName[index].name, '')
						$(this).parents('#attrMask').find('#chooseAttr option').text(text1)

						attrName[index].status = false
						$(this).parents('#attrMask').find('#choose_ul li').eq(index).find('input').attr('checked', false)
						$(this).parent().parent().remove()
					})
				})

				// 选择属性值
				$('body', parent.document).find('#chooseAttrBox [type="checkbox"]').off()
				$('body', parent.document).find('#chooseAttrBox [type="checkbox"]').on('change', function() {
					var index1 = $(this).parents('.attr_content').attr('data-index')
					var index2 = $(this).parent().index()
					attrName[index1].children[index2].status = !attrName[index1].children[index2].status
				})

				//删除属性名
				$('body', parent.document).find('#chooseAttrBox img').off()
				$('body', parent.document).find('#chooseAttrBox img').on('click', function() {
					var index = Number($(this).attr('data-index'))

					var text1 = $(this).parents('#attrMask').find('#chooseAttr option').text()
					text1 = text1.replace(',' + attrName[index].name, '').replace(attrName[index].name + ',', '').replace(
						attrName[index].name, '')
					$(this).parents('#attrMask').find('#chooseAttr option').text(text1)

					attrName[index].status = false
					$(this).parents('#attrMask').find('#choose_ul li').eq(index).find('input').attr('checked', false)
					$(this).parent().parent().remove()
				})

				// 切换选择还是自定义属性
				$('body', parent.document).find('.radio input').off()
				$('body', parent.document).find('.radio input').on('change', function() {
					var index = $(this).context.defaultValue
					if (index == 1) {
						$(this).parents('#attrMask').find('#shooser_attrDiv').css('display', '')
						$(this).parents('#attrMask').find('#custom_attrDiv').css('display', 'none')
					} else {
						$(this).parents('#attrMask').find('#shooser_attrDiv').css('display', 'none')
						$(this).parents('#attrMask').find('#custom_attrDiv').css('display', '')
					}
				})

				// 添加属性名称
				$('body', parent.document).find('#custom_attrDiv .addA').off()
				$('body', parent.document).find('#custom_attrDiv .addA').on('click', function() {
					var val = $(this).prev().val().trim()
					val = val.replace("//s/g", "");
					if (val == '') {
						$('body', parent.document).append(
							`
                <div id="timeLoading" style="position:fixed;top:0;left:0;right:0;bottom: 0;z-index: 99999;">
                    <div style="position: absolute;top:50%;left:50%;transform: translate(-50%,-50%);padding: 12px 25px;font-size: 14px;color:#ffffff;background: rgba(0,0,0,0.6)">请输入属性名称</div>
                </div>
            `
						)
						setTimeout(() => {
							$('body', parent.document).find('#timeLoading').remove()
						}, 2000)
						return
					}

					var is_name = false
					customAttr.filter(item => {
						if (item.attr_group_name == val) {
							is_name = true
						}
					})
					if (is_name) {
						$('body', parent.document).append(
							`
                <div id="timeLoading" style="position:fixed;top:0;left:0;right:0;bottom: 0;z-index: 99999;">
                    <div style="position: absolute;top:50%;left:50%;transform: translate(-50%,-50%);padding: 12px 25px;font-size: 14px;color:#ffffff;background: rgba(0,0,0,0.6)">属性名称重复</div>
                </div>
            `
						)
						setTimeout(() => {
							$('body', parent.document).find('#timeLoading').remove()
						}, 2000)
						return
					}
					var str1 = '';
					var attr_list = [];
					attrName.filter((item, index) => {
						if (item.name == val) {
							item.children.filter((item1, index1) => {
								str1 +=
									`<a href="javascript:;">
                        ${item1.name}
                        <img src="images/icon1/gb.png">
                    </a>`
								attr_list.push({
									'attr_name': item1.name,
									'chooseMe': true
								})
							})
						}
					})
					var str =
						`<div class="custom_attr" style="padding-bottom: 10px;">
            <span class="left_text">${val}：</span>
            <input type="text" placeholder="请输入属性值" style="width: 212px;">
            <a class="addBtn addB" href="javascript:;">添加属性</a>
            <a class="removeBtn" href="javascript:;">删除属性</a>
        </div>
        <div class="custom_attrVlue" style="padding: 0 70px 10px;">
            ${str1}
        </div>`
					$(this).parents('#attrMask').find('#custom_attrDiv').append(str)
					if (str1 == '') {
						customAttr.push({
							attr_group_name: val,
							attr_list: [],
							isShow: false
						})
					} else {
						customAttr.push({
							attr_group_name: val,
							attr_list: attr_list,
							isShow: false
						})
					}
					$(this).prev().val('')

					// 删除属性值
					$(this).parents('#attrMask').find('.custom_attrVlue a').off()
					$(this).parents('#attrMask').find('.custom_attrVlue a').on('click', function() {
						var i = ($(this).parent().prev().index() - 1) / 2
						customAttr[i].attr_list.splice($(this).index(), 1)
						$(this).remove()
					})
					// 添加属性值
					$(this).parents('#attrMask').find('#custom_attrDiv .addB').off()
					$(this).parents('#attrMask').find('#custom_attrDiv .addB').on('click', function() {
						var val = $(this).prev().val().trim()
						val = val.replace("//s/g", "");
						if (val == '') {
							$('body', parent.document).append(
								`
                    <div id="timeLoading" style="position:fixed;top:0;left:0;right:0;bottom: 0;z-index: 99999;">
                        <div style="position: absolute;top:50%;left:50%;transform: translate(-50%,-50%);padding: 12px 25px;font-size: 14px;color:#ffffff;background: rgba(0,0,0,0.6)">请输入属性值</div>
                    </div>
                `
							)
							setTimeout(() => {
								$('body', parent.document).find('#timeLoading').remove()
							}, 2000)
							return
						}

						var is_cf = false
						var i = ($(this).parent().index() - 1) / 2

						customAttr[i].attr_list.filter(item => {
							if (item.attr_name == val) {
								is_cf = true
								console.log(is_cf)
							}
						})
						if (is_cf) {
							$('body', parent.document).append(
								`
                    <div id="timeLoading" style="position:fixed;top:0;left:0;right:0;bottom: 0;z-index: 99999;">
                        <div style="position: absolute;top:50%;left:50%;transform: translate(-50%,-50%);padding: 12px 25px;font-size: 14px;color:#ffffff;background: rgba(0,0,0,0.6)">属性值重复</div>
                    </div>
                `
							)
							setTimeout(() => {
								$('body', parent.document).find('#timeLoading').remove()
							}, 2000)
							return
						}
						customAttr[i].attr_list.push({
							'attr_name': val,
							'chooseMe': true
						})

						var str =
							`<a href="javascript:;">
                            ${val}
                            <img src="images/icon1/gb.png">
                        </a>`
						$(this).parent().next().append(str)
						$(this).prev().val('')

						// 删除属性值
						$(this).parents('#attrMask').find('.custom_attrVlue a').off()
						$(this).parents('#attrMask').find('.custom_attrVlue a').on('click', function() {
							var i = ($(this).parent().prev().index() - 1) / 2
							customAttr[i].attr_list.splice($(this).index(), 1)
							$(this).remove()
						})
					})

					// 删除属性名称
					$(this).parents('#attrMask').find('#custom_attrDiv .removeBtn').off()
					$(this).parents('#attrMask').find('#custom_attrDiv .removeBtn').on('click', function() {
						var i = ($(this).parent().index() - 1) / 2
						customAttr.splice(i, 1)

						$(this).parent().next().remove()
						$(this).parent().remove()
					})
				})

				// 添加属性值
				$('body', parent.document).find('#custom_attrDiv .addB').off()
				$('body', parent.document).find('#custom_attrDiv .addB').on('click', function() {
					var val = $(this).prev().val().trim()
					val = val.replace("//s/g", "");
					if (val == '') {
						return
					}

					var is_cf = false
					var i = ($(this).parent().index() - 1) / 2

					customAttr[i].attr_list.filter(item => {
						if (item.attr_name == val) {
							is_cf = true
							console.log(is_cf)
						}
					})
					if (is_cf) {
						return
					}
					customAttr[i].attr_list.push({
						'attr_name': val,
						'chooseMe': true
					})

					var str = `<a href="javascript:;">
${val}
<img src="images/icon1/gb.png">
</a>`
					$(this).parent().next().append(str)
					$(this).prev().val('')

					// 删除属性值
					$(this).parents('#attrMask').find('.custom_attrVlue a').off()
					$(this).parents('#attrMask').find('.custom_attrVlue a').on('click', function() {
						var i = ($(this).parent().prev().index() - 1) / 2
						customAttr[i].attr_list.splice($(this).index(), 1)
						$(this).remove()
					})
				})

				// 删除属性名称
				$('body', parent.document).find('#custom_attrDiv .removeBtn').off()
				$('body', parent.document).find('#custom_attrDiv .removeBtn').on('click', function() {
					var i = ($(this).parent().index() - 1) / 2
					customAttr.splice(i, 1)

					$(this).parent().next().remove()
					$(this).parent().remove()
				})
				// 删除属性值
				$('body', parent.document).find('#attrMask .custom_attrVlue a').off()
				$('body', parent.document).find('#attrMask .custom_attrVlue a').on('click', function() {
					var i = ($(this).parent().prev().index() - 1) / 2
					customAttr[i].attr_list.splice($(this).index(), 1)
					$(this).remove()
				})

				// 关闭弹窗
				$('body', parent.document).find('.closeAttr').off()
				$('body', parent.document).find('.closeAttr').on('click', function() {
					$(this).parents('.maskNew').remove()
				})

				// 点击确定
				$('body', parent.document).find('#confirmMask').off()
				$('body', parent.document).find('#confirmMask').on('click', function() {
					var qh = $(this).parents('#attrMask').find("[name='attrStyle']:checked").val()
					attrIndex = qh
					// 1为选择属性 2为自定义
					if (qh == 1) {
						var strArr = []
						var attrTitle = []
						attrName.filter((item, index) => {
							if (item.status) {
								attrTitle.push({
									attr_group_name: item.name,
									attr_list: [],
									isShow: false
								})
								item.children.filter(items => {
									if (items.status) {
										attrTitle[attrTitle.length - 1].attr_list.push({
											'attr_name': items.name,
											'chooseMe': true
										})
									}
								})
							}
						})
						var iw = 0;
						// 循环删除没有选择属性值的属性名
						var attrTitleCopy = JSON.parse(JSON.stringify(attrTitle))
						while (iw < attrTitleCopy.length) {
							if (attrTitleCopy[iw].attr_list.length == 0) {
								attrTitleCopy.splice(iw, 1)
							} else {
								iw++
							}
						}

						if (attrTitleCopy.length == 0) {
							$('body', parent.document).append(
								`
                    <div id="timeLoading" style="position:fixed;top:0;left:0;right:0;bottom: 0;z-index: 99999;">
                        <div style="position: absolute;top:50%;left:50%;transform: translate(-50%,-50%);padding: 12px 25px;font-size: 14px;color:#ffffff;background: rgba(0,0,0,0.6)">请选择商品属性</div>
                    </div>
                `
							)
							setTimeout(() => {
								$('body', parent.document).find('#timeLoading').remove()
							}, 2000)
							return
						}
						attrTitle = attrTitleCopy

						page.attrTitle = attrTitle
						var listX = 0
						for (var i = 0; i < attrTitle.length; i++) {
							var attr_list = attrTitle[i].attr_list
							if (listX == 0) {
								listX = attr_list.length
							} else {
								listX = attr_list.length > 0 ? (attr_list.length * listX) : listX
							}
						}

						for (var i = 0; i < listX; i++) {
							if (page.strArr[i]) {
								strArr.push({
									"cbj": price1,
									"yj": price2,
									"sj": price3,
									"unit": size,
									"kucun": kucun,
									"image": '', //图片
									"bar_code": '', // 条形码
									"attr_list": [],
									"cid": page.strArr[i].cid
								})
							} else {
								strArr.push({
									"cbj": price1,
									"yj": price2,
									"sj": price3,
									"unit": size,
									"kucun": kucun,
									"image": '', //图片
									"bar_code": '', // 条形码
									"attr_list": [],
									"cid": ''
								})
							}
						}

						var th_title = JSON.parse(JSON.stringify(attrTitle))

						digui(th_title, 0, listX)

						strArr.filter(items=>{
							
							var attrStr = ''
							
							items.attr_list.filter(item=>{
								
								attrStr += ',' + item.attr_name
								
							})
							
							attrStr = attrStr.replace(',','')
							
							page.imgArr.filter(its=>{
								if(its.attrStr == attrStr){
									items.img = its.img
								}
							})
							
						})
						
						page.strArr = []
						
						setTimeout(function(){
							page.strArr = strArr
						},5)

					} else {
						var attrTitle = customAttr
						var strArr = []
						var listX = 0

						var iw = 0;
						// 循环删除没有选择属性值的属性名
						var attrTitleCopy = JSON.parse(JSON.stringify(attrTitle))
						while (iw < attrTitleCopy.length) {
							if (attrTitleCopy[iw].attr_list.length == 0) {
								attrTitleCopy.splice(iw, 1)
							} else {
								iw++
							}
						}
						if (attrTitleCopy.length == 0) {
							$('body', parent.document).append(
								`
                    <div id="timeLoading" style="position:fixed;top:0;left:0;right:0;bottom: 0;z-index: 99999;">
                        <div style="position: absolute;top:50%;left:50%;transform: translate(-50%,-50%);padding: 12px 25px;font-size: 14px;color:#ffffff;background: rgba(0,0,0,0.6)">请添加商品属性</div>
                    </div>
                `
							)
							setTimeout(() => {
								$('body', parent.document).find('#timeLoading').remove()
							}, 2000)
							return
						}

						attrTitle = attrTitleCopy

						for (var i = 0; i < attrTitle.length; i++) {
							var attr_list = attrTitle[i].attr_list
							if (listX == 0) {
								listX = attr_list.length
							} else {
								listX = attr_list.length > 0 ? (attr_list.length * listX) : listX
							}
						}

						for (var i = 0; i < listX; i++) {
							strArr.push({
								"cbj": price1,
								"yj": price2,
								"sj": price3,
								"unit": size,
								"kucun": kucun,
								"image": '', //图片
								"bar_code": '', // 条形码
								"attr_list": [],
								"cid": ''
							})
						}

						page.attrTitle = attrTitle

						var th_title = JSON.parse(JSON.stringify(attrTitle))

						digui(th_title, 0, listX)

						strArr.filter(items=>{
							
							var attrStr = ''
							
							items.attr_list.filter(item=>{
								
								attrStr += ',' + item.attr_name
								
							})
							
							attrStr = attrStr.replace(',','')
							
							page.imgArr.filter(its=>{
								if(its.attrStr == attrStr){
									items.img = its.img
								}
							})
							
						})
						
						page.strArr = []
						
						setTimeout(function(){
							page.strArr = strArr
						},5)
					}

					function digui(th_title, i, _listX) {
						// 如果该循环的子项没有东西则停止递归
						if (!th_title[i]) {
							if (i < (th_title.length - 1)) {
								th_title.splice(i, 1)
								digui(th_title, i, _listX)
								return
							}
							return
						}

						// 如果该项属性的没有属性值，则删除该项重新递归
						if (th_title[i].attr_list.length == 0) {
							th_title.splice(i, 1)
							digui(th_title, i, _listX)
							return
						}

						var xx = 0
						if (i == 0) {
							// 第一个规格属性的格式是白色白色白色,黑色黑色黑色
							for (var j = 0; j < th_title[i].attr_list.length; j++) {
								var value = th_title[i].attr_list[j].attr_name
								for (var x = 0; x < listX / th_title[i].attr_list.length; x++) {
									var name = th_title[i].attr_group_name
									strArr[xx].attr_list.push({
										'attr_id': '',
										'attr_name': value,
										'attr_group_name': name
									})
									xx++
								}
							}
						} else if (i < th_title.length - 1) {

							_listX = Math.round(_listX / th_title[i - 1].attr_list.length)
							// 外面这层循环代表当前属性在内循环完成之后进入新的循环,比如白色白色黑色黑色红色红色,完成之后再次白色白色黑色黑色红色红色循环,总行数除以前一个属性每个属性有多少行,得出总循环数
							for (var l = 0; l < listX / _listX; l++) {
								for (var j = 0; j < th_title[i].attr_list.length; j++) {
									var value = th_title[i].attr_list[j].attr_name
									// 当前规格的前一个每个属性行数,除当前
									for (var x = 0; x < _listX / th_title[i].attr_list.length; x++) {
										var name = th_title[i].attr_group_name
										strArr[xx].attr_list.push({
											'attr_id': '',
											'attr_name': value,
											'attr_group_name': name
										})
										xx++
									}
								}
							}

						} else {
							// 后面的规格属性格式是x,l,xl x,l,xl循环
							for (var x = 0; x < listX / th_title[i].attr_list.length; x++) {
								for (var j = 0; j < th_title[i].attr_list.length; j++) {
									var value = th_title[i].attr_list[j].attr_name
									var name = th_title[i].attr_group_name
									strArr[xx].attr_list.push({
										'attr_id': '',
										'attr_name': value,
										'attr_group_name': name
									})
									xx++
								}
							}
						}
						i++
						if (i < th_title.length) {
							digui(th_title, i, _listX)
						}
					}

					$(this).parents('.maskNew').remove()
				})

				attrFlag = true
			}
		});
	}
})

$('.multiple').on('click', '.file-item-delete', function() {
	$(this).parent().css('display', 'none')
})
