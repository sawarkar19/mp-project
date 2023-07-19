<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
    *{
        font-family: 'Poppins', sans-serif;
    }
    .main-page{
        position: relative;
        min-height: 100vh;
        padding: 1rem 0;
        background: linear-gradient(45deg, #0062E0 -40.34%, #00FFAF 159.18%);
    }

    .card.instant-tasks{
        max-width: 440px;
        width: 100%;
        margin: auto;
        border: none;
        border-radius: .8rem;
        overflow: hidden;
        /* box-shadow: */
    }
    .instant-tasks .card-img > .offer-image{
        position: relative;
        width: 100%;
        padding-bottom: 50%;
        background-color: #F5F5F5;
        background-size: cover;
        background-position: top left;
        background-repeat: no-repeat;
        background-image: url('../images/no-preview.jpg');
        transition: all 1000ms ease;
        cursor: pointer;
    }
    /* .instant-tasks .card-img > .offer-image:hover{
        background-position: bottom right !important;
    } */

    .instant-tasks > .card-body{
        text-align: center;
    }
    .instant-tasks .card-body > .main-title{
        color: #237CD8;
        font-weight: 600;
        font-size: 1rem;
    }
    .instant-tasks .card-body > .main-text{
        font-weight: 300;
        font-size: .9rem;
    }
    .instant-tasks .card-body > .task-info{
        padding: .5rem;
        background-color: rgba(35, 124, 216, 0.05);
        border: 1px dashed rgba(0, 0, 0, 0.2);
        border-radius: .6rem;
        font-size: 80%;
    }
    .business_logo{
        height: 45px;
    }


    .instant-tasks .tasks-container{
        position: relative;
        /* background-color: rgba(35, 124, 216, 0.05); */
        background-color: rgba(0, 0, 0, 0.03);
        padding: 1rem;
        margin-bottom: 1rem;
        border-top: 1px solid rgba(0, 0, 0, 0.15);
        border-bottom: 1px solid rgba(0, 0, 0, 0.15);
    }
    .task-row{
        position: relative;
    }
    .task-row a{
        color: inherit;
        text-decoration: none!important;
    }
    .task-row:not(:last-child){
        margin-bottom: 1rem;
    }

    .card.in-task{
        border-radius: .6rem;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.08);
        margin-bottom: 0px;
        border-color: #ffffff;
    }
    .card.in-task .card-body{
        padding: .7rem;
    }
    .in-task .task-logo{
        width: 1.75rem;
        height: 1.75rem;
        margin-right: .5rem;
    }
    .in-task .task-title{
        margin-bottom: 0px;
        font-size: 1rem;
        line-height: 1;
    }
    
    .task-row .check_right{
        position: absolute;
        display: inline-block;
        width: 1.5rem;
        top: -6px;
        right: -6px;
    }

    .task-row .task-alert{
        position: relative;
        width: calc(100% - 1.8rem);
        margin: auto;
        border-radius: 0 0 .5rem .5rem;
        border-style: solid;
        border-width: 1px;
        border-top: none;
        padding: 4px 5px;
        font-size: .65rem;
        border-color: #838383;
        color: #838383;
        background-color: #dedede;
    }
    .task-row .task-alert.warning{
        border-color: var(--bs-orange);
        color: var(--bs-orange);
        background-color: rgba(var(--bs-warning-rgb), 0.1);
    }
    .task-row .task-alert.danger{
        border-color: var(--bs-danger);
        color: var(--bs-danger);
        background-color: rgba(var(--bs-danger-rgb), 0.1);
    }

    .task-row .verify,
    .task-row .failed,
    .task-row .check_right{
        display: none;
    }
    .task-row.varifying .card.in-task{
        border-color: rgba(var(--bs-warning-rgb), .5);
    }
    .task-row.unverify .card.in-task{
        border-color: rgba(var(--bs-danger-rgb), .5);
    }
    .task-row.verified .card.in-task{
        border-color: rgba(var(--bs-success-rgb), .5);
    }

    .task-row .single-tick,
    .task-row .double-tick{
        display: none;
    }


    .task-row.verifying .verify,
    .task-row.unverify .failed,
    .task-row.verified .check_right{
        display: block!important;
    }

    .task-row.verifying .single-tick,
    .task-row.verified .double-tick{
        display: inline-block!important;
    }

    .task-row .disabled{
        opacity: .6!important;
        cursor: not-allowed!important;
    }
    .task-row .disabled > .card.in-task{
        box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.05);
    }

    .spin{
        animation: spin 3000ms linear infinite;
        -webkit-animation: spin 3000ms linear infinite;
    }
    @keyframes spin {
        from {transform:rotate(0deg);}
        to {transform:rotate(360deg);}
    }
    @-webkit-keyframes spin {
        from {transform:rotate(0deg);}
        to {transform:rotate(360deg);}
    }

    .small-links {
        font-size: 12px;
        text-decoration: underline;
        color: inherit;
    }

    /* Modal  */
    .task-modal .modal-fullscreen{
        width: calc(100vw - 2rem);
        height: calc(100% - 2rem);
        margin: auto;
        margin-top: .8rem;
    }
    .task-modal .modal-fullscreen > .modal-content{
        border-radius: 1rem;
    }

    /* Action icons */
    .action-icon{
        position: relative;
        flex: none;
        display: inline-block;
        width: 22px;
        height: 22px;
        overflow: hidden;
        background-color: transparent;
        background-position: 0 0;
        background-size:72px;
        background-repeat: no-repeat;
        background-image: url({{asset('assets/instant_card/imgs/icons-set.jpg')}});
    }
    .action-icon.IG-like{ background-position: 0px 0px;}
    .action-icon.IG-liked{ background-position: -23px 0px;}
    .action-icon.IG-comment{ background-position: 0px -22px;}
    .action-icon.IG-commented{ background-position: -23px -22px;}
    .action-icon.FB-share{ background-position: 0px -44px;}
    .action-icon.FB-shared{ background-position: -23px -44px;}
    .action-icon.FB-comment{ background-position: 0px -66px;}
    .action-icon.FB-commented{ background-position: -23px -66px;}
    .action-icon.FB-like{ background-position: 0px -88px;}
    .action-icon.FB-liked{ background-position: -23px -88px;}
    .action-icon.TW-like{ background-position: 0px -112px;}
    .action-icon.TW-liked{ background-position: -23px -112px;}
    .action-icon.LN-like{ background-position: 0px -134px;}
    .action-icon.LN-liked{ background-position: -23px -134px;}
    .action-icon.YT-like{ background-position: 0px -156px;}
    .action-icon.YT-liked{ background-position: -23px -156px;}
    .action-icon.YT-comment{ background-position: 0px -178px;}
    .action-icon.YT-commented{ background-position: -23px -178px;}
    .action-icon.GL-review{ background-position: 0px -200px;}
    .action-icon.GL-reviewed{ background-position: -23px -200px;}
    .action-icon.WB-visit{ background-position: 0px -223px;}
    .action-icon.WB-visited{ background-position: -23px -223px;}

    .action-icon.IG-follow{
        background-position: 0px -245px;
        width: 54px;
    }
    .action-icon.IG-following{
        background-position: 0px -268px;
        width: 68px;
    }

    .action-icon.TW-follow{
        background-position: 0px -291px;
        width: 61px;
    }
    .action-icon.TW-following{
        background-position: 0px -313px;
        width: 63px;
    }

    .action-icon.LN-follow{
        background-position: 0px -336px;
        width: 70px;
    }
    .action-icon.LN-following{
        background-position: 0px -359px;
        width: 72px;
    }

    .action-icon.YT-subscribe{
        background-position: 0px -381px;
        width: 67px;
    }
    .action-icon.YT-subscribed{
        background-position: 0px -404px;
        width: 72px;
    }

    /* Action icon end */
    
    @media(max-width:320px){
        .card.in-task .card-body{
            padding: 0.5rem;
        }
        .in-task .task-logo{
            width: 1.5rem;
            height: 1.5rem;
        }
        .in-task .task-title{
            font-size: .8rem;
            line-height: 1.1;
        }
    }


    /* ==== Modal Popup ==== */
    .ol-modal.popin{
        -webkit-animation: popin 0.3s;
        animation: popin 0.3s;
    }
    @keyframes popin{
        0% {
            -webkit-transform: scale(0);
            -ms-transform: scale(0);
            transform: scale(0);
            opacity: 0;
        }
        85% {
            -webkit-transform: scale(1.05);
            -ms-transform: scale(1.05);
            transform: scale(1.05);
            opacity: 1;
        }
        100% {
            -webkit-transform: scale(1);
            -ms-transform: scale(1);
            transform: scale(1);
            opacity: 1;
        }
    }
    @-webkit-keyframes popin{
        0% {
            -webkit-transform: scale(0);
            -ms-transform: scale(0);
            transform: scale(0);
            opacity: 0;
        }
        85% {
            -webkit-transform: scale(1.05);
            -ms-transform: scale(1.05);
            transform: scale(1.05);
            opacity: 1;
        }
        100% {
            -webkit-transform: scale(1);
            -ms-transform: scale(1);
            transform: scale(1);
            opacity: 1;
        }
    }


    /* Loader */
    #loader{
        position: fixed;
        z-index: 9999;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0, 0.6);
        display: none;
    }
    #loader .content{
        color: #fff;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        height: 100%;
        width: 100%;
    }
    #loader svg{
        animation-name: spin;
        animation-duration: 4000ms;
        animation-iteration-count: infinite;
        animation-timing-function: linear; 
    }

    #loaderFetchRecord{
        position: fixed;
        z-index: 9999;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0, 0.6);
        display: none;
    }
    #loaderFetchRecord .content{
        color: #fff;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        height: 100%;
        width: 100%;
    }
    #loaderFetchRecord svg{
        animation-name: spin;
        animation-duration: 4000ms;
        animation-iteration-count: infinite;
        animation-timing-function: linear; 
    }
    /* get details dob popup */
    .selected-date{
      color: #ffffff;
      background-color: #237cd8;
      border-radius: 4px;
    }
        
    #date-month-modal .modal-dialog{
        pointer-events: all;
    }
    .custom_calendar .days {
        list-style: none;
        margin: 0;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: start;
        padding-left: 0px;
    }
    .custom_calendar .days li {
        text-align: center;
        cursor: pointer;
        flex: 0 1 14.20%;
        height: 38px;
        line-height: 38px;
    }
    .custom_calendar .days li:hover,
    .custom_calendar .days li:active,
    .custom_calendar .days li:focus {
        color: #ffffff;
        background-color: #237cd8;
        border-radius: 4px;
    }
    .custom_calendar .days li .active {
        padding: 5px;
        background: #1abc9c;
        color: white !important
    }
    .close_calendar{
        font-size: 20px;
        line-height: 28px;
        width: 28px;
        height: 28px;
        color: #000000;
        background-color: #ffffff;
        border: 1px solid #000000;
        border-radius: 50%;
        text-decoration: none !important;
        text-align: center;
    }
    
    /* Add media queries for smaller screens */
    @media screen and (max-width:720px) {
        .days li {width: 13.1%;}
    }

    @media screen and (max-width: 420px) {
        .days li {width: 12.5%;}
        .days li .active {padding: 2px;}
    }

    @media screen and (max-width: 290px) {
        .days li {width: 12.2%;}
    }
</style>
