@extends('layouts.seo')

@section('head')
    @include('layouts.partials.headersection', ['title' => 'User Activity'])
@endsection

@section('end_head')
    <style>
        .card.card-hero .userBg1 {
            background: #D3FFDB !important;
            border: none;
        }

        .card.card-hero .userBg2 {
            background: #fdf4c4 !important;
            border: none;
        }

        .card.card-hero .userBg3 {
            background: #E5E5FF !important;
            border: none;
        }

        .card.card-hero .userBg4 {
            background: #FFF6F4 !important;
            border: none;
        }

        .card.card-hero .userBg1.card-header h4,
        .card.card-hero .userBg2.card-header h4,
        .card.card-hero .userBg3.card-header h4 {
            font-size: 35px !important;
        }

        .card.card-hero .userBg1 h4,
        .card.card-hero .userBg2 h4,
        .card.card-hero .userBg3 h4,
        .card.card-hero .userBg4 h4,
        .card.card-hero .card-description {
            color: #34395e;
        }

        .card.card-hero .userBg1 .card-icon {
            color: #b7edc0;
        }

        .card.card-hero .userBg2 .card-icon {
            color: #fff1a8;
        }

        .card.card-hero .userBg3 .card-icon {
            color: #d0d0ef;
        }

        .card.card-hero .userBg4 .card-icon {
            color: #ffe2df;
        }

        .userChartHead {
            position: absolute;
            left: 50%;
            transform: translate(-50%, 0);
            font-size: 80px;
            bottom: 0;
        }
        .width-30{
            display: inline-block;
            width: 30%;
        }
    </style>
@endsection

@section('content')
    <section class="section">

        <div class="section-body">
         
            <div class="col-12 col-md-12 col-lg-12 col-xl-12">

                <div class="card">
                    <div class="card-header">
                      User Details
                    </div>
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item"><span class="width-30"><b>Name: </b></span>{{ $user->name }}</li>
                      <li class="list-group-item"><span class="width-30"><b>Email: </b></span>{{ $user->email }}</li>
                      <li class="list-group-item"><span class="width-30"><b>Mobile No: </b></span>{{ $user->mobile }}</li>
                      <li class="list-group-item"><span class="width-30"><b>Status: </b></span>@if($user->is_paid == 1) <span class="badge badge-success">Paid</span> @else <span class="badge badge-warning">Free</span> @endif</li>
                      <li class="list-group-item"><span class="width-30"><b>Account Balance: </b></span><span class="badge badge-primary">{{ $balance->wallet_balance }}</span></li>

                    </ul>
                </div>

                <div class="card">
                    <div class="card-header">
                      Social Connections
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><span class="width-30"><b>Facebook: </b></span>@if($socialConnections->is_facebook_auth == 1) <span class="badge badge-success">Connected</span> @else <span class="badge badge-warning">Not Connected</span> @endif</li>
                        <li class="list-group-item"><span class="width-30"><b>Twitter: </b></span>@if($socialConnections->is_twitter_auth == 1) <span class="badge badge-success">Connected</span> @else <span class="badge badge-warning">Not Connected</span> @endif</li>
                        <li class="list-group-item"><span class="width-30"><b>Instagram: </b></span>@if($socialConnections->is_instagram_auth == 1) <span class="badge badge-success">Connected</span> @else <span class="badge badge-warning">Not Connected</span> @endif</li>
                        <li class="list-group-item"><span class="width-30"><b>Youtube: </b></span>@if($socialConnections->is_youtube_auth == 1) <span class="badge badge-success">Connected</span> @else <span class="badge badge-warning">Not Connected</span> @endif</li>
                        <li class="list-group-item"><span class="width-30"><b>Google: </b></span>@if($socialConnections->is_google_auth == 1) <span class="badge badge-success">Connected</span> @else <span class="badge badge-warning">Not Connected</span> @endif</li>
                        <li class="list-group-item"><span class="width-30"><b>Linkedin: </b></span>@if($socialConnections->is_linkedin_auth == 1) <span class="badge badge-success">Connected</span> @else <span class="badge badge-warning">Not Connected</span> @endif</li>
                    </ul>
                </div>

                <div class="card">
                    <div class="card-header">
                      Challenge Settings
                    </div>
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item"><span class="width-30"><b>Instant Challenge: </b></span>@if($instantChallengeSetting != null) <span class="badge badge-success">Done</span> @else <span class="badge badge-warning">Pending</span> @endif</li>

                      <li class="list-group-item"><span class="width-30"><b>Share Challenge: </b></span>@if($shareChallengeSetting != null) <span class="badge badge-success">Done</span> @else <span class="badge badge-warning">Pending</span> @endif</li>

                    </ul>
                </div>

                <div class="card">
                    <div class="card-header">
                        Current Offer Details
                    </div>
                    <ul class="list-group list-group-flush">

                        @if($currentOffer != null)
                            <li class="list-group-item"><span class="width-30"><b>Title: </b></span> {{ $currentOffer->title }}</li>
                        @else
                            <li class="list-group-item">Does not have offer running.</li>
                        @endif

                    </ul>
                </div>

                <div class="card">
                    <div class="card-header">
                        Upcoming Offer Details
                    </div>
                    <ul class="list-group list-group-flush">

                        @if(count($comingOffers) > 0)
                            @foreach($comingOffers as $offer)
                                <li class="list-group-item"><span class="width-30"><b>{{ $loop->iteration }}. Title: </b></span> {{ $offer->title }}</li>
                            @endforeach
                        @else
                            <li class="list-group-item">Does not have upcoming offers.</li>
                        @endif

                    </ul>
                </div>
            
            </div>

        </div>
    </section>
@endsection

@section('end_body')
@endsection
