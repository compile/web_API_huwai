/**
 * 刷新页面
 */
function refreshPage() {
    var sessionStorage = window.sessionStorage;
    var index = location.href.lastIndexOf("/");
    if (index != -1) {
        var href = location.href.substring(index + 1);
        if (href !== 'index.php?module=Customer') {
            sessionStorage.setItem("refreshPage", href);
        }
    }
}

// 无需等待 onload
refreshPage();