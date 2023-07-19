@extends('layouts.business')
@section('head')
    @include('layouts.partials.headersection', ['title'=>'Please Select Template'])
@endsection
@section('end_head')
<style>
    .ts_lable{
        position: relative;
        width: 100%;
    }
    .template_selection{
        position: relative;
        border-radius:5px;
        overflow:hidden;
        background-color:#F2F2F2;
        border-style: solid;
        border-width:2px;
        border-color:transparent;
        width: 100%;
    }
    .template_selection .thumb{
        position: relative;
        width: 100%;
        padding-bottom: 100%;
        background-color: #f2f2f2;
        background-size: cover;
        transition: all  1000ms ease;
    }
    .template_selection .thumb:hover{
        background-position: bottom center;
    }
    .action_list{
        list-style-type: none;
        padding: 0px !important;
    }
    .action_list li{
        display: inline;
    }

    .template-card{
        margin-bottom: 30px;
        box-shadow: 0px 4px 15px rgb(0 0 0 / 10%);
        border-radius: 4px;
        overflow: hidden;
    }
    .template-card .thumb{
        position: relative;
        width: 100%;
        padding-bottom: 100%;
        background-color: #f2f2f2;
        background-size: cover;
        transition: all  1000ms ease;
        cursor: pointer;
    }
    .template-card .thumb:hover{
        background-position: bottom center;
    }
    .template-card .tc-buttons{
        display: flex;
        position: relative;
        padding: 10px 10px;
        justify-content: space-between;
        box-shadow: -4px 0px 8px rgb(0 0 0 / 8%);
    }
    .template-card .tc-buttons a{
        width: 120px;
        max-width: 100%;
    }
</style>
@endsection


@section('content')

<section class="section">
<div class="section-body">


    <!-- ==================================== Template if Page type Template ================================== -->

    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Template</h4>
                </div>
                
                @if($userPlan != '')
                    <div class="col-md-12 mt-3">
                    
                        <div class="row justify-content-between">
                            <div class="col-md-5" style="float: left;">
                                <div class="from-group">
                                    <label>Business Type</label>
                                    <select class="form-control select2" name="business_type" id="business_type">
                                        <option value="all">All</option>
                                        @foreach($businesses as $business)
                                        <option value="{{$business->id}}" @if(isset($request_data['business_type_id']) && $request_data['business_type_id'] == $business->id) selected @endif>{{$business->name}}</option>
                                        @endforeach  
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5" style="display: inline-block;">
                                <div class="from-group">
                                    <label>Template Type</label>
                                    <select class="form-control select2" name="template_type" id="template_type">
                                        <option value="all">All</option>
                                        <option value="banner" @if(isset($request_data['template_type_id']) && $request_data['template_type_id'] == 'banner') selected @endif>Banner</option> 
                                        <option value="video" @if(isset($request_data['template_type_id']) && $request_data['template_type_id'] == 'video') selected @endif>Video</option>  
                                    </select>
                                </div>
                            </div>
                        </div>  
                            
                    </div>
                @endif
                
                <div class="card-body">


                    <form id="templateform" action="{{ route('business.templateUpdate') }}" method="post">
                    @csrf
                    
                    @if(count($templates) >= 1)
                    <div class="form-row">
                        @foreach($templates as $template)

                        <div class="col-lg-4 col-sm-6 show_all template_{{ $template->business_type }} {{ $template->template_type }}_template">
                            <div class="template-card">
                                <div class="tc-inner" id="{{ route('business.builder',$template->id.'?type='.$request_data['type']) }}">
                                    <div class="thumb" style="background-image: url({{url('assets/'.$template->thumbnail)}});"></div>
                                </div>
                                <div class="tc-buttons">
                                    <a href="{{ url('business/preview/'. $template->id) }}" target="_blank" class="tc-view btn btn-outline-dark mr-2">Preview</a>
                                    <a href="{{ url('business/builder/'. $template->id. '?type='.$request_data['type']) }}" class="tc-custom btn btn-primary">Customise</a>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>

                    @php

                        $url_params = array();
                        if(isset($request_data['type'])){
                            $url_params['type'] = $request_data['type'];
                        }

                        if(isset($request_data['business_type_id'])){
                            $url_params['business_type_id'] = $request_data['business_type_id'];
                        }

                        if(isset($request_data['template_type_id'])){
                            $url_params['template_type_id'] = $request_data['template_type_id'];
                        }

                    @endphp
                    @if($userPlan != '')
                        {{ $templates->appends($url_params)->links('vendor.pagination.bootstrap-4') }}  
                    @endif
                    
                    @else
                    <div class="card">
                        <div class="card-body p-3">  
                            <h3 style="padding:50px;text-align:center;clear: both;">{{ Config::get('constants.no_record_found') }}</h3>
                        </div>
                    </div>
                    @endif
                </form>
                </div>
            </div>
        </div>


    </div>


    <!-- ======================================================================== -->

</div>
</section>


@endsection
@section('end_body')
<script>

    /*filter template*/
    $( "body" ).delegate( "#business_type", "change", function() {
        var business_type_id = $(this).val();
        var template_type_id = $('#template_type').val();
        var ENDPOINT = "{{ url('/') }}";

        var params = '';
        if(business_type_id != 'all'){
            params += '&business_type_id='+ business_type_id;
        }

        if(template_type_id != 'all'){
            params += '&template_type_id='+ template_type_id;
        }

        window.location.href = ENDPOINT + "/business/offer/future/template?type=" + '{{ $request_data['type'] }}'+params;
    });

    $( "body" ).delegate( "#template_type", "change", function() {
        var template_type_id = $(this).val();
        var business_type_id = $('#business_type').val();
        var ENDPOINT = "{{ url('/') }}";

        var params = '';
        if(business_type_id != 'all'){
            params += '&business_type_id='+ business_type_id;
        }

        if(template_type_id != 'all'){
            params += '&template_type_id='+ template_type_id;
        }

        window.location.href = ENDPOINT + "/business/offer/future/template?type=" + '{{ $request_data['type'] }}'+params;
    });
        
</script>
    @include('business.offers.future.js')
@endsection