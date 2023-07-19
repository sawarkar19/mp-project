@extends('layouts.admin')
@section('title', 'Admin: Create Coupon')
@section('head')
    <style type="text/css">
        .is_required {
            color: red;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/chosen2/chosen.min.css') }}" />
    <link href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css" rel="stylesheet" />
    @include('layouts.partials.headersection', ['title' => 'Edit Coupon'])
@endsection
@section('content')

    <div class="row">
        <div class="col-12 mt-2">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('admin.coupon.update', $info->id) }}" id="actionForm">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label>{{ __('Coupon Name') }} <span class="is_required">*</span></label>
                                    <input type="text" name="name" class="form-control char-spcs-validation"
                                        maxlength="30" required value="{{ $info->name }}">
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Coupon Code') }} <span class="is_required">*</span></label>
                                    <input type="text" name="code" class="form-control two-space-validation"
                                        maxlength="21" style="text-transform:uppercase;" required
                                        value="{{ $info->code }}">
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Coupon Description') }} <span class="is_required">*</span></label>
                                    <textarea name="description" class="form-control char-spcs-validation " cols="30" rows="3"
                                        placeholder="Description" id="description" maxlength="" required>{{ $info->description }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Coupon For') }} <span class="is_required">*</span></label>
                                    <select class="form-control" name="coupon_for" id="coupon_for" required>
                                        <option>{{ __('Select Coupon For') }}</option>
                                        <option @if ($info->coupon_for == 'individuals') selected="" @endif value="individuals">
                                            {{ __('For Individuals') }}</option>
                                        <option @if ($info->coupon_for == 'all') selected="" @endif value="all">
                                            {{ __('For All') }}</option>
                                    </select>
                                </div>


                                <div class="form-group" id="subscriber_type"
                                    @if ($info->coupon_for != 'individuals') {
                                        ' style="display:none;" ';
                                    } @endif>
                                    <label>{{ __('Subscribe Type') }} <span class="is_required">*</span></label>
                                    <select class="form-control" name="subscriber_type" id="subscriber_type">
                                        <option selected="" disabled>{{ __('Select Option') }}</option>
                                        <option @if ($info->subscriber_type == 0) selected="" @endif value="0"
                                            id="new_user" name="usertype" data-value="0">{{ __('New User') }}
                                        </option>
                                        <option @if ($info->subscriber_type == 1) selected="" @endif value="1"
                                            id="free" name="usertype" data-value="1">{{ __('Free Subscriber') }}
                                        </option>
                                        <option @if ($info->subscriber_type == 2) selected="" @endif value="2"
                                            id="paid" name="usertype" data-value="2">{{ __('Paid Subscriber') }}
                                        </option>
                                        <option @if ($info->subscriber_type == 3) selected="" @endif value="3"
                                            id="expired" name="usertype" data-value="3">
                                            {{ __('Subscriber Expired') }}</option>
                                    </select>
                                </div>


                                @if ($info->subscriber_type == 1 || $info->subscriber_type == 2 || $info->subscriber_type == 3)
                                    <div class="form-group" id="userList" style="display:block;">
                                        <label class="d-block">{{ __('User List') }} <span
                                                class="is_required">*</span></label>
                                        <select class="chzn-select form-control" name="user_id" id="user_id">
                                            <option value=""></option>
                                            @foreach ($getIndividualUser as $user)
                                                <option value="{{ $user->id }}"
                                                    {{ $getUser->id == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @else
                                    <div class="form-group" id="userList" style="display:none;">
                                        <label class="d-block">{{ __('User List') }} <span
                                                class="is_required">*</span></label>
                                        <select class="chzn-select form-control" name="user_id" id="user_id">
                                            <option value="0"></option>
                                            @foreach ($getIndividualUser as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                
                                @if ($info->subscriber_type == 0)
                                <div class="form-group" id="newuser_type" style="display: block;">
                                    <label>{{ __('Mobile') }} <span class="is_required">*</span></label>
                                    <input type="text" name="mobile" id="mobile" value="{{ $info->mobile }}" maxlength="10"
                                        class="form-control number-validation">
                                
                                    <label>{{ __('Email') }} <span class="is_required">*</span></label>
                                    <input type="text" name="email" id="email" value="{{ $info->email }}"
                                        class="form-control check-email-input">
                                    
                                </div>
                                @endif
                                

                                <div class="form-group">
                                    <label>{{ __('Coupon Type') }} <span class="is_required">*</span></label>
                                    <select class="form-control" name="coupon_type" id="coupon_type" required>
                                        <option>{{ __('Select Coupon Type') }}</option>
                                        <option @if ($info->coupon_type == 'percentage') selected="" @endif value="percentage">
                                            {{ __('Percentage') }}</option>
                                        <option @if ($info->coupon_type == 'flat_rate') selected="" @endif value="flat_rate">
                                            {{ __('Fixed Amount') }}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Fixed Amount/Percenatge') }} <span class="is_required">*</span></label>
                                    <input type="text" name="discount" id="discount"
                                        class="form-control number-validation" required value="{{ $info->discount }}">
                                    <span class="is_required">* The amount must be between 0 and 1000000 ! *</span> or
                                    <span class="is_required">* The percentage must be between 0 and 100 ! *</span>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('No. Of Time Can Use') }} <span class="is_required">*</span></label>
                                    <input type="text" name="no_of_time" id="no_of_time" maxlength="8" value="{{ $info->no_of_time }}"
                                        class="form-control number-validation">
                                    
                                </div>

                                {{-- add date new code di start --}}
                                <div class="form-group">
                                    <label>Start Date</label><span class="is_required">*</span>
                                    <div class="ui calendar" id="rangestart">
                                        <div class="date-input">
                                            <input type="text" name="start_date" id="start_date"
                                                placeholder="mm/dd/yyyy" value="{{ $start_date }}"
                                                class="form-control" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>End Date</label><span class="is_required">*</span>
                                    <div class="ui calendar" id="rangeend">
                                        <div class="date-input">
                                            <input type="text" name="end_date" id="end_date"
                                                placeholder="mm/dd/yyyy" value="{{ $end_date }}"
                                                class="form-control" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>
                                {{-- add date new code di end --}}

                                <div class="form-group">
                                    <button class="btn btn-primary basicbtn" type="submit">{{ __('Update') }}</button>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>{{ __('Is Featured ?') }} <span class="is_required">*</span></label>
                                    <select class="form-control" name="featured">
                                        <option value="0" @if ($info->featured == 0) selected="" @endif>
                                            {{ __('No') }}</option>
                                        <option value="1" @if ($info->featured == 1) selected="" @endif>
                                            {{ __('Yes') }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Is Default ?') }} <span class="is_required">*</span></label>
                                    <select class="form-control" name="is_default">
                                        <option value="0" @if ($info->is_default == 0) selected @endif>
                                            {{ __('No') }}</option>
                                        <option value="1" @if ($info->is_default == 1) selected @endif>
                                            {{ __('Yes') }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Status') }} <span class="is_required">*</span></label>
                                    <select class="form-control" name="status">
                                        <option value="1" @if ($info->status == 1) selected="" @endif>
                                            {{ __('Enable') }}</option>
                                        <option value="0" @if ($info->status == 0) selected="" @endif>
                                            {{ __('Disable') }}</option>
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

    <script type="text/javascript">
        //---add new code date start dinesh---//

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

        //---add new code end date dinesh---//
    </script>
    <script>
        //---new ajax code of edit page start dinesh---//
        $("#actionForm").on('submit', function(e) {
            e.preventDefault();

            var couponType = $('#coupon_type').val();
            // console.log(couponType);

            if (couponType == "percentage") {
                if ($('input[name="discount"]').val() < 0 || $('input[name="discount"]').val() > 100) {
                    Sweet('error', 'The percentage must be between 0 and 100 !');
                    return false;

                }
            } else if (couponType == "flat_rate") {
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
                    // location.reload();
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
        //---new ajax code of edit page start dinesh---//
    </script>

    <script>
        //---add extra code display none user list start dinesh---//
        $('#coupon_for').click(function() {
            var couponFor = $('#coupon_for').val();
            console.log(couponFor);
            if (couponFor == "individuals") {
                //$("#userList").show();//
                $("#subscriber_type").show();
            } else {
                $("#userList").hide();
                $("#subscriber_type").hide();
            }
        });
        // $(".chzn-select").chosen(); // Userlist search js
        //---add extra code display none user list end dinesh---//
    </script>

    {{-- free,paid and expired  start --}}
    <script>
        $(document).ready(function() {
            $("#subscriber_type").change(function() {
                var selectedItem = $(this).val();
                var usertypeArray = $(this).find(':selected').data("value");
                console.log(usertypeArray);

                if (usertypeArray == 1 || 2 || 3) {
                    $("#userList").show();
                } else {
                    $("#userList").hide();
                }

                if (usertypeArray == 0) {
                    $("#userList").hide();
                    $("#newuser_type").show();
                }

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

                        if (response.status == true) {

                            $('#user_id').empty();

                            if (response.userList != '') {

                                $.each(response.userList, function(k, v) {

                                    $('#user_id').append( '<option value="' + v.userid + '">' + v
                                        .name +
                                        '</option>');

                                });

                            } else {
                                $('#user_id').append( '<option value="">No user found</option>');
                            }

                        } else {
                            $('#user_id').empty();
                            $('#userList').hide();
                        }

                    },
                    error: function(error) {
                        console.log(error);
                    }
                });

            });

            //$(".chzn-select").chosen();//

        });
    </script>
    {{-- free,paid and expired end --}}

@endsection
