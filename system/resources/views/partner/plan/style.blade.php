<style>
    .buy-renew{
        position: relative;
    }
    .plan_duration_sticky_top{
        width: 100%;
        position: sticky;
        top: 0;
        z-index: 5;
        
    }
    
    .pricing-nav{
        width: 100%;
        background-color: #FFFFFF;
        /* box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1); */
        z-index: 1;
        position: relative;
    }
    .pricing-nav .pnav-inner{
        padding: 15px 0;
    }
    .flex-nav{
        position: relative;
        display: flex;
        flex-direction: row;
        justify-content:center;
        align-items: center;
    }
    .pt-check-box{
        position: relative;
        margin-top: 5px;
        line-height: 1;
    }
    .pt-check-box .custom-switch-input{
        display: none;
    }
    .pt-check-box .custom-switch-input:checked + label{
        background: var(--primary);
        border: 1px solid var(--primary);
        opacity: 1;
    }
    .pt-check-box .custom-switch-input:checked + label::before{
        content: "";
        background: white;
        height: 15px;
        width: 3px;
        position: absolute;
        top: 20%;
        left: 55%;
        transform: rotate(45deg);
        border-radius: 5px;
        transition: all 300ms ease-in-out;
    }
    .pt-check-box .custom-switch-input:checked + label::after{
        content: "";
        background: white;
        height: 8px;
        width: 3px;
        position: absolute;
        top: 42%;
        left: 24.5%;
        transform: rotate(-45deg);
        border-radius: 5px;
        transition: all 300ms ease-in-out;
    }
    .pt-check-box label{
        position: relative;
        height: 26px;
        width: 26px;
        border-radius: 100px;
        background: rgba(200, 200, 200, 1);
        overflow: hidden;
        opacity: 1;
        cursor: pointer;
        transition: all 300ms ease-in-out;
    }
    .pt-check-box label::before{
        content: "";
        position: absolute;
        top: -100%;
        left: 100%;
    }
    .pt-check-box label::after{
        content: "";
        position: absolute;
        top: -100%;
        left: -100%;
    }
    .price-duration-box{
        position: relative;
        text-align: center;
        padding: 0px 10px;
    }
    .price-duration-box .heads{
        font-family: var(--font-h1);
        font-size: 11px;
        text-transform: capitalize;
        font-weight: 400;
        line-height: 1;
        cursor: pointer;
        position: relative;
        top: 0px;
    }
    .pt-check-box{
        text-align: initial;
        width: 86px;
        display: block;
        cursor: pointer;
        margin-top: 0px;
    }
    .pt-check-box .badge-save{
        position: absolute;
        display: inline-block;
        min-width: 70px;
        background-color: #fa0000;
        color: #FFF;
        padding: 2px 5px;
        top:  calc(50% - 1px);
        transform: translateY(-50%);
        font-size: 11px;
        left: 13px;
        border-radius: 0 40px 40px 0;
        z-index: -1;
        font-family: var(--font-h1);
        text-align: right;
        transition: all 300ms ease;
    }
    .price-duration-box label{
        margin-bottom: 0px;
    }


    /* List Featurs  */
    .feature_row{
        position: relative;
    }
    .feature_row .inner{
        padding: 15px;
    }
    .feature_flex{
        position: relative;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        /* align-items: center; */
    }
    .feature_flex .f-col{
        width: auto;
    }
    .feature_flex .ftr_flx_check{
        width: 60px;
        min-width: 60px;
        display: inline-block;
    }
    .feature_flex .ftr_flx_title{
        max-width: 500px;
        display: block;
    }
    .ftr_flx_title h6{
        cursor: pointer;
    }


    /*.feature_row:nth-child(odd){
        background-color: #fff;
    }
    .feature_row:nth-child(even){
        background-color: #f5f5f5;
    }*/





    .item-qty {
        background: #EAEAEA;
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        border-radius: 4px;
    }
    .item-qty .qty-count--minus {
        border-top: 1px solid #e2e2e2;
    }
    .item-qty .qty-count {
        padding: 3px 0;
        cursor: pointer;
        width: 1.3rem;
        font-size: 1.25em;
        text-indent: -100px;
        overflow: hidden;
        position: relative;
        text-align: center;
        margin: auto;
        outline: none!important;
    }
    .item-qty .product-qty {
        width: 30px;
        min-width: 0;
        display: inline-block;
        text-align: center;
        -webkit-appearance: textfield;
        -moz-appearance: textfield;
        appearance: textfield;
        outline: none!important;
        text-align: center;
    }
    .item-qty .product-qty, .item-qty .qty-count {
        background: transparent;
        color: #000;
        /* font-weight: bold; */
        font-size: 14px;
        border: none;
        display: inline-block;
        min-width: 0;
        line-height: .7;
    }
    .item-qty .qty-count:before, .item-qty .qty-count:after {
        content: "";
        height: 1px;
        width: 6px;
        position: absolute;
        display: block;
        background: #000;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
    }
    .item-qty .qty-count--add:after {
        transform: rotate(90deg);
    }
    .item-qty .qty-count--add {
        border-bottom: 1px solid #e2e2e2;
    }


    .font_90{
        font-size: 90%!important;
    }
    .lh-normal{
        line-height: 1.5!important;
    }
    .c-dul{
        opacity: 0.7;
    }

    .custom-control-label::before,
    .custom-control-label::after{
        top: .15rem;
    }
    .card .card-header, .card .card-body, .card .card-footer{
        padding: 15px 15px;
    }
    .table:not(.table-sm):not(.table-md):not(.dataTable) td,
    .table:not(.table-sm):not(.table-md):not(.dataTable) th{
        height:45px;
    }
    .input-group-sm .form-control{
        height: 35px!important;
    }
    .bg_off_white_recharge:nth-child(even){
        background-color: #f5f5f5;
    }
    .price-top{
        background-color: #edf6ff!important;
        position: sticky;
        top: 76px;
        z-index: 5;
    }

    .custom-control-input:checked ~ .custom-control-label.default-checkbox::before{
        background-color: #adadad !important;
    }

    .reduce_opacity{
        background-color: #f2f2f2;
        opacity: 0.5;
    }

    .disable_plan{
        pointer-events: none;
        background-color: #f2f2f2;
        opacity: 0.5;
    }
    /*tm edit*/
    .add_user{
        border: 1px solid #e3f6fa;
        border-radius: 4px;
        background: #fff;
        box-shadow: 1px 1px 2px #e8e8e8;
    }
    .total_user{
        border: 1px solid #dcf6ff;
        background: #fff;
        box-shadow: 1px 1px 2px #ebebeb;
        border-radius: 4px;
    }
    .add_message_modal .modal-dialog{
        width: 1120px;
        max-width: 100%;
    }
   .add_message_modal .modal-dialog .card{
        background-color: #f7f7f7;
    }
    .radio_button_msg{
        visibility: hidden;
        position: absolute;
        top: 0;
        left: 0;
    }
      .options{
        /* height: 100%; */
        position: relative;
    }
    .options .radio_label{
        height: 100%;
        width: 100%;
        position: relative;
    }
    .options input:checked + .radio_label .card{
        border: 1px solid #006ba2;
        background: #F0F5F7;
    } 
    /*tm edit end*/
    @media(min-width:768px){
        .pt-check-box .custom-switch-input:checked ~ .badge-save{
            background-color: #08ec0b;
            padding: 5px;
        }
    }
    @media(max-width:991px){
        .flex-nav .package-duration-cell{
            width: 100%;
            max-width: 424px;
        }
    }
    @media(max-width:767px){
        .flex-nav{
            flex-wrap: wrap;
        }
        .scroll-btns{
            margin-bottom: 15px;
        }
        .scroll-btns a{
            line-height: 18px;
        }
        .price-duration-box{
            padding:0px 5px;
        }
        .pt-check-box{
            width: 65px;
            text-align: center;
        }
        .pt-check-box .badge-save{
            color: red;
            background-color: transparent;
            padding: 0px;
            /* bottom: 100%; */
            left: 50%;
            top: calc(100% + 19px);
            min-width: 55px;
            text-align: center;
            transform: translateX(-50%);
        }
        .pt-check-box .custom-switch-input:checked ~ .badge-save{
            color: #15c539;
            font-weight: 600;
        }
        .price-top{
            top: 0px;
        }
        
    }

    @media(max-width:575px){
        .feature_flex{
            flex-direction: column;
        }
        .feature_flex .f-col{
            width: 100%;
        }
    }
</style>