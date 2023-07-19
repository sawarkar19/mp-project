@extends('layouts.website')

@section('title', 'About Us | MouthPublicity.io: The Best Mouth Publicity Management Tool')
@section('description', 'MouthPublicity.io powers word-of-mouth marketing campaigns for businesses of all shapes and sizes. Try it for free today!')
@section('keywords', 'why MouthPublicity.io, what is MouthPublicity.io, mission of MouthPublicity.io, about us MouthPublicity.io')
{{-- @section('image', '') --}}

@section('end_head')

@endsection

@section('content')
{{-- About us section --}}
<section id="about_us">
    <div class="container">
        {{-- Breadcrumb Section --}}
        @php
            $bcrm = array(
                array('name' => 'About Us', 'link' => false),
            );
        @endphp
        @include('website.components.breadcrumb', $bcrm)
    </div>
    <div>
        <div class="container">
            <div class="flex-banner py-5">
                <div class="d-block">
                    <div class="row justify-content-center">
                        <div class="col-lg-12 mb-5 mb-lg-0">
                            <div class="clearfix">
                                <h1 class="font-900 color-gradient d-inline-block py-4" style="font-size:3rem;">What is <br> MouthPublicity.io?</h1>
                                <img src="{{ asset('assets/website/images/about-page/about-mobile.svg') }}" class="banner-image col-md-6 float-md-end mb-3 ms-md-3" alt="MouthPublicity.io" style="max-width: 200px;">

                                <p>With over 20 years of experience in several industries such as telecommunications, FMCG, textiles, newspapers, garments, electronics, and dairy, we have learned that the two most crucial factors in determining the success of any business are the quality of its products & services and effective branding strategies. These factors are especially vital in today's market, where marketing, branding, and customer acquisition are significant challenges to business owners.</p>
                                <p>Traditional marketing and advertising strategies often fall short when it comes to building brand awareness and customer trust. Word-of-mouth from satisfied customers can have a significant impact on business growth and reputation. However, many business owners struggle to leverage this powerful tool to achieve their marketing and branding goals.</p>
                                <p>To address this issue, we developed MouthPublicity.io - a platform that helps businesses to use the power of word-of-mouth to drive brand awareness and customer acquisition. With MouthPublicity.io, businesses can manage and track their mouth publicity, and engage with their target audience to build relationships and brand loyalty.</p>
                                <p>A strong product or service is essential to generate positive word-of-mouth through its customers. Our platform provides businesses with the tools and resources they need to create a compelling brand message, develop effective marketing strategies, and connect with their customers in meaningful ways.</p>
                                <p>We are committed to help businesses of all size achieve their marketing and branding goals by providing them with the tools and expertise they need to succeed in today's competitive market. Whether it's a startup or an established enterprise, MouthPublicity.io can help businesses to build a strong brand that stands out in a crowded marketplace.</p>
                                
                                {{-- <h5 class="font-800 color-primary">MISSION</h5>
                                <p>To help Business owners, entrepreneurs, and marketers of all sizes around India witness the power and maximize the utilization of digital mouth publicity media through social networks to grow and save on their marketing costs.</p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-color-gradient py-5">
        <div class="container-fluid">
            <div class="text-center text-white">
                <h3 class="font-800 mb-2 h1">When you don't have enough time or resources...</h3>
                <h4 class="font-700 mb-3">...sit back, relax and let us build your next campaign.</h4>
                <a href="{{url('signin')}}" class="btn btn-light btn-lg font-600 px-4">Let's Get Started</a>
            </div>
        </div>
    </div>

    <div class="py-5">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-8">
                    <div>
                        <h2 class="fw-bolder">We appreciate your interest in MouthPublicity.io!</h2>
                        <ul style="list-style: circle;" class="ps-3">
                            <li class="py-2">
                                <span class="mb-3">For General Inquiries, please contact us at <a href="mailto:care@openCchallenge.co.in" class="text-decoration-none color-lht fw-bolder">care@mouthpublicity.io</a>.</span>
                            </li>
                            <li class="py-2">
                                <span class="mb-5">For Pricing and plans check our <a href="{{url('pricing')}}" class="text-decoration-none color-lht fw-bolder">Pricing page</a>.</span>
                            </li>
                            {{--<li class="py-2">
                                <span class="mb-3">For help or guide, please check out our help page.</span>
                            </li>--}}
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <div class="why_img">
                            <img src="{{ asset('assets/front/images/home/y_should_go_for_opnlnk.svg') }}" alt="MouthPublicity.io">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

{{-- @push('end_body')

@endpush --}}