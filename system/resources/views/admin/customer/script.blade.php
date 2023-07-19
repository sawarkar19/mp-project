<script>
    $(document).ready(function() {
        $('.scrolly').click(function() {
            $('html, body').animate({
                scrollTop: $($(this).attr('href')).offset().top - 75
            }, 700);
            return false;
        });
        
    
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
            var pricePlans = @json($plans);
            var paidChannels = @json($paidChannels);
            var unpaidChannels = @json($unpaidChannels);
            
            var selectedPlan = $('input[name="pkg_duration"]:checked').val();
            var main_user_price = $("#main_user_price").val();
    
            $.each(pricePlans, function( index, value ) {
                if(selectedPlan == value.slug){
                    $(".employee_price").text(main_user_price * value.months);
                    $("#per_user_price").val(main_user_price * value.months);
    
                    $.each(paidChannels, function( indexpChannel, valuepChannel ) {
                        var renew_channel_price = $('input[name="renew_channel_price_'+valuepChannel.id+'"]').val();
                        var newPChannelPrice = parseInt(renew_channel_price) * parseInt(value.months);
                        $("#paidChannel"+valuepChannel.id).text(newPChannelPrice);
                        // console.log(valuepChannel);
                    });
    
                    $.each(unpaidChannels, function( indexunpChannel, valueunpChannel ) {
                        var buy_channel_price = $('input[name="buy_channel_price_'+valueunpChannel.id+'"]').val();
                        var newUnPChannelPrice = parseInt(buy_channel_price) * parseInt(value.months);
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
            $("#userTotalPrice").text(parseInt(qty * per_user_price));
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
        
    
        /* Calculate Final Amount */
        function calculate_final_amount(){
            var total = channelRenew = channelBuy = userTotal = messageTotal = 0;
            // console.log('Calculate');
    
    
            /* User Purchase */
            var employee_price = $("#per_user_price").val();
            $('input[name="user_checkbox[]"]:checkbox:checked').each(function(i){
                userTotal = parseInt(userTotal) + parseInt(employee_price);
            });
    
            var userCount = $("#user_count").val();
            if(userCount != ''){
                var totalPrice = parseInt(employee_price) * parseInt(userCount);
                userTotal = userTotal + totalPrice;
            }
            $("#usersPrice").text(userTotal);
    
    
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
                channelRenew = parseInt(channelRenew) + parseInt(price);
            });
            $("#paidChannelPrice").text(channelRenew);
            
    
    
            /* Add Channel */
            $('.buy-channel:checkbox:checked').each(function(i){
                // console.log($(this).attr('id'));
                var checkboxId = $(this).attr('id');
                var split = checkboxId.split('_');
                var channel_id = split[1];
                var price = $("#unpaidChannel"+channel_id).text();
                channelBuy = parseInt(channelBuy) + parseInt(price);
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
            $("#cartTotal").text(total);
    
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
            var cart = $("#cartTable").empty();
            var paymentTable = $("#paymentTable").empty();
    
            var total = $("#cartTotal").text();
            var coupon_type = $('input[name="coupon_type"]').val();
            var coupon_discount = $('input[name="coupon_discount"]').val();
    
            cart.append('<tr class="bg-light"><th>Title</th><th>Qty</th><th>Type</th><th class="text-right">Amount</th><th class="text-right">Action</th></tr>');
    
            ///////////Add items to cart
    
            //users
            var employee_price = $("#per_user_price").val();
            var userCount = $("#user_count").val();
            if(userCount != ''){
                var usersPrice = parseInt(employee_price * userCount);
                
                cart.append('<tr class="cart-item removeUserPlan"><td>User</td><td>('+userCount+')</td><td width="80"><h6 class="mb-0"><span class="badge badge-success">Buy</span></h6></td><td class="text-right pl-0 pr-2" width="100"><span>&#8377;</span> <span>'+usersPrice+'</span></td><td><button id="removeUserPlan" class="btn btn-danger remove-btn">Remove</button></td></tr>');
    
                $('input[name="buy_users"]').val(userCount);
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
                paymentTable.append('<tr><td>Promocode Discount ('+discount_type+')</td><td width="100" class="pl-0 pr-2 text-success"> - <span>&#8377;</span> <span id="discountAmount">'+discount_value+'</span></td></tr>');

                $('input[name="promocode_amount"]').val(discount_value);
            }
    
            paymentTable.append('<tr><td class="">Payable Amount</td><td class="pl-0 pr-2"><h6 class="mb-0"><span>&#8377;</span> <span id="payableAmount">'+total+'</span></h6></td></tr>');           
            
            $('input[name="payble_price"]').val(total);
            
        }
    
        /* Cart Actions */
        $(document).on('click', '.remove-btn', function(){
            var row_id = $(this).attr("id");
            $("."+row_id).remove();
    
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
    
                $("#checkbox_"+channel_id).prop("checked", false);
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
                url: '{{ route('admin.getCouponCode') }}',
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