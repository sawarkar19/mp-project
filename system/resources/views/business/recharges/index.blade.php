@extends('layouts.business')
@section('title', 'All Messages Recharge: Business Panel')

@section('head')
    <div class="section-header">
            <h1>All Messages Recharge</h1>

            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">Business</a></div>
                <div class="breadcrumb-item">Recharge</div>
            </div>
        </div>
@endsection

@section('end_head')
<style>
.customB {
    vertical-align: middle;
    padding: 2px 12px;
    font-weight: 500;
    letter-spacing: .3px;
    border-radius: 30px;
    font-size: 10px;
    color: #fff;
}
.rechrgeAmount {
    border-right: 2px solid #ddd;
    padding-right: 25px;
}
.rechrgeAmount h4 {
    padding-top: 16px;
}
.dataRechrge p:first-child{
    font-weight: bold;
}
.dataRechrge .textDull{
    color: #b9b4b4;
}
.togBorder{
    border: 2px solid #ffc107;
    box-shadow: 0px 0px 6px 2px #ffc107;
}
.payAmount span {
    font-weight: bold;
}
</style>
@endsection

@section('content')

<div class="row msgrechargeblog">
    @foreach($posts as $recharge)
            @if ($recharge->price != 0)
    <div class="col-lg-3 col-md-6 col-sm-6 col-12 ">

            <div class="card rechargeBox msg-recharge" data-amt="{{$recharge->price}}" id="{{ $recharge->id }}" style="cursor: pointer;">
                <div class="px-3 pt-3">
                    <span class="customB badge-warning ">New Offer with Data Addon</span>
                </div>
                <div class="d-flex justify-content-around p-3">
                    <div class="rechrgeAmount">
                        <h4>&#8377; <span id="recharge_amt_id">{{ $recharge->price }}</span></h4>
                    </div>
                    <div class="dataRechrge" style="padding-left: 10px;">
                        <p class="mb-0"><span id="unit_id">{{ $recharge->messages }} msg</span></p>
                        <p class="m-0 textDull">₹ {{ $recharge->per_message }} per Messages</p>
                    </div>
                </div>
               
                <div class="card-body">
                    <!-- <input class="form-check-input" type="checkbox"> -->
                    <p>Get {{ $recharge->messages }} WhatsApp messages for unlimited period. Also get carry forward benefits.</p>
                </div>
            </div>
            
    </div>
    @else
                
    @endif
    @endforeach

    <input type="hidden" id="msg_recharge_id" value="">
    <!-- <input type="hidden" id="pay_amount" value=""> -->
    <!-- <input type="hidden" id="recharge_id" value=""> -->

    <div class="col-md-12"> 
        <div class="text-center mt-4">
            <h6 class="payAmount" id="selected_plan"><span value="">Please select recharge plan!</span></h6>
            <h6 class="payAmount" style="display:none">Payable Amount is <span id="amount_pay" value="">&#8377; </span></h6>
            <button id="{{ $recharge->id }}" class="btn btn-primary mt-2 subscribeBtn">Proceed to Checkout</button>
        </div>
    </div>
                 
</div>


@endsection 


@section('end_body')
<script>
    $('.rechargeBox').click(function(){
      $('.rechargeBox').removeClass('togBorder');
      $(this).addClass('togBorder');
    });
  $(document).on('click', '.subscribeBtn', function($e){
        $e.preventDefault();
            var recharge_id = $('#msg_recharge_id').val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var rechrgeAmount = $('#recharge_amt_id').text();
            var dataRechrge = $('#unit_id').text();
            // var base_price = $('#base_price').text();
            var plan_name = 'Abcd';
            // var billing_type = $("input[name='billing_type']:checked").val();

            var input = {
                "recharge_id" : recharge_id,
                "rechrgeAmount": rechrgeAmount,
                "dataRechrge": dataRechrge,
                "plan_name": plan_name,
                // "billing_type": billing_type,
                "_token" : CSRF_TOKEN
            };
            $.ajax({
                url : '{{ route('business.checkRechargeSubscription') }}',
                type : 'POST',
                data : input,
                dataType : "json",
                success : function(response) {
                    //console.log(response);
                    if(response.status == true){
                            window.location.href = response.url;
                    }else if(response.status == false){
                            Swal.fire({
                              icon: 'success',
                              title: 'Hey!',
                              text: response.message
                            });
                    }
                    
                }
            });

    
  });

  $(document).on('click', '.msg-recharge', function($e){
        var msg_recharge = $(this).attr('id');
        var rechrgeAmount = $(this).attr('data-amt');
  //    var dataRechrge = $(this).data('units');        
        
        $('#msg_recharge_id').val(msg_recharge);
        $('#amount_pay').html("&#8377; "+ rechrgeAmount);
        $('.payAmount').show();
        $('#selected_plan').hide();
  //       $('#unit_id').val(dataRechrge);
  });

</script>

@endsection