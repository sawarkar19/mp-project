<script>
    $(document).ready(function() {
        // Check Calculation On Page Load 
        calculate_final_amount();

        var planDataArr = @json($planDataArr);
        if(planDataArr.payment_token_id){
            if(planDataArr.plan_id == 2){
                var selectedPlan = 'monthly';
                $("#in_id_monthly").prop("checked", true);
            }else if(planDataArr.plan_id == 5){
                var selectedPlan = 'yearly';
                $("#in_id_yearly").prop("checked", true);
            }

            var pricePlans = @json($plans);
            var paidChannels = @json($paidChannels);
            var unpaidChannels = @json($unpaidChannels);
             
            var main_user_price = $("#main_user_price").val();
    
            $.each(pricePlans, function( index, value ) {
                if(selectedPlan == value.slug){
                    /* Employee Price Change */
                    var employee_price = main_user_price * value.months;
                    if(value.discount > '0'){
                        employee_price = employee_price - ((parseInt(value.discount) / 100) * employee_price);
                        // employee_price = Math.round(employee_price);
                    }                
                    $(".employee_price").text(employee_price);
                    $("#per_user_price").val(employee_price);
                
                    // console.log(value);
                    $.each(paidChannels, function( indexpChannel, valuepChannel ) {
                        var renew_channel_price = $('input[name="renew_channel_price_'+valuepChannel.id+'"]').val();
                        var newPChannelPrice = parseInt(renew_channel_price) * parseInt(value.months);

                        if(value.discount > '0'){
                            newPChannelPrice = newPChannelPrice - ((parseInt(value.discount) / 100) * newPChannelPrice);
                            newPChannelPrice = Math.round(newPChannelPrice);
                        }
                        
                        $("#paidChannel"+valuepChannel.id).text(newPChannelPrice);
                        // console.log(valuepChannel);
                    });
    
                    $.each(unpaidChannels, function( indexunpChannel, valueunpChannel ) {
                        var buy_channel_price = $('input[name="buy_channel_price_'+valueunpChannel.id+'"]').val();
                        var newUnPChannelPrice = parseInt(buy_channel_price) * parseInt(value.months);
                        if(value.discount > '0'){
                            newUnPChannelPrice = newUnPChannelPrice - ((parseInt(value.discount) / 100) * newUnPChannelPrice);
                            newUnPChannelPrice = Math.round(newUnPChannelPrice);
                        }
                        
                        $("#unpaidChannel"+valueunpChannel.id).text(newUnPChannelPrice);
                        // console.log(valueunpChannel);
                    });
                }
                
            });

            updatePlanData();
        }
        

        function updatePlanData(){
            var planDataArr = @json($planDataArr);
            if(planDataArr.payment_token_id){

                /* Buy Message Plan */
                if(planDataArr.message_plan_id != null){
                    $("#message_plan_selected").val(planDataArr.message_plan_id );
                    $('input[name="message_plan_id"]').val(planDataArr.message_plan_id );
                }
                
                /* Buy Channel */
                if(planDataArr.buy_channels != null){
                    var buyChannelArray = planDataArr.buy_channels.split(",");
                    for(i = 0; i < buyChannelArray.length; i++){
                        $("#checkbox_"+buyChannelArray[i]).click();
                    }
                }
                
                /* Renew Channel */
                if(planDataArr.renew_channels != null){
                    var renewChannelArray = planDataArr.renew_channels.split(",");
                    for(i = 0; i < renewChannelArray.length; i++){
                        $("#checkbox_"+renewChannelArray[i]).click();
                    }
                }

                /* Renew User */
                if(planDataArr.renew_users != null){
                    var renewUsersArray = planDataArr.renew_users.split(",");
                    for(i = 0; i < renewUsersArray.length; i++){
                        $("#userCheckbox_"+renewUsersArray[i]).click();
                    }
                }

                /* Buy User */
                if(planDataArr.buy_users != null){
                    $("#user_count").val(planDataArr.buy_users);
                }

                calculate_final_amount();

            }
            // console.log(planDataArr);
        }

        /* Check for old cart data */
        checkCartCookie();

        $('.scrolly').click(function() {
            if ($(window).width() > 575) {
                $('html, body').animate({
                    scrollTop: $($(this).attr('href')).offset().top - 75
                }, 700);
                return false;
                } else {
                    $('html, body').animate({
                        scrollTop: $($(this).attr('href')).offset().top - 110
                    }, 700);
                    return false;
                }
            // $('html, body').animate({
            //     scrollTop: $($(this).attr('href')).offset().top - 75
            // }, 700);
            // return false;
        });

        /* Store cookie */
        function setCookie(cname, cvalue, exdays) {
            const d = new Date();
            d.setTime(d.getTime() + (exdays*24*60*60*1000));
            let expires = "expires="+ d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }

        function checkCartCookie(){
            var user_id = {{ auth()->user()->id }};


            
            setCookie("cart-data-"+user_id, 'okok', 365);

            var old_customer = false;
            var customer_uuid = '';
            var allCookiesArray = document.cookie.split(';');
            for (var i = 0; i < allCookiesArray.length; i++ ){
                var singleCookie = allCookiesArray[i].split('=');

                // console.log(singleCookie);
                
                if(singleCookie[0].trim() == 'cart-data-'+user_id){
                    // console.log('Found it');
                    customer_uuid = singleCookie[1];
                    old_customer = true;
                }
            }

            if(old_customer == false){
                //
            }else{
                console.log('Update Cart');
            }
        }
        
    
        //////////////Update Price
        $(document).on("click", "#openAddUser", function(e){
            var selectedPlan = $('input[name="pkg_duration"]:checked').val();
            let userPlanPrice = $("#per_user_price").val();
            
            $("#modalAmtUserPer").html("&#8377;"+userPlanPrice);
            $("#modalPerUserAmt").html("Per User (&#8377;"+userPlanPrice+"/-)");

            var qty = $('input[name="product-qty"]').val();
            $('#modalCountUser').text(qty);
            calculate_user_total(qty);
        });
    
        $(document).on('change', 'input[name="pkg_duration"]', function(){
            // Check Msg plan selected or not
            var msgPlanSelectedId = $("input[name=message_plan_id]").val();
            if(msgPlanSelectedId==""){
                $("input[name=message_plan_selected]").val('');
            }

            var pricePlans = @json($plans);
            var paidChannels = @json($paidChannels);
            var unpaidChannels = @json($unpaidChannels);
            
            var selectedPlan = $('input[name="pkg_duration"]:checked').val();
            var main_user_price = $("#main_user_price").val();
    
            $.each(pricePlans, function( index, value ) {
                if(selectedPlan == value.slug){
                    /* Employee Price Change */
                    var employee_price = main_user_price * value.months;
                    if(value.discount > '0'){
                        employee_price = employee_price - ((parseInt(value.discount) / 100) * employee_price);
                        // employee_price = Math.round(employee_price);
                    }                
                    $(".employee_price").text(employee_price);
                    $("#per_user_price").val(employee_price);

                    // $(".employee_price").text(main_user_price * value.months);
                    // $("#per_user_price").val(main_user_price * value.months);
                
                    // console.log(value);
                    $.each(paidChannels, function( indexpChannel, valuepChannel ) {
                        var renew_channel_price = $('input[name="renew_channel_price_'+valuepChannel.id+'"]').val();
                        var newPChannelPrice = parseInt(renew_channel_price) * parseInt(value.months);

                        if(value.discount > '0'){
                            newPChannelPrice = newPChannelPrice - ((parseInt(value.discount) / 100) * newPChannelPrice);
                            newPChannelPrice = Math.round(newPChannelPrice);
                        }
                        
                        $("#paidChannel"+valuepChannel.id).text(newPChannelPrice);
                        // console.log(valuepChannel);
                    });
    
                    $.each(unpaidChannels, function( indexunpChannel, valueunpChannel ) {
                        var buy_channel_price = $('input[name="buy_channel_price_'+valueunpChannel.id+'"]').val();
                        var newUnPChannelPrice = parseInt(buy_channel_price) * parseInt(value.months);
                        if(value.discount > '0'){
                            newUnPChannelPrice = newUnPChannelPrice - ((parseInt(value.discount) / 100) * newUnPChannelPrice);
                            newUnPChannelPrice = Math.round(newUnPChannelPrice);
                        }
                        
                        $("#unpaidChannel"+valueunpChannel.id).text(newUnPChannelPrice);
                        // console.log(valueunpChannel);
                    });
                }
                
                calculate_final_amount();
                // console.log(value);
            });
        });
    
    
        ///////////Renew Channel
        $('.renew-channel').click(function() {
            var setting = @json($setting);
            if(setting.value == 'group'){
                // console.log($('.renew-channel').is(':checked'));
                if($(this).is(':checked')){
                    $('.renew-channel').prop("checked", true);
                }else{
                    $('.renew-channel').prop("checked", false);
                }
            }
            
            calculate_final_amount();
        });
    
        ////////////Buy Channel
        $('.buy-channel').click(function() {

            var setting = @json($setting);
            if(setting.value == 'group'){
                // console.log($('.buy-channel').is(':checked'));
                if($(this).is(':checked')){
                    $('.buy-channel').prop("checked", true);
                }else{
                    $('.buy-channel').prop("checked", false);
                }
            }
            calculate_final_amount();
        });
        
    
    
        ////////////Message plan
        $('.options').click(function() {
            var message_plan_id = $(this).attr("id");
            $("#message_plan_selected").val(message_plan_id);
        });
    
        $("body").delegate("#selectMessagePlan", "click", function(){
            var message_plan_id = $("#message_plan_selected").val();
            
            if(!message_plan_id){
                Sweet("error", "Please select a message plan.");
                return false;
            }
    
            $("#message_plan_id").val(message_plan_id);
            $('#Message_Modal').modal('toggle');
            calculate_final_amount();
        });
    
        $('#Message_Modal').on('show.bs.modal', function () {
            var message_plan_id = $("#message_plan_id").val();
    
            $('.radio_button_msg').prop("checked", false);
            // console.log(message_plan_id);
            if(message_plan_id){
                $('#pack_'+message_plan_id).prop("checked", true);
            }        
        });
    
        /////////////User plan
        $(document).on('click', '.qty-count--add', function(){
            var qty = $('input[name="product-qty"]').val();

            qty = parseInt(qty) + 1;
            $('input[name="product-qty"]').val(qty);
            $('#modalCountUser').text(qty);
            calculate_user_total(qty);
        });
    
        $(document).on('click', '.qty-count--minus', function(){
            var qty = $('input[name="product-qty"]').val();
            
            if(parseInt(qty) == 1){
                return false;
            }
    
            if(parseInt(qty) > 1){
                qty = parseInt(qty) - 1;
            }
    
            $('input[name="product-qty"]').val(qty);
            $('#modalCountUser').text(qty);
            calculate_user_total(qty);
        });
    
        function calculate_user_total(qty){
            var per_user_price = $("#per_user_price").val();
            // $("#userTotalPrice").text(parseInt(qty * per_user_price));
            var userTotal = qty * per_user_price;
            userTotal = userTotal.toFixed(2);
            userTotal = parseFloat(userTotal);
            $("#userTotalPrice").text(userTotal);
        }
    
        $("body").delegate("#selectUserPlan", "click", function(){
            var usersPrice = $("#userTotalPrice").text();
            var userCount = $('input[name="product-qty"]').val();
    
            if(!usersPrice){
                Sweet("error", "Please select a user.");
                return false;
            }
            $('#userModal').modal('toggle');
            $("#user_count").val(userCount);
    
            calculate_final_amount();
        });
    
    
        $(document).on('click', '.user-checkbox', function(){
            calculate_final_amount();
        });
    
        $('#userModal').on('hidden.bs.modal', function () {
            var userCount = $("#user_count").val();
            // console.log(userCount);
            if(userCount){
                $('input[name="product-qty"]').val(userCount);
            }else{
                $('input[name="product-qty"]').val(1);
            }
            
        });
    
    
    
        /////////////View Cart
        $(document).on('click', '.view_cart_detail', function(e){
            e.preventDefault();
            if($("#cartTable tr").hasClass('cart-item')){
                $("#viewCart").trigger("click");
            }else{
                Sweet("error", "Please add item to Cart");    
                return false;
            }
            
        });

        function btnDisableAddRemoveUser(){
            var userCount = $("#user_count").val();
            if(userCount > '0'){
                $("#openRemoveUsers").prop("disabled", false);
                $("#openRemoveUsers").css({"display":"inline"});
            }
            else{
                $("#openRemoveUsers").prop("disabled", true);
                $("#openRemoveUsers").css({"display":"none"});
            }
        }

        $(document).on('click', '#openRemoveUsers', function(){
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to remove Users!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes Delete'
            }).then((result) => {
                if (result.value) {
                    var usersPrice = $("#userTotalPrice").text();
                    var userCount = 0;
                    if(!usersPrice){
                        Sweet("error", "Please select a user.");
                        return false;
                    }
                    $("#user_count").val(userCount);
                    calculate_final_amount();
                }
            });
        });
        
    
        /* Calculate Final Amount */
        function calculate_final_amount(){
            var total = channelRenew = channelBuy = userTotal = messageTotal = 0;
            // console.log('Calculate');
    
    
            /* User Purchase */
            var employee_price = $("#per_user_price").val();
            $('input[name="user_checkbox[]"]:checkbox:checked').each(function(i){
                // userTotal = parseInt(userTotal) + parseInt(employee_price);
                userTotal = parseFloat(userTotal) + parseFloat(employee_price);
            });
    
            var userCount = $("#user_count").val();
            if(userCount != ''){
                // var totalPrice = parseInt(employee_price) * parseInt(userCount);
                var totalPrice = (employee_price) * parseInt(userCount);
                userTotal = userTotal + totalPrice;
            }
            userTotal = userTotal.toFixed(2);
            userTotal = parseFloat(userTotal);
            $("#usersPrice").text(userTotal);
            if(userCount > 0){
                $("#usersPriceUser").text("[No of Users "+userCount+"]");
            }
            else{
                $("#usersPriceUser").text("");
            }
            btnDisableAddRemoveUser();
    
            /* Message Purchase */
            var message_plan_id = $("#message_plan_selected").val();
            if(message_plan_id != ''){
                var message_plan_price = $("#messagePlanPrice"+message_plan_id).text();
                $("#messagePrice").text(message_plan_price);
                messageTotal = parseInt(messageTotal) + parseInt(message_plan_price);
            }
    
    
            /* Renew Channel */
            $('.renew-channel:checkbox:checked').each(function(i){
                // console.log($(this).attr('id'));
                var checkboxId = $(this).attr('id');
                var split = checkboxId.split('_');
                var channel_id = split[1];
                var price = $("#paidChannel"+channel_id).text();
                if(price != ''){
                    // channelRenew = parseInt(channelRenew) + parseInt(price);
                    channelRenew = parseFloat(channelRenew) + parseFloat(price);
                }
                // console.log(price);
            });
            $("#paidChannelPrice").text(channelRenew);
            
    
    
            /* Add Channel */
            $('.buy-channel:checkbox:checked').each(function(i){
                // console.log($(this).attr('id'));
                var checkboxId = $(this).attr('id');
                var split = checkboxId.split('_');
                var channel_id = split[1];
                var price = $("#unpaidChannel"+channel_id).text();
                
                if(price != ''){
                    channelBuy = parseInt(channelBuy) + parseInt(price);
                }
            });
            $("#unpaidChannelPrice").text(channelBuy);
    
            total = channelRenew + channelBuy + userTotal + messageTotal;
            
            $("#total_before_discount").val(total);
    
            /* Apply Coupon Code */
            var coupon_type = $('input[name="coupon_type"]').val();
            var coupon_discount = $('input[name="coupon_discount"]').val();

            $('input[name="total_price"]').val(total);
    
            if(coupon_type != '' && coupon_discount != ''){

                $('input[name="total_price"]').val(total);

                if(coupon_type == 'percentage'){
                    total = total - (total * (coupon_discount/100));
                }
    
                if(coupon_type == 'flat_rate'){
                    total = total - coupon_discount;
                }
                 
                if(total < 0){
                    total = 0;
                }
            }
            
            if(total > 0){
                $("#proceedToPay").prop("disabled", false);
            }else{
                $("#proceedToPay").prop("disabled", true);
            }
            
            total = parseFloat(total);
            total = total.toFixed(2);
            total = parseFloat(total);
            
            $("#cartTotal").text(total);
            if(total > 0){
                $("#tot_amt_text_gst").text("( Including GST )");
            }
            else{
                $("#tot_amt_text_gst").text("");
            }
            updateCartDetail();
        }
    
    
        function updateCartDetail(){
            /* Reset Form Inputs */
            $('input[name="buy_channels"]').val('');
            $('input[name="renew_channels"]').val('');
            $('input[name="buy_users"]').val('');
            $('input[name="renew_users"]').val('');
            $('input[name="message_plan_id"]').val('');
    
            /* Empty Cart */
            var userCount = $("#user_count").val();
            
            var cart = $("#cartTable").empty();
            var paymentTable = $("#paymentTable").empty();
    
            var total = $("#cartTotal").text();
            var coupon_type = $('input[name="coupon_type"]').val();
            var coupon_discount = $('input[name="coupon_discount"]').val();
    
            cart.append('<tr class="bg-light"><th>Title</th><th>Qty</th><th>Type</th><th class="text-right">Amount</th><th class="text-right">Action</th></tr>');
    
            ///////////Add items to cart
    
            //users
            var employee_price = $("#per_user_price").val();
            
            if(userCount > 0){
                if(userCount != ''){
                    var usersPrice = parseFloat(employee_price * userCount);
                    
                    cart.append('<tr class="cart-item removeUserPlan"><td>User</td><td>('+userCount+')</td><td width="80"><h6 class="mb-0"><span class="badge badge-success">Buy</span></h6></td><td class="text-right pl-0 pr-2" width="100"><span>&#8377;</span> <span>'+usersPrice+'</span></td><td><button id="removeUserPlan" class="btn btn-danger remove-btn">Remove</button></td></tr>');
        
                    $('input[name="buy_users"]').val(userCount);
                }
            }
            else{
                cart.html('');
            }
    
            var employeeIds = '';
            $('input[name="user_checkbox[]"]:checkbox:checked').each(function(i){
                var employeeIdTxt = $(this).attr('id');
                var split_id = employeeIdTxt.split('_');
                var employee_id = split_id[1];
                var user_name = $("#user_name"+employee_id).val();
    
                cart.append('<tr class="cart-item removeRenewUser_'+employee_id+'"><td>'+user_name+'</td><td>-</td><td width="80"><h6 class="mb-0"><span class="badge badge-primary">Renew</span></h6></td><td class="text-right pl-0 pr-2" width="100"><span>&#8377;</span> <span>'+employee_price+'</span></td><td><button id="removeRenewUser_'+employee_id+'" class="btn btn-danger remove-btn">Remove</button></td></tr>');
    
                employeeIds += employee_id+',';
            });
            if(employeeIds != ''){
                employeeIds = employeeIds.replace(/,\s*$/, "");
            }
            $('input[name="renew_users"]').val(employeeIds);
            
    
            //message plan
            var message_plan_id = $("#message_plan_selected").val();
            if(message_plan_id != ''){
                var message_plan_price = $("#messagePlanPrice"+message_plan_id).text();
                
                cart.append('<tr class="cart-item removeMessagePlan"><td>Message Plan (yearly)</td><td>-</td><td width="80"><h6 class="mb-0"><span class="badge badge-primary">Buy</span></h6></td><td class="text-right pl-0 pr-2" width="100"><span>&#8377;</span> <span>'+message_plan_price+'</span></td><td><button id="removeMessagePlan" class="btn btn-danger remove-btn">Remove</button></td></tr>');
    
                $('input[name="message_plan_id"]').val(message_plan_id);
            }
    
            //Renew Channels
            var renewChannelIds = '';
            $('.renew-channel:checkbox:checked').each(function(i){
                // console.log($(this).attr('id'));
                var checkboxId = $(this).attr('id');
                var split = checkboxId.split('_');
                var renewChannel_id = split[1];
                var price = $("#paidChannel"+renewChannel_id).text();
    
                var channel_name = $("#channel_name"+renewChannel_id).text();
    
                cart.append('<tr class="cart-item removeChannel_'+renewChannel_id+'"><td>'+channel_name+'</td><td>-</td><td width="80"><h6 class="mb-0"><span class="badge badge-primary">Renew</span></h6></td><td class="text-right pl-0 pr-2" width="100"><span>&#8377;</span> <span>'+price+'</span></td><td><button id="removeChannel_'+renewChannel_id+'" class="btn btn-danger remove-btn">Remove</button></td></tr>');
    
                renewChannelIds += renewChannel_id+',';
            });
            if(renewChannelIds != ''){
                renewChannelIds = renewChannelIds.replace(/,\s*$/, "");
            }
            $('input[name="renew_channels"]').val(renewChannelIds);
    
    
            //Buy Channels
            var buyChannelIds = '';
            $('.buy-channel:checkbox:checked').each(function(i){
                // console.log($(this).attr('id'));
                var checkboxId = $(this).attr('id');
                var split = checkboxId.split('_');
                var buyChannel_id = split[1];
                var price = $("#unpaidChannel"+buyChannel_id).text();
    
                var channel_name = $("#channel_name"+buyChannel_id).text();
    
                cart.append('<tr class="cart-item removeChannel_'+buyChannel_id+'"><td>'+channel_name+'</td><td>-</td><td width="80"><h6 class="mb-0"><span class="badge badge-success">Buy</span></h6></td><td class="text-right pl-0 pr-2" width="100"><span>&#8377;</span> <span>'+price+'</span></td><td><button id="removeChannel_'+buyChannel_id+'" class="btn btn-danger remove-btn">Remove</button></td></tr>');
    
                buyChannelIds += buyChannel_id+',';
            });
            if(buyChannelIds != ''){
                buyChannelIds = buyChannelIds.replace(/,\s*$/, "");
            }
            $('input[name="buy_channels"]').val(buyChannelIds);
    
            
            /* Plan Selection */
            var selectedPlan = $('input[name="pkg_duration"]:checked').val();
            var pricePlans = @json($plans);
            $.each(pricePlans, function( index, value ) {
                if(selectedPlan == value.slug){
                    $('input[name="plan_id"]').val(value.id);
                }
            });

            ///////////Price Calulate
            if(coupon_type != '' && coupon_discount != ''){
                var total_before_discount = $("#total_before_discount").val();
                var discount_type = coupon_discount+'%';
                var discount_value = total_before_discount * (coupon_discount/100);
                
                if(coupon_type == 'flat_rate'){
                    discount_type = '&#8377;'+coupon_discount;
                    discount_value = coupon_discount;
                }

                var total_before_discount = $("#total_before_discount").val();
                total_before_discount = parseFloat(total_before_discount);
                total_before_discount = total_before_discount.toFixed(2);
                total_before_discount = parseFloat(total_before_discount);

                paymentTable.append('<tr><td>Total Amount </td><td width="100" class="pl-0 pr-2"><span>&#8377;</span> <span id="totAmountBeforDiscount">'+total_before_discount+'</span></td></tr>');

                discount_value = parseFloat(discount_value);
                discount_value = discount_value.toFixed(2);
                discount_value = parseFloat(discount_value);

                paymentTable.append('<tr><td>Promocode Discount ('+discount_type+')</td><td width="100" class="pl-0 pr-2 text-success"> - <span>&#8377;</span> <span id="discountAmount">'+discount_value+'</span></td></tr>');

                $('input[name="promocode_amount"]').val(discount_value);
            }

            var pay_msg="";
            if(total > 0){
                total = parseFloat(total);
                total = total.toFixed(2);
                total = parseFloat(total);

                pay_msg = '<p class="mb-0" style="font-size: 11px; ">( Including GST )</p>';
                paymentTable.append('<tr><td class="">Payable Amount</td><td class="pl-0 pr-2"><h6 class="mb-0"><span>&#8377;</span> <span id="payableAmount">'+total+'</span></h6>'+pay_msg+'</td></tr>');  
            }
            else{
                $("#fare_breakup").removeClass("show");
                $("#fare_breakup").addClass('hide');
            }
        
            // total modified
            /* var selectedPlan = $('input[name="pkg_duration"]:checked').val();
            if(selectedPlan == 'yearly'){
                total = parseInt(total + 1);
            } */
            
            $('input[name="payble_price"]').val(total);
            
        }
    
        /* Cart Actions */
        $(document).on('click', '.remove-btn', function(){
            var row_id = $(this).attr("id");

            var setting = @json($setting);
            var row_params = row_id.split('_');
            if(row_params[0] == 'removeChannel' && setting.value == 'group'){
                for (let i = 1; i < 6; i++) {
                    $(".removeChannel_"+i).remove();
                }
            }else{
                $("."+row_id).remove();
            }
            
            /* Users */
            if(row_id == 'removeUserPlan'){
                $("#user_count").val('');
            }
    
            if(row_id.indexOf('removeRenewUser') != -1){
                var split_id = row_id.split('_');
                var employee_id = split_id[1];
    
                $("#userCheckbox_"+employee_id).prop("checked", false);
                // console.log(employee_id+" found");
            }
    
    
            /* Message Plan */
            if(row_id == 'removeMessagePlan'){
                $("#message_plan_selected").val('');
            }
    
            /* Channels */
            if(row_id.indexOf('removeChannel') != -1){
                var split_id = row_id.split('_');
                var channel_id = split_id[1];


                if(setting.value == 'group'){
                    for (let i = 1; i < 6; i++) {
                        $("#checkbox_"+i).prop("checked", false);
                    }
                }else{
                    $("#checkbox_"+channel_id).prop("checked", false);
                }
    
                // $("#checkbox_"+channel_id).prop("checked", false);
                // console.log(employee_id+" found");
            }
    
            if(!$("#cartTable tr").hasClass('cart-item')){
                $("#viewCart").trigger("click");
            }
    
            calculate_final_amount();
        });
    
    
        /* Apply Coupon Code */
        $(document).on('click', '#applyCoupon', function(){
    
            var total = $('#cartTotal').text();
            var couponCode = $('#couponCode').val();
            var btnText = $('#applyCoupon').text();
    
            if(couponCode == '' && btnText == 'Apply'){
                Sweet('error','Please enter coupon code.');
                return false;
            }
    
            if(couponCode != '' && btnText == 'Cancel'){
                $('#couponCode').val('');
                $("#applyCoupon").text('Apply');
    
                $('input[name="coupon_type"]').val('');
                $('input[name="coupon_discount"]').val('');
                
                calculate_final_amount();
                $("#couponCode").prop("readonly", false);
                Sweet('success','Coupon removed successfully');
                return false;
            }
    
            if(parseInt(total) <= 0){
                Sweet('error','Cart total is 0.');
                return false;
            }
    
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            
            $.ajax({
                url: '{{ route('business.getCouponCode') }}',
                type: "post",
                data: {
                    _token: CSRF_TOKEN,
                    coupon: couponCode
                },
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if(data.status == true){
    
                        var user_id = {{ Auth::id() }};
                        if(data.coupon.coupon_for != 'all'){
                            if(user_id != data.coupon.user_id){
                                Sweet('error','Coupon is invalid.');
                                return false;
                            }
                        }
    
                        $('input[name="coupon_type"]').val(data.coupon.coupon_type);
                        $('input[name="coupon_discount"]').val(data.coupon.discount);
    
                        /* Calculate Payable Buy Amount */
                        calculate_final_amount();
    
                        $("#couponCode").prop("readonly", true);
                        $("#applyCoupon").text('Cancel');
    
                        Sweet('success','Coupon applied successfully');
                        
                    }else{
                        Sweet('error',data.message);
                        $("#couponCode").prop("readonly", false);
                    }
                }
            });
    
        });
    
    
    
    
        /* Proceed to pay */
        $("#subscriptionForm").on('submit', function(e){
            e.preventDefault();
    
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: this.action,
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                success: function(response){ 
                    // console.log(response);
                    if(response.status){
                        window.location.href = response.url;
                    }
                },
                error: function(xhr, status, error) 
                {
                    $.each(xhr.responseJSON.errors, function (key, item) 
                    {
                        Sweet('error',item);
                    });
                }
            })
        });
    
    });
</script>