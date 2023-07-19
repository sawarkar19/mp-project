<style>
    .background_color{
        background:linear-gradient(135deg, rgb(0,255,175, 1) -50%, rgba(0,36,156, 1));
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 991;
    }
    #Template{
        margin-top: 76px;
    }
    .back_btn a{
        color: #fff;
        text-decoration: none;
    }
    .container{
        width: 100%;
        max-width:991px;
    }
    .status .badge{
        padding: 6px 20px;
        border-radius: 20px;
    }
    .social_icons{
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        justify-content: space-between;
        align-items: center;
    /* width: 155px;
        height: 47px;*/
    }
    .social_icons  a{
        margin: 0px 4px;
        text-align: center;
        position: relative;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: var(--cl-prime);
        color: #fff;
    }
    .social_icons  a > i {
        line-height: 38px;
        margin-left: 0px!important;
        font-size: 18px;
    }
    .social_icons a:nth-child(1) {
        background-color: #00acee;
    }
    .social_icons a:nth-child(2) {
        background-color: #4267B2;
    }
    .social_icons a:nth-child(3) {
        background-color: #0e76a8;
    }
    .share_icon i{
        display: none;
    }
    @media(max-width: 575px){
        #Template{
            margin-top: 62px;
        }
        .status  p{
            display: none;
        }
        .back_btn a span{
            display: none;
        }
        /* .editor_button a{
            background-color: transparent;
            color: #fff;
            border-style: none;
        } */
        /* .editor_button span{
            display: none;
        } */
        .share_icon{
            position: relative;
        }
        .share_icon i{
            display: block;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            top: -15px;
            color: #fff;
        }
        .social_icons{
            position: absolute;
            left: 0px;
            top: 49px;
            width: 100%;
            padding: 5px;
            z-index: 2;
            background-color: #c8cdd4;
            justify-content: space-around;
            transition: all 300ms ease-in-out;
        }
        .icons{
            display: none;
        }
        .back_btn i, .share_icon i, .editor_button i{
            font-size: 16px;
        }
        .btn:focus {
            box-shadow: none;
        }
    }
</style>
 
<div class="background_color py-2 py-sm-3">
     <div class="container position-relative">
         <div class="d-flex align-items-center justify-content-between">
             <div class="back_btn">
                
                 <a href="{{ route('business.designOffer') }}">
                     <h5 class="mb-0"><i class="bi bi-arrow-left mb-0"></i>
                         <span>Back</span>
                     </h5>
                 </a>  
             </div>
             <div class="text-center status" id="offer_post_status">
                    <p class="small mb-0 text-white ">Post Status</p>
                    {{-- @if($isCurrentOfferPosted == 1)
                        <span style="color: #f2f2f2" class="badge badge-success py-1">Posted</span>
                    @else
                        <span style="color: #f2f2f2" class="badge badge-warning py-1">Scheduled</span>
                    @endif --}}
                    <span style="color: #f2f2f2" class="badge badge-warning py-1">Scheduled</span>
             </div>
             {{-- <div class="">
                 <div class="share_icon">
                     <i class="bi bi-share-fill"></i>
                 </div>
                 <div class="icons p-1 mx-sm-auto">
                     <div class="social_icons">
                         <a href=""><i class="bi bi-twitter"></i></a>
                         <a href=""><i class="bi bi-facebook"></i></a>
                         <a href=""><i class="bi bi-linkedin"></i></a> 
                     </div>
                 </div>
             </div> --}}
             <div class="editor_button">
                 @php
                     $now = \Carbon\Carbon::now()->format("Y-m-d");
                     
                     $start_date = $end_date = '';
                     if($offer->start_date != null){
                        $start_date = date('Y-m-d', strtotime($offer->start_date));
                     }

                     if($offer->end_date != null){
                        $end_date = date('Y-m-d', strtotime($offer->end_date));
                     }
 
                     $current_offer = $expired_offer = false;
                     if(($start_date != '' && $end_date != '') && $start_date <= $now && $now <= $end_date ){
                         $current_offer = true;
                     }

                     if(($start_date != '' && $end_date != '') && $start_date < $now && $end_date < $now ){
                         $expired_offer = true;
                     }

                     /* dd($start_date); */
                 @endphp
 
                 @if($current_offer == true && $expired_offer == false)
                     <div class="text-center status">
                         <p class="small mb-0 text-white ">Offer Status</p>
                         <span class="badge badge-success">Current Offer</span>
                     </div>
                 @elseif($current_offer == false && $expired_offer == true)
                     <span class="btn btn-danger">Expired</span>
                 @else
                     <a href="{{ $edit_url }}" class="btn btn-primary font-weight-bold"><span>Edit</span><i class="bi bi-pencil-square ml-sm-2"></i></a>
                     
                 @endif
             </div>   
         </div>   
     </div>
</div>
 
<script type="text/javascript">
     $(document).ready(function() {
        $('.share_icon').on('click', function () {
           $('.icons').toggle();
        });
     });
</script>
 
 