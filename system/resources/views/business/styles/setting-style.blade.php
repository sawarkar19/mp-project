<style>
    
    .sb-tabs{
        position: relative;
        width: 100%;
        
        border-bottom: 1px solid #e1e7ed;
        /* border-top: 1px solid #e1e7ed; */
        border-left: 3px solid transparent;
    }
    .sb-tabs .inner{
        position: relative;
        padding: 20px 12px;
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        align-items: center
    }
    .sb-tabs .status-icon{
        width: 35px;
        text-align: left;
    }
    .sb-tabs .status-icon i{
        font-size: 1rem!important;
    }
    .sb-tabs .dirction-ico{
        width: 15px;
        text-align: right;
    }
    .sb-tabs .title_{
        width: calc(100% - 50px);
        text-align: left;
    }
    .sb-tabs .title_ h6{
        color: #38404b;
        margin-bottom: 3px;
        font-size: .9rem;
        line-height: 1.2!important;
    }
    .sb-tabs .title_ p{
        color: rgb(117, 117, 117);
        margin-bottom: 0px;
        font-size: .6rem;
        line-height: 1.2!important;
    }

    #b-setting-tab .nav-item >.nav-link{
        padding: 0px;
    }
    #b-setting-tab .nav-item >.nav-link.active > .sb-tabs{
        /* border-bottom: 1px solid #e1e7ed;
        border-top: 1px solid #e1e7ed; */
        border-left: 3px solid var(--primary);
        background-color: #f8fbff;
    }



    .step-num{
        margin-right: 15px;
        width: 48px;
    }
    .step-num p{
        font-size: 2rem;
        margin-bottom: 0px;
        line-height: 1;
        color: #d9e3f3;
    }
    .wa-div{
        position: relative;
        width: 100%;
        max-width: 280px;
        margin: auto;
    }
    .wa-qr{
        position: relative;
        width: 100%;
        height: auto;
        /*padding: 5px 0px;*/
        border: 2px solid #128C7E;
        text-align: center;
    }
    .wa-qr img{
        width: 100%;/*
        max-width: 270px;*/
    }
    .reload-qr{
        width: 100%;
        height: 100%;
        min-height: 280px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .reload-qr .circle-reload{
        display: inline;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background-color: #128C7E;
        color: #ffffff;
        text-align: center;
    }
    .reload-qr .circle-reload i{
        line-height: 80px;
    }
    #onClickReloadQR{
        cursor:pointer;
    }

    .lh-1{
        line-height: 1.5!important;
    }
    
    .default.alert-info{
        color: #0c5460;
        background-color: #f4fbfc;
        border:1px solid #99c5cc;
    }

    .facebook-bg,
    .instagram-bg,
    .twitter-bg,
    .linkedin-bg,
    .youtube-bg,
    .pintrest-bg{
        color: #ffffff;
        padding-left: 12px;
        padding-right: 12px;
    }
    .facebook-bg i,
    .instagram-bg i,
    .twitter-bg i,
    .linkedin-bg i,
    .youtube-bg i,
    .pintrest-bg i{
        font-size: 1.2rem!important;
        width: 20px;
        text-align: center;
    }
    .facebook-bg{ background-color: #4267B2!important;}
    .instagram-bg{ background-color: #E1306C!important;}
    .twitter-bg{ background-color: #00acee!important;}
    .linkedin-bg{ background-color: #0077b5!important;}
    .youtube-bg{ background-color: #FF0000!important;}
    .pintrest-bg{ background-color: #E60023!important;}

    .img-container {
        /* Never limit the container height here */
        max-width: 100%;
    }

    .img-container img {
        /* This is important */
        width: 100%;
    }
    button.google_map_btn:focus{
        outline: none !important;
        border-style: none !important;
    }

    /* busniess logo */
    .logo-wrap.crop-again{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        height: 100%;
        text-align: center;
        width: 100%;

    }
    .logo-wrap.crop-again img{
        height: 100% !important;
        width: 100%;
        object-fit: contain;
    }


    .channel_list{
        position: relative;
        width: 100%;
        /* margin-bottom: 2rem; */
    }
    .channel_list .inner{
        position: relative;
        align-items: center;
        justify-content: space-between;
        background-color: #fff;
        border-radius: 4px;
        border-bottom: 1px solid #e1e7ed;
        padding: 15px 0px;
    }

    .inner{
        border-bottom: 1px solid #e1e7ed;
    }

    
    .channel_list:last-child .inner {
        border-bottom: 0px;
    }
    @media(max-width:767px){
        .channel_list{
            margin-bottom: 1.5rem;
        }
        .channel_list .inner{
            padding: 10px 15px;
            box-shadow: 0px 2px 8px rgba(0,0,0,.05);
        }
    }

    .vw{
        position: relative;
    }
    .vw .card{
        border: 1px solid #e3e3e3;
        transition: all 300ms ease;
        background-color: #fbfbfb;
        box-shadow: none!important;
    }
    .vw .card > .card-body{
        padding: 15px !important;
    }
    .vw h6{
        margin-left: 20px;
    }
    .vw p{
        line-height: 1.5!important;
    }
    .vw .vw_input{
        /* visibility: hidden; */
        position: absolute;
        z-index: 1;
        top: 20px;
        left: 15px;
    }
    .vw .vw_input:checked + .card{
        border: 1px solid var(--primary);
        background-color: #fafcff;
    }
    .vw_page_preview{
        width: 100%;
        display: block;
        position: relative;
        padding: 5px 2px;
        text-align: center;
        font-size: .8rem;
        font-weight: 500;
        color: #556070;
        background-color: #ffffff;
        text-decoration: none;
        transition: all 300ms ease-in-out;
        border-radius: 3px 3px 0 0;
        border: 1px solid #e4e6fc;
        border-bottom: none!important;
        line-height: 1.5;
    }
    .vw_page_preview:hover{
        text-decoration: none;
        color: #303439;
        background-color: #e6eef9;
    }
    .imagecheck-image:hover {
        opacity: 1;
    }
    .imagecheck .selectable-name:after {
        content: '';
        position: absolute;
        top: 0.42rem;
        left: .25rem;
        display: block;
        width: 1rem;
        height: 1rem;
        pointer-events: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        background: var(--cl-prime) url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3E%3Cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3E%3C/svg%3E") no-repeat center center/50% 50%;
        color: #fff;
        z-index: 1;
        border-radius: 3px;
        opacity: 0;
        transition: .3s opacity; 
    }
    .imagecheck-input:checked ~ .selectable-name:after {
        opacity: 1;
    }
    .imagecheck-input:checked .imagecheck-image:hover {
        opacity: 1;
    }
    
    .google-review img{
        width: 40px;
    }
    .google-review{
        padding: 0 2px !important;
    }
    #contact5 .info-btn {
        font-size: 14px;
    }

    .card.sconnect{
        position: relative;
        text-align: center;
        box-shadow: none!important;
        border: 1px solid rgba(0, 0, 0, .3);
        border-radius: 6px;
        height: 100%;
        margin-bottom: 0px;
    }
    .card.sconnect .card-body{
        padding-left: 10px;
        padding-right: 10px;
    }
    .sconnect .sc-icon i{
        font-size: 2.2rem;
    }
    .card.sconnect .connected,
    .card.sconnect .new_connect,
    .card.sconnect .re_connect{
        position: relative;
        padding: 10px;
        border-radius: 0 0 6px 6px;
    }
    .card.sconnect .connected{
        background-color: #d4edda;
        color: #155724;

        pointer-events: none;
    }
    .card.sconnect .new_connect{
        background-color: #cce5ff;
        color: #004085;
        cursor: pointer;
    }
    .card.sconnect .re_connect{
        background-color: #fff3cd;
        color: #856404;
        cursor: pointer;
    }

    .card.sconnect .connected-icon,
    .card.sconnect .disconnected-icon{
        position: absolute;
        font-size: 1.2rem;
        top: 6px;
        left: 6px;
    }
    .card.sconnect .connected-icon{
        color: var(--success);
    }
    .card.sconnect .disconnected-icon{
        color: var(--danger);
    }

    .card.sconnect .update-icon{
        position: absolute;
        font-size: 1rem;
        top: 6px;
        right: 6px;
        cursor: pointer;
    }
    .sconnect .a_disable{
        cursor: no-drop !important;
        background: #bdc0c4 !important;
        color: #a2a2a2 !important;
    }
    .facebook-modal .modal-dialog-centered::before {
        height: auto !important;
    }
    .step-icon i{
        font-size: 23px;
        position: relative;
        top: 4px;
    }
    .social-steps.accordion .accordion-item{
        background: #fff;
    }
    .social-steps.accordion .accordion-header{
        background-color: transparent;
        box-shadow: none;
        position: relative;
        color: #3f729b;
    }   
    .underline-text{
        max-width: 150px;
        border-bottom: 2px solid #FAD8AB;
        margin: auto;
    } 
    .social-post-setps .accordion .accordion-header[aria-expanded="true"] .fa-angle-down:before {
        content: "\f106";
    }
    .steps-lineHeight p{
        line-height: 22px;
    }
    .gift_item .badge {
        line-height: 0;
    }
    .delete_badge {
        padding: 10px 8px;
        font-size: 10px;
        margin-left: 6px;
        cursor: pointer;
    }
    .vcard_redirect{
        font-size: 11px;
        line-height: 15px;
        margin-top: 10px;
    }
    .pop-icon{
        border: none;
        background: none;
    }
    .pop-icon:focus{
        outline: none;
    }

    /* .connect-pop .fa-link{
        transform: rotate(45deg);
        font-size: 23px;
    } */
    .connect-pop .fab{
        background: #4d4a4a;
        color: #fff;
        font-size: 15px;
        border-radius: 50%;
        padding: 6px;
    }
    .arrow.dark::after{
        border-bottom-color: var(--dark);
    }

</style>