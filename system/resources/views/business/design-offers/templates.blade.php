@extends('layouts.business')
@section('title', 'Design Offer: Business Panel')
@section('head')
    @include('layouts.partials.headersection',['title'=>'Design Offer'])
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
        /* margin-bottom: 30px; */
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


    .custom-template{
        height: 100%;
        min-height: 300px;
        cursor: pointer;
    }
    .cus-tem-inner{
        position: relative;
        padding: 15px;
        width: calc(100% - 50px);
        height: calc(100% - 50px);
        top: 25px;
        /* left: 25px; */
        border: 1px dashed var(--secondary);
        border-radius: 6px;
        margin: auto;
        text-align: center;
        transition: all 300ms ease;
    }
    .cus-tem-inner .cus-body{
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .cus-tem-inner .title{
        transition: all 300ms ease;
        color: var(--dark);
    }
    .custom-template:hover .cus-tem-inner{
        border: 1px dashed var(--primary);
    }
    .custom-template:hover .cus-tem-inner .title{
        color: var(--primary);
    }
    .default.alert-info {
        color: #0c5460;
        background-color: #f4fbfc;
        border: 1px solid #99c5cc;
    }
</style>
@endsection


@section('content')

<section class="section">
<div class="section-body">


    <!-- ==================================== Template if Page type Template ================================== -->

    <div class="row">

        <div class="col-12">
            <div class="default alert alert-info mb-4">
                <p class="lh-1"><b>Select template according to your choice and customize it or you upload your own pre-designed image or Webpage URL.</b></p>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Template</h4>
                </div>
                
                @if($planData['is_paid'] != '')
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


                {{-- <form id="templateform" action="{{ route('business.templateUpdate') }}" method="post">
                    @csrf --}}
                    @if(count($templates) >= 1)
                    <div class="form-row">

                        {{-- custom template  --}}
                    	<div class="col-lg-4 col-sm-6 mb-3 show_all">
                    		<div class="template-card custom-template" onclick="location.href = '{{route('business.customOffer', ['offer_create_id' => rand()])}}';">
                                <div class="cus-tem-inner">
                                    <div class="cus-body">
                                        <h4 class="title">Custom</h4>
                                        <p class="text text-secondary mb-0">Create Offer by using single image or URL</p>
                                    </div>
                                </div>
                    		</div>
                    	</div>
                        {{-- custom template - END --}}
                    	
                        @foreach($templates as $template)

                        <div class="col-lg-4 col-sm-6 show_all mb-3 template_{{ $template->business_type }} {{ $template->template_type }}_template">

                            @php
                                if(app('request')->input('offer_id')){
                                    $offer_id = app('request')->input('offer_id');
                                    $action = app('request')->input('action');
                                    $customise =  route('business.offerCustomise',['id' => $template->id, 'action' => $action, 'offer_id' => $offer_id, 'offer_create_id' => rand()]);
                                    
                                }else{
                                    $customise =  route('business.offerCustomise', ['id' => $template->id, 'offer_create_id' => rand()]);
                                    
                                }
                                $preview =  route('business.templatePreview',$template->id);
                            @endphp

                            <div class="template-card">
                                <div class="tc-inner" id="{{ $customise }}">
                                    <div class="thumb" style="background-image: url({{url('assets/'.$template->thumbnail)}});"></div>
                                </div>
                                <div class="tc-buttons">
                                    <a href="{{ $preview }}" target="_blank" class="tc-view btn btn-outline-dark mr-2">Preview</a>
                                    <a href="{{ $customise }}" class="tc-custom btn btn-primary">Customise</a>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>

                    
                    {{-- @if(count($templates) > 5) --}}
                        {{-- no need above condition for free and paid users --}}
                        <div class="text-center mt-4">
                            {{ $templates->appends(request()->input())->links('vendor.pagination.bootstrap-4') }} 
                        </div> 
                    {{-- @endif --}}
                    
                    
                    @else
                    <div class="card">
                        <div class="card-body p-3">  
                            <div class="no_recored text-center">
                                <h3> {{ Config::get('constants.no_record_found') }}</h3>
                            </div>
                        </div>
                    </div>
                    @endif
                {{-- </form> --}}
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
        
        var edit_query_string = "{{ request()->get('action') }}";
        if(edit_query_string){
            var query_variable = "{{ request()->get('offer_id') }}";
            params += "&offer_id="+query_variable+"&action=edit";
        }
        params = params.substring(1);

        window.location.href = ENDPOINT + "/business/design-offer/templates?"+params;
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

        var edit_query_string = "{{ request()->get('action') }}";
        if(edit_query_string){
            var query_variable = "{{ request()->get('offer_id') }}";
            params += "&offer_id="+query_variable+"&action=edit";
        }
        params = params.substring(1);

        window.location.href = ENDPOINT + "/business/design-offer/templates?"+params;
    });
        
</script>
    @include('business.offers.future.js')

@endsection