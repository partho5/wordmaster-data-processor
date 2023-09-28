

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


function generateRandomString(length) {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var randomString = '';
    for (var i = 0; i < length; i++) {
        const randomIndex = Math.floor(Math.random() * characters.length);
        randomString += characters.charAt(randomIndex);
    }
    return randomString;
}

function getCurrentTimestamp() {
    return new Date().getTime();
}


function generateVisitorLogId() {
    var fp = new Fingerprint({
        canvas: true,
        ie_activex: true,
        screen_resolution: true
    });
    var fingerprint = fp.get();
    var randomString = generateRandomString(5);
    var timestamp = getCurrentTimestamp();
    var separator = '-';
    var visitorLogId = `${fingerprint}${separator}${randomString}${separator}${timestamp}`;
    return visitorLogId;
}

