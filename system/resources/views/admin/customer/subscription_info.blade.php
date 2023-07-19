@extends('layouts.admin')
@section('title', 'Admin: Plan Info')
@section('head')
    @include('layouts.partials.headersection', ['title' => 'Subscription Plan Info'])
@endsection
@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-11">
                    <div class="card profile-widget">
                        <div class="profile-widget-description">
                            <div class="profile-widget-name">
                                <h4>Channel Details</h4>
                            </div>
                            @if (count($channel) >= 1)

                                <table class="table table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Expiry Date</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <span style="display:none;">@php $n = 1 @endphp</span>
                                        @foreach ($channel as $app)
                                            <tr>
                                                <th scope="row">{{ $n }}</th>
                                                <td>{{ $app->channel->name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($app->will_expire_on)->toFormattedDateString() }}
                                                </td>
                                                <td>
                                                    <div class="profile-widget-item-value">
                                                        @empty($app)
                                                            <span class="badge badge-success">{{ __('active') }}</span>
                                                        @else
                                                            @if ($app->status == 1)
                                                                <span class="badge badge-success">{{ __('Active') }}</span>
                                                            @elseif($app->status == 0)
                                                                <span class="badge badge-danger">{{ __('Expired') }}</span>
                                                            @endif
                                                        @endempty

                                                    </div>
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

                <div class="col-12 col-md-12 col-lg-11">
                    <div class="card profile-widget">
                        <div class="profile-widget-description">
                            <div class="profile-widget-name">
                                <h4>User Details</h4>
                            </div>

                            @if (count($useremployee) >= 1)

                                <table class="table table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Expiry Date</th>
                                            <th scope="col">Type ( Free / Paid )</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <span style="display:none;">@php $m = 1 @endphp</span>
                                        @foreach ($useremployee as $employee)
                                            <tr>
                                                <th scope="row">{{ $m }}</th>
                                                <td>{{ $employee->employee->name ?? 'user' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($employee->will_expire_on)->toFormattedDateString() }}
                                                </td>
                                                <td>
                                                    <div class="profile-widget-item-value">
                                                        @empty($employee)
                                                            <span class="badge badge-success">{{ __('Free') }}</span>
                                                        @else
                                                            @if ($employee->is_free == 1)
                                                                <span class="badge badge-success">{{ __('Free') }}</span>
                                                            @elseif($employee->is_free == 0)
                                                                <span class="badge badge-danger">{{ __('Paid') }}</span>
                                                            @endif
                                                        @endempty
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="profile-widget-item-value">
                                                        @empty($employee)
                                                            <span class="badge badge-success">{{ __('active') }}</span>
                                                        @else
                                                            @if ($employee->status == 1)
                                                                <span class="badge badge-success">{{ __('Active') }}</span>
                                                            @elseif($employee->status == 0)
                                                                <span class="badge badge-danger">{{ __('Expired') }}</span>
                                                            @endif
                                                        @endempty

                                                    </div>
                                                </td>
                                            </tr>
                                            @php $m=$m+1; @endphp
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

                <div class="col-12 col-md-12 col-lg-11">
                    <div class="card profile-widget">
                        <div class="profile-widget-description">
                            <div class="profile-widget-name">
                                <h4>Message Details</h4>
                            </div>
                            @if(count($message) >= 1)
                            <table class="table table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Total Messages</th>
                                        <th scope="col">Expiry Date</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <span style="display:none;">@php $a = 1 @endphp</span>
                                    @foreach ($message as $msg)
                                        <tr>
                                            <th scope="row">{{ $a }}</th>
                                            <td>{{ $msg->total_messages }}</td>
                                            <td>{{ \Carbon\Carbon::parse($msg->will_expire_on)->toFormattedDateString() }}
                                            </td>
                                            <td>
                                                <div class="profile-widget-item-value">
                                                    @empty($msg)
                                                        <span class="badge badge-success">{{ __('active') }}</span>
                                                    @else
                                                        @if ($msg->users->status == 1)
                                                            <span class="badge badge-success">{{ __('Active') }}</span>
                                                        @elseif($msg->users->status == 0)
                                                            <span class="badge badge-danger">{{ __('Expired') }}</span>
                                                        @endif
                                                    @endempty

                                                </div>
                                            </td>
                                        </tr>
                                        @php $a=$a+1; @endphp
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
    </section>
@endsection
