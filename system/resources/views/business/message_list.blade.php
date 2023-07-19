@extends('layouts.business')
@section('title', 'Notifications')

@section('end_head')
    <style>
        .noti-title {
            color: var(--primary);
            font-size: 15px;
        }

        .notification-detail {
            cursor: pointer;
        }

        .activity.readed {
            opacity: .8;
        }

        .activities .activity.readed:before {
            background-color: var(--secondary);
        }

        .activity.readed .noti-title {
            color: inherit;
        }

        .activity.readed .activity-detail,
        .activity.readed .activity-icon.shadow-primary {
            box-shadow: 0 2px 5px rgb(0 0 0 / 2%);
        }

        .activity.readed .activity-icon.bg-primary {
            background-color: var(--secondary) !important;
        }

        .hide_btn {
            display: none;
        }

        .auto-load {
            padding: 20px;
            font-size: 20px;
        }
    </style>
@endsection



@section('head')
    @include('layouts.partials.headersection', ['title' => 'Notifications'])
@endsection

@section('content')


    <div class="text-right mb-3">
        <a href="#" class="btn btn-primary mark-all-as-read">
            <i class="fas fa-eye mr-2"></i>Mark all as read
        </a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="activities">
                <input type="hidden" name="stopRequest" id="stopRequest" value="0">
            </div>
            <!-- Data Loader -->
            <div class="auto-load text-center">
                <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" height="60"
                    viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                    <path fill="#000"
                        d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                        <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s"
                            from="0 50 50" to="360 50 50" repeatCount="indefinite" />
                    </path>
                </svg>
            </div>
        </div>

    </div>

    <div class="loader-overlap" style="display: none;" id="loader">
        <div class="d-flex flex-column h-100 align-items-center justify-content-center">
            <div class="spinner-border text-white" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>


@endsection
@section('end_body')
    <script>
        $(document).on('click', '.mark-read', function($e) {
            $e.preventDefault();

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var noti_id = $(this).attr('id');
            var input = {
                "noti_id": noti_id,
                "_token": CSRF_TOKEN
            };
            $.ajax({
                url: '{{ route('business.markRead') }}',
                type: 'POST',
                data: input,
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    $('#notification_sec' + noti_id).addClass('readed');
                    $('.mark-read-' + noti_id).addClass('hide_btn');
                    $('.mark-unread-' + noti_id).removeClass('hide_btn');
                }
            });
        });

        $(document).on('click', '.mark-unread', function($e) {
            $e.preventDefault();

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var noti_id = $(this).attr('id');
            var input = {
                "noti_id": noti_id,
                "_token": CSRF_TOKEN
            };
            $.ajax({
                url: '{{ route('business.markUnRead') }}',
                type: 'POST',
                data: input,
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    $('#notification_sec' + noti_id).removeClass('readed');
                    $('.mark-unread-' + noti_id).addClass('hide_btn');
                    $('.mark-read-' + noti_id).removeClass('hide_btn');
                }
            });
        });

        $(document).on('click', '.mark-deleted', function($e) {
            $e.preventDefault();

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var noti_id = $(this).attr('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    var input = {
                        "noti_id": noti_id,
                        "_token": CSRF_TOKEN
                    };
                    $.ajax({
                        url: '{{ route('business.markDeleted') }}',
                        type: 'POST',
                        data: input,
                        dataType: "json",
                        success: function(response) {
                            // console.log(response);
                            $('#notification_sec' + noti_id).css('display', 'none');
                            Sweet("success", "Message has been deleted.");

                            setInterval(function() {
                                location.reload();
                            }, 1000);

                        }
                    });
                }
            })
        });

        $(document).on('click', '.mark-all-as-read', function(e) {
            e.preventDefault();

            $('#overlay').fadeIn(300);

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var input = {
                "_token": CSRF_TOKEN
            };
            $.ajax({
                url: '{{ route('business.markAllAsRead') }}',
                type: 'POST',
                data: input,
                dataType: "json",
                success: function(response) {
                    console.log(response.status, "check response");
                    $("#overlay").fadeOut(300);
                    if (response.status == true) {
                        setInterval(function() {
                            location.reload();
                        }, 2000);
                        Sweet('success', response.message);

                    } else {
                        Sweet('error', response.message);
                    }

                }
            });
        });

        $(document).on('click', '.notification-detail', function() {
            var sec = $(this).attr('id');
            var noti_id = sec.replace('notification_detail', '');
            var noti_url = $('#noti_url_' + noti_id).attr('href');
            window.location.href = noti_url;
            //console.log(noti_url);
        });
    </script>

    <script>
        var ENDPOINT = "{{ url('/') }}";
        var page = 1;
        var stopRequest = $("#stopRequest").val();

        infinteLoadMore(page);
        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 1) {
                page++;
                if (stopRequest == 0) {
                    infinteLoadMore(page);
                }

            }
        });

        function infinteLoadMore(page) {

            $.ajax({
                    url: ENDPOINT + "/business/notifications?page=" + page,
                    datatype: "html",
                    type: "get",
                    beforeSend: function() {
                        $('.auto-load').show();
                    }
                })
                .done(function(response) {

                    if (response.length == 0) {
                        $('.auto-load').html(
                            "Sorry, there are no more notifications available to display at this time. Please check back later for any updates or new notifications. Thank you."
                        );
                        stopRequest = 1;
                        return;
                    }
                    $('.auto-load').hide();
                    $(".activities").append(response);
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                });
        }
    </script>
@endsection
