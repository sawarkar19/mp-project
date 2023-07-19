@extends('layouts.account')
@section('title', 'Admin: User Details')
@section('head')
    @include('layouts.partials.headersection', ['title' => 'User Details'])
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
                                    <div class="profile-widget-item-label">{{ __('User Name :') }}</div>
                                    <div class="profile-widget-item-value">{{ $allUsers->name }}</div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Mobile :') }}</div>
                                    <div class="profile-widget-item-value">{{ $allUsers->mobile }}</div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Email :') }}</div>
                                    <div class="profile-widget-item-value">{{ $allUsers->email }}</div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Join :') }}</div>
                                    <div class="profile-widget-item-value">{{ $allUsers->created_at->format('d M Y') }}</div>
                                </div>

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{ __('Status :') }}</div>
                                    <div class="profile-widget-item-value">
                                        @if ($allUsers->status == 1)
                                            <span class="badge badge-success">{{ __('Active') }}</span>
                                        @elseif($allUsers->status == 0)
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
                        <div class="row">
                            <div class="col-12 col-md-3">
                                <div class="card card-hero">
                                    <div class="card-header userBg1">
                                        <div class="card-icon">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <h4>{{count($allUsers->getUniqueClicks)}}</h4>
                                        <div class="card-description">Unique Clicks</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="card card-hero">
                                    <div class="card-header userBg2">
                                        <div class="card-icon">
                                            <i class="fas fa-users-slash"></i>
                                        </div>
                                        <h4>{{count($allUsers->getUniqueClicks) + count($allUsers->getExtraClicks)}}</h4>
                                        <div class="card-description">Total Clicks</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="card card-hero">
                                    <div class="card-header userBg3">
                                        <div class="card-icon">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <h4>{{count($allUsers->getRedeemedCodeSent)}}</h4>
                                        <div class="card-description">Redeem Code Sent</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="card card-hero">
                                    <div class="card-header userBg3">
                                        <div class="card-icon">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <h4>{{count($allUsers->getRedeemedCustomers)}}</h4>
                                        <div class="card-description">Successfully Redeemed</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="card card-hero">
                                    <div class="card-header userBg4">
                                        <div class="card-icon">
                                            <i class="fas fa-users-slash"></i>
                                        </div>
                                        <h4>{{count($allUsers->getShareSubscriptions)}}</h4>
                                        <div class="card-description">Subscribed Challanges</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="card card-hero">
                                    <div class="card-header userBg4">
                                        <div class="card-icon">
                                            <i class="fas fa-users-slash"></i>
                                        </div>
                                        <h4>{{count($allUsers->getCompletedTasks)}}</h4>
                                        <div class="card-description">Completed Tasks</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="card card-hero">
                                    <div class="card-header userBg4">
                                        <div class="card-icon">
                                            <i class="fas fa-users-slash"></i>
                                        </div>
                                        <h4>{{$instantTasks}}</h4>
                                        <div class="card-description">Instant Challanges</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="report_sticky_top sticky-top mt-5_" id="">
                        <div class="report_tabs rounded">
                            <div class="report_tabs-inner">
                                <div class="container-fluid">
                                    <div class="flex-nav justify-content-md-between">
        
                                        <div class="scroll-btns">
                                            <a href="#deduction_list"
                                                class="scrolly btn btn-sm  btn-primary py-1 px-3 h-auto">Deduction List</a>
                                            <a href="#offer_list"
                                                class="scrolly btn btn-sm btn-success py-1 mx-sm-1 px-3 h-auto">Offer List</a>
                                            <a href="#social_post_list"
                                                class="scrolly btn btn-sm  py-1 btn-warning px-3 h-auto">Social Post List</a>
                                            <a href="#employee_list"
                                                class="scrolly btn btn-sm  py-1 btn-info px-3 h-auto">Employee List</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('layouts.partials.headersection', ['title' => 'Deduction List'])
                    <div class="card profile-widget" id="deduction_list">
                        <div class="table-responsive">
                            
                            @if (count($deductionHistory) >= 1)
                                <table class="table table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            {{-- <th>User Name</th> --}}
                                            <th>Name/Number</th>
                                            <th>Deduction Towards</th>
                                            <th>Deducted Amount</th>
                                            <th>Date</th>
                                        <tr>
                                    </thead>
                                    <tbody>
                                        <?php $count = 1; ?>
                                        @foreach ($deductionHistory as $key => $deductHistory)
                                        
                                            <tr id="row{{ $deductHistory->id }}">
                                                <td>{{ $deductionHistory->perPage() * ($deductionHistory->currentPage() - 1) + $count }}</td>
                                                {{-- <td>{{ $deductHistory->user->name }}</td> --}}
                                                <td>{{ @$deductHistory->businessCustomer->name ?? @$deductHistory->getEmployees->mobile }}</td>
                                                <td>        {{$deductHistory->deduction->name }}</td>
                                                <td><span class="badge badge-danger">{{$deductHistory->deduction_amount }}
                                                </td></span>
                                                <td>
                                                    {{\Carbon\Carbon::parse($deductHistory->created_at)->format('d M Y')}}
                                                </td>
                                            </tr>
                                            <?php $count++; ?>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="card-body">
                                    {{ Config::get('constants.no_record_found') }}</h3>
                                </div>
                            @endif
                        </div>
                        <div class="card-footer text-center">
                            {{ $deductionHistory->appends(array_except(Request::query(), 'deduction_page'))->links() }}
                        </div>
                    </div>
                    @include('layouts.partials.headersection', ['title' => 'Offer List'])
                    <div class="card profile-widget" id="offer_list">
                        <div class="table-responsive">
                            
                            @if (count($offers) >= 1)
                                <table class="table table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Offer Name</th>
                                            <th>End Date</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                        <tr>
                                    </thead>
                                    <tbody>
                                        <?php $count = 1; ?>
                                        @foreach ($offers as $offer)
                                            <tr id="row{{ $offer->id }}">
                                                
                                                <td>{{ $offers->perPage() * ($offers->currentPage() - 1) + $count }}</td>
                                                <td class="text-left">{{ $offer->title }}</td>
                                                <td>{{ \Carbon\Carbon::parse($offer->end_date)->format('d M Y') }}</td>
                                                <td><span class="badge badge-info">{{ $offer->type }}</span></td>
                                                <td>
                                                    @if ($offer->status == 1)
                                                        <div class="badge badge-success">
                                                            Active
                                                        </div>
                                                    @elseif ($offer->status == 0)
                                                        <div class="badge badge-danger">
                                                            Inactive
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                            <?php $count++; ?>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                            <div class="card-body">
                                <h3>{{ Config::get('constants.no_record_found') }}</h3>
                            </div>
                            @endif
                        </div>
                        <div class="card-footer text-center">
                            {{ $offers->appends(array_except(Request::query(), 'offer_page'))->links() }}
                        </div>
                    <div>
                    @include('layouts.partials.headersection', ['title' => 'Social Post List'])
                    <div class="card profile-widget" id="social_post_list">
                        <div class="table-responsive">
                            
                            @if (count($socilPosts) >= 1)
                                <table class="table table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Title</th>
                                            <th>Facebook Clicks</th>
                                            <th>Twitter Clicks</th>
                                            <th>Created Date</th>
                                        <tr>
                                    </thead>
                                    <tbody>
                                        <?php $count = 1; ?>
                                        
                                        @foreach ($socilPosts as $socilPost)
                                            <tr id="row{{ $socilPost->id }}">
                                                
                                                <td>{{ $socilPosts->perPage() * ($socilPosts->currentPage() - 1) + $count }}</td>
                                                <td class="text-left">{{ $socilPost->title }}</td>
                                                <td><span class="badge badge-info">{{ count($socilPost->getFacebookClicks) }}</span></td>
                                                <td><span class="badge badge-primary">{{ count($socilPost->getTwitterClicks)  }}</td>
                                                <td>
                                                    {{\Carbon\Carbon::parse($socilPost->created)->format('d M Y')}}
                                                </td>
                                            </tr>
                                            <?php $count++; ?>
                                        @endforeach
                                            
                                    </tbody>
                                </table>
                            @else
                            <div class="card-body">
                                <h3>{{ Config::get('constants.no_record_found') }}</h3>
                            </div>
                            @endif
                        </div>
                        <div class="card-footer text-center">
                            {{ $socilPosts->appends(array_except(Request::query(), 'social_post_page'))->links() }}
                        </div>
                    </div>
                    @include('layouts.partials.headersection', ['title' => 'Employee List'])
                    <div class="card profile-widget" id="employee_list">
                        <div class="table-responsive">
                            
                            @if (count($employees) >= 1)
                                <table class="table table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Employee Name</th>
                                            <th>Mobile</th>
                                            {{-- <th>Email</th>
                                            <th>Designation</th> --}}
                                            <th>Status</th>
                                        <tr>
                                    </thead>
                                    <tbody>
                                        <?php $count = 1; ?>
                                        
                                        @foreach ($employees as $employee)
                                            <tr id="row{{ $employee->id }}">
                                                
                                                <td>{{ $employees->perPage() * ($employees->currentPage() - 1) + $count }}</td>
                                                <td class="">{{ $employee->name }}</td>
                                                <td>{{ $employee->mobile ?? '-' }}</td>
                                                {{-- <td>{{ $employee->email ?? '-' }}</td>
                                                <td><span class="badge badge-info">{{ $employee->designation ?? "Employee" }}</span></td> --}}
                                                <td>
                                                    @if ($employee->status == 1)
                                                        <div class="badge badge-success">
                                                            Active
                                                        </div>
                                                    @elseif ($employee->status == 0)
                                                        <div class="badge badge-danger">
                                                            Inactive
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                            <?php $count++; ?>
                                        @endforeach
                                            
                                    </tbody>
                                </table>
                            @else
                            <div class="card-body">
                                <h3>{{ Config::get('constants.no_record_found') }}</h3>
                            </div>
                            @endif
                        </div>
                        <div class="card-footer text-center">
                            {{ $employees->appends(array_except(Request::query(), 'employee_page'))->links() }}
                        </div>
                    <div>
                </div>
            </div>
        </div>

    </section>
@endsection
@section('end_body')
    <script src="{{ asset('assets/js/form.js') }}"></script>
@endsection
