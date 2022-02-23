const checkAllSelector = $('.checkAll')

/**
 * 列表页面，多选和勾选
 * @param type
 */
function selectCheckBox(type) {
    if (type === 'all') {
        checkAllSelector.prop('checked', checkAllSelector.prop('checked'))
    } else {
        if ($('.checkA:checked').length === $('.checkA').length) {
            checkAllSelector.prop('checked', true)
        } else {
            checkAllSelector.prop('checked', false)
        }
    }
}

function getSelectIds() {

}


function del(id) {

    // 单选删除
    if (!id) {
        id = ''
        if (!$('.checkA:checked').length) {
            return layer.msg('未选择数据')
        }

        for (let i = 0; i < $('.checkA:checked').length; i++) {
            id += ',' + $('.checkA:checked').eq(i).val()
        }
    }
    
}