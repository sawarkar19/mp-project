@extends('layouts.admin')
@section('title', 'Admin: Plan Info')
@section('head')
    @include('layouts.partials.headersection', ['title' => 'User Management'])
@endsection
@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-11">
                    <div class="card profile-widget">
                        <div class="profile-widget-description">
                            <div class="row mb-2">
                                <div class="col-sm-8">
                                    <a href="{{ route('admin.customer.userInfo',['id' => $id]) }}"
                                        class="mr-2 btn btn-outline-primary @if ($type === 'all') active @endif">{{ __('All') }}
                                        ({{ $all }})</a>
                                    <a href="{{ route('admin.customer.userInfo',['id' => $id,'type'=>'2']) }}"
                                        class="mr-2 btn btn-outline-warning @if ($type == 2) active @endif">{{ __('Suspened') }}
                                        ({{ $suspened }})</a>
                                </div>
                            </div>
                            <div class="float-right">
                                <form>
                                    <input type="hidden" name="type"
                                        value="@if ($type === 0) trash @else {{ $type }} @endif">
                                    <div class="input-group mb-2">
                                        <input type="text" id="src" class="form-control" placeholder="Search..."
                                            name="src" autocomplete="off" value="{{ $request->src ?? '' }}">
                                        <select class="form-control selectric" name="term" id="term">
                                            <option value="name" @if ($request->term == 'name') selected @endif>{{ __('Search By Name') }}</option>
                                            <option value="mobile" @if ($request->term == 'mobile') selected @endif>{{ __('Search By Mobile') }}</option>
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                                @if (count($users) >= 1)

                                    <table class="table table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Number') }}</th>
                                                <th>{{ __('Status') }}</th>
                                                <th>{{ __('Join at') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <span style="display:none;">@php $n = 1 @endphp</span>
                                            @foreach ($users as $user)
                                                <tr>
                                                    <th scope="row">{{ $n }}</th>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->mobile }}</td>
                                                    <td>
                                                        @if ($user->status == 1)
                                                            <span class="badge badge-success">{{ __('Active') }}</span>
                                                        @elseif($user->status == 0)
                                                            <span class="badge badge-warning">{{ __('Deactive') }}</span>
                                                        @elseif($user->status == 2)
                                                            <span class="badge badge-danger">{{ __('Suspended') }}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $user->created_at->format('d M Y') }}</td>
                                                    <td>
                                                        @if($user->status == 1 || $user->status == 0)
                                                        <div class="dropdown d-inline">
                                                            <button class="btn btn-primary dropdown-toggle" type="button"
                                                                id="dropdownMenuButton2" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                                {{ __('Action') }}
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                @if($user->status == 1 || $user->status == 0)
                                                                    <a class="dropdown-item has-icon suspendUser"
                                                                    href="javascript:void()" id="{{ $user->id }}"><i
                                                                        class="fas fa-trash-alt mr-2"></i> {{ __('Suspend') }}
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        @else
                                                        {{ 'N.A.' }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                @php $n=$n+1; @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                <div class="card-body">
                                    <h3>{{ Config::get('constants.no_record_found') }}</h3>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('end_body')
    <script>
        $(".suspendUser").on('click', function() {
            $("#overlay").fadeIn(300);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var user_id = $(this).attr('id');  
             
            $.ajax({
                type: 'POST',
                url: '{{ route('admin.suspendUser') }}',
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

        })
    </script>
@endsection
