// 报价
function calcPrice(obj) {
    var form = $(obj).parent().find('.calc-form');
    var _area = form.find('.build_area').val();
    var _phone = form.find('.tel-phone').val();
    var _house_type = form.find('.house-type').val();
    var _city_province = form.find('.city-province').val();
    var _city = form.find('.city-id').val();
    var _grade = form.find('.grade-list').val();
    var host_get_offer = $('#host_get_offer').val();
    var pc_type = $('#pc_offer_type').val();
    var dec_type = $('.dec-type .active').text();
    if (!_area) {
        form.find('.build_area').siblings('em').show();
    } else if (!_phone) {
        form.find('.tel-phone').siblings('em').show();
    } else if (!/^(13[0-9]|14[0-9]|15[0-9]|18[0-9]|17[0-9]|19[0-9])\d{8}$/i.test(_phone)) {
        form.find('.tel-phone').siblings('em').show();
    } else if (!host_get_offer) {
        alert('报价失败');
    } else {
        var city = _city_province + '-' + _city;
        $.ajax({
            url: host_get_offer,
            type: 'POST',
            dataType: 'JSON',
            data: { area: _area, phone: _phone, house: _house_type, city: city, grade: _grade, type: pc_type, decoration_type: dec_type },
            success: function (res) {
                if (res.status == 200) {
                    var data = res.data_list
                    $('.inclusive').html(data.all_money);
                    $('.halfpack').html(data.part_money);
                    if ($('#utm_from').val()) {
                            window._agl && window._agl.push(['track', ['success', { t: 3 }]])
                    }
                    alert('您家的装修预算，全包：' + data.all_money + '元，半包：' + data.part_money + '元， 以上为估算报价仅供参考，实际报价以量房为准。');
                } else {
                    alert('报价失败');
                }
            },
            error: function (e) {
                alert('报价失败');
            }
        });
        // 提交数据,清空电话号码。。。。。
        $('.tel-phone').val('');        
    }
}
// 获取验证码
function getVaildCode(dom, self) {
    var form = $(dom).closest('.calc-form');
    console.log(form);
    // console.log($(dom).siblings('div').children('input').val())
    var phone = $(dom).siblings('div').children('input').val();
    if (!phone || !/^(13[0-9]|14[0-9]|15[0-9]|18[0-9]|17[0-9]|19[0-9])\d{8}$/i.test(phone)) {
        form.find('.tel-phone').siblings('em').show();
        return;
    } else {
        form.find('.tel-phone').siblings('em').hide();
        var SMScodeUrl = $('#getSMScode').val();
        var key = $('#key').val();
        var sign = hex_md5(phone+key);
        $.ajax({
            type: 'post',
            url: SMScodeUrl,
            data: {
                'phone': phone,
                'token': $('#token').val(),
                'sign': sign
            },
            dataType: 'json',
            success: function (res) {
                if (res.code == 200) {
                    $(self).attr('disabled', true);
                    var seconds = 60;
                    var timer = setInterval(() => {
                        seconds--
                        if (seconds > 0) {
                            $(self).text(seconds + 's后重新获取');
                        } else {
                            seconds = 60;
                            clearInterval(timer);
                            $(self).removeAttr('disabled').text('获取验证码')
                        }
                    }, 1000);
                }
            }
        })
    }
    // console.log(val, phone);

}
// 表单必填校验
function vaildRequire(dom) {
    $(dom).css({
        'border': 'solid 1px #d9d9d9'
    });
    // $(dom).next().next().text('');
    if (!$(dom).val()) {
        // $(dom).val('输入您的建筑面积');
        $(dom).siblings('em').show();
        $(dom).css({
            'border': 'solid 1px red'
        })
    } else {
        $(dom).css({
            'border': 'solid 1px #d9d9d9'
        });
        $(dom).siblings('em').hide();
    }
}
// 电话号码校验
function vaildTel(dom) {
    console.log('hi', dom);
    $(dom).css({
        'border': 'solid 1px #d9d9d9'
    });
    var _tel = $(dom).val()
    if (_tel == '') {
        $(dom).siblings('em').show();
        $(dom).css({
            'border': 'solid 1px red'
        })
    } else if (!/^(13[0-9]|14[0-9]|15[0-9]|18[0-9]|17[0-9]|19[0-9])\d{8}$/i.test(_tel)) {
        $(dom).siblings('em').show();
        $(dom).css({
            'border': 'solid 1px red'
        })
    } else {
        $(dom).css({
            'border': 'solid 1px #d9d9d9'
        });
        $(dom).siblings('em').hide();
    }
}
$(document).ready(function () {
    // banner
    (function ($) {
        $.fn.extend({
            rotaion: function (options) {
                //默认参数
                var defaults = {
                    /**轮换间隔时间，单位毫秒*/
                    during: 6000,
                    /**是否显示左右按钮*/
                    btn: true,
                    /**是否显示焦点按钮*/
                    focus: true,
                    /**是否显示标题*/
                    title: false,
                    /**是否自动播放*/
                    auto: true
                }
                var options = $.extend(defaults, options);
                return this.each(function () {
                    var o = options;
                    var curr_index = 0;
                    var $this = $(this);
                    var $li = $this.find("ul li");
                    var li_count = $li.length;
                    $this.css({ position: 'relative', overflow: 'hidden', height: $li.find("img").height() || '406px' });
                    // $this.css({position: 'relative', overflow: 'hidden', height: '340px'});
                    $this.find("li").css({ position: 'absolute', left: 0, top: 0 }).hide();
                    $li.first().show();
                    $this.append('<i class="demo-icon icon-left-open-big">&#xe85f;<\/i><i class="demo-icon icon-right-open-big">&#xe860;<\/i>');
                    if (!o.btn) $(".rotaion-btn").css({ visibility: 'hidden' });
                    if (o.focus) $this.append('<ol class="rotation-focus"><\/ol');
                    var $btn = $(".rotaion i"), $focus = $(".rotation-focus");
                    //如果自动播放，设置定时器
                    if (o.auto) var t = setInterval(function () {
                        $btn.last().click()
                    }, o.during);
                    // 输出焦点按钮
                    for (i = 1; i <= li_count; i++) {
                        $focus.append('<li>' + '</li>');
                    }
                    var $f = $focus.children("li");
                    $f.first().addClass("on");
                    //鼠标覆盖元素，清除计时器
                    $btn.add($li).add($f).hover(function () {
                        if (t) clearInterval(t);
                    }, function () {
                        if (o.auto) t = setInterval(function () {
                            $btn.last().click()
                        }, o.during);
                    });
                    //鼠标覆盖焦点按钮效果
                    $f.bind("click", function () {
                        var i = $(this).index();
                        $(this).addClass("on");
                        $focus.children("li").not($(this)).removeClass("on");
                        $li.eq(i).fadeIn(300);
                        $li.not($li.eq(i)).fadeOut(300);
                        curr_index = i;
                    });
                    //鼠标点击左右按钮效果
                    $btn.bind("click", function () {
                        $(this).index() == 1 ? curr_index-- : curr_index++;
                        if (curr_index >= li_count) curr_index = 0;
                        if (curr_index < 0) curr_index = li_count - 1;
                        $li.eq(curr_index).fadeIn(300);
                        $li.not($li.eq(curr_index)).fadeOut(300);
                        $f.eq(curr_index).addClass("on");
                        $f.not($f.eq(curr_index)).removeClass("on");
                        // $title.text($li.eq(curr_index).find("img").attr("alt"));
                        // $title.attr("href",$li.eq(curr_index).find("a").attr("href"));
                    });
                });
            }
        });
    })(jQuery);
    $('.rotaion').rotaion();


    //地区市获取
    $("#city").on("change", function () {
        pid = $("#city").find("option:selected").attr("k");
        if (pid) {
            host_url = $('input[name= host_url]').val();
            city(pid, host_url, '#city_level');
        } else {
            $('#city_level').html('<option value="市/地区">市/地区</option>');
        }
    });
  //地区市获取
    $("#city_1").on("change", function () {
        pid = $("#city_1").find("option:selected").attr("k");
        if (pid) {
            host_url = $('input[name= host_url]').val();
            city(pid, host_url, '#city_level_1');
        } else {
            $('#city_level_1').html('<option value="市/地区">市/地区</option>');
        }
    });
    //地区市获取
    $("#common_city").on("change", function () {
        pid = $("#common_city").find("option:selected").attr("k");
        if (pid) {
            host_url = $('input[name= host_url]').val();
            city(pid, host_url, '#common_city_level');
        } else {
            $('#common_city_level').html('<option value="市/地区">市/地区</option>');
        }
    });
    function city(pid, host_url, id) {
        $.ajax({
            url: host_url,
            type: 'POST',
            dataType: 'JSON',
            data: { pid: pid, },
            success: function (res) {
                if (res.code == 200) {
                    html = '';
                    $.each(res.data_list, function (key, value) {
                        html += "<option value=" + value.name + ">" + value.name + "</option>";
                    });
                    $(id).html(html);
                } else {
                    return false;
                }
            },
            error: function (e) {
                return false;
            }
        });
    }

    // 计算器输入项验证
    //    $('.calc-btn').on('click', function() {
    //                 var _area = $('.build_area').val();
    //                 var _phone = $('.tel-phone').val();
    //                 var _house_type = $('.house-type').val();
    //                 var _city_province = $('.city-province').val();
    //                 var _city = $('.city-id').val();
    //                 var _grade = $('.grade-list').val();
    //                 var host_get_offer =  $('#host_get_offer').val();
    //                 var pc_type =  $('#pc_offer_type').val();  
    //                 if (!_area) {
    //                     $('.build_area').siblings('em').addClass('show');
    //                 } else if (!_phone){
    //                     $('.tel-phone').siblings('em').text('手机号码不能为空')
    //                     $('.tel-phone').siblings('em').addClass('show');
    //                 } else if (!/^(13[0-9]|14[0-9]|15[0-9]|18[0-9]|17[0-9])\d{8}$/i.test(_phone)) {
    //                     $('.tel-phone').siblings('em').text('手机号码不正确')
    //                     $('.tel-phone').siblings('em').addClass('show');
    //                } else if (!host_get_offer) {
    //                         alert('报价失败');
    //                } else {
    //                  var city = _city_province+'-'+_city;
    //                        $.ajax({
    //                         url: host_get_offer,
    //                         type: 'POST',
    //                         dataType: 'JSON',
    //                         data: {area: _area,phone: _phone,house: _house_type,city: city,grade: _grade,type:pc_type},
    //                         success: function (res) {
    //                             if (res.status == 200) {
    //                                var  data = res.data_list
    //                                  $('#inclusive').html(data.all_money);
    //                                  $('#halfpack').html(data.part_money);
    //                                   alert('您家的装修预算，全包：' + data.all_money + '元，半包：' + data.part_money + '元， 以上为估算报价仅供参考，实际报价以量房为准。')
    //                             } else { 
    //                                 alert('报价失败');
    //                             }
    //                         },
    //                         error: function (e) {
    //                              alert('报价失败');
    //                         }
    //                       });
    //                     // 提交数据,清空电话号码。。。。。
    //                     $('.tel-phone').val('');
    //                 }
    //     })

    /* 报价服务 */
    $('.telphone').on('blur', function () {
        $(this).css({
            'border': 'solid 1px #d9d9d9'
        });
        $(this).next().text('');
        if ($(this).val() == '') {
            $(this).val('方便接受报价及装修服务');
            $(this).next().text('手机号码不能为空');
            $(this).css({
                'border': 'solid 1px red'
            })
        }
    });
    // $('.build_area').on('blur',function(){
    //     $(this).css({
    //         'border':'solid 1px #d9d9d9'
    //     });
    //     $(this).next().next().text('');
    //     if($(this).val() == ''){
    //         $(this).val('输入您的建筑面积');
    //         $(this).next().next().text('输入您的建筑面积');
    //         $(this).css({
    //             'border':'solid 1px red'
    //         })
    //     }
    // });

    /* 预约 */
    $('.eg-alert input').not('.village').on('blur', function () {
        var pltext = $(this).attr('placeholder')
        $(this).css({
            'border': 'solid 1px #d9d9d9'
        })
        $(this).next().text('')
        if ($(this).val() == '') {
            $(this).val(pltext)
            $(this).next().text('请填写' + pltext)
            $(this).css({
                'border': 'solid 1px red'
            })
        }
    })
    $('.ep-alert input').not('.village').on('blur', function () {
        var pltext = $(this).attr('placeholder')
        $(this).parent().css({
            'border': 'solid 1px #d9d9d9'
        })
        $(this).next().text('')
        if ($(this).val() == '') {
            $(this).val(pltext)
            $(this).next().text('请填写' + pltext)
            $(this).parent().css({
                'border': 'solid 1px red'
            })
        }
    })
    $('.al-alert input').not('.village').on('blur', function () {
        var pltext = $(this).attr('placeholder')
        $(this).css({
            'border': 'solid 1px #d9d9d9'
        })
        $(this).next().text('')
        if ($(this).val() == '') {
            $(this).val(pltext)
            $(this).next().text('请填写' + pltext)
            $(this).css({
                'border': 'solid 1px red'
            })
        }
    })
    // 申请提供平面方案
    $('.btn-emit-applyPlan').on('click', function () {
        $('.applyPlanDialog').toggleClass('actived');
    })
    $('.applyPlanDialog-btn-close').on('click', function () {
        $('.applyPlanDialog').toggleClass('actived');
        $('.applyPlanDialog input').val('');
    })

    // 搜索下拉-防select效果
    $('.drop_down').click(function (e) {
        $(this).find('i').toggleClass('transform');
        $('.list').toggle();
        e.stopPropagation();
        $('body').click(function () {
            $('.list').hide();
            $('.drop_down').find('i').removeClass('transform');
        })
    });
    $('.list li').click(function () {
        $('.drop_down a').text(($(this).text()));
        $('.drop_down a').attr('k', $(this).attr('k'));
        if ($(this).attr('k') == 'anli') {
            $('.keyword').val('楼盘名称、户型、风格、面积、预算');
            // $('.keyword').attr('placeholder','楼盘名称、户型、风格、面积、预算');
        } else {
            $('.keyword').val('请输入搜索关键词');
            // $('.keyword').attr('placeholder','请输入搜索关键词');
        }
        $('.list').toggle();
        $('.drop_down').find('i').removeClass('transform');
    });
    //点击搜索
    $(".search_btn").click(function () {
        search();
    });
    //回车搜索
    $(".keyword").keydown(function (e) {
        if (e.keyCode == 13) {
            search();
        }
    });
    // 导航下拉保持
    $('.navbar-nav').find('div').hover(function () {
        $(this).siblings('a').toggleClass('on');
        $(this).siblings('a').find('i').toggleClass('transform');
    });
    function gotoTop(min_height){
    	var gotoTop_html = '<div id="gotoTop"><img alt="" src="/template/pc/skin/images/back_top.png"></div>';
   	    $(".back-top").append(gotoTop_html);
   	    $("#gotoTop").click(
    	function(){$('html,body').animate({scrollTop:0},500);
    	    }).hover(
    	        function(){$(this).addClass("hover");},
   			function(){$(this).removeClass("hover");
	    	});
	    	min_height ? min_height = min_height : min_height = 200;
   	    $(window).scroll(function(){
   	        var s = $(window).scrollTop();
   	        if( s > min_height){
   	            $("#gotoTop").fadeIn(100);
   	        }else{
   	            $("#gotoTop").fadeOut(200);
   	        };
   	    });
   	};
   	gotoTop();
    // 导航下拉过境
    // $('.nav_div').find('li').mouseover(function (f) {
    //     var Id1 = $(this).attr("id");
    //     $(this).find('img').attr('src', home_static + "/ijz/images/icon/" + Id1 + "_1.png");
    // });
    // $('.nav_div').find('li').mouseout(function (f) {
    //     var Id1 = $(this).attr("id");
    //     $(this).find('img').attr('src', home_static + "/ijz/images/icon/" + Id1 + ".png");
    // });
    // john edit 侧边栏二维码显示隐藏 右侧定位的高度计算
//    var leyuCusLiHeight = $('.doyoo_pan_icon_inner a').height();  // 乐语客服的高度
//    if (leyuCusLiHeight > 0) {
//        var rightFixedHeight = $('.fixed_right').height();          // 右侧固定的三个图标的高度
//        $('.fixed_right').height(rightFixedHeight).offset({ top: leyuCusLiHeight + 120 });
//    }
//    $('.qr_little_code').hover(function () {
//        $('.qr_fade_code').fadeIn()
//    }, function () {
//        $('.qr_fade_code').fadeOut()
//    })

    // 右侧的菜单栏的计算器hover态的点击 触发弹窗的显示关闭
    $('.computedPara').click(function () {
        $('.common_apply_popup_layer').toggle('on');
        $('.common_rePrice_apply_popup').toggle('on');
    })
    $('.little_comp_pic').click(function () {
        $('.apply_popup_layer').toggle('on');
        $('.rePrice_apply_popup').toggle('on');
    })
    // 弹窗的右上角的关闭小叉的点击   触发弹窗的显示关闭
    $('.rePrice_close_layer').click(function () {
        $('.apply_popup_layer').removeClass('on').hide();
        $('.rePrice_apply_popup').removeClass('on').hide();
    });
    $('.common_rePrice_close_layer').click(function () {
        $('.common_apply_popup_layer').removeClass('on').hide();
        $('.common_rePrice_apply_popup').removeClass('on').hide();
    });
    //页面加载后延迟09秒弹出，首页报价器弹窗
    /*if(isIndex){
     setTimeout(function () {
     $('.apply_popup_layer').toggle('on');
     $('.rePrice_apply_popup').toggle('on');
     },900)
     }*/

    // 经典案例-实景案例-却换
    var t;
    $('.index_four').find('h2').hover(function () {
        var url = $(this).attr('data-url');
        if (url == 'vr') {
            $('.anliItem').addClass('hidden');
        } else {
            $('.anliItem').removeClass('hidden');
        }
        $('.anMore').attr('href', domain + '/' + url);
        var liindex = $(this).index();
        $(this).addClass('on').siblings().removeClass('on');
        clearTimeout(t);
        t = setTimeout(function () {
            $('.index_four ul').eq(liindex).addClass('display').siblings('.index_four ul').removeClass('display');
        }, 800);
    });
    // 热门楼盘-VR工地-却换
    var k;
    $('.index_six').find('h2').hover(function () {
        var url = $(this).attr('data-url');
        if (url == 'vrgongdi') {
            $('.lpitem').addClass('hidden');
        } else {
            $('.lpitem').removeClass('hidden');
        }
        $('.lpMore').attr('href', domain + '/' + url);
        var liindex = $(this).index();
        $(this).addClass('on').siblings().removeClass('on');
        clearTimeout(k);
        k = setTimeout(function () {
            $('.index_six ul').eq(liindex).addClass('display').siblings('.index_six ul').removeClass('display');
        }, 800);
    });
    // banner图不固定高度
    var banner_h = $('.banner ul li').find('img').height() || 580;
    $('.banner ul li').css({ "height": banner_h + "px" });
    $('.banner ul li a').css({ "height": banner_h + "px" });
    $('.banner ul').css({ "height": banner_h + "px" });
    $('.banner .demo-icon').css({ "top": (banner_h - 50) / 2 + "px" });

    // 设计团队
    var _index5 = 0;
    var lists = $('.live li').length;
    var list_w = 243;
    $('.live').css({ "width": lists * list_w - 16 + "px" });
    $(".icon-right").click(function () {
        _index5++;
        if (_index5 <= lists - 4) {
            $(".live").stop().animate({ marginLeft: -_index5 * list_w + "px" }, 1000);
        } else {
            _index5 = lists - 4;
        }
    });
    $(".icon-left").click(function () {
        if (_index5 != 0) {
            _index5--;
            $(".live").stop().animate({ marginLeft: -_index5 * list_w + "px" }, 1000);
        } else {
        }
    });
    // 友情链接-却换
    var m;
    $('.Friendship_link').find('em').hover(function () {
        var liindex = $(this).index();
        $(this).addClass('on').siblings().removeClass('on');
        clearTimeout(m);
        m = setTimeout(function () {
            $('.Friendship_link span').eq(liindex).addClass('display').siblings('.Friendship_link span').removeClass('display');
        }, 800);
    });
    // Strength  品牌实力  材料优质环保
    $('.datum .datum_nav').find('li').click(function () {
        var liindex = $(this).index();
        $(this).addClass('on').siblings().removeClass('on');
        $('.datum .datum_date').eq(liindex).addClass('on').siblings('.datum .datum_date').removeClass('on');
    });
    // about_us  -左侧导航下拉保持
    $('.news_list li').find('a').click(function () {
        $(this).parent('li').toggleClass('on').siblings().removeClass('on');
    });
    // about_us  -左侧导航却换
    $('.news .summary_nav').find('li').click(function () {
        var liindex = $(this).index();
        $(this).addClass('on').siblings().removeClass('on');
        $('.news .summary').eq(liindex).addClass('on').siblings('.news .summary').removeClass('on');
    });

    // about_us  企业荣誉
    var ul = $('.honor_trends ul li');
    var w = (ul.length - 3) * 295;
    var p = 0;
    var right_bt = 1;
    var left_bt = 1;
    // 正在绑定
    $('.right_bt').click(function () {
        if (right_bt == 1) {
            right_bt = 0
            if (p > -w) {
                if (p == 0) {
                    p += w;
                } else {
                    p -= 295;
                }
                $('.honor_trends ul').animate({ left: -p + 'px' }, 500);
            } else {
                p -= p;
                $('.honor_trends ul').animate({ left: -p + 'px' }, 500);
            }
            setTimeout(function () {
                right_bt = 1
            }, 500)
        }
    });

    $('.left_bt').click(function () {
        if (left_bt == 1) {
            left_bt = 0
            if (p < w) {
                p += 295;
                $('.honor_trends ul').animate({ left: -p + 'px' }, 500);
            } else {
                if (p == 0) {
                    p += p;
                } else {
                    p -= w;
                }
                $('.honor_trends ul').animate({ left: -p + 'px' }, 500);
            }
            setTimeout(function () {
                left_bt = 1
            }, 500)
        }
    });

    // 经典案例yu实景案例-切换
    // $('.cases h2').click(function () {
    //     var Id1 = $('.on').attr("id");
    //     $('.on p').html("<img src= '" + home_static + "/ijz/images/icon/" + Id1 + ".png' alt=''/>");
    //     $('.cases h2').removeClass('on');
    //     $(this).addClass('on');
    //     var Id2 = $('.on').attr("id");
    //     $('.on p').html("<img src='" + home_static + "/ijz/images/icon/" + Id2 + "_on.png' alt=''/>");
    //     var liindex = $(this).index();
    //     $('.all_case').eq(liindex).addClass('on').siblings('.all_case').removeClass('on');
    // });
    // 施工工地
    $('.construction_state .state_name').click(function () {
        $(this).parent('li').toggleClass('on').siblings('li').removeClass('on');
    });
    // 装修视频
    /* $('.lores_videos .lists li').find('.video').click(function(){
     $(this).addClass('hidden').siblings('iframe').removeClass('hidden').siblings('.Close').removeClass('hidden').siblings('.jump').addClass('vary');
     $(this).siblings('.Close').click(function(){
     $(this).addClass('hidden').siblings('iframe').addClass('hidden').siblings('.video').removeClass('hidden').siblings('.jump').removeClass('vary');
     })
     });*/
    // 免费申请弹出层
    $('.service .application').click(function () {
        $('.apply_popup_layer').toggle('on');
        $('.apply_popup').toggle('on');
        $('.apply_popup_title').text(('申请' + $(this).siblings('.article').text()))
        $('.apply_popup_p').text(('免费' + $(this).siblings('.hidden').text()))
        if ($(this).siblings('.article').text() === '上门验房') {
            $('.apply_popup_button').text('申请免费验房')
        }
        else if ($(this).siblings('.article').text() === '上门量房') {
            $('.apply_popup_button').text('申请免费量房')
        }
        else {
            $('.apply_popup_button').text(('申请免费' + $(this).siblings('.article').text()))
        }

    });
    // 参观楼盘弹出层
    $('.visit_button').click(function () {
        $('.apply_popup_layer').toggle('on');
        $('.apply_popup').toggle('on');
    });
    // 立即预约
    $('.make-appointment').click(function () {
        $('.apply_popup_layer').toggle('on');
        $('.apply_popup').toggle('on');
    });
    // 电话咨询弹出层
    $('.tele_a').click(function () {
        $('.apply_popup_layer').toggle('on');
        $('.apply_popup').toggle('on');
    });
    $('.close_layer').click(function () {
        $('.apply_popup_layer').toggle('on');
        $('.apply_popup').toggle('on');
        $('.apply_popup_ul input').attr('value', '')
    });
    // 所在城市
    $('.all .mores').click(function () {
        $(this).siblings('.more').toggleClass('block').parent('tr').siblings('tr').find('.variable').toggleClass('block');
    });
    $('.all .mores1').click(function () {
        $(this).siblings('.more').toggleClass('block').parent('tr').siblings('tr').find('.variable').toggleClass('block1');
    });
    // 案例详情 图片NAV
    /* window.onload = function() {

     };*/
    var img_nav = $('#img_nav');
    if (img_nav.length) {
        var mTop = $('#img_nav').offset().top;  //ID为img_nav 的元素到页面顶部的距离
        var hNav = $('#img_nav').height(); 		//ID为img_nav 的元素的高度
        var hImg = $('#img_nav_imgs').height(); //ID为img_nav_imgs 的元素的高度
        var hNew = hImg + mTop - hNav; 			//计算出ID为img_nav 的元素到达父级元素的底部时的距离
        $(window).scroll(function () {
            var sTop = $(window).scrollTop();  //滚动条到页面顶部的距离
            if (mTop <= sTop && sTop < hNew) {
                $('#img_nav').addClass('fixed_top');
            } else if (sTop >= hNew) {
                $('#img_nav').removeClass('fixed_top');
                $('#img_nav').addClass('absolute_top');
            } else if (mTop > sTop) {
                $('#img_nav').removeClass('fixed_top');
                $('#img_nav').removeClass('absolute_top');
            }
        });
    }

    //案例图片限制下载
    $('.imgMenuStop').on('contextmenu', 'img', function (e) {
        e.preventDefault();
        $('.stopMenuAlert').addClass('show');
        setTimeout(function () {
            $('.stopMenuAlert').removeClass('show')
        }, 2000)
    });

    //视频限制下载
    $('.videoMenuStop').on('contextmenu', function (e) {
        e.preventDefault();
        $('.stopMenuAlert').addClass('show');
        setTimeout(function () {
            $('.stopMenuAlert').removeClass('show')
        }, 2000)
    });

    //家居风水
    var _index6 = 0;
    var fengshui_list = $('.fengshui_ol li').length;
    var fengshui_ol_width = fengshui_list * 940;
    $('.fengshui_ol').css('width', fengshui_ol_width);
    $('.fengshui_right').click(function () {
        _index6++;
        if (_index6 <= fengshui_list - 1) {
            $(".fengshui_ol").stop().animate({ marginLeft: -_index6 * 940 + "px" }, 1000);
            $(".fengshui_focus li").eq(_index6).addClass('on').siblings().removeClass('on');
        } else {
            _index6 = fengshui_list - 1;
        }
    });
    $(".fengshui_left").click(function () {
        if (_index6 != 0) {
            _index6--;
            $(".fengshui_ol").stop().animate({ marginLeft: -_index6 * 940 + "px" }, 1000);
            $(".fengshui_focus li").eq(_index6).addClass('on').siblings().removeClass('on');
        } else {
        }
    });

    // 背景色宽度随浏览器宽度而变化---以后可以只需要用一个属性名“box”
    // var wid = $(window).width()
    var wid = $(document).width();
    $('.box').css('width', wid);
    //$('.nav').css('width',wid);
    $('.banner').css('width', wid);
    $('.team_page_banner').css('width', wid);
    $('.new_banner').css('width', wid);
    $('.cases_banner').css('width', wid);
    $('.hots_build_page_banner').css('width', wid);
    // $('.lores_banner').css('width',wid);
    $('.news').css('width', wid);
    $('.f5f6f9').css('width', wid);
    $('.ffffff').css('width', wid);
    $('.Friendship_link').css('width', wid);
    //$('footer').css('width',wid);

    $('.prov_select').change(function () {
        var provID = $(this).val();
        if (provID != '') {
            $.ajax({
                url: '/getcitys.html',
                data: { 'provid': provID },
                type: 'post',
                dataType: 'json',
                success: function (data) {
                    if (data.status == 1) {
                        var optionStr = '<option value="">请选择</option>';
                        $.each(data.data, function (k, v) {
                            optionStr += '<option value="' + v.name + '">' + v.name + '</option>';
                        });
                        $(".city_select").html(optionStr);
                    } else {
                        $(".city_select").html();
                    }
                }, error: function () {
                    alert('error');
                }
            });
        } else {
            $(".city_select").html('<option value="">市/地区</option>');
        }
    })
    $('.reComp_prov_select').change(function () {
        var provID = $(this).val();
        if (provID != '') {
            $.ajax({
                url: '/getcitys.html',
                data: { 'provid': provID },
                type: 'post',
                dataType: 'json',
                success: function (data) {
                    if (data.status == 1) {
                        var optionStr = '<option value="">请选择</option>';
                        $.each(data.data, function (k, v) {
                            optionStr += '<option value="' + v.name + '">' + v.name + '</option>';
                        });
                        $(".reComp_city_select").html(optionStr);
                    } else {
                        $(".reComp_city_select").html();
                    }
                }, error: function () {
                    alert('error');
                }
            });
        } else {
            $(".reComp_city_select").html('<option value="">市/地区</option>');
        }
    })

    $(".g2anli").click(function () {
        window.location.href = httpType + "://" + window.location.host + "/anli/";
    });
    $(".g2anvr").click(function () {
        window.location.href = httpType + "://" + window.location.host + "/vr/";
    });

    //V5客服
    /*var v5_hm = document.createElement("script");
     v5_hm.src = "https://www.v5kf.com/136934/v5kf.js";
     var s = document.getElementsByTagName("script")[0];
     s.parentNode.insertBefore(v5_hm, s);*/

//    $(".v5_zxzx").click(function () {
//        V5CHAT('showChat');
//    });

    //PC端统计代码
    var _hmt = _hmt || [];
    (function () {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?08f94f9bcac3a719f426afe725611187";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();


    // 品牌实力
    $('.type-9-li').hover(function () {
        $('.type-9-li').attr('class', 'type-9-li')
        $(this).attr('class', 'type-9-li type-9-active')
        $(this).find('.type-9-activeimg').css('display', 'block')
        $(this).find('.type-9-noneimg').hide()
    }, function () {
        $('.type-9-activeimg').hide()
        $('.type-9-noneimg').css('display', 'block')
        $('.type-9-li').attr('class', 'type-9-li')
    })
    $('.type-10-li').on('click', function () {
        var index = $(this).index()
        $('.type-10-li').attr('class', 'type-10-li')
        $(this).attr('class', 'type-10-li active')
        $('.type-10-list img').attr('class', '')
        $('.type-10-list img').eq(index).attr('class', 'active')
    })

    // 按钮防重复点击
    var isLeftClick = true
    var isRightClick = true
    $('.type-12-left').on('click', function () {
        var left = parseInt($('.type-12-ul').css('left').replace('px'))
        if (isLeftClick && isRightClick && left < 0) {
            isLeftClick = false
            var nowLeft = left + 400
            $('.type-12-ul').animate({ left: nowLeft + 'px' })
            setTimeout(function () {
                isLeftClick = true
            }, 800)
        }
    })
    $('.type-12-right').on('click', function () {
        var left = parseInt($('.type-12-ul').css('left').replace('px'))
        var _width = $('.type-12-ul>li').length * 400 - 1200
        if (isLeftClick && isRightClick && (left < 0 || left == 0) && left > -(_width)) {
            isRightClick = false
            var nowLeft = left - 400
            $('.type-12-ul').animate({ left: nowLeft + 'px' }, 'linear')
            setTimeout(function () {
                isRightClick = true
            }, 800)
        }
    })

    var selectIndex = 0;
    // 竞价页面(品牌实力)
    $('.bidding-type-12-left').on('click', function () {
        var left = parseInt($('.type-12-ul').css('left').replace('px'))
        if (isLeftClick && isRightClick && left < 0) {
            isLeftClick = false
            var nowLeft = left + 106
            $('.type-12-ul').animate({ left: nowLeft + 'px' })
            setTimeout(function () {
                isLeftClick = true
            }, 800)
        }
    })
    $('.bidding-type-12-right').on('click', function () {
        var left = parseInt($('.bidding .type-12-ul').css('left').replace('px'))
        var _width = $('.type-12-ul>li').length * 106 - 640
        if (isLeftClick && isRightClick && (left < 0 || left == 0) && _width > (-left)) {
            isRightClick = false
            var nowLeft = left - 106
            $('.type-12-ul').animate({ left: nowLeft + 'px' }, 'linear')
            setTimeout(function () {
                isRightClick = true
            }, 800)
        }
    })

    $('.bidding .type-12-ul li').click(function () {
        selectIndex = $('.bidding .type-12-ul li').index($(this));
        toggleSelect(selectIndex);
    });

    $('.js-select-bt').click(function (event) {
        var type = event.currentTarget.dataset.type;
        var length = $('.select-box li').length;
        if (type === 'left' && selectIndex > 0) {
            selectIndex--;
        } else if (type === 'right' && selectIndex < (length - 1)) {
            selectIndex++;
        }
        toggleSelect(selectIndex);
    });
    $('.type-15 .js-case-nav li').click(function () {
        var index = $('.type-15 .js-case-nav li').index($(this));
        toggleType(index);
    });
    $('.type-15 .js-case-nav-ol li').click(function () {
        var index = $('.type-15 .js-case-nav-ol li').index($(this));
        toggleType(index);
    });

    // 关闭模态框
    $('.js-close').click(function () {
        var modal = $(this).parent(".js-modal");
        modal.css('display', 'none');
        const modals = $('.js-modal');
        for (var i = 0; i < modals.length; i++) {
            if ($(modals[i]).css('display') === 'block') {
                return;
            }
        }
        $('.js-modal-mask').css('display', 'none');
        // setTimeout(function () {
        //     openAll();
        // }, 20000);
    });
    // 打开弹窗
    $('.js-open-modal').click(function (event) {
        var modal = event.currentTarget.dataset.modal;
        $('.' + modal).css('display', 'block');
        $('.js-modal-mask').css('display', 'block');
    });
    // openAll();
});
// function openAll() {
//     $(".js-open-modal").trigger("click");
// }
function randomNum(lowerValue, upperValue) {
    var choices = upperValue - lowerValue + 1;
    var num = Math.floor(Math.random() * choices + lowerValue);
    return num;
}
// 经典案例切换
function toggleType(index) {
    $('.type-15 .js-img-box img').css('display', 'none');
    $($('.type-15 .js-img-box img')[index]).css('display', 'block');
    $('.type-15 .js-case-nav-ol li').removeClass('active');
    $($('.type-15 .js-case-nav-ol li')[index]).addClass('active');
}
//  品牌实力切换
function toggleSelect(selectIndex) {
    $('.select-box li').css('display', 'none');
    $('.bidding .type-12-ul li .mask').css('display', 'block');
    $($('.bidding .type-12-ul li .mask')[selectIndex]).css('display', 'none');
    $($('.select-box li')[selectIndex]).css('display', 'block');
}


// 文章分享
// window._bd_share_config = {
//     "common": {
//         "bdPopTitle": "您的自定义pop窗口标题",
//         "bdSnsKey": {},
//         "bdText": "此处填写自定义的分享内容",
//         "bdMini": "2",
//         "bdMiniList": false,
//         "bdPic": "http://localhost/centlight/public/attachment/201410/24/14/5449ef39574f5_282x220.jpg", /* 此处填写要分享图片地址 */
//         "bdStyle": "0",
//         "bdSize": "16"
//     },
//     "share": {}
// };
// with (document)0[
//     (getElementsByTagName('head')[0] || body).
//     appendChild(createElement('script')).
//         src = 'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=' + ~(-new Date() / 36e5)
//     ];


// // Strength  品牌实力  工艺行业尖端
$(document).ready(function () {
    var hydropower = [{
        img: "shuidian1.png",
        tou: "01、强弱电彩管分色布设工艺",
        nr: "同一室内，线管分为红、蓝、白三种颜色。\n优点：\n1.方便辨别、检查线路。\n2.方便安装、维修，施工规范。\n3.有效预防施工中出现错穿电线。"
    }, {
        img: "shuidian2.png",
        tou: "02、沉降池内暗设二次排水系统和存水弯防臭工艺",
        nr: "预防沉箱内存水，导致渗漏到楼下或房间区域,同时保障沉箱的长期干燥。\n所有排水管道加设存水弯头，能避免管道的臭气返到房间，同时控制细菌的衍生。"
    }, {
        img: "shuidian3.png",
        tou: "03、水管采用纳米生态抗菌PPR水管工艺",
        nr: "给水管内壁的纳米层，有天然抗菌、杀菌的功效。\n能有效净化水质，长期饮用有利于人体健康。\n内壁光滑，减小阻力，增加水流量，同时纳米层能预防使用10年以上内壁不结水垢。"
    }, {
        img: "shuidian4.png",
        tou: "04、电线之间接头采用WAGO绝缘终身连接器工艺",
        nr: "优点：\n1.将电线接头连接成为整体电线的性能，终身不用更换。\n2.能有效避免接触不良打火、短路、漏电、断路等情况的发生。"
    }, {
        img: "shuidian5.png",
        tou: "05、自动热水循环工艺",
        nr: "所有的热水管为串走式（不分支），热水主管道一直串联，铺设到每一个热水出口100mm以内。\n优点：能真正实现三层复式别墅2秒钟以内出热水，即开即用，无需等待的功效。"
    }];
    var waterproof = [{
        img: "fangshui1.png",
        tou: "01、厨房、卫生间加建地梁隔水防潮工艺",
        nr: "优点：保证洗手间加大或减少之后防水基础的稳固性和密实结构的防水性；\n避免因结构不稳定破坏防水层导致漏水、渗水的现象。"
    }, {
        img: "fangshui2.png",
        tou: "02、沉降池预防下沉和预防裂缝漏水工艺",
        nr: "优点：\n1.陶粒混凝土形成整体受力，防止洗手间地面下沉和地砖空鼓、开裂。\n2.找平层整体均匀受力，防止找平层因受力不均匀而下沉、开裂致防水层破裂、漏水等。"
    }, {
        img: "fangshui3.png",
        tou: "03、实木地板基础涂刷防尘、防潮、环保地保工艺",
        nr: "对地板的基础砂浆表面进行防潮、防尘处理，涂刷绿色环保地保2遍。\n优点：\n1.防止砂浆找平层起砂、起尘等。\n2.隔绝地面和木地板之间的潮气，防止木地板及底板因吸潮而膨胀变形发霉。"
    }];
    var mud = [{
        img: "niewa1.png",
        tou: "01、新砌墙体终身防裂工艺",
        nr: "轻质砖表面满铺10mm×10mm方格镀锌钢网，再用1:3水泥砂浆进行批荡。\n优点：保证了新砌墙体的稳定性和牢固性，有效防止新砌墙体开裂、脱层的现象发生。"
    }, {
        img: "niewa2.png",
        tou: "02、门头做过梁、门套周边砂浆封固防裂工艺",
        nr: "凡是门套线外口封盖不住与原墙接口的门头、门边，必须用砂浆或砌砖封制完成，并挂网批荡，门套周边空位决不允许使用夹板或者石膏板封制。\n可有效预防门套四周墙体裂缝现象发生。"
    }, {
        img: "niewa3.png",
        tou: "03、瓷质墙砖采用薄贴法工艺",
        nr: "优点：\n1.能节省空间，同时因为瓷砖胶收缩性很小，便于把控其平整度。\n2.专用粘结剂的高粘结强度和慢干特性可以有效防止瓷砖空鼓、掉落。"
    }];
    var carpentry = [{
        img: "mugong1.png",
        tou: "01、套底板“Π”形防裂及实木线条加厚制作工艺",
        nr: "有效预防门套线条90度拼角位变形开裂。\n优点：\n①增强门套线条稳定性，拐角位置不易开裂。\n②线条更易造形，立体感强，效果对比强烈。\n③更彰显美观大气。"
    }, {
        img: "mugong2.png",
        tou: "02、柜体框架多层实木线条叠级收口防缩防裂工艺",
        nr: "优点：\n①加厚柜框，确保柜体受力，防止变形。\n②小线条收口位置不收缩防止油漆开裂。\n③柜体边框线条叠级收口增加了造型，美观大方。\n④有效防止因线条收缩导致油漆裂缝的问题。"
    }, {
        img: "mugong3.png",
        tou: "03、柜门、抽屉自动回力型闭合式工艺",
        nr: "1.柜门与柜体框架为一个平整的面，美观且整体严实。\n2.柜门开关灵活，闭合平稳、无声，避免了关闭时的碰撞和冲击；消声减振，保护了柜门油漆和柜体框架。\n3关闭时手感非常舒适、平稳。"
    }];
    var paint = [{
        img: "youqi1.png",
        tou: "01、饰面板及浮雕饰面板艺术油漆工艺",
        nr: "索色采用淋油打磨的面板，浮雕饰面板是因其木皮纹理深，层次感强，艺术油漆处理后更突显立体机理效果。\n艺术漆要根据款式来确定面板。\n木器油漆效果是室内装修整体风格的一大亮点。"
    }, {
        img: "youqi2.png",
        tou: "02、整面平整度冲筋赶刮、阴阳角直度处理工艺",
        nr: "优点：\n1.墙体乳胶漆大面积平整，阴阳角与大面为同一个平面，角度和线型非常清晰，不会有凹凸或波浪的现象。\n2.阴阳角顺直角度清晰。\n3.灯光下视感很舒服。"
    }, {
        img: "youqi3.png",
        tou: "03、全房墙面四层防裂制作工艺",
        nr: "优点：\n1.四层防裂工艺。\n2.乳胶漆调滑石粉批刮打磨工艺，使乳胶漆基底更加平滑，手感、质感更好。\n3.引入质量识别系统—腻子呈浅黄色，油漆需涂刷到位才能封盖底色，杜绝偷工减料。"
    }];
    var install = [{
        img: "anzhuang1.png",
        tou: "01、墙面瓷砖阳角防撞工艺",
        nr: "优点：\n1.从视觉上，避免阳角出现尖锐的瓷砖尖角（风水角度）\n2.半圆形PVC阳角线，视觉上柔和舒服，且耐用、耐碰，不易产生破损、缺角等。\n3.安全性高，不易碰伤老人和小孩。"
    }, {
        img: "anzhuang2.png",
        tou: "02、天花角线实底胶粘安装工艺",
        nr: "将线条和底板双面刮胶，采用射钉或自攻螺丝进行固定。\n优点：\n1.固定非常牢固，不会产生安全隐患。\n2.线条接口处不易产生收缩而裂缝。"
    }];
    var i = 0;
    var time;
    $(document).ready(function () {
        neirong(hydropower);
    });
    $('.gc-ul li').click(function () {
        var Id1 = $('.gc-ul .on').attr("id");
        var home_static = $('#commonBaseUrl').val() || ''
        $('.on p').html("<img src='" + home_static + "/template/pc/skin/images/" + Id1 + ".png' alt=''/>");
        $('.gc-ul li').removeClass('on');
        $(this).addClass('on');
        var Id2 = $('.gc-ul .on').attr("id");
        $('.on p').html("<img src='" + home_static + "/template/pc/skin/images/" + Id2 + "_on.png' alt=''/>");

        switch (this.id) {
            case "hydropower":
                neirong(hydropower, home_static);
                break;
            case "waterproof":
                neirong(waterproof, home_static);
                break;
            case "mud":
                neirong(mud, home_static);
                break;
            case "carpentry":
                neirong(carpentry, home_static);
                break;
            case "paint":
                neirong(paint, home_static);
                break;
            case "install":
                neirong(install, home_static);
                break;
        }
    });
    function neirong(A, home_static) {
        var home_static = home_static || ''
        var imageSuffix = $('#imageSuffix').val();
        var li = "";
        var PicTxt = "";
        $('.neirong div').remove();
        for (var l = 0; l < A.length; l++) {
            var nr = A[l].nr.replace(/\n/g, '<br/>');
            PicTxt += "<div class='lunbo'><div class='pic-left'><img src='" + home_static + "/template/pc/skin/images/" + A[l].img + imageSuffix + "' alt=''/></div><div class='txt-right'><h4>" + A[l].tou + "</h4><p>" + nr + "</p></div></div>";
        }

        $('.spots li').remove();
        for (var n = 0; n < A.length; n++) {
            if (n == 0) {
                li += "<li class='spot lv'></li>";
            } else {
                li += "<li class='spot'></li>";
            }
        }
        $('.spots').append(li);
        $('.neirong').append(PicTxt);
        $(".lunbo").eq(0).show().siblings().hide();
        i = 0;
        $('.spots li').click(function () {
            var i = $(this).index();
            $(".lunbo").siblings().fadeOut();
            $(".lunbo").eq(i).fadeIn();
            $(".spot").eq(i).addClass("lv").siblings().removeClass("lv");
        });
        $(".lunbo").hover(function () {
            clearInterval(time);
        }, function () {
            showTime();
        });
        $(".spots li").hover(function () {
            clearInterval(time);
        }, function () {
            showTime();
        });
    }

    showTime();
    function show() {
        $(".lunbo").siblings().fadeOut();
        $(".lunbo").eq(i).fadeIn();
        $(".spot").eq(i).addClass("lv").siblings().removeClass("lv");
    }

    function showTime() {
        time = setInterval(function () {
            i++;
            if (i == $(".lunbo").length) {
                i = 0;
            }
            show();
        }, 6000);
    }

    $('.spots li').click(function () {
        var i = $(this).index();
        $(".lunbo").siblings().fadeOut();
        $(".lunbo").eq(i).fadeIn();
        $(".spot").eq(i).addClass("lv").siblings().removeClass("lv");
    });
    $(".lunbo").hover(function () {
        clearInterval(time);
    }, function () {
        showTime();
    });
    $(".spots li").hover(function () {
        clearInterval(time);
    }, function () {
        showTime();
    });
});

/* 新版客服接入 */
/*(function (w, d, s, i, v, j, b) {
    w[i] = w[i] || function () {
        (w[i].v = w[i].v || []).push(arguments)
    };
    j = d.createElement(s), b = d.getElementsByTagName(s)[0];
    j.async = true;
    j.charset = "UTF-8";
    j.src = "https://www.v5kf.com/136934/v5kf.js";
    b.parentNode.insertBefore(j, b);
})(window, document, "script", "V5CHAT");

V5CHAT('withoutBtn'); // 自定义按钮时需隐藏原插件中的按钮
V5CHAT('showChatOnHuman', false);//禁止刷新页面时自动弹窗
V5CHAT('onPluginLoad', function () {
    //用户隐藏弹窗后，如果客服发消息，该弹窗会自动打开
    V5CHAT('onChatHide', function () { // 对话框隐藏的回调
        V5CHAT('onMessage', function (res) { //收到消息的回调
            V5CHAT('showChat');
        });
    });
});
V5CHAT('human', { human: 1, wid: 0, gid: 0 });

//点击自定义按钮事件 所有点击调用V5客服的地方 统一这个class名
$(function () {
    $(".btnKeFu").on("click", function () {
        V5CHAT('showChat');
    })
})*/
/* 新版客服接入 */

function strToJson(str) {
    var json = eval('(' + str + ')');
    return json;
}

/*报价*/
function getQoute(param, ctype = '') {
    var ctype = ctype ? 14 : 12;
    if (param) {
        var area = $(".reComp_build_area").val();
        var tel = $(".reComp_telphone").val();
        var type = $(".reComp_build_type").val();
        var zh_type = $(".reComp_build_type").find("option:selected").text();
        var grade = $(".reComp_decoration_grade").val();
        var zh_grade = $(".reComp_decoration_grade").find("option:selected").text();
        var prov = $('.reComp_prov_select option:selected');
        var city = $('.reComp_city_select option:selected');
        if (!ctype && (!prov.val() || !city.val())) {
            alert('请选择所在城市');
            return false;
        }
        var reg = /^[1-9]{1}[0-9]{1,}$/;
        if (!area) {
            $(".reComp_build_area").css({
                'border': '1px solid red'
            }).focus().next().fadeIn().text('请填写输入您的建筑面积')

            return false;
        }
        if (!reg.test(area)) {
            $(".reComp_build_area").css({
                'border': '1px solid red'
            }).next().fadeIn().text('请输入正确的房屋面积')
            return false;
        }
        if (!tel) {
            $(".reComp_telphone").css({
                'border': '1px solid red'
            }).next().fadeIn().text('手机号码不能为空').focus()
            return false;
        }
        if (!/^(13[0-9]|14[0-9]|15[0-9]|18[0-9]|17[0-9]|19[0-9])\d{8}$/i.test(tel)) {
            $(".reComp_telphone").css({
                'border': '1px solid red'
            }).next().fadeIn().text('手机号码不正确').focus()
            return false;
        }

    } else {
        var area = $(".build_area").val();
        var tel = $(".telphone").val();
        var type = $(".build_type").val();
        var zh_type = $(".build_type").find("option:selected").text();
        var grade = $(".decoration_grade").val();
        var zh_grade = $(".decoration_grade").find("option:selected").text();
        var prov = $('.prov_select option:selected');
        var city = $('.city_select option:selected');
        if (!ctype && (!prov.val() || !city.val())) {
            alert('请选择所在城市');
            return false;
        }
        var reg = /^[1-9]{1}[0-9]{1,}$/;

        if (!area) {
            $(".build_area").focus();
            $(".build_area").next().next().fadeIn().text('房屋面积不能为空');
            $(".build_area").css({
                'border': '1px solid red'
            });
            return false;
        }
        if (!reg.test(area)) {
            $(".build_area").next().next().fadeIn().text('请输入正确的房屋面积');
            $(".build_area").css({
                'border': '1px solid red'
            });
            return false;
        }
        if (!tel) {
            $(".telphone").next().fadeIn().text('手机号码不能为空');
            $(".telphone").focus();
            $(".telphone").css({
                'border': '1px solid red'
            });
            return false;
        }
        if (!/^(13[0-9]|14[0-9]|15[0-9]|18[0-9]|17[0-9]|19[0-9])\d{8}$/i.test(tel)) {
            $(".telphone").next().fadeIn().text('手机号码不正确');
            $(".telphone").focus();
            $(".telphone").css({
                'border': '1px solid red'
            });
            return false;
        }
    }

    $.ajax({
        url: get_offer_url,
        type: 'post',
        data: {
            'area': area,
            'house': type,
            'grade': grade,
            'phone': tel,
            'city': prov.text() + '-' + city.text(),
            'type': ctype,
        },
        dataType: 'json',
        success: function (res) {
            if (res.status == 200 && res.data_list) {
                var money = res.data_list;
                if (param) {
                    $(".reComp_money_all").html(money['all_money']);
                    $(".reComp_money_part").html(money['part_money']);
                    $(".reComp_telphone").val('方便接受报价及装修服务');
                } else {
                    $(".money_all").html(money['all_money']);
                    $(".money_part").html(money['part_money']);
                    $(".telphone").val('方便接受报价及装修服务');
                }
                var leyuUrl = 'http://looyuoms7813.looyu.com/chat/form?c=20003252&conf=11520&cmd=save&column0=' + area + '&column1=' + zh_type + '&column2=' + zh_grade + '&column3=' + tel + '&column4=' + prov.text() + '-' + city.text();
                newWin(leyuUrl);
                alert('您家的装修预算，全包：' + money['all_money'] + '元，半包：' + money['part_money'] + '元， 以上为估算报价仅供参考，实际报价以量房为准。')
            } else {
                alert('报价失败，请稍后重试');
            }
        }, error: function () {
            alert('报价失败，请稍后重试');
        }
    });
    return false;
}
//用来提交预约、报价器到乐语
function newWin(url) {
    var elemIF = document.createElement("iframe");
    elemIF.src = url;
    elemIF.style.display = "none";
    elemIF.id = 'leyuIF';
    document.body.appendChild(elemIF);
    setTimeout("remElemIF()", 2000);
}
function remElemIF() {
    $("#leyuIF").remove();
}
/*获取报价人数、户型*/
function setOffer() {
    $.ajax({
        type: 'post',
        url: set_offer_url,
        data: {},
        dataType: 'jsonp',
        jsonp: "jsoncallback",
        success: function (res) {
            if (res['count'] && res['build_type']) {
                $(".qoutr_num").html(res['count']);
                var optionStr = '';
                $.each(res['build_type'], function (k, v) {
                    optionStr += '<option value="' + v.id + '">' + v.name + '</option>';
                });
                $(".build_type").html(optionStr);
            }
        }
    });
}
function getSMSVaildcode(dom, self) {
    if ($(self).attr('disabled')) return false;
    var form = $(dom).closest('form');
    var tel = form.find('.phone').val();
    var book = form.attr('class') == 'book' ? true : false
    if (!tel || tel == '您的手机号码') {
        form.find('.phone').next().text('请填写您的手机号码')
        form.find('.phone').focus();
        book ? form.find('.phone').parent().css({
            'border': 'solid 1px red'
        }) : form.find('.phone').css({
            'border': 'solid 1px red'
        })
        return false;
    }
    if (!/^(13[0-9]|14[0-9]|15[0-9]|18[0-9]|17[0-9]|19[0-9])\d{8}$/i.test(tel)) {
        form.find('.phone').next().text('手机号码不正确')
        form.find('.phone').focus();
        book ? form.find('.phone').parent().css({
            'border': 'solid 1px red'
        }) : form.find('.phone').css({
            'border': 'solid 1px red'
        })
        return false;
    }
    var SMScodeUrl = $('#getSMScode').val();
    var key = $('#key').val();
    var sign = hex_md5(tel+key);
    $.ajax({
        type: 'post',
        url: SMScodeUrl,
        data: {
            'phone': tel,
            'token': $('#token').val(),
            'sign': sign
        },
        dataType: 'json',
        success: function (res) {
            if (res.code == 200) {
                $(self).attr('disabled', true);
                var seconds = 60;
                var timer = setInterval(() => {
                    seconds--
                    if (seconds > 0) {
                        $(self).text(seconds + 's后重新获取');
                    } else {
                        seconds = 60;
                        clearInterval(timer);
                        $(self).removeAttr('disabled').text('获取验证码')
                    }
                }, 1000);
            }
        }
    })

}
//预约
function subscribe(obj) {
    var form = $(obj).closest('form');
    var tel = form.find('.phone').val();
    var name = form.find('.name').val();
    console.log(form, form.find('.phone'), tel, name);
    var village = form.find('.village').val() ? form.find('.village').val() : '';
    var area = form.find('.area').val() ? form.find('.area').val() : 0;
    var ctype = $('#pc_subscribe_type').val() ? $('#pc_subscribe_type').val() : 3;
    var prov = form.find('.prov_select option:selected').text() ? form.find('.prov_select option:selected').text() : '';
    var city = form.find('.city_select').val() ? form.find('.city_select').val() : '';
    var designName = form.find('.designName').val() ? form.find('.designName').val() : '';
    var comment = form.find('.Comment.php').val() ? form.find('.Comment.php').val() : '';
    village = village == '您的楼盘' ? '' : village;
    var host_add_subscribe = $('#host_add_subscribe').val();
    var remark = '';
    if (prov && city) {
        remark = '客户预约的省市：' + prov + '/' + city;
    }
    if (designName) {
        remark = '客户预约设计师：' + designName;
    }
    remark = comment ? comment : remark;
    var book = form.attr('class') == 'book' ? true : false

    if (!name || name == '您的姓名' || name == '您的称呼，如王先生/刘女士') {
        form.find('.name').next().text('请填写您的姓名')
        form.find('.name').focus();
        book ? form.find('.name').parent().css({
            'border': 'solid 1px red'
        }) : form.find('.name').css({
            'border': 'solid 1px red'
        })
        return false;
    }

    if (!tel || tel == '您的手机号码' || tel == '联系方式，便于提供0元装修服务') {
        form.find('.phone').next().text('请填写您的手机号码')
        form.find('.phone').focus();
        book ? form.find('.phone').parent().css({
            'border': 'solid 1px red'
        }) : form.find('.phone').css({
            'border': 'solid 1px red'
        })
        return false;
    }
    if (!/^(13[0-9]|14[0-9]|15[0-9]|18[0-9]|17[0-9]|19[0-9])\d{8}$/i.test(tel)) {
        form.find('.phone').next().text('手机号码不正确')
        form.find('.phone').focus();
        book ? form.find('.phone').parent().css({
            'border': 'solid 1px red'
        }) : form.find('.phone').css({
            'border': 'solid 1px red'
        })
        return false;
    } else {
        
        $.ajax({
            type: 'post',
            url: host_add_subscribe,
            data: {
                'phone': tel,
                'name': name,
                'address': village,
                'area': area,
                'type': ctype,
                'utm_from': $('#utm_from').val(),
                'remark': remark
            },
            dataType: 'json',
            success: function (res) {
                if (res['status'] == '200') {
                    var leyuUrl = 'http://looyuoms7813.looyu.com/chat/form?c=20003252&conf=11520&cmd=save&column0=' + name + '&column1=' + tel + '&column2=' + village + '&column3=' + remark + '';
                    newWin(leyuUrl);
                    form.find('input').val('');
                    $('.apply_popup_layer').hide('on');
                    $('.apply_popup').hide('on');
                    $('.applyPlanDialog').removeClass('actived');
                    $('.applyPlanDialog input').val('');
                    setTimeout(function () {
                        if ($('#utm_from').val()) {
                            window._agl && window._agl.push(['track', ['success', { t: 3 }]])
                        }
                        alert('预约成功！工作人员会以最快速度与您联系。');
                    }, 800)
                } else {
                    alert('预约失败');
                }
            }
        });       
    }
    return false;
}

function getSubscribeNum() {
    $.ajax({
        type: 'post',
        url: api_totalsubscribe_url,
        data: {},
        dataType: 'json',
        success: function (res) {
            if (res.data_list && res.data_list.count) {
                $(".subscribeNum").text(res.data_list.count);
            }
        }
    });
}

function search() {
    var item = $(".drop_down a").attr('k');
    var keyword = $(".keyword").val();
    if (keyword && item && keyword != '楼盘名称、户型、风格、面积、预算' && keyword != '请输入搜索关键词') {
        // window.location.href = httpType + '://' + window.location.host + '/search/' + item + '/keyword/' + keyword;
    }
}
// Echo.init({
//     offset: 100,
//     throttle: 50,
//     unload: false
// });
function applyVisit() {
    //$('html,body').animate({ scrollTop: 0 }, 700);
    //window.location.href = 'http://' + window.location.host + '/pinpai.html';
}
// function totel() {
//     alert('咨询电话：400-700-9883');
// }
//返回顶部
function go2top() {
    $('html,body').animate({ scrollTop: 0 }, 500);
}

// 运用js判断当前浏览器是什么，在做出操作
function myBrowser() {
    var userAgent = navigator.userAgent; //取得浏览器的userAgent字符串
    var isOpera = userAgent.indexOf("Opera") > -1; //判断是否Opera浏览器
    var isIE = userAgent.indexOf("compatible") > -1 && userAgent.indexOf("MSIE") > -1 && !isOpera; //判断是否IE浏览器
    var isFF = userAgent.indexOf("Firefox") > -1; //判断是否Firefox浏览器
    var isSafari = userAgent.indexOf("Safari") > -1; //判断是否Safari浏览器
    if (isIE) {
        var IE5 = IE55 = IE6 = IE7 = IE8 = IE9 = false;
        var reIE = new RegExp("MSIE (\\d+\\.\\d+);");
        reIE.test(userAgent);
        var fIEVersion = parseFloat(RegExp["$1"]);
        IE55 = fIEVersion == 5.5;
        IE6 = fIEVersion == 6.0;
        IE7 = fIEVersion == 7.0;
        IE8 = fIEVersion == 8.0;
        IE9 = fIEVersion == 9.0;
        if (IE55) {
            return "IE55";
        }
        if (IE6) {
            return "IE6";
        }
        if (IE7) {
            return "IE7";
        }
        if (IE8) {
            return "IE8";
        }
        if (IE9) {
            return "IE9";
        }
    }//isIE end
    if (isFF) {
        return "FF";
    }
    if (isOpera) {
        return "Opera";
    }
}
//myBrowser() end
//以下是调用上面的函数
if (myBrowser() == "FF") {
    // alert("我是 Firefox");
}
if (myBrowser() == "Opera") {
    // alert("我是 Opera");
}
if (myBrowser() == "Safari") {
    // alert("我是 Safari");
}
if (myBrowser() == "IE55") {
    // alert("我是 IE5.5");
}
if (myBrowser() == "IE6") {
    // alert("我是 IE6");
}
if (myBrowser() == "IE7") {
    // alert("我是 IE7");
}
if (myBrowser() == "IE8") {
    // alert("我是 IE8");
    $('.index_three div ul li .em_xia').addClass('ie_em')
    $('.index_five .ol_eight li').css('width', '105px')
    $('.bespoke li.selects i').addClass('ie_em')
    $('.service .application').addClass('imgbag')
    $('.anli_em').addClass('anli_em_bag')
}
if (myBrowser() == "IE9") {
    // alert("我是 IE9");
    $('.index_three div ul li .em_xia').addClass('ie9_em')
    $('.bespoke li.selects i').addClass('ie9_em')
}

//百度站长平台自动推送代码
(function () {
    var bp = document.createElement('script');
    var curProtocol = window.location.protocol.split(':')[0];
    if (curProtocol === 'https') {
        bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';
    }
    else {
        bp.src = 'http://push.zhanzhang.baidu.com/push.js';
    }
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(bp, s);
})();
(function () {

    $(".navBid ul li").on('click', function () {
        $(".navBid ul li").attr('class', '')
        $(this).attr('class', 'on')
        var i = $(this).index()
        var div = document.querySelector('body');
        div.scrollTop = '888px';
    })
})();

// 检测图像宽高比
// 默认 w*h
function checkImgRatio(w, h) {
    var _default = w / h;
    var _temp = $(this).width() / $(this).height();
    // reset
    this.style.width = '';
    this.style.height = '';
    // this.parentElement.style.lineHeight = '';

    if (this !== window) {
        if (_temp >= _default) { // 实际比例比默认比例大(宽过大)
            // this.style.width = w + 'px';
            this.style.height = h + 'px';
            // this.parentElement.style.lineHeight = h + 'px';
        } else if (_temp < _default) { // 实际比例比默认比例小(高过大)
            this.style.width = w + 'px';
            // this.style.height = h + 'px';
        }
    }
}
$(function () {
    initImage()
})
initImage()
function initImage() {
    $('.decorCaselist .caseslist-img>img').on('load', function (e) {
        checkImgRatio.call(e.target, 306, 230);
    });
    $('.teamslist img').on('load', function (e) {
        checkImgRatio.call(e.target, 306, 365);
    });
    $('.teamslist-img-box>img').on('load', function (e) {
        checkImgRatio.call(e.target, 306, 365);
    })
    $('.designerDetWorkList img').on('load', function (e) {
        checkImgRatio.call(e.target, 298, 230);
    });
    $('.designerDetRelatedList img').on('load', function (e) {
        checkImgRatio.call(e.target, 298, 365);
    });
    $('.main_design_wrap img').on('load', function (e) {
        checkImgRatio.call(e.target, 412, 416);
    })
    $('.small_design_wrap img').on('load', function (e) {
        checkImgRatio.call(e.target, 199.7, 200);
    })
    $('.design>img').on('load', function (e) {
        checkImgRatio.call(e.target, 308, 365);
    });

    $('.designerDetRelatedList-img-box>img').on('load', function (e) {
        checkImgRatio.call(e.target, 298, 365);
    })
    $('.designerDetWorkList-img-box>img').on('load', function (e) {
        checkImgRatio.call(e.target, 298, 230)
    })
    $('.see-more-img-box>img').on('load', function (e) {
        checkImgRatio.call(e.target, 298, 230)
    })
    $('.recommend_case_img>img').on('load', function (e) {
        checkImgRatio.call(e.target, 300, 230)
    })
    $('.avoid-transshape>img').on('load', function (e) {
        checkImgRatio.call(e.target, 418, 241)
    })
    $('.relative-case>img').on('load', function (e) {
        checkImgRatio.call(e.target, 298, 230);
    })
    // console.log('/////////')
    $('.avatar img').on('load', function (e) {
        console.log('....')
        checkImgRatio.call(e.target, 128, 128);
    })
    $('.attach-img>img').on('load', function (e) {
        checkImgRatio.call(e.target, 306, 365)
    })
    $('.teams_nominate_img>img').on('load', function (e) {
        checkImgRatio.call(e.target, 298, 365)
    })
}

/* 底部预约 */
$('.appointment-wrap').on('click', function () {
    $(this).animate({
        width: 0
    }, 300, 'linear', () => {
        $('.ijuzhong-wrap').animate({
            width: '100%',
            'min-width': '1200px'
        })
    });
})
$('.close-btn').on('click', function () {
    $('.ijuzhong-wrap').animate({
        width: 0,
        'min-width': 0
    }, 300, 'linear')
    // $('.ijuzhong-wrap').animate({
    //     width: 0,
    //     'min-width': 0
    // }, 300, 'linear', () => {
    //     $('.appointment-wrap').animate({
    //         width: '246px'
    //     })
    // })

})