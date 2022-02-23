// 鍗犱綅
$('[placehold]').each(function () {
    var text = $(this).attr('placehold');
    this.value = text;
    $(this).on('blur', function (event) {
        if (!this.value) {
            this.value = text;
        }
    }).on('focus', function (event) {
        if (this.value == text) {
            this.value = '';
        }
    });
});
// 杞挱
(function () {
    $.fn.lunbo = function (delayTime) {
        var that = this;
        var $lists = $(this).find('.lunbo-list');
        var $indexList = $(this).find('.lunbo-index');
        var length = $lists.length;
        var timer = null;
        var W = $lists.width();
        var H = $lists.height();
        var curIndex = 0;
        var nextIndex = 0;
        var flagTimer = false;

        function freshWithNewIndex() {
            if (curIndex == nextIndex) {
                return;
            }
            $lists.eq(nextIndex).stop().fadeIn().end().eq(curIndex).stop().fadeOut();
            curIndex = nextIndex;
            $indexList.eq(nextIndex).addClass('act').siblings().removeClass('act');
        }

        function indexPre() {
            nextIndex = curIndex - 1 < 0 ? length - 1 : curIndex - 1;
        }

        function indexNext() {
            nextIndex = curIndex + 1 > length - 1 ? 0 : curIndex + 1;
        }

        $(this).on('click', '.lunbo-ctr-pre', function () {
            indexPre();
            freshWithNewIndex();
        });
        $(this).on('click', '.lunbo-ctr-next', function () {
            indexNext();
            freshWithNewIndex();
        });
        $(this).on('click', '.lunbo-index', function () {
            nextIndex = $(that).find('.lunbo-index').index(this);
            freshWithNewIndex();
        });
        $(this).on('mouseover', function () {
            flagTimer = true;
        });
        $(this).on('mouseleave', function () {
            flagTimer = false;
        });
        timer = setInterval(function () {
            if (flagTimer) return;
            indexNext();
            freshWithNewIndex();
        }, delayTime || 2000);
    }
})(jQuery);
// 琛ㄥ崟鎻愪氦
$('.comitBtn').click(function () {
    var $form = $(this).closest('form');
    var $phone = $form.find('input[name=phone]');
    if (!$phone.val().match(/^[0-9,-]{7,13}$/)) {
        alert('请填写手机号码!');
        $phone.focus();
        return false;
    } else {
        var data = {specialid: specialid};

        $form.find('input[name]').add($form.find('select[name]'))
            .each(function () {
                data[$(this).attr('name')] = $(this).val();
            })
        data.desc = noStr($(this).attr('desc'))
            + noStr(data.shi) + noStr(data.ting)
            + noStr(data.chu) + noStr(data.wei) + noStr(data.yang);
        console.log(data);

        function noStr(str) {
            return str ? str : '';
        }

        function resetForm() {
            $form[0].reset();
            $form.find("[placehold]").each(function () {
                $(this).val($(this).attr('placehold'))
            })
        }
        $.ajax({
            url: '/api/user/special_appoint.php',
            dataType: 'jsonp',
            data: data,
            success: function (d) {
                alert(d.msg);
                if(d.code==1){
                    if($('body').find('.zyTan0')){
                        $('.zyTan0').hide();
                    }
                }
             
                resetForm();
            },
            error: resetForm
        })
    }
})