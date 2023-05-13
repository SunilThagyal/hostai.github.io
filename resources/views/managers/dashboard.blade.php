@extends('layouts.manager')

@section('title', 'Dashboard')

@section('content')

	<div class="main-content">
        <section class="section">
			<x-alert/>
          	<div class="row">
                @if ($authUser->status != 'Active')
					<div class="col-12">
						<div class="card card-primary">
							<div class="card-header">
								<h4>Account Status </h4>
							</div>
							<div class="card-body" style="text-align:center">
								<h4>Your Account has been suspended.</h4>
								<p class="text-muted">For further help contact us </p>
								<a href="mailto:{{ env ('ADMIN_CONTACT_ADDRESS') }}" class="btn btn-primary mr-1">Contact us</a>
							</div>
						</div>
					</div>
				@else

                	<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="card">
							<div class="card-statistic-4">
								<div class="align-items-center justify-content-between">
									<div class="row ">
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
											<div class="card-content">
												<h5 class="font-15">Subcontractors</h5>
												<h2 class="mb-3 font-18"> {{ $contractors}} </h2>
											</div>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
											<div class="banner-img">
												<img src="{{ asset('assets/img/banner/2.png') }}" alt="">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="card">
							<div class="card-statistic-4">
								<div class="align-items-center justify-content-between">
									<div class="row ">
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
											<div class="card-content">
												<h5 class="font-15">Workers</h5>
												<h2 class="mb-3 font-18"> {{ $workers }} </h2>
											</div>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
											<div class="banner-img">
												<img src="{{ asset('assets/img/banner/3.png')}}" alt="">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				@endif
			</div>
		</section>
	</div>
@endsection
