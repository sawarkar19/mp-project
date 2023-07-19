/*on page load running event*/
window.onload = function WindowLoad(event) {
    /*calling the function code*/
    countShare();
}
/*function showShareWarp(){
    var shareBtn = document.getElementById('share_on');
    var shareBoxLayout = document.getElementById('shareBoxLayout');
    if (shareBoxLayout.style.display !== "none") {
        shareBoxLayout.style.display = "block";
        shareBtn.style.display = "none";
    } else {
        shareBoxLayout.style.display = "none";
        shareBtn.style.display = "block";
    }
}
function hideShareWarp(){
    var shareBtn = document.getElementById('share_on');
    var shareBoxLayout = document.getElementById('shareBoxLayout');
    if (shareBoxLayout.style.display !== "block") {
        shareBoxLayout.style.display = "none";
        shareBtn.style.display = "block";
    } else {
        shareBoxLayout.style.display = "block";
        shareBtn.style.display = "none";
    }
}*/

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

function showPosition(position) {
    alert("Latitude: " + position.coords.latitude + "<br>Longitude: " + position.coords.longitude);
}

function addTargetCss(){
    var element = document.createElement("link");
    element.setAttribute("rel", "stylesheet");
    element.setAttribute("type", "text/css");
    element.setAttribute("href", "http://localhost/sharepage/assets/css/web-targets.css");
    document.getElementsByTagName("head")[0].appendChild(element);
}

function addTargetBox(share_cnf,share_st){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let data = JSON.parse(this.responseText);
            if(data.status == true){
                /*insert extra count*/
                console.log(data)
                body = document.getElementsByTagName("body")[0];
                body.insertAdjacentHTML('afterbegin', data.response);
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
                }
                share_btn.onclick = function(){
                    toggle_ol_pop(share_btn, share_modal);
                };
                share_close.onclick = function(){
                    toggle_ol_pop(share_btn, share_modal);
                };
            }
        }
    };
    /*posting url xhttp*/
    xhttp.open("POST", "http://localhost/service-finder/social-buttons", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    /*xhttp.send("code="+share_cnf+"_token="+document.querySelector('meta[name="csrf-token"]').getAttribute('content'));*/
    /*calling request parameters*/
    xhttp.send("code="+share_cnf);
    console.log('Cookie found');
}

function countShare() {

    /*getting all url with parameters*/
    let urlParamsObject = new URLSearchParams(window.location.search)
    let urlParamsString = urlParamsObject.toString();
    let share_cnf = urlParamsObject.get('share_cnf');
    let share_st = urlParamsObject.get('status');
    /*console.log(share_st);*/

    /*getting all cookies values*/
    var cookiesArray = document.cookie.split(';');
    for (var i = 0; i < cookiesArray.length; i++ ){
        var valueArray = cookiesArray[i].split('=');
        if(valueArray[0].trim() == 'share_cnf'){
            var ex_share_cnf = valueArray[1];
        }
    }

    if(share_st != null || share_st != undefined || share_st != ''){
        if(share_st === 'true'){
            getLocation();
            addTargetCss();
            addTargetBox(share_cnf,share_st);
        }
    }

    /*checking parameter available or not*/
    if(share_cnf != '' || share_cnf != null){
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
                        document.cookie = 'share_cnf=' + share_cnf + expires + '; path=/';
                    }
                }
            };
            /*posting url xhttp*/
            xhttp.open("POST", "http://localhost/service-finder/count-targets", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            /*xhttp.send("code="+share_cnf+"_token="+document.querySelector('meta[name="csrf-token"]').getAttribute('content'));*/
            /*calling request parameters*/
            xhttp.send("code="+share_cnf);
            console.log('Cookie Not found');
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
            xhttp.open("POST", "http://localhost/service-finder/extra-count-targets", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            /*xhttp.send("code="+share_cnf+"_token="+document.querySelector('meta[name="csrf-token"]').getAttribute('content'));*/
            /*calling request parameters*/
            xhttp.send("code="+share_cnf);
            console.log('Cookie found');
        }
    }
}