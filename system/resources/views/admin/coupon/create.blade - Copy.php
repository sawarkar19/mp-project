@extends('layouts.admin')
@section('title', 'Admin: Create Coupon')
@section('head')
<style type="text/css">
  .is_required{
    color:red;
  }
</style>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-colorpicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/chosen2/chosen.min.css') }}" />

@include('layouts.partials.headersection',['title'=>'Create Coupon'])
@endsection
@section('content')

<div class="row">
  <div class="col-12 mt-2">
    <div class="card">
      <div class="card-body">
        <form method="post" action="{{ route('admin.coupon.store') }}" class="couponform_with_reset" >
          @csrf
          <div class="row">
            <div class="col-sm-8">
              <div class="form-group">
                <label>{{ __('Coupon Name') }} <span class="is_required">*</span></label>
                <input type="text" name="name" class="form-control" required>
              </div>

              <div class="form-group">
                <label>{{ __('Coupon Code') }} <span class="is_required">*</span></label>
                <input type="text" name="code" class="form-control" required>
              </div>

              <div class="form-group">
                <label>{{ __('Coupon description') }} <span class="is_required">*</span></label>
                <input type="text" name="description" class="form-control" required>
              </div>

              <div class="form-group">
                <label>{{ __('Coupon For') }} <span class="is_required">*</span></label>
                <select class="form-control" name="coupon_for" id="coupon_for" required>
                  <option value="">{{ __('Select Coupon For') }}</option>
                  <option value="individuals">{{ __('For Individuals') }}</option>
                  <option value="for_all">{{ __('For All') }}</option>
                </select>
              </div>
              <div class="row" id="subscribedUser" style="display:none;">
                <div class="form-group col-md-3">
                  <label for="free">{{ __('Free Subscriber') }}</label>
                  <input type="checkbox" class="subscriberUser" id="free" name="usertype" value='1'>
                </div>

                <div class="form-group col-md-3">
                  <label for="paid">{{ __('Paid Subscriber') }}</label>
                  <input type="checkbox" class="subscriberUser" id="paid" name="usertype" value='2'>
                </div>

                <div class="form-group col-md-3">
                  <label for="expired">{{ __('Subscriber Expired') }}</label>
                  <input type="checkbox" class="subscriberUser" id="expired" name="usertype" value='3'>
                </div>

                <div class="form-group col-md-3">
                  <label for="allApp">{{ __('All App') }}</label>
                  <input type="checkbox" class="subscriberUser" id="allApp" name="usertype" value='4'>
                </div>
              </div>

              <div class="form-group" id="userList" style="display: none;">
                <label class="d-block">{{ __('User List') }} <span class="is_required">*</span></label>
                <select class="chzn-select form-control" name="user_id" id="user_id">
                  <option value="">SELECT</option>
                </select>
              </div>


              <div class="form-group">
                <label>{{ __('Coupon Type') }} <span class="is_required">*</span></label>
                <select class="form-control" name="coupon_type" id="coupon_type" required>
                  <option value="">{{ __('Select Coupon Type') }}</option>
                  <option value="percentage">{{ __('Percentage') }}</option>
                  <option value="price">{{ __('Price') }}</option>
                </select>
              </div>

              <div class="form-group">
                <label>{{ __('Price/Percenatge') }} <span class="is_required">*</span></label>
                <input type="number"  name="price_percentage" id="price_percentage" class="form-control"   required>
              </div>

              <div class="form-group">
                <label>{{ __('Start Date') }}</label>
                <input type="date"  name="start_date" class="form-control" required />
              </div>

              <div class="form-group">
                <label>{{ __('End Date') }}</label>
                <input type="date"  name="end_date" class="form-control" required />
              </div>

              <div class="form-group">
                <button class="btn btn-primary basicbtn" type="submit" id="submit">{{ __('Save') }}</button>
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
    <script>

      $(document).ready(function() {
          $('#coupon_type').click(function(){
            var couponType = $('#coupon_type :selected').text();
            console.log(couponType);
            if(couponType=="Percentage"){
              $("input").attr({
                 "max" : 100,
                 "min" : 1
              });
            } else if(couponType=="Price"){
                $("input").attr({
                 "max" : 1000000,
                 "min" : 1
                });
            }
          });

          $('#coupon_for').click(function(){
                var couponFor = $('#coupon_for :selected').text();
                console.log(couponFor);
                if(couponFor=="For Individuals"){
                    // $("#userList").show();
                    $("#subscribedUser").show();
                }else{
                    // $("#userList").hide();
                    $("#subscribedUser").hide();
                }
              });

          // $(".chzn-select").chosen(); // Userlist search js

          //Get userList from Coupon controller based on user subscription plan

          $(".subscriberUser").click(function (e) {
              var usertypeArray = [];
			  $("#userList").show();
			  $("input:checkbox[name=usertype]:checked").each(function(){
				usertypeArray.push($(this).val());
			  });
              console.log(usertypeArray);
			  $('#user_id').html('');
			  $("#user_id").chosen("destroy");

              var url = '{!! route('admin.coupons.get-subscribe-user','') !!}';
              let _token   = $('meta[name="csrf-token"]').attr('content');

              $.ajax({
                url: url,
                type:"GET",
                data : { usertypeArray : usertypeArray, _token : _token },
                success:function(response){

                    if(response.status == true){

						var html = '';
						$.each(response.userList, function(k, v) {

						html +='<option value="'+v.userid+'">'+v.name+'</option>';
						});
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

		  // $("#user_id").chosen();

      });

      function checkboxValue()
      {
        var free = $('#free').prop('checked'); // true | false

      }
    </script>
@endsection

