let browserName = "other";
let isPageShow = true;

var browserPageModal = '<style>.btn {background: #428bca;border: #357ebd solid 1px;border-radius: 3px;color: #fff;display: inline-block;font-size: 14px;padding: 8px 15px;text-decoration: none;text-align: center;min-width: 60px;position: relative;transition: color .1s ease;} .btn:hover {background: #357ebd; } .btn.btn-big {font-size: 18px;padding: 15px 20px;min-width: 100px; }.btn-close {color: #aaaaaa;font-size: 30px;text-decoration: none;position: absolute;right: 5px;top: 0; }.btn-close:hover {color: #919191; }.modal:target:before {display: none;}.modal:before {content:"";display: block;background: rgba(0, 0, 0, 0.6);position: fixed;top: 0;left: 0;right: 0;bottom: 0;z-index: 10;}.modal .modal-dialog {background: #fefefe;border: #333333 solid 1px;border-radius: 5px;margin-left: -200px;position: fixed;left: 50%;z-index: 11;width: 360px;-webkit-transform: translate(0, 0);-ms-transform: translate(0, 0);transform: translate(0, 0);-webkit-transition: -webkit-transform 0.3s ease-out;-moz-transition: -moz-transform 0.3s ease-out;-o-transition: -o-transform 0.3s ease-out;transition: transform 0.3s ease-out;top: 20%;}.modal:target .modal-dialog {top: -100%;-webkit-transform: translate(0, -500%);-ms-transform: translate(0, -500%);transform: translate(0, -500%);}.modal-body {padding: 20px;}.modal-header, .modal-footer{padding: 10px 20px;}.modal-header {border-bottom: #eeeeee solid 1px;}.modal-header h2 {font-size: 20px;}.modal-footer {border-top: #eeeeee solid 1px;text-align: right;}</style><div class="modal" id="modal-one" aria-hidden="true"><div class="modal-dialog" style="pointer-events: auto!important;"><div class="modal-header"><h2>Please note!</h2></div><div class="modal-body"><p>This browser can\'t open this link! Please open this using the Google Chrome browser!</p> <input type="text" id="cpurl" style="display:none" />  <div class="modal-footer"><a href="javascript:void(0)" id="btn-copy" class="btn" role="button" >Copy URL!</a> </div></div></div></div>';

/*on page load running event*/
window.onload = function WindowLoad(event) {
    // Check URL
    var isShareChallenge = checkIsUrlSharechallenge();
    if(isShareChallenge==true){
        // Check Browser
        checkDeviceBrowser();
        if(isPageShow==false){
            $("body").after(browserPageModal);
            // $("#modal-one").modal("show");
            $("#modal-one").show();
        }
        else{
            /*calling the function code*/
            countShare();
            // countShareWebCustomUrl();
            showPopupBeforScoialCount();
            addTargetCss();
        }
    }
    else{
        /*calling the function code*/
        countShare();
        // countShareWebCustomUrl();
        showPopupBeforScoialCount();
        addTargetCss();
    }
}

function showIsActive(){
    window.setTimeout("showIsActive()", 1000);
}

$(document).ready(function() {
    $(document).on('click', '#btn-copy', function(){
        copy(window.location.href);
        $("#modal-one").hide();

        var copySuccessModal = '</style><div class="modal" id="modal-copy-success" aria-hidden="true"><div class="modal-dialog" style="pointer-events: auto!important;"><div class="modal-header"><h2>URL is copied!</h2></div><div class="modal-body"><p>Go to chrome browser and continue!</p></div></div></div>';

        $("body").after(copySuccessModal);
        $("#modal-copy-success").show();
    });

    $(document).on('click', '#btn-popup-close', function(){
        $("#modal-count-popup").hide();
        countShareWebCustomUrl();
    });

    $(function(){
        window.isActive = true;
        $(window).focus(function() { this.isActive = true; });
        $(window).blur(function() { this.isActive = false; });
        showIsActive();
    });

    $(document).on('click', ".share_link", function(){
        var share_link = $(this).attr("data-share_link");
        var type = $(this).attr("data-type");

        var showLoader = '<style>.loading-overlay { display: none; background: rgba(255, 255, 255, 0.7); position: fixed; bottom: 0; left: 0; right: 0; top: 0; z-index: 99999; align-items: center; justify-content: center; } .loading-overlay.is-active { display: flex; }</style><div class="loading-overlay"><span class="fas fa-spinner fa-3x fa-spin"></span></div>';

        $("body").after(showLoader);
        
        let overlay = document.getElementsByClassName('loading-overlay')[0];
        overlay.classList.toggle('is-active');
        
        var link = "";
        if(type=='fb'){
            link="fb://facewebmodal/f?href="+share_link;
            // var withouthttpslink=share_link.split("//");
            window.location.replace(link);
        }
        else if(type=='tw'){
            var link=share_link.replace(/&amp;/g, '&');
        }
        else if(type=='li'){
            var link=share_link.replace(/&amp;/g, '&');
        }

        showIsActive();
        setTimeout(function() {
            overlay.classList.toggle('is-active');
            if (window.isActive == true) {
                window.open(share_link, '_blank').focus();
            }
        }, 4000);
    })
});

function copy(txt){
    var cb = document.getElementById("cpurl");
    cb.value = txt;
    cb.style.display='block';
    cb.select();
    document.execCommand('copy');
    cb.style.display='none';
}

function checkIsUrlSharechallenge(){
    var url = window.location.href;
    var hashes = url.split("?")[1];
    var hash = hashes.split('&');

    for (var i = 0; i < hash.length; i++) {
        params=hash[i].split("=");
        if(params[0]=="share_cnf"){
            return true;
        }
    }
    return false;
}


function checkDeviceBrowser(){
    let userAgent = navigator.userAgent;
    let browserName="other";
    if(userAgent.match(/edg/i)){
        browserName = "edge";
    }
    else if(userAgent.match(/opr\//i) ){
        browserName = "opera";
    }
    else if(userAgent.match(/trident/i)){
        browserName = "internetExplorer";
    }
    else if(userAgent.match(/samsungbrowser/i)){
        browserName = "SamsungBrowser";
    }
    else if(userAgent.match(/wv/i) ){
        browserName = "MiWebBrowser";
    }
    else if(userAgent.match(/chrome|chromium|crios/i)){
        browserName = "chrome";
    }
    else if(userAgent.match(/firefox|fxios/i)){
        browserName = "firefox";
    }
    else if(userAgent.match(/safari/i)){
        browserName = "safari";
    }
    else{
        browserName="other";
    }

    // if(browserName=="chrome" || browserName=="edge"){
    //     isPageShow = true;
    // }
    // else{
    //     isPageShow = false;
    // }
}

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

function showPosition(position) {
    /*alert("Latitude: " + position.coords.latitude + "<br>Longitude: " + position.coords.longitude);*/
}

function addTargetCss(){
    var element = document.createElement("link");
    element.setAttribute("rel", "stylesheet");
    element.setAttribute("type", "text/css");
    element.setAttribute("href", "https://mouthpublicity.io/assets/css/web-targets.css");
    document.getElementsByTagName("head")[0].appendChild(element);
}

function addTargetBox(share_cnf,share_st){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let data = JSON.parse(this.responseText);
            if(data.status == true){
                /*insert extra count*/
                body = document.getElementsByTagName("body")[0];
                if(screen.width > 991){
                    body.insertAdjacentHTML('afterbegin', data.web);
                }else{
                    body.insertAdjacentHTML('afterbegin', data.phone);
                }
                function toggle_ol_pop(share_btn, share_modal){
                    share_modal.classList.toggle("__open__");
                    share_btn.classList.toggle("__close__");
                }

                var share_btn = document.getElementById("_OL_Share_");
                var share_modal = document.getElementById("_Openlink_Modal_");
                var share_close = document.getElementById("_OL_Close_");

                if(screen.width > 991){
                    share_btn.addEventListener("mouseover", function() {
                        toggle_ol_pop(share_btn, share_modal);
                    }, {once : true});
                    share_btn.onclick = function(){
                        toggle_ol_pop(share_btn, share_modal);
                    };
                    share_close.onclick = function(){
                        toggle_ol_pop(share_btn, share_modal);
                    };
                }else{
                    share_btn.onclick = function(){
                        if (navigator.share) {
                            navigator.share({
                                /*title: data.title,
                                text: data.desc,*/
                                url: data.url,
                            })
                            .then(() => {
                                console.log('Successful share')
                            })
                            .catch((error) => {
                                console.log('Error sharing', error)
                            });
                        }else{
                            /*navigator.share({
                                url: data.url
                            });*/
                            toggle_ol_pop(share_btn, share_modal);
                            navigator.canShare({url: data.url})
                        }
                    };
                    share_close.onclick = function(){
                        toggle_ol_pop(share_btn, share_modal);
                    }; 
                }
            }
        }
    };
    /*posting url xhttp*/
    xhttp.open("POST", "https://services.openchallenge.in/web-social-buttons", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("code="+share_cnf);
}

function countShare() {

    /*getting all url with parameters*/
    let urlParamsObject = new URLSearchParams(window.location.search)
    let urlParamsString = urlParamsObject.toString();
    let share_cnf = urlParamsObject.get('share_cnf');
    let share_st = urlParamsObject.get('status');
    let offer = urlParamsObject.get('o');
    /*console.log(offer);*/

    /* Offer UUID */
    var href = window.location.href;
    href = href.split("?")
    href = href[0];
    href = href.split("/");
    var offer_uuid = offer;
    /*console.log(offer_uuid);*/


    /*getting all cookies values*/
    var cookiesArray = document.cookie.split(';');

    for (var i = 0; i < cookiesArray.length; i++ ){
        var valueArray = cookiesArray[i].split('=');
        /*console.log(valueArray);*/
        if(valueArray[0].trim() == 'share_cnf_'+offer_uuid){
            var ex_share_cnf = valueArray[1];
            /*console.log('ex_share_cnf: ', ex_share_cnf);*/
        }
        if(valueArray[0].trim() == 'offer'){
            var ex_offer = valueArray[1];
        }
    }

    if(share_st != null || share_st != undefined || share_st != ''){
        if(share_st === 'true'){
            /*getLocation();*/
        }
    }

    addTargetBox(share_cnf,share_st);

    /*checking parameter available or not*/
    if((share_cnf != '' || share_cnf != null) && share_st == null){
        if(ex_share_cnf == undefined && ex_share_cnf != share_cnf){
            /*run core ajax function*/
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    let data = JSON.parse(this.responseText);
                    /*document.getElementById("demo").innerHTML = this.responseText;*/
                    if(data.status == true){
                        /*set cookies*/
                        var date = new Date();
                        date.setTime(date.getTime() + (365 * 24 * 60 * 60 * 1000));
                        var expires = ';expires=' + date.toGMTString();
                        document.cookie = 'share_cnf_'+offer_uuid+'=' + share_cnf + expires + '; path=/';
                        document.cookie = 'offer=' + offer + expires + '; path=/';
                    }
                }
            };
            /*posting url xhttp*/
            xhttp.open("POST", "https://services.openchallenge.in/count-targets", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("code="+share_cnf);
        }else{
            /*run core ajax function*/
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    let data = JSON.parse(this.responseText);
                    if(data.status == true){
                        /*insert extra count*/
                    }
                }
            };
            /*posting url xhttp*/
            xhttp.open("POST", "https://services.openchallenge.in/extra-count-targets", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("code="+share_cnf);
        }
    }
}

// Read a page's GET URL variables and return them as an associative array.
function getUrlVars(url)
{
    var vars = [], hash;
    var hashes = url.slice(url.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

function getCookie(cookieName) {
    let cookie = {};
    document.cookie.split(';').forEach(function(el) {
      let [key,value] = el.split('=');
      cookie[key.trim()] = value;
    })
    return cookie[cookieName];
}

/* Social Counts */
function showPopupBeforScoialCount(){
    var isShowPopup = 0;

    var href = window.location.href;
    href = href.split("?")
    href = href[0];
    href = href.split("/");
    
    var isCookiesAvailable = getCookie('social_post_popup');
    if(isCookiesAvailable != undefined || isCookiesAvailable!= null){
        countShareWebCustomUrl();
    }
    else{
        var urls = getUrlVars(window.location.href)["media"];
        if(urls != undefined || urls!= null){
            isShowPopup = 1;
        }
        if(isShowPopup==1){
            showPopup();
        }
        else{
            // setCount();
            countShareWebCustomUrl();
        }
    }
}

function showPopup(){
    // var countModal = '<style>.btn {background: #428bca;border: #357ebd solid 1px;border-radius: 3px;color: #fff;display: inline-block;font-size: 14px;padding: 8px 15px;text-decoration: none;text-align: center;min-width: 60px;position: relative;transition: color .1s ease;} .btn:hover {background: #357ebd; } .btn.btn-big {font-size: 18px;padding: 15px 20px;min-width: 100px; }.btn-close {color: #aaaaaa;font-size: 30px;text-decoration: none;position: absolute;right: 5px;top: 0; }.btn-close:hover {color: #919191; }.modal:target:before {display: none;}.modal:before {content:"";display: block;background: rgba(0, 0, 0, 0.6);position: fixed;top: 0;left: 0;right: 0;bottom: 0;z-index: 10;}.modal .modal-dialog {background: #fefefe;border: #333333 solid 1px;border-radius: 5px;margin-left: -200px;position: fixed;left: 50%;z-index: 11;width: 360px;-webkit-transform: translate(0, 0);-ms-transform: translate(0, 0);transform: translate(0, 0);-webkit-transition: -webkit-transform 0.3s ease-out;-moz-transition: -moz-transform 0.3s ease-out;-o-transition: -o-transform 0.3s ease-out;transition: transform 0.3s ease-out;top: 20%;}.modal:target .modal-dialog {top: -100%;-webkit-transform: translate(0, -500%);-ms-transform: translate(0, -500%);transform: translate(0, -500%);}.modal-body {padding: 20px;}.modal-header, .modal-footer{padding: 10px 20px;}.modal-header {border-bottom: #eeeeee solid 1px;}.modal-header h2 {font-size: 20px;}.modal-footer {border-top: #eeeeee solid 1px;text-align: right;}</style><div class="modal" id="modal-count-popup" aria-hidden="true"><div class="modal-dialog" style="pointer-events: auto!important;"><div class="modal-header"><h2>Confirmation</h2></div><div class="modal-body"><p>You want to open this link!</p> <a href="javascript:void(0)" id="btn-popup-close" class="btn" role="button" >Yes!</a> </div></div></div></div>';

    var countModal = '<div id="modal-count-popup" style="position: fixed;top: 0;left: 0;width: 100%;height: 100%;z-index: 99999;overflow-x: hidden;overflow-y: auto;outline: 0;background-color: rgba(0, 0, 0, .5);display: block;" aria-hidden="true">' + 
                        '<div style="position: relative;width: auto;margin: 1.75rem;pointer-events: none;margin-right: auto;margin-left: auto;max-width: 480px;display: flex;align-items: center;min-height: calc(100% - 1.75rem * 2);padding: 0 15px;" role="document">' + 
                            '<div style="border: none;border-radius: 0.8rem;outline: 0;position: relative;display: flex;flex-direction: column;width: 100%;pointer-events: auto;background-clip: padding-box;outline: 0;background-color: #fff;padding: 2rem;">' + 
                                '<h5 style="margin-bottom: 1rem;font-weight:600;">Confirmation</h5>' + 
                                '<p style="margin-bottom: 1rem;">Please press \'OK\' to view the Page!</p>' + 
                                '<button id="btn-popup-close" style="border: 0!important;border-radius: 5px;color: #161f18!important;background-color: rgb(0, 255, 102);display: block;padding: 5px 15px;width: 80px;text-align: center;font-weight: bold;" type="button">OK</button>' + 
                            '</div>' + 
                        '</div>' + 
                    '</div>';

    $("body").after(countModal);
    $("#modal-count-popup").show();
}


function countShareWebCustomUrl(){
    /*getting all url with parameters*/
    let urlParamsObject = new URLSearchParams(window.location.search)
    let offerMedia = urlParamsObject.get('media');
    // console.log(offerMedia);

    /*getting all cookies values*/
    var allCookies = document.cookie.split(';');

    for (var i = 0; i < allCookies.length; i++ ){
        var cookieValue = allCookies[i].split('=');
        // console.log(cookieValue);
        if(cookieValue[0].trim() == 'social_post_'+offerMedia){
            var social_cookie = cookieValue[1];
        }
    }

    if(offerMedia!=""){

        if(social_cookie == undefined && offerMedia != social_cookie){
            /*run core ajax function*/
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    let data = JSON.parse(this.responseText);
                    /*document.getElementById("demo").innerHTML = this.responseText;*/
                    if(data.status == true){
                        /*set cookies*/
                        var date = new Date();
                        date.setTime(date.getTime() + (365 * 24 * 60 * 60 * 1000));
                        var expires = ';expires=' + date.toGMTString();
                        document.cookie = 'social_post_'+offerMedia+'=' + offerMedia + expires + '; path=/';

                        /* Offer UUID */
                        var href = window.location.href;
                        href = href.split("?")
                        href = href[0];
                        href = href.split("/");
                        var offer_uuid = href[href.length-1];
                        
                        document.cookie = 'social_post_popup=' + offer_uuid + expires + '; path=/';
                    }
                }
            };
            /*posting url xhttp*/
            xhttp.open("POST", "https://services.openchallenge.in/count-social-click", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("offer_media="+offerMedia+"&type=unique");
        }else{
            /*run core ajax function*/
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    let data = JSON.parse(this.responseText);
                    if(data.status == true){
                        /*insert extra count*/
                    }
                }
            };
            /*posting url xhttp*/
            xhttp.open("POST", "https://services.openchallenge.in/count-social-click", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("offer_media="+offerMedia+"&type=extra");
        }
    }
}


function clickToCopyURL($url) {
    /*Create an auxiliary hidden input*/
    var aux = document.createElement("input");
    /*Get the text from the element passed into the input*/
    aux.setAttribute("value", $url);
    /*Append the aux input to the body*/
    document.body.appendChild(aux);
    /*Highlight the content*/
    aux.select();
    /*Execute the copy command*/
    document.execCommand("copy");
    /*Remove the input from the body*/
    document.body.removeChild(aux);
    var ac = document.getElementsByClassName("__ol_copy_url_btn__")[0];

    var mg = document.createElement("SPAN");
    mg.innerHTML = 'Copied';
    mg.id = '__OL_REMOVABLE_SPN__';
    mg.style.color = '#000';
    mg.style.fontSize  = 'x-small';
    mg.style.display  = 'block';
    mg.style.textAlign  = 'center';

    ac.appendChild(mg);

    setTimeout(() => {
    var rmCop = document.getElementById("__OL_REMOVABLE_SPN__");
        ac.removeChild(rmCop);
    }, 3000);
}