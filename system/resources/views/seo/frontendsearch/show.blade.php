@extends('layouts.seo')
@section('title', 'SEO: Keyword Details')
@section('head')
    @include('layouts.partials.headersection', ['title' => 'Keyword Details'])
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
                                    <div class="profile-widget-item-label">{{ __('Keyword :') }}</div>
                                    <div class="profile-widget-item-value">{{ $FrontEndSearch->keyword }}</div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Path (URL) :') }}</div>
                                    <div class="profile-widget-item-value">{{ $FrontEndSearch->path }}</div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Name :') }}</div>
                                    <div class="profile-widget-item-value">{{ $FrontEndSearch->name }}</div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Description :') }}</div>
                                    <div class="profile-widget-item-value">{{ $FrontEndSearch->description }}</div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Status :') }}</div>
                                    <div class="profile-widget-item-value">
                                        @if ($FrontEndSearch->status == 1)
                                            <span class="badge badge-success">{{ __('Active') }}</span>
                                        @elseif($FrontEndSearch->status == 0)
                                            <span class="badge badge-danger">{{ __('Inactive') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{--  <div class="profile-widget-header">
                            <div class="profile-widget-items">
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Slug :') }}</div>
                                    <div class="profile-widget-item-value">{{ $plangroups->slug }}</div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Ordering :') }}</div>
                                    <div class="profile-widget-item-value">{{ $plangroups->ordering }}</div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label"></div>
                                    <div class="profile-widget-item-value"></div>
                                </div>
                            </div>
                        </div>  --}}
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
@section('end_body')
    <script src="{{ asset('assets/js/form.js') }}"></script>
@endsection
