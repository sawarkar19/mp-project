@extends('layouts.business')

@section('head') @include('layouts.partials.headersection',['title'=>'Maintenance mode']) @endsection

@section('end_head')

@endsection

@section('content')
<section class="section">
    <div class="section-body">
        
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    {{-- <div class="card-header">
                      <h4>Whoops</h4>
                    </div> --}}
                    <div class="card-body">
                      <div class="empty-state p-0 pb-5" data-height_="600" style="height_: 600px;">
                        <img class="img-fluid" style="max-width: 350px;" src="{{asset('assets/img/drawkit/drawkit-full-stack-man-colour.svg')}}" alt="image">
                        <h2 class="mt-0">We can't reach the server</h2>
                        <p class="lead">
                          We were unable to reach the server, it seemed like it was sleeping, so we were reluctant to wake it up.
                        </p>
                        {{-- <a href="#" class="btn btn-warning mt-4">Try Again</a> --}}
                      </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection

@section('end_body')

@endsection