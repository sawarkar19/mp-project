@extends('layouts.business')
@section('title', 'Resize Image: Business Panel')
@section('head')
    @include('layouts.partials.headersection',['title'=>'Resize Image'])
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <form method="post" action="{{ route('business.resizeImage') }}" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4>Promotions Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-row align-items-center">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Resize Image</label>
                                    <input type="file" name="file" class="form-control">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection