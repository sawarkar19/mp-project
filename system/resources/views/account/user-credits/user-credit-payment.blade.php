@extends('layouts.account')

@section('head')
    @include('layouts.partials.headersection', ['title' => 'Free User Payments'])
@endsection

@section('end_head')
    <style>
        .card.card-hero .userBg1 {
            background: #D3FFDB !important;
            border: none;
        }

        .card.card-hero .userBg2 {
            background: #fdf4c4 !important;
            border: none;
        }

        .card.card-hero .userBg3 {
            background: #E5E5FF !important;
            border: none;
        }

        .card.card-hero .userBg4 {
            background: #FFF6F4 !important;
            border: none;
        }

        .card.card-hero .userBg1.card-header h4,
        .card.card-hero .userBg2.card-header h4,
        .card.card-hero .userBg3.card-header h4 {
            font-size: 35px !important;
        }

        .card.card-hero .userBg1 h4,
        .card.card-hero .userBg2 h4,
        .card.card-hero .userBg3 h4,
        .card.card-hero .userBg4 h4,
        .card.card-hero .card-description {
            color: #34395e;
        }

        .card.card-hero .userBg1 .card-icon {
            color: #b7edc0;
        }

        .card.card-hero .userBg2 .card-icon {
            color: #fff1a8;
        }

        .card.card-hero .userBg3 .card-icon {
            color: #d0d0ef;
        }

        .card.card-hero .userBg4 .card-icon {
            color: #ffe2df;
        }

        .userChartHead {
            position: absolute;
            left: 50%;
            transform: translate(-50%, 0);
            font-size: 80px;
            bottom: 0;
        }
    </style>
@endsection

@section('content')
    <section class="section">

        <div class="section-body">
            <h2 class="section-title">Total Users</h2>

            {{--  <div class="row">
                <!-- <div class="col-12 col-md-8">
                                                    <div class="card p-5">
                                                        <div style="max-width:720px;">
                                                            <canvas id="totalUserChart" ></canvas>
                                                        </div>
                                                    </div>
                                                </div> -->
                <div class="col-12 col-md-3">
                    <div class="card card-hero">
                        <div class="card-header userBg1">
                            <div class="card-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <h4>{{ $activeUser }}</h4>
                            <div class="card-description">Active Users</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="card card-hero">
                        <div class="card-header userBg2">
                            <div class="card-icon">
                                <i class="fas fa-users-slash"></i>
                            </div>
                            <h4>{{ $inactiveUser }}</h4>
                            <div class="card-description">Inactive Users</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="card card-hero">
                        <div class="card-header userBg3">
                            <div class="card-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <h4>{{ count($paidUser) }}</h4>
                            <div class="card-description">Paid Users</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="card card-hero">
                        <div class="card-header userBg4">
                            <div class="card-icon">
                                <i class="fas fa-users-slash"></i>
                            </div>
                            <h4>{{ count($unPaidUser) }}</h4>
                            <div class="card-description">Unpaid Users</div>
                        </div>
                    </div>
                </div>
            </div>  --}}
            <div class="col-12 col-md-12 col-lg-12 col-xl-12">

                <div class="card mb-0 h-100">
                    <div class="card-header">
                        <h4>List Of Users</h4>

                    </div>
                    <div class="card-body p-0">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-sm-4 col-12">
                                <form>
                                    <div class="input-group mb-2">
                                        <select class="form-control selectric" name="no_of_users" id="no_of_users">
                                            <option value="10" @if ($request->no_of_users == '10') selected @endif>
                                                {{ __('10') }}</option>
                                            <option value="25" @if ($request->no_of_users == '25') selected @endif>
                                                {{ __('25') }}</option>
                                            <option value="50" @if ($request->no_of_users == '50') selected @endif>
                                                {{ __('50') }}</option>
                                            <option value="100" @if ($request->no_of_users == '100') selected @endif>
                                                {{ __('100') }}</option>
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit"><i
                                                    class="fas fa-search"></i></button>
                                        </div>
                                    </div>

                                </form>

                            </div>

                            <div class="col-sm-6 col-12">
                                <form>
                                    <div class="input-group mb-2">

                                        <input type="text" id="src" class="form-control" placeholder="Search..."
                                            name="src" autocomplete="off" value="{{ $request->src ?? '' }}">
                                        <select class="form-control selectric" name="term" id="term">
                                            <option value="name" @if ($request->name == 'name') selected @endif>
                                                {{ __('Search By Name') }}</option>
                                            <option value="mobile" @if ($request->term == 'mobile') selected @endif>
                                                {{ __('Search By Number') }}</option>
                                            <option value="email" @if ($request->term == 'email') selected @endif>
                                                {{ __('Search By Mail') }}</option>

                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit"><i
                                                    class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="table-responsive">
                            @if (count($freeUsers) >= 1)
                                <table class="table table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>SR. NO.</th>
                                            <th>USER NAME</th>
                                            <th>NUMBER</th>
                                            <th>EMAIL</th>
                                            <th>JOIN</th>
                                            <th>STATUS</th>
                                            <th>ACTION</th>
                                        <tr>
                                    </thead>
                                    <tbody>
                                        <?php $count = 1; ?>
                                        @foreach ($freeUsers as $free)
                                            @if (isset($free))
                                                <tr id="row{{ $free->id }}">
                                                    <td>{{ $freeUsers->perPage() * ($freeUsers->currentPage() - 1) + $count }}
                                                    </td>
                                                    <td>{{ $free->name ?? 'Customer Name' }}</td>
                                                    <td>{{ $free->mobile ?? '1234567890' }}</td>
                                                    <td>{{ $free->email ?? 'xyz@gmail.com' }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($free->created_at)->format('d M Y') }}
                                                    </td>
                                                    <td>
                                                        @if ($free->status == 1)
                                                            <div class="badge badge-success">
                                                                Active
                                                            </div>
                                                        @elseif ($free->status == 0)
                                                            <div class="badge badge-danger">
                                                                Inactive
                                                            </div>
                                                        @endif
                                                    </td>

                                                    <td><a class="btn btn-sm btn-primary px-3"
                                                            href="{{ route('account.creditPayment', $free->id) }}">Credit
                                                            Payment</a></td>
                                                </tr>
                                                <?php $count++; ?>
                                            @endif
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
                            {{ $freeUsers->appends(array_except(Request::query(), $request->no_of_users))->links() }}
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@push('js')
    <!-- <script src="{{ asset('assets/js/chart.min.js') }}"></script>

                                        <script>
                                            var data = {
                                                labels: [
                                                    "Free Users",
                                                    "Paid Users"
                                                ],
                                                datasets: [{
                                                    data: [300, 100],
                                                    backgroundColor: [
                                                        "#FF6384",
                                                        "#FFCE56"
                                                    ],
                                                    hoverBackgroundColor: [
                                                        "#FF6384",
                                                        "#FFCE56"
                                                    ]

                                                }]
                                            };

                                            var ctx = document.getElementById("totalUserChart");

                                            // And for a doughnut chart
                                            var myDoughnutChart = new Chart(ctx, {
                                                type: 'doughnut',
                                                data: data,
                                                options: {
                                                    legend: {
                                                        position: 'bottom',
                                                    },
                                                    cutoutPercentage: 85,
                                                    rotation: 1 * Math.PI,
                                                    circumference: 1 * Math.PI,

                                                }
                                            });
                                        </script> -->
@endpush
@section('end_body')
@endsection
