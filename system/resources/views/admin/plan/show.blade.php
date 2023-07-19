@extends('layouts.admin')
@section('title', 'Admin: Plans')
@section('head')
    @include('layouts.partials.headersection', ['title' => 'Plan Details'])
@endsection
@section('content')

    <section class="section">
        <div class="section-body">
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card profile-widget">
                        <div class="profile-widget-header">
                            <div class="profile-widget-items">
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Plan Name :') }}</div>
                                    <div class="profile-widget-item-value">{{ $posts->name }}</div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Discount') }}</div>
                                    <div class="profile-widget-item-value">{{ $posts->discount }}</div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Status') }}</div>
                                    <div class="profile-widget-item-value">
                                        @if ($posts->status == 1)
                                            <span class="badge badge-success">{{ __('Active') }}</span>
                                        @elseif($posts->status == 0)
                                            <span class="badge badge-danger">{{ __('Inactive') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="profile-widget-header">
                            <div class="profile-widget-items">
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Months:') }}</div>
                                    <div class="profile-widget-item-value">{{ $posts->months }}</div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Days:') }}</div>
                                    <div class="profile-widget-item-value">{{ $posts->days }}</div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Slug:') }}</div>
                                    <div class="profile-widget-item-value">{{ $posts->slug }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="profile-widget-header">
                            <div class="profile-widget-items">

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Ordering:') }}</div>
                                    <div class="profile-widget-item-value">{{ $posts->ordering }}</div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Default:') }}</div>
                                    <div class="profile-widget-item-value">{{ $posts->is_default }}</div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label"></div>
                                    <div class="profile-widget-item-value"></div>
                                </div>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>

    </section>

    <div class="row">
        <div class="col-12 mt-2">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">

                        @if (count($customers) >= 1)
                            <table class="table table-striped table-hover text-center table-borderless">
                                <thead>
                                    <tr>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Email') }}</th>
                                        <th>{{ __('Domain') }}</th>
                                        <th>{{ __('Plan') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Order at') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $row)
                                        <tr id="row{{ $row->id }}">

                                            <td>{{ $row->name }}</td>
                                            <td><a href="mailto:{{ $row->email }}">{{ $row->email }}</a></td>
                                            <td><a href="{{ $row->user_domain->full_domain ?? '' }}"
                                                    target="_blank">{{ $row->user_domain->domain ?? '' }}</a></td>

                                            <td>{{ $row->user_plan->plan_info->name ?? '' }}</td>
                                            <td>
                                                @if ($row->status == 1)
                                                    <span class="badge badge-success">{{ __('Active') }}</span>
                                                @elseif($row->status == 0)
                                                    <span class="badge badge-danger">{{ __('Trash') }}</span>
                                                @elseif($row->status == 2)
                                                    <span class="badge badge-warning">{{ __('Suspended') }}</span>
                                                @elseif($row->status == 3)
                                                    <span class="badge badge-warning">{{ __('Pending') }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $row->user_plan->created_at->format('d-F-Y') }}</td>
                                            <td>
                                                <div class="dropdown d-inline">
                                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                                        id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu">

                                                        <a class="dropdown-item has-icon"
                                                            href="{{ route('admin.customer.edit', $row->id) }}"><i
                                                                class="far fa-edit"></i> Edit</a>

                                                        <a class="dropdown-item has-icon"
                                                            href="{{ route('admin.customer.show', $row->id) }}"><i
                                                                class="far fa-eye"></i>View</a>


                                                        <a class="dropdown-item has-icon"
                                                            href="{{ route('admin.order.create', 'email=' . $row->email) }}"><i
                                                                class="fas fa-cart-arrow-down"></i>Make Order</a>

                                                        <a class="dropdown-item has-icon"
                                                            href="{{ route('admin.customer.show', $row->id) }}"><i
                                                                class="far fa-envelope"></i>Send Email</a>
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

                    {{ $customers->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('end_body')
    <script src="{{ asset('assets/js/form.js') }}"></script>
@endsection
