@extends('layouts.website')

@section('title', '')
@section('description', '')
@section('keywords', '')
{{-- @section('image', '') --}}

@section('end_head')
<style>
    .heading,
    .video{
        position: relative;
        width: 100%;
        max-width: 720px;
        margin-left: auto;
        margin-right: auto;
    }
</style>
@endsection

@section('content')
    <section>
        <div class="container">
            <div class="py-5">

                

                <div class="video mb-4">
                    <div id="player"></div>
                    {{-- <iframe src="https://www.youtube.com/embed/ACF6_JFgZm8?controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> --}}
                </div>

                <div class="heading text-center mb-4">
                    <h1 class="font-600 color-primary h2">Introducing the first ever mouth publicity management tool for your business - MouthPublicity.io</h1>
                    {{-- <p>Atque, ipsam itaque! Sapiente, neque laboriosam? Esse molestias distinctio quae impedit?</p> --}}
                </div>

                <div class="text-center">
                    <a href="{{url('signin?tab=register')}}" class="btn btn-primary-ol btn-lg px-4">Register for Free now</a>
                </div>

            </div>
        </div>
    </section>
@endsection

@push('end_body')


<script>
    // 1. get height and width of window
    var winWidth = $('.video').width();
    var setVidHeight =  (winWidth / 100) * 57;

    // var video_id = 'xIN7W55-j3s';
    var video_id = 'V0fs0nNLbcs';

    // 2. This code loads the IFrame Player API code asynchronously.
    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    // 3. This function creates an <iframe> (and YouTube player)
    //    after the API code downloads.
    var player;
    function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
            // width: winWidth,
            // height: setVidHeight,
            videoId: video_id,
            playerVars: {
                'rel':0,
                'showinfo':0,
                'playsinline': 1,
                'fs':0,
            },
            events: {
                'onReady': onPlayerReady,
            }
        });
    }

    // 4. The API will call this function when the video player is ready.
    function onPlayerReady(event) {
        // event.target.playVideo();
        $('iframe#player').width(winWidth).height(setVidHeight);
    }

    // $(document).ready(function() {
    //     $('iframe#player').width(winWidth).height(setVidHeight);
    // })
</script>
@endpush