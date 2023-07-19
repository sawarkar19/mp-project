@extends('layouts.business')

@section('title', 'Social Post: Business Panel')

@section('head')
    @include('layouts.partials.headersection', ['title'=>'Social Post'])
@endsection

@section('end_head')
<style>
    .btn_wrap {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        /* cursor: pointer; */
        width: 130px;
        height: 35px;
        /* background-color: #EEEEED; */
        border-radius: 80px;
        padding: 0 18px;
        will-change: transform;
        -webkit-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
    }
    /* .btn_wrap:hover {
        transform: scale(1.1)
    } */
    .btn_wrap span {
       position: absolute;
       z-index: 99;
       width: 240px;
       height: 35px;
       line-height: 35px;
       border-radius: 40px;
       font-size: 16px;
       text-align: center;
       color: #fff;
       background-color: var(--primary);
       padding: 0 18px;
       -webkit-transition: all 600ms ease;
       transition: all 600ms ease;
    }
    .btn_wrap:hover span {
        /* transition-delay: .25s; */
        transform: translateX(-280px)
    }
    
    .social_Box {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 240px;
        height: 35px;
        border-radius: 40px;
    }
    .social_Box a{
        margin: 0px 4px;
        text-align: center;

        position: relative;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: var(--cl-prime);
        color: #fff;

        opacity: 0;
        
        -webkit-transform: scale(.1);
        transform: scale(.1);
        -webkit-transition: all .2s ease;
        transition: all .3s ease;
    }
    .btn_wrap:hover .social_Box > a {
        opacity: 1;
        transform: scale(1);
    }

    /*social media share 2*/
    .social_Box a > i {
        line-height: 31px;
        margin-left: 0px!important;
        font-size: 15px;
    }
    .social_Box a:nth-child(1) {
        transition-delay: 300ms;
        background-color: #00acee;
    }
    .social_Box a:nth-child(2) {
        transition-delay: 500ms;
        background-color: #4267B2;
    }
    .social_Box a:nth-child(3) {
        transition-delay: 700ms;
        background-color: #0e76a8;
    }
    /*social media share */


    .clicks-data{
        position: relative;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;

        width: 100%;
        padding: 5px 10px 5px 5px;
        background-color: #f6f6f6;
        border-radius: 30px;
    }
    .clicks-data .ico-sp{
        display: inline-block;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        text-align: center;
        background-color: #000;
    }
    .clicks-data i{
        line-height: 22px;
        color: #FFF;
    }
    .clicks-data p{
        line-height: 1;
        text-align: center;
        font-size: 11px;
    }
    .clicks-data .ico-sp.fb{
        background-color: #4267B2;
    }
    .clicks-data .ico-sp.tw{
        background-color: #00acee;
    }
    .clicks-data .ico-sp.ln{
        background-color: #0e76a8;
    }

    .action_button .btn{
        border-radius: 50%;
        width: 30px;
        height: 30px;
        text-align: center;
        /* border: 0px; */
    }
    .action_button .btn i{
        line-height: 25px;
    }
    .default-tag.draft-tag{
        background-color: #ffc107 !important;
    }
</style>
@endsection



@section('content')
<section class="section">

    <div class="mb-4">	
        <div class="row align-item-center">
            <div class="col-sm-8 mb-4 mb-sm-0">
                <a href="{{ route('business.socialPosts','post_type=all') }}" class="mr-2 my-1 btn btn-sm btn-outline-primary">{{ __('All') }} ({{ $post_count }})</a>
                <a href="{{ route('business.socialPosts','post_type=publish') }}" class="mr-2 my-1 btn btn-sm btn-outline-primary">{{ __('Published') }} ({{ $active_count }})</a>
                <a href="{{ route('business.socialPosts','post_type=draft') }}" class="mr-2 my-1 btn btn-sm btn-outline-warning">{{ __('Draft') }} ({{ $draft_count }})</a>
            </div>			
            <div class="col-sm-4 text-right">
                <a href="{{ route('business.socialPostsCreate') }}" class="btn btn-primary btn-lg">
                   Create Post
                </a>
            </div>
        </div>
    </div>


    @if(count($posts) >= 1)
    <div class="row">

        @php $i=1; @endphp 
        @foreach ($posts as $post) 
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <article class="article article-style-c h-100 mb-0">
                <div class="article-header">
                    @if ($post->image)
                    <div class="article-image" data-background="{{asset('assets/socialposts/'.$post->image)}}"></div>
                    @else
                    <div class="article-image" data-background="{{asset('assets/img/news/img11.jpg')}}"></div>
                    @endif

                    @if($post->status == '1')
                        <div class="default-tag">Active</div>
                    @else
                        <div class="default-tag draft-tag">Draft</div>
                    @endif
                    
                </div>
                <div class="article-details">
                    <div class="article-title">
                        <h5 class="h6 text-primary" style="line-height: 1.5">{{$post->title}}</h5>
                    </div>
                    <div class="my-4">
                        <div class="clicks-data">
                            <span class="ico-sp mr-1 fb"><i class="fab fa-facebook"></i></span>
                            <p class="mb-0"><span class="font-weight-bold">{{$post->facebook_count}}</span> <small>Unique Clicks</small></p>
                            <p class="mb-0"><span class="font-weight-bold">{{$post->facebook_extra_count}}</span> <small>Extra clicks</small></p>
                        </div>
                        <div class="clicks-data"> 
                            <span class="ico-sp mr-1 tw"><i class="fab fa-twitter"></i></span>
                            <p class="mb-0"><span class="font-weight-bold">{{$post->twitter_count}}</span> <small>Unique Clicks</small></p>
                            <p class="mb-0"><span class="font-weight-bold">{{$post->twitter_extra_count}}</span> <small>Extra clicks</small></p>
                        </div>
                        <div class="clicks-data">
                            <span class="ico-sp mr-1 ln"><i class="fab fa-linkedin"></i></span>
                            <p class="mb-0 px-1"><span class="font-weight-bold">{{$post->linkedin_count}}</span> <small>Unique Clicks</small></p>
                            <p class="mb-0 pl-1"><span class="font-weight-bold">{{$post->linkedin_extra_count}}</span> <small>Extra clicks</small></p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn_wrap">
                            @if($post->status == '1')
                                <span>Post</span>
                                <div class="social_Box">
                                    <a href="https://www.twitter.com/intent/tweet?url={{url('sp/'.$post->uuid.'?media=twitter')}}" target="_blank"><i class="fab fa-twitter socialImg"></i></a>
                                    <a href="https://www.facebook.com/sharer.php?u={{url('sp/'.$post->uuid.'?media=facebook')}}" target="_blank"><i class="fab fa-facebook socialImg"></i></a>
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{url('sp/'.$post->uuid.'?media%3Dlinkedin')}}" target="_blank"><i class="fab fa-linkedin socialImg"></i></a>
                                </div>
                            @endif
                            
                        </div>
                        <div class="ml-2 action_button">        
                            <a href="{{ route('business.socialPostsEdit', $post->id) }}" class="btn btn-sm btn-outline-warning" data-toggle="tooltip" title="Edit Post"> <i class="far fa-edit"></i></a>  
                            <a href="{{url('sp/'.$post->uuid)}}" target="_blank" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" title="Preview"><i class="far fa-eye"></i></a>
                        </div>
                    </div>
                </div>
            </article>
        </div>
        @php $i++; @endphp 
        @endforeach
    </div>
    @else
    <div class="card">
        <div class="card-body">
            <div class="text-center py-5 px-3">
                <h5>{{ Config::get('constants.no_record_found') }}</h5>
            </div>
        </div>
    </div>
    @endif

</section>
@endsection

@section('end_body')

@endsection