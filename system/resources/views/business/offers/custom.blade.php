@extends('layouts.business')
@section('title', 'Custom - Design Offer: Business Panel')

@section('head')
    @include('layouts.partials.headersection', ['title' => 'Custom Design'])
@endsection

@section('end_head')
<style>
    .dargdrop-zone{
        position: relative;
        width: 100%;
        min-height: 120px;
        border: 2px dashed rgba(0, 0, 0, 0.2);
        margin-bottom: 25px;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        transition: all 300ms ease;
        cursor: pointer;
        background: rgba(255, 255, 255, 0.5);
    }
    .dargdrop-zone p{
        text-align: center;
        color: var(--secondary);
    }
    .dargdrop-zone input{
        position: absolute;
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        outline: none;
        opacity: 0;
        cursor: pointer;
    }
    .dargdrop-zone:hover{
        border: 2px dashed var(--primary);
    }

    .lh-1{
        line-height: 1.5!important;
    }


    .custom-header,
    .custom-footer{
        position: relative;
        width: 100%;
        background-color: #f9fdff;
        color: #232325;
        border: 1px solid #ccd1d3;
    }
    .custom-header{
        border-radius: 4px 4px 0 0;
        border-bottom: 0px;
    }
    .custom-footer{
        border-radius: 0 0 4px 4px;
        border-top: 0px;
    }
    .custom-header .custom-header-inner,
    .custom-footer .custom-footer-inner{
        padding: 15px;
    }
    .custom-header .busines-name{
        text-align: center;
    }
    .custom-header .logo{
        position: relative;
        width: 70px;
        max-width: 100%;
        margin: auto;
    }
    .custom-header .contact-section{
        list-style: none;
        padding-left: 0px;
        position: relative;
        width: 100%;
        display: flex;
        justify-content: center;
        margin-bottom: 0px;
        line-height: 1;
    }
    .custom-header .contact-section li{
        display: inline-block;
        margin: 0 5px; 
    }
    .custom-header .contact-section li a{
        font-size: 20px;
        display: inline-block;
        width: 40px;
        height: 40px;
        text-align: center;
        line-height: 38px;
        background-color: #565b5f;
        transition: all 200ms ease;
        border-radius: 50%;
        box-shadow: -1px 1px 3px rgba(0, 0, 0, 0.2);
        color: #ffffff;
    }
    .custom-header .contact-section li a:hover{
        background-color: #acb4bb;
        color: #000000;
    }



    .number_link{
        font-size: 18px;
        letter-spacing: 1px;
        color: inherit!important;
        text-decoration: none!important;
        line-height: 1;
    }
    .number_link svg{
        vertical-align: top;
    }
    .custom-footer .social-icons{
        position: relative;
        list-style: none;
        padding-left: 0px;
        text-align: center;
    }
    .custom-footer .social-icons .si-tab{
        display: inline-block;
        margin: 0 5px;
    }
    .custom-footer .social-icons .si-tab:first-child{
        margin-left: 0px;
    }
    .custom-footer .social-icons .si-tab:last-child{
        margin-right: 0px;
    }
    .custom-footer .social-icons .si-tab > a{
        display: inline-block;
        width: 25px;
        height: 25px;
        text-align: center;
        transform: scale(1);
        transition: all 100ms ease;
        color: inherit;
    }
    .custom-footer .social-icons .si-tab > a:hover{
        /* transform: scale(1.1); */
    }
    .custom-footer .social-icons .si-tab > a > i{
        line-height: 32px;
        font-size: 22px;
    }
    @media (min-width:768px) {
        .custom-header .contact-tab{
            position: absolute;
            right: 0;
            bottom: 0;
            border-top-left-radius: 100px;
        }
        
    }
    @media (min-width:576px) {
        .custom-header .busines-name{
            text-align: left;
        }

        .custom-footer .social-icons{
            text-align: right;
        }

        .custom-header .contact-section{
            justify-content: right;
        }
    }


    .custom-header.dark,
    .custom-footer.dark{
        background-color: #232325;
        color: #ffffff;
        border: 1px solid #232325;
    }

    .card .disbale-input{
        opacity: 0.5;
        pointer-events: none;
    }

    /*.image_preview{
        border: 5px solid #f2f2f2;
        padding: 5px;
    }*/
</style>

{{-- Image Crop CSS --}}
<style type="text/css">
    .image-crop-modal .docs-tooltip{
        color: #ffffff;
    }
    .image-crop-modal .preview {
    overflow: hidden;
    width: 160px; 
    height: 160px;
    margin: 10px;
    border: 1px solid red;
    }
    .image-crop-modal .modal-lg{
    max-width: 1000px !important;
    }
    .image-crop-modal .ratio-btn{
    margin-bottom: 0px !important;
    }
    .image-crop-modal .container {
    margin: 20px auto;
    max-width: 640px;
    }
    .image-crop-modal img {
        width: 100%;
    }
    .image_preview{
        margin: auto;
        display: block;
        width: 200px;
    }
</style>
@endsection

@section('content')
<section class="section">
    <div class="section-body">

        <div class="row justify-content-center">
            <div class="col-xl-8">

            <form method="POST" action="{{ route('business.offerSaveCustom', ['offer_id' => $offer_id]) }}" id="customOfferform">

                <input type="hidden" name="offer_id" value="{{ $offer_id }}" /> 
                <input type="hidden" name="offer_create_id" value="{{ request()->get('offer_create_id') }}" />

                {{-- URL section  --}}
                <div class="card mb-0" id="existing_url">
                    <div class="card-body">
                        @php
                            
                            if($offer != ''){
                                $theme = $offer->theme;
                                $show_header = $offer->show_header;
                                $show_footer = $offer->show_footer;
                                $image = $offer->image;
                                $website_url = $offer->website_url;
                            }else{
                                $theme = 'light';
                                $show_header = 0;
                                $show_footer = 0;
                                $image = '';
                                $website_url = '';
                            }

                            //get session data
                            $imagestring = $selected_file = '';

                            if(!empty($custom_offer_data)){
                                $imagestring = $custom_offer_data['imagestring'];

                                if($custom_offer_data['show_header'] == '1'){
                                    $show_header = 1;
                                }

                                if($custom_offer_data['show_footer'] == '1'){
                                    $show_footer = 1;
                                }

                                $theme = $custom_offer_data['theme'];

                                $website_url = $custom_offer_data['website_url'];

                                $selected_file = $custom_offer_data['selected_file'];
                                
                            } 


                        @endphp
                        
                        <div class="form-group mb-0">
                            <label for="" class="text-primary">Website Link (URL)</label>
                            <input type="url" name="website_url" id="website_url" class="form-control website_url" placeholder="Enter the URL of you webpage..." value="{{old('website_url', $website_url)}}">
                        </div>
                    </div>
                </div>
                {{-- url - END --}}

                <div class="p-5">
                    <h5 class="my-0 text-center">OR</h5>
                </div>

                {{-- image section  --}}
                <div class="card">
                    <div class="card-body">
                        <div class="form-group mb-0">
                            <label for="" class="text-primary">Use Image</label>
                        </div>
                        <div class="dargdrop-zone @if($imagestring != '') border-success @endif">
                            <input name="image" id="cus_image" type="file" accept="image/jpeg, image/png"
                                class="cropperjs_input" 
                                data-exts="jpeg|jpg|png" 
                                data-function-name="custom_offer_image_select" 
                                data-cancel-function="click_canceled($(this));"
                            />

                            <input type="hidden" name="imagestring" id="imagestring" value="{{ $imagestring }}" />
                            
                            <p class="mb-0 lh-1">Select or Drag and drop image here.</p>
                            <p class="mb-2 text-secondary lh-1">Please select only .png, .jpg and .jpeg file with 2MB of maximum file size.</p>
                            <p class="mb-0"><span class="btn btn-sm btn-primary px-3">Browes Image</span> </p>
                            <p class="mb-0" id="cus_image_text">
                                @if($selected_file != '')
                                    <span class="text-success">{{ $selected_file }}</span>
                                @endif
                            </p>
                        </div>

                        <div class="image_preview">
                        @if($image != '')
                            <img id="preview_oi" src="{{ asset('assets/templates/custom/'.$image) }}" class="img-fluid logo_path" alt="{{ asset('assets/templates/custom/'.$image) }}">
                        @else
                            <img id="preview_oi" src="{{ $imagestring }}" class="img-fluid logo_path" alt="">
                        @endif
                        </div>

                        <div class="mb-5 headerbox @if($imagestring == '' && $image == '')) disbale-input @endif" >
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="show_header" name="show_header" value="1" @if($show_header == 1) checked @endif>
                                <label class="custom-control-label" for="show_header"><b>Show Header</b></label>
                                <span class="small d-block lh-1">Select show header if you want to add a header above your uploaded image where the customer can view your business name,logo and tagline etc.</span>
                            </div>

                            <div class="custom-header" id="custom_header">
                                <div class="custom-header-inner">
                                    <div class="d-sm-flex justify-content-between align-items-center">
                                        <div class="mb-2 mb-sm-0">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <div>

                                                    {{-- @php
                                                    dd($planData['business_detail']);
                                                    @endphp --}}

                                                    @if($planData['business_detail']['logo'])
                                                    <div class="logo mr-2">
                                                        <img src="{{ asset('assets/business/logos/'.$planData['business_detail']['logo'])}}" class="img-fluid" alt="Logo" width="50">
                                                    </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <h5 class="mb-0">{{ $planData['business_detail']['business_name'] }}</h5>
                                                    <p class="mb-0">{{ $planData['business_detail']['tag_line'] }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="">
                                            <ul class="contact-section">
                                                <li>
                                                    <a href="">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                                                        <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                                                    </svg>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                                                        <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                                                    </svg>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" data-toggle="modal" data-target="#LocationModal">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                                        <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                                                        <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                                    </svg>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-globe2" viewBox="0 0 16 16">
                                                        <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855-.143.268-.276.56-.395.872.705.157 1.472.257 2.282.287V1.077zM4.249 3.539c.142-.384.304-.744.481-1.078a6.7 6.7 0 0 1 .597-.933A7.01 7.01 0 0 0 3.051 3.05c.362.184.763.349 1.198.49zM3.509 7.5c.036-1.07.188-2.087.436-3.008a9.124 9.124 0 0 1-1.565-.667A6.964 6.964 0 0 0 1.018 7.5h2.49zm1.4-2.741a12.344 12.344 0 0 0-.4 2.741H7.5V5.091c-.91-.03-1.783-.145-2.591-.332zM8.5 5.09V7.5h2.99a12.342 12.342 0 0 0-.399-2.741c-.808.187-1.681.301-2.591.332zM4.51 8.5c.035.987.176 1.914.399 2.741A13.612 13.612 0 0 1 7.5 10.91V8.5H4.51zm3.99 0v2.409c.91.03 1.783.145 2.591.332.223-.827.364-1.754.4-2.741H8.5zm-3.282 3.696c.12.312.252.604.395.872.552 1.035 1.218 1.65 1.887 1.855V11.91c-.81.03-1.577.13-2.282.287zm.11 2.276a6.696 6.696 0 0 1-.598-.933 8.853 8.853 0 0 1-.481-1.079 8.38 8.38 0 0 0-1.198.49 7.01 7.01 0 0 0 2.276 1.522zm-1.383-2.964A13.36 13.36 0 0 1 3.508 8.5h-2.49a6.963 6.963 0 0 0 1.362 3.675c.47-.258.995-.482 1.565-.667zm6.728 2.964a7.009 7.009 0 0 0 2.275-1.521 8.376 8.376 0 0 0-1.197-.49 8.853 8.853 0 0 1-.481 1.078 6.688 6.688 0 0 1-.597.933zM8.5 11.909v3.014c.67-.204 1.335-.82 1.887-1.855.143-.268.276-.56.395-.872A12.63 12.63 0 0 0 8.5 11.91zm3.555-.401c.57.185 1.095.409 1.565.667A6.963 6.963 0 0 0 14.982 8.5h-2.49a13.36 13.36 0 0 1-.437 3.008zM14.982 7.5a6.963 6.963 0 0 0-1.362-3.675c-.47.258-.995.482-1.565.667.248.92.4 1.938.437 3.008h2.49zM11.27 2.461c.177.334.339.694.482 1.078a8.368 8.368 0 0 0 1.196-.49 7.01 7.01 0 0 0-2.275-1.52c.218.283.418.597.597.932zm-.488 1.343a7.765 7.765 0 0 0-.395-.872C9.835 1.897 9.17 1.282 8.5 1.077V4.09c.81-.03 1.577-.13 2.282-.287z"/>
                                                    </svg>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4 footerbox @if($imagestring == '' && $image == '')) disbale-input @endif" >
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="show_footer" name="show_footer" value="1" @if($show_footer == 1) checked @endif>
                                <label class="custom-control-label" for="show_footer"><b>Show Footer</b></label>
                                <span class="small d-block lh-1">Select show footer if you want to add a header above your uploaded image where the customer can view your business name,logo and tagline etc.</span>
                            </div>

                            <div class="custom-footer {{ $theme }}" id="custom_footer">
                                <div class="custom-footer-inner">
                                    <div class="row align-items-center">
                                        <div class="col-sm-5 text-center text-sm-left">
                                            <a href="#" class="number_link">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                                                    <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                                                </svg>
                                                <span>{{ $planData['business_detail']['whatsapp_number'] }}</span>
                                            </a>
                                        </div>
                                        <div class="col-sm-7">
                                            <div >
                                                <ul class="social-icons mb-0">
                                                    <li class="si-tab">
                                                        <a href="" class="fb" title="Facebook" id="facebook_link">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                                                <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                                                            </svg>
                                                        </a>
                                                    </li>
                                                    <li class="si-tab">
                                                        <a href="" class="ig" title="Instagram" id="instagram_link">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                                                                <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
                                                            </svg>
                                                        </a>
                                                    </li>
                                                    <li class="si-tab">
                                                        <a href="" class="tw" title="Twitter" id="twitter_link">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                                                                <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
                                                            </svg>
                                                        </a>
                                                    </li>
                                                    <li class="si-tab">
                                                        <a href="" class="li" title="LinkedIn" id="linkedin_link">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
                                                                <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z"/>
                                                            </svg>
                                                        </a>
                                                    </li>
                                                    <li class="si-tab">
                                                        <a href="" class="yt" title="YouTube" id="youtube_link">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-youtube" viewBox="0 0 16 16">
                                                                <path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.007 2.007 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.007 2.007 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31.4 31.4 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.007 2.007 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A99.788 99.788 0 0 1 7.858 2h.193zM6.4 5.209v4.818l4.157-2.408L6.4 5.209z"/>
                                                            </svg>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ============ Header footer - END ==============--}}

                        <div class="themebox @if($imagestring == '' && $image == '')) disbale-input @endif" >
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="light_theme" name="theme" value="light" class="custom-control-input" @if($theme == 'light') checked @endif>
                                <label class="custom-control-label" for="light_theme">Light Themes</label>
                            </div>

                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="dark_theme" name="theme" value="dark" class="custom-control-input" @if($theme == 'dark') checked @endif>
                                <label class="custom-control-label" for="dark_theme">Dark Themes</label>
                            </div>
                        </div>




                    </div>
                </div>
                {{-- image - END --}}

                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-success px-4">Save & Continue</button>
                        {{-- <a href="#" class="btn btn-success px-4">Save & Continue</a> --}}
                    </div>
                </div>

            </form>

            </div>
        </div>

    </div>
</section>

    {{-- CropperJS component --}}
    @include('components.cropperjs')

@endsection

@section('end_body')
<script>
    var media_selector = $("#cus_image");
    var media_text = $("#cus_image_text");
    var allowed_ext = ['png', 'jpg', 'jpeg'];
    var allowed_file = ['image'];
    var allowed_size = 2; // in MB

    $(document).ready(function() {
        var fname, fsize, fpath, fext, ftype;

        media_selector.on("change", function(evnt){
            $("#website_url").val('');
            var preview_img = $("#preview_oi").attr("src");
            if(preview_img != ''){
                $(".image_preview").show();

                $('.headerbox').addClass('disbale-input');
                $('.footerbox').addClass('disbale-input');
                $('.themebox').addClass('disbale-input');
            }
            
            var media = evnt.target.files[0];

            media_text.empty();
            $(".dargdrop-zone").removeClass("border-danger").removeClass("border-success");

            if(evnt.target.files.length > 0){
                let mediaOK = true;
                let mediaError = '';

                fpath = (window.URL || window.webkitURL).createObjectURL(media); // Path
                fext = media.name.split('.').pop(); // extension
                fsize = media.size / 1024 / 1024; // size in MB
                ftype = media.type;
                ftype = ftype.substr(0, ftype.indexOf("/")).toLowerCase(); // type
                console.table(ftype);
                /* Validations */
                if(allowed_file.indexOf(ftype) >= 0){
                    if (allowed_ext.indexOf(fext) == -1) {
                        mediaOK = false;
                        mediaError += ' "'+fext.toUpperCase()+'" file extension is not allowed. Only '+allowed_ext.join(', ').toUpperCase()+' are allowed. ';
                    }
                    if(fsize > allowed_size){
                        mediaOK = false;
                        mediaError += 'File size should be less than equals to '+allowed_size+' MB. ';
                    }
                }else{
                    mediaOK = false;
                    mediaError += 'Only Excel (.xlsx) file type is allowed. ';
                }

                if(mediaOK){
                    let reader = new FileReader();
                    reader.readAsDataURL(media);
                    reader.onloadend = function(evt){
                        if (evt.target.readyState == FileReader.DONE){
                            $(".dargdrop-zone").addClass("border-success");
                            media_text.html('<span class="text-success">'+media.name+'</span>');

                            $('.headerbox').removeClass('disbale-input');
                            $('.footerbox').removeClass('disbale-input');
                            $('.themebox').removeClass('disbale-input');
                        }
                    }
                }else{
                    media_selector.val('');
                    $(".dargdrop-zone").addClass("border-danger");
                    media_text.html('<span class="text-danger">'+mediaError+'</span>');
                    
                }
                
            }
        });


        $('#website_url').keyup(function(event) {
            $("#cus_image").val('');
            $(".dargdrop-zone").removeClass("border-success");
            $("#cus_image_text").html('<span class="text-success"></span>');
            $(".dargdrop-zone").removeClass("border-danger");
            $("#cus_image_text").html('<span class="text-danger"></span>');
            var preview_img = $("#preview_oi").attr("src");
            if(preview_img != ''){
                $(".image_preview").hide();

                $('.headerbox').addClass('disbale-input');
                $('.footerbox').addClass('disbale-input');
                $('.themebox').addClass('disbale-input');
            }
        });
    });
</script>
<script>
    $(document).ready(function(){

        $('input[name="theme"]').on('change', function(){
            var theme = $('input[name="theme"]:checked').val();
            $('#custom_header').removeClass('light').removeClass('dark').addClass(theme);
            $('#custom_footer').removeClass('light').removeClass('dark').addClass(theme);
        });


        $(document).ajaxSend(function() {
            $("#overlay").fadeIn(300);　
        });

        $("#customOfferform").on('submit', function(e){
            e.preventDefault();

            var website_url = $("#website_url").val();
            if(website_url != ''){
                if(website_url.indexOf('https') != -1){
                    /* Valid */
                }else{
                    Sweet("error", "Please enter valid URL.");
                    return false;
                }
            }
            
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
                    $("#overlay").fadeOut(300);
                    //console.log(response);
                    if(response.status == true){
                        //Sweet('success',response.message);
                        window.location.href = response.redirect_url;
                    }else{
                        Sweet('error',response.message);
                    }
                },
                error: function(xhr, status, error) 
                {
                    $("#overlay").fadeOut(300);
                    $.each(xhr.responseJSON.errors, function (key, item) 
                    {
                        Sweet('error',item);
                    });
                }
            })
        });


    });
</script>
{{-- Image Crop Script --}}
<script>

    function click_canceled(input) {
        $('#cus_image').val('');
        var img_pre = $('#preview_oi');
        var image = img_pre.attr('alt');
        img_pre.attr('src', image);

        $("#imagestring").val('');

        $(".dargdrop-zone").removeClass("border-success").removeClass("border-danger");
        $("#cus_image_text").html('');
    }
    
    /* Image Crop Script */
    function custom_offer_image_select(image){
        /* $('.remove-business-logo').show(); */
        $("#preview_oi").attr("src", image);
        $("#imagestring").val(image);
    }


    /* Billing address */
    $(document).on("change", "#same_to_bill", function(){
        if(this.checked) {
            $(this).prop("checked", true);
            $.ajax({
                url : '{{ route('business.checkSameBilling') }}',
                type : 'GET',
                dataType : "json", 
                success : function(record) {
                    console.log(record);
                    $('#billing_address_line_1').val(record.details.billing_address_line_1);
                    $('#billing_pincode').val(record.details.billing_pincode);
                    $('#billing_pincode').val(record.details.billing_pincode);
                    $('#billing_city').val(record.details.billing_city);
                    $('#billing_state').val(record.details.billing_state);
                    if(record.tab == 'billing_address'){
                        $('#contact_tab4 .status-icon').empty();
                        $('#contact_tab4 .status-icon').html('<i class="fas fa-check-circle text-success"></i>');
                    }
                    Sweet('success','Billing address set same as business address!');
                    return true;
                }
            });
        }else{
            swal.fire({
                title: 'Are you sure?',
                text: 'Once unchecked, your billing address will show empty!',
                type: 'question',
                icon: 'warning',
                animation: true,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes Delete',
                cancelButtonText: 'Cancel',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: true,
                focusConfirm: true
            })
            .then(function(data){
                /*console.log(data.value);*/
                if (data.value == true) {
                    $("#overlay").fadeIn(300);
                    
                    $.ajax({
                        type: 'POST',
                        url: "{{route('business.deleteBilling')}}",
                        data:  {"_token": "{{ csrf_token() }}"},
                        dataType: 'JSON',
                        success: function (res) {

                            $("#overlay").fadeOut(300);
                            
                            if(res.status == true){
                                Swal.fire(
                                  'Deleted!',
                                  res.message,
                                  'success'
                                )
                                
                                $('#billing_address_line_1').val('');
                                $('#billing_pincode').val('');
                                $('#billing_pincode').val('');
                                $('#billing_city').val('');
                                $('#billing_state').val('');

                                if(res.tab == 'billing_delete'){
                                    $('#contact_tab4 .status-icon').empty();
                                    $('#contact_tab4 .status-icon').html('<i class="fas fa-exclamation-circle text-warning"></i>');
                                }

                            }else{
                                Swal.fire(
                                  'Deleted!',
                                  res.message,
                                  'success'
                                )
                            }
                        }
                    });
                        
                } /*else {
                    Sweet('success','Your logo file is safe!');
                }*/
            });
            $(this).prop("checked", false);
        }
        console.log(this.checked);
    });
    
    /* Channel */
    $(document).on("change", ".custom-switch", function(){
        var parentId, checkbox, value;
        parentId = $(this).attr('id');
        checkbox = $('#'+parentId+' .custom-switch-input');
        if(checkbox.is(':checked')) { checkbox.val('1'); }else{ checkbox.val('0'); }
        value = checkbox.val();
        $.ajax({
            url : '{{ route('business.msgToggle') }}',
            type : 'POST',
            data : {
                "channel": parentId,
                "value" : value,
                "_token" : $('meta[name="csrf-token"]').attr('content')
            },
            dataType : "json", 
            success : function(record) {
                console.log(record);
                if(record.status == true){
                    // if(record.messager == true ){ $('#'+record.channel+' .custom-switch-input').prop('checked', true)}
                    Sweet('success',record.message);
                    return true;
                }else{                    
                    Sweet('error',record.message);
                    return false;
                }
                
            }
        });
    });

    var hash = location.hash.replace(/^#/, '');  // ^ means starting, meaning only match the first hash
    if (hash) {
        $('.tab-pane a[href="#' + hash + '"]').tab('show');
    } 

    // Change hash for page-reload
    $('.tab-pane a').on('shown.bs.tab', function (e) {
        window.location.hash = e.target.hash;
    })
</script>
@endsection