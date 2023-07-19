@extends('layouts.business')
@section('title', 'Contact Groups: Business Panel')
@section('end_head')
	<style>.dropdown-item{cursor:pointer;}</style>
@endsection
@section('head')
@include('layouts.partials.headersection',['title'=>'Edit Contact Groups'])
@endsection
@section('content')
<section>
	<div class="section">
        <div class="row">
            <div class="col-md-6 offset-md-3">
        		<div class="card">
                    <div class="card-header">
                        <h4>{{ __('Edit Group Name') }}</h4>
                                
                      </div>
        			<div class="card-body">
        				
                        <form class="basicform" id="groupform" action="{{ route('business.updateGroup',$group->id) }}" method="post">
                            @csrf
                                <div id="front_page">
                                    <div class="row">
            
                                        <div class="form-group col-12">
                                            <label for="name">{{ __('Enter Group Name') }}</label>
                                            <div class="input-group">
                                              <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                  <i class="fas fa-users"></i>
                                                </div>
                                              </div>
                                              <input id="name" type="text" class="form-control two-space-validation char-spcs-validation" value="{{ old('name', $group->name) }}" name="name">
                                            </div>
                                            

                                            @error('name')
                                                <span class="alert alert-danger p-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                
                                    </div>
                      
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary btn-lg" value="Save" >
                                </div>
                        </form>
        			
        		    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('js')
    <script>

        $(document).ajaxSend(function() {
            $("#overlay").fadeIn(300);　
        });

        $("#groupform").on('submit', function(e){
            e.preventDefault();
            
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
                    
                    if(response.status == true){
                        Sweet('success',response.message);
                        setTimeout(() => {
                            window.location.href = response.redirect_url;
                        }, 1200);
                        
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

    </script>
@endpush
@section('end_body')
@endsection