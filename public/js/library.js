

function setCookie(cookieName, cookieVal) {

    //document.cookie = cookieName+"="+cookieVal+";expires=01 Jan 2100";

    //another style
    var days = 20000;
    var date = new Date();
    date.setDate(date.getDate() + days);
    var expireTime = date.toUTCString();
    document.cookie = cookieName+"="+cookieVal+";expires="+expireTime+";path=/";
}

function getCookie(cookieName) {
    var nameEQ = cookieName + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}


function copyToClipboard(text) {
    const tempInput = $('<input>');
    $('body').append(tempInput);
    tempInput.val(text).select();
    document.execCommand('copy');
    tempInput.remove();
}


function saveVisitLog() {
    p("to save visit log");
    var fp = new Fingerprint({
        canvas: true,
        ie_activex: true,
        screen_resolution: true
    });

    var fingerprint = fp.get();
    setCookie("visitorLogId", fingerprint);


    var intervalTime = 2000  ;
    setInterval(function () {
        $.ajax({
            url : "/ajax/visit_log/save",
            type : "post",
            async : true,
            data : {
                _token : "{{ csrf_token() }}", visitorLogId : getCookie("visitorLogId"),
                current_time : Date.now(), browser : navigator.userAgent,
                url : '/'
            },
            success : function (response) {
                //p(response);
            },error: function (error) {}
        });
    }, intervalTime);
}