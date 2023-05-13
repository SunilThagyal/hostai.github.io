@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="main-content">
	<section class="section">
		<div class="row ">
			@if($authUser->role == "admin" && $authUser->status != 'Inactive' )
				<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="card">
						<x-alert />
						<div class="card-statistic-4">
							<div class="align-items-center justify-content-between">
								<div class="row ">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
										<div class="card-content">
											<h5 class="font-15">Main Contractors</h5>
											<h2 class="mb-3 font-18"> {{ $architects }} </h2>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
										<div class="banner-img">
											<img src="{{ asset('assets/img/banner/1.png') }}" alt="">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			@endif

			@if ($authUser->role == 'project-manager' && $authUser->status != 'Active')
				<div class="col-12">
					<div class="card card-primary">
						<x-alert />
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
			@endif

			@if($authUser->role != 'subcontractor' && $authUser->status != 'Inactive')
				<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="card">
						<x-alert />
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
											<h2 class="mb-3 font-18"> {{$workers}} </h2>
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

			@if(isset($ContractorVerification))
				@if($ContractorVerification->document_status != 'submitted' && $ContractorVerification->document_status != 'rejected' )
					@if( ($authUser->role == 'subcontractor') && ($ContractorVerification->is_approved == 1) && ($authUser->status == 'Active') )
						<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="card">
								<x-alert />
								<div class="card-statistic-4">
									<div class="align-items-center justify-content-between">
										<div class="row ">
											<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
												<div class="card-content">
													<h5 class="font-15">Workers</h5>
													<h2 class="mb-3 font-18"> {{$workers}} </h2>
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

					@if (($authUser->role == 'subcontractor') && $ContractorVerification->is_approved == 0)
						<div class="col-12">
							<div class="card">
								@if($documents->count() < 12)
									<x-alert />
									<div class="card-header">
										<h4>Upload documents for your Account Verification</h4>
									</div>
									<div class="card-body">
										<form id="filesVerification" action="{{ route('subcontractor.documents.upload',[$authUser->slug]) }}" enctype="multipart/form-data" method="post">
											@csrf
											<label>Documents</label>
											<table id="addMoreCertifacte" class="table table-striped table-md">
												<tr>
													<td>Files</td>
												</tr>
												<tr>
													<td>
														<div>
															<input type="hidden" id="max_count" value="{{old('max_count', 0)}}" name="max_count">
															<input type="text" placeholder="Document Name" name="document_name[0]" value="{{ old('document_name.0' )}}" class="form-control  document-name @error('document_name.*')is-invalid   @enderror">
															@error('document_name.0')
															<span>
																{{$message}}
															</span>
															@enderror
														</div>
													</td>
													<td>
														<div>
															<input type="file" name="certificate[0]" value="{{ old('certificate.0')}}" class="form-control contractor-documents @error('certificate.*') is-invalid   @enderror">
															@error('certificate.0')
															<span>
																{{$message}}
															</span>
															@enderror
														</div>
													</td>
                                                    <td>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <i class="fas fa-calendar"></i>
                                                                </div>
                                                            </div>
                                                            <input type="text" name="admin_dates[0]" class="form-control admin-daterange-cus" placeholder="Select Expiry Date" value="{{ old('admin_dates.0')}}">
                                                        </div>
                                                    </td>
													<td>
														<button class="btn btn-primary" type="button" id="addMore">Add</button>
													</td>
												</tr>
												@for($i = 1; $i <= old('max_count', 0); $i++)
													<tr>
														<td>
															<div>
																<input type="text" placeholder="Document Name" value="{{ old('document_name.' . $i )}}" name='document_name[]' class="form-control document-name @error('document_name.'.$i)is-invalid   @enderror">
																@error('document_name.'.$i)
																<span>
																	{{$message}}
																</span>
																@enderror
															</div>
														</td>
														<td>
															<div>
																<input type="file" name="certificate[]" value="{{ old('certificate.' . $i )}}" class="form-control contractor-documents @error('certificate.'.$i) is-invalid   @enderror">
																@error('certificate.'.$i)
																<span>
																	{{$message}}
																</span>
																@enderror
															</div>
														</td>
                                                        <td>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">
                                                                        <i class="fas fa-calendar"></i>
                                                                    </div>
                                                                </div>
                                                                <input type="text" name="admin_dates[]" class="form-control admin-daterange-cus" placeholder="Select Expiry Date" value="{{ old('admin_dates.' . $i)}}">
                                                            </div>
                                                        </td>
														<td>
															<button type="button" class="btn btn-danger remove">Remove</button>
														</td>
													</tr>
												@endfor
											</table>
											@error('certificate')
											<span class="invalid-feedback">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
											<div class="card-footer text-right">
												<button class="btn btn-primary mr-1" name="draft" name="draft" type="submit">Add to draft</button>
												<button class="btn btn-primary mr-1" name="submit" value="submit" type="submit">Submit</button>
											</div>
										</form>
									</div>
								@else
                                <x-alert/>
									<div class="card-body">
										<h4>You have reach the maximum uploaded limit.</h4>
									</div>
								@endif
							</div>
						</div>

						<div class="col-12">
							<div class="card">
								<div class="card-header">
									<h4>Uploaded documents </h4>
								</div>
								<div class="card-body">
									@if (!is_null($documents))
									<table class="table table-striped table-md">
										<tr>
											<th>Sr no.</th>
											<th>Document Name</th>
											<th>File</th>
											<th> Action </th>
										</tr>
										@php $sr_number = 1; @endphp
										@foreach($documents as $document)
										<tr>
											<td>
												{{ $sr_number }}
											</td>
											<td>
												{{$document->document_name}}
											</td>
											<td>
												<a data-toggle="modal" data-target=".bd-example-modal-lg" onclick="sendData('{{ $document->uploaded_file_url}}')" href="#"> {{$document->uploaded_file_name}} </a>
											</td>
											<td>
												<button data-toggle="modal" data-target=".bd-example-modal-lg" onclick="sendData('{{ $document->uploaded_file_url}}')" class="btn btn-primary">View</button>
												<a href="{{ route('subcontractor.document.delete',[$document->id]) }}" class="btn btn-danger delete">Delete</a>
											</td>
										</tr>

										@php  $sr_number++; @endphp
										@endforeach
									</table>
									<div class="card-footer text-right">
										@if($document_count != 0)
										<a href="{{ route('subcontractor.document.submit',[$document->user_id]) }}"> <input class="btn btn-primary mr-1" type="button" value="Submit for Verification" @if($document_count==0) {{'disabled=disabled'}} @else {{'enable'}} @endif> </a>
										@endif
									</div>
									@endif
								</div>
							</div>
						</div>
					@endif
				@endif
				@if (($ContractorVerification->is_approved == 1) && ($authUser->status != 'Active'))
				<div class="col-12">
					<div class="card card-primary">
						<div class="card-header">
							<h4>Account Status </h4>
						</div>
						<div class="card-body" style="text-align:center">
							<h4>your Account is inactive </h4>
							<p class="text-muted">For further help contact us </p>
							<a href="mailto:admin@gmail.com" class="btn btn-primary mr-1">Contact us</a>
						</div>
					</div>
				</div>
				@endif

				@if ($ContractorVerification->document_status == 'submitted')
				<div class="col-12">
					<div class="card card-primary">
						<div class="card-header">
							<h4>Account Status </h4>
						</div>
						<div class="card-body" style="text-align:center">
							<p class="lead text-success">Your Documents uploaded Successfully</p>
							<h4>your Account is under Review </h4>
							<p class="text-muted">If it is taking longer then expected you can contact us </p>
							<a href="mailto:admin@gmail.com" class="btn btn-primary mr-1">Contact us</a>
						</div>
					</div>
				</div>
				@endif

				@if ($ContractorVerification->document_status == 'rejected')
					<div class="col-12">
						<div class="card card-danger">
							<div class="card-header">
								<h4>Account Status </h4>
							</div>
							<div class="card-body" style="text-align:center">
								<h4 class="text-danger"> Your Account is Rejected </h4>
								<p class="text-muted">Check the reason of rejection and upload valid Documents again</p>
							</div>
						</div>
					</div>

					<div class="col-12">
						<div class="card">
							<div class="card-header">
								<h4>Check Uploaded Documents </h4>
							</div>
							<div class="card-body" style="text-align:center">
								<table class="table table-striped table-md">
									<tr>
										<th>Document Name</th>
										<th>File</th>
										<th>Comment</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
									<tbody>
										@foreach($documents as $docs)
										<tr>
											<td> {{ $docs->document_name }}</td>
											<td>
												<a href="{{ asset('storage/' . $docs->uploaded_file_url) }}"> {{ Str::limit($docs->uploaded_file_name, 20) }} </a>
											</td>
											<td style="width: 200px;word-wrap: break-word;">
												{{ !is_null($docs->RejectedDocument) ? $docs->RejectedDocument->comments: '/' }}
											</td>
											<td>
												@if ($docs->status == 'REJECTED')
												<i title="Rejected" class="fas fa-times-circle" style="color:red;font-size:20px;"></i>
												@elseif ($docs->status == 'PENDING')
												<i title="Pending" class="fa fa-clock" style="color:rgb(0, 140, 255);font-size:20px;"></i>
												@elseif ($docs->status == 'APPROVED')
												<i title="Accepted" class="fas fa-check-circle" style="color:rgb(0, 255, 81);font-size:20px;"></i>
												@endif
											</td>
											<td>
												<button data-toggle="modal" data-target=".bd-example-modal-lg" onclick="sendData('{{ $docs->uploaded_file_url}}')" class="btn btn-primary">View</button>
												@if($docs->status == 'REJECTED')
												<button id='triggerfile' onclick="$(this).closest('td').find('input').click()" class="btn btn-info"> Re-upload</button>

												<form action="{{route('subcontractor.document.reupload',[$docs->id])}}" method="post" class="filesVerification" enctype="multipart/form-data">
													@csrf
													<input class="reupload-certificate form-control" name="certificate" type='file' value="Re-upload" onchange="$(this).closest('form').submit()" hidden>
                                                    @error('certificate','document_'.$docs->id)
                                                    <span>
                                                        {{$message}}
                                                    </span>
                                                    @enderror
												</form>
												@endif
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				@endif
			@endif
		</div>
	</section>
</div>

<!-- Model section -->
@section('modal')
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="myLargeModalLabel">Document</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<iframe id="recivedData" width="100%" height="500px" style="border:none"></iframe>
			</div>
		</div>
	</div>
</div>
@endsection

@endsection
@push('scripts')
<script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
<script>
	function sendData(url) {
		document.getElementById("recivedData").src = APP_URL + '/storage/' + url;
	};

	jQuery(document).ready(function() {
		jQuery('input[name="dates"]').daterangepicker({
			locale: {
				format: 'YYYY-MM-DD',
				autoApply: true,
				cancelLabel: 'Clear',
			}
		});
		jQuery('input[name="dates"]').val('');
		jQuery('input[name="dates"]').attr("placeholder", "Select Dates");
		jQuery('input[name="dates"]').on('apply.daterangepicker', function(ev, picker) {
			jQuery('#search').submit();
		});
        //for docs dates
        jQuery('input.admin-daterange-cus').daterangepicker({
                autoUpdateInput: false,
                singleDatePicker: true,
                locale: {
                    cancelLabel: 'Clear',
                    format: 'YYYY-MM-DD'
                }
            });

            jQuery('input.admin-daterange-cus').on('apply.daterangepicker', function(ev, picker) {
                jQuery(this).val(picker.startDate.format('YYYY-MM-DD'));
            });



        //

		var i = 0;

		var max_document = {{ config('constants.contractor_document_limit') }}

		jQuery("#addMore").click(function() {
			if (i + {{ isset($document_count) ? $document_count : 0 }} == max_document) {
				return swal({
					text: 'you can only upload only 12  documents',
					icon: 'warning',
					dangerMode: true,
				});
			}
			++i;
			jQuery("#max_count").val(i);
			var html = '<tr><td><div><input type="text" placeholder="Document Name" name="document_name[' + i + ']"   class="form-control document-name "></div></td><td><div><input type="file" name="certificate[' + i + ']"  class="form-control contractor-documents "></div></td><td><div class="input-group"><div class="input-group-prepend"><div class="input-group-text"><i class="fas fa-calendar"></i></div></div><input type="text" id="AdminDates'+i+'" name="admin_dates[' + i + ']" class="form-control admin-daterange-cus" placeholder="Select Expiry Date"></div></td><td><button type="button" class="btn btn-danger remove">Remove</button></td></tr>';

			jQuery("#addMoreCertifacte").append(html);
             var dates2 = '#AdminDates'+i
                jQuery(dates2).daterangepicker({
                    autoUpdateInput: false,
                    singleDatePicker: true,
                    minDate: moment(),
                    locale: {
                        cancelLabel: 'Clear',
                        format: 'YYYY-MM-DD'
                    }
                });

                jQuery(dates2).on('apply.daterangepicker', function(ev, picker) {
                    jQuery(this).val(picker.startDate.format('YYYY-MM-DD'));
                });
		});

		jQuery(document).on('click', '.remove', function() {
			--i;
			jQuery(this).closest("tr").remove();
		});
	})

	// jQuery(window).on('load',function() {
	// 	var test = jQuery("#max_count").val();
	// 		for (var i=1; i<test; ++i ){
	// 			var document= '("document_name.'+i+'")';
	// 			console.log(document)
	// 			var someVariable = "-123456";
	// 			someVariable.replace('-', '');
	// 			console.log(someVariable)
	// 			var testt = 'error'+document+'<span>'+'$message'+'</span>'+'enderror';

	// 			console.log(testt);
	// 			var html = '<tr><td><div><input type="text" placeholder="Document Name" name="document_name['+i+']"  class="form-control  @error("document_name.*") is-invalid   @enderror">error("document_name.'+i+'")<span>$message</span>enderror</div></td><td><div><input type="file" name="certificate['+i+']"  accept="application/pdf" class="form-control  @error("certificate") is-invalid   @enderror">@error("certificate\.'+i+'")<span>{{$message}}</span>@enderror</div></td><td><button type="button" class="btn btn-danger remove">Remove</button></td></tr>';
	// 		console.log(html);
	// 		jQuery("#addMoreCertifacte").append(html);

	// 		}
	// 	});
	var perfEntries = performance.getEntriesByType("navigation");

	if (perfEntries[0].type === "back_forward") {
		location.reload(true);
	}
</script>
@includeFirst(['validation.js_contractor_document'])

@endpush
