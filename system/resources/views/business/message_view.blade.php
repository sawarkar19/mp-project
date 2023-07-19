@extends('layouts.business')
@section('title', 'View Notifications')

@section('head')
@include('layouts.partials.headersection', ['title'=>'Notification'] )
@endsection

@section('content')


<div class="row">
    <div class="col-lg-12">

      @if($notification)

        
        <div class="card" id="single_nitification">
            <div class="card-header py-3 justify-content-between" style="min-height: auto;">
              <p class="mb-0 text-primary">{{ $notification->created_at->diffForHumans() }}</p>
              <div>
                <a href="#" id="{{$notification->id}}" class="mark-deleted text-danger" data-toggle="tooltip" title="Delete Message"><i class="fas fa-trash m-0"></i></a>
              </div>
            </div>
            <div class="card-body">
              <div class="media">
                <div class="media-body">
                  <h5 class="mt-0 h6" style="font-size: 15px;">{!! $notification->subject !!}</h5>
                  <p class="mb-0" style="font-size: 13px;">{!! $notification->message !!}</p>
                </div>
              </div>
            </div>
        </div>

      @else

        <div class="card">
            <div class="card-body">
              <h3 style="padding:50px;text-align:center;clear: both;">{{ Config::get('constants.no_record_found') }}</h3>
            </div>
        </div>

      @endif

    </div>
</div>


@endsection

@section('end_body')
<script>
  $(document).on('click', '.mark-deleted', function($e){
    $e.preventDefault();

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var noti_id = $(this).attr('id');

    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.value) {
        var input = {
          "noti_id" : noti_id,
          "_token" : CSRF_TOKEN
        };
        $.ajax({
          url : '{{ route('business.markDeleted') }}',
          type : 'POST',
          data : input,
          dataType : "json",
          success : function(response) {
            window.location.replace("{{route('business.notifications')}}");
          }
        });
      }
    })
  });
</script>
@endsection