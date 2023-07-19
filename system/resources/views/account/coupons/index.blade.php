@extends('layouts.account')

@section('head') @include('layouts.partials.headersection',['title'=>'Coupons']) @endsection

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

        
        <!-- <h2 class="section-title">List Of Coupons</h2> -->
        
        {{-- WA CONNECTIN TAB  --}}
        
        <div class="col-12 col-md-12 col-lg-12 col-xl-12">

            <div class="card mb-0 h-100">
                <div class="card-header">
                    <h4>List Of Coupons</h4>

                </div>
                <div class="card-body p-0">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-sm-4 col-12">
                            <form>
                                <div class="input-group mb-2">
                                    <select class="form-control selectric" name="per_page" id="per_page">
                                        <option value="10" @if ($request->per_page == '10') selected @endif>
                                            {{ __('10') }}</option>
                                        <option value="25" @if ($request->per_page == '25') selected @endif>
                                            {{ __('25') }}</option>
                                        <option value="50" @if ($request->per_page == '50') selected @endif>
                                            {{ __('50') }}</option>
                                        <option value="100" @if ($request->per_page == '100') selected @endif>
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
                                        <option value="code" @if ($request->code == 'code') selected @endif>
                                            {{ __('Search By Coupon Code') }}</option>
                                        {{--  <option value="mobile" @if ($request->term == 'mobile') selected @endif>
                                            {{ __('Search By Number') }}</option>
                                        <option value="email" @if ($request->term == 'email') selected @endif>
                                            {{ __('Search By Mail') }}</option>  --}}

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
                        @if (count($allCoupons) >= 1)
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>SR. NO.</th>
                                        <th>COUPON CODE</th>
                                        <th>DETAILS</th>
                                        <th>DISCOUNT</th>
                                        <th>STATUS</th>
                                    <tr>
                                </thead>
                                <tbody>
                                    <?php $count = 1; ?>
                                    @foreach ($allCoupons as $allCoupon)
                                        <tr id="row{{ $allCoupon->id }}">
                                            <td>{{ $allCoupons->perPage() * ($allCoupons->currentPage() - 1) + $count }}</td>
                                            <td> <span class="badge badge-info">{{ $allCoupon->code }}</span></td>
                                            <td><a tabindex="0" class="btn btn-white" role="button" data-toggle="popover" data-trigger="focus" title="" data-content="{{ $allCoupon->description }}" data-original-title="{{ $allCoupon->name }}">{{ $allCoupon->name }}</a></td>
                                            <td>
                                                @if ($allCoupon->coupon_type == "percentage")
                                                {{ $allCoupon->discount.' %' }}
                                                @elseif($allCoupon->coupon_type == "flat_rate")
                                                {{ $allCoupon->discount. ' ₹'}}
                                                @endif
                                                </td>
                                            <td>
                                                @if ($allCoupon->status == 1)
                                                    <div class="badge badge-success">
                                                        Active
                                                    </div>
                                                @elseif ($allCoupon->status == 0)
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
                        {{ $allCoupons->appends(array_except(Request::query(), $request->per_page))->links(); }}
                    </div>

                </div>
            </div>
        </div>

        {{-- END WA CONNECTIN TAB  --}}
    </div>
</section>


@endsection

@push('js')
<script>
    $(function() {
        // popover
          $('[data-toggle="popover"]').popover({
            container: 'body'
          });
      });
</script>
<script src="{{ asset('assets/js/form.js') }}"></script>
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/input-validation.js') }}"></script>

@endpush
@section('end_body')
    
@endsection