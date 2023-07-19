  <script type="text/javascript">

    $(document).ajaxSend(function() {
        $("#overlay").fadeIn(300);　
    });
    
    $(document).on('click', '.task_click', function(){

        var task_key = $(this).attr('id');

        var urlParamsObject = new URLSearchParams(window.location.search)
        var urlParamsString = urlParamsObject.toString();
        var share_cnf = urlParamsObject.get('share_cnf');

        setTimeout(function(){ 
            updateTask(task_key,share_cnf);
        }, 10000);
        
    });

    function updateTask(task_key,share_cnf){
        $("#overlay").fadeOut(300);
        $('.pending_task_'+task_key).css("display","none");
        $('.processing_task_'+task_key).css("display","block");
        
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var input = {
            "user_code" : share_cnf,
            "task_key" : task_key,
            "_token" : CSRF_TOKEN
        };

        var url = '{{ $services_url->value }}'+"/update-task-status";

        $.ajax({
            url : url,
            type : 'POST',
            data : input,
            dataType : "json",
            success : function(response) {
                console.log(response);
            },
            error: function(xhr, status, error) 
            {
                console.log("Task not updated");
            }
        });
    }

    //redeem code sent
    $(document).on("click", "#sendRedeemCode", function(event){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        /*getting all url with parameters*/
        var urlParamsObject = new URLSearchParams(window.location.search)
        var urlParamsString = urlParamsObject.toString();
        var share_cnf = urlParamsObject.get('share_cnf');

        $.ajax({
            type: 'POST',
            url: "{{url('/instant/redeem/')}}",
            data: {uuid: share_cnf, _token: CSRF_TOKEN},
            dataType: 'JSON',
            success: function (results) {
                $("#overlay").fadeOut(300);
                if (results.status === true && results.type == 'success') {
                    Swal.fire({
                      icon: 'success',
                      title: results.message,
                      showConfirmButton: true,
                      confirmButtonText:
                        '<i class="fa fa-thumbs-up"></i> Okay!',
                      confirmButtonColor: '#3085d6',
                    })
                } else if(results.status === true && results.type == 'info'){
                    Swal.fire({
                      icon: 'info',
                      title: results.message,
                      showConfirmButton: true,
                      confirmButtonText:
                        '<i class="fa fa-thumbs-up"></i> Okay!',
                      confirmButtonColor: '#3085d6',
                    })
                }else{
                    Swal.fire({
                      icon: 'error',
                      title: results.message,
                      showConfirmButton: true,
                      confirmButtonText:
                        '<i class="fa fa-thumbs-up"></i> Okay!',
                      confirmButtonColor: '#3085d6',
                    })
                }
            },
            error: function(xhr) { 
                $("#overlay").fadeOut(300);
                Swal.fire({
                  icon: 'error',
                  title: "Something went wrong!",
                  showConfirmButton: true,
                  confirmButtonText:
                    '<i class="fa fa-thumbs-up"></i> Okay!',
                  confirmButtonColor: '#3085d6',
                })
            },
        });
    });


    $(document).on("click", ".show_less", function(event){
        //event.preventDefault();
        $('.more_text').css('display','none');
        $('.less_text').css('display','block');
    });
    $(document).on("click", ".show_more", function(event){
        //event.preventDefault();
        $('.more_text').css('display','block');
        $('.less_text').css('display','none');
    });
  </script>

    <script>
        /* Add Subcription */
        function checkFollow() {

            swal.fire({
                title: 'Enter Your Twitter Username!',
                html: `<input type="text" id="tw_username" class="swal2-input" placeholder="Enter Your Twitter Username">`,
                confirmButtonText: 'Verify',
                focusConfirm: false,
                showCancelButton: !0,
                cancelButtonText: "Close",
                allowOutsideClick: false,
                reverseButtons: !0,
                preConfirm: () => {

                    const tw_username = Swal.getPopup().querySelector('#tw_username').value;
                    const tw_business = "{{ $tasks['tw_username'] }}";

                    if (tw_username == '') {
                        Swal.showValidationMessage(`Please enter valid Twitter Username!`)
                    }

                    return { tw_username: tw_username, tw_business: tw_business }
                }
            }).then(function (e) {

                /*getting all url with parameters*/
                var urlParamsObject = new URLSearchParams(window.location.search)
                var urlParamsString = urlParamsObject.toString();
                var share_cnf = urlParamsObject.get('share_cnf');

                if (e.value && e.value.tw_username) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    const tw_business = e.value.tw_business;

                    $.ajax({
                        type: 'POST',
                        url: "{{url('/instant/verify-twfollow')}}",
                        data: {tw_username: e.value.tw_username, tw_business: tw_business, share_cnf: share_cnf, _token: CSRF_TOKEN},
                        dataType: 'JSON',
                        success: function (results) {
                            $("#overlay").fadeOut(300);
                            if (results.status === true) {
                                updateTask('tw_username',share_cnf);

                                swal.fire("Done!", results.message, "success");
                            } else {
                                swal.fire("Error!", results.message, "error");
                            }
                        },
                        error: function(xhr) { 
                            $("#overlay").fadeOut(300);
                            Swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'Something went wrong!'
                            })
                        },
                    });

                }
            }, function (dismiss) {
                return false;
            })
        }



        function checkTwLikedBy() {

            swal.fire({
                title: 'Enter Your Twitter Username!',
                html: `<input type="text" id="tw_username" class="swal2-input" placeholder="Enter Your Twitter Username">`,
                confirmButtonText: 'Verify',
                focusConfirm: false,
                showCancelButton: !0,
                cancelButtonText: "Close",
                allowOutsideClick: false,
                reverseButtons: !0,
                preConfirm: () => {

                    const tw_username = Swal.getPopup().querySelector('#tw_username').value;
                    const tw_business = "{{ $tasks['tw_tweet_like'] }}";

                    if (tw_username == '') {
                        Swal.showValidationMessage(`Please enter valid Twitter Username!`)
                    }

                    return { tw_username: tw_username, tw_business: tw_business }
                }
            }).then(function (e) {

                /*getting all url with parameters*/
                var urlParamsObject = new URLSearchParams(window.location.search)
                var urlParamsString = urlParamsObject.toString();
                var share_cnf = urlParamsObject.get('share_cnf');

                if (e.value && e.value.tw_username) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        type: 'POST',
                        url: "{{url('/instant/verify-twliked')}}",
                        data: {tw_username: e.value.tw_username, tw_business: e.value.tw_business, share_cnf: share_cnf, _token: CSRF_TOKEN},
                        dataType: 'JSON',
                        success: function (results) {
                            $("#overlay").fadeOut(300);
                            if (results.status === true) {
                                updateTask('tw_tweet_like',share_cnf);

                                swal.fire("Done!", results.message, "success");
                            } else {
                                swal.fire("Error!", results.message, "error");
                            }
                        },
                        error: function(xhr) { 
                            $("#overlay").fadeOut(300);
                            Swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'Something went wrong!'
                            })
                        },
                    });

                }
            }, function (dismiss) {
                return false;
            })
        }
    </script>

    <script>
        /* Add Subcription */
        function checkSubscribe() {

            swal.fire({
                title: 'Enter Your Name!',
                html: `<input type="text" id="yt_username" class="swal2-input" placeholder="Enter Your Name">`,
                confirmButtonText: 'Verify',
                focusConfirm: false,
                showCancelButton: !0,
                cancelButtonText: "Close",
                allowOutsideClick: false,
                reverseButtons: !0,
                preConfirm: () => {

                    const yt_username = Swal.getPopup().querySelector('#yt_username').value;
                    const yt_business = "{{ $tasks['yt_channel_url'] }}";

                    if (yt_username == '') {
                        Swal.showValidationMessage(`Please enter your name!`)
                    }

                    return { yt_username: yt_username, yt_business: yt_business }
                }
            }).then(function (e) {

                /*getting all url with parameters*/
                var urlParamsObject = new URLSearchParams(window.location.search)
                var urlParamsString = urlParamsObject.toString();
                var share_cnf = urlParamsObject.get('share_cnf');

                if (e.value && e.value.yt_username) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    const yt_business = e.value.yt_business;

                    $.ajax({
                        type: 'POST',
                        url: "{{url('/instant/verify-youtube-subscribe')}}",
                        data: {yt_username: e.value.yt_username, yt_business: e.value.yt_business, share_cnf: share_cnf, _token: CSRF_TOKEN},
                        dataType: 'JSON',
                        success: function (results) {
                            $("#overlay").fadeOut(300);
                            if (results.status === true) {
                                updateTask('yt_channel_url',share_cnf);

                                swal.fire("Done!", results.message, "success");
                            } else {
                                swal.fire("Error!", results.message, "error");
                            }
                        },
                        error: function(xhr) { 
                            $("#overlay").fadeOut(300);
                            Swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'Something went wrong!'
                            })
                        },
                    });

                }
            }, function (dismiss) {
                return false;
            })
        }

        /* Add Comment */
        function checkComment() {

            swal.fire({
                title: 'Enter Your Name!',
                html: `<input type="text" id="yt_username" class="swal2-input" placeholder="Enter Your Name">`,
                confirmButtonText: 'Verify',
                focusConfirm: false,
                showCancelButton: !0,
                cancelButtonText: "Close",
                allowOutsideClick: false,
                reverseButtons: !0,
                preConfirm: () => {

                    const yt_username = Swal.getPopup().querySelector('#yt_username').value;
                    const yt_business = "{{ $tasks['yt_comment_url'] }}";

                    if (yt_username == '') {
                        Swal.showValidationMessage(`Please enter your name!`)
                    }

                    return { yt_username: yt_username, yt_business: yt_business }
                }
            }).then(function (e) {

                /*getting all url with parameters*/
                var urlParamsObject = new URLSearchParams(window.location.search)
                var urlParamsString = urlParamsObject.toString();
                var share_cnf = urlParamsObject.get('share_cnf');

                if (e.value && e.value.yt_username) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    const yt_business = e.value.yt_business;

                    $.ajax({
                        type: 'POST',
                        url: "{{url('/instant/verify-youtube-comment')}}",
                        data: {yt_username: e.value.yt_username, yt_business: e.value.yt_business, share_cnf: share_cnf, _token: CSRF_TOKEN},
                        dataType: 'JSON',
                        success: function (results) {
                            $("#overlay").fadeOut(300);
                            if (results.status === true) {
                                updateTask('yt_comment_url',share_cnf);

                                swal.fire("Done!", results.message, "success");
                            } else {
                                swal.fire("Error!", results.message, "error");
                            }
                        },
                        error: function(xhr) { 
                            $("#overlay").fadeOut(300);
                            Swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'Something went wrong!'
                            })
                        },
                    });

                }
            }, function (dismiss) {
                return false;
            })
        }


        /* Add Like */
        function checkLike() {

            swal.fire({
                title: 'Enter Your Name!',
                html: `<input type="text" id="yt_username" class="swal2-input" placeholder="Enter Your Name">`,
                confirmButtonText: 'Verify',
                focusConfirm: false,
                showCancelButton: !0,
                cancelButtonText: "Close",
                allowOutsideClick: false,
                reverseButtons: !0,
                preConfirm: () => {

                    const yt_username = Swal.getPopup().querySelector('#yt_username').value;
                    const yt_business = "{{ $tasks['yt_like_url'] }}";

                    if (yt_username == '') {
                        Swal.showValidationMessage(`Please enter your name!`)
                    }

                    return { yt_username: yt_username, yt_business: yt_business }
                }
            }).then(function (e) {

                /*getting all url with parameters*/
                var urlParamsObject = new URLSearchParams(window.location.search)
                var urlParamsString = urlParamsObject.toString();
                var share_cnf = urlParamsObject.get('share_cnf');

                if (e.value && e.value.yt_username) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    const yt_business = e.value.yt_business;

                    $.ajax({
                        type: 'POST',
                        url: "{{url('/instant/verify-youtube-like')}}",
                        data: {yt_username: e.value.yt_username, yt_business: e.value.yt_business, share_cnf: share_cnf, _token: CSRF_TOKEN},
                        dataType: 'JSON',
                        success: function (results) {
                            $("#overlay").fadeOut(300);
                            if (results.status === true) {
                                updateTask('yt_like_url',share_cnf);

                                swal.fire("Done!", results.message, "success");
                            } else {
                                swal.fire("Error!", results.message, "error");
                            }
                        },
                        error: function(xhr) { 
                            $("#overlay").fadeOut(300);
                            Swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'Something went wrong!'
                            })
                        },
                    });

                }
            }, function (dismiss) {
                return false;
            })
        }

        function checkInstagramFollower() {

            swal.fire({
                title: 'Enter Your Name!',
                html: `<input type="text" id="in_username" class="swal2-input" placeholder="Enter Your Name">`,
                confirmButtonText: 'Verify',
                focusConfirm: false,
                showCancelButton: !0,
                cancelButtonText: "Close",
                allowOutsideClick: false,
                reverseButtons: !0,
                preConfirm: () => {

                    const in_username = Swal.getPopup().querySelector('#in_username').value;
                    const in_business = "{{ $tasks['insta_profile_url'] }}";

                    if (in_username == '') {
                        Swal.showValidationMessage(`Please enter your name!`)
                    }

                    return { in_username: in_username, in_business: in_business }
                }
            }).then(function (e) {

                /*getting all url with parameters*/
                var urlParamsObject = new URLSearchParams(window.location.search)
                var urlParamsString = urlParamsObject.toString();
                var share_cnf = urlParamsObject.get('share_cnf');

                if (e.value && e.value.in_username) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    const in_business = e.value.in_business;

                    $.ajax({
                        type: 'POST',
                        url: "{{url('/instant/verify-instagram-follow')}}",
                        data: {in_username: e.value.in_username, in_business: e.value.in_business, share_cnf: share_cnf, _token: CSRF_TOKEN},
                        dataType: 'JSON',
                        success: function (results) {
                            $("#overlay").fadeOut(300);
                            if (results.status === true) {
                                swal.fire("Done!", results.message, "success");
                            } else {
                                swal.fire("Error!", results.message, "error");
                            }
                        },
                        error: function(xhr) { 
                            $("#overlay").fadeOut(300);
                            Swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'Something went wrong!'
                            })
                        },
                    });

                }
            }, function (dismiss) {
                return false;
            })
        }
    </script>