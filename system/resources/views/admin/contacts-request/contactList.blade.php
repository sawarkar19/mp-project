@extends('layouts.admin')

@section('head')
    @include('layouts.partials.headersection', ['title' => 'Contacts Request'])
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
         
            <div class="col-12 col-md-12 col-lg-12 col-xl-12">

                <div class="card mb-0 h-100">
                    <div class="card-header">
                        <h4>List Of Contacts Request</h4>

                        <a href="{{route('admin.exportContacts')}}" class="export btn btn-success btn-lg px-4 mx-1">Export Contacts</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-sm-4 col-12"></div>
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
                            @if (count($allContacts) >= 1)
                                <table class="table table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>SR. NO.</th>
                                            <th>USER NAME</th>
                                            <th>NUMBER</th>
                                            <th>EMAIL</th>
                                            <th>Message</th>
                                            <th>Date</th>
                                            <th>STATUS</th>
                                        <tr>
                                    </thead>
                                    <tbody>
                                        <?php $count = 1; ?>
                                        @foreach ($allContacts as $allContact)
                                            <tr id="row{{ $allContact->id }}">
                                                <td>{{ $allContacts->perPage() * ($allContacts->currentPage() - 1) + $count }}</td>
                                                <td>{{ $allContact->name }}</td>
                                                <td>{{ $allContact->mobile }}</td>
                                                <td>{{ $allContact->email }}</td>
                                                <td>{{ $allContact->message }}</td>
                                                <td>{{ \Carbon\Carbon::parse($allContact->created_at)->format('d M Y') }}</td>
                                                <td>
                                                    @if ($allContact->status == 1)
                                                        <div class="badge badge-success">
                                                            Active
                                                        </div>
                                                    @elseif ($allContact->status == 0)
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
                            <div class="card-body text-center">
                                <h3>{{ Config::get('constants.no_record_found') }}</h3>
                            </div>
                            @endif
                        </div>
                        <div class="card-footer text-center">
                            {{ $allContacts->links('vendor.pagination.bootstrap-4') }}
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
