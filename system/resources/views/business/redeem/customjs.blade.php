<script type="text/javascript">
	$(function () {
	    $('#checkRedeemCoupon').on('click', function () {
			var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	    	var code = $("#coupon").val();

			var btn = $('#checkRedeemCoupon');
	    	
	    	if (code == 0 || code == -1 || code == -0) {
	    		$( "#error-show" ).replaceWith( '<span id="error-show">Please enter a valid Coupon</span>' );
	    		return false;
	    	}

	        $.ajax({
                type: 'POST',
                url: "{{url('/business/redeem-offers')}}",
                data: {code: code, _token: CSRF_TOKEN},
                dataType: 'JSON',
				beforeSend: function() {
                    btn.attr('disabled','').addClass('btn-progress');
                },
                success: function (results) {
                	// console.log(results);
					btn.removeAttr('disabled').removeClass('btn-progress');
                    if (results.success === true) {
                    	var type = 'future_offer';
                    	if(results.data.subscription.future_offer.future_offer != null){
                    		var title = results.data.subscription.future_offer.title;
                    		var discount_type = results.data.subscription.future_offer.future_offer.discount_type;
                    		var discount_value = results.data.subscription.future_offer.future_offer.discount_value;
                    		var offer_id = results.data.subscription.future_offer.id;
                    	}else{
                    		var title = results.data.subscription.instant_offer.title;
                    		var discount_type = results.data.subscription.instant_offer.instant_offer.discount_type;
                    		var discount_value = results.data.subscription.instant_offer.instant_offer.discount_value;
                    		var offer_id = results.data.subscription.instant_offer.id;
                    	}


                    	$( "#error-show" ).replaceWith( '<span id="error-show"></span>' );
                    	$('#couponForm').hide();
                    	$('#calculationForm').show();
                    	$('#offerTitle').replaceWith( '<td id="offerTitle">'+title+'</td>' );
                    	$('#offerTable').show();
                    	$("#form-head").replaceWith( '<h4 id="form-head">Enter Redeem Details!</h4>' );

                    	$( "#offer_id" ).val(offer_id);
                		$( "#discount_type" ).val(discount_type);
                		$( "#discount_value" ).val(discount_value);
                		$('#redeem_id').val(results.data.id);
                		$('#targets').val(results.targets);
                        
                    } else {
                        $( "#error-show" ).replaceWith( '<span id="error-show">'+results.message+'</span>' );
                    }
                },
                error: function(xhr) { 
					btn.removeAttr('disabled').removeClass('btn-progress');
	                $( "#error-show" ).replaceWith( '<span id="error-show">Something went wrong</span>' );
	            },
            });
	    });

	    $('#redeemOffer').on('click', function () {
	    	var offer_id = $( "#offer_id" ).val();
	    	var discount_type = $( "#discount_type" ).val();
	    	var discount_value = $( "#discount_value" ).val();
	    	var actualAmount = $( "#amount" ).val();
	    	var invoice = $( "#invoice" ).val();
	    	var targets = $( "#targets" ).val();

			var btn = $('#redeemOffer');

	    	var amount = Math.sign(actualAmount); 
			if (!isNaN(amount) && amount != 0 && amount != -1 && amount != -0) {
				$( "#error-amount" ).replaceWith('<span id="error-amount"></span>');

				var redeem_amount = $("#redeem_amount").val();

				if(redeem_amount == ''){
					$( "#error-amount" ).replaceWith('<span id="error-amount">Please calculate the total first!</span>');
				}else{
					if (invoice == undefined) {
						invoice = '';
					}
					var redeem_id = $('#redeem_id').val();

					var calculated_amount = redeem_amount;
                    var final_amount = redeem_amount;
                    if (Math.sign(redeem_amount) == -1) {
                        final_amount = 0;
                    }

                    var final_discount = discount_value;
                    if(discount_type == 'Perclick'){
                    	final_discount = discount_value * targets;
                    }

					var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        			var data = { offer_id: offer_id, redeem_id: redeem_id,actualAmount: actualAmount, invoice: invoice, discount_type: discount_type, discount_value: final_discount, redeem_amount: final_amount, calculated_amount:calculated_amount, targets: targets}

					$.ajax({
	                    type: 'POST',
	                    url: "{{url('/business/proceed-redeem')}}",
	                    data: {data: data, _token: CSRF_TOKEN},
	                    dataType: 'JSON',
						beforeSend: function() {
							btn.attr('disabled','').addClass('btn-progress');
						},
	                    success: function (results) {
							btn.removeAttr('disabled').removeClass('btn-progress');
	                        if (results.success === true) {
	                            swal.fire("Done!", results.message, "success");
                            
	                            setTimeout(function(){
	                                location.reload();
	                            },2000);
	                        } else {
	                            Swal.showValidationMessage(results.message)
	                        }
	                    },
	                    error: function(xhr) {
							btn.removeAttr('disabled').removeClass('btn-progress');
							Swal.showValidationMessage('Somethingn went wrong')
			            },
	                });
				}
				
			}else{
				$( "#totalBox" ).replaceWith( '<div id="totalBox"></div>' );
				$( "#error-amount" ).replaceWith( '<span id="error-amount">Please enter valid amount!</span>' );
			}
	    });


	    $('#calculateOffer').on('click', function () {
	    	var discountType = $( "#discount_type" ).val();
	    	var discountValue = $( "#discount_value" ).val();
	    	var actualAmount = $( "#amount" ).val();
	    	var invoice = $( "#invoice" ).val();
	    	var targets = $( "#targets" ).val();

	    	var amount = Math.sign(actualAmount); 
			if (!isNaN(amount) && amount != 0 && amount != -1 && amount != -0) {

				if('{{ $businessSettings['invoice_required'] }}' == 'Yes' && invoice == ''){
		            $( "#error-invoice" ).replaceWith('<span id="error-invoice">Please enter valid Invoice Number!</span>');
		            $( "#error-amount" ).replaceWith('<span id="error-amount"></span>');
		            return false;
		        }
		        $( "#error-invoice" ).replaceWith('<span id="error-invoice"></span>');
	        	$( "#error-amount" ).replaceWith('<span id="error-amount"></span>');
				
				
				var amount = 0;
				var discount_amount = 0;
                var type = '%';

                if(discountType == 'Perclick'){
                    amount = actualAmount - (discountValue * targets);
                    type = '₹ Per Click';
                }else if(discountType == 'Percentage'){
                    amount = actualAmount - (actualAmount / 100) * discountValue;
                    amount = amount.toFixed(2);
                    type = '%';

                }else{
                    amount = actualAmount - discountValue;
                    type = '₹';
                }

                discount_amount = actualAmount - amount;
                discount_amount = discount_amount.toFixed(2);

                var check = Math.sign(amount);
                if(isNaN(check) || check == 0 || check == -1 || check == -0) {
                    Swal.showValidationMessage(`Please enter valid amount!`)
                    return;
                }

                $('#redeemOffer').prop('disabled', false);

                $("#redeem_amount").val(amount);

                $( "#totalBox" ).replaceWith( '<div id="totalBox" class="total-amount"><div class="py-2"><span class="theme-color">Payment Summary</span><div class="mb-3"><hr class="dashed"></div><div class="d-flex justify-content-between"><span class="font-weight-bold">Amount</span> <span class="text-muted">₹ '+actualAmount+'</span></div><div class="d-flex justify-content-between"> <small>Discount ( '+discountValue+' '+type+' )</small> <small>- ₹ '+discount_amount+'</small> </div><div class="d-flex justify-content-between mt-3"> <span class="font-weight-bold">Total</span><span class="font-weight-bold theme-color">₹ '+amount+'</span></div></div></div>' );
			
			}else{
				$( "#totalBox" ).replaceWith( '<div id="totalBox"></div>' );
				$( "#error-amount" ).replaceWith( '<span id="error-amount">Please enter valid amount!</span>' );
				$( "#error-invoice" ).replaceWith('<span id="error-invoice"></span>');
			}
	    });
	});

	$( "#resetBtn" ).on( "click", function() {
	  	$( "#amount" ).val('');
	  	$( "#invoice" ).val('');
	  	$('#redeemOffer').prop('disabled', true);
	  	$( "#totalBox" ).replaceWith( '<div id="totalBox" class="total-amount"></div>' );
	});

	$(document).ready(function(){
        $( "body" ).delegate( "#amount", "keyup", function() {
            $('#redeemOffer').prop('disabled', true);
            $( "#totalBox" ).replaceWith( '<div id="totalBox" class="total-amount"></div>' );
        });

        $( "body" ).delegate( "#invoice", "keyup", function() {
        	if('{{ $businessSettings['invoice_required'] }}' == 'Yes'){
				$('#redeemOffer').prop('disabled', true);
            	$( "#totalBox" ).replaceWith( '<div id="totalBox" class="total-amount"></div>' );
	        }
            
        });
    });
					
</script>