@extends('layouts.business')
@section('title', 'Offers: Business Panel')
@section('end_head')
	<style>
		label span{color:red;}
		.card-statistic-1{cursor:pointer;}
		.redeem-offer-header{display:block !important;}
		.redeem-offer-header h4{text-align:center;}
	</style>
@endsection
@section('head') @include('layouts.partials.headersection',['title'=>'Offers']) @endsection
@section('content')
	<section class="section">
		<div class="row">
			<div class="col-lg-3 col-md-6 col-sm-6 col-12">
				<div class="card card-statistic-1 card-primary" onclick="window.location.href='{{ route('business.future.index') }}'">
					<div class="card-icon bg-primary">
						<i class="fas fa-tags"></i>
					</div>
					<div class="card-wrap">
						<div class="card-header">
							<h4>Future Offers</h4>
						</div>
						<div class="card-body">
							16
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 col-sm-6 col-12">
				<div class="card card-statistic-1 card-danger" onclick="window.location.href='{{ route('business.instant.index') }}'">
					<div class="card-icon bg-danger">
						<i class="fas fa-tags"></i>
					</div>
					<div class="card-wrap">
						<div class="card-header">
							<h4>Instant Offers</h4>
						</div>
						<div class="card-body">
							0
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 col-sm-6 col-12">
				<div class="card card-statistic-1 card-warning">
					<div class="card-icon bg-warning">
						<i class="fas fa-users"></i>
					</div>
					<div class="card-wrap">
						<div class="card-header">
							<h4>Customers Subscribe</h4>
						</div>
						<div class="card-body">
							13
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 col-sm-6 col-12">
				<div class="card card-statistic-1 card-success">
					<div class="card-icon bg-success">
						<i class="fas fa-gift"></i>
					</div>
					<div class="card-wrap">
						<div class="card-header">
							<h4>Offers Redeem</h4>
						</div>
						<div class="card-body">
							0
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 col-sm-6 col-12">
				<div class="card card-statistic-1 card-primary">
					<div class="card-icon bg-primary">
						<i class="fas fa-money-check-alt"></i>
					</div>
					<div class="card-wrap">
						<div class="card-header">
							<h4>Total Amount</h4>
						</div>
						<div class="card-body">
							$21,045.79
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 col-sm-6 col-12">
				<div class="card card-statistic-1 card-danger">
					<div class="card-icon bg-danger">
						<i class="fas fa-money-bill"></i>
					</div>
					<div class="card-wrap">
						<div class="card-header">
							<h4>Canceled Amount</h4>
						</div>
						<div class="card-body">
							$0.00
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 col-sm-6 col-12">
				<div class="card card-statistic-1 card-warning">
					<div class="card-icon bg-warning">
						<i class="fas fa-money-bill"></i>
					</div>
					<div class="card-wrap">
						<div class="card-header">
							<h4>Pending Amount</h4>
						</div>
						<div class="card-body">
							$15,263.29
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 col-sm-6 col-12">
				<div class="card card-statistic-1 card-success">
					<div class="card-icon bg-success">
						<i class="fas fa-money-bill"></i>
					</div>
					<div class="card-wrap">
						<div class="card-header">
							<h4>Earnings Amount</h4>
						</div>
						<div class="card-body">
							$607.50
						</div>
					</div>
				</div>
			</div>
			{{-- <div class="col-sm-12">
				<div class="card card-primary">
					<div class="card-header">
						<h4>Offers</h4>
						<form class="card-header-form">
							<div class="d-flex">
								<input type="text" name="start" class="form-control datepicker" value="">
								<input type="text" name="end" class="form-control datepicker" value="">
								<button class="btn btn-primary btn-icon" type="submit"><i class="fas fa-search"></i></button>
							</div>
						</form>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-striped table-md table-hover">
								<tbody>
									<tr>
										<th class="text-left">Invoice No</th>
										<th>Date</th>
										<th>Customer</th>
										<th class="text-right">Order total</th>
										<th>Payment</th>
										<th>Fulfillment</th>
										<th class="text-right">Item(s)</th>
										<th class="text-right">Invoice</th>
									</tr>
									<tr>
										<td>
											<a href="https://saka-cart.amwork.xyz/seller/orders/invoice/106">SAKA105</a>
										</td>
										<td>
											<a href="https://saka-cart.amwork.xyz/seller/order/106">18-September-2021</a>
										</td>
										<td>
											<a href="https://saka-cart.amwork.xyz/seller/customer/4"></a>
										</td>
										<td class="text-right">$607.50</td>
										<td>
											<span class="badge badge-warning">Pending</span>
										</td>
										<td>
											<span class="badge badge-warning">Awaiting processing</span>
										</td>
										<td class="text-right"> 1</td>
										<td class="text-right">
											<a href="https://saka-cart.amwork.xyz/seller/order/106" class="btn btn-primary btn-sm">
												<i class="fa fa-eye"></i>
											</a>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div> --}}

			<div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
				{{-- <div class="login-brand">
				Stisla
				</div> --}}

				<div class="card card-primary">
					<div class="card-header redeem-offer-header">
						<h4>Enter Coupon Code To Redeem The Offer.</h4>
					</div>

					<div class="card-body">
						<form method="POST">
							<div class="form-group">
								<div class="input-group">
									<div class="input-group-prepend">
										<div class="input-group-text">
											<i class="fas fa-gift"></i>					
										</div>
									</div>
									<input id="couponCode" type="text" class="form-control" name="couponCode" autofocus="" placeholder="Type Coupon Code">
								</div>
							</div>

							<div class="form-group text-center">
								<button type="submit" class="btn btn-lg btn-round btn-primary">
									Redeem Code
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection