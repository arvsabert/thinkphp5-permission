"use strict";

function xbGoTo(e, o, n) {
    var e = arguments[0] ? arguments[0] : "/", o = arguments[1] ? arguments[1] : 0,
        n = arguments[2] ? arguments[2] : "";
    o = 1e3 * o + 1, "" != n && xbAlert(n), setTimeout(function () {
        location.href = e
    }, o)
}

function xbRefresh(e, o) {
    var e = arguments[0] ? arguments[0] : 0, o = !!arguments[1] && arguments[1];
    e = 1e3 * e + 1, setTimeout(function () {
        o ? location.reload(!0) : (console.log(o), location.reload(!1))
    }, e)
}

function xbCheckLogin() {
    var e = !1;
    return $.ajaxSetup({async: !1}), $.get(xbCheckLoginUrl, function (o) {
        0 == o.error_code && (e = !0)
    }, "json"), e
}

function xbNeedLogin(e) {
    xbCheckLogin() ? xbGoTo(e) : (xbAlert("您需要登录"), xbSetCookie("thisUrl", e), xbShowLogin())
}

function xbNeedConfirm(e, o) {
    var o = arguments[1] ? arguments[1] : "确认操作";
    confirm(o) && (location.href = e)
}

function xbGetForm(e) {
    var o = $(e).serializeArray(), n = {};
    return $.each(o, function (e, o) {
        n[o.name] = o.value
    }), n
}

function xbSetCookie(e, o, n) {
    if (n) {
        var t = new Date;
        t.setTime(t.getTime() + 24 * n * 60 * 60 * 1e3);
        var i = "; expires=" + t.toGMTString()
    } else var i = "";
    document.cookie = e + "=" + o + i + "; path=/"
}

function xbGetCookie(e) {
    for (var o = e + "=", n = document.cookie.split(";"), t = 0; t < n.length; t++) {
        for (var i = n[t]; " " == i.charAt(0);) i = i.substring(1, i.length);
        if (0 == i.indexOf(o)) return i.substring(o.length, i.length)
    }
    return null
}

function xbDeleteCookie(e) {
    xbSetCookie(e, "", -1)
}