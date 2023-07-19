@extends('layouts.admin')
@section('title', 'Admin: Subscribers')
@section('head') @include('layouts.partials.headersection', ['title' => 'Subscribers']) @endsection
@section('content')

    <div class="row">
        <div class="col-12 mt-2">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-8">
                            <a href="{{ route('admin.customer.index') }}"
                                class="mr-2 btn btn-outline-primary @if ($type === 'all') active @endif">{{ __('All') }}
                                ({{ $all }})</a>

                            {{-- <a href="{{ route('admin.customer.index','type=1') }}" class="mr-2 btn btn-outline-success @if ($type == 1) active @endif">{{ __('Published') }} ({{ $actives }})</a> --}}

                            <a href="{{ route('admin.customer.index', 'type=2') }}"
                                class="mr-2 btn btn-outline-warning @if ($type == 2) active @endif">{{ __('Suspened') }}
                                ({{ $suspened }})</a>

                            {{-- <a href="{{ route('admin.customer.index', 'type=0') }}"
                                class="mr-2 btn btn-outline-warning @if ($type == 0) active @endif">{{ __('Deleted') }}
                                ({{ $trash }})</a> --}}

                        </div>

                        {{-- <div class="col-sm-4 text-right">
                            <a href="{{ route('admin.customer.create') }}"
                                class="btn btn-primary">{{ __('Create Subscriber') }}</a>
                        </div> --}}
                    </div>

                    <div class="float-right">
                        <form>
                            <input type="hidden" name="type"
                                value="@if ($type === 0) trash @else {{ $type }} @endif">
                            <div class="input-group mb-2">

                                {{-- @php
                                    dd($request->name);
                                @endphp --}}
                                <input type="text" id="src" class="form-control" placeholder="Search..."
                                    name="src" autocomplete="off" value="{{ $request->src ?? '' }}">
                                <select class="form-control selectric" name="term" id="term">
                                    <option value="name" @if ($request->term == 'name') selected @endif>{{ __('Search By Name') }}</option>
                                    <option value="mobile" @if ($request->term == 'mobile') selected @endif>{{ __('Search By Mobile') }}</option>
                                    <option value="email" @if ($request->term == 'email') selected @endif>{{ __('Search By Mail') }}</option>
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- <form method="post" action="{{ route('admin.customers.destroys') }}" class="basicform_with_reload"> --}}
                        @csrf
                        {{-- <div class="float-left mb-1">
                            <div class="input-group">
                                <select class="form-control selectric" name="method">
                                    <option selected="" disabled="">{{ __('Select Action') }}</option>
                                    <option value="1" >{{ __('Move To Publish') }}</option>
                                    <option value="2">{{ __('Move To Suspend') }}</option>
                                    <option value="0">{{ __('Move To Trash') }}</option>
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-primary basicbtn" type="submit">{{ __('Submit') }}</button>
                                </div>
                            </div>
                        </div> --}}


                        <div class="table-responsive">
                            @if (count($customers) >= 1)
                                <table class="table table-striped table-hover text-left table-borderless">
                                    <thead>
                                        <tr>
                                            {{-- <th><input type="checkbox" class="checkAll"></th> --}}

                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Number') }}</th>
                                            <th>{{ __('Email') }}</th>
                                            <th>{{ __('Active Plan') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Join at') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $row)
                                            <tr id="row{{ $row->id }}">
                                                {{-- <td><input type="checkbox" name="ids[]" value="{{ $row->id }}"></td> --}}
                                                <td>{{ $row->name }}</td>
                                                <td>{{ $row->mobile }}</td>
                                                <td><a href="mailto:{{ $row->email }}">{{ $row->email }}</a></td>
                                                <td><b>{{ $row->user_plan->plan_info->name ?? 'Free Plan' }}</b></td>
                                                <td>
                                                    @if ($row->status == 1)
                                                        <span class="badge badge-success">{{ __('Active') }}</span>
                                                        {{-- @elseif($row->status == 0)
                                                        <span class="badge badge-danger">{{ __('Trash') }}</span> --}}
                                                    @elseif($row->status == 0)
                                                        <span class="badge badge-warning">{{ __('Deactive') }}</span>
                                                    @elseif($row->status == 2)
                                                        <span class="badge badge-danger">{{ __('Suspended') }}</span>
                                                        {{-- @elseif($row->status==3) <span class="badge badge-success">{{ __('Active') }}</span> --}}
                                                    @endif
                                                </td>
                                                <td>{{ $row->created_at->format('d M Y') }}</td>
                                                <td>
                                                    <div class="dropdown d-inline">
                                                        <button class="btn btn-primary dropdown-toggle" type="button"
                                                            id="dropdownMenuButton2" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            {{ __('Action') }}
                                                        </button>
                                                        <div class="dropdown-menu">


                                                            <a class="dropdown-item has-icon"
                                                                href="{{ route('admin.customer.show', $row->id) }}"><i
                                                                    class="far fa-eye"></i>{{ __('View') }}
                                                            </a>

                                                            @if($row->status == 1 || $row->status == 0)
                                                                <a class="dropdown-item has-icon suspendCustomer"
                                                                href="javascript:void()" id="{{ $row->id }}"><i
                                                                    class="fas fa-trash-alt mr-2"></i> {{ __('Suspend') }}
                                                                </a>
                                                            @endif

                                                            {{-- <a class="dropdown-item has-icon"
                                                                href="{{ route('admin.customer.managePayments',$row->id) }}"><i
                                                                    class="fas fa-cart-arrow-down"></i>{{ __('Manage Payments') }}
                                                            </a> --}}

                                                            {{-- <a class="dropdown-item has-icon" href="{{ route('admin.customer.show',$row->id) }}"><i class="far fa-envelope"></i>{{ __('Send Email') }}</a> --}}
                                                        </div>
                                                    </div>

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
                    {{-- </form> --}}
                    {{ $customers->appends($request->all())->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('end_body')
    <script>
        $(".basicform_with_reload").on('submit', function(e) {
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

        $(".suspendCustomer").on('click', function() {
            $("#overlay").fadeIn(300);
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var user_id = $(this).attr('id');

            $.ajax({
                type: 'POST',
                url: '{{ route('admin.suspendCustomer') }}',
                data: { user_id: user_id },
                dataType: 'json',
                success: function(response) {
                    $("#overlay").fadeOut(300);

                    if (response.status == true) {
                        Sweet('success', 'User status updated successfully.');
                    } else {
                        Sweet('error', 'User status update failed.');
                    }

                    setTimeout(function(){
                        location.reload();
                    },1200);
                    
                },
                error: function(xhr, status, error) {
                    $("#overlay").fadeOut(300);
                    Sweet("error", "Something went wrong");
                }
            })


        });

        function success(res) {
            setTimeout(function() {
                window.location.href = '{{ route('admin.customer.index') }}';
            }, 2000);
        }

        function error(res) {
            console.log(res);
        }
    </script>
@endsection
