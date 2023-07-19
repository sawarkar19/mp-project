@extends('layouts.business')

@section('title', 'D2C Posts Details: Business Panel')

@section('head')
    @include('layouts.partials.headersection', ['title'=>'D2C Posts Details'])
@endsection
@section('end_head')
<style>
    .conversation {
        /* height: calc(100% - 12px); */
        position: relative;
        background-color: #edebe6;
        z-index: 0;
        overflow: hidden;
        border-radius: 10px;
    }
    .conversation .conversation-container {
        padding: 0 16px;
    }
    .conversation .conversation-container:after {
        content: "";
        display: table;
        clear: both;
    }
    /* Messages */
    .message {
        color: #000;
        clear: both;
        line-height: 18px;
        font-size: 15px;
        padding: 8px;
        position: relative;
        margin: 8px 0;
        max-width: 85%;
        word-wrap: break-word;
        z-index: -1;
    }
    .message:after {
        position: absolute;
        content: "";
        width: 0;
        height: 0;
        border-style: solid;
    }
    .metadata {
        display: inline-block;
        float: right;
        padding: 0 0 0 7px;
        position: relative;
        bottom: -4px;
    }
    .metadata .time {
        color: rgba(0, 0, 0, .45);
        font-size: 11px;
        display: inline-block;
    }
    .metadata .tick {
        display: inline-block;
        margin-left: 2px;
        position: relative;
        top: 4px;
        height: 16px;
        width: 16px;
    }
    .metadata .tick svg {
        position: absolute;
        transition: .5s ease-in-out;
    }
    .metadata .tick svg:first-child {
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        -webkit-transform: perspective(800px) rotateY(180deg);
        transform: perspective(800px) rotateY(180deg);
    }
    .metadata .tick svg:last-child {
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        -webkit-transform: perspective(800px) rotateY(0deg);
        transform: perspective(800px) rotateY(0deg);
    }
    .message.sent {
        background: #e1ffc7;
        border-radius: 5px 5px 0px 5px;
        float: right;
    }
    .message.sent:after {
        border-width: 0px 0 10px 10px;
        border-color: transparent transparent transparent #e1ffc7;
        bottom: 0;
        right: -10px;
    }
</style>
@endsection
@section('content')
<section class="section">
    <div class="section-body">
        
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card h-100 mb-0">
                    <div class="card-header">
                        <h4>Details</h4>
                    </div>
                    @php
                        if($wq_post->shared_to != ''){
                            $shared_to_cust = explode(',',$wq_post->shared_to);
                            $shared_to = count($shared_to_cust);
                        }else{
                            $shared_to = 0;
                        }

                        if($wq_post->delivered_to != ''){
                            $delivered_to = $wq_post->delivered_to;
                        }else{
                            $delivered_to = 0;
                        }

                        if($wq_post->failed_to != ''){
                            $failed_to = $wq_post->failed_to;
                        }else{
                            $failed_to = 0;
                        }
                    @endphp
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <tr>
                                    <th>Shared Date</th>
                                    <td>{{ date('d M Y',strtotime($wq_post->schedule_date))  }}</td>
                                </tr>
                                <tr>
                                    <th>Shared Time</th>
                                    <td>{{ date('h:i A',strtotime($wq_post->schedule_date)) }}</td>
                                </tr>
                                <tr>
                                    <th>Total Customers</th>
                                    <td>{{ $shared_to }}</td>
                                </tr>
                                <tr>
                                    <th>Delivered</th>
                                    <td>{{ $delivered_to }}</td>
                                </tr>
                                <tr>
                                    <th>Failed</th>
                                    <td>{{ $failed_to }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            {{-- POST PREVIEW --}}
            <div class="col-md-6  mb-4">
                <div class="card h-100 mb-0">
                    <div class="card-header">
                        <h4>Post Content</h4>
                    </div>
                    <div class="card-body">
                        
                        @php
                        
                        $scheduled_post_media = '';
                        $scheduled_post_media_url = isset($wq_post->attachment_url) ? $wq_post->attachment_url : '';
                        
                        if(isset($wq_post->is_media_deleted) && ($wq_post->is_media_deleted > 0)){
                        
                            $is_media_deleted = $wq_post->is_media_deleted;
                            if($is_media_deleted==1){
                                $scheduled_post_media_url = asset('assets/whatsapp/no_image_available.jpg');
                                $scheduled_post_media = '<img class="img-fluid" src="'.$scheduled_post_media_url.'" />';
                            }else if($is_media_deleted==2){
                                $scheduled_post_media_url = asset('assets/whatsapp/no_video_available.jpg');
                                $scheduled_post_media = '<img class="img-fluid" src="'.$scheduled_post_media_url.'" />';
                            }
                            
                        }else if(!empty($scheduled_post_media_url)){
                            $extension = pathinfo($scheduled_post_media_url, PATHINFO_EXTENSION);
                            if($extension == 'mp4'){
                                $scheduled_post_media = '<video class="img-fluid" controls="controls"  src="'.$scheduled_post_media_url.'" />';
                            }else if($extension == 'jpg' || $extension == 'jpeg'){
                                $scheduled_post_media = '<img class="img-fluid" src="'.$scheduled_post_media_url.'" />';
                            }
                        }
                        
                        @endphp

                        <div class="conversation">
                            <div class="conversation-container pt-5 pb-3 rounded">
                                <div class="message sent">
                                    <div id="scheduled_post_media" class="media-section">{!! $scheduled_post_media !!}</div>
                                    <span>{!! $wq_post->content !!}</span>
                                    <span class="metadata">
                                        <span class="time"></span>
                                        <span class="tick"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" id="msg-dblcheck-ack" x="2063" y="2076"><path d="M15.01 3.316l-.478-.372a.365.365 0 0 0-.51.063L8.666 9.88a.32.32 0 0 1-.484.032l-.358-.325a.32.32 0 0 0-.484.032l-.378.48a.418.418 0 0 0 .036.54l1.32 1.267a.32.32 0 0 0 .484-.034l6.272-8.048a.366.366 0 0 0-.064-.512zm-4.1 0l-.478-.372a.365.365 0 0 0-.51.063L4.566 9.88a.32.32 0 0 1-.484.032L1.892 7.77a.366.366 0 0 0-.516.005l-.423.433a.364.364 0 0 0 .006.514l3.255 3.185a.32.32 0 0 0 .484-.033l6.272-8.048a.365.365 0 0 0-.063-.51z" fill="#4fc3f7"/></svg></span>
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            {{-- List of total customers  --}}
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>List Of Customers </h4>
                        <div class="card-header-form">
                            <form class="card-header-form">
                            @csrf
                            <div class="d-flex">
                                <input type="text" name="search" class="form-control" placeholder="Search Number..." value="{{ $search }}" >
                                <button class="btn btn-primary btn-icon" type="submit"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        @if(count($customers) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped mb-0" >
                                <thead>
                                    <tr>
                                        <th>Sr.No.</th>
                                        <th>Name</th>
                                        <th>Number</th>
                                        <th>Birth Date</th>
                                        <th>Anniversary Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customers as $customer)
                                    <tr>
                                        <td>{{ $customers->firstItem() + $loop->index }}</td>
                                        <td>
                                            @if(!empty($customer->details) && $customer->details[0]->name != '')
                                                {{ $customer->details[0]->name }}
                                            @else
                                                Customer
                                            @endif
                                        </td>
                                        <td>{{ $customer->mobile }}</td>
                                        <td>
                                            @if(!empty($customer->details) && $customer->details[0]->dob != '')
                                                @if($customer->details[0]->dob != '0000-00-00')
                                                    @php
                                                        $dob = date("d M Y", strtotime($customer->details[0]->dob));
                                                    @endphp
    
                                                    {{ $dob }}
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($customer->details) && $customer->details[0]->anniversary_date != '')
                                                @if($customer->details[0]->anniversary_date != '0000-00-00')
                                                    @php
                                                        $anniversary_date = date("d M Y", strtotime($customer->details[0]->anniversary_date));
                                                    @endphp
    
                                                    {{ $anniversary_date }}
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                            <h2 class="text-center p-3">No records found</h2>
                        @endif
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>
@endsection

@section('end_body')

@endsection