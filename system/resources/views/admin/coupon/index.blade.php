@extends('layouts.admin')
@section('title', 'Admin: Coupons')
@section('head')
    @include('layouts.partials.headersection', ['title' => 'Coupons'])
@endsection
@section('content')


    <div class="row">
        <div class="col-12 mt-2">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <form>
                                <div class="input-group mb-2">
                                    <select class="form-control selectric" name="no_of_page" id="no_of_page">
                                        <option value="10" @if ($request->no_of_page == '10') selected @endif>
                                            {{ __('10') }}</option>
                                        <option value="25" @if ($request->no_of_page == '25') selected @endif>
                                            {{ __('25') }}</option>
                                        <option value="50" @if ($request->no_of_page == '50') selected @endif>
                                            {{ __('50') }}</option>
                                        <option value="100" @if ($request->no_of_page == '100') selected @endif>
                                            {{ __('100') }}</option>
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit"><i
                                                class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-7">
                            <form>
                                <div class="input-group mb-2">
                                    <input type="text" id="src" class="form-control" placeholder="Search..."
                                        name="src" autocomplete="off" value="{{ $request->src ?? '' }}">
                                    <select class="form-control selectric" name="term" id="term">
                                        <option value="name" @if ($request->name == 'name') selected @endif>
                                            {{ __('Search By Coupon Name') }}</option>
                                        <option value="code" @if ($request->term == 'code') selected @endif>
                                            {{ __('Search By Coupon Code') }}</option>
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                    <form method="post" action="{{ route('admin.coupons.destroys') }}" id="actionForm">
                        @csrf
                        <div class="float-left mb-1">
                            <div class="input-group">
                                <select class="form-control" name="type">
                                    <option selected="" disabled="">{{ __('Select Action') }}</option>
                                    <option value="delete">{{ __('Delete Permanently') }}</option>
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-primary basicbtn" type="submit">{{ __('Submit') }}</button>
                                </div>
                            </div>
                        </div>
                        <div class="float-right">
                            <a href="{{ route('admin.coupon.create') }}"
                                class="btn btn-primary">{{ __('Create Coupon') }}</a>
                        </div>

                        <div class="table-responsive">
                            @if (count($allCoupons) >= 1)
                                <table class="table table-striped table-hover text-center table-borderless">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" class="checkAll"></th>
                                            <th>{{ __('Coupon Name') }}</th>
                                            <th>{{ __('Coupon Code ') }}</th>
                                            <th>{{ __('Is Deafult') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Action') }}</th>
                                            {{-- <th>{{ __('Archive Coupons') }}</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allCoupons as $row)
                                            <tr id="row{{ $row->id }}">
                                                <td><input type="checkbox" name="ids[]" value="{{ $row->id }}"></td>
                                                <!-- <td><input type="hidden" name="id" id="rowId" value=""></td> -->
                                                <td>{{ $row->name }}</td>
                                                <td>{{ $row->code }}</td>
                                                <td>
                                                    @if ($row->is_default == 1)
                                                        <span class="badge badge-success  badge-sm">Yes</span>
                                                    @else
                                                        <span class="badge badge-danger  badge-sm">No</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($row->status == 1)
                                                        <span class="badge badge-success  badge-sm">Active</span>
                                                    @else
                                                        <span class="badge badge-danger  badge-sm">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.coupon.edit', $row->id) }}"
                                                        class="btn btn-primary btn-sm text-center"><i
                                                            class="far fa-edit"></i></a>

                                                    <a href="{{ route('admin.coupon.show', $row->id) }}"
                                                        class="btn btn-success btn-sm text-center"><i
                                                            class="far fa-eye"></i></a>

                                                    {{-- <!-- <td><a href="{{ route('admin.coupons.archive', $row->id) }}" class="btn btn-success btn-sm text-center">Archive Coupon</a></td> --> --}}
                                                    {{-- <td><button type="button"
                                                    class="btn btn-success btn-sm text-center archivedCoupon"
                                                    data-row="{{ $row->id }}">Archive</button></td>
                                            </td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="card-body">
                                    <h3>{{ Config::get('constants.no_record_found') }}</h3>
                                </div>
                            @endif

                            <div class="card-footer text-center">
                                {{ $allCoupons->appends(array_except(Request::query(), $request->no_of_page))->links() }}
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('end_body')
    {{--  <script src="{{ asset('assets/js/form.js') }}"></script>  --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $(".archivedCoupon").click(function(e) {

                var rowId = $(this).data('row');
                var route = '{!! route('admin.coupons.archive', '') !!}';
                var url = route + '/' + rowId;
                let _token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(response) {
                        if (response) {
                            // $('.success').text(response.success);
                            // $("#ajaxform")[0].reset();
                            alert("Coupon archive successfully.");
                            location.reload();
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>

    <script>
        $("#actionForm").on('submit', function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var basicbtnhtml = $('.basicbtn').html();
            $.ajax({
                type: 'POST',
                url: this.action,
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {

                    $('.basicbtn').html("Please Wait....");
                    $('.basicbtn').attr('disabled', '')

                },

                success: function(response) {
                    $('.basicbtn').removeAttr('disabled')

                    if (response.status == true) {
                        Sweet('success', response.message);
                    } else {
                        Sweet('error', response.message);
                    }

                    $('.basicbtn').html(basicbtnhtml);
                    location.reload();
                },
                error: function(xhr, status, error) {
                    $('.basicbtn').html(basicbtnhtml);
                    $('.basicbtn').removeAttr('disabled')
                    $('.errorarea').show();
                    $.each(xhr.responseJSON.errors, function(key, item) {
                        Sweet('error', item)
                        $("#errors").html("<li class='text-danger'>" + item + "</li>")
                    });
                    errosresponse(xhr, status, error);
                }
            })
        });
    </script>
@endsection
