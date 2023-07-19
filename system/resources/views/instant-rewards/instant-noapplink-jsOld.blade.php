<script type="text/javascript">
    // Check Browser
    let browserName = "other";
    let isTaskListShow = true;
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

         if(browserName=="chrome" || browserName=="edge"){
              // alert(browserName + " support");
              isTaskListShow = true;
         }
         else{
              // alert(" Only Chrome browser support");
              isTaskListShow = false;
         }
    }

    $(function() {
         window.isActive = true;
         $(window).focus(function() { this.isActive = true; });
         $(window).blur(function() { this.isActive = false; });
         showIsActive();
    });

    function showIsActive() {
         // console.log(window.isActive)
         window.setTimeout("showIsActive()", 1000);
    }

    let isDevice = "mobile-or-tab";
    checkDeviceWidth();
    function checkDeviceWidth() {
         var windowsize = window.innerWidth;
         if (windowsize > 790) {
              isDevice = "desktop";
         }
    }
    
    function setLaoding(){
         i = 0;
         text = "loading";
         $("#loader").show();
         setInterval(function() {
             $("#loading").html(text+Array((++i % 4)+1).join("."));
             if (i===10) text = "start";
         }, 2000);

         setTimeout(function() {
              $("#loader").hide();
         }, 2500);
    }

    // check instant-task page show
    function checkIsTaskListShow(){
         if(isTaskListShow==false){
              // Swal.fire({
              //      position: 'center',
              //      icon: 'warning',
              //      title: "Please note",
              //      text: "This browser can't open this link! Please open this using the Google Chrome browser!",
              //      showConfirmButton: false,
              //      allowOutsideClick: false,
              // });
              Swal.fire({
                   title: 'Please note',
                   text: "This browser can't open this link! Please open this using the Google Chrome browser!",
                   icon: 'warning',
                   confirmButtonColor: '#3085d6',
                   confirmButtonText: 'Copy url',
                   allowOutsideClick: false,
              }).then((result) => {
                   if (result.value) {
                        copy(window.location.href);
                        Swal.fire({
                             title: 'Url copied!',
                             text: "Above url has been copied!",
                             icon: 'success',
                             allowOutsideClick: false,
                        }).then((copyresult) => {
                             // console.log(copyresult);
                             if (result.value) {
                                  // checkIsTaskListShow();
                                  Swal.fire({
                                       position: 'center',
                                       icon: 'success',
                                       title: 'URL is copied!',
                                       text: 'Go to chrome browser and continue!',
                                       showConfirmButton: false,
                                       allowOutsideClick: false,
                                       // timer: 1500
                                  });
                             }
                        });
                   }
              })
         }
    }
    
    function copy(txt){
         // alert(txt);
         var cb = document.getElementById("cpToClipbord");
         cb.value = txt;
         cb.style.display='block';
         cb.select();
         document.execCommand('copy');
         cb.style.display='none';
    }

    function checkExpiryApp() {
         var now_ = new Date();
         var expiry = new Date('-1');
         if (now_ > expiry){
              // document.body.innerHTML = "";
              // document.head.innerHTML = "";
              // force alert() to the end of the callstack so body & head get cleared before alert
              setTimeout(() => alert("The webpage is expired."), 0); 
         }            
    }
    // setInterval(function () { checkExpiryApp(); }, 15 * 1000);

    $(document).ready(function(){
         // Check Browser

         if(window.location.href.indexOf("share_cnf") > -1){
              checkDeviceBrowser();
              checkIsTaskListShow();
         }
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
         /* Facebook page link */
         $(document).on('click', '.fb-page-link', function(){
              var task_value = $(this).attr("data-task_value");
              var task_key = $(this).attr("data-task_key");
              var instant_task_id = $(this).attr("data-instant_task_id");

              var link="fb://facewebmodal/f?href=https://www.facebook.com/"+task_value.replace(/&amp;/g, '&');
              var noapplink="https://www.facebook.com/"+task_value;
              var withouthttpslink=noapplink.split("//");

              window.location.replace(link);
              setLaoding();
              setTimeout(function() { 
                   console.log(window.isActive); 
                   if (window.isActive == true) {
                        if(isDevice=="desktop"){
                             // checkExpiryApp();
                             window.location.href=noapplink;
                        }
                        else{
                             // checkExpiryApp();
                             window.location.href = noapplink;
                             // window.location.replace(noapplink);
                        }
                   }
                   // else{
                        checkFacebookLikeOurPage(instant_task_id);
                   // }
              }, 2000);
         });

         /* Facebook page post link */
         $(document).on('click', '.fb-post-link', function(){
              var task_value = $(this).attr("data-task_value");
              var task_key = $(this).attr("data-task_key");
              var instant_task_id = $(this).attr("data-instant_task_id");

              // const postId = task_value.substring(task_value.lastIndexOf('/') + 1)
              var link="fb://facewebmodal/f?href="+task_value.replace(/&amp;/g, '&');
              var noapplink=task_value;
              var withouthttpslink=noapplink.split("//");
              
              window.location.replace(link)
              setLaoding();
              setTimeout(function() { 
                   // console.log(window.isActive); 
                   if (window.isActive == true) {
                        if(isDevice=="desktop"){
                             window.location.href=noapplink;
                        }
                        else{
                             window.location.href = noapplink;
                             // window.location.replace(noapplink);
                        }
                   } 
                   // else{
                        if(task_key=="fb_comment_post_url"){
                             checkFacebookPostComment(instant_task_id);
                        }
                        else if(task_key=="fb_like_post_url"){
                             checkFacebookPostLike(instant_task_id);
                        }
                        // else if(task_key=="fb_share_post_url"){
                        //      checkFacebookSharePost(instant_task_id);
                        // }
                   // }
              }, 2000);
         });

         /* Twitter profile link */
         $(document).on('click', '.tw-profile-link', function(){
              var task_value = $(this).attr("data-task_value");
              var task_key = $(this).attr("data-task_key");
              var instant_task_id = $(this).attr("data-instant_task_id");

              var link="intent://twitter.com/"+task_value.replace(/&amp;/g, '&');
              var noapplink="//twitter.com/"+task_value;
              var withouthttpslink=noapplink.split("//");
              
              window.location.replace(link)
              setLaoding();
              setTimeout(function() { 
                   console.log(window.isActive); 
                   if (window.isActive == true) {
                        if(isDevice=="desktop"){
                             window.location.href=noapplink;
                        }
                        else{
                             window.location.href = noapplink;
                             // window.location.replace(noapplink);
                        }
                   } 
                   // else{
                        checkFollow(instant_task_id);
                   // }
              }, 2000);
         });

         /* Twitter profile tweet link */
         $(document).on('click', '.tw-post-link', function(){
              var task_value = $(this).attr("data-task_value");
              var task_key = $(this).attr("data-task_key");
              var instant_task_id = $(this).attr("data-instant_task_id");

              var link="intent://"+task_value.replace(/&amp;/g, '&');
              var noapplink=task_value;
              var withouthttpslink=noapplink.split("//");

              window.location.replace(link)
              setLaoding();
              setTimeout(function() { 
                   // console.log(window.isActive); 
                   if (window.isActive == true) {
                        if(isDevice=="desktop"){
                             window.location.href=noapplink;
                        }
                        else{
                             window.location.href = noapplink;
                             // window.location.replace(noapplink);
                        }
                   } 
                   // else{
                        checkTwLikedBy(instant_task_id);
                   // }
              }, 2000);
         });

         /* Instagram Follow Page */
         $(document).on('click', '.instagram-follow-link', function(){
              console.log("instagram-follow-link => Counf API not found!");
         });

         /* Instagram Like Post */
         $(document).on('click', '.instagram-post-link', function(){
              var task_value = $(this).attr("data-task_value");
              var task_key = $(this).attr("data-task_key");
              var instant_task_id = $(this).attr("data-instant_task_id");

              var link="intent://"+task_value.replace(/&amp;/g, '&');
              var noapplink=task_value;
              var withouthttpslink=noapplink.split("//");

              window.location.replace(link)
              setLaoding();
              setTimeout(function() { 
                   // console.log(window.isActive); 
                   if (window.isActive == true) {
                        
                        if(isDevice=="desktop"){
                             window.location.href=noapplink;
                        }
                        else{
                             window.location.href = noapplink;
                             // window.location.replace(noapplink);
                        }
                   } 
                   // else{
                        if(task_key=="insta_post_url"){
                             checkInstaLikes(instant_task_id);
                        }
                        else if(task_key=="insta_comment_post_url"){
                             checkInstaComments(instant_task_id);
                        }
                   // }
              }, 2000);
         });


         /* Youtube channel link */
         $(document).on('click', '.youtube-channel-link', function(){
              var task_value = $(this).attr("data-task_value");
              var task_key = $(this).attr("data-task_key");
              var instant_task_id = $(this).attr("data-instant_task_id");

              var link="intent://"+task_value.replace(/&amp;/g, '&');
              var noapplink=task_value;
              var withouthttpslink=noapplink.split("//");
              
              var appWindow = window.location.replace(link);
              setLaoding();
              setTimeout(function() { 
                   console.log(window.isActive); 
                   if (window.isActive == true) {
                        if(isDevice=="desktop"){
                             window.location.href=noapplink;
                        }
                        else{
                             window.location.href = noapplink;
                             // window.location.replace(noapplink);
                        }
                   } 
                   // else{
                        checkSubscribe(instant_task_id);
                   // }
              }, 2000);
         });

         // $(document).on('click', '.youtube-channel-link', function(){
         //      var task_value = $(this).attr("data-task_value");

         //      var link="intent://"+task_value.replace(/&amp;/g, '&');
         //      var noapplink=task_value;
         //      var withouthttpslink=noapplink.split("//");
              
         //      var appWindow = window.location.replace(link);
         //      // console.log('1: ', appWindow);
         //      setLaoding();

         //      var start = Date.now();
         //      function noappfound(){
         //           var now = Date.now();
         //           if (now - start > 4000) {
         //           } else if(now - start > 500){
         //                // window.location.replace(noapplink);
         //                alert("noAppLink");
         //           }
         //      }
         //      window.location.replace(link);
         //      setTimeout(noappfound, 501);
         //      // setTimeout(function() { 
         //      //      console.log(window.isActive); 
         //      //      if (window.isActive == true) {
         //      //           console.log('2: ', appWindow);
         //      //           if(isDevice=="desktop"){
         //      //                window.location.href=noapplink;
         //      //                // alert("youtube desk");
         //      //                checkExpiryApp();
         //      //           }
         //      //           else{
         //      //                window.location.href = noapplink;
         //      //                // alert("youtube not desk");
         //      //                // $("#popup").show();
         //      //                checkExpiryApp();
         //      //           }
         //      //      } 
         //      // }, 2000);
         // });

         /* Youtube channel video link */
         $(document).on('click', '.youtube-post-link', function(){
              var task_value = $(this).attr("data-task_value");
              var task_key = $(this).attr("data-task_key");
              var instant_task_id = $(this).attr("data-instant_task_id");

              var link="intent://"+task_value.replace(/&amp;/g, '&');
              var noapplink=task_value;
              var withouthttpslink=noapplink.split("//");

              window.location.replace(link)
              setLaoding();
              setTimeout(function() { 
                   // console.log(window.isActive); 
                   if (window.isActive == true) {
                        
                        if(isDevice=="desktop"){
                             window.location.href=noapplink;
                        }
                        else{
                             window.location.href = noapplink;
                             // window.location.replace(noapplink);
                        }
                   } 
                   // else{
                        if(task_key=="yt_comment_url"){
                             checkComment(instant_task_id);
                        }
                        else if(task_key=="yt_like_url"){
                             checkLike(instant_task_id);
                        }
                   // }
              }, 2000);
         });

    });


    
</script>