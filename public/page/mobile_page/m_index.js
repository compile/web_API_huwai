// 电话号码校验
function vaildTel(obj) {
    var _phone = $(obj).val();
    if (_phone && /^(13[0-9]|14[0-9]|15[0-9]|18[0-9]|17[0-9]|19[0-9])\d{8}$/i.test(_phone)) {
        $(obj).siblings('em').hide();
    } else {
        $(obj).siblings('em').show();
    }
}
// 必填项校验
function vaildRequire(dom) {
    var _val = $(dom).val();
    if (!_val) {
        $(dom).siblings('em').show();
    } else {
        $(dom).siblings('em').hide();
    }
}
function getSMSCodeMark(dom) {
    if ($(dom).attr('disabled')) return false;
    var form = $(dom).closest('form');
    var phoneDom = form.find('.phone');
    var _phone = phoneDom.val();
    if (!_phone || !/^(13[0-9]|14[0-9]|15[0-9]|18[0-9]|17[0-9]|19[0-9])\d{8}$/i.test(_phone)) {
        alert('请输入正确的手机号码')
    } else {
        var get_code_url = $('#get_SMS_code_url').val();
        var key = $('#key').val();
        var sign = hex_md5(_phone+key);
        $.ajax({
            type: 'post',
            url: get_code_url,
            data: {
                'phone': _phone,
                'token': $('#token').val(),
                'sign': sign
            },
            dataType: 'json',
            success: function (res) {
                if (res.code == 200) {
                    $(dom).attr('disabled', true);
                    var seconds = 60;
                    var timer = setInterval(() => {
                        seconds--;
                        if (seconds > 0) {
                            $(dom).text(seconds + 's后重新获取');
                        } else {
                            seconds = 60;
                            clearInterval(timer);
                            $(dom).removeAttr('disabled').text('获取验证码')
                        }
                    }, 1000);
                }
            }
        })
    }
}
// 获取短信验证码
function getSMSCode(dom) {
    if ($(dom).attr('disabled')) return false;
    var form = $(dom).closest('form');
    var phoneDom = form.find('.jz-user-phone')
    var _phone = phoneDom.val();
    // console.log(_phone, form, phoneDom)
    if (!_phone || !/^(13[0-9]|14[0-9]|15[0-9]|18[0-9]|17[0-9]|19[0-9])\d{8}$/i.test(_phone)) {
        phoneDom.siblings('em').show();
        // if (phoneDom.siblings('em')) {
        // } else {
        //     alert('请输入正确的手机号');
        // }
    } else {
        phoneDom.siblings('em').hide();
        var get_code_url = $('#get_SMS_code_url').val();
        var key = $('#key').val();
        var sign = hex_md5(_phone+key);
        $.ajax({
            type: 'post',
            url: get_code_url,
            data: {
                'phone': _phone,
                'token': $('#token').val(),
                'sign': sign
            },
            dataType: 'json',
            success: function (res) {
                if (res.code == 200) {
                    $(dom).attr('disable', true);
                    var seconds = 60;
                    var timer = setInterval(() => {
                        seconds--;
                        if (seconds > 0) {
                            $(dom).text(seconds + 's后重新获取');
                        } else {
                            seconds = 60;
                            clearInterval(timer);
                            $(dom).removeAttr('disabled').text('获取验证码')
                        }
                    }, 1000);
                }
            }
        })
    }
}
//    //新 预约 
function handleAppointment(obj) {
    var form = $(obj).closest('form');
    var phoneDom = form.find('.phone');
    var codeDom = form.find('.code');
    var _phone = phoneDom.val();

    if (!_phone || !/^(13[0-9]|14[0-9]|15[0-9]|18[0-9]|17[0-9]|19[0-9])\d{8}$/i.test(_phone)) {
        phoneDom.siblings('em').show();
        return false;
    } else {
        var name = '';
        var village = '';
        var remark = '';
        var area = '';
        var m_type = $('#m_subscribe_type').val();
        var host_add_subscribe = $('#host_add_subscribe').val();
        $.ajax({
            type: 'post',
            url: host_add_subscribe,
            data: {
                'phone': _phone,
                'name': name,
                'address': village,
                'area': area,
                'utm_from': $('#utm_from').val(),
                'type': m_type,
                'remark': remark
            },
            dataType: 'json',
            success: function (res) {
                if (res['status'] == '200') {
                    if ($('#utm_from').val()) {
                        window._agl && window._agl.push(['track', ['success', { t: 3 }]])
                    }
                    alert('预约成功！工作人员会以最快速度与您联系。');
                    form.find('input').val('');
                    var leyuUrl = 'https://looyuoms7813.looyu.com/chat/form?c=20003252&conf=11538&cmd=save&column0=' + name + '&column1=' + _phone + '&column2=' + village + '&column3=' + remark + '';
                    newWin(leyuUrl);
                } else {
                    alert('预约失败');
                }
            }
        });
    }
}
// 获取报价
function getQuote(data) {
    var host_get_offer = $('#host_get_offer').val();
    if (host_get_offer) {
        $.ajax({
            url: host_get_offer,
            type: 'POST',
            dataType: 'JSON',
            data: data,
            success: function (res) {
                if (res.status == 200) {
                     if ($('#utm_from').val()) {
                                        window._agl && window._agl.push(['track', ['success', { t: 3 }]])
                     }
                    var data = res.data_list
                    alert('您家的装修预算，全包：' + data.all_money + '元，半包：' + data.part_money + '元， 以上为估算报价仅供参考，实际报价以量房为准。')
                } else {
                    alert('报价失败');
                }
            },
            error: function (e) {
                alert('报价失败');
            }
        });
    }
}
// 获取报价
function getHousePrice(dom) {
    var form = $(dom).closest('form');
    var _name = form.find('.jz-user-name').val();
    var _area = form.find('.jz-user-area').val();
    var _phone = form.find('.jz-user-phone').val();
    var m_type = $('#m_subscribe_type').val();
    form.find('em').hide();
    if (!_name) {
        form.find('.jz-user-name').siblings('em').show();
        return false;
    }
    if (!_area) {
        form.find('.jz-user-area').siblings('em').show();
        return false;
    }
    if (!_phone) {
        form.find('.jz-user-phone').siblings('em').show();
        return false;
    }
    if (_phone && !/^(13[0-9]|14[0-9]|15[0-9]|18[0-9]|17[0-9]|19[0-9])\d{8}$/i.test(_phone)) {
        form.find('.jz-user-phone').siblings('em').show();
        return false;
    } else {
        var data = { area: _area, phone: _phone, name: _name, city: '', grade: '', type: m_type };
        getQuote(data);
        // 提交数据,清空电话号码。。。。。
        form.find('.jz-user-phone').val('');
    }
}
$(document).ready(function () {
    //新计算
    // 立即获取报价
    // $('.getPrice').on('click', function() {
    //     var _name = $('.jz-user-name').val();
    //     var _area = $('.jz-user-area').val();
    //     var _phone = $('.jz-user-phone').val();

    //     var m_type =  $('#m_offer_type').val();
    //     if (!_name) {
    //         $('.form-item>em').hide();
    //         $('.jz-user-name').siblings('em').show();
    //         return false;
    //     } else if(!_area){
    //         $('.form-item>em').hide();
    //         $('.jz-user-area').siblings('em').show();
    //         return false;
    //     } else if (!_phone) {
    //         $('.form-item>em').hide();
    //         $('.jz-user-phone').siblings('em').show();
    //         return false;
    //     } else if(!/^(13[0-9]|14[0-9]|15[0-9]|18[0-9]|17[0-9])\d{8}$/i.test(_phone)){
    //         $('.form-item>em').hide();
    //         $('.jz-user-phone').siblings('em').show();
    //         return false;
    //     } else {
    //             var data = {area: _area,phone: _phone,name: _name,city: '',grade: '',type:m_type};
    //             getQuote(data);
    //             // 提交数据,清空电话号码。。。。。
    //             $('.jz-user-phone').val('');
    //     }
    // });

    // 城市切换
    $('.city').click(function (c) {
        $(this).find('.xiangxia2').toggleClass('transform');
        $('.all_city').toggle();
        c.stopPropagation();
        $('.back1').click(function () {
            $('.all_city').hide();
            $('.city').find('.xiangxia2').removeClass('transform');
        })
    });
    //根据首字母城市高亮选中
    $(".all_letter a").click(function () {
        var initial = $(this).text();
        $(this).addClass('on').siblings('a').removeClass('on');
        $(".region").find('li>a').removeClass('on');
        $(".region").find('[class="' + initial + '"]').addClass('on');
    });

    // 顶部nav
    $('.caidan1').click(function (n) {
        $('.top_nav').toggle();
        n.stopPropagation();
        $('body').click(function () {
            $('.top_nav').hide();
        })
    });
    // 搜索
    $('.sousuo3').click(function () {
        $('.search').toggle();
    });
    $('.drop_down').click(function (g) {
        $(this).find('i').toggleClass('transform');
        $('.list').toggle();
        g.stopPropagation();
        $('body').click(function () {
            $('.list').hide();
            $('.drop_down').find('i').removeClass('transform');
        })
    });

    $('.list li').click(function () {
        /*$(this).addClass('on').siblings().removeClass('on');
         $('.drop_down a').text(($(this).text()));
         $('.list').toggle();
         $('.drop_down').find('i').removeClass('transform');*/
        $('.drop_down a').text(($(this).text()));
        $('.drop_down a').attr('k', $(this).attr('k'));
        if ($(this).attr('k') == 'anli') {
            $('.keyword').attr('placeholder', '楼盘名称、户型、风格、面积、预算');
        } else {
            $('.keyword').attr('placeholder', '请输入搜索关键词');
        }
        $('.list').toggle();
        $('.drop_down').find('i').removeClass('transform');
    });

    $(".keyword").bind("search", function () {
        //要执行的方法
        var searchType = $(".drop_down a").attr('k');
        var keyword = $(".keyword").val();
        hosturl = $('input[name= hosturl]').val();
        if (keyword && searchType) {
            window.location.href = hosturl + searchType + '?keywords=' + keyword;
        }
    });
    /*$(".keyword").keydown(function (e) {
     if (e.keyCode == 13) {
     alert('搜索');
     }
     });*/

    // banner
    $(".main_img").touchSlider({
        flexible: true,
        speed: 200,
        paging: $(".point li"),
        counter: function (e) {
            $(".point li").removeClass("on").eq(e.current - 1).addClass("on");//图片顺序点切换
        }
    });
    // 户型结构
    $('.structure_down').click(function (e) {
        $(this).find('em').toggleClass('transform');
        $('.structure_list').toggle();
        e.stopPropagation();
        $('body').click(function () {
            $('.structure_list').hide();
            $('.structure_down').find('em').removeClass('transform');
        })
    });
    $('.structure_list li').click(function () {
        $('.structure_down').text(($(this).text()));
        $('.structure_down').attr('value', $(this).attr('value'));
        $('.structure_list').toggle();
        $('.structure_down').find('em').removeClass('transform');
    });
    // 装修档次
    $('.grade_down').click(function (g) {
        $(this).find('em').toggleClass('transform');
        $('.grade_list').toggle();
        g.stopPropagation();
        $('body').click(function () {
            $('.grade_list').hide();
            $('.grade_down').find('em').removeClass('transform');
        })
    });
    $('.grade_list li').click(function () {
        $('.grade_down').text(($(this).text()));
        $('.grade_down').attr('value', $(this).attr('value'));
        $('.grade_list').toggle();
        $('.grade_down').find('em').removeClass('transform');
    });
    // 经典案例  实景案例
    $('.case').find('h4').click(function () {
        var liindex = $(this).index();
        $(this).addClass('on').siblings().removeClass('on');
        $('.case .slide_frame').eq(liindex - 1).addClass('on').siblings('.case .slide_frame').removeClass('on');
    });
    // 经典案例  实景案例
    $('.building').find('h4').click(function () {
        var liindex = $(this).index();
        $(this).addClass('on').siblings().removeClass('on');
        $('.building .slide_frame').eq(liindex - 1).addClass('on').siblings('.building .slide_frame').removeClass('on');
    });
    // 经典案例  实景案例---case_list.html
    /*    $('.cases_list').find('h2').click(function () {
            var liindex = $(this).index();
            $(this).addClass('on').siblings().removeClass('on');
            $('.all_case').eq(liindex).addClass('on').siblings('.all_case').removeClass('on');
        });*/
    // 经典案例
    $('.sutra .genre').find('th').click(function () {
        var liindex = $(this).index();
        $(this).addClass('on').siblings().removeClass('on');
        $('.sutra .all').eq(liindex).addClass('on').siblings('.sutra .all').removeClass('on');
    });
    $('.sutra .all').find('td').click(function () {
        $(this).addClass('on').siblings().removeClass('on');
    });
    // 装修案例
    // var clistl = $('.case .ul_left li').length;
    // var clistr = $('.case .ul_right li').length;
    // var clistw = $('.case .slip_layer li').width();
    // $('.case .ul_left ul').css('width',clistl*(clistw+22)+'px');
    // $('.case .ul_right ul').css('width',clistr*(clistw+22)+'px');
    $('.anli').click(function () {
        var url = $(this).attr('data-url');
        // $('.anliMore').attr('href', domain + '/' + url);
        $(this).addClass('on').siblings('h3').removeClass('on');
        $('.anliDiv').removeClass('on');
        $('#' + url + '').addClass('on');
    });
    $('.anli_index_right').click(function () {
        var mySwiper = new Swiper('.ul_right_anlidiv', {
            slidesPerView: 1.1730,
        });
    });
    //滑动TAB
    var mySwiper = new Swiper('.ul_left', {
        // slidesPerView: 2.1176,
        //slidesPerView: 0.9535,
        loop: true,
        autoplay: 5000,
        spaceBetween: 30,
        autoplayDisableOnInteraction: false
    });
    var styleSwiper = new Swiper('.ul_left_style', {
        // slidesPerView: 2.1176,
        //slidesPerView: 0.9535,
    	freeMode:true,
        loop: true,
        speed:  5000,
        autoplay: {
	    	delay: 0,
	    },
	    autoplayDisableOnInteraction: false
    });
    // 热装楼盘
    $('.house-nav').on('click', 'a', function () {
        var url = $(this).attr('data-url');
        $(this).addClass('active').siblings().removeClass('active');
        $('.house-list>div').removeClass('on');
        $('#' + url + '').addClass('on');
        var mySwiper = new Swiper('.ul_left', {
            slidesPerView: 1.1730,
        });
    })
    // 热门楼盘
    // var blistl = $('.building .ul_left li').length;
    // var blistr = $('.building .ul_right li').length;
    // var blistw = $('.building .slip_layer li').width();
    // $('.building .ul_left ul').css('width',blistl*(blistw+22)+'px');
    // $('.building .ul_right ul').css('width',blistr*(blistw+22)+'px');
    $('.lp').click(function () {
        var url = $(this).attr('data-url');
        $('.lpMore').attr('href', domain + '/' + url);
        $(this).addClass('on').siblings('h3').removeClass('on');
        $('.lpdiv').removeClass('on');
        $('#' + url + '').addClass('on');

    });
    $('.lp_index_right').click(function () {
        var mySwiper = new Swiper('.ul_right_lpdiv', {
            slidesPerView: 1.1730,
        });
    })
    // 设计师团队
    /*  $('.designer-nav').on('click', 'a', function() {
          var url = $(this).attr('data-url');
          $(this).addClass('active').siblings().removeClass('active');
          $('.designer-list>div').removeClass('on');
          $('#' + url + '').addClass('on');
          var mySwiper = new Swiper('.ul_left', {
              slidesPerView: 1.1730,
          });
      })*/
    // 实景案例
    $('.real .genre').find('th').click(function () {
        var liindex = $(this).index();
        $(this).addClass('on').siblings().removeClass('on');
        $('.real .all').eq(liindex).addClass('on').siblings('.real .all').removeClass('on');
    });
    $('.real .all').find('td').click(function () {
        $(this).addClass('on').siblings().removeClass('on');
    });
    // 服务团队
    $('.all_teams .genre').find('th').click(function () {
        var liindex = $(this).index();
        $(this).addClass('on').siblings().removeClass('on');
        $(this).children('span').toggleClass('transform');
        $(this).siblings().children('span').removeClass('transform');
        $('.all_teams .all').eq(liindex).toggleClass('on').siblings('.all_teams .all').removeClass('on');
    });
    $('.all_teams .all').find('td').click(function () {
        $(this).addClass('on').siblings().removeClass('on');
    });
    // 热门楼盘
    $('.city1 .mores').click(function () {
        $('.city1 .more_city').toggleClass('show');
        $(this).toggleClass('transform');
    });
    $('.city1 .all').find('td').click(function () {
        $(this).addClass('on').siblings().removeClass('on');
    });
    // 热门楼盘 工地
    $('.building_site .genre').find('th').click(function () {
        var liindex = $(this).index();
        $(this).addClass('on').siblings().removeClass('on');
        $('.building_site .all').eq(liindex).addClass('on').siblings('.building_site .all').removeClass('on');
    });
    $('.building_site .all').find('td').click(function () {
        $(this).addClass('on').siblings().removeClass('on');
    });
    // 知识
    $('.lores_title').click(function () {
        var liindex = $(this).index();
        $(this).addClass('on').siblings().removeClass('on');
        $('.fixture').eq(liindex).addClass('on').siblings('.fixture').removeClass('on');
    });
    // 装修流程
    $('.choice_stage').click(function () {
        $('.stage_down').toggle();
    });
    $('.stage').click(function () {
        $(this).parent('.stagelist').toggleClass('on');
        $(this).parent('.stagelist').siblings('.stagelist').removeClass('on');
    });
    /*$('.stage_down li').click(function(){
     $('.stage_show').text(($(this).text()));
     $('.stage_down').toggle();
     $('.choice_stage').find('svg').removeClass('transform');
     });*/
    // 材料优质环保
    $('.datum_nav li').click(function () {
        var liindex = $(this).index();
        $(this).addClass('on').siblings().removeClass('on');
        $('.datum_date').eq(liindex).addClass('on').siblings('.datum_date').removeClass('on');
    });
    // 走进居众
    $('.ahout_us_one').click(function () {
        $('.ahout_us_nav').toggle();
    });
    // $('.ahout_us_nav').click(function () {
    //     $(this).addClass('on').siblings('.enter_title').removeClass('on');
    //     $('.ahout_us_one i').text(($(this).text()));
    //     $('.ahout_us_nav').toggle();
    // });
    $('.enters_nav').click(function () {
        $(this).addClass('on').siblings('.enters_nav').removeClass('on');
    });
    $('.enter_title').click(function () {
        var liindex = $(this).index();
        $('.ahout_us_nav').hide();
        $('.enters').eq(liindex - 1).addClass('on').siblings('.enters').removeClass('on');
    });
    // 打开弹窗
    $(document).on('click', '.application', function () {
        $('.clarity_layer').toggle('on');
        $('.clarity_layer_window').toggle('on');
        $('.clarity_layer_window_span .captio').text(('申请' + $(this).siblings('.article').text()))
        $('.clarity_layer_window_span .explain').text(('免费' + $(this).siblings('.hidden').text()))
        if ($(this).siblings('.article').text() === '上门验房') {
            $('.apply_popup_button').text('申请免费验房')
        }
        else if ($(this).siblings('.article').text() === '上门量房') {
            $('.apply_popup_button').text('申请免费量房')
        }
        else {
            $('.apply_popup_button').text(('申请免费' + $(this).siblings('.article').text()))
        }
        return false;
    })
    $('.hots_build_button').click(function () {
        $('.clarity_layer').toggle();
        $('.clarity_layer_window').toggle();
        return false;
    })
    // $('.fix-right-enter').click(function () {
    //     $('.clarity_layer').toggle();
    //     $('.clarity_layer_window').toggle();
    //     return false;
    // })
    // 关闭弹窗
    $('.close').click(function () {
        $('.clarity_layer').hide();
        $('.clarity_layer_window').hide();
    });
    // 节点展开
    $('.building_list li .node_name').click(function () {
        $(this).parent('li').toggleClass('on');
        $(this).parent('li').siblings('li').removeClass('on');
    });
    // 设计师详情
    $('.teams_page_list .team4 li').click(function () {
        var liindex = $(this).index();
        if (liindex == 3) {
            return false;
        }
        $(this).addClass('on').siblings().removeClass('on');
        $('.teams_page_list4').eq(liindex).addClass('on').siblings('.teams_page_list4').removeClass('on');
    });

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

    //V5客服
    /*var v5_hm = document.createElement("script");
    v5_hm.src = "https://www.v5kf.com/136934/v5kf.js";
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(v5_hm, s);*/
    $('#zaixian').click(function () {
        // $("#chat_btn").click();
        // $(".v5-btn-img").click();
        $(".doyoo_link").click();
    });

    //移动端统计代码
    var _hmt = _hmt || [];
    (function () {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?5210295fb411a68a3d13fcdb9619753c";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();

    //地区市获取
    $("#common_city").on("change", function () {
        pid = $("#common_city").find("option:selected").attr("k");
        if (pid) {
            host_url = $('input[name=host_url]').val();
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

    // 品牌实力 ------------------------
    function toggleSelect(selectIndex) {
        $('.select-box li').css('display', 'none');
        $('.bidding .type-12-ul li .mask').css('display', 'block');
        $($('.bidding .type-12-ul li .mask')[selectIndex]).css('display', 'none');
        $($('.select-box li')[selectIndex]).css('display', 'block');
    }
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
        var left = parseInt($('.type-12-ul').css('left').replace('rem'))
        if (isLeftClick && isRightClick && left < 0) {
            isLeftClick = false
            var nowLeft = left + 4.5
            $('.type-12-ul').animate({ left: nowLeft + 'rem' })
            setTimeout(function () {
                isLeftClick = true
            }, 800)
        }
    })
    $('.type-12-right').on('click', function () {
        var left = parseInt($('.type-12-ul').css('left').replace('rem'))
        var _width = $('.type-12-ul>li').length * 4.5
        if (isLeftClick && isRightClick && (left < 0 || left == 0) && left > -(_width)) {
            isRightClick = false
            var nowLeft = left - 4.5
            $('.type-12-ul').animate({ left: nowLeft + 'rem' }, 'linear')
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

    $('.bidding .type-12-ul li').click(function () {
        selectIndex = $('.bidding .type-12-ul li').index($(this));
        toggleSelect(selectIndex);
    });

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
    $('.case-img-point').on('click', 'li', function() {
        $(this).siblings('li').removeClass('active');
        $(this).addClass('active');
        $('.case-img-list>img').eq($(this).index()).show().siblings().hide()
    })
    $('.case-style').on('click', 'li', function() {
        var index = $(this).index();
        $('.case-img-list>img').eq(index).show().siblings().hide()
        $('.case-img-point>li').eq(index).addClass('active').siblings().removeClass('active')
    })

    // console.log($(".touchslider"))
    $(".touchslider").touchSlider({
        container: this,
        duration: 350, // 动画速度
        delay: 3000, // 动画时间间隔
        margin: 5,
        mouseTouch: true,
        namespace: "touchslider",
        next: ".touchslider-next", // next 样式指定
        pagination: ".touchslider-nav-item",
        currentClass: "touchslider-nav-item-current", // current 样式指定
        prev: ".touchslider-prev", // prev 样式指定
        // scroller: viewport.children(),
        autoplay: false, // 自动播放
        viewport: ".touchslider-viewport"
    });
})

// 文章分享
// window._bd_share_config={
//         "common":{
//             "bdPopTitle":"您的自定义pop窗口标题",
//             "bdSnsKey":{},
//             "bdText":"此处填写自定义的分享内容",
//             "bdMini":"2",
//             "bdMiniList":false,
//             "bdPic":"http://localhost/centlight/public/attachment/201410/24/14/5449ef39574f5_282x220.jpg", /* 此处填写要分享图片地址 */
//             "bdStyle":"0",
//             "bdSize":"16"
//             },
//         "share":{}
// };
// with(document)0[
//                 (getElementsByTagName('head')[0]||body).
//                 appendChild(createElement('script')).
//                 src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)
// ];

$(document).ready(function () {
    var swiperMain = new Swiper('.swiper-container-main', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        speed: 1000,
        loop: true,
        autoplay: 3000,
        autoplayDisableOnInteraction: false,
    })
    // Strength   工艺行业尖端
    $('.gc-ul li').click(function () {
        var liindex = $(this).index();
        $(this).addClass('on').siblings().removeClass('on');
        $('.neirong').eq(liindex).addClass('on').siblings('.neirong').removeClass('on');
        var ID = $(this).attr("id");
        if (ID === "hydropower") {
            var mySwiper = new Swiper('.hydropower', {
                pagination: '.hydropowers',
                paginationClickable: true,
                speed: 1000,
                loop: true,
                autoplay: 3000,
                autoplayDisableOnInteraction: false,
            });
        }
        else if (ID === "waterproof") {
            var mySwiper = new Swiper('.waterproof', {
                pagination: '.waterproofs',
                paginationClickable: true,
                speed: 1000,
                loop: true,
                autoplay: 3000,
                autoplayDisableOnInteraction: false,
            });
        }
        else if (ID === "mud") {
            var mySwiper = new Swiper('.mud', {
                pagination: '.muds',
                paginationClickable: true,
                speed: 1000,
                loop: true,
                autoplay: 3000,
                autoplayDisableOnInteraction: false,
            });
        }
        else if (ID === "carpentry") {
            var mySwiper = new Swiper('.carpentry', {
                pagination: '.carpentrys',
                paginationClickable: true,
                speed: 1000,
                loop: true,
                autoplay: 3000,
                autoplayDisableOnInteraction: false,
            });
        }
        else if (ID === "paint") {
            var mySwiper = new Swiper('.paint', {
                pagination: '.paints',
                paginationClickable: true,
                speed: 1000,
                loop: true,
                autoplay: 3000,
                autoplayDisableOnInteraction: false,
            });
        }
        else if (ID === "install") {
            var mySwiper = new Swiper('.install', {
                pagination: '.installs',
                paginationClickable: true,
                speed: 1000,
                loop: true,
                autoplay: 3000,
                autoplayDisableOnInteraction: false,
            });
        }
    });
    $('.gc-ul li#hydropower').click();
})
var bidding_timer = null;
bidding_timer = setInterval(() => {
    var flag = parseInt(Math.random());
    $('.total_money').html(flag%2 == 0 ? parseInt(Math.random() * 100000) : parseInt(Math.random() * 10000))
}, 300)
/*报价*/
function getQouteBidding(param, type = '') {
    var area = $(".build_area").val();
    var tel = $(".telphone").val();
    var type = $(".build_type").val();
    var zh_type = $(".build_type").find("option:selected").text();
    var grade = $(".decoration_grade").val();
    var zh_grade = $(".decoration_grade").find("option:selected").text();
    var prov = $('.prov_select option:selected');
    var city = $('.city_select option:selected');
    var reg = /^[1-9]{1}[0-9]{1,}$/;
    var m_type = $('#m_offer_type').val();
    var host_get_offer = $('#host_get_offer').val();
    // alert(host_get_offer);
    if (!host_get_offer) {
        alert("获取失败");
        return false;
    }
    if (!area) {
        alert("房屋面积不能为空");
        $(".build_area").focus();
        return false;
    }
    if (!reg.test(area)) {
        alert("请输入正确的房屋面积");
        return false;
    }
    if (!tel) {
        alert("电话不能为空");
        $(".telphone").focus();
        return false;
    }
    if (!/^(13[0-9]|14[0-9]|15[0-9]|18[0-9]|17[0-9]|19[0-9])\d{8}$/i.test(tel)) {
        alert('手机号码不正确');
        return false;
    } else {
        $.ajax({
            url: host_get_offer,
            type: 'post',
            data: {
                'area': area,
                'house': type,
                'grade': grade,
                'phone': tel,
                'city': prov.text() + '-' + city.text(),
                'type': m_type
            },
            dataType: 'json',
            success: function (res) {
                if (res.status == 200 && res.data_list) {
                    if ($('#utm_from').val()) {
                            window._agl && window._agl.push(['track', ['success', { t: 3 }]])
                    }
                    var money = res.data_list;
                    $(".total_money").html(money['all_money']);
                    clearInterval(bidding_timer);
                    alert('预约成功')
                    $(".build_area").val('')
                    $(".telphone").val('')
                    $('.bidding-code').val('');
                    // $(".money_part").html(money['part_money']);
                    // $(".telphone").val('');
                    // var leyuUrl = 'https://looyuoms7813.looyu.com/chat/form?c=20003252&conf=11538&cmd=save&column0=' + area + '&column1=' + zh_type + '&column2=' + zh_grade + '&column3=' + tel + '&column4=' + prov.text() + '-' + city.text();
                    // newWin(leyuUrl);
                } else {
                    alert('报价失败，请稍后重试');
                }
            }, error: function () {
                alert('报价失败，请稍后重试');
            }
        });       
    }
}
function getQoute(param, type = '') {
    var area = $(".build_area").val();
    var tel = $(".telphone").val();
    var type = $(".build_type").val();
    var zh_type = $(".build_type").find("option:selected").text();
    var grade = $(".decoration_grade").val();
    var zh_grade = $(".decoration_grade").find("option:selected").text();
    var prov = $('.prov_select option:selected');
    var city = $('.city_select option:selected');
    var reg = /^[1-9]{1}[0-9]{1,}$/;
    var m_type = $('#m_offer_type').val();
    /* if(!type && (!prov.val() || !city.val())){
         alert('请选择所在城市');
         return false;
     }*/
    var host_get_offer = $('#host_get_offer').val();
    alert(host_get_offer);
    if (!host_get_offer) {
        alert("获取失败");
        return false;
    }
    if (!area) {
        alert("房屋面积不能为空");
        $(".build_area").focus();
        return false;
    }
    if (!reg.test(area)) {
        alert("请输入正确的房屋面积");
        return false;
    }
    if (!tel) {
        alert("电话不能为空");
        $(".telphone").focus();
        return false;
    }
    if (!/^(13[0-9]|14[0-9]|15[0-9]|18[0-9]|17[0-9]|19[0-9])\d{8}$/i.test(tel)) {
        alert('手机号码不正确');
        return false;
    }
    $.ajax({
        url: host_get_offer,
        type: 'post',
        data: {
            'area': area,
            'house': type,
            'grade': grade,
            'phone': tel,
            'city': prov.text() + '-' + city.text(),
            'type': m_type
        },
        dataType: 'json',
        success: function (res) {
            if (res.status == 200 && res.data_list) {
                if ($('#utm_from').val()) {
                        window._agl && window._agl.push(['track', ['success', { t: 3 }]])
                }
                var money = res.data_list;
                $(".money_all").html(money['all_money']);
                $(".money_part").html(money['part_money']);
                $(".telphone").val('');
                var leyuUrl = 'https://looyuoms7813.looyu.com/chat/form?c=20003252&conf=11538&cmd=save&column0=' + area + '&column1=' + zh_type + '&column2=' + zh_grade + '&column3=' + tel + '&column4=' + prov.text() + '-' + city.text();
                newWin(leyuUrl);
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
                var liStr = '';
                $.each(res['build_type'], function (k, v) {
                    liStr += '<option value="' + v.id + '">' + v.name + '</option>';
                });
                $(".structure_list").html(liStr);
            }
        }
    });
}

/*预约*/
function subscribe(obj) {
    var form = $(obj).closest('form');
    var tel = form.find('.phone').val();
    var name = form.find('.name').val();
    var village = form.find('.village').val() ? form.find('.village').val() : '';
    var area = form.find('.area').val() ? form.find('.area').val() : 0;
    var ctype = $('#m_subscribe_type').val() ? $('#m_subscribe_type').val() : 5;
    var prov = form.find('.prov_select option:selected').text() ? form.find('.prov_select option:selected').text() : '';
    var city = form.find('.city_select').val() ? form.find('.city_select').val() : '';
    var designName = form.find('.designName').val() ? form.find('.designName').val() : '';
    var host_add_subscribe = $('#host_add_subscribe').val();

    var remark = '';
    if (prov && city) {
        remark = '客户预约的省市：' + prov + '/' + city;
    }
    if (designName) {
        remark = '客户预约设计师：' + designName;
    }
    if (!name) {
        alert('名称不能为空');
        form.find('.name').focus();
        return false;
    }
    if (!/^(13[0-9]|14[0-9]|15[0-9]|18[0-9]|17[0-9]|19[0-9])\d{8}$/i.test(tel)) {
        alert('手机号码不正确');
        form.find('.tel').focus();
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
                'utm_from': $('#utm_from').val(),
                'type': ctype,
                'remark': remark
            },
            dataType: 'json',
            success: function (res) {
                if (res['status'] == '200') {
                    form.find('input').val('');
                    if ($('#utm_from').val()) {
                        window._agl && window._agl.push(['track', ['success', { t: 3 }]])
                    }
                    alert('预约成功！工作人员会以最快速度与您联系。');
                    var leyuUrl = 'https://looyuoms7813.looyu.com/chat/form?c=20003252&conf=11538&cmd=save&column0=' + name + '&column1=' + tel + '&column2=' + village + '&column3=' + remark + '';
                    newWin(leyuUrl);
                    //关闭预约窗口
                    $('.close').click();
                } else {
                    alert('预约失败');
                }
            }
        });             
    }
}

function getSubscribeNum() {
    $.ajax({
        type: 'post',
        url: api_totalsubscribe_url,
        data: {},
        dataType: 'json',
        success: function (res) {
            if (res.data.count) {
                $(".subscribeNum").text(res.data.count);
            }
        }
    });
}

function applyVisit() {
    var curProtocol = window.location.protocol.split(':')[0];
    url = (curProtocol === 'https') ? 'https' : 'http';
    window.location.href = url + '://' + window.location.host + '/pinpai/';
    return false;
}

//时间戳转化成时间：
function timetrans(date) {
    var date = new Date(date * 1000);//如果date为13位不需要乘1000
    var Y = date.getFullYear() + '-';
    var M = (date.getMonth() + 1 < 10 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1) + '-';
    var D = (date.getDate() < 10 ? '0' + (date.getDate()) : date.getDate()) + ' ';
    var h = (date.getHours() < 10 ? '0' + date.getHours() : date.getHours()) + ':';
    var m = (date.getMinutes() < 10 ? '0' + date.getMinutes() : date.getMinutes()) + ':';
    var s = (date.getSeconds() < 10 ? '0' + date.getSeconds() : date.getSeconds());
    return Y + M + D + h + m + s;
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

function strToJson(str) {
    var json = eval('(' + str + ')');
    return json;
}

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

V5CHAT('onChatShow', function () {
    if ($('#v5frame').css('display') === 'block') {
        $('meta[name="viewport"]').attr('content', 'width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0');
        $('body').addClass('viewport');
        var _wid = document.documentElement.clientWidth;
        V5CHAT('onChatHide', function () {
            if ($('#v5frame').css('display') === 'none') {
                $('meta[name="viewport"]').attr('content', 'user-scalable=no, width=' + _wid);
                $('body').removeClass('viewport');
            }
        });
    }
});

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
function btnKeFu() {
    V5CHAT('showChat');
}*/
/* 新版客服接入 */



// 号码轮播
var topVal = 0;
$(function () {
    setInterval(function () {
        topVal = topVal+18;
        var maxHeight = parseInt($('.js-bidding-cal .inner').css('height'));
        if(topVal>=maxHeight){
            topVal = 0;
        }
        $('.js-bidding-cal .inner').css('top','-'+topVal+'px');
    }, 3000);
});