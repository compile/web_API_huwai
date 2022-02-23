
(function () {
    
    if (! ("performance" in window && window.performance && window.performance.getEntriesByName)) {
        return;
    }
    var _ishttp = 'https:' == document.location.protocol ? 'https' : 'http'; 
    performance.setResourceTimingBufferSize(300);
    var _id = _guid();
    var _url = _ishttp + '://rum.xundayun.cn/probe/source/dd-rum?id=' + _id;
    var _img = new Image(1, 1);

    _img.src = _url;
    var _status = false;

    _img.onload = function () {
        var _result = window.performance.getEntriesByName(_url, 'resource')[0];
        //console.log(_result);
        if (_result) {
            _data(_result, _id);
        } else {
            _empty(_id, 'exception');

        }
        _status = true;
    }

    _img.onerror = function () {
        _empty(_id, 'load failure');

        _status = true;
    }

    setTimeout(function() {
        if (!_status) {
            _empty(_id, 'timeout');

        }
    }, 15000);
    function _guid() {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
            var r = Math.random() * 16 | 0,
                v = c == 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    }

    function _data(data, id) {
        var _res = "rs=" + data.redirectStart + "&re=" + data.redirectEnd + "&fs=" + data.fetchStart + "&dls=" + data.domainLookupStart + "&dle=" + data.domainLookupEnd + "&cs=" + data.connectStart + "&ce=" + data.connectEnd + "&reqs=" + data.requestStart + "&ress=" + data.responseStart + "&rese=" + data.responseEnd + "&d=" + data.duration + "&sct=" + data.secureConnectionStart + "&dbs=" + data.decodedBodySize + "&ebs=" + data.encodedBodySize + "&ts=" + data.transferSize ;

        var _imgData = new Image(1, 1);
        _imgData.src = _ishttp + '://rum.xundayun.cn/probe/resault/rum' + id + '.gif?' + _res;

    }

    function _empty(id, err) {
        var _res = "&msg=" + err;
        var _imgData = new Image(1, 1);
        _imgData.src = _ishttp + '://rum.xundayun.cn/probe/resault/rum' + id + '.gif?' + _res;
    }
})()


