@extends('layouts.admin')
@section('title', 'Admin: Vcards List')
@section('head')
@include('layouts.partials.headersection',['title'=>'Vcards List'])
@endsection
@section('content')
<div class="row">
    <div class="col-12 mt-2">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-8"> <a href="{{ route('admin.vcards.index') }}"
                            class="mr-2 btn btn-outline-primary @if($status===" all ") active @endif">{{ __('All') }}
                            ({{ $all }})</a>
                        <a href="{{ route('admin.vcards.index','status=1') }}"
                            class="mr-2 btn btn-outline-success @if($status==1) active @endif">{{ __('Active') }}
                            ({{ $actives }})</a>
                        <a href="{{ route('admin.vcards.index','status=0') }}"
                            class="mr-2 btn btn-outline-warning @if($status==0) active @endif">{{ __('Inactive') }}
                            ({{ $inactives }})</a>
                    </div>
                    <div class="col-sm-4 text-right">
                        <a href="{{ route('admin.vcards.create') }}"
                            class="btn btn-primary">{{ __('Create Vcard') }}</a>
                    </div>
                </div>

                
                <form method="post" action="{{ route('admin.vcards.destroys') }}" id="actionForm">
                    @csrf
                    <div class="float-left mb-1">
                        <div class="input-group">
                            <select class="form-control selectric" name="type">
                                <option selected="" disabled="">{{ __('Select Action') }}</option>
                                <option value="1">{{ __('Status To Active') }}</option>
                                <option value="0">{{ __('Status To Inactive') }}</option>
                                <option value="delete">{{ __('Delete Selected') }}</option>
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-primary basicbtn" type="submit">{{ __('Submit') }}</button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        @if (count($vcards) >= 1)
                            
                        
                        <table class="table table-striped table-hover text-center table-borderless">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" class="checkAll">
                                    </th>
                                    <th>{{ __('Thumbnails') }}</th>
                                    <th>{{ __('Deafult Card') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vcards as $card)
                                <tr id="row{{ $card->id }}">
                                    <td>
                                        <input type="checkbox" name="ids[]" value="{{ $card->id }}">
                                    </td>
                                    <td> <img src="{{asset('assets/business/vcards/' .$card->thumbnail) }}" style="max-height: 100px" class="img-fluid border" id="main_img_preview" alt=""></td>
                                    <td>
                                        @if($card->default_card==1) <span
                                            class="badge badge-success">{{ __('Yes') }}</span>
                                        @elseif($card->default_card==0) <span
                                            class="badge badge-danger">{{ __('No') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($card->status==1) <span
                                            class="badge badge-success">{{ __('Active') }}</span>
                                        @elseif($card->status==0) <span
                                            class="badge badge-danger">{{ __('Inactive') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-primary has-icon"
                                            onclick="window.location.href = '{{ route('admin.vcards.edit',$card->id) }}'"
                                            type="button"> <i class="fas fa-edit"></i> {{ __('Edit') }}
                                        </button>
                                        {{--  <button class="btn btn-success has-icon"
                                            onclick="window.location.href = '{{ route('admin.templates.show',$temp->id) }}'"
                                            type="button"> <i class="fas fa-eye"></i> {{ __('View') }}
                                        </button>  --}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                        @else
                        <div class="card-body">
                            <h3>{{ Config::get('constants.no_record_found') }}</h3>
                        </div>
                        @endif
                    </div>
                </form>
                {{ $vcards->appends($request->all())->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('end_body')
<script src="{{ asset('assets/js/form.js') }}"></script>
<script>

$("#actionForm").on('submit', function(e){
		e.preventDefault();
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		var basicbtnhtml=$('.basicbtn').html();
		$.ajax({
			type: 'POST',
			url: this.action,
			data: new FormData(this),
			dataType: 'json',
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function() {
				
				$('.basicbtn').html("Please Wait....");
				$('.basicbtn').attr('disabled','')

			},
			
			success: function(response){ 
				$('.basicbtn').removeAttr('disabled')

                if(response.status == true){
                    Sweet('success',response.message);
                }else{
                    Sweet('error',response.message);
                }
				
				$('.basicbtn').html(basicbtnhtml);
				location.reload();
			},
			error: function(xhr, status, error) 
			{
				$('.basicbtn').html(basicbtnhtml);
				$('.basicbtn').removeAttr('disabled')
				$('.errorarea').show();
				$.each(xhr.responseJSON.errors, function (key, item) 
				{
					Sweet('error',item)
					$("#errors").html("<li class='text-danger'>"+item+"</li>")
				});
				errosresponse(xhr, status, error);
			}
		})


	});

    function success(res) {
        setTimeout(function() {
            window.location.href = '{{ route('admin.vcards.index') }}';
        }, 2000);
    }

    function error(res) {
        console.log(res);
    }
</script>
@endsection