@extends('layouts.admin')
@section('title', 'Admin: Channel')
@section('head')
    @include('layouts.partials.headersection', ['title' => 'Channel Details'])
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
                                    <div class="profile-widget-item-label">{{ __('Channel Name :') }}</div>
                                    <div class="profile-widget-item-value">{{ $channels->name }}</div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Price') }}</div>
                                    <div class="profile-widget-item-value">{{ $channels->price }}</div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Status') }}</div>
                                    <div class="profile-widget-item-value">
                                        @if ($channels->status == 1)
                                            <span class="badge badge-success">{{ __('Active') }}</span>
                                        @elseif($channels->status == 0)
                                            <span class="badge badge-danger">{{ __('Inactive') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="profile-widget-header">
                            <div class="profile-widget-items">
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Slug:') }}</div>
                                    <div class="profile-widget-item-value">{{ $channels->slug }}</div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Short Description:') }}</div>
                                    <div class="profile-widget-item-value">{{ $channels->short_description }}</div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Description:') }}</div>
                                    <div class="profile-widget-item-value">{{ $channels->description }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="profile-widget-header">
                            <div class="profile-widget-items">
                                
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Icon:') }}</div>
                                    <div class="profile-widget-item-value">{{ $channels->icon }}</div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Font Icon:') }}</div>
                                    <div class="profile-widget-item-value">{{ $channels->font_icon }}</div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Route:') }}</div>
                                    <div class="profile-widget-item-value">{{ $channels->route }}</div>
                                </div>

                            </div>
                        </div>

                        <div class="profile-widget-header">
                            <div class="profile-widget-items">
                                

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Free Employee:') }}</div>
                                    <div class="profile-widget-item-value">{{ $channels->free_employee }}</div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Ordering:') }}</div>
                                    <div class="profile-widget-item-value">{{ $channels->ordering }}</div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Use Message:') }}</div>
                                    <div class="profile-widget-item-value">{{ $channels->is_use_msg }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
@section('end_body')
    <script src="{{ asset('assets/js/form.js') }}"></script>
@endsection
