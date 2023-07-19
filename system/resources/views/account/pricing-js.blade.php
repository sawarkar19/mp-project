<script>
    $(document).ready(function(){
        $("input[name='billing_type']").change(function(){
            var duration = $("input[name='billing_type']:checked").val();
            var build_plan = '';
            var payble_price = '';
            
            var pricing_data = @json($pricing_data);
            var plan_data = '';
            
            $('#billing-type-name').text(duration);
            
            
            $.each(pricing_data, function(key,value) {
                if(duration == key){
                    plan_data = value;
                }
            }); 

            $('.plan_groups').each(function(i){
                var group_slug = $(this).attr("id"); 

                if(duration == 'monthly'){
                    $("#"+group_slug+"_total").parent().hide();
                    $("#"+group_slug+"_monthly_total").parent().hide();
                }else{
                    $("#"+group_slug+"_total").parent().show();
                    $("#"+group_slug+"_monthly_total").parent().show();
                }

                $.each(plan_data, function(key,value) {
                    if(group_slug == key){
                        $("#"+group_slug+"_total").html(value.total_price);
                        $("#"+group_slug+"_payable").html(value.payble_price);
                        $("#"+group_slug+"_monthly_total").html(value.mothly_total_price);
                        $("#"+group_slug+"_monthly_payable").html(value.mothly_payble_price);
                        $("#"+group_slug+"_discount").text(value.discount);

                        if(value.discount == 0){
                            $("#"+group_slug+"_discount").parent().hide();
                        }else{
                            $("#"+group_slug+"_discount").parent().show();
                        }
                    }
                }); 
            });
            
            $('html,body').animate({
                scrollTop: $("#_plans_").offset().top - 300},
            500);

        });


    });


    // select apps and proceedToCheckout function
    $(document).on('click', '.proceed-to-checkout', function() {
        var plan_slug = $(this).attr("id");

        var billing_type = $('input[name="billing_type"]:checked').val();
        var total_price = $("#"+plan_slug+"_total").text();
        var payble_price = $("#"+plan_slug+"_payable").text();

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        if(total_price != ''){
            
            $.ajax({
                url: '{{ route('account.setPlanData') }}',
                type: "post",
                data: {
                    _token: CSRF_TOKEN,
                    plan_slug: plan_slug,
                    billing_type: billing_type,
                    total_price: total_price,
                    payble_price: payble_price
                },
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if(data.status == true){
                        window.location.href = "{{ route('account.checkout') }}";
                    }else{
                        Sweet('error','Please try again.');
                    }
                }
            });
        }else{
            return false;
        }
    });
</script>