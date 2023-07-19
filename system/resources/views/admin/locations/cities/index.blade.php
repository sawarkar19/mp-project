@extends('layouts.admin')
@section('title', 'Admin: Cities')
@section('head')
    @include('layouts.partials.headersection',['title'=>'Cities'])
@endsection
@section('content')
<div class="row">
    <div class="col-12 mt-2">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-8"> <a href="{{ route('admin.cities.index') }}" class="mr-2 btn btn-outline-primary @if($status===" all ") active @endif">{{ __('All') }} ({{ $all }})</a>
                        <a href="{{ route('admin.cities.index','status=1') }}" class="mr-2 btn btn-outline-success @if($status==1) active @endif">{{ __('Active') }} ({{ $actives }})</a>
                        <a href="{{ route('admin.cities.index','status=0') }}" class="mr-2 btn btn-outline-warning @if($status==0) active @endif">{{ __('Inactive') }} ({{ $inactives }})</a>
                    </div>
                    <div class="col-sm-4 text-right">
                        <a href="{{ route('admin.cities.create') }}" class="btn btn-primary">{{ __('Create City') }}</a>
                    </div>
                </div>
                <div class="float-right">
                    <form>
                        <div class="input-group mb-2">
                            <input type="text" id="src" class="form-control" placeholder="Search..." required="" name="src" autocomplete="off" value="{{ $request->src ?? '' }}">
                            <select class="form-control selectric" name="term" id="term">
                                <option value="state">{{ __('Search By State Name') }}</option>
                                <option value="name">{{ __('Search By Name') }}</option>
                                <option value="lat">{{ __('Search By Latitude') }}</option>
                                <option value="lng">{{ __('Search By Longitude') }}</option>
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <form method="post" action="{{ route('admin.cities.destroys') }}" class="basicform_with_reload">
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
                        <table class="table table-striped table-hover text-center table-borderless">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" class="checkAll">
                                    </th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('State') }}</th>
                                    <th>{{ __('Latitude') }}</th>
                                    <th>{{ __('Longitude') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cities as $row)
                                <tr id="row{{ $row->id }}">
                                    <td>
                                        <input type="checkbox" name="ids[]" value="{{ $row->id }}">
                                    </td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->state->name }}</td>
                                    <td>@if(empty($row->lat)){{ __('---') }}@else{{ $row->lat }}@endif</td>
                                    <td>@if(empty($row->lng)){{ __('---') }}@else{{ $row->lng }}@endif</td>
                                    <td>
                                        @if($row->status==1) <span class="badge badge-success">{{ __('Active') }}</span>
                                        @elseif($row->status==0) <span class="badge badge-danger">{{ __('Inactive') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-primary has-icon" onclick="window.location.href = '{{ route('admin.cities.edit',$row->id) }}'" type="button"> <i class="fas fa-edit"></i> {{ __('Edit') }}</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>
                                    <input type="checkbox" class="checkAll">
                                </th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('State') }}</th>
                                <th>{{ __('Latitude') }}</th>
                                <th>{{ __('Longitude') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </form>
            {{ $cities->appends($request->all())->links('vendor.pagination.bootstrap-4') }}</div>
        </div>
    </div>
</div>
@endsection
@section('end_body')
    <script src="{{ asset('assets/js/form.js') }}"></script>
    <script>
        function success(res){
            setTimeout(function(){
                window.location.href = '{{ route('admin.cities.index') }}';
            }, 2000);
        }
        function error(res){
            console.log(res);
        }
    </script>
@endsection