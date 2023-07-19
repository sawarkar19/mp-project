<script>

    $(document).on('click', '#buy_employee_account_add', function(){
        var qty = $('#buy_employee_account_qty').val();
        
        qty = parseInt(qty) + 1;
        $('#buy_employee_account_qty').val(qty);

        var constant_price = qty * $("#buy_constant_price_employee_account").val();
        $('#buy_sale_price_employee_account').text(constant_price);

        /* Calculate Payable Buy Amount */
        calculate_buy_total();

    });

    $(document).on('click', '#buy_employee_account_minus', function(){

        var qty = $('#buy_employee_account_qty').val();
        
        if(parseInt(qty) == 1){
            return false;
        }

        if(parseInt(qty) > 1){
            qty = parseInt(qty) - 1;
        }

        $('#buy_employee_account_qty').val(qty);

        var constant_price = qty * $("#buy_constant_price_employee_account").val();
        $('#buy_sale_price_employee_account').text(constant_price);

        /* Calculate Payable Buy Amount */
        calculate_buy_total();

    });

</script>

<script>
    /*Buy Bulk*/
    $(document).on('click', '#proceedWithBuy', function(e) {
        e.preventDefault();
        
        var package = $('input[name="pkg_duration"]:checked').val();
        var payable_amount = $('#total_buy_amount').text();
        var actual_total = $('#actual_buy_amount').text();
        var added_discount_buy = $('#added_discount_buy').text();
        var promocode_amount_buy = $('#promocode_amount_buy').text();
        var plan_id = $('#'+package+'_plan_id').val();
        var plan_name = $('#'+package+'_plan_name').val();
        var billing_type = $('#'+package+'_billing_type').val();
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        
        var ids = '';
        
        if($('#buy_input_openlink_api').is(':checked')) {
            ids += ',' + 'openlink_api';
        }
        if($('#buy_input_share_rewards').is(':checked')) {
            ids += ',' + 'share_rewards';
        }
        if($('#buy_input_instant_rewards').is(':checked')) {
            ids += ',' + 'instant_rewards';
        }
        if($('#buy_input_employee_account').is(':checked')) {
            ids += ',' + 'employee_account';
        }
        if($('#buy_input_d2c_post').is(':checked')) {
            ids += ',' + 'd2c_post';
        }
        if($('#buy_input_customised_wishing').is(':checked')) {
            ids += ',' + 'customised_wishing';
        }

        ids = ids.replace(/^,|,$/g,'');

        if(ids == ''){
            Sweet('error','Please select Apps.');
            return false;
        }

        var employee_count = $('#buy_employee_account_qty').val();
        var direct_post_count = $('#buy_d2c_post_qty').val();

        if(payable_amount != ''){
            
            $.ajax({
                url: '{{ route('business.setBuyData') }}',
                type: "post",
                data: {
                    _token: CSRF_TOKEN,
                    package: package,
                    payble_price: payable_amount,
                    total_amount: actual_total,
                    added_discount_amount: added_discount_buy,
                    promocode_amount: promocode_amount_buy,
                    plan_id: plan_id,
                    plan_name: plan_name,
                    billing_type: billing_type,
                    features: ids,
                    employee_count: employee_count,
                    direct_post_count: direct_post_count,
                    directpost_list: '',
                    employee_list: '',
                    plan_tab_type: 'buy_plan'
                },
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if(data.status == true){
                        window.location.href = "{{ route('business.make_payment', $getways->id) }}";
                    }else{
                        Sweet('error',data.message);
                    }
                }
            });
        }else{
            return false;
        }
    });
</script>

<script>

    // select apps and proceedToCheckout function
    $(document).on('click', '#proceedWithRenew', function(e) {
        e.preventDefault();
        // console.log('proceedToCheckout');
        var package = $('input[name="pkg_duration"]:checked').val();
        var payable_amount = $('#total_renew_amount').text();
        var actual_amount = $('#actual_renew_amount').text();
        var added_discount_renew = $('#added_discount_renew').text();
        var promocode_amount_renew = $('#promocode_amount_renew').text();
        var plan_id = $('#'+package+'_plan_id').val();
        var plan_name = $('#'+package+'_plan_name').val();
        var billing_type = $('#'+package+'_billing_type').val();
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        // return false;
        
        var ids = '';
        
        if($('#renew_input_openlink_api').is(':checked')) {
            ids += ',' + 'openlink_api';
        }
        if($('#renew_input_share_rewards').is(':checked')) {
            ids += ',' + 'share_rewards';
        }
        if($('#renew_input_instant_rewards').is(':checked')) {
            ids += ',' + 'instant_rewards';
        }
        if($('#renew_input_customised_wishing').is(':checked')) {
            ids += ',' + 'customised_wishing';
        }

        var employee_list = '';
        $('input[name="employee_list[]"]:checkbox:checked').each(function(i){
            employee_list += ','+ $(this).attr('id');
        });
        employee_list = employee_list.replace(/^,|,$/g,'');

        if(employee_list != ''){
            ids += ',' + 'employee_account';
        }

        var directpost_list = '';
        $('input[name="directpost_list[]"]:checkbox:checked').each(function(i){
            directpost_list += ','+ $(this).attr('id');
        });
        directpost_list = directpost_list.replace(/^,|,$/g,'');
        if(directpost_list != ''){
            ids += ',' + 'd2c_post';
        }

        ids = ids.replace(/^,|,$/g,'');

        if(ids == '' && employee_list == '' && directpost_list ==''){
            Sweet('error','Please select Apps.');
            return false;
        }

        var employee_count = $('#renew_employee_account_qty').val();
        var direct_post_count = $('#renew_d2c_post_qty').val();

        if(payable_amount != ''){
            
            $.ajax({
                url: '{{ route('business.setRenewData') }}',
                type: "post",
                data: {
                    _token: CSRF_TOKEN,
                    package: package,
                    payble_price: payable_amount,
                    total_amount: actual_amount,
                    added_discount_amount: added_discount_renew,
                    promocode_amount: promocode_amount_renew,
                    plan_id: plan_id,
                    plan_name: plan_name,
                    billing_type: billing_type,
                    features: ids,
                    employee_count: employee_count,
                    direct_post_count: direct_post_count,
                    directpost_list: directpost_list,
                    employee_list: employee_list,
                    plan_tab_type: 'renew_plan'
                },
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if(data.status == true){
                        window.location.href = "{{ route('business.make_payment', $getways->id) }}";
                    }else{
                        Sweet('error',data.message);
                    }
                }
            });
        }else{
            return false;
        }
    });
</script>

<script>

    function getApplyCouponBuy() {

        var total = $('#total_buy_amount').text();
        if(total <= 0){
            Sweet('error','Please select Apps.');
            return false;
        }

        var coupon = $('input[name="promo_code"]').val();

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        if(coupon != ''){
            $.ajax({
                url: '{{ route('business.getCouponCode') }}',
                type: "post",
                data: {
                    _token: CSRF_TOKEN,
                    coupon: coupon
                },
                dataType: 'JSON',
                success: function (data) {
                    /*console.log(data);*/
                    if(data.status == true){

                        var user_id = {{ Auth::id() }};

                        if(data.coupon.coupon_for != 'all'){
                            if(user_id != data.coupon.user_id){
                                Sweet('error','Coupon is invalid.');
                                return false;
                            }
                        }

                        $('input[name="promo_code"]').val(data.coupon.code);
                        $('input[name="coupon_user"]').val(data.coupon.user_id);
                        $('input[name="coupon_for"]').val(data.coupon.coupon_for);
                        $('input[name="coupon_type"]').val(data.coupon.coupon_type);
                        $('input[name="coupon_discount"]').val(data.coupon.discount);

                        /* Calculate Payable Buy Amount */
                        calculate_buy_total();

                        $('#cancelCoupon').css("display","block");
                        $('#applyCoupon').css("display","none");
                    }else{
                        Sweet('error',data.message);
                        return false;
                    }
                }
            });

        }else{
            Sweet('error','Coupon can not be blank.');
            return false;
        }
    };

    function removeCouponBuy() {

        var coupon = $('input[name="promo_code"]').val();
        var total = $('#total_buy_amount').text();
        
        if(coupon != ''){
            $('input[name="promo_code"]').val('');

            /* Calculate Payable Buy Amount */
            calculate_buy_total();

            $('#cancelCoupon').css("display","none");
            $('#applyCoupon').css("display","block");
        }else{
            Sweet('error','Coupon is blank');
            return false;
        }
    
    };

    $(document).on('click', '#applyCoupon', function(e) {
        e.preventDefault();

        getApplyCouponBuy();
    });

    $(document).on('click', '#cancelCoupon', function(e) {
        e.preventDefault();

        removeCouponBuy();
    });

</script>


<script>

    function getApplyCouponRenew() {

        var total = $('#total_renew_amount').text();
        if(total <= 0){
            Sweet('error','Please select Apps.');
            return false;
        }

        var coupon = $('input[name="promo_code_renew"]').val();

        if(coupon.toUpperCase() == 'WELCOME50'){
            Sweet('error',"Coupon is not valid.");
            return false;
        }

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        if(coupon != ''){
            $.ajax({
                url: '{{ route('business.getCouponCode') }}',
                type: "post",
                data: {
                    _token: CSRF_TOKEN,
                    coupon: coupon
                },
                dataType: 'JSON',
                success: function (data) {
                    /*console.log(data);*/
                    if(data.status == true){

                        var user_id = {{ Auth::id() }};

                        if(data.coupon.coupon_for != 'all'){
                            if(user_id != data.coupon.user_id){
                                Sweet('error','Coupon is invalid.');
                                return false;
                            }
                        }

                        $('input[name="promo_code_renew"]').val(data.coupon.code);
                        $('input[name="coupon_user_renew"]').val(data.coupon.user_id);
                        $('input[name="coupon_for_renew"]').val(data.coupon.coupon_for);
                        $('input[name="coupon_type_renew"]').val(data.coupon.coupon_type);
                        $('input[name="coupon_discount_renew"]').val(data.coupon.discount);

                        /* Calculate Payable Buy Amount */
                        calculate_renew_total();

                        $('#cancelCouponRenew').css("display","block");
                        $('#applyCouponRenew').css("display","none");
                    }else{
                        Sweet('error','Please try again.');
                    }
                }
            });

        }else{
            Sweet('error','Coupon is blank');
            return false;
        }
    };

    function removeCouponRenew() {

        var coupon = $('input[name="promo_code_renew"]').val();

        if(coupon.toUpperCase() == 'WELCOME50'){
            Sweet('error',"Coupon is not valid.");
            return false;
        }

        var total = $('#total_renew_amount').text();
        var promocode_amount = $('#promocode_amount_renew_row').text();
        
        if(coupon != ''){

            $('input[name="promo_code_renew"]').val('');

            /* Calculate Payable Buy Amount */
            calculate_renew_total();

            $('#cancelCouponRenew').css("display","none");
            $('#applyCouponRenew').css("display","block");
        }else{
            Sweet('error','Coupon is blank');
            return false;
        }
    
    };

    $(document).on('click', '#applyCouponRenew', function(e) {
        e.preventDefault();

        getApplyCouponRenew();
    });

    $(document).on('click', '#cancelCouponRenew', function(e) {
        e.preventDefault();

        removeCouponRenew();
    });
</script>

<script>
    window.addEventListener( "pageshow", function ( event ) {
      var historyTraversal = event.persisted || 
                             ( typeof window.performance != "undefined" && 
                                  window.performance.navigation.type === 2 );
      if ( historyTraversal ) {
        // Handle page restore.
        window.location.reload();
      }
    });
</script>

<script>

    /*Update Plan Prices for Renew and Buy*/

    $(document).on('change', '.change_plan', function(){
        getPlanData($(this).attr('id'));
    });

    function getPlanData(option_id) {
        var pricing_type = $('#'+option_id).val();
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        if(pricing_type){
            $.ajax({
                url: '{{ route('business.getPlanData') }}',
                type: "post",
                data: {
                    _token: CSRF_TOKEN,
                    pricing_type: pricing_type
                },
                dataType: 'JSON',
                // loader,
                beforeSend: function() {
                    $("#overlay").fadeIn(300);
                },
                success: function (data) {
                    $("#overlay").fadeOut(300);
                    /*console.log(data);*/
                    if(data.status == true){
                        /*Update Feature Sale Price*/
                        $('#buy_sale_price_openlink_api').text(data.sale_prices.openlink_api);
                        $('#buy_sale_price_share_rewards').text(data.sale_prices.share_rewards);
                        $('#buy_sale_price_instant_rewards').text(data.sale_prices.instant_rewards);
                        $('#buy_sale_price_employee_account').text(data.sale_prices.employee_account);
                        $('#buy_sale_price_d2c_post').text(data.sale_prices.d2c_post);
                        $('#buy_sale_price_customised_wishing').text(data.sale_prices.customised_wishing);

                        /*Update Input Value*/
                        $('input[name="buy_input_openlink_api"]').val(data.sale_prices.openlink_api);
                        $('input[name="buy_input_share_rewards"]').val(data.sale_prices.share_rewards);
                        $('input[name="buy_input_instant_rewards"]').val(data.sale_prices.instant_rewards);
                        $('input[name="buy_input_employee_account"]').val(data.sale_prices.employee_account);
                        $('input[name="buy_input_d2c_post"]').val(data.sale_prices.d2c_post);
                        $('input[name="buy_input_customised_wishing"]').val(data.sale_prices.customised_wishing);

                        /*Update Input Value*/
                        $('input[name="buy_sale_price_openlink_api"]').val(data.sale_prices.openlink_api);
                        $('input[name="buy_sale_price_share_rewards"]').val(data.sale_prices.share_rewards);
                        $('input[name="buy_sale_price_instant_rewards"]').val(data.sale_prices.instant_rewards);
                        $('input[name="buy_sale_price_employee_account"]').val(data.sale_prices.employee_account);
                        $('input[name="buy_sale_price_d2c_post"]').val(data.sale_prices.d2c_post);
                        $('input[name="buy_sale_price_customised_wishing"]').val(data.sale_prices.customised_wishing);

                        /*Update Input Value*/
                        $('#buy_input_openlink_api').val(data.sale_prices.openlink_api);
                        $('#buy_input_share_rewards').val(data.sale_prices.share_rewards);
                        $('#buy_input_instant_rewards').val(data.sale_prices.instant_rewards);
                        $('#buy_input_employee_account').val(data.sale_prices.employee_account);
                        $('#buy_input_d2c_post').val(data.sale_prices.d2c_post);
                        $('#buy_input_customised_wishing').val(data.sale_prices.customised_wishing);


                        /*Set Qty to default*/
                        $('#buy_d2c_post_qty').val(1);
                        $('#buy_employee_account_qty').val(1);


                        /*Update Feature Sale Price*/
                        $('#renew_sale_price_openlink_api').text(data.sale_prices.openlink_api);
                        $('#renew_sale_price_share_rewards').text(data.sale_prices.share_rewards);
                        $('#renew_sale_price_instant_rewards').text(data.sale_prices.instant_rewards);
                        $('#renew_sale_price_employee_account').text(data.sale_prices.employee_account);
                        $('#renew_sale_price_d2c_post').text(data.sale_prices.d2c_post);
                        $('#renew_sale_price_customised_wishing').text(data.sale_prices.customised_wishing);

                        /*Update Input Value*/
                        $('input[name="renew_input_openlink_api"]').val(data.sale_prices.openlink_api);
                        $('input[name="renew_input_share_rewards"]').val(data.sale_prices.share_rewards);
                        $('input[name="renew_input_instant_rewards"]').val(data.sale_prices.instant_rewards);
                        $('input[name="renew_input_employee_account"]').val(data.sale_prices.employee_account);
                        $('input[name="renew_input_d2c_post"]').val(data.sale_prices.d2c_post);
                        $('input[name="renew_input_customised_wishing"]').val(data.sale_prices.customised_wishing);

                        /*Update Input Value*/
                        $('input[name="renew_sale_price_openlink_api"]').val(data.sale_prices.openlink_api);
                        $('input[name="renew_sale_price_share_rewards"]').val(data.sale_prices.share_rewards);
                        $('input[name="renew_sale_price_instant_rewards"]').val(data.sale_prices.instant_rewards);
                        $('input[name="renew_sale_price_employee_account"]').val(data.sale_prices.employee_account);
                        $('input[name="renew_sale_price_d2c_post"]').val(data.sale_prices.d2c_post);
                        $('input[name="renew_sale_price_customised_wishing"]').val(data.sale_prices.customised_wishing);

                        /*Update Input Value*/
                        $('#renew_input_openlink_api').val(data.sale_prices.openlink_api);
                        $('#renew_input_share_rewards').val(data.sale_prices.share_rewards);
                        $('#renew_input_instant_rewards').val(data.sale_prices.instant_rewards);
                        $('#renew_input_employee_account').val(data.sale_prices.employee_account);
                        $('#renew_input_d2c_post').val(data.sale_prices.d2c_post);
                        $('#renew_input_customised_wishing').val(data.sale_prices.customised_wishing);

                        /*Update Individual Employee and D2C*/
                        $('input[name="employee_list[]"]:checkbox').each(function(i){
                            $('#'+$(this).attr('id')).val(data.sale_prices.employee_account);
                            $('#renew_sale_price_'+$(this).attr('id')).text(data.sale_prices.employee_account);
                            $('input[name="renew_sale_price_'+$(this).attr("id")+'"]').val(data.sale_prices.employee_account);
                        });
                        
                        $('input[name="directpost_list[]"]:checkbox').each(function(i){
                            $('#'+$(this).attr('id')).val(data.sale_prices.d2c_post);
                            $('#renew_sale_price_'+$(this).attr('id')).text(data.sale_prices.d2c_post);
                            $('input[name="renew_sale_price_'+$(this).attr("id")+'"]').val(data.sale_prices.d2c_post);
                        });


                        /*Set Qty to default*/
                        $('#renew_d2c_post_qty').val(1);
                        $('#renew_employee_account_qty').val(1);


                        /* Calculate Again */
                        calculate_buy_total();
                        calculate_renew_total();
                        
                    }else{
                        Sweet('error','Please try again.');
                    }
                }
            });
        }
    }
</script>

<script>

   $(document).on('click', '.subscribeBtn', function($e){
        $e.preventDefault();
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var recharge_id = $(this).attr('id');
        var rechrgeAmount = $(this).data('amt');
        var dataRechrge = $(this).data('msgs');
        var plan_name = 'Recharge Plan - ' + dataRechrge;

        // var base_price = $('#base_price').text();
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


</script>

<script>

    $(document).on('click', '#all_apps', function(e) {
        if($(this).is(':checked')){
            $('.buy_feature:checkbox').each(function(i){
        
                $(this).prop('checked', true);

            });
            $('#selectText').text('deselect');
            $('#offerText').text('You will not get extra 25% OFF if you click here.');

            $('#row_employee_account').removeClass('disable_plan');
            // $('#row_d2c_post').removeClass('disable_plan');
            // $('#row_customised_wishing').removeClass('disable_plan');
        }else{
            $('.buy_feature:checkbox').each(function(i){
        
                $(this).prop('checked', false);

            });
            $('#selectText').text('select');
            $('#offerText').text('You will get extra 25% OFF.');

            $('#row_employee_account').addClass('disable_plan');
            // $('#row_d2c_post').addClass('disable_plan');
            // $('#row_customised_wishing').addClass('disable_plan');
        }

        /* Calculate Payable Buy Amount */
        calculate_buy_total();

    });


    $(document).on('click', '.buy_feature', function(){

        var checkAll = true;
        $('.buy_feature:checkbox').each(function(i){
        
            if(!$(this).is(':checked')){
                checkAll = false
            }

        });
        if(checkAll == false){
            $('#all_apps').prop('checked', false);
            $('#selectText').text('deselect');
            $('#offerText').text('You will not get extra 25% OFF if you click here.');
        }else{
            $('#all_apps').prop('checked', true);
            $('#selectText').text('select');
            $('#offerText').text('You will get extra 25% OFF.');
        }

        var input_id = $(this).attr('id');

        changePlanStatus(input_id);

        /* Calculate Payable Buy Amount */
        calculate_buy_total();
    });

    function  changePlanStatus(input_id) {
        if('buy_input_openlink_api' == input_id || 'buy_input_share_rewards' == input_id || 'buy_input_instant_rewards' == input_id){


            /* if($('#buy_input_openlink_api').length != 0){
                if($('#buy_input_openlink_api').is(':checked') || $('#buy_input_share_rewards').is(':checked') || $('#buy_input_instant_rewards').is(':checked')) {

                    $('#row_d2c_post').removeClass('disable_plan');
                    $('#row_customised_wishing').removeClass('disable_plan');

                }else{

                    $('#row_d2c_post').addClass('disable_plan');
                    $('#row_customised_wishing').addClass('disable_plan');

                    $('#buy_input_d2c_post').prop('checked', false);
                    $('#buy_input_customised_wishing').prop('checked', false);

                }
            } */
            
            if($('#buy_input_share_rewards').length != 0 && $('#buy_input_instant_rewards').length != 0){
                if($('#buy_input_share_rewards').is(':checked') || $('#buy_input_instant_rewards').is(':checked')) {

                    $('#row_employee_account').removeClass('disable_plan');

                }else{
                    $('#row_employee_account').addClass('disable_plan');

                    $('#buy_input_employee_account').prop('checked', false);
                }
            }
            
        }
    }

    
</script>

<script>
    $(document).on('click', '.renew_feature', function(){
        var input_id = $(this).attr('id');

        /* Calculate Payable Buy Amount */
        calculate_renew_total(input_id);
    });
</script>

<script>
    function calculate_buy_total(){
        var total = 0;
        $('#actual_buy_amount').text(total);
        $('#promocode_amount_buy').text(total);
        $('#added_discount_buy').text(total);
        $('#total_buy_amount').text(total);
        $('#topbar_buy_amount').text(total);

        $('#promocode_amount_buy_row').css("display","none");

        $('#added_discount_buy_row').css("display","none");

        /* Add amount of all selected apps */
        if($('#buy_input_openlink_api').is(':checked')) {
            total = total + parseInt($('#buy_sale_price_openlink_api').text());
        }
        if($('#buy_input_share_rewards').is(':checked')) {
            total = total + parseInt($('#buy_sale_price_share_rewards').text());
        }
        if($('#buy_input_instant_rewards').is(':checked')) {
            total = total + parseInt($('#buy_sale_price_instant_rewards').text());
        }
        if($('#buy_input_employee_account').is(':checked')) {
            total = total + parseInt($('#buy_sale_price_employee_account').text());
        }
        if($('#buy_input_d2c_post').is(':checked')) {
            total = total + parseInt($('#buy_sale_price_d2c_post').text());
        }
        if($('#buy_input_customised_wishing').is(':checked')) {
            total = total + parseInt($('#buy_sale_price_customised_wishing').text());
        }
        /* Update total amount */
        $('#actual_buy_amount').text(total);


        /* Check is available for 25% Extra discount */
        if($('#all_apps').is(':checked')){
            var added_discount = Math.round(total * (25/100));
            total = Math.round(total - added_discount);

            $('#selectText').text('deselect');
            $('#offerText').text('You will not get extra 25% OFF if you click here.');

            $('#added_discount_buy').text(added_discount);
            $('#added_discount_buy_row').css("display","revert");
        }else{
            $('#selectText').text('select');
            $('#offerText').text('You will get extra 25% OFF.');
        }

        /* Apply coupon discount */
        var coupon = $('input[name="promo_code"]').val();

        if(coupon != ''){
            var user_id = {{ Auth::id() }};
            var coupon_type = $('input[name="coupon_type"]').val();
            var coupon_discount = $('input[name="coupon_discount"]').val();
            var coupon_amount = 0;

            if(coupon_type == 'percentage'){
                coupon_amount = Math.round(total * (coupon_discount/100));
            }else{
                coupon_amount = Math.round(coupon_discount);
            }
            total = Math.round(total - coupon_amount);

            /* Update Coupon Discount */
            $('#promocode_amount_buy').text(coupon_amount);
        }

        if(parseInt($('#promocode_amount_buy').text()) > 0){
            $('#promocode_amount_buy_row').css("display","revert");
        }

        /* Update payable amount */
        $('#total_buy_amount').text(total);
        $('#topbar_buy_amount').text(total);
    }


    function calculate_renew_total(input_id){
        var total = 0;
        $('#actual_renew_amount').text(total);
        $('#promocode_amount_renew').text(total);
        $('#added_discount_renew').text(total);
        $('#total_renew_amount').text(total);
        $('#topbar_renew_amount').text(total);

        $('#promocode_amount_renew_row').css("display","none");

        $('#added_discount_renew_row').css("display","none");

        /* Add amount of all selected apps */
        if($('#renew_input_openlink_api').is(':checked')) {
            total = total + parseInt($('#renew_sale_price_openlink_api').text());
        }
        if($('#renew_input_share_rewards').is(':checked')) {
            total = total + parseInt($('#renew_sale_price_share_rewards').text());
        }
        if($('#renew_input_instant_rewards').is(':checked')) {
            total = total + parseInt($('#renew_sale_price_instant_rewards').text());
        }
        if($('#renew_input_d2c_post').is(':checked')) {
            total = total + parseInt($('#renew_sale_price_d2c_post').text());
        }
        if($('#renew_input_customised_wishing').is(':checked')) {
            total = total + parseInt($('#renew_sale_price_customised_wishing').text());
        }

        
        if(input_id == 'renew_input_employee_account'){
            if($('#renew_input_employee_account').is(':checked')) {
                $('input[name="employee_list[]"]:checkbox').each(function(i){
                    $(this).prop('checked', true);
                });
            }else{
                $('input[name="employee_list[]"]:checkbox').each(function(i){
                    $(this).prop('checked', false);
                });
            }
        }else{
            $('#renew_input_employee_account').prop('checked', true);
            $('input[name="employee_list[]"]:checkbox').each(function(i){
                if(!$(this).is(':checked')){
                    $('#renew_input_employee_account').prop('checked', false);
                }
            });
        }

        
        
        /* Employee and D2C Post */
        $('input[name="employee_list[]"]:checkbox:checked').each(function(i){
            
            total = total + parseInt($('#renew_sale_price_'+$(this).attr('id')).text());
        });
        
        /* $('input[name="directpost_list[]"]:checkbox:checked').each(function(i){

            total = total + parseInt($('#renew_sale_price_'+$(this).attr('id')).text());
        }); */

        /* Update total amount */
        $('#actual_renew_amount').text(total);

        /* Apply coupon discount */
        var coupon = $('input[name="promo_code_renew"]').val();

        if(coupon != ''){
            var user_id = {{ Auth::id() }};
            var coupon_type = $('input[name="coupon_type_renew"]').val();
            var coupon_discount = $('input[name="coupon_discount_renew"]').val();
            var coupon_amount = 0;

            if(coupon_type == 'percentage'){
                coupon_amount = Math.round(total * (coupon_discount/100));
            }else{
                coupon_amount = Math.round(coupon_discount);
            }
            total = Math.round(total - coupon_amount);

            /* Update Coupon Discount */
            $('#promocode_amount_renew').text(coupon_amount);
        }

        if(parseInt($('#promocode_amount_renew').text()) > 0){
            $('#promocode_amount_renew_row').css("display","revert");
        }

        /* Update payable amount */
        $('#total_renew_amount').text(total);
        $('#topbar_renew_amount').text(total);
    }
</script>