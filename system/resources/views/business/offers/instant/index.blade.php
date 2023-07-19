@extends('layouts.business')
@section('title', 'Instant Offers: Business Panel')

@section('end_head')
<style>
    .form_select label{
        font-size: 14px;
    }
    .form_select button{
        max-width: 100%;

    }   
    .current_offer .card{
        flex-direction: row;
    }
    .offer_img img{
        max-width: 100%;
        border-radius: 3px;
    }
   .current_offer .card-body p{
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        line-height: 20px;
        overflow: hidden;
        text-overflow: ellipsis;
        cursor: pointer;
   }
   .status .badge{
     padding: 4px 12px;
     font-size: 9px;
     color: #fff;

   }
   .form_select small{
    line-height: 19px;
    font-size: 11px;

   }
    .selectgroup-button{
        line-height: 22px;
    }
   .current_offer .date p{
        font-weight: 500 !important;
    } 
    .select_offer .card{
        background: #f9f9f9; 
        margin-bottom: 0;
        border: 1px solid #ebebeb;
    }
   
    .article-header{
        border-radius: 3px 3px 0 0;
    } 
    .article, .article-details{
        border-radius: 3px;
    }
    .amount{
        height: 100%;
        position: relative;
    }
    .amount .radio_label{
        height: 100%;
        width: 100%;
        position: relative;
    }
    .select_offer .radio_label:before{
        content: '';
        border-radius: 50%;
        width: 20px;
        height: 20px;
        background-color: #fff;
        border: 1px solid #c7c7c7;
        position: absolute;
        top: 15px;
        left: 10px;
        z-index: 1;
    }
    .select_offer .radio_label:after{
        content: '';
        top: 15px;
        left: 10px;
        background-color: #ffffff;
        position: absolute;/*
        transform: rotate(45deg);*/
        height: 20px;
        width: 20px;
        border-radius: 50%;
        border: 4px solid #006ba2;
        /*border-bottom: 2px solid #237cd8;
        border-right: 2px solid #237cd8;*/
        visibility: hidden;
        z-index: 2;
    }
    .radio_button{
        visibility: hidden;
        position: absolute;
        top: 0;
        left: 0;
    }
    .amount input:checked + .radio_label:before{
        visibility: hidden;
    }
    .amount input:checked + .radio_label:after{
        visibility: visible;
    } 
    .amount input:checked + .radio_label .card{
        border: 1px solid #006ba2;
        background: #effaff;
    } 
    .card_style{
        padding: 12px;
        padding-left: 40px;
    }
    .card_style h6{
        font-size: 14px;
        margin-bottom: 6px;
    }
    .card_style p{
        font-size: 12px;
        line-height: 16px;
    }
    .form_detail label span{
        color: red;
    }
  @media(max-width: 575px){
    .toggle_buttons .custom-switch {
        padding-left: 0rem;
    }
      .current_offer .card{
        flex-direction: column;
    }
}
 @media(max-width: 991px){
    .amount{
        height: 100%;
        min-height: 100%;
    }

 }
    
</style>
@endsection

@section('head') @include('layouts.partials.headersection',['title'=>'Instant Offers']) @endsection

@section('content')
<section class="section">
    <div class="">
        <div class="row">
           <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
                <button class="btn btn-primary">QR Code <i class="fas fa-qrcode"></i></button>
                <button class="btn btn-success ml-4">Share <i class="fas fa-share"></i></button>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
                <div class="toggle_buttons">
                   <div class="form-group float-sm-right">
                        <div class="custom-switches-stacked mt-2">
                            <label class="custom-switch justify-content-sm-between">
                              <input type="checkbox" checked data-toggle="toggle"  name="option" value="1" class="custom-switch-input" checked>
                              <span class="custom-switch-description mr-4">Via SMS</span><span class="custom-switch-indicator"></span>
                            </label>
                            <label class="custom-switch justify-content-sm-between">
                              <input type="checkbox" checked data-toggle="toggle" name="option" value="2" class="custom-switch-input">
                              <span class="custom-switch-description mr-4">Via WhatsApp</span>
                              <span class="custom-switch-indicator"></span>
                            </label>
                        </div>
                    </div> 
                </div>
                
            </div>
        </div>
        <div  class="row">
            {{--card1 offer section--}}
            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-3 ">
                <div class="current_offer" style="max-width: 400px;">
                    <h5>Current Offer</h5>
                    <article class="article <!-- article-style-c --> h-100 mb-0">
                        <div class="article-header">
                            <div class="article-image" data-background="{{asset('assets/socialposts/OL-socialpost-11022022021543.jpg')}}"></div>
                        </div>
                        <div class="article-details">
                            <div class="article-title">
                                <h5 class="h6 text-primary" style="line-height: 1.5">There is a title of the Social Post</h5>
                            </div>
                            <div class="card-body p-0">
                                <p class="mb-1" style="line-height: 22px;">Lorem ipsum dolor sit amet, consectetur elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore.</p>
                                
                            </div>
                            <div class="date_status d-flex justify-content-between mt-2">
                                <div class="date">
                                    <p class="mb-0 font-weight-bold">Start Date: <span class="text-warning">01/06/2022</span></p> 
                                    <p class="mb-0 font-weight-bold">End Date: <span class="text-warning">28/06/2022</span></p> 
                                </div> 
                                <div class="status text-center">
                                    <p class="mb-0 font-weight-bold">Status</p>
                                    <span class="badge bg-success">Posted</span>  
                                </div>
                            </div>
                        </div>    
                    </article>
                </div> 
            </div> 
        {{--card discount type--}}
            <div class="col-lg-8 col-md-10 col-sm-12 col-12">
                <div class="card p-4 form_select1">
                    {{--select discount type start--}}
                    <div class="form-group mb-0">
                        <label class="form-label mb-3">Select Discount type for your running offer</label>
                        <div class="row select_offer">
                            <div class="col-lg-6 col-md-12 col-sm-12 mb-3"> 
                                <div class="amount">
                                    <input type="radio" name="option"  id="option1" class="radio_button select_fixed" checked=""> 
                                        <label class="radio_label mb-0" for="option1">
                                            <div class="card">
                                                <div class="card_style">
                                                   <h6>Fixed Amount</h6> 
                                                    <p class="mb-0">Set the fixed amount in rupees, you want to give to your customer as an offer.</p> 
                                                </div>
                                            </div>  
                                        </label>    
                                </div>
                            </div> 
                            <div class="col-lg-6 col-md-12 col-sm-12 mb-3">
                                <div class="amount">
                                    <input type="radio" name="option"  id="option2" class="radio_button select_percentage"> 
                                        <label class="radio_label mb-0" for="option2">
                                            <div class="card">
                                                <div class="card_style">
                                                   <h6>Percentage Discount</h6> 
                                                    <p class="mb-0">Set the percentage of discount you want to give to your customer on the specific offer.</p> 
                                                </div>
                                            </div>  
                                        </label>    
                                </div> 
                            </div>
                        </div>
                    </div>
                    {{--select discount type end--}}   
                    {{--form Fixed amount Start--}} 
                <div class="form_detail">
                 <input type="hidden" name="discount_type" value="Fixed" />
                    <div class="fixed_amount1">
                        <div class="card-header p-0" style="border-style: none;">
                            <h4>Challenge Details</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="form-group row" style="margin-bottom: 15px;">
                                <div class="col-sm-5 col-form-label">
                                    <label class="mb-1">Enter Discount Amount <span>*</span> </label> 
                                    <p class="small text-secondary mb-1" style="line-height:1.6;">Set the fixed amount in rupees, you want to give to your customer as an offer.</p>    
                                </div>
                                <div class="col-sm-7">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                                        </div>
                                        <input type="text" name="discount_amount" class="form-control offer_data_in" min="0" placeholder="Enter Amount from 0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-5 col-form-label">
                                    <label>Minimum clicks Require? <span>*</span> </label>
                                </div>
                                <div class="col-sm-7">    
                                    <input type="text" name="promo_count" min="1" class="form-control" placeholder="Enter the number clicks to required to get the offer..." value="">
                                </div>
                            </div>            
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <div class="col-sm-5 col-form-label">
                                            <label>Last Date To Redeem Code <span>*</span></label>   
                                        </div>
                                        <div class="col-sm-7">
                                            <input type="date" id="redeem_date" name="redeem_date" class="form-control" value="">   
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  
                        {{--form Fixed amount end--}} 
                         {{--form percentage discount start--}} 
                    <input type="hidden" name="discount_type" value="Percentage" />
                    <div class="percentage_discount" style="display: none;">
                        <div class="card-header p-0" style="border-style: none;">
                            <h4>Challenge Details</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="form-group row" style="margin-bottom: 15px;">
                                <div class="col-sm-5 col-form-label">
                                    <label class="mb-1">Enter Discount Percentage <span>*</span> </label>
                                     <p class="small text-secondary mb-1" style="line-height:1.6;">Set the percentage of discount you want to give to your customer on the specific offer.</p>
                                </div>
                                <div class="col-sm-7">
                                    <div class="input-group">
                                        <input type="text" name="discount_percent" class="form-control offer_data_in" min="0" max="100" placeholder="Enter Percentage between 0 to 100%">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" style="    border-radius: 0 3px 3px 0;"><i class="fas fa-percent"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <div class="form-group row">
                                <div class="col-sm-5 col-form-label">
                                    <label>Minimum clicks Require? <span>*</span> </label>
                                </div>
                                <div class="col-sm-7">    
                                    <input type="text" name="promo_count" min="1" class="form-control" placeholder="Enter the number clicks to required to get the offer..." value="">
                                </div>    
                            </div>             
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <div class="col-sm-5 col-form-label">
                                            <label>Last Date To Redeem Code <span>*</span></label>
                                        </div>
                                        <div class="col-sm-7">  
                                            <input type="date" id="redeem_date" name="redeem_date" class="form-control" value="">
                                        </div>    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="d-flex justify-content-between">  
                        <button type="submit" class="btn btn-success">Save Changes</button>
                        <button class="btn btn-sm btn-outline-primary">Modify Instant Challenge</button>
                    </div>
                </div>        
            </div>
        </div>
            
        </div>
    </div>        
</section>
@endsection

@section('end_body')
<script>
    $(function () {
        $(".form_select1").click(function () {
            if ($("#option1").is(":checked")) {
                $(".fixed_amount1").show();
                $(".percentage_discount").hide();
            }    
            else{
               $(".fixed_amount1").hide();
                $(".percentage_discount").show();
            }
        });
    });
</script>
<!-- @include('business.offers.instant.js') -->
@endsection