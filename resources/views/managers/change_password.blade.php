@extends('layouts.manager')

@section('title', ' Change Password')

@section('content')
	<div class="main-content">
		<section class="section">
			<div class="main-content">
				<div class="container mt-2">
					<div class="row">
						<div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
							<div class="card card-primary">
								<div class="card-header">
									<h4>{{ __('Change Password') }}</h4>
								</div>
								<div class="card-body">
									<form id="changePassword" method="POST" action="{{ route('manager.change.password') }}">
										@csrf
										<div class="form-group">
											<label for="old_password" class="d-block">{{ __('Old Password') }}</label>
											<input type="password"
												class="form-control pwstrength @error('old_password') is-invalid @enderror"
												data-indicator="pwindicator" name="old_password" autocomplete="">
											@error('old_password')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
											<div id="pwindicator" class="pwindicator">
												<div class="bar"></div>
												<div class="label"></div>
											</div>
										</div>
										<div class="form-group">
											<label>New Password</label>
											<input type="password" name="password" id="cpassword"
												class="form-control @error('password') is-invalid @enderror" value="">
											@error('password')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>
										<div class="form-group">
											<label>Confirm Password</label>
											<input type="password" name="confirm_password"
												class="form-control @error('confirm_password') is-invalid @enderror"
												value="">
											@error('confirm_password')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-primary btn-lg btn-block">
												Change Password
											</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
@endsection
@push('scripts')
    @includeFirst(['validation.js_change_password'])
@endpush
