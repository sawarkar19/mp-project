@extends('layouts.employee')
@section('title', 'Dashboard: Employee Panel')

@section('head')
@include('layouts.partials.headersection',['title'=>'Dashboard'])
<style>
  ul li b{
    font-weight: 600;
  }
</style>

<style>
  .lh-1{
      line-height: 1.5;
  }

  .offer-icon-data .icon-box{
      position: relative;
      width: 38px;
      height: 38px;
      border-radius: 6px;
      color: #fff;
      text-align: center;
  }
  .offer-icon-data .icon-box i.far,
  .offer-icon-data .icon-box i.fas{
      font-size: 1.2rem;
      line-height: 38px;
  }

  /* Hero card CSS Overwrite */
  .card.card-hero .card-header{
      background: var(--primary);
  }
  .card.card-hero .card-header h4{
      font-size: 2rem;
  }
  .card.card-hero .card-header .card-icon{
      color: rgba(255, 255, 255, 0.4);
  }


  /* Social Posts Data CSS */
  .social-canvas-container{
      position: relative;
      width: 100%;
      max-width: 300px;
      margin: auto;
  }
  .budget-price .budget-price-label{
      line-height: 1;
  }
  .msg-expired{
      background-color: #767676 !important;
  }
  .expired-msg-text{
      color: #a6a6a6 !important;
  }
  /* dashbaord design offer banner */
  .bg-design-offer-banner{
      background: #F2EAE1;
      overflow: hidden;
      position: relative;
  }
  .bg-design-offer-banner-inner{
      display: flex;
      flex-direction: row;
      align-items: center;
      justify-content: space-between;
  }
  .design-offer-banner-img{
      text-align: right;
  }
  .design-offer-banner-img img{
      width: 575px;
  }
  .design-offer-button{
      background: #EF5744;
      border: 0px !important;
      border-radius: 30px;
      color: #fff;
  }
  .do-banner-text-para{
      color:#7C5037;
  }
  .design-img-top img{
      position: absolute;
      top: -20px;
      left: -24px;
      width: 100px;
      transform: rotate(180deg);
  }
  .design-img-bottom img{
      position: absolute;
      bottom: -20px;
      right: -24px;
      width: 100px;
  }
  .bg-design-offer-banner-inner.banner-responsive{
      flex-direction: column !important;
  }
  .bg-design-offer-banner-inner.banner-responsive .design-offer-banner-text,
  .bg-design-offer-banner-inner.banner-responsive .design-offer-banner-img{
      text-align: center;
  }
  /* create offer */
  .bg-design-offer{
      background: linear-gradient(245deg, #BFC3E2 0%, #F1F5FD 91%, #F8F5FD 100%);
      overflow: hidden;
      position: relative;
  }
  .design-offer-banner-text ,.design-offer-banner-img{
      position: relative;
  z-index: 2;
  }
  

  @media(max-width: 575px){
      .bg-design-offer-banner-inner{
          flex-direction: column;
      }
      .design-offer-banner-text,
      .design-offer-banner-img{
          text-align: center;
      }

  }

  .hide-section{
      display: none;
  }
</style>
@endsection
@section('content')
<section>
    <div class="section">
        <div class="section-body">
            <h2 class="section-title text-uppercase" style="color: #6777ef;">{{ $employee_info->bussiness_details->bussiness_detail->business_name ?? '' }}</h2>
            <p class="section-lead">{{ $employee_info->bussiness_details->bussiness_detail->tag_line ?? '' }}</p>
        </div>
   
         <div class="row mt-sm-4">
          
              <div class="col-12 col-md-12 col-lg-8">
                <div class="card card-primary">
                  
                  <div class="card-header">
                        <h4>Profile Details</h4>
                    </div>
                  <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item"><b>{{ __('Name :') }}</b> {{ $employee_info->name }}</li>
                      <li class="list-group-item"><b>{{ __('Mobile No :') }}</b> <a href="tel:{{ $employee_info->mobile }}">{{ $employee_info->mobile }} </a></li>
                      <li class="list-group-item"><b>{{ __('Joining Date :') }}</b> {{ $employee_info->created_at->format('j M, Y') }}</li>
                      <li class="list-group-item"><b>{{ __('Total Shared :') }}</b> <span class="badge badge-warning">{{ $total_shares }}</span> Customer(s)</li>
                      <li class="list-group-item"><b>{{ __('Total Redeemed :') }}</b> <span class="badge badge-warning">{{ $total_redeems }}</span> Customer(s)</li>
                      
                    </ul>

                  </div>
                  
                </div>
              </div>

              
              <div class="col-12 col-md-12 col-lg-4">
                <div class="">
            
                    @include('employee.current-offer')
                  
                </div>
              </div>
              

        </div>

    </div>
</section>

@endsection

