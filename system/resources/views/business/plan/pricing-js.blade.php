<script>

    $(document).ready(function(){
        setTimeout(() => {
            $('html, body').animate({
                scrollTop: $('#price_start').offset().top
            }, 2000);
        }, 3000);
        // $('.div_share_rewards .')
        var package_input = $('input[name="package_type"]');
        $('.featurs_price_main .feature-list').removeClass('reduce_opacity');
        $(".custom-check input[type=checkbox]").prop('checked', true);
        $(".fr-inputs").removeAttr('disabled');
        $(".qty-count").removeAttr('disabled');

        calculate();
        
        package_input.on('change', function(){
            var package = $('input[name="package_type"]:checked').val();
            if(package === 'personal'){
                $('#allAppsDiscount').hide();
                $('.employee_account_input').prop('checked', false);
                package_input.parents('div.pkg-buttons').removeClass('business').addClass(package);
                calculate();
            } else if(package === 'business'){
                $('#allAppsDiscount').show();
                package_input.parents('div.pkg-buttons').removeClass('personal').addClass(package);
                $('.featurs_price_main .feature-list').removeClass('reduce_opacity');
                $('.custom-check input').removeAttr('disabled');
                $(".custom-check input[type=checkbox]"). prop('checked', $(this). prop('checked'));
                // console.log('done');
                calculate();
            }
        });

        /*Set on load*/
        $(document).on('change', '.custom-switch-input', function(){
            /*console.log('calling');*/

            var pricing_type = $(this).val();
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
                        console.log(data);
                        if(data.status == true){
                            /*sale price*/
                            $('.openlink_api_sale_price').text(data.sale_prices.openlink_api);
                            $('.share_rewards_sale_price').text(data.sale_prices.share_rewards);
                            $('.instant_rewards_sale_price').text(data.sale_prices.instant_rewards);
                            $('.employee_account_sale_price').text(data.sale_prices.employee_account);
                            $('.d2c_post_sale_price').text(data.sale_prices.d2c_post);
                            $('.customised_wishing_sale_price').text(data.sale_prices.customised_wishing);

                            $('.openlink_api_input').text(data.sale_prices.openlink_api);
                            $('.share_rewards_input').text(data.sale_prices.share_rewards);
                            $('.instant_rewards_input').text(data.sale_prices.instant_rewards);
                            $('.employee_account_input').text(data.sale_prices.employee_account);
                            $('.d2c_post_input').text(data.sale_prices.d2c_post);
                            $('.customised_wishing_input').text(data.sale_prices.customised_wishing);

                            /*actual price*/
                            $('#openLinkApiPrice').val(data.prices.openlink_api);
                            $('#shareRewardsPrice').val(data.prices.share_rewards);
                            $('#instantRewardsPrice').val(data.prices.instant_rewards);
                            $('#employeePrice').val(data.prices.employee_account);
                            $('#d2cPostPrice').val(data.prices.d2c_post);
                            $('#customisedWishingPrice').val(data.prices.customised_wishing);

                            /* employee & d2c counter */
                            var employeeQty = $('.employee_account_qty').val();
                            var employeeUpdatedPrice = parseInt(data.prices.employee_account) * parseInt(employeeQty);
                            $('.employee_account_sale_price').text(employeeUpdatedPrice);

                            var d2cPostQty = $('.d2c_post_qty').val();
                            var d2cPostUpdatedPrice = parseInt(data.prices.d2c_post) * parseInt(d2cPostQty);
                            $('.d2c_post_sale_price').text(d2cPostUpdatedPrice);

                            /*update full plan details*/
                            $('#perMonthPrice').text(data.full_plan.full_monthly_price);
                            $('#full_price').text(data.full_plan.full_price);
                            $('#full_sale_price').text(data.full_plan.full_sale_price);
                            $('#full_total').text(data.full_plan.full_total);
                            $('#discount_percentage').text(Math.round(data.planInfo.discount));

                            $('#plan_id').val(data.planInfo.selected_plan);
                            $('#billedPlanName').text(data.planInfo.plan_name);
                            $('#plan_name').val(data.planInfo.plan_name);
                            $('#billing_type').val(data.planInfo.billing_type);

                            calculate();
                        }else{
                            Sweet('error','Please try again.');
                        }
                    }
                });
            }
        });
    });


    // sweet alert function 
    function Sweet(icon,title,time=3000){
    
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: time,
            timerProgressBar: true,
            onOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: icon,
            title: title,
        })
    }

    function allCeckboxes(){
        var package_input = $('input[name="package_type"]');
        var package = $('input[name="package_type"]:checked').val();

        if ($('.fr-inputs:checked').length == $('.fr-inputs').length){
            $('#pkg_all_apps').prop('checked', true);
            // console.log('all apps');
            $('#allAppsDiscount').show();
            package_input.parents('div.pkg-buttons').removeClass('personal').addClass('business');
        } else {
            $('#pkg_select_apps').prop('checked', true);
            // console.log('select apps');
            $('#allAppsDiscount').hide();
            package_input.parents('div.pkg-buttons').removeClass('business').addClass('personal');
        }
    }

    $(document).on('click', '#fetaure_row_openlink_api', function(){
        if($('.openlink_api_input').is(':checked')) {
            $('#fetaure_row_share_rewards').removeClass('reduce_opacity');
            $('#fetaure_row_instant_rewards').removeClass('reduce_opacity');
            $('#fetaure_row_d2c_post').removeClass('reduce_opacity');
            $('#fetaure_row_customised_wishing').removeClass('reduce_opacity');

            $( ".share_rewards_input" ).prop('disabled', false);
            $( ".instant_rewards_input" ).prop('disabled', false);
            $( ".d2c_post_input" ).prop('disabled', false);
            $( ".customised_wishing_input" ).prop('disabled', false);
            
            $('#fetaure_row_employee_account').removeClass('reduce_opacity');
            if($('.share_rewards_input').is(':checked') || $('.instant_rewards_input').is(':checked')) {
                $( ".employee_account_input" ).prop('disabled', false);
            }else{
                $('#fetaure_row_employee_account').addClass('reduce_opacity');
                $( ".employee_account_input" ).prop('disabled', true);
            }

        }else{
            $('#fetaure_row_share_rewards').addClass('reduce_opacity');
            $('#fetaure_row_instant_rewards').addClass('reduce_opacity');
            $('#fetaure_row_d2c_post').addClass('reduce_opacity');
            $('#fetaure_row_customised_wishing').addClass('reduce_opacity');
            $('#fetaure_row_employee_account').addClass('reduce_opacity');

            $( ".share_rewards_input" ).prop('disabled', true);
            $( ".instant_rewards_input" ).prop('disabled', true);
            $( ".d2c_post_input" ).prop('disabled', true);
            $( ".customised_wishing_input" ).prop('disabled', true);
            $( ".employee_account_input" ).prop('disabled', true);

            $( ".share_rewards_input" ).prop('checked', false);
            $( ".instant_rewards_input" ).prop('checked', false);
            $( ".d2c_post_input" ).prop('checked', false);
            $( ".customised_wishing_input" ).prop('checked', false);
            $( ".employee_account_input" ).prop('checked', false);
        }

        calculate();
        allCeckboxes();
    });

    $(document).on('click', '.openlink_api_input', function(){
        var share_rewards_input = $('.share_rewards_input');
        var instant_rewards_input = $('.instant_rewards_input');
        if($(this).is(':checked') || share_rewards_input.is(':checked') || instant_rewards_input.is(':checked')) {
            $('.div_d2c_post').removeClass('reduce_opacity');
            $( ".d2c_post_input" ).prop('disabled', false);
            $('.div_customised_wishing').removeClass('reduce_opacity');
            $( ".customised_wishing_input" ).prop('disabled', false);
        }else{
            $('.div_d2c_post').addClass('reduce_opacity');
            $( ".d2c_post_input" ).prop('disabled', true);
            $( ".d2c_post_input" ).prop('checked', false);

            $('.div_customised_wishing').addClass('reduce_opacity');
            $( ".customised_wishing_input" ).prop('disabled', true);
            $( ".customised_wishing_input" ).prop('checked', false);
        }

        calculate();
        allCeckboxes();
    });

    $(document).on('click', '.instant_rewards_input', function(){
        var share_rewards_input = $('.share_rewards_input');
        var openlink_api_input = $('.openlink_api_input');
        if($(this).is(':checked') || share_rewards_input.is(':checked') || openlink_api_input.is(':checked')) {
            $('.div_d2c_post').removeClass('reduce_opacity');
            $( ".d2c_post_input" ).prop('disabled', false);
            $('.div_customised_wishing').removeClass('reduce_opacity');
            $( ".customised_wishing_input" ).prop('disabled', false);
        }else{
            $('.div_d2c_post').addClass('reduce_opacity');
            $( ".d2c_post_input" ).prop('disabled', true);
            $( ".d2c_post_input" ).prop('checked', false);

            $('.div_customised_wishing').addClass('reduce_opacity');
            $( ".customised_wishing_input" ).prop('disabled', true);
            $( ".customised_wishing_input" ).prop('checked', false);
        }

        if($(this).is(':checked') || share_rewards_input.is(':checked')){
            $('.div_employee_account').removeClass('reduce_opacity');
            $( ".employee_account_input" ).prop('disabled', false);
            
        }else{
            $('.div_employee_account').addClass('reduce_opacity');
            $( ".employee_account_input" ).prop('disabled', true);
            $( ".employee_account_input" ).prop('checked', false);
        }

        calculate();
        allCeckboxes();
    });

    $(document).on('click', '.share_rewards_input', function(){
        var openlink_api_input = $('.openlink_api_input');
        var instant_rewards_input = $('.instant_rewards_input');
        if($(this).is(':checked') || openlink_api_input.is(':checked') || instant_rewards_input.is(':checked')) {
            $('.div_d2c_post').removeClass('reduce_opacity');
            $( ".d2c_post_input" ).prop('disabled', false);
            $('.div_customised_wishing').removeClass('reduce_opacity');
            $( ".customised_wishing_input" ).prop('disabled', false);
        }else{
            $('.div_d2c_post').addClass('reduce_opacity');
            $( ".d2c_post_input" ).prop('disabled', true);
            $( ".d2c_post_input" ).prop('checked', false);

            $('.div_customised_wishing').addClass('reduce_opacity');
            $( ".customised_wishing_input" ).prop('disabled', true);
            $( ".customised_wishing_input" ).prop('checked', false);
        }

        if($(this).is(':checked') || instant_rewards_input.is(':checked')){
            $('.div_employee_account').removeClass('reduce_opacity');
            $( ".employee_account_input" ).prop('disabled', false);
            
        }else{
            $('.div_employee_account').addClass('reduce_opacity');
            $( ".employee_account_input" ).prop('disabled', true);
            $( ".employee_account_input" ).prop('checked', false);
        }

        calculate();
        allCeckboxes();
    });

    $(document).on('click', '.customised_wishing_input', function(){
        if($(this).is(':checked')) {
            $('#fetaure_row_employee_account').removeClass('reduce_opacity');
            $( ".employee_account_input" ).prop('disabled', false);
        }else if($('.instant_rewards_input').is(':checked')){
            $('#fetaure_row_employee_account').removeClass('reduce_opacity');
            $( ".employee_account_input" ).prop('disabled', false);
        }else{
            $('#fetaure_row_employee_account').addClass('reduce_opacity');
            $( ".employee_account_input" ).prop('disabled', true);
            $( ".employee_account_input" ).prop('checked', false);
        }

        calculate();
        allCeckboxes();
    });

    $(document).on('click', '.share_rewards_input', function(){
        if($(this).is(':checked')) {
            $('#fetaure_row_employee_account').removeClass('reduce_opacity');
            $( ".employee_account_input" ).prop('disabled', false);
        }else if($('.instant_rewards_input').is(':checked')){
            $('#fetaure_row_employee_account').removeClass('reduce_opacity');
            $( ".employee_account_input" ).prop('disabled', false);
        }else{
            $('#fetaure_row_employee_account').addClass('reduce_opacity');
            $( ".employee_account_input" ).prop('disabled', true);
            $( ".employee_account_input" ).prop('checked', false);
        }

        calculate();
        allCeckboxes();
    });

    $(document).on('click', '.instant_rewards_input', function(){
        if($(this).is(':checked')) {
            $('#fetaure_row_employee_account').removeClass('reduce_opacity');
            $( ".employee_account_input" ).prop('disabled', false);
        }else if($('.share_rewards_input').is(':checked')){
            $('#fetaure_row_employee_account').removeClass('reduce_opacity');
            $( ".employee_account_input" ).prop('disabled', false);
        }else{
            $('#fetaure_row_employee_account').addClass('reduce_opacity');
            $( ".employee_account_input" ).prop('disabled', true);
            $( ".employee_account_input" ).prop('checked', false);
        }

        calculate();
    });

    $(document).on('click', '.social_media_input', function(){
        if($(this).is(':checked')) {
            $( this ).prop('checked', true);
        }else{
            $( this ).prop('checked', true);
        }

        calculate();
        allCeckboxes();
    });

    $(document).on('click', '.make_share_input', function(){
        if($(this).is(':checked')) {
            $( this ).prop('checked', true);
        }else{
            $( this ).prop('checked', true);
        }

        calculate();
        allCeckboxes();
    });

    $(document).on('click', '.d2c_post_add', function(){

        var price = $("#d2cPostPrice").val();
        var qty = $('.d2c_post_qty').val();
        if(qty == 4){
            return false;
        }
        qty = parseInt(qty) + 1;
        $('.d2c_post_qty').val(qty);

        var updated_sale_price = parseInt(price) * parseInt(qty);
        $('.d2c_post_sale_price').text(updated_sale_price);

        // var updated_price = parseInt(price) * parseInt(qty);
        // $('.employee_account_sale_price').val(updated_price);
        /*console.log(updated_price);*/

        calculate();
        allCeckboxes();
    });

    $(document).on('click', '.d2c_post_minus', function(){

        var price = $("#d2cPostPrice").val();
        var qty = $('.d2c_post_qty').val();
        if(parseInt(qty) > 1){
            qty = parseInt(qty) - 1;
        }
        $('.d2c_post_qty').val(qty);

        var updated_sale_price = parseInt(price) * parseInt(qty);
        $('.d2c_post_sale_price').text(updated_sale_price);

        calculate();
        allCeckboxes();
    });

    $(document).on('click', '.employee_account_add', function(){
        var qty = $('.employee_account_qty').val();
        var price = $("#employeePrice").val();
        console.log(price);
        qty = parseInt(qty) + 1;
        $('.employee_account_qty').val(qty);

        var updated_sale_price = parseInt(price) * parseInt(qty);
        $('.employee_account_sale_price').text(updated_sale_price);

        calculate();
        allCeckboxes();
    });

    $(document).on('click', '.employee_account_minus', function(){


        var qty = $('.employee_account_qty').val();
        var price = $("#employeePrice").val();
        console.log(price);
        if(parseInt(qty) > 1){
            qty = parseInt(qty) - 1;
        }
        $('.employee_account_qty').val(qty);

        var updated_sale_price = parseInt(price) * parseInt(qty);
        $('.employee_account_sale_price').text(updated_sale_price);

        calculate();
        allCeckboxes();
    });

    $(document).on('click', '.d2c_post_input', function(){
        if($(this).is(':checked')) {
            $( ".d2c_post_qty" ).prop('disabled', false);
            $( ".d2c_post_add" ).prop('disabled', false);
            $( ".d2c_post_minus" ).prop('disabled', false);
        }else{
            $( ".d2c_post_qty" ).prop('disabled', true);
            $( ".d2c_post_add" ).prop('disabled', true);
            $( ".d2c_post_minus" ).prop('disabled', true);
        }

        calculate();
        allCeckboxes();
    });

    $(document).on('click', '.employee_account_input', function(){
        if($(this).is(':checked')) {
            $( ".employee_account_qty" ).prop('disabled', false);
            $( ".employee_account_add" ).prop('disabled', false);
            $( ".employee_account_minus" ).prop('disabled', false);
        }else{
            $( ".employee_account_qty" ).prop('disabled', true);
            $( ".employee_account_add" ).prop('disabled', true);
            $( ".employee_account_minus" ).prop('disabled', true);
        }

        calculate();
        allCeckboxes();
    });

    $(document).on('click', '#fetaure_row_customised_wishing', function(){
        calculate();
        allCeckboxes();
    });

    /* Calculate Total Price */
    function calculate() {
        /*sale price*/
        var openlink_api_sale_price = parseInt($('.openlink_api_sale_price').text());
        var share_rewards_sale_price = parseInt($('.share_rewards_sale_price').text());
        var instant_rewards_sale_price = parseInt($('.instant_rewards_sale_price').text());
        var employee_account_sale_price = parseInt($('.employee_account_sale_price').text());
        var d2c_post_sale_price = parseInt($('.d2c_post_sale_price').text());
        var customised_wishing_sale_price = parseInt($('.customised_wishing_sale_price').text());

        /*actual price*/
        var openlink_api_price = parseInt($('.openlink_api_price').val());
        var share_rewards_price = parseInt($('.share_rewards_price').val());
        var instant_rewards_price = parseInt($('.instant_rewards_price').val());
        var employee_account_price = parseInt($('.employee_account_price').val());
        var d2c_post_price = parseInt($('.d2c_post_price').val());
        var customised_wishing_price = parseInt($('.customised_wishing_price').val());

        var total_amount = 0;
        var actual_amount = 0;
        var monthly_price = 0;
        var added_discount_amount = 0;
        /*is checked*/
        if($('.openlink_api_input').is(':checked')) {
            // console.log('checked');
            actual_amount = parseInt(openlink_api_price) + actual_amount;
            total_amount = parseInt(openlink_api_sale_price) + total_amount;
            added_discount_amount = parseInt(added_discount_amount) + (parseInt(openlink_api_price) - parseInt(openlink_api_sale_price));
        }
        if($('.share_rewards_input').is(':checked')) {
            actual_amount = parseInt(share_rewards_price) + actual_amount;
            total_amount = parseInt(share_rewards_sale_price) + total_amount;
            added_discount_amount = parseInt(added_discount_amount) + (parseInt(share_rewards_price) - parseInt(share_rewards_sale_price));
        }
        if($('.instant_rewards_input').is(':checked')) {
            actual_amount = parseInt(instant_rewards_price) + actual_amount;
            total_amount = parseInt(instant_rewards_sale_price) + total_amount;
            added_discount_amount = parseInt(added_discount_amount) + (parseInt(instant_rewards_price) - parseInt(instant_rewards_sale_price));
        }
        if($('.employee_account_input').is(':checked')) {
            actual_amount = parseInt(employee_account_price) + actual_amount;
            total_amount = parseInt(employee_account_sale_price) + total_amount;
            added_discount_amount = parseInt(added_discount_amount) + (parseInt(employee_account_price) - parseInt(employee_account_sale_price));
        }
        if($('.d2c_post_input').is(':checked')) {
            actual_amount = parseInt(d2c_post_price) + actual_amount;
            total_amount = parseInt(d2c_post_sale_price) + total_amount;
            added_discount_amount = parseInt(added_discount_amount) + (parseInt(d2c_post_price) - parseInt(d2c_post_sale_price));
        }
        if($('.customised_wishing_input').is(':checked')) {
            actual_amount = parseInt(customised_wishing_price) + actual_amount;
            total_amount = parseInt(customised_wishing_sale_price) + total_amount;
            added_discount_amount = parseInt(added_discount_amount) + (parseInt(customised_wishing_price) - parseInt(customised_wishing_sale_price));
        }


        
        var per25 = 0;
        var pricing_type = $('input[name="pkg_duration"]:checked').val();
        if(pricing_type == 'monthly'){monthly_price = parseInt(total_amount)/1}
        if(pricing_type == 'quarterly'){monthly_price = parseInt(total_amount)/3}
        if(pricing_type == 'half_yearly'){monthly_price = parseInt(total_amount)/6}
        if(pricing_type == 'yearly'){monthly_price = parseInt(total_amount)/12}
        var package = $('input[name="package_type"]:checked').val();
        var promocode_amount = 0;
        total_amount = total_amount.toFixed(2);
        
        $('#top_total_amount').text(total_amount);
        if(package == 'business'){
            per25 = (25*total_amount)/100;
            var promocode_amount = parseInt(total_amount - per25) / 2;
            promocode_amount = promocode_amount.toFixed(2);
            
            per25 = per25.toFixed(2);
            $('#total_amount').text(total_amount);
            $('#added_discount_amount').text(per25);
            $('#promocode_amount').text(promocode_amount);
            $('#payable_amount').text(promocode_amount);
            $('#perMonthPrice').text(Math.round(monthly_price));
        }else{
            per25 = 0;
            var promocode_amount = parseInt(total_amount - per25) / 2;
            promocode_amount = promocode_amount.toFixed(2);
            per25 = per25.toFixed(2);
            $('#total_amount').text(total_amount);
            $('#added_discount_amount').text(per25);
            $('#promocode_amount').text(promocode_amount);
            $('#payable_amount').text(promocode_amount);
            $('#perMonthPrice').text(Math.round(monthly_price));
        }

        // console.log('calculate', total_amount);
    }

    // All apps and proceedToCheckout function
    $(document).on('click', '#buyFullPackage', function() {
        console.log('buyFullPackage');

        var total_amount = parseInt($('#full_total').text());
        var added_discount_amount = parseInt($('#added_discount_amount').text());
        var promocode_amount = parseInt($('#promocode_amount').text());
        var plan_id = $('#plan_id').val();
        var plan_name = $('#plan_name').val();
        var billing_type = $('#billing_type').val();
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var employee_count = 1;
        var direct_post_count = 1;

        if(total_amount != ''){
            
            $.ajax({
                url: '{{ route('business.setPlanData') }}',
                type: "post",
                data: {
                    _token: CSRF_TOKEN,
                    total_amount: total_amount,
                    added_discount_amount: added_discount_amount,
                    promocode_amount: promocode_amount,
                    payble_price: total_amount,
                    plan_id: plan_id,
                    plan_name: plan_name,
                    billing_type: billing_type,
                    features: 'all',
                    employee_count: employee_count,
                    direct_post_count: direct_post_count
                },
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if(data.status == true){
                        window.location.href = "{{ route('business.make_payment', $getways->id) }}";
                    }else{
                        Sweet('error','Please try again.');
                    }
                }
            });
        }
        
    });

    // select apps and proceedToCheckout function
    $(document).on('click', '#proceedToCheckout', function() {
        // console.log('proceedToCheckout');
        var package = $('input[name="package_type"]:checked').val();
        var total_amount = $('#total_amount').text();
        var added_discount_amount = $('#added_discount_amount').text();
        var promocode_amount = $('#promocode_amount').text();
        var payable_amount = $('#payable_amount').text();
        var plan_id = $('#plan_id').val();
        var plan_name = $('#plan_name').val();
        var billing_type = $('#billing_type').val();
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        // return false;
        
        var ids = '';
        ids = $('#social_media_feature_id').val();
        // console.log('first', ids);
        ids += ',' + $('#make_share_feature_id').val();
        
        if($('.openlink_api_input').is(':checked')) {
            ids += ',' + $('#openlink_api_feature_id').val();
        }
        if($('.share_rewards_input').is(':checked')) {
            ids += ',' + $('#share_rewards_feature_id').val();
        }
        if($('.instant_rewards_input').is(':checked')) {
            ids += ',' + $('#instant_rewards_feature_id').val();
        }
        if($('.employee_account_input').is(':checked')) {
            ids += ',' + $('#employee_account_feature_id').val();
        }
        if($('.d2c_post_input').is(':checked')) {
            ids += ',' + $('#d2c_post_feature_id').val();
        }
        if($('.customised_wishing_input').is(':checked')) {
            ids += ',' + $('#customised_wishing_feature_id').val();
        }

        if(ids == 'social_media,make_share'){
            Sweet('error','Please select Plan.');
            return false;
        }

        var direct_post_count = $('.d2c_post_qty').val();
        var employee_account = $('#employee_account_feature_id');
        var employee_count;
        if(employee_account.is(':checked')){ employee_count = $('.employee_account_qty').val(); }else{ employee_count = 0; }

        if(total_amount != ''){
            
            $.ajax({
                url: '{{ route('business.setPlanData') }}',
                type: "post",
                data: {
                    _token: CSRF_TOKEN,
                    package: package,
                    total_amount: total_amount,
                    added_discount_amount: added_discount_amount,
                    promocode_amount: promocode_amount,
                    payble_price: payable_amount,
                    plan_id: plan_id,
                    plan_name: plan_name,
                    billing_type: billing_type,
                    features: ids,
                    employee_count: employee_count,
                    direct_post_count: direct_post_count
                },
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if(data.status == true){
                        window.location.href = "{{ route('business.make_payment', $getways->id) }}";
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