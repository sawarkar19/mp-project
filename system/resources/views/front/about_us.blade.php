@extends('layouts.front')

@section('title', 'About Us - MouthPublicity.io')
@section('description', 'MouthPublicity.io powers word-of-mouth marketing campaigns for businesses of all shapes and sizes. Try it for free today!')
@section('keywords', 'why MouthPublicity.io, what is MouthPublicity.io, mission of MouthPublicity.io, about us MouthPublicity.io')
{{-- @section('image', '') --}}

@section('end_head')
    {{-- //  --}}
@endsection

@section('content')
<section id="header-banner">
    <div class="py-5 pb-0">
        <div class="container">
            <div class="mb-5 mb-xl-0">
                <a href="{{url('')}}">
					<img src="{{ asset('assets/front/images/logo-dark.svg') }}" class="main_logo" alt="MouthPublicity.io">
				</a>
            </div>

            <div class="flex-banner py-5">
                <div class="d-block">
                    <div class="row justify-content-center">
                        <div class="col-lg-12 mb-5 mb-lg-0">
                           	<div class="clearfix">
								<h1 class="fw-bold oplk-text-gradient d-inline-block py-4" style="font-size: 60px;">What is <br> MouthPublicity.io?</h1>
                           	    <img src="{{ asset('assets/front/images/about-mobile.svg') }}" class="banner-image col-md-6 float-md-end mb-3 ms-md-3" alt="MouthPublicity.io" style="max-width: 200px;">

								<p>MouthPublicity.io aims to be the most powerful mouth publicity marketing application for businesses and enterprises of any size powered by Logic Innovates. MouthPublicity.io has been developed as the premier application to provide your customer billing updates on WhatsApp, provide automatic customer greeting service, boost your brand reach by your existing customers, and provide them with structured benefits for growing your social media presence and referring your business to their network. </p>
								<p>Over time, it's more clear that every business spends a lot in their Billing communication on SMS Packs & even struggles to boost their brand to their targeted customer and grow their social media presence. Even with time SMS API, online advertising, paid marketing and SEO have also become far more expensive. The best solution to such a problem is MouthPublicity.io</p>
								<p>That's built with one clear, concise goal: To build a powerful mouth publicity marketing tool that any size of business can use to boost their customer base and of course, increase sales.</p>
								
                                <h5 class="fw-bolder">MISSION</h5>
								<p>To help Business owners, entrepreneurs, and marketers of all sizes around India witness the power and maximize the utilization of digital mouth publicity media through social networks to grow and save on their marketing costs.</p>
							</div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</section>

<section class="">
	<div class="oplk-bg-color-gradient py-5">
		<div class="container-fluid">
			<div class="text-center text-white">
				<h1 class="fw-bold mb-2">When you don't have enough time or resources...</h1>
				<h4 class="mb-2">...sit back, relax and let us build your next campaign.</h4>
				<a href="{{url('signin')}}" class="btn bg-white btn-lg font-500">Let's Get Started</a>
			</div>
		</div>
	</div>
</section>

<section class="py-5 my-lg-3">
	<div class="container">
		<div class="row justify-content-between align-items-center">
			<div class="col-md-8">
				<div>
					<h2 class="fw-bolder">We appreciate your interest in MouthPublicity.io!</h2>
					<ul style="list-style: circle;" class="ps-3">
						<li class="py-2">
							<span class="mb-3">For General Inquiries, please contact us at <a href="mailto:care@mouthpublicity.io" class="text-decoration-none color-lht fw-bolder">care@mouthpublicity.io</a>.</span>
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
</section>
@endsection