function createXHR() {
    if (typeof XMLHttpRequest != 'undefined') {
        return new XMLHttpRequest();
    } else if (typeof ActiveXObject != 'undefined') {
        var versions = [
            'MSXML2.XMLHttp.6.0',
            'MSXML2.XMLHttp.3.0',
            'MSXML2.XMLHttp'
        ];
        for (var i = 0; i < versions.length; i++) {
            try {
                return new ActiveXObject(version[i]);
            } catch (e) {
                //跳过
            }
        }
    } else {
        throw new Error('您的浏览器不支持 XHR 对象！');
    }
}

function ajax(obj) {

    var xhr = new createXHR();
    obj.url = obj.url + '?rand=' + Math.random();
    obj.data = params(obj.data);
    if (obj.method === 'get') obj.url = obj.url.indexOf('?') == -1 ?
        obj.url + '?' + obj.data : obj.url + '&' + obj.data;
    if (obj.async === true) {
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) callback();
        };
    }
    xhr.open(obj.method, obj.url, obj.async);
    if (obj.method === 'post') {
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(obj.data);
    } else {
        xhr.send(null);
    }
    if (obj.async === false) {
        callback();
    }

    function callback() {
        if (xhr.status == 200) {
            err_mesg.style.display="none"
            obj.success(xhr.responseText); //回调
        } else {
            // 失败的时候执行的内容
           errwrap.style.height=screenHeight+'px'

           
        }
    }
}

function params(data) {
    var arr = [];
    for (var i in data) {
        arr.push(encodeURIComponent(i) + '=' + encodeURIComponent(data[i]));
    }
    return arr.join('&');
}



/*  调用方法
ajax({
    method : 'get',  //传送方式 get / post
    url : 'demo.php',  //获取接口地址
    data : {           //用对像的方法，输入要传递的数据
        'name' : 'YingHua',
        'age' : 35
    },
    success : function (text) {
         alert(text);    //数据回调！text为自定义属性
    },
    async : true   //是否异步
});
*/