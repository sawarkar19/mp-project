@extends('layouts.admin')
@section('title', 'Admin: Create Coupon')
@section('head')
    <style type="text/css">
        .is_required {
            color: red;
        }

        .form-group {
            position: relative;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/chosen2/chosen.min.css') }}" />
    <link href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css" rel="stylesheet" />

    @include('layouts.partials.headersection', ['title' => 'Create Coupon'])
@endsection
@section('content')

    <div class="row">
        <div class="col-12 mt-2">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('admin.coupon.store') }}" id="actionForm">
                        @csrf
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label>{{ __('Coupon Name') }} <span class="is_required">*</span></label>
                                    <input type="text" name="name" class="form-control char-spcs-validation"
                                        maxlength="30" required>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Coupon Code') }} <span class="is_required">*</span></label>
                                    <input type="text" name="code" class="form-control"
                                        style="text-transform:uppercase;" maxlength="21" required>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Coupon description') }} <span class="is_required">*</span></label>
                                    <textarea name="description" class="form-control char-spcs-validation " cols="30" rows="3"
                                        placeholder="Description" id="description" maxlength="" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Coupon For') }} <span class="is_required">*</span></label>
                                    <select class="form-control" name="coupon_for" id="coupon_for" required>
                                        <option selected="" disabled>{{ __('Select Coupon For') }}</option>
                                        <option value="individuals">{{ __('For Individuals') }}</option>
                                        <option value="all" onclick="couponFor()">{{ __('For All') }}</option>
                                    </select>
                                </div>

                                <div class="form-group" id="subscriber_type" style="display:none;">
                                    <label>{{ __('Subscribe Type') }} <span class="is_required">*</span></label>
                                    <select class="form-control" name="subscriber_type">
                                        <option selected="" disabled>{{ __('Select Subscribe') }}</option>
                                        <option value="0" id="new_user" name="usertype" data-value="0">{{ __('New User') }}
                                        </option>
                                        <option value="1" id="free" name="usertype" data-value="1">{{ __('Free Subscriber') }}
                                        </option>
                                        <option value="2" id="paid" name="usertype" data-value="2">{{ __('Paid Subscriber') }}
                                        </option>
                                        <option value="3" id="expired" name="usertype" data-value="3">
                                            {{ __('Subscriber Expired') }}</option>

                                    </select>

                                </div>


                                {{-- <div class="row" id="subscribedUser" style="display:none;">
                                    <div class="form-group col-md-3">
                                        <label for="free">{{ __('Free Subscriber') }}</label>
                                        <input type="checkbox" class="subscriberUser" id="free" name="usertype"
                                            value='1'>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="paid">{{ __('Paid Subscriber') }}</label>
                                        <input type="checkbox" class="subscriberUser" id="paid" name="usertype"
                                            value='2'>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="expired">{{ __('Subscriber Expired') }}</label>
                                        <input type="checkbox" class="subscriberUser" id="expired" name="usertype"
                                            value='3'>
                                    </div>

                                    {{-- <div class="form-group col-md-3">
                                    <label for="allApp">{{ __('All App') }}</label>
                                    <input type="checkbox" class="subscriberUser" id="allApp" name="usertype" value='4'>
                                    </div> --}}
                                {{-- </div> --}}

                                <div class="form-group" id="userList" style="display: none;">
                                    <label class="d-block">{{ __('User List') }} <span class="is_required">*</span></label>

                                    <select class="chzn-select form-control" name="user_id" id="user_id">
                                        {{--  @foreach ($users as $user)
                                            <option value="{{ $user->id }}"> {{ $user->name }}
                                            </option>
                                        @endforeach  --}}
                                        <option value="">SELECT</option>
                                    </select>
                                </div>

                                <div class="form-group" id="newuser_type" style="display: none;">
                                    <label>{{ __('Mobile') }} <span class="is_required">*</span></label>
                                    <input type="text" name="mobile" id="mobile" maxlength="10"
                                        class="form-control number-validation">
                                
                                    <label>{{ __('Email') }} <span class="is_required">*</span></label>
                                    <input type="text" name="email" id="email"
                                        class="form-control check-email-input">
                                    
                                </div>


                                <div class="form-group">
                                    <label>{{ __('Coupon Type') }} <span class="is_required">*</span></label>
                                    <select class="form-control" name="coupon_type" id="coupon_type" required>
                                        <option value="">{{ __('Select Coupon Type') }}</option>
                                        <option value="percentage">{{ __('Percentage') }}</option>
                                        <option value="flat_rate">{{ __('Fixed Amount') }}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Fixed Amount/Percenatge') }} <span class="is_required">*</span></label>
                                    <input type="text" name="discount" id="discount"
                                        class="form-control number-validation" required>
                                    <span class="is_required">* The amount must be between 0 and 1000000 ! *</span> or
                                    <span class="is_required">* The percentage must be between 0 and 100 ! *</span>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('No. Of Time Can Use') }} <span class="is_required">*</span></label>
                                    <input type="text" name="no_of_time" id="no_of_time" value="1" maxlength="8"
                                        class="form-control number-validation">
                                    
                                </div>

                                {{-- -add date new code di start- --}}
                                <div class="form-group">
                                    <label>Start Date</label><span class="is_required">*</span>
                                    <div class="ui calendar" id="rangestart">
                                        <div class="date-input">
                                            <input type="text" name="start_date" id="start_date" placeholder="mm/dd/yyyy"
                                                value="{{ old('start_date') }}" class="form-control" autocomplete="off"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>End Date</label><span class="is_required">*</span>
                                    <div class="ui calendar" id="rangeend">
                                        <div class="date-input">
                                            <input type="text" name="end_date" id="end_date"
                                                placeholder="mm/dd/yyyy" value="{{ old('end_date') }}"
                                                class="form-control" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>
                                {{-- -add date new code di end- --}}

                                <div class="form-group">
                                    <button class="btn btn-primary basicbtn" type="submit"
                                        id="submit">{{ __('Save') }}</button>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>{{ __('Is Featured ?') }} <span class="is_required">*</span></label>
                                    <select class="form-control" name="featured">
                                        <option value="0">{{ __('No') }}</option>
                                        <option value="1">{{ __('Yes') }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Is Default ?') }} <span class="is_required">*</span></label>
                                    <select class="form-control" name="is_default">
                                        <option value="0">{{ __('No') }}</option>
                                        <option value="1">{{ __('Yes') }}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Status') }} <span class="is_required">*</span></label>
                                    <select class="form-control" name="status">
                                        <option value="1">{{ __('Enable') }}</option>
                                        <option value="0">{{ __('Disable') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('end_body')
    <script src="{{ asset('assets/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/form.js') }}"></script>
    <script src="{{ asset('assets/js/input-validation.js') }}"></script>
    <script src="{{ asset('assets/js/chosen2/chosen.jquery.min.js') }}"></script>
    <script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
    <script>
        //---new code ajax form start---//
        $("#actionForm").on('submit', function(e) {
            e.preventDefault();
            var couponType = $('#coupon_type :selected').text();
            console.log(couponType);

            if (couponType == "Percentage") {
                if ($('input[name="discount"]').val() < 0 || $('input[name="discount"]').val() > 100) {
                    Sweet('error', 'The percentage must be between 0 and 100 !');
                    return false;
                }

            } else if (couponType == "Fixed Amount") {
                if ($('input[name="discount"]').val() < 0 || $('input[name="discount"]').val() > 1000000) {
                    Sweet('error', 'The amount must be between 0 and 1000000 !');
                    return false;
                }
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var basicbtnhtml = $('.basicbtn').html();
            $.ajax({
                type: 'POST',
                url: this.action,
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {

                    $('.basicbtn').html("Please Wait....");
                    $('.basicbtn').attr('disabled', '')

                },

                success: function(response) {
                    $('.basicbtn').removeAttr('disabled')

                    if (response.status == true) {
                        Sweet('success', response.message);
                        window.location.href = response.url;
                    } else {
                        Sweet('error', response.message);
                    }

                    $('.basicbtn').html(basicbtnhtml);
                    //location.reload();
                },
                error: function(xhr, status, error) {
                    $('.basicbtn').html(basicbtnhtml);
                    $('.basicbtn').removeAttr('disabled')
                    $('.errorarea').show();
                    $.each(xhr.responseJSON.errors, function(key, item) {
                        Sweet('error', item)
                        $("#errors").html("<li class='text-danger'>" + item + "</li>")
                    });
                    errosresponse(xhr, status, error);
                }
            })
        });
        //--- new ajax form code end ---//
    </script>

    {{-- new code  date start  --}}
    <script type="text/javascript">
        $(function() {
            var dateFormat = "mm/dd/yy",
                from = $("#start_date")
                .datepicker({
                    // defaultDate: "+1w",
                    changeMonth: true,
                    changeYear: true,
                    minDate: new Date(),
                    //maxDate: '5/5/2020',
                    numberOfMonths: 1
                })
                .on("change", function() {
                    to.datepicker("option", "minDate", getDate(this));
                }),
                to = $("#end_date").datepicker({
                    // defaultDate: "+1w",
                    changeMonth: true,
                    changeYear: true,
                    minDate: new Date(),
                    //maxDate: '5/5/2020',
                    numberOfMonths: 1
                })
                .on("change", function() {
                    from.datepicker("option", "maxDate", getDate(this));
                });

            function getDate(element) {
                var date;
                try {
                    date = $.datepicker.parseDate(dateFormat, element.value);
                } catch (error) {
                    date = null;
                }

                return date;
            }

            $("#showTo").click(function() {
                $("#start_date").datepicker("show");
            });
        });

        window.onload = () => {
            const start_date = document.getElementById('start_date');
            start_date.onpaste = e => e.preventDefault();

            const end_date = document.getElementById('end_date');
            end_date.onpaste = e => e.preventDefault();
        }

        //--- display none user list start ---//
        $('#coupon_for').click(function() {
            var couponFor = $('#coupon_for :selected').text();
            console.log(couponFor);
            if (couponFor == "For Individuals") {
                // $("#userList").show();//
                $("#subscriber_type").show();
            } else {
                //$("#userList").hide();//
                $("#subscriber_type").hide();
                $("#newuser_type").hide();
            }

            if (couponFor == "For All") {
                // $("#userList").hide();
                document.getElementById("userList").style.display = "none";
                document.getElementById("newuser_type").style.display = "none";
                
            }
        });
        // $(".chzn-select").chosen(); // Userlist search js

        //--- display none user list end ---//

    </script>
    //new code date end//


    {{-- free and paid and expired start --}}
    <script>
        $(document).ready(function() {
            $("#subscriber_type").change(function() {
                var selectedItem = $(this).val();
                var usertypeArray = $(this).find(':selected').data("value");
                console.log(usertypeArray, "result 1");

                if (usertypeArray == 1 || 2 || 3) {
                    $("#userList").show();
                    $("#newuser_type").hide();
                } else {
                    $("#userList").hide();
                    $("#newuser_type").hide();
                }

                if (usertypeArray == 0) {
                    $("#userList").hide();
                    $("#newuser_type").show();
                }

                $('#user_id').html('');
                $("#user_id").chosen("destroy");

                var url = '{!! route('admin.coupons.get-subscribe-user', '') !!}';
                let _token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: url,
                    type: "GET",
                    data: {
                        usertypeArray: usertypeArray,
                        _token: _token
                    },
                    success: function(response) {

                        console.log(response, "result");

                        if (response.status == true) {

                            var html = '';
                            if (response.userList != '') {

                                $.each(response.userList, function(k, v) {

                                    html += '<option value="' + v.userid + '">' + v
                                        .name + '</option>';

                                });

                            } else {
                                html += '<option value="">No user found</option>';
                            }

                            $('#user_id').html('');
                            $('#user_id').html(html);
                            $("#user_id").chosen();

                        } else {
                            $('#user_id').html('');
                            $('#userList').hide();
                        }

                    },
                    error: function(error) {
                        console.log(error);
                    }
                });

            });


        });

        function checkboxValue() {
            var free = $('#free').prop('checked'); // true | false 

        }
    </script>
    {{-- free and paid and expired end --}}

@endsection
